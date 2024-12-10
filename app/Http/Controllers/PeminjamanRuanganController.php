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



    public function approvePeminjaman($id)
    {
        $peminjaman = PeminjamanRuangan::findOrFail($id);
        $adminId = Auth::guard('admin')->user()->id;
        // Update status peminjaman menjadi disetujui
        $peminjaman->status_peminjaman = 'disetujui';
        $peminjaman->admin_id = $adminId;
        $peminjaman->save();

        // Kirim email ke peminjam
        $this->sendStatusEmail($peminjaman, 'disetujui', null);

        return redirect()->back()->with('success', "Peminjaman Oleh {$peminjaman->peminjam->name} telah disetujui.");
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
