@extends('layout.TemplatePeminjam')

@section('title', 'Home Peminjam')

@section('content')
    <section class="p-6 bg-gray-100 min-h-screen">
        <div class="container mx-auto">
            <!-- Salam dan Nama Peminjam -->
            <h2 class="text-3xl font-semibold text-gray-800 mb-6">
                Selamat
                @php
                    $hour = now()->format('H');
                    if ($hour >= 5 && $hour < 12) {
                        echo 'Pagi';
                    } elseif ($hour >= 12 && $hour < 16) {
                        echo 'Siang';
                    } elseif ($hour >= 16 && $hour < 19) {
                        echo 'Sore';
                    } else {
                        echo 'Malam';
                    }
                @endphp
                <span class="text-blue-600">{{ Auth::guard('peminjam')->user()->name }}</span>,
                Selamat Datang di Sistem Peminjaman Asset Gereja Babadan!
            </h2>

            <!-- Statistik Peminjaman -->
            <section class="bg-white p-6 rounded-lg shadow-md mb-6">
                <div class="container mx-auto">
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <!-- Card Riwayat Peminjaman -->
                        <div class="p-6 bg-white rounded shadow-md hover:shadow-xl transition-all duration-300">
                            <h3 class="text-xl font-semibold text-gray-700">Riwayat Peminjaman</h3>
                            <p class="text-4xl text-blue-500">3</p>
                        </div>
                        <!-- Card Peminjaman Berjalan -->
                        <div class="p-6 bg-white rounded shadow-md hover:shadow-xl transition-all duration-300">
                            <h3 class="text-xl font-semibold text-gray-700">Peminjaman Berjalan</h3>
                            <p class="text-4xl text-green-500">1</p>
                        </div>
                        <!-- Card Total Aset yang Pernah Dipinjam -->
                        <div class="p-6 bg-white rounded shadow-md hover:shadow-xl transition-all duration-300">
                            <h3 class="text-xl font-semibold text-gray-700">Total Aset yang Pernah Dipinjam</h3>
                            <p class="text-4xl text-purple-500">15</p>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </section>
@endsection
