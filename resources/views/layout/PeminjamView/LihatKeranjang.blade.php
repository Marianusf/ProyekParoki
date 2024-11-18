@extends('layout.TemplatePeminjam')

@section('content')
    <div class="container mx-auto py-8">
        <h2 class="text-2xl font-semibold mb-6">Keranjang Anda</h2>

        @if ($keranjangItems->isEmpty())
            <p class="text-gray-500">Keranjang Anda kosong.</p>
        @else
            <form action="{{ route('checkout') }}" method="POST">
                @csrf
                @foreach ($keranjangItems as $item)
                    <div class="border p-4 mb-4 rounded-md shadow-md">
                        <h4 class="text-lg font-semibold">{{ $item->asset->name }}</h4>
                        <p class="text-sm text-gray-600">Jumlah: {{ $item->jumlah }}</p>
                        <p class="text-sm text-gray-600">Tanggal Peminjaman:
                            {{ \Carbon\Carbon::parse($item->tanggal_peminjaman)->format('d M Y') }}</p>
                        <p class="text-sm text-gray-600">Tanggal Pengembalian:
                            {{ \Carbon\Carbon::parse($item->tanggal_pengembalian)->format('d M Y') }}</p>

                        <!-- Checkbox untuk memilih item -->
                        <div class="mt-2">
                            <input type="checkbox" name="selected_items[]" value="{{ $item->id }}">
                            <label for="selected_items" class="text-sm">Pilih untuk checkout</label>
                        </div>
                    </div>
                @endforeach

                <div class="mt-6">
                    <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">Proses
                        Checkout</button>
                </div>
            </form>
        @endif
    </div>
@endsection
