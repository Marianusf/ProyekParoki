<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AlatMisa;

class AlatMisaController extends Controller
{
    // Menampilkan daftar alat misa (index)
    public function index()
    {
        $alatMisa = AlatMisa::paginate(10); // Ambil data alat misa dengan paginasi
        return view('layout.AdminParamentaView.LihatAlatMisa', compact('alatMisa'));
    }

    // Menampilkan form untuk menambahkan alat misa
    public function create()
    {
        return view('layout.AdminParamentaView.TambahEditAlatMisa');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_alat' => 'required|string|max:255',
            'jenis_alat' => 'required|string|max:255',
            'jumlah' => 'required|integer|min:1',
            'kondisi' => 'required|string',
            'deskripsi' => 'required|string',
            'detail_alat' => 'nullable|array',
            'detail_alat.*.nama_detail' => 'required|string|max:255',
            'detail_alat.*.jumlah' => 'required|integer|min:1',
            'gambar' => 'nullable|image|mimes:jpg,jpeg,png,gif|max:2048',
        ], [
            'nama_alat.required' => 'Nama alat harus diisi.',
            'nama_alat.max' => 'Nama alat tidak boleh lebih dari 255 karakter.',
            'jenis_alat.required' => 'Jenis alat harus dipilih.',
            'jumlah.required' => 'Jumlah alat harus diisi.',
            'jumlah.integer' => 'Jumlah alat harus berupa angka.',
            'jumlah.min' => 'Jumlah alat minimal 1.',
            'kondisi.required' => 'Kondisi alat harus dipilih.',
            'deskripsi.string' => 'Deskripsi harus berupa teks.',
            'deskripsi.required' => 'Deskripsi harus diisi (jika tidak ada silahkan kasih -).',
            'detail_alat.*.nama_detail.required' => 'Nama detail pada setiap item wajib diisi.',
            'detail_alat.*.nama_detail.max' => 'Nama detail tidak boleh lebih dari 255 karakter.',
            'detail_alat.*.jumlah.required' => 'Jumlah pada setiap detail wajib diisi.',
            'detail_alat.*.jumlah.integer' => 'Jumlah detail harus berupa angka.',
            'detail_alat.*.jumlah.min' => 'Jumlah detail minimal 1.',
            'gambar.image' => 'File gambar harus berupa gambar dengan format jpg, jpeg, png, atau gif.',
            'gambar.mimes' => 'Format gambar hanya boleh jpg, jpeg, png, atau gif.',
            'gambar.max' => 'Ukuran gambar tidak boleh lebih dari 2MB.',
        ]);

        // Simpan gambar jika ada
        $gambarPath = $request->hasFile('gambar')
            ? $request->file('gambar')->store('alat_misa/images', 'public')
            : null;
        $detailAlat = $request->has('detail_alat') ? $request->input('detail_alat') : null;

        AlatMisa::create([
            'nama_alat' => $validated['nama_alat'],
            'jenis_alat' => $validated['jenis_alat'],
            'deskripsi' => $validated['deskripsi'],
            'detail_alat' => $detailAlat, // Simpan langsung sebagai array
            'jumlah' => $validated['jumlah'],
            'kondisi' => $validated['kondisi'],
            'gambar' => $gambarPath,
        ]);


        return redirect()->route('alat_misa.index')->with('success', 'Alat misa berhasil ditambahkan!');
    }

    // Menampilkan form untuk mengedit alat misa
    public function edit($id)
    {

        $alatMisa = AlatMisa::findOrFail($id);

        return view('layout.AdminParamentaView.TambahEditAlatMisa', compact('alatMisa'));
    }


    public function update(Request $request, $id)
    {
        $alatMisa = AlatMisa::findOrFail($id);
        // Validasi Input
        // dd($request->all());

        $validated = $request->validate([
            'nama_alat' => 'required|string|max:255',
            'jenis_alat' => 'required|string|max:255',
            'jumlah' => 'required|integer|min:1',
            'kondisi' => 'required|string',
            'deskripsi' => 'required|string',
            'detail_alat' => 'nullable|array',
            'detail_alat.*.nama_detail' => 'required|string|max:255',
            'detail_alat.*.jumlah' => 'required|integer|min:1',
            'gambar' => 'nullable|image|mimes:jpg,jpeg,png,gif|max:2048',
        ], [
            'nama_alat.required' => 'Nama alat harus diisi.',
            'nama_alat.max' => 'Nama alat tidak boleh lebih dari 255 karakter.',
            'jenis_alat.required' => 'Jenis alat harus dipilih.',
            'jumlah.required' => 'Jumlah alat harus diisi.',
            'jumlah.integer' => 'Jumlah alat harus berupa angka.',
            'jumlah.min' => 'Jumlah alat minimal 1.',
            'kondisi.required' => 'Kondisi alat harus dipilih.',
            'deskripsi.required' => 'Deskripsi harus diisi (jika tidak ada silahkan kasih -).',
            'deskripsi.string' => 'Deskripsi harus berupa teks.',
            'detail_alat.*.nama_detail.required' => 'Nama detail pada setiap item wajib diisi.',
            'detail_alat.*.nama_detail.max' => 'Nama detail tidak boleh lebih dari 255 karakter.',
            'detail_alat.*.jumlah.required' => 'Jumlah pada setiap detail wajib diisi.',
            'detail_alat.*.jumlah.integer' => 'Jumlah detail harus berupa angka.',
            'detail_alat.*.jumlah.min' => 'Jumlah detail minimal 1.',
            'gambar.image' => 'File gambar harus berupa gambar dengan format jpg, jpeg, png, atau gif.',
            'gambar.mimes' => 'Format gambar hanya boleh jpg, jpeg, png, atau gif.',
            'gambar.max' => 'Ukuran gambar tidak boleh lebih dari 2MB.',
        ]);

        if ($request->hasFile('gambar')) {
            if ($alatMisa->gambar && file_exists(public_path('storage/' . $alatMisa->gambar))) {
                unlink(public_path('storage/' . $alatMisa->gambar));
            }
            $gambarPath = $request->file('gambar')->store('alat_misa/images', 'public');
        } else {
            $gambarPath = $alatMisa->gambar;
        }
        $detailAlat = $request->has('detail_alat') ? $request->input('detail_alat') : $alatMisa->detail_alat;

        $alatMisa->update([
            'nama_alat' => $validated['nama_alat'],
            'jenis_alat' => $validated['jenis_alat'],
            'deskripsi' => $validated['deskripsi'],
            'detail_alat' => $detailAlat, // Simpan langsung sebagai array
            'jumlah' => $validated['jumlah'],
            'kondisi' => $validated['kondisi'],
            'gambar' => $gambarPath,
        ]);




        return redirect()->route('alat_misa.index')->with('success', 'Alat misa berhasil diperbarui!');
    }

    // Menghapus data alat misa
    public function destroy($id)
    {
        $alatMisa = AlatMisa::findOrFail($id);

        // Hapus gambar jika ada
        if ($alatMisa->gambar && file_exists(public_path('storage/' . $alatMisa->gambar))) {
            unlink(public_path('storage/' . $alatMisa->gambar));
        }

        // Hapus data dari database
        $alatMisa->delete();

        return redirect()->route('alat_misa.index')->with('success', 'Alat misa berhasil dihapus!');
    }

    // Menampilkan alat misa dengan kondisi "baik" untuk pengguna peminjam
    public function cekKetersediaan()
    {
        $alatMisa = AlatMisa::where('kondisi', 'baik')->get();
        return view('layout.PeminjamView.LihatKetersediaanAlatMisa', compact('alatMisa'));
    }
}
