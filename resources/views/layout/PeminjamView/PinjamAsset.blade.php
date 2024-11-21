@extends('layout.TemplatePeminjam')

@section('content')
    <div class="container mx-auto py-8">
        <h2 class="text-2xl font-semibold mb-6">Form Peminjaman</h2>

        <!-- Menampilkan notifikasi sukses jika ada -->
        @if (session('success'))
            <div class="bg-green-500 text-white p-4 rounded-md mb-4">
                {{ session('success') }}
            </div>
        @endif

        <form action="{{ route('keranjang.tambah') }}" method="POST">
            @csrf

            <!-- Pilih Asset -->
            <div class="mb-4">
                <label for="id_asset" class="block text-sm font-medium text-gray-700">Pilih Asset</label>
                <select id="id_asset" name="id_asset" class="mt-1 block w-full" required>
                    @foreach ($asset as $item)
                        <option value="{{ $item->id }}"
                            data-stok="{{ $item->jumlah_barang - $item->jumlah_terpinjam }}">
                            {{ $item->nama_barang }} - {{ $item->deskripsi }}
                        </option>
                    @endforeach
                </select>
                @error('id_asset')
                    <p class="text-red-500 text-xs mt-2">{{ $message }}</p>
                @enderror
            </div>

            <!-- Jumlah Asset -->
            <div class="mb-4">
                <label for="jumlah" class="block text-sm font-medium text-gray-700">Jumlah</label>
                <input type="number" id="jumlah" name="jumlah" class="mt-1 block w-full" required min="1">
                @error('jumlah')
                    <p class="text-red-500 text-xs mt-2">{{ $message }}</p>
                @enderror
            </div>
            <p class="text-sm text-gray-600 stok-info"></p>

            <!-- Tanggal Pinjam -->
            <div class="mb-4">
                <label for="tanggal_peminjaman" class="block text-sm font-medium text-gray-700">Tanggal Pinjam</label>
                <input type="date" id="tanggal_peminjaman" name="tanggal_peminjaman" class="mt-1 block w-full" required>
                @error('tanggal_peminjaman')
                    <p class="text-red-500 text-xs mt-2">{{ $message }}</p>
                @enderror
            </div>

            <!-- Tanggal Kembali -->
            <div class="mb-4">
                <label for="tanggal_pengembalian" class="block text-sm font-medium text-gray-700">Tanggal Kembali</label>
                <input type="date" id="tanggal_pengembalian" name="tanggal_pengembalian" class="mt-1 block w-full"
                    required>
                @error('tanggal_pengembalian')
                    <p class="text-red-500 text-xs mt-2">{{ $message }}</p>
                @enderror
            </div>

            <!-- Submit Button -->
            <div class="mb-4">
                <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">Tambah ke
                    Keranjang</button>
            </div>
        </form>
    </div>

    {{-- <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script> --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const assetSelect = document.getElementById('id_asset');
            const jumlahInput = document.getElementById('jumlah');
            const stokInfo = document.querySelector('.stok-info');
            const submitButton = document.querySelector('button[type="submit"]');

            // Fungsi untuk memperbarui stok tersedia
            const updateStok = () => {
                const selectedOption = assetSelect.options[assetSelect.selectedIndex];
                const stokTersedia = parseInt(selectedOption.getAttribute('data-stok'), 10);

                if (stokTersedia === 0) {
                    // Jika stok 0, tampilkan pesan dan nonaktifkan input serta tombol
                    stokInfo.textContent = `Stok tidak tersedia.`;
                    jumlahInput.disabled = true;
                    submitButton.disabled = true;
                } else {
                    // Jika stok tersedia, aktifkan input dan tombol
                    stokInfo.textContent = `Stok tersedia: ${stokTersedia}`;
                    jumlahInput.disabled = false;
                    jumlahInput.max = stokTersedia;
                    submitButton.disabled = false;
                }
            };

            // Event listener untuk validasi jumlah input saat blur (field kehilangan fokus)
            jumlahInput.addEventListener('blur', function() {
                const max = parseInt(this.max, 10);
                const value = parseInt(this.value, 10);

                // Validasi jika nilai melebihi stok maksimum
                if (value > max) {
                    this.value = max; // Set nilai ke maksimum
                    Swal.fire({
                        icon: 'warning',
                        title: 'Jumlah Melebihi Stok',
                        text: `Stok maksimum untuk aset ini adalah ${max}.`,
                        confirmButtonText: 'OK',
                        timer: 3000
                    });
                }
            });

            // Event listener untuk memperbarui stok saat opsi berubah
            assetSelect.addEventListener('change', updateStok);

            // Inisialisasi pertama
            updateStok();
        });
    </script>
@endsection
