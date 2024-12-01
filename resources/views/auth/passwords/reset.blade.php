@extends('layout.templateAuth')

@section('title', 'Reset Password')

@section('content')
    <section class="flex items-center justify-center min-h-screen bg-[#7cb1ff]">
        <div
            class="bg-[#7cb1ff] rounded-2xl flex flex-col w-full p-20 shadow-lg transition-transform duration-300 transform hover:scale-105">
            @if (session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4"
                    role="alert">
                    <strong class="font-bold">Sukses: </strong>
                    <span class="block sm:inline">{{ session('success') }}</span>
                </div>
            @endif
            @if (session('message'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4"
                    role="alert">
                    <strong class="font-bold">PESAN: </strong>
                    <span class="block sm:inline">{{ session('message') }}</span>
                </div>
            @endif

            @if (session('error'))
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
                    <strong class="font-bold">Error: </strong>
                    <span class="block sm:inline">{{ session('error') }}</span>
                </div>
            @endif
            <h2 class="text-lg font-bold text-gray-800 mb-1">SISTEM PEMINJAMAN GEREJA BABADAN</h2>
            <p class="text-sm text-gray-500 mb-8">PAROKI ST PETRUS DAN PAULUS</p>
            <h2 class="font-bold text-4xl text-[#002D74] text-center mb-4">Reset Password</h2>



            <form id="gantiPasForm" method="POST" action="{{ route('password.update') }}"
                class="flex flex-col gap-6 p-8 bg-white rounded-xl shadow-md">
                @csrf
                <input type="hidden" name="token" value="{{ $token }}">

                <div class="form-group flex flex-col">
                    <label for="email" class="text-gray-700 font-medium mb-2">Email</label>
                    <input type="email" id="email" name="email" value="{{ old('email', $email) }}"
                        class="p-3 rounded-xl border border-gray-300 focus:outline-none focus:ring-2 focus:ring-[#002D74]"
                        required autofocus placeholder="Masukkan Email Anda">
                </div>

                <div class="relative">
                    <input
                        class="p-3 rounded-xl border border-gray-300 focus:outline-none focus:ring-2 focus:ring-[#002D74] w-full"
                        type="password" name="password" id="password" placeholder="Password" required>
                    <svg id="eyeOpenPassword" xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                        fill="gray" class="bi bi-eye absolute top-1/2 right-3 -translate-y-1/2 cursor-pointer hidden"
                        viewBox="0 0 16 16">
                        <path
                            d="M16 8s-3-5.5-8-5.5S0 8 0 8s3 5.5 8 5.5S16 8 16 8zM1.173 8a13.133 13.133 0 0 1 1.66-2.043C4.12 4.668 5.88 3.5 8 3.5c2.12 0 3.879 1.168 5.168 2.457A13.133 13.133 0 0 1 14.828 8c-.058.087-.122.183-.195.288-.335.48-.83 1.12-1.465 1.755C11.879 11.332 10.119 12.5 8 12.5c-2.12 0-3.879-1.168-5.168-2.457A13.134 13.134 0 0 1 1.172 8z">
                        </path>
                        <path d="M8 5.5a2.5 2.5 0 1 0 0 5 2.5 2.5 0 0 0 0-5zM4.5 8a3.5 3.5 0 1 1 7 0 3.5 3.5 0 0 1-7 0z">
                        </path>
                    </svg>
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

                <button id="gantiPasButton"
                    class="bg-[#002D74] text-white py-3 rounded-xl hover:scale-105 duration-300 hover:bg-[#206ab1] font-medium text-lg">
                    Reset Password
                </button>
            </form>


            <div class="mt-6 text-center">
                <p>Sudah ingat password? <a href="{{ route('login') }}" class="text-[#002D74] underline">Login sekarang</a>
                </p>
                <p>Belum punya akun? <a href="{{ route('register') }}" class="text-[#002D74] underline">Daftar sekarang</a>
                </p>
            </div>
        </div>
    </section>

@section('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const gantiPasButton = document.getElementById('gantiPasButton');
            const gantiPasForm = document.getElementById('gantiPasForm');

            if (gantiPasButton && gantiPasForm) {
                gantiPasButton.addEventListener('click', function(event) {
                    event.preventDefault();

                    Swal.fire({
                        title: "Apakah anda Yakin?",
                        text: "Kamu akan Reset Password akun paroki Babadan",
                        icon: "warning",
                        showCancelButton: true,
                        confirmButtonColor: "#3085d6",
                        cancelButtonColor: "#d33",
                        confirmButtonText: "Ya, Ganti!"
                    }).then((result) => {
                        if (result.isConfirmed) {
                            gantiPasForm.submit();
                        }
                    });
                });
            }
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
