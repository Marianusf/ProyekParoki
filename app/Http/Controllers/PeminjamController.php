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
        return view('PeminjamView.ViewRuangan'); // Ensure this view exists
    }
  
public function DaftarRuangan(){
    return View('PeminjamView.FormRuangan');
}
public function Dashboard(){
    return View('PeminjamView.DashboardPeminjam');
}
public function InformasiRuangan(){
    return view('PeminjamView.InformasiRuangan');
}






//Menyimpan inputan data peminjaman ruangan 
public function SaveDataRuangan(Request $request)
    {
        // Validasi data
        $validatedData = $request->validate([
            'penanggung_jawab' => 'required|string|max:255',
            'tanggal_mulai' => 'required|date_format:d/m/Y',
            'tanggal_selesai' => 'required|date_format:d/m/Y',
            'jam_mulai' => 'required|date_format:H:i',
            'jam_selesai' => 'required|date_format:H:i',
            'keperluan' => 'required|string',
        ]);



        // Simpan data ke dalam database
        Peminjaman::create([
            'penanggung_jawab' => $validatedData['penanggung_jawab'],
            'tanggal_mulai' => $tanggal['tanggal_mulai'],
            'tanggal_selesai' => $tanggal['tanggal_selesai'],
            'jam_mulai' => $validatedData['jam_mulai'],
            'jam_selesai' => $validatedData['jam_selesai'],
            'keperluan' => $validatedData['keperluan'],
        ]);

        // Redirect atau kirim response sukses
        return redirect()->back()->with('success', 'Peminjaman ruangan berhasil diajukan.');
    }



  
}


