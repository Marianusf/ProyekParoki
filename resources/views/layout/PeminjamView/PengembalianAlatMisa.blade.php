@extends('layout.TemplatePeminjam')
@section('title', 'Pengajuan Pengembalian Alat Misa')
@section('content')
    <div class="container mx-auto py-8">
        <h2 class="text-3xl font-bold mb-6 text-gray-800">Pengembalian Alat Misa</h2>

        <!-- Menampilkan Pesan Error -->
        @if ($errors->any())
            <div class="bg-red-500 text-white p-4 mb-4 rounded-md">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @if (session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                <strong class="font-bold">SUKSES: </strong>
                <span class="block sm:inline">{{ session('success') }}</span>
            </div>
        @endif

        @if ($peminjamanAlatMisa->isEmpty())
            <p class="text-gray-500 text-center">Tidak ada alat misa yang perlu dikembalikan saat ini.</p>
        @else
            <form action="{{ route('pengembalianAlatMisa.store') }}" method="POST" id="pengembalianForm">
                @csrf

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach ($peminjamanAlatMisa as $item)
                        <div class="border p-4 rounded-lg shadow-md bg-white relative">
                            <h4 class="text-lg font-semibold text-blue-700 mb-2">{{ $item->alatMisa->nama_alat }}</h4>
                            <p class="text-sm text-gray-500 mb-1">Jumlah: {{ $item->jumlah }} unit</p>
                            <p class="text-sm text-gray-500 mb-1">Tanggal Peminjaman: <span
                                    class="font-medium">{{ \Carbon\Carbon::parse($item->tanggal_peminjaman)->format('d M Y') }}</span>
                            </p>
                            <p class="text-sm text-gray-500 mb-1">Tanggal Pengembalian: <span
                                    class="font-medium">{{ \Carbon\Carbon::parse($item->tanggal_pengembalian)->format('d M Y') }}</span>
                            </p>

                            <!-- Checkbox untuk Memilih Alat Misa untuk Dikembalikan -->
                            <div class="mt-4">
                                <input type="checkbox" name="peminjaman_id[]" value="{{ $item->id }}"
                                    class="select-item" id="item_{{ $item->id }}">
                                <label for="item_{{ $item->id }}" class="text-sm text-gray-600 ml-2">Pilih untuk
                                    pengembalian</label>
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Tombol Ajukan Pengembalian -->
                <div class="mt-8 text-right">
                    <button type="button" onclick="confirmReturn()"
                        class="bg-blue-600 text-white px-5 py-2 rounded-lg shadow hover:bg-blue-700 transition">
                        Ajukan Pengembalian
                    </button>
                </div>
            </form>
        @endif
    </div>

    <!-- SweetAlert2 untuk Validasi dan Konfirmasi -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        function confirmReturn() {
            // Cek apakah ada alat misa yang dipilih
            const selectedItems = document.querySelectorAll('.select-item:checked');
            if (selectedItems.length === 0) {
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'Pilih setidaknya satu alat misa untuk diajukan pengembaliannya.',
                    confirmButtonColor: '#3085d6'
                });
                return;
            }

            // Jika ada alat misa yang dipilih, tampilkan konfirmasi pengembalian
            Swal.fire({
                title: 'Konfirmasi Pengembalian',
                text: "Apakah Anda yakin ingin melanjutkan proses pengembalian?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, lanjutkan!'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('pengembalianForm').submit();
                }
            });
        }
    </script>
@endsection
