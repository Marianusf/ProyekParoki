@extends('layout.templateAuth')

@section('title', 'Lupa Password')

@section('content')
    <section class="flex items-center justify-center min-h-screen bg-[#7cb1ff]">
        <div
            class="bg-[#7cb1ff] rounded-2xl flex flex-col w-full p-20 shadow-lg transition-transform duration-300 transform hover:scale-105">
            @if (session('status'))
                <script>
                    Swal.fire({
                        title: 'Sukses!',
                        text: '{{ session('status') }}',
                        icon: 'success',
                        confirmButtonText: 'Ok'
                    });
                </script>
            @endif

            @if (session('error'))
                <script>
                    Swal.fire({
                        title: 'Error!',
                        text: '{{ session('error') }}',
                        icon: 'error',
                        confirmButtonText: 'Ok'
                    });
                </script>
            @endif


            <h2 class="text-lg font-bold text-gray-800 mb-1">SISTEM PEMINJAMAN GEREJA BABADAN</h2>
            <p class="text-sm text-gray-500 mb-8">PAROKI ST PETRUS DAN PAULUS</p>
            <h2 class="font-bold text-4xl text-[#002D74] text-center mb-4">Lupa Password</h2>


            <form id="resetForm" method="POST" action="{{ route('password.email') }}" class="flex flex-col gap-6">
                @csrf
                <input class="p-3 rounded-xl border border-gray-300 focus:outline-none focus:ring-2 focus:ring-[#002D74]"
                    type="email" name="email" placeholder="Email" required autofocus>
                <button id="resetButton"
                    class="bg-[#002D74] text-white py-3 rounded-xl hover:scale-105 duration-300 hover:bg-[#206ab1] font-medium text-lg">Kirim
                    Link Reset Password</button>
            </form>

            <div class="mt-6 text-center">
                <p>Sudah punya akun? <a href="{{ route('login') }}" class="text-[#002D74] underline">Login sekarang</a></p>
                <p>Belum punya akun? <a href="{{ route('register') }}" class="text-[#002D74] underline">Daftar sekarang</a>
                </p>
            </div>
        </div>
    </section>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const resetButton = document.getElementById('resetButton');
            const resetForm = document.getElementById('resetForm');

            resetButton.addEventListener('click', function(event) {
                event.preventDefault(); // Mencegah form submit langsung

                Swal.fire({
                    title: "Apakah anda Yakin?",
                    text: "Apakah Benar akan mereset Password?",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#3085d6",
                    cancelButtonColor: "#d33",
                    confirmButtonText: "Ya, Reset!"
                }).then((result) => {
                    if (result.isConfirmed) {
                        resetForm.submit(); // Menyubmit form jika konfirmasi diterima
                    }
                });
            });
        });
    </script>
@endsection
