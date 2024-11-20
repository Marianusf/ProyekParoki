@extends('layout.TemplatePeminjam')

@section('title', 'Pengembalian')

@section('content')
<div class="py-8 px-4 mx-auto max-w-7xl lg:py-8 rounded-lg bg-gray-100">
    <h2 class="mb-6 text-2xl font-bold">Tambah Aset Baru</h2>
    <form action="#" class="">
        <div class="grid gap-4 sm:grid-cols-2 sm:gap-6">
            <div class="sm:col-span-1">
                <label for="nama" class="block mb-2 text-sm font-medium">Nama Aset</label>
                <input type="text" name="nama" id="nama" class="bg-gray-50 border border-gray-300 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5" placeholder="Masukkan nama aset" required>
            </div>

            <div class="sm:col-span-2 md:col-span-2">
                <label for="lokasi" class="block mb-2 text-sm font-medium ">Lokasi</label>
                <input type="text" name="lokasi" id="lokasi" class="bg-gray-50 border border-gray-300 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 sm:w-96" placeholder="Masukkan lokasi aset" required>
            </div>

            <div class="sm:col-span-1">
                <label for="jenis" class="block mb-2 text-sm font-medium ">Jenis aset</label>
                <select id="jenis" class="bg-gray-50 border border-gray-300 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5">
                    <option selected>Pilih jenis aset</option>
                    <option value="Alat">Alat</option>
                    <option value="Ruangan">Ruangan</option>
                </select>
            </div>
            <div class="sm:col-span-1">
                <label for="jumlah" class="block mb-2 text-sm font-medium">Jumlah</label>
                <input type="number" name="jumlah" id="jumlah" class="bg-gray-50 border border-gray-300 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-min p-2.5" placeholder="12" required>
            </div>

            <div class="sm:col-span-1 md:col-span-1">
                <label for="gambar" class="block mb-2 text-sm font-medium ">Unggah Gambar</label>
                <input type="file" name="gambar" id="gambar" class="bg-gray-50 border border-gray-300 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5" placeholder="Tidak ada file dipilih" required>
            </div>

            <div class="sm:col-span-2">
                <label for="deskripsi" class="block mb-2 text-sm font-medium ">Deskripsi</label>
                <textarea id="deskripsi" rows="8" class="block p-2.5 w-full text-sm bg-gray-50 rounded-lg border border-gray-300 focus:ring-primary-500 focus:border-primary-500" placeholder="Masukkan deskripsi aset"></textarea>
            </div>
        </div>
        
        <div>
            <button type="submit" class="bg-blue-600 border h-9 border-gray-300 text-white inline-flex items-center px-5 py-2.5 mt-4 sm:mt-4 text-sm font-medium text-center rounded-lg focus:ring-4 focus:ring-primary-200 hover:bg-primary-800">
                Tambahkan Aset
            </button>
            <button type="submit" class="bg-red-600 border h-9 border-gray-300 text-white inline-flex items-center px-5 py-2.5 mt-4 sm:mt-4 first-line:text-sm font-medium text-center rounded-lg focus:ring-4 focus:ring-primary-200 hover:bg-primary-800">
                Batal
            </button>
        </div>
    </form>
</div>
@endsection