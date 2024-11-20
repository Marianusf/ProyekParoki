@extends('layout.TemplatePeminjam')
@section('title', 'Keranjang')
@section('content')

<div class="max-w-3xl mx-auto p-4 bg-gray-100 rounded-md">
    <h2 class="text-2xl font-medium mb-6">Keranjang Peminjaman</h2>
    <div class="space-y-6">
        <div class="flex items-center bg-white p-4 rounded-lg shadow-md">
            <img src="https://via.placeholder.com/100" alt="Item Image" class="w-14 h-14 sm:w-20 sm:h-20 rounded object-cover">
            <div class="ml-4 flex-1 text-xs sm:text-sm">
                <h3 class="text-lg font-semibold">Proyektor</h3>
                <p class="text-gray-500">Kategori: Barang</p>
            </div>
            <div class="flex items-center">
                <input type="number" value="1" class="w-10 h-8 sm:w-12 sm:h-10 p-2 border rounded-lg text-center mr-4">
                <button class="text-red-600 hover:text-red-800 font-medium">Hapus</button>
            </div>
        </div>
        
        <div class="flex items-center bg-white p-4 rounded-lg shadow-md">
            <img src="https://via.placeholder.com/100" alt="Item Image" class="w-14 h-14 sm:w-20 sm:h-20 rounded object-cover">
            <div class="ml-4 flex-1 text-xs sm:text-sm">
                <h3 class="text-lg font-semibold">Ruangan 1</h3>
                <p class="text-gray-500">Kategori: Ruangan</p>
            </div>
            <div class="flex items-center">
                <input type="number" value=" " class="w-10 h-8 sm:text-sm sm:w-12 sm:h-10 p-2 border rounded-lg text-center mr-4" disabled>
                <button class="text-red-600 hover:text-red-800 font-medium">Hapus</button>
            </div>
        </div>
    </div>
    
    <div class="mt-6 flex justify-end text-xs sm:text-sm">
        <button class="bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700">Ajukan Peminjaman</button>
    </div>
</div>

@endsection
