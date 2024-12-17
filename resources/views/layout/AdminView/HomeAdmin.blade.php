@extends('layout.TemplateAdmin')

@section('title', 'HomeAdmin')

@section('content')
    <section class="p-6 bg-gray-100 min-h-screen">
        <div class="container mx-auto">
            <!-- Header Greeting -->
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
                <span class="text-blue-600">{{ Auth::guard('admin')->user()->nama }}</span>,
                Selamat Datang di Sistem Peminjaman Asset Gereja Babadan!
            </h2>
            <!-- Persetujuan Akun -->
            <div class="p-6 bg-white rounded-lg shadow-md hover:shadow-lg transition-transform transform hover:scale-105">
                <h3 class="text-xl font-semibold text-gray-700">Persetujuan Akun</h3>
                <p class="text-5xl font-bold text-blue-500">{{ $persetujuanAkun }}</p>
                <p class="text-sm text-gray-500 mt-2">Akun menunggu persetujuan.</p>
            </div>

            <!-- Peminjaman Aktif -->
            <div class="p-6 bg-white rounded-lg shadow-md hover:shadow-lg transition-transform transform hover:scale-105">
                <h3 class="text-xl font-semibold text-gray-700">Peminjaman Aktif</h3>
                <p class="text-5xl font-bold text-green-500">{{ $peminjamanAktif }}</p>
                <p class="text-sm text-gray-500 mt-2">Jumlah peminjaman yang berjalan.</p>
            </div>

            <!-- Permintaan Peminjaman -->
            <div class="p-6 bg-white rounded-lg shadow-md hover:shadow-lg transition-transform transform hover:scale-105">
                <h3 class="text-xl font-semibold text-gray-700">Permintaan Peminjaman</h3>
                <p class="text-5xl font-bold text-purple-500">{{ $permintaanPeminjaman }}</p>
                <p class="text-sm text-gray-500 mt-2">Permintaan peminjaman tertunda.</p>
            </div>

            <!-- Grafik Peminjaman -->
            <div class="bg-white rounded-lg shadow-md p-6">
                <h3 class="text-2xl font-semibold text-gray-700 mb-4">Statistik Peminjaman Bulanan</h3>
                <canvas id="peminjamanChart"></canvas>
            </div>

            <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    const ctx = document.getElementById('peminjamanChart').getContext('2d');
                    const peminjamanData = @json($peminjamanPerBulan);

                    new Chart(ctx, {
                        type: 'bar',
                        data: {
                            labels: Object.keys(peminjamanData).map(bulan => `Bulan ${bulan}`),
                            datasets: [{
                                label: 'Jumlah Peminjaman',
                                data: Object.values(peminjamanData),
                                backgroundColor: '#3b82f6',
                                borderColor: '#3b82f6',
                                borderWidth: 1
                            }]
                        },
                        options: {
                            responsive: true,
                            scales: {
                                y: {
                                    beginAtZero: true
                                }
                            }
                        }
                    });
                });
            </script>

        @endsection
