@extends('layout.TemplateAdmin')

@section('title', 'Ketersediaan Asset')

@section('content')
    <div class="container mx-auto py-8">
        <h2 class="text-2xl font-semibold mb-6">Daftar Ketersediaan Asset</h2>

        <!-- Notifikasi sukses jika ada -->
        @if (session('success'))
            <div class="bg-green-500 text-white p-4 rounded-md mb-4">
                {{ session('success') }}
            </div>
        @endif
        <div class="mb-4 text-right">
            <a href="{{ route('asset.create') }}" class="bg-blue-500 text-white px-4 py-2 rounded-md hover:bg-blue-600">
                Tambah Asset Baru
            </a>
        </div>
        <!-- Tabel Ketersediaan Asset -->
        <div class="overflow-x-auto bg-white shadow-md rounded-md mb-6">
            <table class="min-w-full table-auto">
                <thead>
                    <tr class="bg-gray-100 text-left text-sm text-gray-600">
                        <th class="px-6 py-3">Nama Barang</th>
                        <th class="px-6 py-3">Jenis Barang</th>
                        <th class="px-6 py-3">Jumlah Tersedia</th>
                        <th class="px-6 py-3">Status</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($assets as $asset)
                        <tr class="border-b">
                            <td class="px-6 py-4 text-sm text-gray-800">{{ $asset->nama_barang }}</td>
                            <td class="px-6 py-4 text-sm text-gray-800">{{ $asset->jenis_barang }}</td>
                            <td class="px-6 py-4 text-sm text-gray-800">{{ $asset->stok_tersedia }}</td>
                            <td class="px-6 py-4 text-sm">
                                @if ($asset->stok_tersedia > 0)
                                    <span class="bg-green-500 text-white px-2 py-1 rounded-full text-xs">Tersedia</span>
                                @else
                                    <span class="bg-red-500 text-white px-2 py-1 rounded-full text-xs">Habis</span>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Tombol untuk menambah asset baru -->

    </div>
@endsection
