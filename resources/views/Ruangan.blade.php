@extends('layout.TemplatePeminjam')
@section('title', 'Input')
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

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">

<section class="p-6 bg-gray-100 min-h-screen">
    <div class="bg-cover bg-white bg-center w-full h-full min-h-screen">
        <div id="main-content" class="main-content p-4 md:p-8 relative pt-16 min-h-screen">
            <div class="flex justify-center items-center p-9">
                <div class="border-4 border-gray-800 rounded-full py-4 px-8 inline-block mx-auto text-center">
                    <h1 id="room-title" class="text-3xl md:text-6xl font-semibold text-gray-700 text-center">Ruangan</h1>
                </div>
            </div>

            <hr class="my-6 text-gray-800 font-bold">
            
            <div class="bg-blue-200 rounded-3xl shadow-lg p-4 md:p-6 text-center">
                <div class="flex justify-center mb-6">
                    <button class="w-full py-2 border border-gray-300 text-4xl font-medium text-gray-800 rounded-md">Ruangan $</button>
                </div>

                <!-- Grid untuk input tanggal dan jam -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                    <div class="flex flex-col">
                        <label class="block text-gray-800 text-sm mb-1 font-bold">Penanggung jawab</label>
                        <input type="text" placeholder="Input penanggung jawab" class="w-full px-3 py-2 border border-gray-300 rounded-md text-gray-700 bg-gray-100 focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>

                    <div class="flex flex-col">
                        <label class="block text-gray-800 text-sm mb-1 font-bold">Tanggal Mulai Peminjaman</label>
                        <div class="relative">
                            <input name="tanggal_mulai" type="text" placeholder="DD/MM/YYYY" class="w-full pl-10 px-3 py-2 border border-gray-300 rounded-md text-gray-700 bg-gray-100 focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <i class="bi bi-calendar absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-500"></i>
                        </div>
                    </div>

                    <div class="flex flex-col">
                        <label class="block text-gray-800 text-sm mb-1 font-bold">Tanggal Selesai Peminjaman</label>
                        <div class="relative">
                            <input name="tanggal_selesai" type="text" placeholder="DD/MM/YYYY" class="w-full pl-10 px-3 py-2 border border-gray-300 rounded-md text-gray-700 bg-gray-100 focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <i class="bi bi-calendar absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-500"></i>
                        </div>
                    </div>
                </div>

                <!-- Grid untuk jam mulai dan jam selesai -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                    <div class="flex flex-col">
                        <label class="block text-gray-800 text-sm mb-1 font-bold">Jam Mulai Peminjaman</label>
                        <div class="relative">
                            <input name="jam_mulai" type="text" placeholder="00:00 WIB" class="w-full pl-10 px-3 py-2 border border-gray-300 rounded-md text-gray-700 bg-gray-100 focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <i class="bi bi-stopwatch absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-500"></i>
                        </div>
                    </div>

                    <div class="flex flex-col">
                        <label class="block text-gray-800 text-sm mb-1 font-bold">Jam Selesai Peminjaman</label>
                        <div class="relative">
                            <input name="jam_selesai" type="number" placeholder="00:00 WIB" class="w-full pl-10 px-3 py-2 border border-gray-300 rounded-md text-gray-700 bg-gray-100 focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <i class="bi bi-stopwatch absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-500"></i>
                        </div>
                    </div>
                </div>

                <div>
                    <label class="block text-gray-800 text-sm mb-1 font-bold">Keperluan Peminjaman</label>
                    <textarea placeholder="Tuliskan keterangan peminjaman" class="w-full h-40 px-3 py-2 border border-gray-300 rounded-md text-gray-700 bg-gray-100 focus:outline-none focus:ring-2 focus:ring-blue-500"></textarea>
                </div>

                <!-- Buttons -->
                <div class="flex justify-between items-center space-x-4">
                    <button id="open-modal" class="w-full md:w-40 h-16 py-2 bg-blue-600 text-white rounded-md hover:bg-gray-600 focus:outline-none font-bold">
                        Ajukan Peminjaman
                    </button>
                    <button class="w-full md:w-40 h-16 bg-blue-600 text-white rounded-md hover:bg-gray-600 focus:outline-none font-bold">
                        Reset
                    </button>
                </div>
            </div>

            <!-- Modal Konfirmasi -->
            <div id="confirmation-modal" class="fixed inset-0 flex items-center justify-center bg-gray-800 bg-opacity-50 hidden">
                <div class="bg-white rounded-lg p-6 w-96 text-center">
                    <h2 class="text-lg font-semibold mb-4 text-gray-800">Apakah Anda Yakin?</h2>
                    <p class="text-gray-800">Data yang dimasukkan akan diajukan untuk peminjaman ruangan.</p>
                    <div class="flex justify-between mt-4">
                        <button id="cancel-btn" class="w-40 py-2 bg-gray-400 text-white rounded-md hover:bg-gray-600">Batal</button>
                        <button id="confirm-btn" class="w-40 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-800">Ya</button>
                    </div>
                </div>
            </div>

            <!-- Popup Success Modal -->
            <div id="success-modal" class="fixed inset-0 flex items-center justify-center bg-gray-800 bg-opacity-50 hidden">
                <div class="bg-white rounded-lg p-6 w-96 text-center">
                    <div class="flex justify-center mb-4">
                        <div class="checkmark-circle">
                            <div class="background"></div>
                            <div class="checkmark draw"></div>
                        </div>
                    </div>
                    <h2 class="text-lg font-semibold mb-4 text-gray-800">Pengajuan Peminjaman Berhasil</h2>
                    <p class="text-gray-800">Peminjaman ruangan telah berhasil diajukan.</p>
                    <button id="close-success-modal" class="mt-4 bg-blue-500 text-white px-4 py-2 rounded-md">Tutup</button>
                </div>
            </div>

            <footer class="bg-gray-800 text-white py-2 text-center">
                <p>&copy; {{ date('Y') }} Babadan Application. All rights reserved.</p>
            </footer>
        </div>
    </div>
</section>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Menangani modal konfirmasi
        document.getElementById("open-modal").addEventListener("click", function() {
            document.getElementById("confirmation-modal").classList.remove("hidden");
        });

        document.getElementById("cancel-btn").addEventListener("click", function() {
            document.getElementById("confirmation-modal").classList.add("hidden");
        });

        document.getElementById("confirm-btn").addEventListener("click", function() {
            document.getElementById("confirmation-modal").classList.add("hidden");
            document.getElementById("success-modal").classList.remove("hidden");
        });

        document.getElementById("close-success-modal").addEventListener("click", function() {
            document.getElementById("success-modal").classList.add("hidden");
        });

        flatpickr("input[name='tanggal_mulai'], input[name='tanggal_selesai']", {
            dateFormat: "d/m/Y",
            allowInput: true
        });

        flatpickr("input[name='jam_mulai'], input[name='jam_selesai']", {
            enableTime: true,
            noCalendar: true,
            dateFormat: "H:i",
            allowInput: true,
            time_24hr: true
        });

        // Validasi input angka
        const inputs = document.querySelectorAll('input[type="number"], input[type="text"]');
        inputs.forEach(input => {
            input.addEventListener('blur', function() {
                if (input.type === "number" && isNaN(input.value) && input.value !== '') {
                    input.setCustomValidity('Input harus berupa angka');
                } else {
                    input.setCustomValidity('');
                }
            });
        });
    });
</script>

@endsection
