<?php

namespace App\Http\Controllers;

use App\Models\Peminjaman;
use Illuminate\Http\Request;

class PeminjamController extends Controller
{
    // Method untuk menampilkan form peminjaman
    public function create()
    {
        return view('peminjam.create');
    }

    // Method untuk menyimpan data peminjaman ke dalam database
    public function store(Request $request)
    {
        // Validasi data dari form
        $validatedData = $request->validate([
            'penanggung_jawab' => 'required|string|max:255',
            'jenis_peminjaman' => 'required|string',
            'asset_id' => 'nullable|exists:assets,id',
            'ruangan_id' => 'nullable|exists:ruangans,id',
            'jumlah' => 'nullable|integer|min:1',
            'tanggal_mulai' => 'required|date',
            'tanggal_selesai' => 'required|date|after_or_equal:tanggal_mulai',
            'jam_mulai' => 'required|date_format:H:i',
            'jam_selesai' => 'required|date_format:H:i|after:jam_mulai',
        ]);

        // Menyimpan data peminjaman ke dalam database
        Peminjaman::create([
            'penanggung_jawab' => $validatedData['penanggung_jawab'],
            'jenis_peminjaman' => $validatedData['jenis_peminjaman'],
            'asset_id' => $validatedData['jenis_peminjaman'] == 'asset' ? $validatedData['asset_id'] : null,
            'ruangan_id' => $validatedData['jenis_peminjaman'] == 'ruangan' ? $validatedData['ruangan_id'] : null,
            'jumlah' => $validatedData['jumlah'],
            'tanggal_mulai' => $validatedData['tanggal_mulai'],
            'tanggal_selesai' => $validatedData['tanggal_selesai'],
            'jam_mulai' => $validatedData['jam_mulai'],
            'jam_selesai' => $validatedData['jam_selesai'],
        ]);

        // Redirect atau kembali dengan pesan sukses
        return redirect()->route('peminjaman.index')->with('success', 'Peminjaman berhasil ditambahkan');
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
}


