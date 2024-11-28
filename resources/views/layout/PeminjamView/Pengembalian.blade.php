@extends('layout.TemplatePeminjam')
@section('title', 'pengajuanPengembalian')
@section('content')
    <div class="container mx-auto py-8">
        <h2 class="text-3xl font-bold mb-6 text-gray-800">Pengembalian Barang</h2>

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
        @if (session('message'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                <strong class="font-bold">BERHASIL: </strong>
                <span class="block sm:inline">{{ session('message') }}</span>
            </div>
        @endif


        @if ($peminjaman->isEmpty())
            <p class="text-gray-500 text-center">Tidak ada barang yang perlu dikembalikan saat ini.</p>
        @else
            <form action="{{ route('pengembalian.store') }}" method="POST" id="pengembalianForm">
                @csrf

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach ($peminjaman as $item)
                        <div class="border p-4 rounded-lg shadow-md bg-white relative">
                            <h4 class="text-lg font-semibold text-blue-700 mb-2">{{ $item->asset['nama_barang'] }}</h4>
                            <p class="text-sm text-gray-500 mb-1">Jumlah: {{ $item->jumlah }} unit</p>
                            <p class="text-sm text-gray-500 mb-1">Tanggal Peminjaman: <span
                                    class="font-medium">{{ \Carbon\Carbon::parse($item->tanggal_peminjaman)->format('d M Y') }}</span>
                            </p>
                            <p class="text-sm text-gray-500 mb-1">Tanggal Pengembalian: <span
                                    class="font-medium">{{ \Carbon\Carbon::parse($item->tanggal_pengembalian)->format('d M Y') }}</span>
                            </p>

                            <!-- Menampilkan sisa hari -->
                            @php
                                $tanggalPengembalian = \Carbon\Carbon::parse($item->tanggal_pengembalian);
                                $today = \Carbon\Carbon::now();

                                // Menghitung selisih hari penuh antara tanggal pengembalian dan hari ini
                                $selisihHari = $today->diffInDays($tanggalPengembalian, false);

                                // Menghitung selisih jam setelah mengurangi hari penuh
                                $selisihJam = $today->diffInHours($tanggalPengembalian) % 24;
                            @endphp

                            @if ($selisihHari > 0)
                                <!-- Jika tanggal pengembalian lebih besar dari hari ini -->
                                <p class="text-sm text-green-500">Sisa {{ floor($selisihHari) }} hari lagi untuk
                                    pengembalian.</p>
                            @elseif ($selisihHari == 0 && $selisihJam > 0)
                                <!-- Jika tanggal pengembalian adalah hari ini dan masih ada jam tersisa -->
                                <p class="text-sm text-green-500">Sisa {{ floor($selisihJam) }} jam lagi untuk pengembalian.
                                </p>
                            @elseif ($selisihHari == 0 && $selisihJam <= 0)
                                <!-- Jika tanggal pengembalian adalah hari ini tetapi sudah melewati batas waktu -->
                                <p class="text-sm text-red-500">Terlambat {{ abs(floor($selisihJam)) }} jam.</p>
                            @else
                                <!-- Jika tanggal pengembalian sudah lewat -->
                                <p class="text-sm text-red-500">Terlambat {{ abs(floor($selisihHari)) }} hari.</p>
                            @endif

                            <!-- Checkbox untuk Memilih Barang untuk Dikembalikan -->
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
                        class="bg-blue-600 text-white px-5 py-2 rounded-lg shadow hover:bg-blue-700 transition">Ajukan
                        Pengembalian</button>
                </div>
            </form>
        @endif
    </div>

    <!-- SweetAlert2 untuk Validasi dan Konfirmasi -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        function confirmReturn() {
            // Cek apakah ada barang yang dipilih
            const selectedItems = document.querySelectorAll('.select-item:checked');
            if (selectedItems.length === 0) {
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'Pilih setidaknya satu barang untuk diajukan pengembaliannya.',
                    confirmButtonColor: '#3085d6'
                });
                return;
            }

            // Jika ada barang yang dipilih, tampilkan konfirmasi pengembalian
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
