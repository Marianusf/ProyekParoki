@extends('layout.TemplatePeminjam')
@section('title', 'Pengajuan Pengembalian')
@section('content')
    <div class="container mx-auto py-10 px-6">
        <h2 class="text-4xl font-extrabold text-center text-gray-800 mb-10">Formulir Peminjaman Aset</h2>

        <!-- SweetAlert Notifications -->
        @if (session('success'))
            <script>
                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil',
                    text: '{{ session('success') }}',
                    confirmButtonText: 'OK',
                    timer: 3000
                });
            </script>
        @endif

        @if ($errors->any())
            <script>
                Swal.fire({
                    icon: 'error',
                    title: 'Validasi Gagal',
                    html: `
                    <ul style="text-align: left;">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                `,
                    confirmButtonText: 'OK'
                });
            </script>
        @endif
        <button onclick="window.location.reload();"
            class="bg-transparent text-blue-500 hover:text-blue-700 p-2 rounded-full transition duration-200 ease-in-out"
            title="Refresh halaman">
            <i class="fas fa-sync-alt text-xl"></i> <!-- Ikon refresh -->
        </button>
        <!-- Form -->
        <form action="{{ route('keranjang.tambah') }}" method="POST" class="bg-white shadow-lg rounded-xl p-8 space-y-6">
            @csrf

            <!-- Pilih Asset -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <div>
                    <label for="id_asset" class="block text-lg font-semibold text-gray-700 flex items-center">
                        <i class="fas fa-box text-blue-500 mr-2"></i>Pilih Aset
                    </label>
                    <select id="id_asset" name="id_asset"
                        class="mt-2 block w-full border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-blue-400 focus:border-blue-400"
                        required>
                        @foreach ($asset as $item)
                            <option value="{{ $item->id }}" data-stok="{{ $item->stok_tersedia }}">
                                {{ $item->nama_barang }} - {{ $item->deskripsi }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Jumlah -->
                <div>
                    <label for="jumlah" class="block text-lg font-semibold text-gray-700 flex items-center">
                        <i class="fas fa-sort-numeric-up text-green-500 mr-2"></i>Jumlah
                    </label>
                    <input type="number" id="jumlah" name="jumlah"
                        class="mt-2 block w-full border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-blue-400 focus:border-blue-400"
                        required min="1">
                    <p class="text-sm text-gray-600 mt-1 stok-info"></p>
                </div>
            </div>

            <!-- Tanggal Pinjam dan Kembali -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <div>
                    <label for="tanggal_peminjaman" class="block text-lg font-semibold text-gray-700 flex items-center">
                        <i class="fas fa-calendar-alt text-purple-500 mr-2"></i>Tanggal Pinjam
                    </label>
                    <input type="date" id="tanggal_peminjaman" name="tanggal_peminjaman"
                        class="mt-2 block w-full border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-blue-400 focus:border-blue-400"
                        required>
                </div>

                <div>
                    <label for="tanggal_pengembalian" class="block text-lg font-semibold text-gray-700 flex items-center">
                        <i class="fas fa-calendar-check text-green-500 mr-2"></i>Tanggal Kembali
                    </label>
                    <input type="date" id="tanggal_pengembalian" name="tanggal_pengembalian"
                        class="mt-2 block w-full border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-blue-400 focus:border-blue-400"
                        required>
                </div>
            </div>

            <!-- Tombol -->
            <div class="flex items-center justify-between mt-4">
                <button type="submit"
                    class="bg-blue-500 text-white font-semibold px-8 py-3 rounded-lg shadow-md hover:bg-blue-600 transition duration-200 transform hover:scale-105">
                    Tambah ke Keranjang
                </button>

                <a href="{{ route('lihatKeranjang') }}"
                    class="text-blue-500 hover:text-blue-700 flex items-center space-x-2">
                    <i class="fas fa-shopping-cart text-3xl"></i>
                    <span class="text-lg font-semibold">Lihat Keranjang</span>
                </a>
            </div>
        </form>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const assetSelect = document.getElementById('id_asset');
            const jumlahInput = document.getElementById('jumlah');
            const stokInfo = document.querySelector('.stok-info');
            const submitButton = document.querySelector('button[type="submit"]');

            const updateStok = () => {
                const selectedOption = assetSelect.options[assetSelect.selectedIndex];
                const stokTersedia = parseInt(selectedOption.getAttribute('data-stok'), 10);

                if (stokTersedia === 0) {
                    stokInfo.textContent = 'Stok tidak tersedia.';
                    jumlahInput.disabled = true;
                    submitButton.disabled = true;

                    Swal.fire({
                        icon: 'error',
                        title: 'Stok Habis',
                        text: 'Stok aset yang dipilih sudah habis.',
                        confirmButtonText: 'OK'
                    });
                } else {
                    stokInfo.textContent = `Stok tersedia: ${stokTersedia}`;
                    jumlahInput.disabled = false;
                    jumlahInput.max = stokTersedia;
                    submitButton.disabled = false;
                }
            };

            jumlahInput.addEventListener('blur', function() {
                const max = parseInt(this.max, 10);
                const value = parseInt(this.value, 10);

                if (value > max) {
                    this.value = max;

                    Swal.fire({
                        icon: 'warning',
                        title: 'Jumlah Melebihi Stok',
                        text: `Stok maksimum untuk aset ini adalah ${max}.`,
                        confirmButtonText: 'OK',
                        timer: 3000
                    });
                }
            });

            assetSelect.addEventListener('change', updateStok);
            updateStok();
        });
    </script>
@endsection
