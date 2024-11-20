@extends('layout.TemplateAdmin')

@section('title', isset($asset) ? 'Edit Asset' : 'Tambah Asset')

@section('content')
<div class="py-8 px-4 mx-auto max-w-7xl lg:py-8 rounded-lg bg-gray-100">
    <h2 class="mb-6 text-2xl font-bold">{{ isset($asset) ? 'Edit Aset' : 'Tambah Aset Baru' }}</h2>
    <form action="{{ isset($asset) ? route('asset.update', $asset->id) : route('asset.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        @if (isset($asset))
            @method('PUT')
        @endif

        <div class="grid gap-4 sm:grid-cols-2 sm:gap-6">
            <div class="sm:col-span-1">
                <label for="nama_barang" class="block mb-2 text-sm font-medium">Nama Barang</label>
                <input type="text" class="bg-gray-50 border border-gray-300 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5" id="nama_barang" name="nama_barang" value="{{ old('nama_barang', $asset->nama_barang ?? '') }}" required>
            </div>

            <div class="sm:col-span-1">
                <label for="jenis_barang" class="block mb-2 text-sm font-medium">Jenis Barang</label>
                <input type="text" class="bg-gray-50 border border-gray-300 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5" id="jenis_barang" name="jenis_barang" value="{{ old('jenis_barang', $asset->jenis_barang ?? '') }}" required>
            </div>

            <div class="sm:col-span-1">
                <label for="jumlah_barang" class="block mb-2 text-sm font-medium">Jumlah Barang</label>
                <input type="number" class="bg-gray-50 border border-gray-300 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5" id="jumlah_barang" name="jumlah_barang" value="{{ old('jumlah_barang', $asset->jumlah_barang ?? '') }}" required>
            </div>

            <div class="sm:col-span-1">
                <label for="kondisi" class="block mb-2 text-sm font-medium">Kondisi Barang</label>
                <input type="text" class="bg-gray-50 border border-gray-300 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5" id="kondisi" name="kondisi" value="{{ old('kondisi', $asset->kondisi ?? '') }}" required>
            </div>

            <div class="sm:col-span-2">
                <label for="deskripsi" class="block mb-2 text-sm font-medium">Deskripsi Barang</label>
                <textarea id="deskripsi" name="deskripsi" rows="8" class="block p-2.5 w-full text-sm bg-gray-50 rounded-lg border border-gray-300 focus:ring-primary-500 focus:border-primary-500" placeholder="Masukkan deskripsi aset">{{ old('deskripsi', $asset->deskripsi ?? '') }}</textarea>
            </div>

            <div class="sm:col-span-2">
                <label for="gambar" class="block mb-2 text-sm font-medium">Unggah Gambar</label>
                <input type="file" class="bg-gray-50 border border-gray-300 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5" id="gambar" name="gambar" accept="image/*" onchange="previewImage(event)">
                <div class="mt-2">
                    <p>Pratinjau Gambar:</p>
                    <img id="preview" src="{{ isset($asset) && $asset->gambar ? asset('storage/' . $asset->gambar) : '' }}" alt="Pratinjau Gambar" style="width: 150px; height: auto; {{ isset($asset) && $asset->gambar ? 'display: block;' : 'display: none;' }}">
                </div>
            </div>
        </div>
        
        <div class="mt-4">
            <button type="submit" class="bg-blue-600 border h-9 border-gray-300 text-white inline-flex items-center px-5 py-2.5 text-sm font-medium text-center rounded-lg focus:ring-4 focus:ring-primary-200 hover:bg-primary-800">
                {{ isset($asset) ? 'Update Asset' : 'Tambah Asset' }}
            </button>
        </div>
    </form>
</div>
<script>
    function previewImage(event) {
        const input = event.target;
        const preview = document.getElementById('preview');

        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                preview.src = e.target.result;
                preview.style.display = 'block';
            };
            reader.readAsDataURL(input.files[0]);
        } else {
            preview.src = '';
            preview.style.display = 'none';
        }
    }
</script>
@endsection
