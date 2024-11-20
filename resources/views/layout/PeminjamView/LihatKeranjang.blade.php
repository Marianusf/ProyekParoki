@extends('layout.TemplatePeminjam')
@section('title', 'Keranjang')
@section('content')

<div class="max-w-3xl mx-auto p-4 bg-gray-100 rounded-md">
    <h2 class="text-2xl font-medium mb-6">Keranjang Peminjaman</h2>
    
    @if ($keranjangItems->isEmpty())
        <p class="text-gray-500 text-center">Keranjang Anda kosong.</p>
    @else
        <div class="space-y-6">
            @foreach ($keranjangItems as $item)
                <div class="flex items-center bg-white p-4 rounded-lg shadow-md">
                    <!-- Placeholder untuk gambar -->
                    <img src="{{ $item->asset->gambar ?? 'https://via.placeholder.com/100' }}" 
                         alt="Gambar {{ 'storage/' . $item->asset->gambar }}" 
                         class="w-14 h-14 sm:w-20 sm:h-20 rounded object-cover">
                    
                    <!-- Detail item -->
                    <div class="ml-4 flex-1 text-xs sm:text-sm">
                        <h3 class="text-lg font-semibold">{{ $item->asset->nama_barang }}</h3>
                        <p class="text-gray-500">Jumlah: {{ $item->jumlah }}</p>
                        <p class="text-gray-500">Tanggal Peminjaman: {{ \Carbon\Carbon::parse($item->tanggal_peminjaman)->format('d M Y') }}</p>
                        <p class="text-gray-500">Tanggal Pengembalian: {{ \Carbon\Carbon::parse($item->tanggal_pengembalian)->format('d M Y') }}</p>
                    </div>
                    <div class="flex items-center">
                        <input type="checkbox" name="selected_items[]" value="{{ $item->id }}" 
                               class="mr-4 w-4 h-4 sm:w-5 sm:h-5">
                    </div>
                </div>
            @endforeach
        </div>
        
        <div class="mt-6 flex justify-end text-xs sm:text-sm">
            <form action="{{ route('checkout') }}" method="POST">
                @csrf
                <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700">
                    Ajukan Peminjaman
                </button>
            </form>
        </div>
    @endif
</div>

<script>
    function handleRemoveItem(url) {
        if (confirm('Apakah Anda yakin ingin menghapus item ini dari keranjang?')) {
            window.location.href = url;
        }
    }
</script>

@endsection
