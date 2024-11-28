<?php

namespace App\Http\Controllers;

use App\Models\Peminjam;
use Illuminate\Http\Request;

class PeminjamController extends Controller
{
    public function lihatProfile()
    {
        // Ambil data peminjam berdasarkan ID pengguna yang sedang login
        $peminjam = auth('peminjam')->user();  // Menggunakan auth()->id() untuk mendapatkan ID pengguna yang sedang login

        // Pastikan data ditemukan, jika tidak, redirect ke halaman error atau lainnya
        if (!$peminjam) {
            return redirect()->route('login')->with('error', 'Silahkan login dahulu');
        }

        // Tampilkan profil peminjam
        return view('layout.PeminjamView.Profile', compact('peminjam'));
    }
    // public function updateProfile(Request $request)
    // {
    //     $peminjam = auth('peminjam')->user();

    //     // Validasi
    //     $request->validate([
    //         'nama_lengkap' => 'required|string|max:255',
    //         'email' => 'required|email|max:255',
    //         'nik' => 'required|string|max:16',
    //         'tanggal_lahir' => 'required|date',
    //         'jenis_kelamin' => 'required|string',
    //         'lingkungan' => 'required|string',
    //         'nomor_telepon' => 'required|string',
    //         'alamat' => 'required|string',
    //     ]);

    //     // Update data
    //     $peminjam->update([
    //         'nama_lengkap' => $request->nama_lengkap,
    //         'email' => $request->email,
    //         'nik' => $request->nik,
    //         'tanggal_lahir' => $request->tanggal_lahir,
    //         'jenis_kelamin' => $request->jenis_kelamin,
    //         'lingkungan' => $request->lingkungan,
    //         'nomor_telepon' => $request->nomor_telepon,
    //         'alamat' => $request->alamat,
    //     ]);

    //     return redirect()->route('profile')->with('success', 'Profile updated successfully!');
    // }
}
