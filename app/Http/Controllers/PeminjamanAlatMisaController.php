<?php

namespace App\Http\Controllers;

use App\Models\Alat_Misa;
use App\Models\KeranjangAlatMisa;
use App\Models\PeminjamanAlatMisa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Peminjam;
use App\Mail\MailPeminjamanAlatMisaStatus;
use Illuminate\Support\Facades\Mail;

class PeminjamanAlatMisaController extends Controller
{
    public function tambahKeKeranjangAlatMisa(Request $request)
    {
        $request->validate([
            'id_alatmisa' => 'required|exists:alat_misa,id',
            'jumlah' => [
                'required',
                'integer',
                'min:1',
            ],
            'tanggal_peminjaman' => 'required|date|after_or_equal:today',
            'tanggal_pengembalian' => 'required|date|after:tanggal_peminjaman',
        ], [
            'tanggal_peminjaman.required' => 'Tanggal peminjaman harus diisi.',
            'tanggal_peminjaman.date' => 'Tanggal peminjaman harus berupa format tanggal yang valid.',
            'tanggal_peminjaman.after_or_equal' => 'Tanggal peminjaman Tidak dapat dilakukan Sebelum Hari ini!',
            'tanggal_pengembalian.required' => 'Tanggal pengembalian harus diisi.',
            'tanggal_pengembalian.date' => 'Tanggal pengembalian harus berupa format tanggal yang valid.',
            'tanggal_pengembalian.after' => 'Tanggal Pengembalian Harus Setelah Tanggal Peminjaman.',
        ]);

        // Ambil data asset dari database
        $alatMisa = Alat_Misa::find($request->id_alatmisa);

        if (!$alatMisa) {
            return redirect()->back()->withErrors(['id_alatmisa' => 'Alat misa tidak ditemukan.']);
        }

        // Hitung stok yang tersedia
        $stokTersedia = $alatMisa->jumlah - $alatMisa->jumlah_terpinjam;

        // Cek apakah jumlah yang diminta melebihi stok yang tersedia
        if ($request['jumlah'] > $stokTersedia) {
            return redirect()->back()->withErrors(['jumlah' => 'Stok tidak cukup untuk jumlah yang diminta.']);
        }

        // Tambahkan ke keranjang
        KeranjangAlatMisa::create([
            'id_peminjam' => auth()->guard('peminjam')->id(),
            'id_alatmisa' => $request->id_alatmisa,
            'jumlah' => $request->jumlah,
            'tanggal_peminjaman' => $request->tanggal_peminjaman,
            'tanggal_pengembalian' => $request->tanggal_pengembalian,
        ]);

        return redirect()->back()->with('success', 'Alat Misa berhasil ditambahkan ke keranjang, Silahkan Checkout.');
    }

    // Fungsi untuk melihat isi keranjang
    public function lihatKeranjangAlatMisa()
    {
        $keranjangItems = KeranjangAlatMisa::where('id_peminjam', auth()->guard('peminjam')->id())->with('alatmisa')->get();

        return view('layout.PeminjamView.LihatKeranjangAlatMisa', compact('keranjangItems'));
    }


    public function prosesCheckoutAlatMisa(Request $request)
    {
        // Validasi item yang dipilih untuk checkout
        $selectedItems = $request->input('selected_items', []);
        if (empty($selectedItems)) {
            return redirect()->back()->with('error', 'Pilih setidaknya satu item untuk checkout.');
        }

        $errors = [];

        // Proses checkout untuk setiap item yang dipilih
        foreach ($selectedItems as $itemId) {
            $item = KeranjangAlatMisa::find($itemId);

            // Validasi item dan relasi alatMisa
            if (!$item || !$item->alatMisa) {
                $errors[] = "Item dengan ID {$itemId} tidak ditemukan atau data alat misa tidak valid.";
                continue;
            }

            // Menghitung stok yang tersedia
            $stokTersedia = $item->alatMisa->jumlah - $item->alatMisa->jumlah_terpinjam;

            // Validasi stok cukup
            if ($item->jumlah > $stokTersedia) {
                $errors[] = "Stok untuk {$item->alatMisa->nama_alat} tidak mencukupi. Tersedia: {$stokTersedia}, Dibutuhkan: {$item->jumlah}.";
                continue;
            }

            // Jika stok cukup, simpan peminjaman dengan status menunggu persetujuan
            PeminjamanAlatMisa::create([
                'id_peminjam' => auth()->guard('peminjam')->id(),
                'id_alatmisa' => $item->id_alatmisa,
                'jumlah' => $item->jumlah,
                'tanggal_peminjaman' => $item->tanggal_peminjaman,
                'tanggal_pengembalian' => $item->tanggal_pengembalian,
                'status' => 'pending',
            ]);
        }

        // Jika ada error stok, kembali ke keranjang dengan pesan error
        if (!empty($errors)) {
            return redirect()->back()->withErrors($errors);
        }

        // Hapus item dari keranjang alat misa setelah checkout
        KeranjangAlatMisa::whereIn('id', $selectedItems)->delete();

        return redirect()->back()->with('success', 'Checkout berhasil! Menunggu persetujuan admin.');
    }

    public function setujuiPeminjaman($id)
    {
        $peminjaman = PeminjamanAlatMisa::findOrFail($id);
        $alatMisa = Alat_Misa::findOrFail($peminjaman->id_alatmisa);

        // Cek stok alat misa
        $stokTersedia = $alatMisa->jumlah_barang - $alatMisa->jumlah_terpinjam;

        if ($peminjaman->jumlah > $stokTersedia) {
            return redirect()->back()->withErrors(['jumlah' => 'Stok tidak cukup untuk memproses peminjaman.']);
        }

        // Update jumlah terpinjam
        $alatMisa->increment('jumlah_terpinjam', $peminjaman->jumlah);

        if (Auth::guard('admin')->check()) {
            $adminId = Auth::guard('admin')->user()->id;
            $peminjaman->update([
                'status_peminjaman' => 'disetujui',
                'id_admin' => $adminId,
            ]);
        } else {
            return redirect()->route('/login')->with('error', 'Admin belum login.');
        }

        // Kirim email ke peminjam
        $peminjam = Peminjam::findOrFail($peminjaman->id_peminjam);
        $alatMisaName = $alatMisa->nama_barang; // Nama alat misa
        Mail::to($peminjam->email)->send(new MailPeminjamanAlatMisaStatus(
            'disetujui', // Status peminjaman
            null, // Tidak ada alasan penolakan
            $peminjam->name,
            [
                [
                    'nama_barang' => $alatMisa->nama_barang,
                    'jumlah' => $peminjaman->jumlah,
                ]
            ]
        ));

        return redirect()->back()->with('success', 'Permintaan Peminjaman Alat Misa oleh ' . $peminjam->name . ' Berhasil disetujui.');
    }
    public function tampilPinjamAlatMisa()
    {
        // Ambil semua alat misa dengan kondisi baik
        $alat_misa = Alat_Misa::where('kondisi', 'baik')->get()
            ->map(function ($item) {
                // Hitung stok tersedia
                $item->stok_tersedia = $item->jumlah - $item->jumlah_terpinjam;
                return $item;
            });

        return view('layout.PeminjamView.PinjamAlatMisa', compact('alat_misa'));
    }
}
