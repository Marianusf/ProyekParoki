@extends('layout.TemplateAdmin')

@section('title', 'Permintaan Aktivasi Akun')

@section('content')
    <section class="p-6 bg-gray-100 min-h-screen">
        <div class="container mx-auto">
            <!-- Header -->
            <div class="flex justify-between items-center mb-6">
                <h2 class="text-3xl font-bold text-gray-800">Daftar Peminjam yang Belum Disetujui</h2>
            </div>
            <!-- SweetAlert untuk Notifikasi -->
            @if (session('success'))
                <script>
                    Swal.fire({
                        icon: 'success',
                        title: 'Sukses!',
                        text: '{{ session('success') }}',
                        confirmButtonText: 'OK'
                    });
                </script>
            @endif

            @if (session('error'))
                <script>
                    Swal.fire({
                        icon: 'error',
                        title: 'Error!',
                        text: '{{ session('error') }}',
                        confirmButtonText: 'OK'
                    });
                </script>
            @endif

            @if ($errors->any())
                <script>
                    Swal.fire({
                        icon: 'error',
                        title: 'Terjadi Kesalahan!',
                        text: '{{ implode(', ', $errors->all()) }}',
                        confirmButtonText: 'OK'
                    });
                </script>
            @endif
            <!-- Table Section -->
            <div class="overflow-x-auto bg-white shadow-lg rounded-lg">
                <button onclick="window.location.reload();"
                    class="bg-transparent text-blue-500 hover:text-blue-700 p-2 rounded-full transition duration-200 ease-in-out"
                    title="Refresh halaman">
                    <i class="fas fa-sync-alt text-xl"></i> <!-- Ikon refresh -->
                </button>
                @if ($pendingRequest->count() > 0)
                    <table class="min-w-full divide-y divide-gray-200 rounded-lg overflow-hidden">
                        <!-- Table Header -->
                        <thead class="bg-blue-600 text-white text-sm uppercase">
                            <tr>
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
                        <!-- Table Body -->
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach ($pendingRequest as $peminjam)
                                <tr class="hover:bg-gray-100 transition duration-200">
                                    <td class="py-4 px-6 text-gray-700 font-medium">{{ $peminjam->name }}</td>
                                    <td class="py-4 px-6 text-gray-600">{{ $peminjam->email }}</td>
                                    <td class="py-4 px-6 text-gray-600">{{ $peminjam->tanggal_lahir }}</td>
                                    <td class="py-4 px-6 text-gray-600">{{ $peminjam->alamat }}</td>
                                    <td class="py-4 px-6 text-gray-600">{{ $peminjam->nomor_telepon }}</td>
                                    <td class="py-4 px-6 text-gray-600">{{ $peminjam->lingkungan }}</td>
                                    <td class="py-4 px-6 text-gray-600">{{ $peminjam->created_at }}</td>
                                    <!-- Action Buttons -->
                                    <td class="py-4 px-6 text-center">
                                        <div class="flex justify-center space-x-2">
                                            <form method="POST" action="{{ route('approve.peminjam', $peminjam->id) }}">
                                                @csrf
                                                <button type="button"
                                                    class="setujuButton bg-green-500 text-white px-4 py-2 rounded-md hover:bg-green-600 transition duration-200">
                                                    Setujui
                                                </button>
                                                <button type="button"
                                                    class="tolakButton bg-red-500 text-white px-4 py-2 rounded-md hover:bg-red-600 transition duration-200">
                                                    Tolak
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @else
                    <div class="p-6 text-center">
                        <h3 class="text-gray-600 text-lg">Belum ada permintaan aktivasi akun.</h3>
                    </div>
                @endif
            </div>
        </div>
    </section>

@section('scripts')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Event untuk Setujui Button
            document.querySelectorAll('.setujuButton').forEach(button => {
                button.addEventListener('click', function(event) {
                    event.preventDefault();
                    const form = button.closest('form');

                    Swal.fire({
                        title: 'Yakin Setujui?',
                        text: 'Akun ini akan disetujui.',
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Ya, Setujui!'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            form.submit();
                        }
                    });
                });
            });

            // Event untuk Tolak Button
            document.querySelectorAll('.tolakButton').forEach(button => {
                button.addEventListener('click', function(event) {
                    event.preventDefault();
                    const form = button.closest('form');

                    Swal.fire({
                        title: 'Tolak Akun',
                        input: 'textarea',
                        inputPlaceholder: 'Tuliskan alasan penolakan...',
                        showCancelButton: true,
                        confirmButtonText: 'Kirim',
                        cancelButtonText: 'Batal',
                        inputValidator: (value) => {
                            if (!value) {
                                return 'Alasan harus diisi!';
                            }
                        }
                    }).then((result) => {
                        if (result.isConfirmed) {
                            // Lakukan pengiriman data alasan penolakan
                            fetch(`/peminjam/tolak/${form.getAttribute('action').split('/').pop()}`, {
                                    method: 'POST',
                                    headers: {
                                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                        'Content-Type': 'application/json'
                                    },
                                    body: JSON.stringify({
                                        reason: result.value
                                    })
                                })
                                .then(response => response.json())
                                .then(data => {
                                    if (data.success) {
                                        Swal.fire('Sukses!', 'Akun ditolak.', 'success')
                                            .then(() => location.reload());
                                    } else {
                                        Swal.fire('Error!', 'Gagal mengirim data.',
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
