@extends('layout.templateAuth')

@section('title', 'Registrasi')

@section('content')
    <section class="flex items-center justify-center min-h-screen bg-[#7cb1ff]"> <!-- Changed to light blue -->
        <div
            class="bg-[#7cb1ff] rounded-2xl flex flex-col w-full p-20 shadow-lg transition-transform duration-300 transform hover:scale-105">
            <!-- Inner container white -->
            @if ($errors->any())
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                    <strong class="font-bold">Pemberitahuan: </strong>
                    <span class="block sm:inline">{{ $errors->first() }}</span>
                </div>
            @endif

            @if (session('message'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                    <strong class="font-bold">Informasi: </strong>
                    <span class="block sm:inline">{{ session('message') }}</span>
                </div>
            @endif

            <h2 class="text-lg font-bold text-gray-800 mb-1">SISTEM PEMINJAMAN GEREJA BABADAN</h2>
            <p class="text-sm text-gray-500 mb-8">PAROKI ST PETRUS DAN PAULUS</p>
            <h2 class="font-bold text-4xl text-[#002D74] text-center mb-4">Registrasi</h2>



            <form id="registerForm" method="POST" action="{{ route('register') }}" class="flex flex-col gap-6">
                @csrf
                <!-- Nama -->
                <div>
                    <input
                        class="p-3 rounded-xl border border-gray-300 focus:outline-none focus:ring-2 focus:ring-[#002D74] w-full"
                        type="text" name="name" placeholder="Nama" required>
                    <span class="text-red-500 text-sm hidden" id="nameError">Nama wajib diisi.</span>
                </div>

                <!-- Email -->
                <div>
                    <input
                        class="p-3 rounded-xl border border-gray-300 focus:outline-none focus:ring-2 focus:ring-[#002D74] w-full"
                        type="email" name="email" placeholder="Email" required>
                    <span class="text-red-500 text-sm hidden" id="emailError">Masukkan email yang valid.</span>
                </div>

                <!-- Tanggal Lahir -->
                <div>
                    <input
                        class="p-3 rounded-xl border border-gray-300 focus:outline-none focus:ring-2 focus:ring-[#002D74] w-full"
                        type="date" name="tanggal_lahir" required>
                    <span class="text-red-500 text-sm hidden" id="tanggalLahirError">Tanggal lahir wajib diisi.</span>
                </div>

                <!-- Alamat -->
                <div>
                    <input
                        class="p-3 rounded-xl border border-gray-300 focus:outline-none focus:ring-2 focus:ring-[#002D74] w-full"
                        type="text" name="alamat" placeholder="Alamat" required>
                    <span class="text-red-500 text-sm hidden" id="alamatError">Alamat wajib diisi.</span>
                </div>

                <!-- Nomor Telepon -->
                <div>
                    <input
                        class="p-3 rounded-xl border border-gray-300 focus:outline-none focus:ring-2 focus:ring-[#002D74] w-full"
                        type="text" name="nomor_telepon" placeholder="Nomor Telepon" required>
                    <span class="text-red-500 text-sm hidden" id="teleponError">Nomor telepon wajib diisi.</span>
                </div>

                <!-- Nama Lingkungan -->
                <div>
                    <input
                        class="p-3 rounded-xl border border-gray-300 focus:outline-none focus:ring-2 focus:ring-[#002D74] w-full"
                        type="text" name="lingkungan" placeholder="Nama Lingkungan" required>
                    <span class="text-red-500 text-sm hidden" id="lingkunganError">Nama lingkungan wajib diisi.</span>
                </div>

                <!-- Password -->
                <div class="relative">
                    <input
                        class="p-3 rounded-xl border border-gray-300 focus:outline-none focus:ring-2 focus:ring-[#002D74] w-full"
                        type="password" name="password" id="password" placeholder="Password" required>
                    <span class="text-red-500 text-sm hidden" id="passwordError">Password wajib diisi.</span>
                </div>

                <!-- Konfirmasi Password -->
                <div class="relative">
                    <input
                        class="p-3 rounded-xl border border-gray-300 focus:outline-none focus:ring-2 focus:ring-[#002D74] w-full"
                        type="password" name="password_confirmation" id="confirmPassword" placeholder="Konfirmasi Password"
                        required>
                    <span class="text-red-500 text-sm hidden" id="confirmPasswordError">Konfirmasi password wajib diisi dan
                        harus cocok.</span>
                </div>

                <button id="registerButton" type="submit"
                    class="bg-[#002D74] text-white py-3 rounded-xl hover:scale-105 duration-300 hover:bg-[#206ab1] font-medium text-lg w-full">Daftar</button>
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
        document.querySelectorAll('#registerForm input').forEach(input => {
            input.addEventListener('blur', function() {
                // Nama
                if (input.name === 'name') {
                    document.getElementById('nameError').style.display = input.value ? 'none' : 'block';
                }
                // Email
                if (input.name === 'email') {
                    const emailValid = /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(input.value);
                    document.getElementById('emailError').style.display = emailValid ? 'none' : 'block';
                }
                // Tanggal Lahir
                if (input.name === 'tanggal_lahir') {
                    document.getElementById('tanggalLahirError').style.display = input.value ? 'none' :
                        'block';
                }
                // Alamat
                if (input.name === 'alamat') {
                    document.getElementById('alamatError').style.display = input.value ? 'none' : 'block';
                }
                // Nomor Telepon
                if (input.name === 'nomor_telepon') {
                    document.getElementById('teleponError').style.display = input.value ? 'none' : 'block';
                }
                // Nama Lingkungan
                if (input.name === 'lingkungan') {
                    document.getElementById('lingkunganError').style.display = input.value ? 'none' :
                        'block';
                }
                // Password
                if (input.name === 'password') {
                    document.getElementById('passwordError').style.display = input.value ? 'none' : 'block';
                }
                // Konfirmasi Password
                if (input.name === 'password_confirmation') {
                    const confirmPasswordMatch = input.value === document.getElementById('password').value;
                    document.getElementById('confirmPasswordError').style.display = confirmPasswordMatch ?
                        'none' : 'block';
                }
            });
        });
    </script>
@endsection
@endsection
