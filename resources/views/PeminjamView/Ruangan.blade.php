@extends('layout.TemplatePeminjam')
@section('title', 'Input')
@section('content')

<script src="https://cdn.tailwindcss.com"></script>
<style>


    .card {
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        background: #f9fafb;
        background-image: linear-gradient(45deg, rgba(255, 255, 255, 0.1) 25%, transparent 25%, transparent 50%, rgba(255, 255, 255, 0.1) 50%, rgba(255, 255, 255, 0.1) 75%, transparent 75%, transparent);
        background-size: 40px 40px;
    }

    .card:hover {
        transform: translateY(-10px);
        box-shadow: 0 12px 25px rgba(0, 0, 0, 0.3);
    }


</style>

<section class="p-8 min-h-screen">
<div class="bg-white border border-4 rounded-lg shadow relative m-10">

    <div class="flex items-start justify-between p-5 border-b rounded-t">
        <h3 class="text-xl font-semibold">
           FORM PEMINJAMAN RUANGAN
        </h3>
   
        
    </div>
    <h3 class="text-3xl font-semibold text-center">
           Ruangan AULA
        </h3>
    <div class="p-6 space-y-6">
        <form action="#">
            <div class="grid grid-cols-6 gap-6">
                <div class="col-span-6 sm:col-span-3">
                    <label for="PenanggungJawab" class="text-sm font-medium text-gray-900 block mb-2">Penanggung Jawab</label>
                    <input type="text" name="PenanggungJawab" id="PenanggungJawab" class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-cyan-600 focus:border-cyan-600 block w-full p-2.5" placeholder="Input Penanggung jawab" required="">
                </div>
                <div class="col-span-6 sm:col-span-3">
                    <label for="tanggal_mulai" class="text-sm font-medium text-gray-900 block mb-2">Tanggal Mulai</label>
                    <input type="date" name="tanggal_mulai" id="tanggal_mulai" class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-cyan-600 focus:border-cyan-600 block w-full p-2.5" placeholder="Electronics" required="">
                </div>
                <div class="col-span-6 sm:col-span-3">
                    <label for="tanggal_selesai" class="text-sm font-medium text-gray-900 block mb-2">Jam Mulai</label>
                    <input type="date" name="brand" id="tanggal_selesai" class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-cyan-600 focus:border-cyan-600 block w-full p-2.5" placeholder="Apple" required="">
                </div>
                <div class="col-span-6 sm:col-span-3">
                    <label for="jam_mulai" class="text-sm font-medium text-gray-900 block mb-2">Tanggal selesai</label>
                    <input type="date" name="price" id="jam_mulai" class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-cyan-600 focus:border-cyan-600 block w-full p-2.5" placeholder="$2300" required="">
                </div>
                <div class="col-span-6 sm:col-span-3">
                    <label for="jam_selesai" class="text-sm font-medium text-gray-900 block mb-2">Jam Selesai</label>
                    <input type="time" name="price" id="jam_selesai" class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-cyan-600 focus:border-cyan-600 block w-full p-2.5" placeholder="$2300" required="">
                </div>
                <div class="col-span-full">
                    <label for="product-details" class="text-sm font-medium text-gray-900 block mb-2">Keperluan Peminjaman</label>
                    <textarea id="product-details" rows="6" class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-cyan-600 focus:border-cyan-600 block w-full p-4" placeholder="Details"></textarea>
                </div>
            </div>
        </form>
    </div>

    <div class="p-6 border-t border-gray-200 rounded-b flex justify-between">
    <button id="open-modal" class="text-white bg-cyan-600 hover:bg-cyan-700 focus:ring-4 focus:ring-cyan-200 font-medium rounded-lg text-sm px-5 py-2.5 text-center" type="submit">
        Ajukan Peminjaman
    </button>
    
    <a href="{{ route('pinjam.ViewRuangan') }}">
        <button id="open-modal" class="text-white bg-cyan-600 hover:bg-cyan-700 focus:ring-4 focus:ring-cyan-200 font-medium rounded-lg text-sm px-5 py-2.5 text-center" type="submit">
            Kembali
        </button>
    </a>
</div>


        </div>

        <!-- Modal Konfirmasi -->
        <div id="confirmation-modal" class="fixed inset-0 flex items-center justify-center bg-gray-800 bg-opacity-75 hidden">

            <div class="modal-content">
                <h2>Apakah Anda Yakin?</h2>
                <p>Data yang dimasukkan akan diajukan untuk peminjaman ruangan.</p>
                <div class="flex gap-4 mt-4">
                    <button id="cancel-btn" class="w-32 py-2 bg-gray-400 text-white rounded-xl hover:bg-gray-500">Batal</button>
                    <button id="confirm-btn" class="w-32 py-2 bg-blue-600 text-white rounded-xl hover:bg-blue-700">Ya</button>
                </div>
            </div>
        </div>

        <!-- Popup Success Modal -->
        <div id="success-modal" class="fixed inset-0 flex items-center justify-center bg-gray-800 bg-opacity-50 hidden">
            <div class="modal-content">
                <div class="checkmark-circle">
                    <div class="background"></div>
                    <div class="checkmark draw"></div>
                </div>
                <h2>Pengajuan Peminjaman Berhasil</h2>
                <p>Peminjaman ruangan telah berhasil diajukan.</p>
                <button id="close-success-modal" class="mt-4 py-2 bg-blue-500 text-white rounded-xl hover:bg-blue-600">Tutup</button>
            </div>
        </div>
    </div>
</section>

<script>
    document.addEventListener('DOMContentLoaded', function() {
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
