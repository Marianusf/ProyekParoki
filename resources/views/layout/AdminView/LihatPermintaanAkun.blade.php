@extends('layout.TemplateAdmin')

@section('title', 'PermintaanAktivasiAkun')

@section('content')
    <section class="p-6 bg-blue-100 min-h-screen">
        <div class="container mx-auto">
            <h2 class="text-2xl font-semibold text-gray-700 mb-4">Daftar Peminjam yang Belum Disetujui</h2>
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

            <div class="overflow-x-auto">
                <table class="min-w-full bg-white border border-gray-200 rounded-lg">
                    <thead>
                        <tr class="w-full bg-blue-600 text-white uppercase text-sm leading-normal">
                            <th class="py-3 px-6 text-left">Nama</th>
                            <th class="py-3 px-6 text-left">Email</th>
                            <th class="py-3 px-6 text-left">Tanggal Lahir</th>
                            <th class="py-3 px-6 text-left">Alamat</th>
                            <th class="py-3 px-6 text-left">Nomor Telepon</th>
                            <th class="py-3 px-6 text-left">Lingkungan</th>
                            <th class="py-3 px-6 text-left">Waktu Permintaan</th>
                            <th class="py-3 px-6 text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="text-gray-700 text-sm font-light">
                        @foreach ($pendingRequest as $peminjam)
                            <tr class="border-b border-gray-200 hover:bg-gray-100">
                                <td class="py-3 px-6 text-left whitespace-nowrap">{{ $peminjam->name }}</td>
                                <td class="py-3 px-6 text-left">{{ $peminjam->email }}</td>
                                <td class="py-3 px-6 text-left">{{ $peminjam->tanggal_lahir }}</td>
                                <td class="py-3 px-6 text-left">{{ $peminjam->alamat }}</td>
                                <td class="py-3 px-6 text-left">{{ $peminjam->nomor_telepon }}</td>
                                <td class="py-3 px-6 text-left">{{ $peminjam->lingkungan }}</td>
                                <td class="py-3 px-6 text-left">{{ $peminjam->created_at }}</td>
                                <td class="py-3 px-6 text-center">
                                    <form class="setujuForm" method="POST"
                                        action="{{ route('approve.peminjam', $peminjam->id) }}">
                                        @csrf
                                        <button type="button"
                                            class="setujuButton bg-green-500 text-white py-1 px-3 rounded hover:bg-green-700">Setujui</button>
                                        <button type="button"
                                            class="tolakButton bg-red-500 text-white py-1 px-3 rounded hover:bg-red-700 ml-2">Tolak</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </section>

@section('scripts')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const setujuButtons = document.querySelectorAll('.setujuButton');
            const tolakButtons = document.querySelectorAll('.tolakButton');

            // Event untuk tombol Setujui
            setujuButtons.forEach((button) => {
                button.addEventListener('click', function(event) {
                    event.preventDefault();
                    const setujuForm = button.closest('form');

                    Swal.fire({
                        title: "Apakah anda Yakin?",
                        text: "Apakah Yakin Akan Setujui Pendaftaran Akun Ini?",
                        icon: "warning",
                        showCancelButton: true,
                        confirmButtonColor: "#3085d6",
                        cancelButtonColor: "#d33",
                        confirmButtonText: "Ya, Setujui!"
                    }).then((result) => {
                        if (result.isConfirmed) {
                            setujuForm.submit();
                        }
                    });
                });
            });

            // Event untuk tombol Tolak
            tolakButtons.forEach((button) => {
                button.addEventListener('click', function(event) {
                    event.preventDefault();
                    const setujuForm = button.closest('form');

                    Swal.fire({
                        title: "Tolak Pendaftaran",
                        input: 'textarea',
                        inputPlaceholder: 'Alasan penolakan...',
                        showCancelButton: true,
                        confirmButtonText: 'Kirim Penolakan',
                        cancelButtonText: 'Batal',
                        inputValidator: (value) => {
                            if (!value) {
                                return 'Anda harus memberikan alasan!';
                            }
                        }
                    }).then((result) => {
                        if (result.isConfirmed) {
                            const reason = result.value;

                            // Send rejection email via AJAX
                            fetch(`/peminjam/tolak/${setujuForm.getAttribute('action').split('/').pop()}`, {
                                    method: 'POST',
                                    headers: {
                                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                        'Content-Type': 'application/json',
                                    },
                                    body: JSON.stringify({
                                        reason
                                    }),
                                })
                                .then(response => response.json())
                                .then(data => {
                                    if (data.success) {
                                        Swal.fire('Sukses!',
                                            'Email penolakan telah dikirim.',
                                            'success');
                                    } else {
                                        Swal.fire('Gagal!',
                                            'Terjadi kesalahan saat mengirim email.',
                                            'error');
                                    }
                                });
                        }
                    });
                });
            });
        });
    </script>
@endsection
@endsection
