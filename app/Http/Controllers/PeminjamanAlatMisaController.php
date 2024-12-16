<?php

namespace App\Http\Controllers;

use App\Models\Alat_Misa;
use App\Models\KeranjangAlatMisa;
use App\Models\PeminjamanAlatMisa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Peminjam;
use App\Mail\MailPeminjamanAlatMisaStatus;
use App\Models\PengembalianAlatMisa;
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

    public function tampilPinjamAlatMisa()
    {
        $alat_misa = Alat_Misa::where('kondisi', 'baik')->get()
            ->map(function ($item) {
                // Pastikan detail_alat berupa array
                if (is_string($item->detail_alat)) {
                    $decoded = json_decode($item->detail_alat, true);
                    $item->detail_alat = array_values($decoded ?? []);
                } elseif (is_array($item->detail_alat)) {
                    $item->detail_alat = array_values($item->detail_alat);
                } else {
                    $item->detail_alat = [];
                }

                // Tambahkan stok
                $item->stok_tersedia = $item->jumlah - $item->jumlah_terpinjam;
                return $item;
            });

        return view('layout.PeminjamView.PinjamAlatMisa', compact('alat_misa'));
    }


    public function setujuiPeminjamanAlatMisa($id)
    {
        $peminjaman = PeminjamanAlatMisa::findOrFail($id);
        $alatMisa = Alat_Misa::findOrFail($peminjaman->id_alatmisa); // Change to AlatMisa model

        // Cek stok barang
        $stokTersedia = $alatMisa->jumlah - $alatMisa->jumlah_terpinjam;

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
        $alatMisaName = $alatMisa->nama_alat; // Nama alat misa
        Mail::to($peminjam->email)->send(new MailPeminjamanAlatMisaStatus(
            'disetujui', // Status peminjaman
            null, // Tidak ada alasan penolakan
            $peminjam->name,
            [
                [
                    'nama_alat' => $alatMisa->nama_alat,
                    'jumlah' => $peminjaman->jumlah,
                ]
            ]
        ));

        return redirect()->back()->with('success', 'Permintaan Peminjaman Alat Misa oleh ' . $peminjam->name . ' Berhasil disetujui.');
    }
    public function tolakPeminjaman(Request $request, $id)
    {
        $request->validate([
            'alasan_penolakan' => 'required|string'
        ]);

        $peminjaman = PeminjamanAlatMisa::findOrFail($id);
        $alatmisa = Alat_Misa::findOrFail($peminjaman->id_alatmisa);

        if (Auth::guard('admin')->check()) {
            $adminId = Auth::guard('admin')->user()->id;
            $peminjaman->update([
                'status_peminjaman' => 'ditolak',
                'id_admin' => $adminId,
                'alasan_penolakan' => $request->alasan_penolakan
            ]);
        } else {
            return redirect()->route('/login')->with('error', 'Admin belum login.');
        }

        // Send the email after rejecting
        $peminjam = Peminjam::findOrFail($peminjaman->id_peminjam);
        Mail::to($peminjam->email)->send(new MailPeminjamanALatMisaStatus(
            'ditolak', // Status peminjaman
            $peminjaman->alasan_penolakan, // Kirimkan alasan penolakan yang sebenarnya
            $peminjam->name,
            [
                [
                    'nama_alat' => $alatmisa->nama_alat,
                    'jumlah' => $peminjaman->jumlah,
                    'alasan' => $peminjaman->alasan_penolakan,
                ]
            ]
        ));

        return redirect()->back()->with('success', 'Permintaan Peminjaman Alat Misa oleh ' . $peminjam->name . ' berhasil ditolak.');
    }
    public function batchAction(Request $request)
    {
        // Validate the input data
        $validated = $request->validate([
            'action' => 'required|in:approve,reject',
            'selected_requests' => 'required|array',
            'selected_requests.*' => 'exists:peminjaman_alat_misa,id', // Ensure valid loan IDs
        ], [
            'action.required' => 'Pilih tindakan yang ingin dilakukan.',
            'selected_requests.required' => 'Tidak ada permintaan yang dipilih.',
        ]);

        // Initialize arrays to store errors and borrower details
        $errors = [];
        $peminjamDetails = [];

        // Step 1: Check if any of the selected requests have insufficient stock
        foreach ($request->selected_requests as $requestId) {
            $peminjaman = PeminjamanAlatMisa::find($requestId);
            $alatMisa = Alat_Misa::find($peminjaman->id_alatmisa); // Change to AlatMisa model
            $peminjaman->id_admin = auth('admin')->user()->id;

            // Check stock availability
            $stokTersedia = $alatMisa->jumlah - $alatMisa->jumlah_terpinjam;

            if ($peminjaman->jumlah > $stokTersedia) {
                // If stock is insufficient, add to errors and break the loop
                $errors[] = "Stok tidak cukup untuk peminjaman {$peminjaman->jumlah} unit dari alat misa '{$alatMisa->nama_barang}'";
                break; // Exit the loop immediately, no need to process further
            }
        }

        // If there are any errors (insufficient stock), return them
        if (!empty($errors)) {
            return redirect()->back()->withErrors($errors);
        }

        // Step 2: Process each selected request (approval or rejection)
        foreach ($request->selected_requests as $requestId) {
            $peminjaman = PeminjamanAlatMisa::find($requestId);
            $alatMisa = Alat_Misa::find($peminjaman->id_alatmisa); // Change to AlatMisa model

            // Proceed with the approval/rejection logic
            if ($validated['action'] === 'approve') {
                $alatMisa->increment('jumlah_terpinjam', $peminjaman->jumlah);
                $peminjaman->update(['status_peminjaman' => 'disetujui']);
            } elseif ($validated['action'] === 'reject') {
                $peminjaman->update(['status_peminjaman' => 'ditolak', 'alasan_penolakan' => $request->alasan_penolakan]);
            }

            if (Auth::guard('admin')->check()) {
                $adminId = Auth::guard('admin')->user()->id;
                $peminjaman->update([
                    'id_admin' => $adminId,
                ]);
            } else {
                return redirect()->route('/login')->with('error', 'Admin belum login.');
            }

            // Group the request details by borrower
            $peminjam = $peminjaman->peminjam; // Get the borrower
            $peminjamDetails[$peminjam->id][] = [
                'nama_alat' => $alatMisa->nama_alat,
                'jumlah' => $peminjaman->jumlah,
            ];
        }

        // Step 3: Send individual emails to each borrower
        foreach ($peminjamDetails as $peminjamId => $assetDetailsForPeminjam) {
            $peminjam = Peminjam::find($peminjamId);
            $status = $validated['action'] === 'approve' ? 'disetujui' : 'ditolak';
            $alasanPenolakan = $validated['action'] === 'reject' ? $request->alasan_penolakan : null;

            // Send the email for this specific borrower
            Mail::to($peminjam->email)->send(new MailPeminjamanAlatMisaStatus(
                $status,
                $alasanPenolakan,
                $peminjam->name,
                $peminjamDetails[$peminjam->id]
            ));
        }

        $peminjamNames = PeminjamanAlatMisa::whereIn('id', $request->selected_requests)
            ->with('peminjam')
            ->get()
            ->map(function ($peminjaman) {
                return $peminjaman->peminjam->name;
            })
            ->unique()
            ->implode(', ');

        return redirect()->back()->with('success', 'Tindakan batch berhasil diproses untuk: ' . $peminjamNames);
    }
    public function lihatRiwayatPeminjamanAlatMisa()
    {
        // Ambil riwayat peminjaman untuk peminjam yang sedang login
        $riwayatPeminjaman = PeminjamanAlatMisa::where('id_peminjam', auth()->guard('peminjam')->id())
            ->with('alatmisa') // Mengambil informasi tentang asset yang dipinjam
            ->get();

        // Ambil riwayat pengembalian yang sesuai dengan riwayat peminjaman
        $riwayatPengembalian = PengembalianAlatMisa::whereIn('peminjaman_id', $riwayatPeminjaman->pluck('id')->toArray())
            ->whereNotNull('tanggal_pengembalian') // Memastikan hanya pengembalian yang sudah tercatat
            ->with('peminjaman') // Mengambil informasi peminjaman yang terkait
            ->get();

        // Filter riwayat peminjaman yang sudah selesai (telah dikembalikan dan disetujui)
        $riwayatSelesai = $riwayatPeminjaman->filter(function ($peminjaman) {
            return $peminjaman->pengembalian &&
                $peminjaman->pengembalian->status == 'approved' &&
                $peminjaman->status_peminjaman == 'disetujui';
        });

        // Mengirimkan data ke view
        return view('layout.PeminjamView.RiwayatPeminjamanAlatMisa', compact('riwayatPeminjaman', 'riwayatPengembalian', 'riwayatSelesai'));
    }
}
