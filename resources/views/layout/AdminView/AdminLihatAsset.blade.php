@extends('layout.TemplateAdmin')

@section('title', 'Daftar Asset')

@section('content')
    <section class="p-6 bg-blue-100 min-h-screen">
        <div class="container mx-auto">
            <h2 class="text-2xl font-semibold text-gray-700 mb-4">Daftar Asset</h2>

            @if (session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                    <strong class="font-bold">Informasi: </strong>
                    <span class="block sm:inline">{{ session('success') }}</span>
                </div>
            @endif
            <div class="overflow-x-auto">
                <table class="min-w-full bg-white border border-gray-200 rounded-lg">
                    <thead>
                        <tr class="w-full bg-blue-600 text-white uppercase text-sm leading-normal">
                            <th class="py-3 px-6 text-left">Nama Barang</th>
                            <th class="py-3 px-6 text-left">Jenis Barang</th>
                            <th class="py-3 px-6 text-left">Jumlah Barang</th>
                            <th class="py-3 px-6 text-left">Kondisi</th>
                            <th class="py-3 px-6 text-left">Gambar</th>
                            <th class="py-3 px-6 text-left">Tanggal Ditambahkan</th>
                            <th class="py-3 px-6 text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="text-gray-700 text-sm font-light">
                        @foreach ($assets as $asset)
                            <tr class="border-b border-gray-200 hover:bg-gray-100">
                                <td class="py-3 px-6 text-left">{{ $asset->nama_barang }}</td>
                                <td class="py-3 px-6 text-left">{{ $asset->jenis_barang }}</td>
                                <td class="py-3 px-6 text-left">{{ $asset->jumlah_barang }}</td>
                                <td class="py-3 px-6 text-left">{{ $asset->kondisi }}</td>
                                <td class="py-3 px-6 text-left">
                                    @if ($asset->gambar)
                                        <img src="{{ asset('storage/' . $asset->gambar) }}"
                                            alt="Gambar {{ $asset->nama_barang }}"
                                            class="w-20 h-20 object-cover rounded-lg">
                                    @else
                                        <span class="text-gray-500">Tidak ada gambar</span>
                                    @endif
                                </td>
                                <td class="py-3 px-6 text-left">{{ $asset->created_at->format('d-m-Y') }}</td>
                                <td class="py-3 px-6 text-center">
                                    <a href="{{ route('asset.edit', $asset->id) }}"
                                        class="bg-yellow-500 text-white py-1 px-3 rounded hover:bg-yellow-700">Edit</a>
                                    <form action="{{ route('asset.delete', $asset->id) }}" method="POST"
                                        class="inline-block ml-2">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                            class="bg-red-500 text-white py-1 px-3 rounded hover:bg-red-700">Hapus</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </section>

    {{-- Pagination --}}
    <div class="mt-4">
        {{ $assets->links() }}
    </div>
@endsection
