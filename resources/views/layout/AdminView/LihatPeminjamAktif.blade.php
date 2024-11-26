<!-- resources/views/layout/AdminView/LihatPeminjamAktif.blade.php -->

@extends('layout.TemplateAdmin')
@section('title', 'PeminjamAktif')


@section('content')
    <div class="container mx-auto py-8">
        <h1 class="text-2xl font-bold mb-6">Daftar Peminjam Aktif</h1>
        @if (session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                <strong class="font-bold">Sukses: </strong>
                <span class="block sm:inline">{{ session('success') }}</span>
            </div>
        @endif
        @if (session('message'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                <strong class="font-bold">PESAN: </strong>
                <span class="block sm:inline">{{ session('message') }}</span>
            </div>
        @endif

        @if (session('error'))
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
                <strong class="font-bold">Error: </strong>
                <span class="block sm:inline">{{ session('error') }}</span>
            </div>
        @endif
        <div class="overflow-x-auto shadow-md sm:rounded-lg">
            <table class="w-full text-sm text-left text-gray-500">
                <thead class="text-xs text-gray-700 uppercase bg-gray-200 sticky top-0">
                    <tr>
                        <th scope="col" class="px-6 py-3">Nama</th>
                        <th scope="col" class="px-6 py-3">Email</th>
                        <th scope="col" class="px-6 py-3">Tanggal Lahir</th>
                        <th scope="col" class="px-6 py-3">Lingkungan</th>
                        <th scope="col" class="px-6 py-3">Alamat</th>
                        <th scope="col" class="px-6 py-3">Nomor Telepon</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($peminjam as $peminjam)
                        <tr class="bg-white border-b hover:bg-gray-100 transition duration-150">
                            <td class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap">{{ $peminjam->name }}</td>
                            <td class="px-6 py-4">{{ $peminjam->email }}</td>
                            <td class="px-6 py-4">{{ $peminjam->tanggal_lahir }}</td>
                            <td class="px-6 py-4">{{ $peminjam->lingkungan }}</td>
                            <td class="px-6 py-4">{{ $peminjam->alamat }}</td>
                            <td class="px-6 py-4">{{ $peminjam->nomor_telepon }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
