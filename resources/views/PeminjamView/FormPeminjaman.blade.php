@extends('layout.TemplatePeminjam')

@section('content')
<style>
    .alat-misa-gambar {
        max-width: 200px;
        max-height: 150px;
        width: auto;
        height: auto;
        margin: 0 auto;
        display: none;
    }
</style>
<div class="container mx-auto py-8 px-4 sm:px-6 lg:px-8">
    <h2 class="text-3xl font-extrabold mb-8 text-center text-blue-600">Form Peminjaman</h2>

    <div class="bg-gradient-to-r from-blue-50 via-blue-100 to-blue-50 border border-gray-300 shadow-xl rounded-xl p-8">
        <form action="{{ route('peminjaman.store') }}" method="POST" class="space-y-8">
            @csrf
            <div>
                <label for="penanggung_jawab" class="block text-sm font-bold text-gray-700 mb-2">Penanggung Jawab</label>
                <input type="text" id="penanggung_jawab" name="penanggung_jawab" class="w-full max-w-md border border-gray-300 rounded-lg shadow-md p-3 focus:outline-none focus:ring-4 focus:ring-blue-300 transition-transform duration-200 transform hover:scale-105" placeholder="Masukkan nama penanggung jawab" required>
            </div>

            <!-- Divider -->
            <div class="border-t border-gray-300"></div>

            <!-- Pilih Jenis Peminjaman -->
            <div>
                <label for="jenis_peminjaman" class="block text-sm font-bold text-gray-700 mb-2">Jenis Peminjaman</label>
                <div class="relative">
                    <select id="jenis_peminjaman" name="jenis_peminjaman" class="w-full sm:w-72 border border-gray-300 rounded-lg shadow-md p-3 focus:outline-none focus:ring-4 focus:ring-blue-300 transition-transform duration-200 transform hover:scale-105">
                        <option value="ruangan">Ruangan</option>
                        <option value="alatMisa">Alat Misa</option>
                        <option value="perlengkapan">Perlengkapan</option>
                    </select>
                    <span class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                        <svg class="w-5 h-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </span>
                </div>
            </div>

            <!-- Form untuk Alat Misa -->
            <div id="alat-misa-fields" class="hidden">
                <label for="alat_misa" class="block text-sm font-bold text-gray-700 mb-2">Pilih Alat Misa</label>
                <select id="alat_misa" name="alat_misa" class="w-60 sm:w-96 border border-gray-300 rounded-lg shadow-md p-3 focus:outline-none focus:ring-4 focus:ring-blue-300 transition-transform duration-200 transform hover:scale-105">
                    <option value="Aspergilum">Aspergilum</option>
                    <option value="Sacramentarium">Sacramentarium</option>
                    <option value="Piala">Piala</option>
                    <option value="Purifikatiroum">Purifikatiroum</option>
                    <option value="Patena">Patena</option>
                    <option value="Corporale">Corporale </option>
                    <option value="Ampul">Ampul</option>
                    <option value="Lavabo">Lavabo</option>
                    <option value="Palla">Palla</option>
                    <option value="Sibori">Sibori</option>
                </select>

                <!-- Gambar Alat Misa -->
                <div id="alat_misa_gambar" class="mt-4">
                    <img id="gambar_Piala" src="{{ asset('Gambar/Piala.png') }}" class="alat-misa-gambar rounded-lg">
                    <img id="gambar_Sibori" src="{{ asset('Gambar/Sibori.png') }}" class="alat-misa-gambar rounded-lg">
                    <img id="gambar_Ampul" src="{{ asset('Gambar/Ampul.png') }}" class="alat-misa-gambar rounded-lg">
                    <img id="gambar_Lavabo" src="{{ asset('Gambar/Lavabo.png') }}" class="alat-misa-gambar rounded-lg">
                    <img id="gambar_Purifikatiroum" src="{{ asset('Gambar/Purifikatorium.png') }}" class="alat-misa-gambar rounded-lg">
                    <img id="gambar_Patena" src="{{ asset('Gambar/Patena.png') }}" class="alat-misa-gambar rounded-lg">
                    <img id="gambar_Palla" src="{{ asset('Gambar/Palla.png') }}" class="alat-misa-gambar rounded-lg">
                    <img id="gambar_Corporale" src="{{ asset('Gambar/Corporal.png') }}" class="alat-misa-gambar rounded-lg">
                </div>
            </div>

            <!-- Form untuk Asset -->
            <div id="perlengkapan-fields" class="hidden">
                <label for="perlengkapan" class="block text-sm font-bold text-gray-700 mb-2">Pilih Perlengkapan</label>
                <select id="perlengkapan" name="perlengkapan" class="w-80 sm:w-96 border border-gray-300 rounded-lg shadow-md p-3 focus:outline-none focus:ring-4 focus:ring-blue-300 transition-transform duration-200 transform hover:scale-105">
                    <option value="Kursi">Kursi</option>
                    <option value="Meja">Meja</option>
                    <option value="Proyektor">Proyektor</option>
                    <option value="Speaker">Speaker</option>
                    <option value="Microfon">Microfon</option>
                </select>

                <div class="mt-4">
                    <label for="jumlah_perlengkapan" class="block text-sm font-bold text-gray-700 mb-2">Jumlah</label>
                    <input type="number" id="jumlah_perlengkapan" name="jumlah_perlengkapan" class="w-80 sm:w-96 border border-gray-300 rounded-lg shadow-md p-3 focus:outline-none focus:ring-4 focus:ring-blue-300 transition-transform duration-200 transform hover:scale-105" min="1">
                    <p class="text-sm text-gray-600 mt-1">Stok tersedia: 10</p>
                </div>
            </div>

            <!-- Form untuk Ruangan -->
            <div id="ruangan-fields" class="hidden">
                <label for="ruangan" class="block text-sm font-bold text-gray-700 mb-2">Pilih Ruangan</label>
                <select id="ruangan" name="ruangan" class="w-80 sm:w-96 border border-gray-300 rounded-lg shadow-md p-3 focus:outline-none focus:ring-4 focus:ring-blue-300 transition-transform duration-200 transform hover:scale-105">
                    <option value="1">Ruangan Aula</option>
                </select>
                <label for="alasan" class="block text-sm font-bold text-gray-700 mb-2">Alasan Peminjaman</label>
                <input type="text" id="" name="alasan" class="w-full max-w-md border border-gray-300 rounded-lg shadow-md p-3 focus:outline-none focus:ring-4 focus:ring-blue-300 transition-transform duration-200 transform hover:scale-105" placeholder="Berikan Alasan Anda " required>
            </div>

            <!-- Grid untuk Tanggal -->
            <div class="mt-4 grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label for="tanggal_mulai" class="block text-sm font-bold text-gray-700 mb-2">Tanggal Mulai</label>
                    <input type="date" id="tanggal_mulai" name="tanggal_mulai" class="w-full border border-gray-300 rounded-lg shadow-md p-3 focus:outline-none focus:ring-4 focus:ring-blue-300 transition-transform duration-200 transform hover:scale-105">
                </div>
                <div>
                    <label for="tanggal_selesai" class="block text-sm font-bold text-gray-700 mb-2">Tanggal Selesai</label>
                    <input type="date" id="tanggal_selesai" name="tanggal_selesai" class="w-full border border-gray-300 rounded-lg shadow-md p-3 focus:outline-none focus:ring-4 focus:ring-blue-300 transition-transform duration-200 transform hover:scale-105">
                </div>
            </div>
                        <!-- Grid untuk Jam -->
                        <div class="mt-4 grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label for="jam_mulai" class="block text-sm font-bold text-gray-700 mb-2">Jam Mulai</label>
                        <input type="time" id="jam_mulai" name="jam_mulai" class="w-full border border-gray-300 rounded-lg shadow-md p-3 focus:outline-none focus:ring-4 focus:ring-blue-300 transition-transform duration-200 transform hover:scale-105">
                    </div>
                    <div>
                        <label for="jam_selesai" class="block text-sm font-bold text-gray-700 mb-2">Jam Selesai</label>
                        <input type="time" id="jam_selesai" name="jam_selesai" class="w-full border border-gray-300 rounded-lg shadow-md p-3 focus:outline-none focus:ring-4 focus:ring-blue-300 transition-transform duration-200 transform hover:scale-105">
                    </div>
                </div>
            </div>





<!-- Form untuk submit ke server -->
<form id="peminjaman-form" action="{{ route('peminjaman.store') }}" method="POST" class="space-y-8">
    @csrf
    <!-- Form fields here -->

    <div class="mt-8 text-center">
        <button id="add-to-cart-btn" type="button" class="px-6 py-3 text-lg font-medium text-white bg-blue-600 hover:bg-blue-700 rounded-lg shadow-md focus:outline-none focus:ring-4 focus:ring-blue-300">
            Masukkan Keranjang
        </button>
    </div>
</form>

<!-- Popup Notifikasi -->
<div id="popup-notification" class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 hidden z-50">
    <div class="bg-white rounded-xl shadow-2xl p-8 w-96 text-center relative">
        <!-- Dekorasi Lingkaran dengan Ceklis -->
        <div class="flex items-center justify-center -mt-12">
            <div class="bg-blue-100 rounded-full p-6 shadow-md">
                <svg class="w-16 h-16 text-blue-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                </svg>
            </div>
        </div>
        <!-- Pesan -->
        <div class="mt-6">
            <h3 class="text-2xl font-semibold text-gray-800">Berhasil Ditambahkan!</h3>
            <p class="text-sm text-gray-600 mt-2">
                Item telah berhasil dimasukkan ke keranjang Anda. Jangan lupa untuk segera menyelesaikan pembelian!
            </p>
            <!-- Tombol -->
            <button id="popup-close-btn" 
                    class="mt-6 w-full px-6 py-3 bg-gradient-to-r from-blue-500 to-blue-600 text-white font-semibold rounded-lg shadow-lg hover:from-blue-600 hover:to-blue-700 transition duration-300 transform hover:scale-105">
                OK
            </button>
        </div>
    </div>
</div>

<script>
    document.getElementById('jenis_peminjaman').addEventListener('change', function() {
        var selectedValue = this.value;
        document.getElementById('alat-misa-fields').classList.add('hidden');
        document.getElementById('perlengkapan-fields').classList.add('hidden');
        document.getElementById('ruangan-fields').classList.add('hidden');

        if (selectedValue === 'alatMisa') {
            document.getElementById('alat-misa-fields').classList.remove('hidden');
        } else if (selectedValue === 'perlengkapan') {
            document.getElementById('perlengkapan-fields').classList.remove('hidden');
        } else {
            document.getElementById('ruangan-fields').classList.remove('hidden');
        }
    });

    document.getElementById('alat_misa').addEventListener('change', function() {
        var selectedAlat = this.value;
        var allImages = document.querySelectorAll('.alat-misa-gambar');
        allImages.forEach(function(image) {
            image.style.display = 'none';
        });

        var selectedImage = document.getElementById('gambar_' + selectedAlat);
        if (selectedImage) {
            selectedImage.style.display = 'block';
        }
    });
     // Show popup notification after "Masukkan Keranjang" button is clicked
    document.getElementById('add-to-cart-btn').addEventListener('click', function() {
        // Prevent form submission
        event.preventDefault();

        // Show the popup
        const popup = document.getElementById("popup-notification");
        popup.classList.remove("hidden");
        popup.classList.add("fade-in");

        // Optionally, submit the form after showing the popup (if needed)
        // setTimeout(function() {
        //     document.getElementById('peminjaman-form').submit();
        // }, 2000); // Delay for 2 seconds before submitting the form (optional)
    });

    // Close the popup when "OK" button is clicked
    document.getElementById("popup-close-btn").addEventListener("click", function () {
        const popup = document.getElementById("popup-notification");
        popup.classList.add("hidden");
    });

    // Add fade-in animation to popup
    const style = document.createElement("style");
    style.innerHTML = `
        .fade-in {
            animation: fadeIn 0.5s ease-in-out;
        }
        @keyframes fadeIn {
            from { opacity: 0; transform: scale(0.95); }
            to { opacity: 1; transform: scale(1); }
        }
    `;
    document.head.appendChild(style);
</script>
@endsection
