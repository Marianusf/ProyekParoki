@extends('layout.TemplateAdminParamenta')

@section('title', 'Dashboard Peminjaman Alat Misa')

@section('content')
    <section class="p-6 bg-gray-100 min-h-screen">
        <div class="container mx-auto">
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

            <!-- Statistik Cards -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                <!-- Persetujuan Alat Misa -->
                <div class="p-6 bg-white rounded-lg shadow-md hover:shadow-lg transition-all duration-300">
                    <h3 class="text-lg font-semibold text-gray-700">Persetujuan Alat Misa</h3>
                    <p class="text-5xl font-bold text-yellow-500">{{ $persetujuanAlat }}</p>
                    <p class="text-sm text-gray-500 mt-2">Permintaan alat misa menunggu persetujuan.</p>
                </div>

                <!-- Peminjaman Aktif -->
                <div class="p-6 bg-white rounded-lg shadow-md hover:shadow-lg transition-all duration-300">
                    <h3 class="text-lg font-semibold text-gray-700">Peminjaman Aktif</h3>
                    <p class="text-5xl font-bold text-green-500">{{ $peminjamanAktifAlat }}</p>
                    <p class="text-sm text-gray-500 mt-2">Alat misa sedang dipinjam.</p>
                </div>

                <!-- Total Permintaan -->
                <div class="p-6 bg-white rounded-lg shadow-md hover:shadow-lg transition-all duration-300">
                    <h3 class="text-lg font-semibold text-gray-700">Total Permintaan</h3>
                    <p class="text-5xl font-bold text-purple-500">{{ $totalPermintaanAlat }}</p>
                    <p class="text-sm text-gray-500 mt-2">Jumlah total permintaan peminjaman alat misa.</p>
                </div>
            </div>

            <!-- Grafik Peminjaman Bulanan -->
            <div class="p-6 bg-white rounded-lg shadow-md mt-8">
                <h3 class="text-2xl font-semibold text-gray-700 mb-4">Grafik Peminjaman Alat Misa Bulanan</h3>
                <canvas id="alatMisaChart"></canvas>
            </div>
        </div>
    </section>

    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const peminjamanData = @json($peminjamanAlatBulanan);

            const labels = [
                'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni',
                'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'
            ];

            const data = Object.values(peminjamanData);

            const ctx = document.getElementById('alatMisaChart').getContext('2d');
            new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: labels,
                    datasets: [{
                        label: 'Peminjaman Alat Misa',
                        data: data,
                        backgroundColor: 'rgba(54, 162, 235, 0.7)',
                        borderColor: 'rgba(54, 162, 235, 1)',
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
