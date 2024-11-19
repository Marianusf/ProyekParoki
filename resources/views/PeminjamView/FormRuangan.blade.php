@extends('layout.TemplatePeminjam')
@section('title', 'Input')
@section('content')


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

    .modal-content {
        background-color: #fff;
        padding: 20px;
        border-radius: 8px;
        text-align: center;
    }

    /* Animasi ceklis */
    .checkmark-circle {
        width: 80px;
        height: 80px;
        border-radius: 50%;
        display: inline-block;
        position: relative;
        background-color: #4caf50;
        margin: 0 auto;
        animation: pop 0.4s ease-out;
    }

    .checkmark {
        display: inline-block;
        width: 20px;
        height: 45px;
        border-right: 5px solid #fff;
        border-bottom: 5px solid #fff;
        position: absolute;
        top: 20px; /* Sesuaikan posisi vertikal */
        left: 45px; 
        transform: rotate(45deg);
        transform-origin: left top;
        animation: checkmark-stroke 0.3s ease-out forwards;
    }

    @keyframes pop {
        0% { transform: scale(0.5); opacity: 0; }
        100% { transform: scale(1); opacity: 1; }
    }

    @keyframes checkmark-stroke {
        0% { width: 0; height: 0; opacity: 1; }
        50% { width: 0; height: 25px; opacity: 1; }
        100% { width: 20px; height: 45px; opacity: 1; }
    }
</style>

<section class="max-w-4xl p-6 mx-auto bg-indigo-600 rounded-md shadow-md dark:bg-gray-800 mt-20 pb-20">

    <h1 class="flex justify-center text-xl font-bold text-white capitalize dark:text-white">FORM PEMINJAMAN RUANGAN</h1>
    <h1 class="flex justify-center text-xl font-bold text-white capitalize dark:text-white mt-4">RUANGAN AULA</h1>
   
    <form>
        <div class="grid grid-cols-1 gap-6 mt-4 sm:grid-cols-2">
            <div>
                <label class="text-white dark:text-gray-200" for="PenanggungJawab">Penanggung Jawab</label>
                <input id="PenanggungJawab" placeholder="Input Penanggung Jawab" type="text" class="block w-full px-4 py-2 mt-2 text-black bg-white border border-gray-300 rounded-md dark:bg-gray-300 dark:text-gray-900 dark:border-gray-600 focus:border-blue-500 dark:focus:border-blue-500 focus:outline-none focus:ring">
            </div>

            <div>
                <label class="text-white dark:text-gray-200" for="Tanggal_mulai">Tanggal Mulai</label>
                <input id="tanggal_mulai" type="date" class="block w-full px-4 py-2 mt-2 text-gray-700 bg-white border border-gray-300 rounded-md dark:bg-gray-300 dark:text-gray-900 dark:border-gray-600 focus:border-blue-500 dark:focus:border-blue-500 focus:outline-none focus:ring">
            </div>
            <div>
                <label class="text-white dark:text-gray-200" for="Tanggal_selesai">Tanggal Selesai</label>
                <input id="Tanggal_selesai" type="date" class="block w-full px-4 py-2 mt-2 text-gray-700 bg-white border border-gray-300 rounded-md dark:bg-gray-300 dark:text-gray-900 dark:border-gray-600 focus:border-blue-500 dark:focus:border-blue-500 focus:outline-none focus:ring">
            </div>

            <div>
                <label class="text-white dark:text-gray-200" for="jam_mulai">Jam Mulai</label>
                <input id="jam_mulai" type="time" class="block w-full px-4 py-2 mt-2 text-gray-700 bg-white border border-gray-300 rounded-md dark:bg-gray-300 dark:text-gray-900 dark:border-gray-600 focus:border-blue-500 dark:focus:border-blue-500 focus:outline-none focus:ring">
            </div>

            <div>
                <label class="text-white dark:text-gray-200" for="jam_selesai">Jam Selesai</label>
                <input id="jam_selesai" type="time" class="block w-full px-4 py-2 mt-2 text-white bg-white border border-gray-300 rounded-md dark:bg-gray-300 dark:text-gray-900 dark:border-gray-600 focus:border-blue-500 dark:focus:border-blue-500 focus:outline-none focus:ring">
            </div>
    
            <div>
                <label class="text-white dark:text-gray-200" for="Keperluan">Keperluan Peminjaman</label>
                <textarea id="Keperluan" placeholder="Keperluan Peminjaman" class="block w-full px-4 py-2 mt-2 text-gray-900 bg-white border border-gray-300 rounded-md dark:bg-gray-300 dark:text-gray-900 dark:border-gray-600 focus:border-blue-500 dark:focus:border-blue-500 focus:outline-none focus:ring"></textarea>
            </div>
        </div>
        <div class="flex justify-between mt-6">
    <a href="{{ route('pinjam.ViewRuangan') }}">
        <button type="button" class="px-6 py-2 leading-5 text-gray-900 transition-colors duration-200 transform bg-gray-400 rounded-md hover:bg-blue-700 focus:outline-none focus:bg-gray-600">
            Kembali
        </button>
    </a>
    <button type="button" id="submit-request" class="px-6 py-2 leading-5 text-gray-900 transition-colors duration-200 transform bg-gray-400 rounded-md hover:bg-blue-700 focus:outline-none focus:bg-gray-600">
        Ajukan Peminjaman
    </button>
</div>

    </form>
</section>

<!-- Modal Konfirmasi -->
<div id="confirmation-modal" class="fixed inset-0 flex items-center justify-center bg-gray-800 bg-opacity-75 hidden">
    <div class="modal-content">
        <h2 class="text-lg font-bold">Apakah Anda Yakin?</h2>
        <p class="mt-2">Data yang dimasukkan akan diajukan untuk peminjaman ruangan.</p>
        <div class="flex justify-center gap-4 mt-6">
            <button id="cancel-btn" class="w-32 py-2 bg-gray-400 text-white rounded-xl hover:bg-gray-500">Batal</button>
            <button id="confirm-btn" class="w-32 py-2 bg-blue-600 text-white rounded-xl hover:bg-blue-700">Ya</button>
        </div>
    </div>
</div>


<!-- Popup Success Modal -->
<div id="success-modal" class="fixed inset-0 flex items-center justify-center bg-gray-800 bg-opacity-50 hidden">
    <div class="modal-content">
        <div class="checkmark-circle">
            <div class="checkmark"></div>
        </div>
        <h2>Pengajuan Peminjaman Berhasil</h2>
        <p>Peminjaman ruangan telah berhasil diajukan.</p>
        <button id="close-success-modal" class="mt-4 py-2 px-5 bg-blue-500 text-white rounded-xl hover:bg-blue-600">Tutup</button>
    </div>
</div>

<script>
    document.getElementById('submit-request').addEventListener('click', function () {
        document.getElementById('confirmation-modal').classList.remove('hidden');
    });

    document.getElementById('cancel-btn').addEventListener('click', function () {
        document.getElementById('confirmation-modal').classList.add('hidden');
    });

    document.getElementById('confirm-btn').addEventListener('click', function () {
        document.getElementById('confirmation-modal').classList.add('hidden');
        document.getElementById('success-modal').classList.remove('hidden');
    });

    document.getElementById('close-success-modal').addEventListener('click', function () {
        document.getElementById('success-modal').classList.add('hidden');
    });
</script>

@endsection
