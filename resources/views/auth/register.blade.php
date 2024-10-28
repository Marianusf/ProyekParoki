@extends('layout.templateAuth')

@section('title', 'Registrasi')

@section('content')
<section class="flex items-center justify-center min-h-screen bg-[#7cb1ff]"> <!-- Changed to light blue -->
    <div class="bg-[#7cb1ff] rounded-2xl flex flex-col w-full p-20 shadow-lg transition-transform duration-300 transform hover:scale-105"> <!-- Inner container white -->
        <h2 class="text-lg font-bold text-gray-800 mb-1">SISTEM PEMINJAMAN GEREJA BABADAN</h2>
        <p class="text-sm text-gray-500 mb-8">PAROKI ST PETRUS DAN PAULUS</p>
        <h2 class="font-bold text-4xl text-[#002D74] text-center mb-4">Registrasi</h2>

        @if ($errors->any())
            <div class="bg-red-500 text-white p-4 rounded mb-4">
                {{ $errors->first() }}
            </div>
        @endif

        <form id="registerForm" method="POST" action="{{ route('register') }}" class="flex flex-col gap-6">
            @csrf
            <input class="p-3 rounded-xl border border-gray-300 focus:outline-none focus:ring-2 focus:ring-[#002D74]" type="text" name="name" placeholder="Nama" required>
            <input class="p-3 rounded-xl border border-gray-300 focus:outline-none focus:ring-2 focus:ring-[#002D74]" type="email" name="email" placeholder="Email" required>
            <input class="p-3 rounded-xl border border-gray-300 focus:outline-none focus:ring-2 focus:ring-[#002D74]" type="date" name="tanggal_lahir" required>
            <input class="p-3 rounded-xl border border-gray-300 focus:outline-none focus:ring-2 focus:ring-[#002D74]" type="text" name="alamat" placeholder="Alamat" required>
            <input class="p-3 rounded-xl border border-gray-300 focus:outline-none focus:ring-2 focus:ring-[#002D74]" type="text" name="nomor_telepon" placeholder="Nomor Telepon" required>
            <input class="p-3 rounded-xl border border-gray-300 focus:outline-none focus:ring-2 focus:ring-[#002D74]" type="password" name="password" placeholder="Password" required>
            <input class="p-3 rounded-xl border border-gray-300 focus:outline-none focus:ring-2 focus:ring-[#002D74]" type="password" name="password_confirmation" placeholder="Konfirmasi Password" required>
            <button id="registerButton" type="submit" class="bg-[#002D74] text-white py-3 rounded-xl hover:scale-105 duration-300 hover:bg-[#206ab1] font-medium text-lg">Daftar</button>
        </form>
        
        <div class="mt-6 text-center">
            <p>Sudah punya akun? <a href="{{ route('login') }}" class="text-[#002D74] underline">Login sekarang</a></p>
        </div>
    </div>
</section>

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const registerButton = document.getElementById('registerButton');
        const registerForm = document.getElementById('registerForm');

        registerButton.addEventListener('click', function (event) {
            event.preventDefault(); // Mencegah form submit langsung

            Swal.fire({
                title: "Apakah anda Yakin?",
                text: "Kamu akan melakukan Pendaftaran Pada Akun Gereja Babadan",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Ya, Daftar!"
            }).then((result) => {
                if (result.isConfirmed) {
                    registerForm.submit(); // Menyubmit form jika konfirmasi diterima
                }
            });
        });
    });
</script>
@endsection
@endsection
