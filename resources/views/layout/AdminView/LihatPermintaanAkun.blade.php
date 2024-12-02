@extends('layout.TemplateAdmin')

@section('title', 'Daftar Peminjam')

@section('content')
<script src="https://cdn.tailwindcss.com"></script>
<section class="min-h-screen rounded-md">

    <div class="container mx-auto pt-4 pb-6 px-6 bg-white rounded-md mt-14">
        <h2 class="text-2xl font-semibold text-gray-700 pb-2 px-2 ">Daftar Peminjam yang Belum Disetujui</h2>

        {{-- Tampilkan notifikasi sukses jika ada --}}
        @if (session('success'))
        <div class="bg-green-500 text-white p-2 rounded mb-4">
            {{ session('success') }}
        </div>
        @endif

        <div class="overflow-x-auto">
            <table class="min-w-full bg-white rounded-t-md">
                <thead class="w-full bg-blue-600 text-white uppercase text-sm leading-normal">
                    <tr class="">
                        <th class="py-3 px-6 text-left border border-collapse">Nama</th>
                        <th class="py-3 px-6 text-left border border-collapse">Email</th>
                        <th class="py-3 px-6 text-left border border-collapse">Tanggal Lahir</th>
                        <th class="py-3 px-6 text-left border border-collapse">Alamat</th>
                        <th class="py-3 px-6 text-left border border-collapse">Nomor Telepon</th>
                        <th class="py-3 px-6 text-left border border-collapse">Lingkungan</th>
                        <th class="py-3 px-6 text-left border border-collapse">Waktu Permintaan</th>
                        <th class="py-3 px-6 text-left border border-collapse">Aksi</th>
                    </tr>
                </thead>

                <tbody class="text-gray-700 text-sm font-light">
                    @foreach ($pendingRequest as $peminjam)
                            <tr class="border-b border-gray-200 hover:bg-gray-100">
                                <td class="py-3 px-6 text-left border border-collapse">{{ $peminjam->name }}</td>
                                <td class="py-3 px-6 text-left border border-collapse">{{ $peminjam->email }}</td>
                                <td class="py-3 px-6 text-left border border-collapse">{{ $peminjam->tanggal_lahir }}</td>
                                <td class="py-3 px-6 text-left border border-collapse">{{ $peminjam->alamat }}</td>
                                <td class="py-3 px-6 text-left border border-collapse">{{ $peminjam->nomor_telepon }}</td>
                                <td class="py-3 px-6 text-left border border-collapse">{{ $peminjam->lingkungan }}</td>
                                <td class="py-3 px-6 text-left border border-collapse">{{ $peminjam->created_at }}</td>
                                <td class="py-3 px-6 text-left border border-collapse">
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