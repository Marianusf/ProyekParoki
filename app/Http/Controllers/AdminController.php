<?php

// app/Http/Controllers/AdminController.php

namespace App\Http\Controllers;

use App\Models\Peminjam;
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
}
