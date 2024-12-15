<?php

// app/Http/Controllers/AdminController.php

namespace App\Http\Controllers;

use App\Models\Peminjam;
use App\Models\Peminjaman;
use App\Models\PeminjamanAlatMisa;
use App\Models\Pengembalian;
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
}
