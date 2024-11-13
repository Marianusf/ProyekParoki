@extends('layout.TemplatePeminjam')

@section('title', 'Informasi Ruangan')

@section('content')
<script src="https://cdn.tailwindcss.com"></script>
<section class="w-full h-full min-h-screen flex justify-center items-center">
    <div class="container mx-auto px-4">
        <div class="bg-cover bg-white bg-center w-full min-h-screen" style="background-image: url('/Gambar/.png');">
            <div id="main-content" class="main-content p-4 md:p-8 relative pt-16 min-h-screen">
                <div class="flex justify-center items-center p-9">
                    <div class="border-4 border-gray-800 rounded-full py-4 px-8 inline-block text-center">
                        <h1 id="room-title" class="text-3xl md:text-6xl font-semibold text-gray-700">Informasi Ruangan</h1>
                    </div>
                </div>
                
                <!-- Bagian Dipinjam -->
                <div class="rounded-3xl shadow-lg p-4 md:p-6 text-center">
                    <h1 class="text-2xl md:text-3xl font-semibold text-gray-700 font-serif p-4">Daftar Ruangan Dipinjam</h1>
                    <div class="overflow-y-auto max-h-64"> <!-- Scroll -->
                        <table class="min-w-full bg-white rounded-lg shadow-lg text-sm md:text-base">
                            <thead>
                                <tr>
                                    <th class="py-3 px-4 md:px-6 bg-blue-600 text-white text-left font-semibold uppercase sticky top-0 z-10">Nama Ruangan</th>
                                    <th class="py-3 px-4 md:px-6 bg-blue-600 text-white text-left font-semibold uppercase sticky top-0 z-10">Penanggung Jawab</th>
                                    <th class="py-3 px-4 md:px-6 bg-blue-600 text-white text-left font-semibold uppercase sticky top-0 z-10">Tanggal Mulai</th>
                                    <th class="py-3 px-4 md:px-6 bg-blue-600 text-white text-left font-semibold uppercase sticky top-0 z-10">Tanggal Selesai</th>
                                    <th class="py-3 px-4 md:px-6 bg-blue-600 text-white text-left font-semibold uppercase sticky top-0 z-10">Jam Mulai</th>
                                    <th class="py-3 px-4 md:px-6 bg-blue-600 text-white text-left font-semibold uppercase sticky top-0 z-10">Jam Selesai</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr class="border-b">
                                    <td class="py-2 px-4 md:py-4 md:px-6 text-gray-700">Ruangan 2</td>
                                    <td class="py-2 px-4 md:py-4 md:px-6 text-gray-700">King Joy</td>
                                    <td class="py-2 px-4 md:py-4 md:px-6 text-gray-700">10-04-2024</td>
                                    <td class="py-2 px-4 md:py-4 md:px-6 text-gray-700">11-04-2024</td>
                                    <td class="py-2 px-4 md:py-4 md:px-6 text-gray-700">10:00 AM</td>
                                    <td class="py-2 px-4 md:py-4 md:px-6 text-gray-700">11:00 AM</td>
                                </tr>
                                <tr class="border-b">
                                    <td class="py-2 px-4 md:py-4 md:px-6 text-gray-700">Ruangan 2</td>
                                    <td class="py-2 px-4 md:py-4 md:px-6 text-gray-700">King Joy</td>
                                    <td class="py-2 px-4 md:py-4 md:px-6 text-gray-700">10-04-2024</td>
                                    <td class="py-2 px-4 md:py-4 md:px-6 text-gray-700">11-04-2024</td>
                                    <td class="py-2 px-4 md:py-4 md:px-6 text-gray-700">10:00 AM</td>
                                    <td class="py-2 px-4 md:py-4 md:px-6 text-gray-700">11:00 AM</td>
                                </tr>
                                <tr class="border-b">
                                    <td class="py-2 px-4 md:py-4 md:px-6 text-gray-700">Ruangan 2</td>
                                    <td class="py-2 px-4 md:py-4 md:px-6 text-gray-700">King Joy</td>
                                    <td class="py-2 px-4 md:py-4 md:px-6 text-gray-700">10-04-2024</td>
                                    <td class="py-2 px-4 md:py-4 md:px-6 text-gray-700">11-04-2024</td>
                                    <td class="py-2 px-4 md:py-4 md:px-6 text-gray-700">10:00 AM</td>
                                    <td class="py-2 px-4 md:py-4 md:px-6 text-gray-700">11:00 AM</td>
                                </tr>
                                <tr class="border-b">
                                    <td class="py-2 px-4 md:py-4 md:px-6 text-gray-700">Ruangan 2</td>
                                    <td class="py-2 px-4 md:py-4 md:px-6 text-gray-700">King Joy</td>
                                    <td class="py-2 px-4 md:py-4 md:px-6 text-gray-700">10-04-2024</td>
                                    <td class="py-2 px-4 md:py-4 md:px-6 text-gray-700">11-04-2024</td>
                                    <td class="py-2 px-4 md:py-4 md:px-6 text-gray-700">10:00 AM</td>
                                    <td class="py-2 px-4 md:py-4 md:px-6 text-gray-700">11:00 AM</td>
                                </tr>
                                <tr class="border-b">
                                    <td class="py-2 px-4 md:py-4 md:px-6 text-gray-700">Ruangan 2</td>
                                    <td class="py-2 px-4 md:py-4 md:px-6 text-gray-700">King Joy</td>
                                    <td class="py-2 px-4 md:py-4 md:px-6 text-gray-700">10-04-2024</td>
                                    <td class="py-2 px-4 md:py-4 md:px-6 text-gray-700">11-04-2024</td>
                                    <td class="py-2 px-4 md:py-4 md:px-6 text-gray-700">10:00 AM</td>
                                    <td class="py-2 px-4 md:py-4 md:px-6 text-gray-700">11:00 AM</td>
                                </tr>
                                <tr class="border-b">
                                    <td class="py-2 px-4 md:py-4 md:px-6 text-gray-700">Ruangan 2</td>
                                    <td class="py-2 px-4 md:py-4 md:px-6 text-gray-700">King Joy</td>
                                    <td class="py-2 px-4 md:py-4 md:px-6 text-gray-700">10-04-2024</td>
                                    <td class="py-2 px-4 md:py-4 md:px-6 text-gray-700">11-04-2024</td>
                                    <td class="py-2 px-4 md:py-4 md:px-6 text-gray-700">10:00 AM</td>
                                    <td class="py-2 px-4 md:py-4 md:px-6 text-gray-700">11:00 AM</td>
                                </tr>

                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Bagian Booking -->
                <div class="brounded-3xl shadow-lg p-4 md:p-6 text-center mt-8 md:mt-12">
                    <h1 class="text-2xl md:text-3xl font-semibold text-gray-700 font-serif">Daftar Ruangan Di Booking</h1>
                    <div class="overflow-y-auto max-h-64"> <!-- Scroll -->
                        <table class="min-w-full bg-white rounded-lg shadow-lg text-sm md:text-base">
                            <thead>
                                <tr>
                                    <th class="py-3 px-4 md:px-6 bg-blue-600 text-white text-left font-semibold uppercase sticky top-0 z-10">Nama Ruangan</th>
                                    <th class="py-3 px-4 md:px-6 bg-blue-600 text-white text-left font-semibold uppercase sticky top-0 z-10">Penanggung Jawab</th>
                                    <th class="py-3 px-4 md:px-6 bg-blue-600 text-white text-left font-semibold uppercase sticky top-0 z-10">Tanggal Mulai</th>
                                    <th class="py-3 px-4 md:px-6 bg-blue-600 text-white text-left font-semibold uppercase sticky top-0 z-10">Tanggal Selesai</th>
                                    <th class="py-3 px-4 md:px-6 bg-blue-600 text-white text-left font-semibold uppercase sticky top-0 z-10">Jam Mulai</th>
                                    <th class="py-3 px-4 md:px-6 bg-blue-600 text-white text-left font-semibold uppercase sticky top-0 z-10">Jam Selesai</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr class="border-b">
                                    <td class="py-2 px-4 md:py-4 md:px-6 text-gray-700">Ruangan 3</td>
                                    <td class="py-2 px-4 md:py-4 md:px-6 text-gray-700">Alice Johnson</td>
                                    <td class="py-2 px-4 md:py-4 md:px-6 text-gray-700">12-04-2024</td>
                                    <td class="py-2 px-4 md:py-4 md:px-6 text-gray-700">12-04-2024</td>
                                    <td class="py-2 px-4 md:py-4 md:px-6 text-gray-700">01:00 PM</td>
                                    <td class="py-2 px-4 md:py-4 md:px-6 text-gray-700">03:00 PM</td>
                                </tr>
                                <tr class="border-b">
                                    <td class="py-2 px-4 md:py-4 md:px-6 text-gray-700">Ruangan 2</td>
                                    <td class="py-2 px-4 md:py-4 md:px-6 text-gray-700">King Joy</td>
                                    <td class="py-2 px-4 md:py-4 md:px-6 text-gray-700">10-04-2024</td>
                                    <td class="py-2 px-4 md:py-4 md:px-6 text-gray-700">11-04-2024</td>
                                    <td class="py-2 px-4 md:py-4 md:px-6 text-gray-700">10:00 AM</td>
                                    <td class="py-2 px-4 md:py-4 md:px-6 text-gray-700">11:00 AM</td>
                                </tr>
                                
                                <tr class="border-b">
                                    <td class="py-2 px-4 md:py-4 md:px-6 text-gray-700">Ruangan 2</td>
                                    <td class="py-2 px-4 md:py-4 md:px-6 text-gray-700">King Joy</td>
                                    <td class="py-2 px-4 md:py-4 md:px-6 text-gray-700">10-04-2024</td>
                                    <td class="py-2 px-4 md:py-4 md:px-6 text-gray-700">11-04-2024</td>
                                    <td class="py-2 px-4 md:py-4 md:px-6 text-gray-700">10:00 AM</td>
                                    <td class="py-2 px-4 md:py-4 md:px-6 text-gray-700">11:00 AM</td>
                                </tr>
                                
                                <tr class="border-b">
                                    <td class="py-2 px-4 md:py-4 md:px-6 text-gray-700">Ruangan 2</td>
                                    <td class="py-2 px-4 md:py-4 md:px-6 text-gray-700">King Joy</td>
                                    <td class="py-2 px-4 md:py-4 md:px-6 text-gray-700">10-04-2024</td>
                                    <td class="py-2 px-4 md:py-4 md:px-6 text-gray-700">11-04-2024</td>
                                    <td class="py-2 px-4 md:py-4 md:px-6 text-gray-700">10:00 AM</td>
                                    <td class="py-2 px-4 md:py-4 md:px-6 text-gray-700">11:00 AM</td>
                                </tr>
                                
                                <tr class="border-b">
                                    <td class="py-2 px-4 md:py-4 md:px-6 text-gray-700">Ruangan 2</td>
                                    <td class="py-2 px-4 md:py-4 md:px-6 text-gray-700">King Joy</td>
                                    <td class="py-2 px-4 md:py-4 md:px-6 text-gray-700">10-04-2024</td>
                                    <td class="py-2 px-4 md:py-4 md:px-6 text-gray-700">11-04-2024</td>
                                    <td class="py-2 px-4 md:py-4 md:px-6 text-gray-700">10:00 AM</td>
                                    <td class="py-2 px-4 md:py-4 md:px-6 text-gray-700">11:00 AM</td>
                                </tr>
                                

                               
                        </table>
                    </div>
                </div>

                <!-- Buttons -->
                <div class="flex justify-between items-center space-x-4 p-4">
                    <a href="{{ route('pinjam.ViewRuangan') }}"> 
                        <button class="w-full md:w-40 h-16 py-2 bg-blue-600 text-white rounded-md hover:bg-gray-600 focus:outline-none font-bold">
                            Kembali
                        </button>
                    </a>
                </div>
            </div>
        </div>
    </section>
@endsection