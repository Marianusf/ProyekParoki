@extends('layout.TemplatePeminjam')

@section('title', 'Pengembalian')

@section('content')
<div class="max-w-3xl mx-auto p-4 bg-gray-100 rounded-md">
    <!-- Header -->
    <h1 class="text-2xl font-semibold mb-4">Pengembalian</h1>
    
    {{-- <!-- Search bar -->
    <div class="flex items-center mb-4 bg-white rounded-md shadow">
        <input
            type="text"
            placeholder="Cari"
            class="w-full p-2 border-none focus:outline-none rounded-l-md"
        />
        <button class="p-2 text-gray-400">
            <!-- Icon pencarian, bisa diganti dengan SVG atau icon dari fontawesome -->
            <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-4.35-4.35M16.64 11.64a5.64 5.64 0 11-11.28 0 5.64 5.64 0 0111.28 0z"/>
            </svg>
        </button>
    </div> --}}

    <div class="text-blue-500 font-semibold mb-2">Sedang berlangsung</div>
    
    <div class="flex items-center bg-white shadow rounded-md p-4">
        <div class="flex-1">
            <div class="text-sm sm:text-base font-medium">Barang 1</div>
            <div class="text-xs sm:text-sm text-gray-500">1 Oktober 2024</div>
            <div class="text-xs sm:text-sm text-gray-500">10.00 WIB</div>
        </div>
        <button class="bg-green-500 text-white px-4 py-2 rounded-md text-sm font-semibold">
            Ajukan Pengembalian
        </button>
        <button class="ml-2 text-gray-400">
            <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v.01M12 12v.01M12 18v.01"/>
            </svg>
        </button>
    </div>
</div>

@endsection