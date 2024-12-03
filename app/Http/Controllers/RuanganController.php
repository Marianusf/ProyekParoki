<?php

namespace App\Http\Controllers;

use App\Models\Ruangan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class RuanganController extends Controller
{

    // Display the form for adding a new room
    public function create()
    {
        return view('layout.AdminSekretariatView.KelolaRuangan', [
            'ruangan' => null,  // No room data for creation
        ]);
    }

    public function store(Request $request)
    {
        try {
            // Validasi input
            $request->validate([
                'nama' => 'required|string|max:255',
                'kapasitas' => 'required|integer|min:1',
                'deskripsi' => 'required|string',
                'fasilitas' => 'nullable|array',
                'fasilitas.*' => 'nullable|string|max:255',
                'gambar' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',  // Validasi gambar
                'kondisi' => 'required|in:baik,dalam_perbaikan',  // Validasi kondisi

            ]);

            // Menyimpan data ruangan ke database
            $ruangan = new Ruangan;
            $ruangan->nama = $request->input('nama');
            $ruangan->kapasitas = $request->input('kapasitas');
            $ruangan->deskripsi = $request->input('deskripsi');
            $ruangan->kondisi = $request->input('kondisi');

            // Menyimpan fasilitas jika ada
            if ($request->has('fasilitas')) {
                $ruangan->fasilitas = json_encode($request->input('fasilitas'));
            }

            if ($request->input('kondisi') === 'dalam_perbaikan') {
                $ruangan->status = 'tidak_dapat_dipinjam';  // Jika kondisi dalam perbaikan, status menjadi tidak dapat dipinjam
            }

            // Menyimpan gambar jika ada
            if ($request->hasFile('gambar')) {
                $image = $request->file('gambar');
                $imagePath = $image->store('ruangan_images', 'public');  // Menyimpan gambar di folder 'public/ruangan_images'
                $ruangan->gambar = $imagePath;  // Menyimpan path gambar ke kolom gambar
            }

            $ruangan->save();

            return redirect()->back()->with('success', 'Ruangan berhasil disimpan!');
        } catch (\Exception $e) {
            // Menangkap error dan mengirimkan pesan error
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function update(Request $request, Ruangan $ruangan)
    {
        try {
            // Validasi input
            $validated = $request->validate([
                'nama' => 'required|string|max:255',
                'kapasitas' => 'required|integer|min:1',
                'deskripsi' => 'required|string',
                'fasilitas' => 'nullable|array',
                'fasilitas.*' => 'nullable|string|max:255',
                'gambar' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',  // Validasi gambar
                'kondisi' => 'required|in:baik,dalam_perbaikan',  // Validasi kondisi
            ]);

            // Update data ruangan
            $ruangan->nama = $validated['nama'];
            $ruangan->kapasitas = $validated['kapasitas'];
            $ruangan->deskripsi = $validated['deskripsi'];
            $ruangan->kondisi = $validated['kondisi'];

            // Menyimpan fasilitas (update menjadi null jika kosong)
            if ($request->has('fasilitas') && !empty($validated['fasilitas'])) {
                $ruangan->fasilitas = json_encode($validated['fasilitas']);
            } else {
                $ruangan->fasilitas = null;
            }

            if ($request->input('kondisi') === 'dalam_perbaikan') {
                $ruangan->status = 'tidak_dapat_dipinjam';  // Jika kondisi dalam perbaikan, status menjadi tidak dapat dipinjam
            }

            // Menyimpan gambar jika ada dan mengganti gambar lama
            if ($request->hasFile('gambar')) {
                // Hapus gambar lama jika ada
                if ($ruangan->gambar) {
                    Storage::delete('public/' . $ruangan->gambar);
                }

                $image = $request->file('gambar');
                $imagePath = $image->store('ruangan_images', 'public');  // Menyimpan gambar di folder 'public/ruangan_images'
                $ruangan->gambar = $imagePath;  // Menyimpan path gambar ke kolom gambar
            }

            $ruangan->save();

            return redirect()->route('ruangan.edit', $ruangan->id)->with('success', 'Ruangan berhasil diperbarui.');
        } catch (\Exception $e) {
            // Menangkap error dan mengirimkan pesan error
            return redirect()->route('ruangan.edit', $ruangan->id)->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function destroy(Ruangan $ruangan)
    {
        try {
            // Menghapus ruangan dari database
            $ruangan->delete();

            // Mengarahkan kembali ke halaman daftar ruangan dengan pesan sukses
            return redirect()->back()->with('success', 'Ruangan berhasil dihapus.');
        } catch (\Exception $e) {
            // Menangkap error dan mengirimkan pesan error
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }



    public function edit(Ruangan $ruangan)
    {
        // Mengonversi fasilitas yang disimpan dalam JSON menjadi array
        $fasilitas = json_decode($ruangan->fasilitas, true); // Mengubah JSON menjadi array

        return view('layout.AdminSekretariatView.KelolaRuangan', [
            'ruangan' => $ruangan,  // Pass the existing room data
            'fasilitas' => $fasilitas,  // Pass the existing fasilitas data
        ]);
    }

    public function cekKetersediaanRuangan()
    {
        $room = Ruangan::where('kondisi', 'baik')->get();
        return view('layout.AdminSekretariatView.LihatKetersediaanRuangan', compact('room'));
    }
    public function lihatSemuaRuangan()
    {
        $ruangan = Ruangan::paginate(1000); // Ambil semua data asset dari database
        return view('layout.AdminSekretariatView.LihatSemuaRuangan', compact('ruangan'));
    }
}
