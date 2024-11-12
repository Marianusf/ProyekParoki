<?php

namespace App\Http\Controllers;

use App\Models\Asset;
use Illuminate\Http\Request;

class AssetController extends Controller
{
    // Menampilkan form untuk menambahkan asset
    public function create()
    {
        return view('layout.AdminView.MenambahkanAsset'); // Pastikan path view benar
    }

    // Menyimpan asset ke database
    public function store(Request $request)
    {
        // Validasi data yang diterima
        $request->validate([
            'nama_barang' => 'required|string|max:255',
            'jenis_barang' => 'required|string|max:255',
            'jumlah_barang' => 'required|integer',
            'kondisi' => 'required|string|max:255',
            'gambar' => 'nullable|image|mimes:jpg,jpeg,png,gif|max:2048',
        ]);

        // Menyimpan gambar
        if ($request->hasFile('gambar')) {
            $gambarPath = $request->file('gambar')->store('assets/images', 'public');
        } else {
            $gambarPath = null;
        }

        // Menyimpan data ke database
        Asset::create([
            'nama_barang' => $request->nama_barang,
            'jenis_barang' => $request->jenis_barang,
            'jumlah_barang' => $request->jumlah_barang,
            'kondisi' => $request->kondisi,
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

    public function destroy($id)
    {
        $asset = Asset::findOrFail($id);
        $asset->delete();

        return redirect()->route('asset.index')->with('success', 'Asset berhasil dihapus!');
    }
}
