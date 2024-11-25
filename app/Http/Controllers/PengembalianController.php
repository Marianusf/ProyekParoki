<?php

namespace App\Http\Controllers;

use App\Models\Peminjaman;
use App\Models\Pengembalian;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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



    public function setujui($id)
    {
        $pengembalian = Pengembalian::findOrFail($id);

        // Mengakses asset melalui relasi peminjaman
        $asset = $pengembalian->peminjaman->asset;

        if ($asset) {
            // Kurangi jumlah terpinjam pada asset
            $asset->jumlah_terpinjam -= 1;
            $asset->save();  // Simpan perubahan ke database
        }

        // Ubah status pengembalian menjadi approved
        $pengembalian->status = 'approved';
        $pengembalian->save();

        // Logika untuk mengirim email atau pemberitahuan lainnya jika diperlukan
        return redirect()->back()->with('success', 'Permintaan pengembalian disetujui.');
    }


    public function tolak(Request $request, $id)
    {
        $pengembalian = Pengembalian::findOrFail($id);
        $pengembalian->status = 'rejected';
        $pengembalian->alasan_penolakan = $request->alasan_penolakan;
        $pengembalian->save();

        // Kirim email notifikasi ke peminjam
        // Mail::to($pengembalian->peminjam->email)->send(new \App\Mail\PenolakanPengembalianMail($pengembalian));
        return redirect()->back()->with('success', 'Permintaan Pengembalian Berhasil ditolak');
    }

    public function batchAction(Request $request)
    {
        $selectedRequests = $request->input('selected_requests', []);
        $action = $request->input('action');
        $alasan_penolakan = $request->input('alasan_penolakan', null);

        if ($action == 'approve') {
            $pengembalian = Pengembalian::whereIn('id', $selectedRequests)->get();
            foreach ($pengembalian as $item) {
                $item->status = 'approved';
                $item->save();

                // Mengurangi jumlah terpinjam pada asset yang terkait
                $asset = $item->peminjaman->asset;  // Mengakses asset melalui relasi peminjaman
                if ($asset && $asset->jumlah_terpinjam > 0) {
                    $asset->jumlah_terpinjam -= 1;  // Mengurangi jumlah terpinjam
                    $asset->save();
                }
            }
            return redirect()->back()->with('success', 'Permintaan pengembalian yang dipilih berhasil disetujui.');
        } elseif ($action == 'reject' && $alasan_penolakan) {
            // Update status penolakan dan alasan penolakan
            Pengembalian::whereIn('id', $selectedRequests)->update([
                'status' => 'rejected',
                'alasan_penolakan' => $alasan_penolakan
            ]);

            // Kirim email notifikasi penolakan untuk setiap peminjam
            foreach ($selectedRequests as $requestId) {
                $pengembalian = Pengembalian::findOrFail($requestId);
                // Mail::to($pengembalian->peminjaman->peminjam->email)
                //     ->send(new \App\Mail\PenolakanPengembalianMail($pengembalian));
            }
            return redirect()->back()->with('success', 'Permintaan pengembalian yang dipilih berhasil ditolak.');
        }

        return redirect()->back()->withErrors(['error' => 'Aksi tidak valid.']);
    }
}
