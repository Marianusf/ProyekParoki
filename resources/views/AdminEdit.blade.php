@extends('layout.TemplatePeminjam')
@section('title', 'Input')
@section('content')

<script src="https://cdn.tailwindcss.com"></script>

<style>
    .card {
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        background: #f3f4f6;
        background-image: linear-gradient(45deg, rgba(255, 255, 255, 0.15) 25%, transparent 25%, transparent 50%, rgba(255, 255, 255, 0.15) 50%, rgba(255, 255, 255, 0.15) 75%, transparent 75%, transparent);
        background-size: 40px 40px;
    }

    .card:hover {
        transform: translateY(-10px);
        box-shadow: 0 12px 25px rgba(0, 0, 0, 0.3);
    }
</style>

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">

<section class="p-6 bg-blue-600 min-h-screen">
<body class="bg-gray-100 p-6">
    <div class="max-w-3xl mx-auto bg-white p-8 rounded-lg shadow-lg">
        <h1 class="text-2xl font-bold text-center mb-6">Tambah Aset Barang dan Ruang Gereja</h1>

        <!-- Tambah Aset Form -->
        <form action="#" method="POST">
            <!-- Nama Barang -->
            <div class="mb-4">
                <label for="nama_barang" class="block text-gray-700 font-semibold mb-2">Nama Barang</label>
                <input type="text" id="nama_barang" name="nama_barang" class="w-full p-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="Nama Barang" required>
            </div>

            <!-- Kategori Barang -->
            <div class="mb-4">
                <label for="kategori_barang" class="block text-gray-700 font-semibold mb-2">Kategori Barang</label>
                <select id="kategori_barang" name="kategori_barang" class="w-full p-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                    <option value="">Pilih Kategori</option>
                    <option value="elektronik">Elektronik</option>
                    <option value="furniture">Furniture</option>
                    <option value="alat_ibadah">Alat Ibadah</option>
                    <!-- Tambahkan kategori lainnya sesuai kebutuhan -->
                </select>
            </div>

            <!-- Kondisi Barang -->
            <div class="mb-4">
                <label for="kondisi_barang" class="block text-gray-700 font-semibold mb-2">Kondisi Barang</label>
                <select id="kondisi_barang" name="kondisi_barang" class="w-full p-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                    <option value="">Pilih Kondisi</option>
                    <option value="baik">Baik</option>
                    <option value="rusak">Rusak</option>
                    <option value="perlu_perbaikan">Perlu Perbaikan</option>
                    <!-- Tambahkan kondisi lainnya sesuai kebutuhan -->
                </select>
            </div>

            <!-- Lokasi Ruang -->
            <div class="mb-4">
                <label for="lokasi_ruang" class="block text-gray-700 font-semibold mb-2">Lokasi Ruang</label>
                <input type="text" id="lokasi_ruang" name="lokasi_ruang" class="w-full p-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="Nama Ruang" required>
            </div>

            <!-- Jumlah Barang -->
            <div class="mb-4">
                <label for="jumlah_barang" class="block text-gray-700 font-semibold mb-2">Jumlah Barang</label>
                <input type="number" id="jumlah_barang" name="jumlah_barang" class="w-full p-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="Jumlah Barang" required min="1">
            </div>

            <!-- Deskripsi -->
            <div class="mb-4">
                <label for="deskripsi" class="block text-gray-700 font-semibold mb-2">Deskripsi</label>
                <textarea id="deskripsi" name="deskripsi" rows="4" class="w-full p-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="Deskripsi aset..."></textarea>
            </div>

            <!-- Tombol Tambah -->
             
            <div class="flex justify-between">
    <button type="submit" class="bg-green-500 hover:bg-green-600 text-white font-semibold py-2 px-4 rounded-lg transition duration-200">Reset</button>
    <button type="submit" class="bg-green-500 hover:bg-green-600 text-white font-semibold py-2 px-4 rounded-lg transition duration-200">Tambah Aset</button>
</div>

        </form>
    </div>
</body>
</html>
