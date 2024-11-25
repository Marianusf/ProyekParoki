<?php

namespace App\Http\Controllers;

use App\Models\Peminjaman;
use Illuminate\Http\Request;
use App\Models\KeranjangPeminjaman;

class PeminjamController extends Controller
{
    // Method untuk menampilkan form peminjaman
    public function create()
    {
        return view('peminjam.create');
    }



    public function index()
    {
        return view('PeminjamView.FormPeminjaman'); // Ensure this view exists
    }
  
public function DaftarRuangan(){
    return View('PeminjamView.FormPeminjaman');
}
public function Dashboard(){
    return View('PeminjamView.DashboardPeminjam');
}
public function InformasiAset(){
    return view('PeminjamView.InformasiAset');
}
public function store(Request $request)
{
    // Validasi inputan
    $validatedData = $request->validate([
        'penanggung_jawab' => 'required|string|max:255',
        'jenis_peminjaman' => 'required|string',
        'perlengkapan' => 'nullable|string',
        'ruangan' => 'nullable|string',
        'alat_misa' => 'nullable|string',
        'tanggal_mulai' => 'nullable|date',
        'tanggal_selesai' => 'nullable|date',
        'jam_mulai' => 'nullable|date_format:H:i',
        'jam_selesai' => 'nullable|date_format:H:i',
        'jumlah' => 'nullable|integer|min:1',
    ]);

    // Simpan ke keranjang peminjaman
    KeranjangPeminjaman::create([
        'penanggung_jawab' => $validatedData['penanggung_jawab'],
        'jenis_peminjaman' => $validatedData['jenis_peminjaman'],
        'perlengkapan' => $request->input('perlengkapan'),
        'ruangan' => $request->input('ruangan'),
        'alat_misa' => $request->input('alat_misa'),
        'tanggal_mulai' => $request->input('tanggal_mulai'),
        'tanggal_selesai' => $request->input('tanggal_selesai'),
        'jam_mulai' => $request->input('jam_mulai'),
        'jam_selesai' => $request->input('jam_selesai'),
        'jumlah' => $request->input('jumlah'),
    ]);

    // Tampilkan popup notifikasi
    return response()->json(['message' => 'Berhasil ditambahkan ke keranjang'], 200);
}

}


