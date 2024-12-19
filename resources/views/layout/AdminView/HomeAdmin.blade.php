@extends('layout.TemplateAdmin')

@section('title', 'HomeAdmin')

@section('content')
    <section class="p-6 sm:p-10 bg-gray-100 min-h-screen">
        <div class="container mx-auto">
            <!-- Header Greeting -->
            <div class="bg-white shadow-lg rounded-lg p-6 sm:p-10 mb-6 text-center">
                <h2 class="text-xl sm:text-3xl font-semibold text-gray-700">
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
                    <span class="text-blue-600 font-bold">{{ Auth::guard('admin')->user()->nama }}</span>,<br>
                    Selamat Datang di Sistem Peminjaman Asset Gereja Babadan!
                </h2>
            </div>

            <!-- Dashboard Summary Cards -->
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-4">
                <!-- Persetujuan Akun -->
                <div
                    class="bg-white p-4 sm:p-6 rounded-lg shadow-md hover:shadow-lg transition-transform transform hover:scale-105 flex items-center">
                    <div class="text-blue-500 p-3 sm:p-4 rounded-full bg-blue-100 mr-4">
                        <i class="fas fa-user-check text-2xl sm:text-3xl"></i>
                    </div>
                    <div>
                        <h3 class="text-base sm:text-lg font-semibold text-gray-700">Persetujuan Akun</h3>
                        <p class="text-3xl sm:text-5xl font-bold text-blue-500">{{ $persetujuanAkun }}</p>
                        <p class="text-xs sm:text-sm text-gray-500 mt-1">Akun menunggu persetujuan.</p>
                    </div>
                </div>

                <!-- Peminjaman Aktif -->
                <div
                    class="bg-white p-4 sm:p-6 rounded-lg shadow-md hover:shadow-lg transition-transform transform hover:scale-105 flex items-center">
                    <div class="text-green-500 p-3 sm:p-4 rounded-full bg-green-100 mr-4">
                        <i class="fas fa-play-circle text-2xl sm:text-3xl"></i>
                    </div>
                    <div>
                        <h3 class="text-base sm:text-lg font-semibold text-gray-700">Peminjaman Aktif</h3>
                        <p class="text-3xl sm:text-5xl font-bold text-green-500">{{ $peminjamanAktif }}</p>
                    </div>
                </div>

                <!-- Permintaan Peminjaman -->
                <div
                    class="bg-white p-4 sm:p-6 rounded-lg shadow-md hover:shadow-lg transition-transform transform hover:scale-105 flex items-center">
                    <div class="text-purple-500 p-3 sm:p-4 rounded-full bg-purple-100 mr-4">
                        <i class="fas fa-clock text-2xl sm:text-3xl"></i>
                    </div>
                    <div>
                        <h3 class="text-base sm:text-lg font-semibold text-gray-700">Permintaan Peminjaman</h3>
                        <p class="text-3xl sm:text-5xl font-bold text-purple-500">{{ $permintaanPeminjaman }}</p>
                        <p class="text-xs sm:text-sm text-gray-500 mt-1">Permintaan peminjaman tertunda.</p>
                    </div>
                </div>

                <!-- Total Pengguna Terdaftar -->
                <div
                    class="bg-white p-4 sm:p-6 rounded-lg shadow-md hover:shadow-lg transition-transform transform hover:scale-105 flex items-center">
                    <div class="text-yellow-500 p-3 sm:p-4 rounded-full bg-yellow-100 mr-4">
                        <i class="fas fa-users text-2xl sm:text-3xl"></i>
                    </div>
                    <div>
                        <h3 class="text-base sm:text-lg font-semibold text-gray-700">Total Pengguna</h3>
                        <p class="text-3xl sm:text-5xl font-bold text-yellow-500">{{ $totalPengguna }}</p>
                        <p class="text-xs sm:text-sm text-gray-500 mt-1">Pengguna terdaftar di sistem.</p>
                    </div>
                </div>
            </div>

            <!-- Additional Stats Cards -->
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4 mt-6">
                <!-- Barang Tersedia -->
                <div
                    class="bg-white p-4 sm:p-6 rounded-lg shadow-md hover:shadow-lg transition-transform transform hover:scale-105 flex items-center">
                    <div class="text-orange-500 p-3 sm:p-4 rounded-full bg-orange-100 mr-4">
                        <i class="fas fa-box text-2xl sm:text-3xl"></i>
                    </div>
                    <div>
                        <h3 class="text-base sm:text-lg font-semibold text-gray-700">Barang Tersedia</h3>
                        <p class="text-3xl sm:text-5xl font-bold text-orange-500">{{ $barangTersedia }}</p>
                        <p class="text-xs sm:text-sm text-gray-500 mt-1">Barang dapat dipinjam.</p>
                    </div>
                </div>

                <!-- Barang Dipinjam -->
                <div
                    class="bg-white p-4 sm:p-6 rounded-lg shadow-md hover:shadow-lg transition-transform transform hover:scale-105 flex items-center">
                    <div class="text-red-500 p-3 sm:p-4 rounded-full bg-red-100 mr-4">
                        <i class="fas fa-box-open text-2xl sm:text-3xl"></i>
                    </div>
                    <div>
                        <h3 class="text-base sm:text-lg font-semibold text-gray-700">Barang Dipinjam</h3>
                        <p class="text-3xl sm:text-5xl font-bold text-red-500">{{ $barangDipinjam }}</p>
                        <p class="text-xs sm:text-sm text-gray-500 mt-1">Barang sedang dipinjam.</p>
                    </div>
                </div>

                <!-- Peminjaman Bulan Ini -->
                <div
                    class="bg-white p-4 sm:p-6 rounded-lg shadow-md hover:shadow-lg transition-transform transform hover:scale-105 flex items-center">
                    <div class="text-teal-500 p-3 sm:p-4 rounded-full bg-teal-100 mr-4">
                        <i class="fas fa-calendar-alt text-2xl sm:text-3xl"></i>
                    </div>
                    <div>
                        <h3 class="text-base sm:text-lg font-semibold text-gray-700">Peminjaman Bulan Ini</h3>
                        <p class="text-3xl sm:text-5xl font-bold text-teal-500">{{ $peminjamanBulanIni }}</p>
                        <p class="text-xs sm:text-sm text-gray-500 mt-1">Peminjaman terjadi bulan ini.</p>
                    </div>
                </div>
            </div>

            <!-- Doughnut Chart Statistik -->
            <div class="mt-8">
                <div class="bg-white rounded-lg shadow-lg p-6 sm:p-8">
                    <h3 class="text-lg sm:text-xl font-semibold text-gray-700 mb-4 sm:mb-6 text-center">Diagram Pemanfaatan
                        Peminjaman</h3>
                    <div class="relative w-full max-w-xs sm:max-w-xl mx-auto">
                        <canvas id="doughnutChart"></canvas>
                    </div>
                </div>
            </div>

            <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    const ctx = document.getElementById('doughnutChart').getContext('2d');

                    new Chart(ctx, {
                        type: 'doughnut',
                        data: {
                            labels: ['Barang Tersedia', 'Barang Dipinjam'],
                            datasets: [{
                                data: [{{ $barangTersedia }}, {{ $barangDipinjam }}],
                                backgroundColor: ['#34d399', '#f87171'],
                                hoverOffset: 4
                            }]
                        },
                        options: {
                            responsive: true,
                            plugins: {
                                legend: {
                                    position: 'top',
                                },
                                tooltip: {
                                    callbacks: {
                                        label: function(context) {
                                            const label = context.label || '';
                                            const value = context.raw || 0;
                                            return `${label}: ${value}`;
                                        }
                                    }
                                }
                            },
                            cutout: '70%',
                        }
                    });
                });
            </script>
        </div>
    </section>
@endsection
