<!-- resources/views/layout/AdminView/LihatPeminjamAktif.blade.php -->

@extends('layout.TemplateAdmin')
@section('title', 'peminjam-aktif')


@section('content')

<script src="https://cdn.tailwindcss.com"></script>

<div class="container mx-auto py-8 bg-gray-100 p-6 rounded-md mt-14 mr-10">
    <h1 class="text-2xl font-bold mb-6">Daftar Peminjam Aktif</h1>

    <div class="overflow-x-auto overflow-y-auto shadow-md sm:rounded-lg">
        <table class="w-full text-sm text-left text-gray-500">
            <thead class="text-xs text-white uppercase bg-gray-600 border border-gray-700 sticky top-0">
                <tr>
                    <th scope="col" class="px-6 py-3 border border-collapse">Nama</th>
                    <th scope="col" class="px-6 py-3 border border-collapse">Email</th>
                    <th scope="col" class="px-6 py-3 border border-collapse">Tanggal Lahir</th>
                    <th scope="col" class="px-6 py-3 border border-collapse">Lingkungan</th>
                    <th scope="col" class="px-6 py-3 border border-collapse">Alamat</th>
                    <th scope="col" class="px-6 py-3 border border-collapse">Nomor Telepon</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($peminjam as $peminjam)
                        <tr class="bg-white border-b hover:bg-gray-100 transition duration-150">
                            <td class="px-6 py-4 border border-collapse font-medium text-gray-900 whitespace-nowrap">{{ $peminjam->name }}</td>
                            <td class="px-6 py-4 border border-collapse">{{ $peminjam->email }}</td>
                            <td class="px-6 py-4 border border-collapse">{{ $peminjam->tanggal_lahir }}</td>
                            <td class="px-6 py-4 border border-collapse">{{ $peminjam->lingkungan }}</td>
                            <td class="px-6 py-4 border border-collapse">{{ $peminjam->alamat }}</td>
                            <td class="px-6 py-4 border border-collapse">{{ $peminjam->nomor_telepon }}</td>
                        </tr>
                    @endforeach
            </tbody>
        </table>

    </div>

</div>
@endsection