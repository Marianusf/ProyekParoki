@extends('layout.templateAuth')

@section('title', 'Registrasi')

@section('content')
    <section class="flex items-center justify-center min-h-screen bg-[#7cb1ff]"> <!-- Changed to light blue -->
        <div
            class="bg-[#7cb1ff] rounded-2xl flex flex-col w-full p-20 shadow-lg transition-transform duration-300 transform hover:scale-105">
            <!-- Inner container white -->
            @if ($errors->any())
                <div class="bg-red-500 text-white p-4 rounded mb-4">
                    {{ $errors->first() }}
                </div>
            @endif
            @if (session('message'))
                <div class="bg-green-500 text-white p-2 rounded mb-4">
                    {{ session('message') }}
                </div>
            @endif

            <h2 class="text-lg font-bold text-gray-800 mb-1">SISTEM PEMINJAMAN GEREJA BABADAN</h2>
            <p class="text-sm text-gray-500 mb-8">PAROKI ST PETRUS DAN PAULUS</p>
            <h2 class="font-bold text-4xl text-[#002D74] text-center mb-4">Registrasi</h2>



            <form id="registerForm" method="POST" action="{{ route('register') }}" class="flex flex-col gap-6">
                @csrf
                <input class="p-3 rounded-xl border border-gray-300 focus:outline-none focus:ring-2 focus:ring-[#002D74]"
                    type="text" name="name" placeholder="Nama" required>
                <input class="p-3 rounded-xl border border-gray-300 focus:outline-none focus:ring-2 focus:ring-[#002D74]"
                    type="email" name="email" placeholder="Email" required>
                <input class="p-3 rounded-xl border border-gray-300 focus:outline-none focus:ring-2 focus:ring-[#002D74]"
                    type="date" name="tanggal_lahir" required>
                <input class="p-3 rounded-xl border border-gray-300 focus:outline-none focus:ring-2 focus:ring-[#002D74]"
                    type="text" name="alamat" placeholder="Alamat" required>
                <input class="p-3 rounded-xl border border-gray-300 focus:outline-none focus:ring-2 focus:ring-[#002D74]"
                    type="text" name="nomor_telepon" placeholder="Nomor Telepon" required>
                <input class="p-3 rounded-xl border border-gray-300 focus:outline-none focus:ring-2 focus:ring-[#002D74]"
                    type="text" name="lingkungan" placeholder="Nama Lingkungan" required>
                <!-- Input password dengan ikon mata -->
                <div class="relative">
                    <input
                        class="p-3 rounded-xl border border-gray-300 focus:outline-none focus:ring-2 focus:ring-[#002D74] w-full"
                        type="password" name="password" id="password" placeholder="Password" required>
                    <!-- Ikon mata terbuka -->
                    <svg id="eyeOpenPassword" xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                        fill="gray" class="bi bi-eye absolute top-1/2 right-3 -translate-y-1/2 cursor-pointer hidden"
                        viewBox="0 0 16 16">
                        <path
                            d="M16 8s-3-5.5-8-5.5S0 8 0 8s3 5.5 8 5.5S16 8 16 8zM1.173 8a13.133 13.133 0 0 1 1.66-2.043C4.12 4.668 5.88 3.5 8 3.5c2.12 0 3.879 1.168 5.168 2.457A13.133 13.133 0 0 1 14.828 8c-.058.087-.122.183-.195.288-.335.48-.83 1.12-1.465 1.755C11.879 11.332 10.119 12.5 8 12.5c-2.12 0-3.879-1.168-5.168-2.457A13.134 13.134 0 0 1 1.172 8z">
                        </path>
                        <path d="M8 5.5a2.5 2.5 0 1 0 0 5 2.5 2.5 0 0 0 0-5zM4.5 8a3.5 3.5 0 1 1 7 0 3.5 3.5 0 0 1-7 0z">
                        </path>
                    </svg>
                    <!-- Ikon mata tertutup -->
                    <svg id="eyeClosedPassword" xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                        fill="gray" class="bi bi-eye-slash absolute top-1/2 right-3 -translate-y-1/2 cursor-pointer"
                        viewBox="0 0 16 16">
                        <path
                            d="M13.359 11.238c.31-.415.582-.877.813-1.377-1.393-2.774-4.105-4.486-7.165-4.486-1.02 0-1.996.195-2.897.553L4.106 4.253c.911-.334 1.877-.526 2.88-.526 3.63 0 6.711 2.208 8.082 5.316a1.007 1.007 0 0 1 0 .789c-.246.586-.585 1.14-1.01 1.653l-.4-.398c-.24-.24-.556-.595-.879-.949zM3.708 3.707l-2.5 2.5a1 1 0 0 0 0 1.415l2.5 2.5a1 1 0 0 0 1.415 0L8 7.415l2.086 2.086a1 1 0 0 0 1.415 0l2.5-2.5a1 1 0 0 0 0-1.415l-2.5-2.5a1 1 0 0 0-1.415 0L8 4.586l-2.086-2.086a1 1 0 0 0-1.415 0L3.708 3.707z">
                        </path>
                    </svg>
                </div>
                <div class="relative">
                    <input
                        class="p-3 rounded-xl border border-gray-300 focus:outline-none focus:ring-2 focus:ring-[#002D74] w-full"
                        type="password" name="password_confirmation" id="confirmPassword" placeholder="Konfirmasi Password"
                        required>
                    <svg id="eyeOpenConfirmPassword" xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                        fill="gray" class="bi bi-eye absolute top-1/2 right-3 -translate-y-1/2 cursor-pointer hidden"
                        viewBox="0 0 16 16">
                        <path
                            d="M16 8s-3-5.5-8-5.5S0 8 0 8s3 5.5 8 5.5S16 8 16 8zM1.173 8a13.133 13.133 0 0 1 1.66-2.043C4.12 4.668 5.88 3.5 8 3.5c2.12 0 3.879 1.168 5.168 2.457A13.133 13.133 0 0 1 14.828 8c-.058.087-.122.183-.195.288-.335.48-.83 1.12-1.465 1.755C11.879 11.332 10.119 12.5 8 12.5c-2.12 0-3.879-1.168-5.168-2.457A13.134 13.134 0 0 1 1.172 8z">
                        </path>
                        <path d="M8 5.5a2.5 2.5 0 1 0 0 5 2.5 2.5 0 0 0 0-5zM4.5 8a3.5 3.5 0 1 1 7 0 3.5 3.5 0 0 1-7 0z">
                        </path>
                    </svg>
                    <svg id="eyeClosedConfirmPassword" xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                        fill="gray" class="bi bi-eye-slash absolute top-1/2 right-3 -translate-y-1/2 cursor-pointer"
                        viewBox="0 0 16 16">
                        <path
                            d="M13.359 11.238c.31-.415.582-.877.813-1.377-1.393-2.774-4.105-4.486-7.165-4.486-1.02 0-1.996.195-2.897.553L4.106 4.253c.911-.334 1.877-.526 2.88-.526 3.63 0 6.711 2.208 8.082 5.316a1.007 1.007 0 0 1 0 .789c-.246.586-.585 1.14-1.01 1.653l-.4-.398c-.24-.24-.556-.595-.879-.949zM3.708 3.707l-2.5 2.5a1 1 0 0 0 0 1.415l2.5 2.5a1 1 0 0 0 1.415 0L8 7.415l2.086 2.086a1 1 0 0 0 1.415 0l2.5-2.5a1 1 0 0 0 0-1.415l-2.5-2.5a1 1 0 0 0-1.415 0L8 4.586l-2.086-2.086a1 1 0 0 0-1.415 0L3.708 3.707z">
                        </path>
                    </svg>
                </div>

                <button id="registerButton" type="submit"
                    class="bg-[#002D74] text-white py-3 rounded-xl hover:scale-105 duration-300 hover:bg-[#206ab1] font-medium text-lg">Daftar</button>
            </form>

            <div class="mt-6 text-center">
                <p>Sudah punya akun? <a href="{{ route('login') }}" class="text-[#002D74] underline">Login sekarang</a></p>
            </div>
        </div>
    </section>

@section('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const registerButton = document.getElementById('registerButton');
            const registerForm = document.getElementById('registerForm');

            registerButton.addEventListener('click', function(event) {
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
            //ini untuk validasi ikon tutup mata buka mata password
            const passwordInput = document.getElementById('password');
            const eyeOpenPassword = document.getElementById('eyeOpenPassword');
            const eyeClosedPassword = document.getElementById('eyeClosedPassword');

            const confirmPasswordInput = document.getElementById('confirmPassword');
            const eyeOpenConfirmPassword = document.getElementById('eyeOpenConfirmPassword');
            const eyeClosedConfirmPassword = document.getElementById('eyeClosedConfirmPassword');

            eyeClosedPassword.addEventListener('click', () => {
                passwordInput.type = 'text';
                eyeClosedPassword.classList.add('hidden');
                eyeOpenPassword.classList.remove('hidden');
            });

            eyeOpenPassword.addEventListener('click', () => {
                passwordInput.type = 'password';
                eyeOpenPassword.classList.add('hidden');
                eyeClosedPassword.classList.remove('hidden');
            });

            eyeClosedConfirmPassword.addEventListener('click', () => {
                confirmPasswordInput.type = 'text';
                eyeClosedConfirmPassword.classList.add('hidden');
                eyeOpenConfirmPassword.classList.remove('hidden');
            });

            eyeOpenConfirmPassword.addEventListener('click', () => {
                confirmPasswordInput.type = 'password';
                eyeOpenConfirmPassword.classList.add('hidden');
                eyeClosedConfirmPassword.classList.remove('hidden');
            });
        });
    </script>
@endsection
@endsection
