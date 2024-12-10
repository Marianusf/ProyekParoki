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
        $this->updateRoomAvailability();
        // Mengambil hanya peminjaman yang statusnya 'pending'
        $peminjaman = PeminjamanRuangan::with('ruangan', 'peminjam', 'admin')
            ->where('status_peminjaman', 'pending') // Filter berdasarkan status 'pending'
            ->get();

        return view('layout.AdminSekretariatView.PermintaanPeminjaman', compact('peminjaman'));
    }

    // Fungsi untuk memperbarui status ruangan yang sudah selesai
    public function updateRoomAvailability()
    {
        // Ambil waktu saat ini, termasuk jam, menit, dan detik
        $now = now();

        // Cari peminjaman yang sudah selesai dan update statusnya
        $peminjamans = PeminjamanRuangan::where('tanggal_selesai', '<=', $now)
            ->where('status_peminjaman', 'disetujui') // Hanya yang disetujui
            ->get();

        foreach ($peminjamans as $peminjaman) {
            // Periksa apakah tanggal selesai sudah lebih kecil atau sama dengan waktu sekarang
            if (Carbon::parse($peminjaman->tanggal_selesai)->lte($now)) {
                // Perbarui status menjadi "tersedia" (available)
                $peminjaman->update(['status_peminjaman' => 'tersedia']);
            }
        }
    }

    public function create()
    {
        // Ambil data peminjaman yang statusnya 'disetujui' dan tanggal selesai masih valid
        $peminjaman = PeminjamanRuangan::where('status_peminjaman', 'disetujui')
            ->where('tanggal_selesai', '>=', now())  // Hanya tampilkan yang belum selesai
            ->get();

        // Ambil data ruangan yang kondisi baik
        $ruangan_baik = Ruangan::where('kondisi', 'baik')->get();

        // Membuat array event untuk kalender dengan waktu yang lebih terperinci
        $events = $peminjaman->map(function ($peminjaman) {
            // Pastikan bahwa tanggal_mulai dan tanggal_selesai sudah berupa instance Carbon
            $start = Carbon::parse($peminjaman->tanggal_mulai);
            $end = Carbon::parse($peminjaman->tanggal_selesai);

            // Tentukan warna berdasarkan status peminjaman
            $color = 'red';  // Selalu merah untuk peminjaman disetujui

            // Kembalikan data event untuk kalender
            return [
                'title' => $peminjaman->ruangan->nama,  // Nama ruangan
                'start' => $start->format('Y-m-d\TH:i:s'),
                'end' => $end->format('Y-m-d\TH:i:s'),
                'color' => $color,  // Set warna merah
                'description' => 'Peminjam: ' . $peminjaman->peminjam->name, // Menampilkan nama peminjam
                'status' => $peminjaman->status_peminjaman, // Tambahkan status peminjaman
            ];
        });

        // Kirim data ke view
        return view('layout.PeminjamView.PinjamRuangan', compact('peminjaman', 'events', 'ruangan_baik'));
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
            ->where('status_peminjaman', 'disetujui')
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

    public function approvePeminjaman($id)
    {
        DB::beginTransaction();

        try {
            $peminjaman = PeminjamanRuangan::findOrFail($id);

            $adminId = Auth::guard('admin')->user()->id;

            // Cek konflik waktu dengan peminjaman yang sudah disetujui
            $conflict = PeminjamanRuangan::where('ruangan_id', $peminjaman->ruangan_id)
                ->where('status_peminjaman', 'disetujui')
                ->where(function ($query) use ($peminjaman) {
                    $query->whereBetween('tanggal_mulai', [$peminjaman->tanggal_mulai, $peminjaman->tanggal_selesai])
                        ->orWhereBetween('tanggal_selesai', [$peminjaman->tanggal_mulai, $peminjaman->tanggal_selesai])
                        ->orWhere(function ($query) use ($peminjaman) {
                            $query->where('tanggal_mulai', '<=', $peminjaman->tanggal_selesai)
                                ->where('tanggal_selesai', '>=', $peminjaman->tanggal_mulai);
                        });
                })
                ->lockForUpdate()
                ->exists();

            if ($conflict) {
                DB::rollBack();
                // Flash message untuk konflik
                session()->flash('sweet-alert', [
                    'icon' => 'error',
                    'title' => 'Konflik Waktu!',
                    'text' => 'Peminjaman tidak dapat disetujui karena konflik waktu dengan peminjaman lain.',
                ]);
                return redirect()->back();
            }

            // Jika tidak ada konflik, setujui peminjaman
            $peminjaman->status_peminjaman = 'disetujui';
            $peminjaman->admin_id = $adminId;
            $peminjaman->save();

            DB::commit();

            // Flash message untuk sukses
            session()->flash('sweet-alert', [
                'icon' => 'success',
                'title' => 'Berhasil!',
                'text' => "Peminjaman oleh {$peminjaman->peminjam->name} telah disetujui.",
            ]);

            return redirect()->back();
        } catch (\Exception $e) {
            DB::rollBack();

            // Flash message untuk error
            session()->flash('sweet-alert', [
                'icon' => 'error',
                'title' => 'Gagal!',
                'text' => 'Terjadi kesalahan saat menyetujui peminjaman.',
            ]);

            return redirect()->back();
        }
    }


    public function rejectPeminjaman(Request $request, $id)
    {
        // Cari peminjaman berdasarkan ID
        $peminjaman = PeminjamanRuangan::findOrFail($id);

        // Validasi alasan penolakan
        $request->validate([
            'alasan_penolakan' => 'required|string|max:255',
        ], [
            'alasan_penolakan.required' => 'Alasan penolakan wajib diisi.',
            'alasan_penolakan.string' => 'Alasan penolakan harus berupa teks.',
            'alasan_penolakan.max' => 'Alasan penolakan tidak boleh lebih dari 255 karakter.',
        ]);
        $adminId = Auth::guard('admin')->user()->id;
        // Update status peminjaman menjadi ditolak
        $peminjaman->status_peminjaman = 'ditolak';
        $peminjaman->admin_id = $adminId;
        $peminjaman->save();

        // Ambil alasan penolakan dari form
        $alasanPenolakan = $request->input('alasan_penolakan');

        // Kirim email ke peminjam
        try {
            $this->sendStatusEmail($peminjaman, 'ditolak', $alasanPenolakan);
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Peminjaman ditolak, tetapi email gagal dikirim.');
        }

        // Redirect kembali dengan pesan sukses
        return redirect()->back()->with('success', "Peminjaman oleh {$peminjaman->peminjam->name} telah ditolak.");
    }


    private function sendStatusEmail($peminjaman, $status, $alasanPenolakan)
    {
        $peminjamName = $peminjaman->peminjam->name;
        $email = $peminjaman->peminjam->email;
        $tanggalMulai = Carbon::parse($peminjaman->tanggal_mulai)->format('d-m-Y H:i');
        $tanggalSelesai = Carbon::parse($peminjaman->tanggal_selesai)->format('d-m-Y H:i');

        // Data ruangan yang dipinjam
        $ruanganDetails = [
            'nama' => $peminjaman->ruangan->nama,
            'tanggal_mulai' => $tanggalMulai,
            'tanggal_selesai' => $tanggalSelesai,
        ];

        // Kirim email pemberitahuan status
        Mail::to($email)->send(new MailPeminjamanStatusRuangan($status, $peminjamName, $alasanPenolakan, $ruanganDetails));
    }
}
