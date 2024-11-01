@extends('layout.templateAuth')

@section('title', 'Login')

@section('content')
<section class="flex items-center justify-center min-h-screen bg-[#7cb1ff]"> <!-- Mengubah latar belakang menjadi biru muda -->
    <div class="bg-[#7cb1ff] rounded-2xl flex flex-col w-full max-w-md p-10 shadow-lg transition-transform duration-300 transform hover:scale-105"> <!-- Ubah latar belakang div menjadi putih -->
        
        <h2 class="font-bold text-3xl text-[#002D74] text-center mb-4">Login</h2>
        
        @if ($errors->any())
    <div class="bg-red-500 text-white p-4 rounded mb-4">
        {{ $errors->first() }} <!-- This will display the first error -->
    </div>
@endif

@if (session('message'))
    <div class="bg-yellow-500 text-white p-4 rounded mb-4">
        {{ session('message') }} <!-- This will display any flash message -->
    </div>
@endif

        <p class="text-sm mt-2 text-[#002D74] text-center">Sudah Punya Akun? Tinggal Login</p>
        
        <form method="POST" action="{{ route('login') }}" class="flex flex-col gap-4">
            @csrf
            <input class="p-3 mt-5 rounded-xl border border-gray-300 focus:outline-none focus:ring-2 focus:ring-[#002D74]" type="email" name="email" placeholder="Email" required>
            <div class="relative">
                <input class="p-3 rounded-xl border border-gray-300 focus:outline-none focus:ring-2 focus:ring-[#002D74] w-full" type="password" name="password" id="password" placeholder="Password" required class="text-center sm:text-left">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="gray" id="togglePassword"
                    class="bi bi-eye absolute top-1/2 right-3 -translate-y-1/2 cursor-pointer z-20 opacity-100"
                    viewBox="0 0 16 16">
                    <path d="M16 8s-3-5.5-8-5.5S0 8 0 8s3 5.5 8 5.5S16 8 16 8zM1.173 8a13.133 13.133 0 0 1 1.66-2.043C4.12 4.668 5.88 3.5 8 3.5c2.12 0 3.879 1.168 5.168 2.457A13.133 13.133 0 0 1 14.828 8c-.058.087-.122.183-.195.288-.335.48-.83 1.12-1.465 1.755C11.879 11.332 10.119 12.5 8 12.5c-2.12 0-3.879-1.168-5.168-2.457A13.134 13.134 0 0 1 1.172 8z"></path>
                    <path d="M8 5.5a2.5 2.5 0 1 0 0 5 2.5 2.5 0 0 0 0-5zM4.5 8a3.5 3.5 0 1 1 7 0 3.5 3.5 0 0 1-7 0z"></path>
                </svg>
            </div>
            <button class="bg-[#002D74] text-white py-2 rounded-xl hover:scale-105 duration-300 hover:bg-[#206ab1] font-medium" type="submit">Login</button>
        </form>

        <div class="mt-6 text-gray-100">
            <hr class="border-gray-300">
            <p class="text-center border-l-indigo-700 text-[#002D74]">OR</p>
            <hr class="border-gray-300">
        </div>

        <button id="resetPasswordButton" type="button" class="bg-white border border-gray-300 py-2 w-full rounded-xl mt-5 flex justify-center items-center text-sm hover:scale-105 duration-300 hover:bg-[#60a8bc4f] font-medium">
            <svg class="mr-3" xmlns="http://www.w3.org/2000/svg" fill="gray" viewBox="0 0 24 24" width="25px">
                <path d="M20 11h-1V7c0-2.21-1.79-4-4-4s-4 1.79-4 4v4H4c-1.1 0-2 .9-2 2v10c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V13c0-1.1-.9-2-2-2zm-10-4c0-1.1.9-2 2-2s2 .9 2 2v4h-4V7zm6 16H4v-8h12v8zm2-2v-8h-2v8h2z"></path>
            </svg>
            Lupa Password?
        </button>
        
        <button id="registerButton" type="button" class="hover:border bg-[#002D74] text-white border-gray-400 rounded-xl py-2 px-5 hover:scale-110 hover:bg-[#002c7424] font-semibold duration-300 mt-5 w-full">
            Register
        </button>

        <div class="mt-3 text-center">
            <p>Belum punya akun? <a href="{{ route('register') }}" class="text-[#002D74] underline">Daftar sekarang</a></p>
            <p>Belum Bisa Login? Silahkan Hubungi Admin</p>
        </div>
    </div>
</section>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Get the register button
        const registerButton = document.getElementById('registerButton');
        const resetPasswordButton = document.getElementById('resetPasswordButton');

        // Add click event for the register button
        registerButton.addEventListener('click', function () {
            window.location.href = '{{ route('register') }}';
        });

        // Add click event for the reset password button
        resetPasswordButton.addEventListener('click', function () {
            window.location.href = '{{ route('password.request') }}';
        });
    });
</script>
@endsection