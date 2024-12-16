@extends('layout.TemplatePeminjam')

@section('title', 'Dashboard Peminjam')

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

            <!-- Statistik Ringkasan -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                <!-- Peminjaman Aktif -->
                <div
                    class="p-6 bg-white rounded-lg shadow hover:shadow-lg transition-transform transform hover:scale-105 flex items-center space-x-4">
                    <div class="text-green-500">
                        <i class="fas fa-hourglass-half text-5xl"></i>
                    </div>
                    <div>
                        <h3 class="text-lg font-semibold text-gray-700">Peminjaman Aktif</h3>
                        <p class="text-4xl font-bold text-green-500">{{ $totalPeminjamanAktif }}</p>
                    </div>
                </div>

                <!-- Peminjaman Selesai -->
                <div
                    class="p-6 bg-white rounded-lg shadow hover:shadow-lg transition-transform transform hover:scale-105 flex items-center space-x-4">
                    <div class="text-purple-500">
                        <i class="fas fa-check-circle text-5xl"></i>
                    </div>
                    <div>
                        <h3 class="text-lg font-semibold text-gray-700">Peminjaman Selesai</h3>
                        <p class="text-4xl font-bold text-purple-500">{{ $totalPeminjamanSelesai }}</p>
                    </div>
                </div>

                <!-- Persentase Pemanfaatan -->
                <div
                    class="p-6 bg-white rounded-lg shadow hover:shadow-lg transition-transform transform hover:scale-105 flex items-center space-x-4">
                    <div class="text-yellow-500">
                        <i class="fas fa-chart-pie text-5xl"></i>
                    </div>
                    <div>
                        <h3 class="text-lg font-semibold text-gray-700">Persentase Pemanfaatan</h3>
                        <p class="text-sm mt-2">
                            Ruangan: <span
                                class="text-blue-600 font-bold">{{ number_format($persenRuangan, 1) }}%</span><br>
                            Alat Misa: <span
                                class="text-green-600 font-bold">{{ number_format($persenAlat, 1) }}%</span><br>
                            Asset: <span class="text-yellow-600 font-bold">{{ number_format($persenAsset, 1) }}%</span>
                        </p>
                    </div>
                </div>
            </div>

            <!-- Grafik Pemanfaatan -->
            <div class="p-6 bg-white rounded-lg shadow mb-8">
                <h3 class="text-2xl font-semibold text-gray-700 mb-4 text-center">Diagram Pemanfaatan Peminjaman</h3>
                <div class="flex justify-center">
                    <div style="width: 300px; height: 300px;">
                        <canvas id="peminjamanChart"></canvas>
                    </div>
                </div>
            </div>

            <!-- Notifikasi Pengingat -->
            <div class="p-6 bg-white rounded-lg shadow">
                <h3 class="text-2xl font-semibold text-gray-700 mb-4">Pengingat Pengembalian</h3>
                @if ($pengingatPeminjaman->isEmpty())
                    <p class="text-gray-500">Tidak ada peminjaman yang mendekati batas pengembalian.</p>
                @else
                    <div class="overflow-x-auto">
                        <table class="min-w-full bg-white">
                            <thead class="bg-gray-200">
                                <tr>
                                    <th class="w-1/3 py-2 px-4 text-left text-gray-700">Nama</th>
                                    <th class="w-1/3 py-2 px-4 text-left text-gray-700">Sisa Waktu</th>
                                    <th class="w-1/3 py-2 px-4 text-left text-gray-700">Tanggal Pengembalian</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($pengingatPeminjaman as $item)
                                    <tr class="hover:bg-gray-100">
                                        <td class="py-2 px-4">{{ $item['nama'] }}</td>
                                        <td class="py-2 px-4 text-red-500">{{ $item['sisa_waktu'] }}</td>
                                        <td class="py-2 px-4">{{ $item['tanggal_selesai']->format('d M Y') }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            </div>
        </div>
    </section>

    <!-- FontAwesome -->
    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const ctx = document.getElementById('peminjamanChart').getContext('2d');
            const data = {
                labels: ['Ruangan', 'Alat Misa', 'Asset'],
                datasets: [{
                    data: [{{ $persenRuangan }}, {{ $persenAlat }}, {{ $persenAsset }}],
                    backgroundColor: ['#3b82f6', '#10b981', '#fbbf24'],
                    hoverOffset: 4
                }]
            };

            new Chart(ctx, {
                type: 'pie',
                data: data,
                options: {
                    responsive: true,
                    maintainAspectRatio: false
                }
            });
        });
    </script>
@endsection
