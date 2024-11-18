<!-- MenambahkanAsset.blade.php -->
@extends('layout.TemplateAdmin')

@section('title', isset($asset) ? 'Edit Asset' : 'Tambah Asset')

@section('content')
    <div class="container">
        <h2>Tambah Asset</h2>
        <form action="{{ isset($asset) ? route('asset.update', $asset->id) : route('asset.store') }}" method="POST"
            enctype="multipart/form-data">
            @csrf
            @if (isset($asset))
                @method('PUT')
            @endif

            <div class="mb-3">
                <label for="nama_barang" class="form-label">Nama Barang</label>
                <input type="text" class="form-control" id="nama_barang" name="nama_barang"
                    value="{{ old('nama_barang', $asset->nama_barang ?? '') }}" required>
            </div>

            <div class="mb-3">
                <label for="jenis_barang" class="form-label">Jenis Barang</label>
                <input type="text" class="form-control" id="jenis_barang" name="jenis_barang"
                    value="{{ old('jenis_barang', $asset->jenis_barang ?? '') }}" required>
            </div>

            <div class="mb-3">
                <label for="jumlah_barang" class="form-label">Jumlah Barang</label>
                <input type="number" class="form-control" id="jumlah_barang" name="jumlah_barang"
                    value="{{ old('jumlah_barang', $asset->jumlah_barang ?? '') }}" required>
            </div>

            <div class="mb-3">
                <label for="kondisi" class="form-label">Kondisi Barang</label>
                <input type="text" class="form-control" id="kondisi" name="kondisi"
                    value="{{ old('kondisi', $asset->kondisi ?? '') }}" required>
            </div>

            <div class="mb-3">
                <label for="deskripsi" class="form-label">Deskripsi Barang</label>
                <textarea class="form-control" id="deskripsi" name="deskripsi" rows="4" required>{{ old('deskripsi', $asset->deskripsi ?? '') }}</textarea>
            </div>

            <div class="mb-3">
                <label for="gambar" class="form-label">Gambar Barang</label>
                <input type="file" class="form-control" id="gambar" name="gambar" accept="image/*"
                    onchange="previewImage(event)">
                <div class="mt-2">
                    <p>Pratinjau Gambar:</p>
                    <img id="preview"
                        src="{{ isset($asset) && $asset->gambar ? asset('storage/' . $asset->gambar) : '' }}"
                        alt="Pratinjau Gambar"
                        style="width: 150px; height: auto; {{ isset($asset) && $asset->gambar ? 'display: block;' : 'display: none;' }}">
                </div>
            </div>
            <button type="submit" class="btn btn-primary">
                {{ isset($asset) ? 'Update Asset' : 'Tambah Asset' }}
            </button>
        </form>

    </div>
    <script>
        function previewImage(event) {
            const input = event.target;
            const preview = document.getElementById('preview');

            if (input.files && input.files[0]) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    preview.src = e.target.result; // Mengupdate gambar pratinjau
                    preview.style.display = 'block'; // Menampilkan pratinjau gambar jika sebelumnya disembunyikan
                };
                reader.readAsDataURL(input.files[0]);
            } else {
                preview.src = ''; // Menghapus src jika tidak ada file baru yang dipilih
                preview.style.display = 'none'; // Menyembunyikan pratinjau gambar
            }
        }
    </script>
@endsection
