<?php

namespace App\Http\Controllers;

use App\Models\Asset;
use Illuminate\Http\Request;

class AssetController extends Controller
{
    public function cekKetersediaanAsset()
    {
        $assets = Asset::where('kondisi', 'baik')->get();
        return view('layout.AdminView.LihatKetersediaan', compact('assets'));
    }

    // Menampilkan form untuk menambahkan asset
    public function create()
    {
        return view('layout.AdminView.MenambahkanAsset'); // Pastikan path view benar
    }

    public function store(Request $request)
    {
        // Validasi data yang diterima
        $request->validate([
            'nama_barang' => 'required|string|max:255',
            'jenis_barang' => 'required|string|max:255',
            'jumlah_barang' => 'required|integer',
            'kondisi' => 'required|string|max:255',
            'deskripsi' => 'required|string|max:255',
            'gambar' => 'nullable|image|mimes:jpg,jpeg,png,gif|max:2048',
        ]);

        // Menyimpan gambar ke folder 'public/assets/images'
        // Pastikan gambar disimpan hanya sekali dalam folder 'assets/images'
        if ($request->hasFile('gambar')) {
            $gambarPath = $request->file('gambar')->store('storage/assets/images', 'public');
        } else {
            $gambarPath = null;
        }


        // Menyimpan data ke database
        Asset::create([
            'nama_barang' => $request->nama_barang,
            'jenis_barang' => $request->jenis_barang,
            'jumlah_barang' => $request->jumlah_barang,
            'kondisi' => $request->kondisi,
            'deskripsi' => $request->deskripsi,
            'gambar' => $gambarPath,
        ]);

        return redirect()->route('asset.index')->with('success', 'Asset berhasil ditambahkan!');
    }


    // Menampilkan daftar asset
    public function index()
    {
        $assets = Asset::paginate(10); // Ambil semua data asset dari database
        return view('layout.AdminView.AdminLihatAsset', compact('assets'));
    }
    public function edit($id)
    {
        $asset = Asset::findOrFail($id);
        return view('layout.AdminView.MenambahkanAsset', compact('asset'));
    }
    public function update(Request $request, $id)
    {
        $asset = Asset::findOrFail($id);

        // Validasi data yang diterima
        $request->validate([
            'nama_barang' => 'required|string|max:255',
            'jenis_barang' => 'required|string|max:255',
            'jumlah_barang' => 'required|integer',
            'kondisi' => 'required|string|max:255',
            'deskripsi' => 'required|string|max:255',
            'gambar' => 'nullable|image|mimes:jpg,jpeg,png,gif|max:2048',
        ]);

        // Jika ada file baru, simpan dan hapus file lama
        if ($request->hasFile('gambar')) {
            // Hapus gambar lama jika ada
            if ($asset->gambar && file_exists(public_path('storage/' . $asset->gambar))) {
                unlink(public_path('storage/' . $asset->gambar));
            }

            // Simpan gambar baru
            $gambarPath = $request->file('gambar')->store('assets/images', 'public');
        } else {
            // Pertahankan gambar lama jika tidak ada file baru
            $gambarPath = $asset->gambar;
        }

        // Memperbarui data di database
        $asset->update([
            'nama_barang' => $request->nama_barang,
            'jenis_barang' => $request->jenis_barang,
            'jumlah_barang' => $request->jumlah_barang,
            'kondisi' => $request->kondisi,
            'deskripsi' => $request->deskripsi,
            'gambar' => $gambarPath,
        ]);

        return redirect()->route('asset.index')->with('success', 'Asset berhasil diperbarui!');
    }


    public function destroy($id)
    {
        $asset = Asset::findOrFail($id);
        $asset->delete();

        return redirect()->route('asset.index')->with('success', 'Asset berhasil dihapus!');
    }
    public function peminjamLihatKetersediaanAsset()
    {
        $assets = Asset::where('kondisi', 'baik')->get();
        return view('layout.PeminjamView.LihatKetersediaan', compact('assets'));
    }
}
