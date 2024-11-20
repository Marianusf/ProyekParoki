@extends('layout.TemplatePeminjam')

@section('content')
    <div class="container mx-auto py-8">
        <h2 class="text-2xl font-semibold mb-6">Form Peminjaman</h2>

        <!-- Menampilkan notifikasi sukses jika ada -->
        @if (session('success'))
            <div class="bg-green-500 text-white p-4 rounded-md mb-4">
                {{ session('success') }}
            </div>
        @endif

        <form action="{{ route('keranjang.tambah') }}" method="POST">
            @csrf

            <!-- Pilih Asset -->
            <div class="mb-4">
                <label for="id_asset" class="block text-sm font-medium text-gray-700">Pilih Asset</label>
                <select id="id_asset" name="id_asset" class="mt-1 block w-full" required>
                    @foreach ($asset as $asset)
                        <option value="{{ $asset->id }}">{{ $asset->nama_barang }} - {{ $asset->deskripsi }}</option>
                    @endforeach
                </select>
                @error('id_asset')
                    <!-- pastikan 'id_asset' sesuai dengan validasi -->
                    <p class="text-red-500 text-xs mt-2">{{ $message }}</p>
                @enderror
            </div>

            <!-- Jumlah Asset -->
            <div class="mb-4">
                <label for="jumlah" class="block text-sm font-medium text-gray-700">Jumlah</label>
                <input type="number" id="jumlah" name="jumlah" class="mt-1 block w-full" required min="1"
                    max="{{ $asset->stok }}">
                @error('jumlah')
                    <p class="text-red-500 text-xs mt-2">{{ $message }}</p>
                @enderror
            </div>
            <p class="text-sm text-gray-600">Stok tersedia: {{ $asset->jumlah_barang - $asset->jumlah_terpinjam }}</p>
            <!-- Tanggal Pinjam -->
            <div class="mb-4">
                <label for="tanggal_peminjaman" class="block text-sm font-medium text-gray-700">Tanggal Pinjam</label>
                <input type="date" id="tanggal_peminjaman" name="tanggal_peminjaman" class="mt-1 block w-full" required>
                @error('tanggal_peminjaman')
                    <p class="text-red-500 text-xs mt-2">{{ $message }}</p>
                @enderror
            </div>

            <!-- Tanggal Kembali -->
            <div class="mb-4">
                <label for="tanggal_pengembalian" class="block text-sm font-medium text-gray-700">Tanggal Kembali</label>
                <input type="date" id="tanggal_pengembalian" name="tanggal_pengembalian" class="mt-1 block w-full"
                    required>
                @error('tanggal_pengembalian')
                    <p class="text-red-500 text-xs mt-2">{{ $message }}</p>
                @enderror
            </div>

            <!-- Submit Button -->
            <div class="mb-4">
                <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">Tambah ke
                    Keranjang</button>
            </div>
        </form>
    </div>
@endsection
