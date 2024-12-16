@extends('layout.TemplateAdminSekretariat')

@section('title', 'Dashboard Admin Paramenta')

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

            <!-- Statistik Dashboard -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                <!-- Persetujuan Ruangan -->
                <div class="p-6 bg-white rounded-lg shadow-md hover:shadow-lg transition-all duration-300">
                    <h3 class="text-lg font-semibold text-gray-700">Persetujuan Ruangan</h3>
                    <p class="text-4xl font-bold text-yellow-500">{{ $persetujuanRuangan }}</p>
                    <p class="text-sm text-gray-500">Permintaan ruangan menunggu persetujuan.</p>
                </div>

                <!-- Peminjaman Aktif -->
                <div class="p-6 bg-white rounded-lg shadow-md hover:shadow-lg transition-all duration-300">
                    <h3 class="text-lg font-semibold text-gray-700">Peminjaman Aktif</h3>
                    <p class="text-4xl font-bold text-green-500">{{ $peminjamanAktifRuangan }}</p>
                    <p class="text-sm text-gray-500">Ruangan sedang digunakan.</p>
                </div>

                <!-- Total Permintaan -->
                <div class="p-6 bg-white rounded-lg shadow-md hover:shadow-lg transition-all duration-300">
                    <h3 class="text-lg font-semibold text-gray-700">Total Permintaan</h3>
                    <p class="text-4xl font-bold text-purple-500">{{ $totalPermintaanRuangan }}</p>
                    <p class="text-sm text-gray-500">Seluruh permintaan peminjaman ruangan.</p>
                </div>
            </div>

            <!-- Grafik Statistik -->
            <div class="mt-8 p-6 bg-white rounded-lg shadow-md">
                <h3 class="text-2xl font-semibold text-gray-700 mb-4">Grafik Peminjaman Ruangan Bulanan</h3>
                <canvas id="ruanganChart"></canvas>
            </div>
        </div>
    </section>

    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Data dari controller
            const peminjamanData = @json($peminjamanRuanganBulanan);

            const labels = [
                'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni',
                'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'
            ];

            const data = Object.values(peminjamanData);

            // Render Chart
            const ctx = document.getElementById('ruanganChart').getContext('2d');
            new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: labels,
                    datasets: [{
                        label: 'Peminjaman Ruangan',
                        data: data,
                        backgroundColor: '#4f46e5',
                        borderColor: '#4f46e5',
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: {
                                precision: 0
                            } // Hanya angka bulat
                        }
                    }
                }
            });
        });
    </script>

@endsection
