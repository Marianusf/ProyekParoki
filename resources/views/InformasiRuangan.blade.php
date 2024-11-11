@extends('layout.TemplatePeminjam')

@section('title', 'Dashboard')

@section('content')
<script src="https://cdn.tailwindcss.com"></script>
<style>
    .card {
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        background: #f3f4f6;
        background-image: linear-gradient(45deg, rgba(255, 255, 255, 0.15) 25%, transparent 25%, transparent 50%, rgba(255, 255, 255, 0.15) 50%, rgba(255, 255, 255, 0.15) 75%, transparent 75%, transparent);
        background-size: 40px 40px;
    }
    .card:hover {
        transform: translateY(-10px);
        box-shadow: 0 12px 25px rgba(0, 0, 0, 0.3);
    }
</style>

<section class="w-full h-full min-h-screen flex justify-center items-center">
    <div class="container mx-auto">
        <div class="bg-cover bg-white bg-center w-full min-h-screen" style="background-image: url('/Gambar/.png');">
            <div id="main-content" class="main-content p-4 md:p-8 relative pt-16 min-h-screen">
                <div class="flex justify-center items-center p-9">
                    <div class="border-4 border-gray-800 rounded-full py-4 px-8 inline-block text-center">
                        <h1 id="room-title" class="text-3xl md:text-6xl font-semibold text-gray-700">Ruangan</h1>
                    </div>
                </div>
                
                <!-- Bagian Dipinjam -->
                <div class="bg-blue-200 rounded-3xl shadow-lg md:p-6 text-center">
                    <div class="mt-8">
                        <h1 class="text-3xl md:text-3xl font-semibold text-gray-700 font-serif p-4">Informasi Ruangan</h1>
                        <h1 class="text-3xl md:text-3xl font-semibold text-gray-700 font-serif">Dipinjam</h1>
                        <section class="w-full flex justify-center items-center py-8">
                            <div class="bg-white p-8 rounded-lg shadow-xl w-full max-w-4xl">
                                <div class="space-y-6">
                                    <div class="flex justify-between items-center">
                                        <span class="font-medium text-gray-700 text-lg">Penanggung Jawab:</span>
                                        <span class="text-gray-900 text-lg font-semibold">King Joy</span>
                                    </div>
                                    <div class="flex justify-between items-center">
                                        <span class="font-medium text-gray-700 text-lg">Tanggal Peminjaman:</span>
                                        <span class="text-green-600 text-lg font-semibold">10-04-2024</span>
                                    </div>
                                    <div class="flex justify-between items-center">
                                        <span class="font-medium text-gray-700 text-lg">Jam Mulai Peminjaman:</span>
                                        <span class="text-gray-900 text-lg font-semibold">10:00 AM</span>
                                    </div>
                                    <div class="flex justify-between items-center">
                                        <span class="font-medium text-gray-700 text-lg">Jam Selesai Peminjaman:</span>
                                        <span class="text-gray-900 text-lg font-semibold">11:00 AM</span>
                                    </div>
                                    <div class="flex justify-between items-center">
                                        <span class="font-medium text-gray-700 text-lg">Status Ruangan:</span>
                                        <span class="text-red-600 text-lg font-semibold">Digunakan</span>
                                    </div>
                                </div>
                            </div>
                        </section>
                    </div>
                </div>

                <!-- Bagian Booking -->
                <div class="bg-blue-200 rounded-3xl shadow-lg md:p-6 text-center">
                    <div class="mt-8">
                        <h1 class="text-3xl md:text-3xl font-semibold text-gray-700 font-serif">Booking</h1>
                        <section class="w-full flex justify-center items-center py-8">
                            <div class="bg-white p-8 rounded-lg shadow-xl w-full max-w-4xl">
                                <div class="space-y-6">
                                    <div class="flex justify-between items-center">
                                        <span class="font-medium text-gray-700 text-lg">Penanggung Jawab:</span>
                                        <span class="text-gray-900 text-lg font-semibold">King Joy</span>
                                    </div>
                                    <div class="flex justify-between items-center">
                                        <span class="font-medium text-gray-700 text-lg">Tanggal Peminjaman:</span>
                                        <span class="text-green-600 text-lg font-semibold">10-04-2024</span>
                                    </div>
                                    <div class="flex justify-between items-center">
                                        <span class="font-medium text-gray-700 text-lg">Jam Mulai Peminjaman:</span>
                                        <span class="text-gray-900 text-lg font-semibold">10:00 AM</span>
                                    </div>
                                    <div class="flex justify-between items-center">
                                        <span class="font-medium text-gray-700 text-lg">Jam Selesai Peminjaman:</span>
                                        <span class="text-gray-900 text-lg font-semibold">11:00 AM</span>
                                    </div>
                                    <div class="flex justify-between items-center">
                                        <span class="font-medium text-gray-700 text-lg">Status Ruangan:</span>
                                        <span class="text-yellow-600 text-lg font-semibold">Booking</span>
                                    </div>
                                </div>
                                
                                <!-- Button Section -->
                                <div class="mt-8 text-center">
                                    <a href="{{ route('pinjam.ViewRuangan', ['id' => 2]) }}" class="bg-blue-600 text-white py-2 px-6 rounded-full hover:bg-blue-700 transition duration-300">
                                        Kembali ke Ruangan
                                    </a>
                                </div>
                            </div>
                        </section>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection

@section('scripts')
<script>
    // Your custom JavaScript can go here.
</script>
@endsection
