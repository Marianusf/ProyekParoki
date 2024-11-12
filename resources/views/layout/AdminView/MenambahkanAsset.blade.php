<!-- MenambahkanAsset.blade.php -->
@extends('layout.TemplateAdmin') <!-- Pastikan layout yang dipakai sesuai -->

@section('content')
    <div class="container">
        <h2>Tambah Asset</h2>
        <form action="{{ route('asset.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="mb-3">
                <label for="nama_barang" class="form-label">Nama Barang</label>
                <input type="text" class="form-control" id="nama_barang" name="nama_barang" required>
            </div>

            <div class="mb-3">
                <label for="jenis_barang" class="form-label">Jenis Barang</label>
                <input type="text" class="form-control" id="jenis_barang" name="jenis_barang" required>
            </div>

            <div class="mb-3">
                <label for="jumlah_barang" class="form-label">Jumlah Barang</label>
                <input type="number" class="form-control" id="jumlah_barang" name="jumlah_barang" required>
            </div>

            <div class="mb-3">
                <label for="kondisi" class="form-label">Kondisi Barang</label>
                <input type="text" class="form-control" id="kondisi" name="kondisi" required>
            </div>

            <div class="mb-3">
                <label for="gambar" class="form-label">Gambar Barang</label>
                <input type="file" class="form-control" id="gambar" name="gambar">
            </div>

            <button type="submit" class="btn btn-primary">Tambah Asset</button>
        </form>
    </div>
@endsection
