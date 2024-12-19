<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Keranjang;
use App\Models\Peminjaman;
use App\Models\peminjam;
use App\Models\Assets;
use App\Mail\MailPeminjamanStatus;
use App\Models\Pengembalian;
use Illuminate\Support\Facades\Mail;
use League\CommonMark\Extension\CommonMark\Node\Inline\Strong;

class PeminjamanController extends Controller
{
    public function tambahKeKeranjang(Request $request)
    {
        $request->validate([
            'id_asset' => 'required|exists:assets,id',
            'jumlah' => [
                'required',
                'integer',
                'min:1',
                function ($attribute, $value, $fail) use ($request) {
                    $asset = Assets::find($request->id_asset);
                    $stokTersedia = $asset->jumlah_barang - $asset->jumlah_terpinjam;
                    if ($value > $stokTersedia) {
                        $fail('Jumlah yang diminta melebihi stok tersedia.');
                    }
                },
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
        $asset = Assets::find($request['id_asset']);

        // Hitung stok yang tersedia
        $stokTersedia = $asset->jumlah_barang - $asset->jumlah_terpinjam;

        // Cek apakah jumlah yang diminta melebihi stok yang tersedia
        if ($request['jumlah'] > $stokTersedia) {
            return redirect()->back()->withErrors(['jumlah' => 'Stok tidak cukup untuk jumlah yang diminta.']);
        }

        // Tambahkan ke keranjang
        Keranjang::create([
            'id_peminjam' => auth()->guard('peminjam')->id(),
            'id_asset' => $request->id_asset,
            'jumlah' => $request->jumlah,
            'tanggal_peminjaman' => $request->tanggal_peminjaman,
            'tanggal_pengembalian' => $request->tanggal_pengembalian,
        ]);

        return redirect()->back()->with('success', 'Asset berhasil ditambahkan ke keranjang.');
    }


    // Fungsi untuk melihat isi keranjang
    public function lihatKeranjang()
    {
        $keranjangItems = Keranjang::where('id_peminjam', auth()->guard('peminjam')->id())->with('asset')->get();

        return view('layout.PeminjamView.LihatKeranjang', compact('keranjangItems'));
    }
    public function prosesCheckout(Request $request)
    {
        // Validasi item yang dipilih untuk checkout
        $selectedItems = $request->input('selected_items', []);
        if (empty($selectedItems)) {
            return redirect()->back()->with('error', 'Pilih setidaknya satu item untuk checkout.');
        }

        $errors = [];

        // Proses checkout untuk setiap item yang dipilih
        foreach ($selectedItems as $itemId) {
            $item = Keranjang::find($itemId);

            // Menghitung stok yang tersedia
            $stokTersedia = $item->asset->jumlah_barang - $item->asset->jumlah_terpinjam;

            // Validasi stok cukup
            if ($item->jumlah > $stokTersedia) {
                $errors[] = "Stok untuk {$item->asset->nama_barang} tidak mencukupi. Tersedia: {$stokTersedia}, Dibutuhkan: {$item->jumlah}.";
                continue;
            }

            // Jika stok cukup, simpan peminjaman dengan status menunggu persetujuan
            Peminjaman::create([
                'id_peminjam' => auth()->guard('peminjam')->id(),
                'id_asset' => $item->id_asset,
                'jumlah' => $item->jumlah,
                'tanggal_peminjaman' => $item->tanggal_peminjaman,
                'tanggal_pengembalian' => $item->tanggal_pengembalian,
                'status' => 'pending', // Status menunggu persetujuan admin
            ]);
        }

        // Jika ada error stok, kembali ke keranjang dengan pesan error
        if (!empty($errors)) {
            return redirect()->back()->withErrors($errors);
        }

        // Hapus item dari keranjang setelah checkout
        Keranjang::whereIn('id', $selectedItems)->delete();

        return redirect()->route('riwayatPeminjaman')->with('success', 'Checkout berhasil! Menunggu persetujuan admin.');
    }

    public function setujuiPeminjaman($id)
    {
        $peminjaman = Peminjaman::findOrFail($id);
        $asset = Assets::findOrFail($peminjaman->id_asset);

        // Cek stok barang
        $stokTersedia = $asset->jumlah_barang - $asset->jumlah_terpinjam;

        if ($peminjaman->jumlah > $stokTersedia) {
            return redirect()->back()->withErrors(['jumlah' => 'Stok tidak cukup untuk memproses peminjaman.']);
        }

        // Update jumlah terpinjam
        $asset->increment('jumlah_terpinjam', $peminjaman->jumlah);
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
        $peminjam = peminjam::findOrFail($peminjaman->id_peminjam);
        $assetName = $asset->nama_barang; // Nama aset
        Mail::to($peminjam->email)->send(new MailPeminjamanStatus(
            'disetujui', // Status peminjaman
            null, // Tidak ada alasan penolakan
            $peminjam->name,
            [
                [
                    'nama_barang' => $asset->nama_barang,
                    'jumlah' => $peminjaman->jumlah,
                ]
            ]
        ));


        return redirect()->back()->with('success', 'Permintaan Peminjaman oleh ' . $peminjam->name . ' Berhasil disetujui.');
    }


    public function tolakPeminjaman(Request $request, $id)
    {
        $request->validate([
            'alasan_penolakan' => 'required|string'
        ]);

        $peminjaman = Peminjaman::findOrFail($id);
        $asset = Assets::findOrFail($peminjaman->id_asset);

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
        $peminjam = peminjam::findOrFail($peminjaman->id_peminjam);
        $assetName = $asset->nama_barang; // Asset name
        Mail::to($peminjam->email)->send(new MailPeminjamanStatus(
            'ditolak', // Status peminjaman
            $peminjaman->alasan_penolakan, // Kirimkan alasan penolakan yang sebenarnya
            $peminjam->name,
            [
                [
                    'nama_barang' => $asset->nama_barang,
                    'jumlah' => $peminjaman->jumlah,
                    'alasan' => $peminjaman->alasan_penolakan,
                ]
            ]
        ));

        return redirect()->back()->with('success', 'Permintaan Peminjaman oleh ' . $peminjam->name . ' berhasil ditolak.');
    }

    public function batchAction(Request $request)
    {
        // Validate the input data
        $validated = $request->validate([
            'action' => 'required|in:approve,reject',
            'selected_requests' => 'required|array',
            'selected_requests.*' => 'exists:peminjaman,id', // Ensure valid loan IDs
        ], [
            'action.required' => 'Pilih tindakan yang ingin dilakukan.',
            'selected_requests.required' => 'Tidak ada permintaan yang dipilih.',
        ]);

        // Initialize arrays to store errors and borrower details
        $errors = [];
        $peminjamDetails = [];

        // Step 1: Check if any of the selected requests have insufficient stock
        foreach ($request->selected_requests as $requestId) {
            $peminjaman = Peminjaman::find($requestId);
            $asset = Assets::find($peminjaman->id_asset);
            $peminjaman->id_admin = auth('admin')->user()->id;
            // Check stock availability
            $stokTersedia = $asset->jumlah_barang - $asset->jumlah_terpinjam;

            if ($peminjaman->jumlah > $stokTersedia) {
                // If stock is insufficient, add to errors and break the loop
                $errors[] = "Stok tidak cukup untuk peminjaman {$peminjaman->jumlah} unit dari asset '{$asset->nama_barang}'";
                break; // Exit the loop immediately, no need to process further
            }
        }

        // If there are any errors (insufficient stock), return them
        if (!empty($errors)) {
            return redirect()->back()->withErrors($errors);
        }

        // Step 2: Process each selected request (approval or rejection)
        foreach ($request->selected_requests as $requestId) {
            $peminjaman = Peminjaman::find($requestId);
            $asset = Assets::find($peminjaman->id_asset);

            // Proceed with the approval/rejection logic
            if ($validated['action'] === 'approve') {
                $asset->increment('jumlah_terpinjam', $peminjaman->jumlah);
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
                'nama_barang' => $asset->nama_barang,
                'jumlah' => $peminjaman->jumlah,
            ];
        }

        // Step 3: Send individual emails to each borrower
        foreach ($peminjamDetails as $peminjamId => $assetDetailsForPeminjam) {
            $peminjam = peminjam::find($peminjamId);
            $status = $validated['action'] === 'approve' ? 'disetujui' : 'ditolak';
            $alasanPenolakan = $validated['action'] === 'reject' ? $request->alasan_penolakan : null;

            // Send the email for this specific borrower
            Mail::to($peminjam->email)->send(new MailPeminjamanStatus(
                $status,
                $alasanPenolakan,
                $peminjam->name,
                $peminjamDetails[$peminjam->id]
            ));
        }
        $peminjamNames = Peminjaman::whereIn('id', $request->selected_requests)
            ->with('peminjam')
            ->get()
            ->map(function ($peminjaman) {
                return $peminjaman->peminjam->name;
            })
            ->unique()
            ->implode(', ');

        return redirect()->back()->with('success', 'Tindakan batch berhasil diproses untuk: ' . $peminjamNames);
    }



    public function lihatRiwayatPeminjaman()
    {
        // Ambil riwayat peminjaman untuk peminjam yang sedang login
        $riwayatPeminjaman = Peminjaman::where('id_peminjam', auth()->guard('peminjam')->id())
            ->with('asset') // Mengambil informasi tentang asset yang dipinjam
            ->get();

        $riwayatPengembalian = Pengembalian::whereIn('peminjaman_id', $riwayatPeminjaman->pluck('id')->toArray())
            ->whereNotNull('tanggal_pengembalian') // Memastikan hanya pengembalian yang sudah tercatat
            ->with('asset') // Mengambil informasi asset yang dikembalikan
            ->get();
        $riwayatSelesai = $riwayatPeminjaman->filter(function ($peminjaman) {
            // Memastikan bahwa peminjaman memiliki pengembalian yang disetujui
            return $peminjaman->pengembalian && $peminjaman->pengembalian->status == 'approved' && $peminjaman->status_peminjaman == 'disetujui';
        });


        return view('layout.PeminjamView.RiwayatPeminjaman', compact('riwayatPeminjaman', 'riwayatPengembalian', 'riwayatSelesai'));
    }


    public function tampilPinjamAsset()
    {
        // Ambil semua aset dengan kondisi baik
        $asset = Assets::where('kondisi', 'baik')->get()
            ->map(function ($item) {
                // Hitung stok tersedia
                $item->stok_tersedia = $item->jumlah_barang - $item->jumlah_terpinjam;
                return $item;
            });

        return view('layout.PeminjamView.PinjamAsset', compact('asset'));
    }
}
