<?php

namespace App\Http\Controllers;

use App\Models\PeminjamanRuangan;
use App\Models\Ruangan;
use App\Models\Peminjam;
use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;
use App\Mail\MailPeminjamanStatus;
use App\Mail\MailPeminjamanStatusRuangan;
use Illuminate\Support\Facades\DB;

class PeminjamanRuanganController extends Controller
{
    public function index()
    {
        // Mengambil hanya peminjaman yang statusnya 'pending'
        $peminjaman = PeminjamanRuangan::with('ruangan', 'peminjam', 'admin')
            ->where('status_peminjaman', 'pending') // Filter berdasarkan status 'pending'
            ->get();

        return view('layout.AdminSekretariatView.PermintaanPeminjaman', compact('peminjaman'));
    }

    public function create()
    {
        $ruangan = Ruangan::where('kondisi', 'baik')->get();
        $peminjaman = PeminjamanRuangan::with('ruangan', 'peminjam') // Pastikan relasi peminjam di-include
            ->whereIn('status_peminjaman', ['disetujui', 'selesai', 'tidak_dapat_dipinjam'])
            ->get();

        // Membuat array event untuk kalender dengan waktu yang lebih terperinci
        $events = $peminjaman->map(function ($peminjaman) {
            // Pastikan bahwa tanggal_mulai dan tanggal_selesai sudah berupa instance Carbon
            $start = Carbon::parse($peminjaman->tanggal_mulai);
            $end = Carbon::parse($peminjaman->tanggal_selesai);

            // Tentukan warna berdasarkan status peminjaman
            $color = null; // Default tidak ada warna (tanpa warna)

            // Jika status peminjaman adalah 'disetujui' atau 'selesai', tandai sebagai sudah dipinjam (merah)
            if ($peminjaman->status_peminjaman === 'disetujui') {
                $color = 'red';  // Sudah dipinjam (merah)
            } elseif ($peminjaman->status_peminjaman === 'selesai') {
                $color = 'green'; // Sudah selesai (hijau)
            } elseif ($peminjaman->status_peminjaman === 'tidak_dapat_dipinjam') {
                $color = 'gray'; // Tidak dapat dipinjam (abu-abu)
            }

            // Kembalikan data event untuk kalender
            return [
                'title' => $peminjaman->ruangan->nama,
                'start' => $start->format('Y-m-d\TH:i:s'),
                'end' => $end->format('Y-m-d\TH:i:s'),
                'color' => $color,  // Set warna berdasarkan status
                'description' => 'Peminjam: ' . $peminjaman->peminjam->name, // Menampilkan nama peminjam
                'status' => $peminjaman->status_peminjaman, // Tambahkan status peminjaman
            ];
        });

        return view('layout.PeminjamView.PinjamRuangan', compact('ruangan', 'events'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'ruangan_id' => 'required|exists:ruangan,id',
            'tanggal_mulai' => 'required|date|before:tanggal_selesai',
            'tanggal_selesai' => 'required|date|after:tanggal_mulai',
        ], [
            'ruangan_id.required' => 'Ruangan harus dipilih.',
            'ruangan_id.exists' => 'Ruangan yang dipilih tidak ada.',
            'tanggal_mulai.required' => 'Tanggal mulai harus diisi.',
            'tanggal_mulai.date' => 'Tanggal mulai tidak valid.',
            'tanggal_mulai.before' => 'Tanggal mulai harus sebelum tanggal selesai.',
            'tanggal_selesai.required' => 'Tanggal selesai harus diisi.',
            'tanggal_selesai.date' => 'Tanggal selesai tidak valid.',
            'tanggal_selesai.after' => 'Tanggal selesai harus setelah tanggal mulai.',
        ]);

        // Mengecek apakah ada peminjaman lain yang tumpang tindih
        $existingBooking = PeminjamanRuangan::where('ruangan_id', $request->ruangan_id)
            ->where(function ($query) use ($request) {
                $query->whereBetween('tanggal_mulai', [$request->tanggal_mulai, $request->tanggal_selesai])
                    ->orWhereBetween('tanggal_selesai', [$request->tanggal_mulai, $request->tanggal_selesai])
                    ->orWhere(function ($query) use ($request) {
                        // Cek juga jika peminjaman baru berada di antara waktu yang ada, seperti 'mulai' baru setelah 'selesai' lama
                        $query->where('tanggal_mulai', '<=', $request->tanggal_selesai)
                            ->where('tanggal_selesai', '>=', $request->tanggal_mulai);
                    });
            })
            ->exists();

        if ($existingBooking) {
            return back()->with('error', 'Ruangan sudah dipinjam pada waktu tersebut.');
        }

        // Simpan peminjaman
        PeminjamanRuangan::create([
            'ruangan_id' => $request->ruangan_id,
            'peminjam_id' => auth()->guard('peminjam')->id(),
            'tanggal_mulai' => $request->tanggal_mulai,
            'tanggal_selesai' => $request->tanggal_selesai,
            'status' => 'pending',
        ]);

        // Redirect dengan pesan sukses
        return redirect()->route('peminjaman.create')->with('success', 'Pengajuan peminjaman berhasil dikirim.');
    }

    public function batchAction(Request $request)
    {
        // Ambil daftar peminjaman yang dipilih
        $selectedPeminjaman = $request->input('selected_peminjaman', []);
        $action = $request->input('action');
        $alasanPenolakan = $request->input('alasan_penolakan', null); // Ambil alasan penolakan jika ada

        if (empty($selectedPeminjaman)) {
            return back()->with('error', 'Tidak ada peminjaman yang dipilih.');
        }

        // Validasi action
        if (!in_array($action, ['approve', 'reject', 'batch_reject'])) {
            return back()->with('error', 'Aksi tidak valid.');
        }

        DB::beginTransaction(); // Mulai transaksi

        try {
            // Mengambil peminjaman berdasarkan ID yang dipilih
            $peminjaman = PeminjamanRuangan::whereIn('id', $selectedPeminjaman)->get();

            foreach ($peminjaman as $item) {
                if ($action == 'approve') {
                    $item->status = 'disetujui';
                    $this->sendStatusEmail($item, 'disetujui', null); // Kirim email disetujui
                } elseif ($action == 'reject' || $action == 'batch_reject') {
                    $item->status = 'ditolak';
                    $this->sendStatusEmail($item, 'ditolak', $alasanPenolakan); // Kirim email ditolak
                }

                // Simpan perubahan status
                $item->save();
            }

            DB::commit(); // Commit transaksi
            return back()->with('success', 'Aksi batch telah diterapkan.');
        } catch (\Exception $e) {
            DB::rollBack(); // Rollback jika terjadi kesalahan
            return back()->with('error', 'Terjadi kesalahan saat menerapkan aksi batch.');
        }
    }


    // public function batchReject(Request $request)
    // {
    //     $selectedPeminjaman = $request->input('selected_peminjaman', []);
    //     $alasanPenolakan = $request->input('alasan_penolakan', 'Tidak ada alasan yang diberikan.');

    //     if (empty($selectedPeminjaman)) {
    //         return back()->with('error', 'Tidak ada peminjaman yang dipilih.');
    //     }

    //     DB::beginTransaction(); // Mulai transaksi

    //     try {
    //         // Loop untuk menolak semua peminjaman yang dipilih
    //         $peminjaman = PeminjamanRuangan::whereIn('id', $selectedPeminjaman)->get();

    //         foreach ($peminjaman as $item) {
    //             // Update status peminjaman menjadi ditolak
    //             $item->status = 'ditolak';
    //             $item->save();

    //             // Kirim email pemberitahuan ke peminjam
    //             $this->sendStatusEmail($item, 'ditolak', $alasanPenolakan);
    //         }

    //         DB::commit(); // Commit transaksi
    //         return back()->with('success', 'Peminjaman yang dipilih telah ditolak.');
    //     } catch (\Exception $e) {
    //         DB::rollBack(); // Rollback jika terjadi kesalahan
    //         return back()->with('error', 'Terjadi kesalahan saat menolak peminjaman.');
    //     }
    // }

    public function approvePeminjaman(Request $request, $id)
    {
        $peminjaman = PeminjamanRuangan::findOrFail($id);

        // Update status peminjaman menjadi disetujui
        $peminjaman->status_peminjaman = 'disetujui';
        $peminjaman->save();

        // Kirim email ke peminjam
        $this->sendStatusEmail($peminjaman, 'disetujui', null);

        return redirect()->back()->with('success', 'Peminjaman telah disetujui.');
    }


    public function rejectPeminjaman(Request $request, $id)
    {
        $peminjaman = PeminjamanRuangan::findOrFail($id);

        // Update status peminjaman menjadi ditolak
        $peminjaman->status_peminjaman = 'ditolak';
        $peminjaman->save();

        // Ambil alasan penolakan dari form
        $alasanPenolakan = $request->input('alasan_penolakan', 'Tidak ada alasan yang diberikan.');

        // Kirim email ke peminjam
        $this->sendStatusEmail($peminjaman, 'ditolak', $alasanPenolakan);

        return redirect()->back()->with('success', 'Peminjaman telah ditolak.');
    }


    private function sendStatusEmail($peminjaman, $status, $alasanPenolakan)
    {
        $peminjamName = $peminjaman->peminjam->name;
        $email = $peminjaman->peminjam->email;
        $tanggalMulai = Carbon::parse($peminjaman->tanggal_mulai)->format('d-m-Y TH:i:s');
        $tanggalSelesai = Carbon::parse($peminjaman->tanggal_selesai)->format('d-m-Y TH:i:s');
        // Data ruangan yang dipinjam
        $ruanganDetails = [
            'nama' => $peminjaman->ruangan->nama,
            'tanggal_mulai' => $tanggalMulai,
            'tanggal_selesai' => $tanggalSelesai
        ];

        // Kirim email pemberitahuan status
        Mail::to($email)->send(new MailPeminjamanStatusRuangan($status, $peminjamName, $alasanPenolakan, $ruanganDetails));
    }
}
