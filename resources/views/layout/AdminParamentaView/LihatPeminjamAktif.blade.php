<!-- resources/views/layout/AdminView/LihatPeminjamAktif.blade.php -->

@extends('layout.TemplateAdminParamenta')
@section('title', 'PeminjamAktif')


@section('content')
    <div class="container mx-auto py-8">
        <h1 class="text-2xl font-bold mb-6">Daftar Peminjam Aktif</h1>
        @if (session('success'))
            <script>
                Swal.fire({
                    icon: 'success',
                    title: 'Sukses!',
                    text: '{{ session('success') }}',
                    confirmButtonText: 'OK'
                });
            </script>
        @endif

        @if (session('message'))
            <script>
                Swal.fire({
                    icon: 'info',
                    title: 'PESAN:',
                    text: '{{ session('message') }}',
                    confirmButtonText: 'OK'
                });
            </script>
        @endif

        @if (session('error'))
            <script>
                Swal.fire({
                    icon: 'error',
                    title: 'Error:',
                    text: '{{ session('error') }}',
                    confirmButtonText: 'OK'
                });
            </script>
        @endif

        <div class="overflow-x-auto overflow-y-auto max-h-[500px] bg-white shadow-md rounded-lg">
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
