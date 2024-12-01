<?php

namespace App\Http\Controllers;

use App\Models\Peminjam;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;


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
    public function updateProfile(Request $request)
    {
        // Ambil ID pengguna yang sedang login
        $peminjamId = auth('peminjam')->id();

        // Cari data peminjam berdasarkan ID
        $peminjam = Peminjam::find($peminjamId);

        // Jika tidak ditemukan, kembalikan pesan error
        if (!$peminjam) {
            return redirect()->route('lihatProfile')->withErrors(['error' => 'Peminjam tidak ditemukan']);
        }

        // Validasi input
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|regex:/^[\w\.\-]+@gmail\.com$/i|unique:peminjam,email,' . $peminjam->id,
            'tanggal_lahir' => 'required|date_format:Y-m-d',
            'alamat' => 'required|string',
            'nomor_telepon' => 'required|numeric|digits_between:10,15',
            'lingkungan' => 'required|string',
            'password' => [
                'nullable',
                'string',
                'min:8',
                'confirmed',
                'regex:/^(?=.*[0-9]).{8,}$/', // Validasi password dengan angka
            ],
            'poto_profile' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        try {
            // Update data profil lainnya
            $updatedFields = []; // Menyimpan field yang berhasil diperbarui
            if ($request->hasFile('poto_profile')) {
                if ($peminjam->poto_profile && $peminjam->poto_profile !== 'default.jpg') {
                    Storage::disk('public')->delete($peminjam->poto_profile);
                }
                $path = $request->file('poto_profile')->store('profile_pictures', 'public');
                $peminjam->update(['poto_profile' => $path]);
                $updatedFields[] = 'Foto Profil';
            }

            if ($request->name !== $peminjam->name) {
                $peminjam->name = $request->name;
                $updatedFields[] = 'Nama Lengkap';
            }

            if ($request->email !== $peminjam->email) {
                $peminjam->email = $request->email;
                $updatedFields[] = 'Email';
            }

            if ($request->tanggal_lahir !== $peminjam->tanggal_lahir) {
                $peminjam->tanggal_lahir = $request->tanggal_lahir;
                $updatedFields[] = 'Tanggal Lahir';
            }

            if ($request->alamat !== $peminjam->alamat) {
                $peminjam->alamat = $request->alamat;
                $updatedFields[] = 'Alamat';
            }

            if ($request->nomor_telepon !== $peminjam->nomor_telepon) {
                $peminjam->nomor_telepon = $request->nomor_telepon;
                $updatedFields[] = 'Nomor Telepon';
            }

            if ($request->lingkungan !== $peminjam->lingkungan) {
                $peminjam->lingkungan = $request->lingkungan;
                $updatedFields[] = 'Lingkungan';
            }

            // Simpan perubahan profil
            $peminjam->save();

            // Jika ada perubahan password
            if ($request->filled('password')) {
                // Verifikasi password yang baru
                $peminjam->password = bcrypt($request->password);
                $updatedFields[] = 'Password';
            }

            // Menampilkan pesan jika ada perubahan
            if (count($updatedFields) > 0) {
                $fieldsString = implode(', ', $updatedFields);
                return redirect()->route('lihatProfile')->with('success', "Berikut perubahan yang berhasil diperbarui: " . $fieldsString);
            } else {
                return redirect()->route('lihatProfile')->with('message', 'Tidak ada perubahan yang dilakukan.');
            }
        } catch (\Exception $e) {
            // Tangkap error dan tampilkan di session dengan pesan error
            return redirect()->route('lihatProfile')->withErrors(['error' => 'Terjadi kesalahan: ' . $e->getMessage()]);
        }
    }
}
