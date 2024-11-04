@extends('layout.TemplateAdmin')

@section('title', 'Home Admin')

@section('content')
    <section class="p-6 bg-gray-100 min-h-screen">
        <div class="container mx-auto">
            <h2 class="text-3xl font-semibold text-gray-800 mb-6">Selamat Datang, Admin</h2>

            <section class="p-6 bg-gray-100">
                <div class="container mx-auto">
                    <h2 class="text-2xl font-semibold text-gray-700 mb-4">Selamat Datang di Dashboard Admin</h2>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <!-- Card Statistik Peminjam -->
                        <div class="p-4 bg-white rounded shadow">
                            <h3 class="text-xl font-bold text-gray-700">Peminjam Baru</h3>
                            <p class="text-4xl text-blue-500">5</p>
                        </div>
                        <!-- Card Statistik Peminjaman Aktif -->
                        <div class="p-4 bg-white rounded shadow">
                            <h3 class="text-xl font-bold text-gray-700">Peminjaman Aktif</h3>
                            <p class="text-4xl text-green-500">12</p>
                        </div>
                        <!-- Card Ketersediaan Aset -->
                        <div class="p-4 bg-white rounded shadow">
                            <h3 class="text-xl font-bold text-gray-700">Aset Tersedia</h3>
                            <p class="text-4xl text-purple-500">100</p>
                        </div>
                    </div>
                </div>
            </section>

        </div>
    </section>
@endsection
