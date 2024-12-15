<?php

namespace App\Http\Controllers;

use App\Models\Peminjaman;
use App\Models\Pengembalian;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Mail\MailPengembalianBarangStatus;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

class PengembalianController extends Controller
{
    public function showPengembalianForm()
    {
        // Periksa apakah pengguna dengan guard 'peminjam' sudah login
        if (!Auth::guard('peminjam')->check()) {
            return redirect()->route('login')->with('error', 'Silakan login terlebih dahulu.');
        }

        $peminjamId = Auth::guard('peminjam')->user()->id;

        // Ambil data peminjaman yang disetujui dan belum dikembalikan
        $peminjaman = Peminjaman::with('asset', 'pengembalian') // Eager load pengembalian
            ->where('id_peminjam', $peminjamId)
            ->where('status_peminjaman', 'disetujui') // Hanya yang disetujui
            ->whereDoesntHave('pengembalian', function ($query) {
                $query->where('status', 'approved'); // Pastikan pengembalian yang sudah disetujui tidak ditampilkan
            })
            ->get();

        return view('layout.PeminjamView.Pengembalian', compact('peminjaman'));
    }

    public function storePengembalian(Request $request)
    {
        // Ambil hanya peminjaman_id yang dipilih oleh pengguna dari request
        $peminjamanIds = $request->input('peminjaman_id', []);

        foreach ($peminjamanIds as $id) {
            // Cek apakah sudah ada permintaan pengembalian untuk peminjaman ini
            $existingPengembalian = Pengembalian::where('peminjaman_id', $id)->first();

            // Jika sudah ada permintaan pengembalian dengan status 'approve' atau 'reject', jangan buat permintaan baru
            if ($existingPengembalian && in_array($existingPengembalian->status, ['approve', 'reject'])) {
                continue; // Skip this peminjaman if it's already approved or rejected
            }

            // Jika ada permintaan sebelumnya dan statusnya bukan 'approve' atau 'reject', hapus permintaan tersebut
            if ($existingPengembalian && $existingPengembalian->status != 'approve' && $existingPengembalian->status != 'reject') {
                $existingPengembalian->delete();
            }

            // Buat permintaan pengembalian baru hanya jika tidak ada permintaan dengan status 'approve' atau 'reject'
            if (!$existingPengembalian || $existingPengembalian->status != 'approve' && $existingPengembalian->status != 'reject') {
                Pengembalian::create([
                    'peminjaman_id' => $id,
                    'tanggal_pengembalian' => now(),
                    'status' => 'pending', // Status pengembalian awal adalah pending
                ]);
            }
        }

        return redirect()->back()->with('success', 'Permintaan pengembalian berhasil dikirim');
    }

    // Fungsi Approve
    public function approve($id)
    {

        if (Auth::guard('admin')->check()) {
            // Ambil ID admin yang sedang login
            $adminId = Auth::guard('admin')->user()->id;

            // Ambil model Pengembalian berdasarkan ID
            $pengembalian = Pengembalian::findOrFail($id); // ID Pengembalian yang diterima

            // Perbarui status pengembalian
            $pengembalian->update([
                'status' => 'approved',  // Ubah status pengembalian menjadi disetujui
                'id_admin' => $adminId,   // Simpan ID admin yang meng-approve
            ]);
            // Mengurangi jumlah terpinjam pada asset terkait sesuai jumlah yang dikembalikan
            $jumlahDikembalikan = $pengembalian->peminjaman->jumlah; // Ambil jumlah yang dipinjam
            $asset = $pengembalian->peminjaman->asset;
            if ($asset && $asset->jumlah_terpinjam >= $jumlahDikembalikan) {
                $asset->jumlah_terpinjam -= $jumlahDikembalikan; // Kurangi dengan jumlah yang dikembalikan
                $asset->save();
            }
            // Kirim email notifikasi ke peminjam
            $peminjamName = $pengembalian->peminjaman->peminjam->name;
            $assetDetails = [
                'nama_barang' => $pengembalian->peminjaman->asset->nama_barang,
                'jumlah' => $pengembalian->peminjaman->jumlah,
            ];

            Mail::to($pengembalian->peminjaman->peminjam->email)->send(
                new MailPengembalianBarangStatus('approved', null, $peminjamName, $assetDetails)
            );

            return redirect()->back()->with('success', 'Pengembalian berhasil disetujui.');
        }
    }
    // Fungsi Reject
    public function reject(Request $request, $id)
    {
        $request->validate([
            'alasan_penolakan' => 'required|string|max:255',
        ]);

        if (Auth::guard('admin')->check()) {
            // Ambil ID admin yang sedang login
            $adminId = Auth::guard('admin')->user()->id;

            // Ambil model Pengembalian berdasarkan ID
            $pengembalian = Pengembalian::findOrFail($id); // ID Pengembalian yang diterima

            // Perbarui status pengembalian
            $pengembalian->update([
                'status' => 'rejected',  // Ubah status pengembalian menjadi disetujui
                'id_admin' => $adminId,   // Simpan ID admin yang meng-approve
                $pengembalian->alasan_penolakan = $request->alasan_penolakan
            ]);
            // Kirim email notifikasi ke peminjam
            $peminjamName = $pengembalian->peminjaman->peminjam->name;
            $assetDetails = [
                'nama_barang' => $pengembalian->peminjaman->asset->nama_barang,
                'jumlah' => $pengembalian->peminjaman->jumlah,
            ];
            Mail::to($pengembalian->peminjaman->peminjam->email)->send(
                new MailPengembalianBarangStatus('rejected', $pengembalian->alasan_penolakan, $peminjamName, $assetDetails)
            );

            return redirect()->back()->with('success', 'Pengembalian berhasil ditolak.');
        }
    }
    public function batchAction(Request $request)
    {
        // Validasi manual
        $validator = Validator::make($request->all(), [
            'selected_requests' => 'required|array',
            'action' => 'required|string|in:approve,reject',
            'alasan_penolakan' => 'nullable|string|max:255',
        ], [
            'selected_requests.required' => 'Anda harus memilih setidaknya satu permintaan.',
            'selected_requests.array' => 'Format data tidak valid.',
            'action.required' => 'Aksi harus dipilih.',
            'action.in' => 'Aksi tidak valid.',
            'alasan_penolakan.string' => 'Alasan penolakan harus berupa teks.',
            'alasan_penolakan.max' => 'Alasan penolakan tidak boleh lebih dari 255 karakter.',
        ]);

        // Jika validasi gagal
        if ($validator->fails()) {
            $errors = $validator->errors()->all();

            return redirect()->back()->with([
                'sweet-alert' => [
                    'icon' => 'error',
                    'title' => 'Validasi Gagal',
                    'text' => implode(' ', $errors), // Gabungkan semua pesan error
                ],
            ]);
        }

        $selectedRequests = $request->input('selected_requests', []);
        $action = $request->input('action');
        $alasan_penolakan = $request->input('alasan_penolakan', null);

        $pengembalians = Pengembalian::whereIn('id', $selectedRequests)->get();

        foreach ($pengembalians as $item) {
            // Periksa apakah admin sedang login
            if (Auth::guard('admin')->check()) {
                $adminId = Auth::guard('admin')->user()->id;

                if ($action == 'approve') {
                    // Perbarui status menjadi approved
                    $item->update([
                        'status' => 'approved',
                        'id_admin' => $adminId,
                    ]);

                    // Mengurangi jumlah terpinjam pada asset terkait
                    $asset = $item->peminjaman->asset;
                    $jumlahDikembalikan = $item->peminjaman->jumlah;
                    if ($asset && $asset->jumlah_terpinjam >= $jumlahDikembalikan) {
                        $asset->jumlah_terpinjam -= $jumlahDikembalikan;
                        $asset->save();
                    }

                    // Kirim email notifikasi ke peminjam
                    $peminjamName = $item->peminjaman->peminjam->name;
                    $assetDetails = [
                        'nama_barang' => $item->peminjaman->asset->nama_barang,
                        'jumlah' => $item->peminjaman->jumlah,
                    ];

                    Mail::to($item->peminjaman->peminjam->email)->send(
                        new MailPengembalianBarangStatus('approved', null, $peminjamName, $assetDetails)
                    );
                } elseif ($action == 'reject' && $alasan_penolakan) {
                    // Perbarui status menjadi rejected
                    $item->update([
                        'status' => 'rejected',
                        'id_admin' => $adminId,
                        'alasan_penolakan' => $alasan_penolakan,
                    ]);

                    // Kirim email notifikasi ke peminjam
                    $peminjamName = $item->peminjaman->peminjam->name;
                    $assetDetails = [
                        'nama_barang' => $item->peminjaman->asset->nama_barang,
                        'jumlah' => $item->peminjaman->jumlah,
                    ];

                    Mail::to($item->peminjaman->peminjam->email)->send(
                        new MailPengembalianBarangStatus('rejected', $alasan_penolakan, $peminjamName, $assetDetails)
                    );
                }
            }
        }

        return redirect()->back()->with('success', 'Batch pengembalian berhasil diproses.');
    }
}
