@extends('layout.TemplatePeminjam')

@section('title', 'Home Peminjam')

@section('content')
    <section class="p-6 bg-gray-100 min-h-screen">
        <div class="container mx-auto">
            <h2 class="text-3xl font-semibold text-gray-800 mb-6">Selamat Datang, Peminjam</h2>

            <section class="p-6 bg-gray-100">
                <div class="container mx-auto">
                    <h2 class="text-2xl font-semibold text-gray-700 mb-4">Selamat Datang di Dashboard Peminjam</h2>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <!-- Card Riwayat Peminjaman -->
                        <div class="p-4 bg-white rounded shadow">
                            <h3 class="text-xl font-bold text-gray-700">Riwayat Peminjaman</h3>
                            <p class="text-4xl text-blue-500">3</p>
                        </div>
                        <!-- Card Peminjaman Berjalan -->
                        <div class="p-4 bg-white rounded shadow">
                            <h3 class="text-xl font-bold text-gray-700">Peminjaman Berjalan</h3>
                            <p class="text-4xl text-green-500">1</p>
                        </div>
                        <!-- Card Total Aset yang Pernah Dipinjam -->
                        <div class="p-4 bg-white rounded shadow">
                            <h3 class="text-xl font-bold text-gray-700">Total Aset yang Pernah Dipinjam</h3>
                            <p class="text-4xl text-purple-500">15</p>
                        </div>
                    </div>
                </div>
            </section>

        </div>
    </section>
@endsection
