@extends('layout.templateAuth')

@section('title', 'Login')

@section('content')
    <section class="flex items-center justify-center min-h-screen bg-[#7cb1ff]">
        <!-- Mengubah latar belakang menjadi biru muda -->
        <div
            class="bg-[#7cb1ff] rounded-2xl flex flex-col w-full max-w-md p-10 shadow-lg transition-transform duration-300 transform hover:scale-105">
            <!-- Ubah latar belakang div menjadi putih -->

            <h2 class="font-bold text-3xl text-[#002D74] text-center mb-4">Login</h2>

            <!-- SweetAlert2 Session Alerts -->
            @if (session('success'))
                <script>
                    Swal.fire({
                        title: 'Berhasil!',
                        text: "{{ session('success') }}",
                        icon: 'success',
                        confirmButtonText: 'OK'
                    });
                </script>
            @endif

            @if (session('error'))
                <script>
                    Swal.fire({
                        title: 'Error!',
                        text: "{{ session('error') }}",
                        icon: 'error',
                        confirmButtonText: 'OK'
                    });
                </script>
            @endif

            @if (session('message'))
                <script>
                    Swal.fire({
                        title: 'Informasi',
                        text: "{{ session('message') }}",
                        icon: 'info',
                        confirmButtonText: 'OK'
                    });
                </script>
            @endif


            <p class="text-sm mt-2 text-[#002D74] text-center">Sudah Punya Akun? Tinggal Login</p>

            <form method="POST" action="{{ route('login') }}" class="flex flex-col gap-4">
                @csrf
                <input
                    class="p-3 mt-5 rounded-xl border border-gray-300 focus:outline-none focus:ring-2 focus:ring-[#002D74]"
                    type="email" name="email" placeholder="Email" required>
                <div class="relative">
                    <input
                        class="p-3 rounded-xl border border-gray-300 focus:outline-none focus:ring-2 focus:ring-[#002D74] w-full"
                        type="password" name="password" id="password" placeholder="Password" required>

                    <!-- Mata terbuka -->
                    <svg id="eyeOpen" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="gray"
                        class="bi bi-eye absolute top-1/2 right-3 -translate-y-1/2 cursor-pointer z-20 hidden"
                        viewBox="0 0 16 16">
                        <path
                            d="M16 8s-3-5.5-8-5.5S0 8 0 8s3 5.5 8 5.5S16 8 16 8zM1.173 8a13.133 13.133 0 0 1 1.66-2.043C4.12 4.668 5.88 3.5 8 3.5c2.12 0 3.879 1.168 5.168 2.457A13.133 13.133 0 0 1 14.828 8c-.058.087-.122.183-.195.288-.335.48-.83 1.12-1.465 1.755C11.879 11.332 10.119 12.5 8 12.5c-2.12 0-3.879-1.168-5.168-2.457A13.134 13.134 0 0 1 1.172 8z">
                        </path>
                        <path d="M8 5.5a2.5 2.5 0 1 0 0 5 2.5 2.5 0 0 0 0-5zM4.5 8a3.5 3.5 0 1 1 7 0 3.5 3.5 0 0 1-7 0z">
                        </path>
                    </svg>

                    <!-- Mata tertutup -->
                    <svg id="eyeClosed" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="gray"
                        class="bi bi-eye-slash absolute top-1/2 right-3 -translate-y-1/2 cursor-pointer z-20"
                        viewBox="0 0 16 16">
                        <path
                            d="M13.359 11.238c.31-.415.582-.877.813-1.377-1.393-2.774-4.105-4.486-7.165-4.486-1.02 0-1.996.195-2.897.553L4.106 4.253c.911-.334 1.877-.526 2.88-.526 3.63 0 6.711 2.208 8.082 5.316a1.007 1.007 0 0 1 0 .789c-.246.586-.585 1.14-1.01 1.653l-.4-.398c-.24-.24-.556-.595-.879-.949zM3.708 3.707l-2.5 2.5a1 1 0 0 0 0 1.415l2.5 2.5a1 1 0 0 0 1.415 0L8 7.415l2.086 2.086a1 1 0 0 0 1.415 0l2.5-2.5a1 1 0 0 0 0-1.415l-2.5-2.5a1 1 0 0 0-1.415 0L8 4.586l-2.086-2.086a1 1 0 0 0-1.415 0L3.708 3.707z">
                        </path>
                    </svg>
                </div>

                <button
                    class="bg-[#002D74] text-white py-2 rounded-xl hover:scale-105 duration-300 hover:bg-[#206ab1] font-medium"
                    type="submit">Login</button>
            </form>

            <div class="mt-6 text-gray-100">
                <hr class="border-gray-300">
                <p class="text-center border-l-indigo-700 text-[#002D74]">OR</p>
                <hr class="border-gray-300">
            </div>

            <button id="resetPasswordButton" type="button"
                class="bg-white border border-gray-300 py-2 w-full rounded-xl mt-5 flex justify-center items-center text-sm hover:scale-105 duration-300 hover:bg-[#60a8bc4f] font-medium">
                <svg class="mr-3" xmlns="http://www.w3.org/2000/svg" fill="gray" viewBox="0 0 24 24" width="25px">
                    <path
                        d="M20 11h-1V7c0-2.21-1.79-4-4-4s-4 1.79-4 4v4H4c-1.1 0-2 .9-2 2v10c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V13c0-1.1-.9-2-2-2zm-10-4c0-1.1.9-2 2-2s2 .9 2 2v4h-4V7zm6 16H4v-8h12v8zm2-2v-8h-2v8h2z">
                    </path>
                </svg>
                Lupa Password?
            </button>

            <button id="registerButton" type="button"
                class="hover:border bg-[#002D74] text-white border-gray-400 rounded-xl py-2 px-5 hover:scale-110 hover:bg-[#002c7424] font-semibold duration-300 mt-5 w-full">
                Register
            </button>

            <div class="mt-3 text-center">
                <p>Belum punya akun? <a href="{{ route('register') }}" class="text-[#002D74] underline">Daftar sekarang</a>
                </p>
                <p>Belum Bisa Login? Silahkan Hubungi Admin</p>
            </div>
        </div>
    </section>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Get the register button
            const registerButton = document.getElementById('registerButton');
            const resetPasswordButton = document.getElementById('resetPasswordButton');

            // Add click event for the register button
            registerButton.addEventListener('click', function() {
                window.location.href = '{{ route('register') }}';
            });

            // Add click event for the reset password button
            resetPasswordButton.addEventListener('click', function() {
                window.location.href = '{{ route('password.request') }}';
            });

            const passwordInput = document.getElementById('password');
            const eyeOpen = document.getElementById('eyeOpen');
            const eyeClosed = document.getElementById('eyeClosed');

            // Toggle password visibility and icon
            eyeOpen.addEventListener('click', function() {
                passwordInput.type = 'password';
                eyeOpen.classList.add('hidden');
                eyeClosed.classList.remove('hidden');
            });

            eyeClosed.addEventListener('click', function() {
                passwordInput.type = 'text';
                eyeClosed.classList.add('hidden');
                eyeOpen.classList.remove('hidden');
            });

        });
    </script>
@endsection
