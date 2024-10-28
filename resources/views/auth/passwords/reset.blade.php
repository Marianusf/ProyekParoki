@extends('layout.templateAuth')

@section('title', 'Reset Password')

@section('content')
<section class="flex items-center justify-center min-h-screen bg-[#7cb1ff]">
    <div class="bg-[#7cb1ff] rounded-2xl flex flex-col w-full p-20 shadow-lg transition-transform duration-300 transform hover:scale-105">
        <h2 class="text-lg font-bold text-gray-800 mb-1">SISTEM PEMINJAMAN GEREJA BABADAN</h2>
        <p class="text-sm text-gray-500 mb-8">PAROKI ST PETRUS DAN PAULUS</p>
        <h2 class="font-bold text-4xl text-[#002D74] text-center mb-4">Reset Password</h2>

        @if ($errors->any())
            <div class="bg-red-500 text-white p-4 rounded mb-4">
                {{ $errors->first() }}
            </div>
        @endif

        <form id="gantiPasForm" method="POST" action="{{ route('password.update') }}" class="flex flex-col gap-6 p-8 bg-white rounded-xl shadow-md">
            @csrf
            <input type="hidden" name="token" value="{{ $token }}">
        
            <div class="form-group flex flex-col">
                <label for="email" class="text-gray-700 font-medium mb-2">Email</label>
                <input type="email" id="email" name="email" value="{{ old('email', $email) }}" 
                       class="p-3 rounded-xl border border-gray-300 focus:outline-none focus:ring-2 focus:ring-[#002D74]" 
                       required autofocus placeholder="Masukkan Email Anda">
            </div>
        
            <div class="form-group flex flex-col">
                <label for="password" class="text-gray-700 font-medium mb-2">Password Baru</label>
                <input type="password" id="password" name="password" 
                       class="p-3 rounded-xl border border-gray-300 focus:outline-none focus:ring-2 focus:ring-[#002D74]" 
                       required placeholder="Masukkan Password Baru">
            </div>
        
            <div class="form-group flex flex-col">
                <label for="password_confirmation" class="text-gray-700 font-medium mb-2">Konfirmasi Password</label>
                <input type="password" id="password_confirmation" name="password_confirmation" 
                       class="p-3 rounded-xl border border-gray-300 focus:outline-none focus:ring-2 focus:ring-[#002D74]" 
                       required placeholder="Konfirmasi Password Baru">
            </div>
        
            <button id="gantiPasButton" class="bg-[#002D74] text-white py-3 rounded-xl hover:scale-105 duration-300 hover:bg-[#206ab1] font-medium text-lg">
                Reset Password
            </button>
        </form>
        

        <div class="mt-6 text-center">
            <p>Sudah ingat password? <a href="{{ route('login') }}" class="text-[#002D74] underline">Login sekarang</a></p>
            <p>Belum punya akun? <a href="{{ route('register') }}" class="text-[#002D74] underline">Daftar sekarang</a></p>
        </div>
    </div>
</section>

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const gantiPasButton = document.getElementById('gantiPasButton');
        const gantiPasForm = document.getElementById('gantiPasForm');

        if (gantiPasButton && gantiPasForm) {
            gantiPasButton.addEventListener('click', function (event) {
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
    });
</script>
@endsection
@endsection
