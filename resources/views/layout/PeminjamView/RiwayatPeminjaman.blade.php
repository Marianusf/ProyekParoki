@extends('layout.TemplatePeminjam')
@section('title', 'Riwayat Peminjaman')

@section('content')
    <div class="container mx-auto py-8">
        <h1 class="text-2xl font-bold mb-6">Riwayat Peminjaman</h1>

        <div class="overflow-x-auto shadow-md sm:rounded-lg">
            <table class="w-full text-sm text-left text-gray-500">
                <thead class="text-xs text-gray-700 uppercase bg-gray-200 sticky top-0">
                    <tr>
                        <th scope="col" class="px-6 py-3">Nama Asset</th>
                        <th scope="col" class="px-6 py-3">Jumlah</th>
                        <th scope="col" class="px-6 py-3">Tanggal Peminjaman</th>
                        <th scope="col" class="px-6 py-3">Tanggal Pengembalian</th>
                        <th scope="col" class="px-6 py-3">Status Peminjaman</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($riwayatPeminjaman as $peminjaman)
                        <tr class="bg-white border-b hover:bg-gray-100 transition duration-150">
                            <td class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap">
                                {{ $peminjaman->asset->nama_barang }}
                            </td>
                            <td class="px-6 py-4">{{ $peminjaman->jumlah }}</td>
                            <td class="px-6 py-4">{{ $peminjaman->tanggal_peminjaman }}</td>
                            <td class="px-6 py-4">{{ $peminjaman->tanggal_pengembalian }}</td>
                            <td class="px-6 py-4">
                                @if ($peminjaman->status_peminjaman == 'pending')
                                    <span class="text-yellow-500">Menunggu Persetujuan</span>
                                @elseif($peminjaman->status_peminjaman == 'disetujui')
                                    <span class="text-green-500">Disetujui</span>
                                @else
                                    <span class="text-red-500">Ditolak</span>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
