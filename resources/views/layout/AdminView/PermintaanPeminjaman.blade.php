<!-- resources/views/layout/AdminView/PermintaanPeminjaman.blade.php -->

@extends('layout.TemplateAdmin')

@section('content')
    <div class="container mx-auto py-8">
        <h2 class="text-2xl font-bold mb-6">Permintaan Peminjaman</h2>

        @if ($peminjamanRequests->isEmpty())
            <p class="text-gray-700">Tidak ada permintaan peminjaman saat ini.</p>
        @else
            <div class="overflow-x-auto shadow-md sm:rounded-lg">
                <table class="w-full text-sm text-left text-gray-500">
                    <thead class="text-xs text-gray-700 uppercase bg-gray-200 sticky top-0">
                        <tr>
                            <th scope="col" class="px-6 py-3">Nama Asset</th>
                            <th scope="col" class="px-6 py-3">Dipinjam Oleh</th>
                            <th scope="col" class="px-6 py-3">Jumlah</th>
                            <th scope="col" class="px-6 py-3">Tanggal Peminjaman</th>
                            <th scope="col" class="px-6 py-3">Tanggal Pengembalian</th>
                            <th scope="col" class="px-6 py-3">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($peminjamanRequests as $request)
                            <tr class="bg-white border-b hover:bg-gray-100 transition duration-150">
                                <td class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap">
                                    {{ $request->asset->nama_barang }}
                                </td>
                                <td class="px-6 py-4">{{ $request->peminjam->name }}</td>
                                <td class="px-6 py-4">{{ $request->jumlah }}</td>
                                <td class="px-6 py-4">{{ $request->tanggal_peminjaman }}</td>
                                <td class="px-6 py-4">{{ $request->tanggal_pengembalian }}</td>
                                <td class="px-6 py-4">
                                    <form action="{{ route('peminjaman.setujui', $request->id) }}" method="POST"
                                        class="inline">
                                        @csrf
                                        <button type="submit"
                                            class="px-4 py-2 bg-green-500 text-white rounded-md hover:bg-green-600 transition">
                                            Setujui
                                        </button>
                                    </form>
                                    <form action="{{ route('peminjaman.tolak', $request->id) }}" method="POST"
                                        class="inline mt-2">
                                        @csrf
                                        <label for="alasan_penolakan_{{ $request->id }}" class="sr-only">Alasan
                                            Penolakan:</label>
                                        <input type="text" name="alasan_penolakan"
                                            id="alasan_penolakan_{{ $request->id }}" placeholder="Alasan Penolakan"
                                            class="mt-1 block w-full text-sm px-2 py-1 border rounded-md">
                                        <button type="submit"
                                            class="px-4 py-2 bg-red-500 text-white rounded-md hover:bg-red-600 transition mt-2">
                                            Tolak
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>
@endsection
