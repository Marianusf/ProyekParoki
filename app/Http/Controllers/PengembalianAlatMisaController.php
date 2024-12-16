<?php

namespace App\Http\Controllers;

use App\Models\PeminjamanAlatMisa;
use App\Models\PengembalianAlatMisa;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Mail\MailPengembalianAlatMisaStatus;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

class PengembalianAlatMisaController extends Controller
{
    public function showPengembalianAlatMisaForm()
    {
        // Periksa apakah pengguna dengan guard 'peminjam' sudah login
        if (!Auth::guard('peminjam')->check()) {
            return redirect()->route('login')->with('error', 'Silakan login terlebih dahulu.');
        }

        $peminjamId = Auth::guard('peminjam')->user()->id;

        // Ambil data peminjaman alat misa yang disetujui dan belum dikembalikan
        $peminjamanAlatMisa = PeminjamanAlatMisa::with(['alatMisa', 'pengembalianAlatMisa']) // Eager load relasi
            ->where('id_peminjam', $peminjamId)
            ->where('status_peminjaman', 'disetujui') // Hanya yang disetujui
            ->whereDoesntHave('pengembalianAlatMisa', function ($query) {
                $query->where('status', 'approved'); // Exclude pengembalian yang sudah approved
            })
            ->get();

        return view('layout.PeminjamView.PengembalianAlatMisa', compact('peminjamanAlatMisa'));
    }

    public function storePengembalianAlatMisa(Request $request)
    {
        // Ambil hanya peminjaman_id yang dipilih oleh pengguna dari request
        $peminjamanIds = $request->input('peminjaman_id', []);

        foreach ($peminjamanIds as $id) {
            // Cek apakah sudah ada permintaan pengembalian untuk peminjaman ini
            $existingPengembalian = PengembalianAlatMisa::where('peminjaman_id', $id)->first();

            // Jika sudah ada permintaan pengembalian dengan status 'approved' atau 'rejected', lewati
            if ($existingPengembalian && in_array($existingPengembalian->status, ['approved', 'rejected'])) {
                continue; // Skip peminjaman jika sudah memiliki status approved atau rejected
            }

            // Jika ada permintaan sebelumnya yang statusnya bukan 'approved' atau 'rejected', hapus permintaan tersebut
            if ($existingPengembalian && !in_array($existingPengembalian->status, ['approved', 'rejected'])) {
                $existingPengembalian->delete();
            }

            // Buat permintaan pengembalian baru
            PengembalianAlatMisa::create([
                'peminjaman_id' => $id,
                'tanggal_pengembalian' => now(),
                'status' => 'pending', // Status awal pending
            ]);
        }

        return redirect()->back()->with('success', 'Permintaan pengembalian alat misa berhasil dikirim.');
    }
    public function approve($id)
    {
        if (Auth::guard('admin')->check()) {
            // Ambil ID admin yang sedang login
            $adminId = Auth::guard('admin')->user()->id;

            // Ambil model PengembalianAlatMisa berdasarkan ID
            $pengembalian = PengembalianAlatMisa::findOrFail($id);

            // Perbarui status pengembalian
            $pengembalian->update([
                'status' => 'approved',  // Ubah status pengembalian menjadi disetujui
                'id_admin' => $adminId,  // Simpan ID admin yang meng-approve
            ]);

            // Mengurangi jumlah terpinjam pada alat misa terkait sesuai jumlah yang dikembalikan
            $jumlahDikembalikan = $pengembalian->peminjaman->jumlah; // Ambil jumlah yang dipinjam
            $alatMisa = $pengembalian->peminjaman->alatMisa; // Relasi ke alat misa

            if ($alatMisa && $alatMisa->jumlah_terpinjam >= $jumlahDikembalikan) {
                $alatMisa->jumlah_terpinjam -= $jumlahDikembalikan; // Kurangi dengan jumlah yang dikembalikan
                $alatMisa->save();
            }

            // Kirim email notifikasi ke peminjam
            $peminjamName = $pengembalian->peminjaman->peminjam->name;
            $alatMisaDetails = [
                'nama_alat' => $alatMisa->nama_alat,
                'jumlah' => $jumlahDikembalikan,
            ];

            Mail::to($pengembalian->peminjaman->peminjam->email)->send(
                new MailPengembalianAlatMisaStatus('approved', null, $peminjamName, $alatMisaDetails)
            );

            return redirect()->back()->with('success', 'Pengembalian alat misa berhasil disetujui.');
        }

        return redirect()->route('login')->with('error', 'Anda harus login sebagai admin.');
    }
    public function reject(Request $request, $id)
    {
        // Validasi alasan penolakan
        $request->validate([
            'alasan_penolakan' => 'required|string|max:255',
        ]);

        if (Auth::guard('admin')->check()) {
            // Ambil ID admin yang sedang login
            $adminId = Auth::guard('admin')->user()->id;

            // Ambil model PengembalianAlatMisa berdasarkan ID
            $pengembalian = PengembalianAlatMisa::findOrFail($id); // ID Pengembalian Alat Misa yang diterima

            // Perbarui status pengembalian dan alasan penolakan
            $pengembalian->update([
                'status' => 'rejected',                // Status pengembalian diubah menjadi rejected
                'id_admin' => $adminId,               // Simpan ID admin yang melakukan reject
                'alasan_penolakan' => $request->alasan_penolakan, // Alasan penolakan
            ]);

            // Ambil data peminjam dan detail alat misa
            $peminjamName = $pengembalian->peminjaman->peminjam->name;
            $alatMisaDetails = [
                'nama_alat' => $pengembalian->peminjaman->alatMisa->nama_alat,
                'jumlah' => $pengembalian->peminjaman->jumlah,
            ];

            // Kirim email notifikasi penolakan ke peminjam
            Mail::to($pengembalian->peminjaman->peminjam->email)->send(
                new MailPengembalianAlatMisaStatus(
                    'rejected',                         // Status rejected
                    $request->alasan_penolakan,         // Alasan penolakan
                    $peminjamName,                      // Nama peminjam
                    $alatMisaDetails                    // Detail alat misa
                )
            );

            return redirect()->back()->with('success', 'Pengembalian alat misa berhasil ditolak.');
        }

        return redirect()->route('login')->with('error', 'Anda harus login sebagai admin.');
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

        // Ambil data pengembalian alat misa berdasarkan ID
        $pengembalians = PengembalianAlatMisa::whereIn('id', $selectedRequests)->get();

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

                    // Mengurangi jumlah terpinjam pada alat misa terkait
                    $alatMisa = $item->peminjaman->alatMisa;
                    $jumlahDikembalikan = $item->peminjaman->jumlah;

                    if ($alatMisa && $alatMisa->jumlah_terpinjam >= $jumlahDikembalikan) {
                        $alatMisa->jumlah_terpinjam -= $jumlahDikembalikan;
                        $alatMisa->save();
                    }

                    // Kirim email notifikasi ke peminjam
                    $peminjamName = $item->peminjaman->peminjam->name;
                    $alatMisaDetails = [
                        'nama_alat' => $item->peminjaman->alatMisa->nama_alat,
                        'jumlah' => $item->peminjaman->jumlah,
                    ];

                    Mail::to($item->peminjaman->peminjam->email)->send(
                        new MailPengembalianAlatMisaStatus('approved', null, $peminjamName, $alatMisaDetails)
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
                    $alatMisaDetails = [
                        'nama_alat' => $item->peminjaman->alatMisa->nama_alat,
                        'jumlah' => $item->peminjaman->jumlah,
                    ];

                    Mail::to($item->peminjaman->peminjam->email)->send(
                        new MailPengembalianAlatMisaStatus('rejected', $alasan_penolakan, $peminjamName, $alatMisaDetails)
                    );
                }
            }
        }

        return redirect()->back()->with('success', 'Batch pengembalian alat misa berhasil diproses.');
    }
}
