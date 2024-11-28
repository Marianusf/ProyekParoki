@extends('layout.TemplatePeminjam')
@section('title', 'LihatKeranjang')
@section('content')
    <div class="container mx-auto py-8">
        <h2 class="text-3xl font-bold mb-6 text-gray-800">Keranjang Peminjaman Anda</h2>
        @if (session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                <strong class="font-bold">Sukses: </strong>
                <span class="block sm:inline">{{ session('success') }}</span>
            </div>
        @endif
        @if (session('message'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                <strong class="font-bold">Sukses: </strong>
                <span class="block sm:inline">{{ session('message') }}</span>
            </div>
        @endif
        @if ($errors->any())
            <div class="bg-red-500 text-white p-4 mb-4 rounded-md">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        @if ($keranjangItems->isEmpty())
            <p class="text-gray-500 text-center">Keranjang Anda kosong </p>
        @else
            <form action="{{ route('checkout') }}" method="POST" id="checkoutForm">
                @csrf

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach ($keranjangItems as $item)
                        <div class="border p-4 rounded-lg shadow-md bg-white relative">
                            <h4 class="text-lg font-semibold text-blue-700 mb-2">{{ $item->asset->nama_barang }}</h4>
                            <p class="text-sm text-gray-500 mb-1">Jumlah: {{ $item->jumlah }}</p>
                            <p class="text-sm text-gray-500 mb-1">Tanggal Peminjaman: <span
                                    class="font-medium">{{ \Carbon\Carbon::parse($item->tanggal_peminjaman)->format('d M Y') }}</span>
                            </p>
                            <p class="text-sm text-gray-500 mb-1">Tanggal Pengembalian: <span
                                    class="font-medium">{{ \Carbon\Carbon::parse($item->tanggal_pengembalian)->format('d M Y') }}</span>
                            </p>

                            @php
                                $stokTersedia = $item->asset->jumlah_barang - $item->asset->jumlah_terpinjam;
                            @endphp

                            @if ($item->jumlah > $stokTersedia)
                                <span
                                    class="absolute top-2 right-2 bg-red-500 text-white text-xs px-2 py-1 rounded-full">Stok
                                    Tidak Cukup</span>
                            @else
                                <span
                                    class="absolute top-2 right-2 bg-green-500 text-white text-xs px-2 py-1 rounded-full">Stok
                                    Tersedia</span>
                            @endif

                            <!-- Checkbox untuk Memilih Item -->
                            <div class="mt-4">
                                <input type="checkbox" name="selected_items[]" value="{{ $item->id }}"
                                    class="select-item" id="item_{{ $item->id }}">
                                <label for="item_{{ $item->id }}" class="text-sm text-gray-600 ml-2">Pilih untuk
                                    checkout</label>
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Tombol Checkout -->
                <div class="mt-8 text-right">
                    <button type="button" onclick="confirmCheckout()"
                        class="bg-blue-600 text-white px-5 py-2 rounded-lg shadow hover:bg-blue-700 transition">Proses
                        Checkout</button>
                </div>
            </form>
        @endif
    </div>

    <!-- SweetAlert2 untuk Validasi dan Konfirmasi -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        function confirmCheckout() {
            // Cek apakah ada item yang dipilih
            const selectedItems = document.querySelectorAll('.select-item:checked');
            if (selectedItems.length === 0) {
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'Pilih setidaknya satu item untuk checkout.',
                    confirmButtonColor: '#3085d6'
                });
                return;
            }

            // Jika ada item yang dipilih, tampilkan konfirmasi checkout
            Swal.fire({
                title: 'Konfirmasi Checkout',
                text: "Apakah Anda yakin ingin melanjutkan proses checkout?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, lanjutkan!'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('checkoutForm').submit();
                }
            });
        }
    </script>
@endsection
