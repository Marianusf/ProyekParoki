<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PeminjamController extends Controller
{
    public function index()
    {
        return view('PeminjamView.ViewRuangan'); // Ensure this view exists
    }
  
public function DaftarRuangan(){
    return View('PeminjamView.Ruangan');
}
public function Dashboard(){
    return View('PeminjamView.DashboardPeminjam');
}
public function InformasiRuangan(){
    return view('PeminjamView.InformasiRuangan');
}

public function EditAdmin(){
    return view('PeminjamView.AdminEdit');
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


