<?php

namespace App\Http\Controllers;

use App\Models\PeminjamanRuangan;
use App\Models\Ruangan;
use App\Models\Peminjam;
use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class PeminjamanRuanganController extends Controller
{
    // Menampilkan daftar peminjaman
    public function index()
    {
        $peminjaman = PeminjamanRuangan::with('ruangan', 'peminjam', 'admin')->get();
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


    public function approve(Request $request, $id)
    {
        $peminjaman = PeminjamanRuangan::findOrFail($id);

        if ($peminjaman->status_peminjaman !== 'pending') {
            return redirect()->back()->withErrors('Peminjaman sudah diproses.');
        }
        $adminId = Auth::guard('admin')->user()->id;
        $peminjaman->update([
            'status_peminjaman' => 'disetujui',
            'admin_id' => $adminId // Assigning the approver admin
        ]);

        return redirect()->back()->with('success', 'Peminjaman berhasil disetujui.');
    }

    public function reject(Request $request, $id)
    {
        $request->validate([
            'alasan_penolakan' => 'required|string',
        ]);

        $peminjaman = PeminjamanRuangan::findOrFail($id);

        if ($peminjaman->status_peminjaman !== 'pending') {
            return redirect()->back()->withErrors('Peminjaman sudah diproses.');
        }
        $adminId = Auth::guard('admin')->user()->id;
        $peminjaman->update([
            'status_peminjaman' => 'ditolak',
            'alasan_penolakan' => $request->alasan_penolakan,
            'admin_id' => $adminId, // Assigning the rejecting admin
        ]);

        return redirect()->back()->with('success', 'Peminjaman berhasil ditolak.');
    }
    public function showCalendar()
    {
        // Mengambil semua peminjaman yang disetujui atau selesai, kecuali yang statusnya 'ditolak' atau 'pending'
        $peminjaman = PeminjamanRuangan::with('ruangan')
            ->whereIn('status', ['disetujui', 'selesai'])
            ->get();

        // Membuat array event untuk kalender
        $events = $peminjaman->map(function ($peminjaman) {
            return [
                'title' => $peminjaman->ruangan->nama_ruangan,
                'start' => $peminjaman->tanggal_mulai,
                'end' => $peminjaman->tanggal_selesai,
                'color' => 'red', // Warna untuk peminjaman yang disetujui
                'description' => 'Peminjam: ' . $peminjaman->peminjam->name,
            ];
        });

        return view('kalender', compact('events'));
    }
}
