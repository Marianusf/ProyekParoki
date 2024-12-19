<?php

// app/Http/Controllers/AdminController.php

namespace App\Http\Controllers;

use App\Models\peminjam;
use App\Models\Peminjaman;
use App\Models\PeminjamanAlatMisa;
use App\Models\PeminjamanRuangan;
use App\Models\Pengembalian;
use App\Models\PengembalianAlatMisa;
use Carbon\Carbon;

use Illuminate\Http\Request;

class AdminController extends Controller
{
    // Fungsi untuk menampilkan daftar peminjam yang telah disetujui
    public function listPeminjamAktif()
    {
        // Mengambil data peminjam yang sudah disetujui (is_approved = true)
        $peminjam = Peminjam::where('is_approved', true)->get();

        // Menampilkan view khusus untuk daftar peminjam aktif di lokasi baru
        return view('layout.AdminView.LihatPeminjamAktif', compact('peminjam'));
    }
    public function listPeminjamAktifbyparamenta()
    {
        // Mengambil data peminjam yang sudah disetujui (is_approved = true)
        $peminjam = peminjam::where('is_approved', true)->get();

        // Menampilkan view khusus untuk daftar peminjam aktif di lokasi baru
        return view('layout.AdminParamentaView.LihatPeminjamAktif', compact('peminjam'));
    }
    public function listPeminjamAktifbysekretariat()
    {
        // Mengambil data peminjam yang sudah disetujui (is_approved = true)
        $peminjam = peminjam::where('is_approved', true)->get();

        // Menampilkan view khusus untuk daftar peminjam aktif di lokasi baru
        return view('layout.AdminSekretariatView.LihatPeminjamAktif', compact('peminjam'));
    }
    public function lihatPermintaanPeminjaman()
    {
        $peminjamanRequests = Peminjaman::where('status_peminjaman', 'pending')->with(['asset', 'peminjam'])->get();

        return view('layout.AdminView.PermintaanPeminjaman', compact('peminjamanRequests'));
    }
    public function adminLihatPermintaanPengembalian()
    {
        $pengembalian = Pengembalian::with('peminjaman')
            ->where('status', 'pending') // Menampilkan pengembalian yang statusnya pending
            ->get();

        return view('layout.AdminView.PermintaanPengembalian', compact('pengembalian'));
    }
    public function lihatPermintaanPeminjamanAlatMisa()
    {
        $alatMisaRequests = PeminjamanAlatMisa::where('status_peminjaman', 'pending')->with(['alatmisa', 'peminjam'])->get();
        return view('layout.AdminParamentaView.PermintaanPeminjamanAlatMisa', compact('alatMisaRequests'));
    }
    public function adminLihatPermintaanPengembalianAlatMisa()
    {
        $pengembalianAlatMisa = PengembalianAlatMisa::with('peminjaman')
            ->where('status', 'pending') // Menampilkan pengembalian yang statusnya pending
            ->get();

        return view('layout.AdminParamentaView.PermintaanPengembalianAlatMisa', compact('pengembalianAlatMisa'));
    }
    public function LihatRiwayatPeminjamanAsset()
    {
        // Data Peminjaman dengan status pending, disetujui, ditolak
        $peminjaman = Peminjaman::with(['asset', 'peminjam'])
            ->get();

        // Data Pengembalian dengan status pending, disetujui, ditolak
        $pengembalian = Pengembalian::with(['peminjaman.asset', 'peminjaman.peminjam'])
            ->get();

        // Data yang sudah selesai: Peminjaman disetujui + Pengembalian disetujui
        $selesai = Pengembalian::with(['peminjaman.asset', 'peminjaman.peminjam'])
            ->where('status', 'approved')
            ->whereHas('peminjaman', function ($query) {
                $query->where('status_peminjaman', 'disetujui');
            })->get();

        return view('layout.AdminView.LihatRiwayatPeminjamanAsset', compact('peminjaman', 'pengembalian', 'selesai'));
    }
    public function LihatRiwayatPeminjamanAlatMisa()
    {
        // Peminjaman Alat Misa
        $peminjaman = PeminjamanAlatMisa::with(['alatMisa', 'peminjam'])->get();

        // Pengembalian Alat Misa
        $pengembalian = PengembalianAlatMisa::with(['peminjaman.alatMisa', 'peminjaman.peminjam'])->get();

        // Peminjaman Selesai
        $selesai = PengembalianAlatMisa::with(['peminjaman.alatMisa', 'peminjaman.peminjam'])
            ->where('status', 'approved')
            ->whereHas('peminjaman', function ($query) {
                $query->where('status_peminjaman', 'disetujui');
            })->get();

        return view('layout.AdminParamentaView.LihatRiwayatPeminjamanAlatMisa', compact('peminjaman', 'pengembalian', 'selesai'));
    }


    public function LihatRiwayatPeminjamanRuangan()
    {
        // Ambil semua data peminjaman dengan relasi ruangan dan peminjam
        $peminjaman = PeminjamanRuangan::with(['ruangan', 'peminjam'])->get();

        // Tandai setiap peminjaman dengan status berdasarkan tanggal
        $peminjaman->map(function ($item) {
            $waktuMulai = Carbon::parse($item->tanggal_mulai);
            $waktuSelesai = Carbon::parse($item->tanggal_selesai);

            if ($item->status_peminjaman === 'disetujui') {
                if (Carbon::now()->between($waktuMulai, $waktuSelesai)) {
                    $item->status = 'Sedang Aktif'; // Sedang dalam pemakaian
                } elseif (Carbon::now()->greaterThan($waktuSelesai)) {
                    $item->status = 'Selesai'; // Waktu selesai telah lewat
                } else {
                    $item->status = 'Akan Datang'; // Peminjaman sudah disetujui, belum dimulai
                }
            } elseif ($item->status_peminjaman === 'pending') {
                $item->status = 'Pending'; // Menunggu persetujuan
            } else {
                $item->status = 'Ditolak'; // Peminjaman ditolak
            }

            return $item;
        });

        return view('layout.AdminSekretariatView.LihatRiwayatPeminjamanRuangan', compact('peminjaman'));
    }
}
