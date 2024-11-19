@extends('layout.TemplatePeminjam')

@section('title', 'Dashboard Peminjam')

@section('content')
<section class="w-full h-full min-h-screen flex justify-center items-center">
    <body class="bg-gradient-to-br from-blue-500 to-green-500">
        <div class="container mx-auto bg-white rounded-lg shadow-xl p-8">

            <!-- Sidebar -->
            <div class="flex flex-col md:flex-row">
                <div class="w-full md:w-64 md:h-screen bg-gray-800 shadow-lg">
                    <div class="py-7 text-white text-center">
                        <h1 class="text-2xl font-bold">Dashboard Peminjam</h1>
                        <div class="w-60md:h-screen bg-gray-800 shadow-lg p-4">
                        <p class="mt-2 text-2xl font-serif">Gereja BABADAN</p>
</div>
                    </div>
                </div>

                <div class="flex-1 p-8">
                    <header class="flex justify-between items-center mb-8">
                        <h2 class="text-3xl font-semibold text-gray-800">Informasi Peminjaman</h2>
                    </header>

                    <!-- Summary Cards -->
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                        <div class="bg-white p-6 shadow-lg rounded-lg border-l-4 border-blue-500 transition transform hover:scale-105 duration-200">
                            <div class="flex items-center">
                                <div class="text-blue-500 text-5xl mr-4">
                                    <i class="fas fa-book-open"></i>
                                </div>
                                <div>
                                    <h3 class="text-xl font-semibold">Peminjaman Aktif</h3>
                                    <p class="text-3xl font-bold text-gray-800">2</p>
                                </div>
                            </div>
                        </div>
                        <div class="bg-white p-6 shadow-lg rounded-lg border-l-4 border-green-500 transition transform hover:scale-105 duration-200">
                            <div class="flex items-center">
                                <div class="text-green-500 text-5xl mr-4">
                                    <i class="fas fa-check-circle"></i>
                                </div>
                                <div>
                                    <h3 class="text-xl font-semibold">Disetujui</h3>
                                    <p class="text-3xl font-bold text-gray-800">15</p>
                                </div>
                            </div>
                        </div>
                        <div class="bg-white p-6 shadow-lg rounded-lg border-l-4 border-red-500 transition transform hover:scale-105 duration-200">
                            <div class="flex items-center">
                                <div class="text-red-500 text-5xl mr-4">
                                    <i class="fas fa-times-circle"></i>
                                </div>
                                <div>
                                    <h3 class="text-xl font-semibold">Ditolak</h3>
                                    <p class="text-3xl font-bold text-gray-800">3</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Riwayat Peminjaman -->
                    <div class="bg-white shadow-lg rounded-lg overflow-hidden">
                        <h3 class="text-2xl font-semibold p-6 bg-gradient-to-r from-blue-400 to-blue-600 text-white">Riwayat Peminjaman</h3>
                        <table class="min-w-full leading-normal">
                            <thead>
                                <tr>
                                    <th class="px-5 py-3 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                        Tanggal Peminjaman
                                    </th>
                                    <th class="px-5 py-3 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                        Jenis
                                    </th>
                                    <th class="px-5 py-3 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                        Status
                                    </th>
                                    <th class="px-5 py-3 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                        Keterangan
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr class="transition hover:bg-gray-200">
                                  <h2 class="text-xl font-serif  font-bold">Data Peminjaan Ruangan</h2>
                                  <div class="text-2xl">
                                    <td class="px-5 py-5 border-b border-gray-200 bg-white ">
                                        <p class="text-gray-900 whitespace-no-wrap">05/11/2024</p>
                                    </td>
                                    <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                                        <p class="text-gray-900 whitespace-no-wrap">Ruangan Aula</p>
                                    </td>
                                    <td class="px-5 py-5 border-b border-gray-200 bg-white ">
                                        <!-- Status Peminjaman dengan warna sesuai status -->
                                        <span class="flex items-center">
                                            <span class="text-green-800 bg-green-100 px-2 py-1 rounded-lg mr-2">
                                                <i class="fas fa-check-circle"></i> Disetujui
                                            </span>
                                        </span>
                                    </td>
                                    <td class="px-5 py-5 border-b border-gray-200 bg-white ">
                                        <p class="text-gray-900 whitespace-no-wrap">Acara Paskah</p>
                                    </td>
                                </tr>
                                <tr class="transition hover:bg-gray-200">
                                    <td class="px-5 py-5 border-b border-gray-200 bg-white ">
                                        <p class="text-gray-900 whitespace-no-wrap">10/11/2024</p>
                                    </td>
                                    <td class="px-5 py-5 border-b border-gray-200 bg-white ">
                                        <p class="text-gray-900 whitespace-no-wrap">Ruangan Serbaguna</p>
                                    </td>
                                    <td class="px-5 py-5 border-b border-gray-200 bg-white ">
                                        <!-- Status Peminjaman Ditolak -->
                                        <span class="flex items-center">
                                            <span class="text-red-500 bg-red-100 px-2 py-1 rounded-lg mr-2">
                                                <i class="fas fa-times-circle"></i> Ditolak
                                            </span>
                                        </span>
                                    </td>
                                    <td class="px-5 py-5 border-b border-gray-200 bg-white ">
                                        <p class="text-gray-900 whitespace-no-wrap">Acara Perayaan Natal</p>
                                    </td>
                                </tr>
                                <!-- Tambahkan lebih banyak baris sesuai kebutuhan -->
                            </tbody>
</div>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </body>
</section>
@endsection

