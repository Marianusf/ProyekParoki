@extends('layout.TemplatePeminjam')

@section('content')
<div class="container mx-auto py-8 px-4 sm:px-6 lg:px-8">
    <h2 class="text-3xl font-bold mb-8 text-center text-blue-600">Form Peminjaman</h2>

    <div class="bg-gradient-to-r from-blue-50 via-blue-100 to-blue-50 border border-gray-500 shadow-2xl rounded-xl p-8">
    <form action="{{ route('peminjaman.store') }}" method="POST" class="space-y-6">
            <!-- Penanggung Jawab -->
            <div>
                <label for="penanggung_jawab" class="block text-sm font-semibold text-gray-700 mb-2">Penanggung Jawab</label>
                <input type="text" id="penanggung_jawab" name="penanggung_jawab" class="w-full sm:w-96 md:w-80 border border-gray-300 rounded-lg shadow-sm p-3 focus:outline-none focus:ring-2 focus:ring-blue-400" placeholder="Masukkan nama penanggung jawab" required>
            </div>

            <!-- Pilih Jenis Peminjaman -->
            <div>
                <label for="jenis_peminjaman" class="block text-sm font-semibold text-gray-700 mb-2">Jenis Peminjaman</label>
                <select id="jenis_peminjaman" name="jenis_peminjaman" class="w-full sm:w-72 md:w-80 border border-gray-300 rounded-lg shadow-sm p-3 focus:outline-none focus:ring-2 focus:ring-blue-400">
                    <option value="asset">Asset</option>
                    <option value="ruangan">Ruangan</option>
                </select>
            </div>

            <!-- Form untuk Asset -->
            <div id="asset-fields">
                <label for="asset" class="block text-sm font-semibold text-gray-700 mb-2">Pilih Asset</label>
                <select id="asset" name="asset" class="w-full sm:w-80 md:w-96 border border-gray-300 rounded-lg shadow-sm p-3 focus:outline-none focus:ring-2 focus:ring-blue-400">
                    <option value="1">Laptop - Core i5</option>
                    <option value="2">Proyektor - 1080p</option>
                    <option value="3">Kamera - DSLR</option>
                </select>

                <div class="mt-4">
                    <label for="jumlah" class="block text-sm font-semibold text-gray-700 mb-2">Jumlah</label>
                    <input type="number" id="jumlah" name="jumlah" class="w-full sm:w-96 md:w-80 border border-gray-300 rounded-lg shadow-sm p-3 focus:outline-none focus:ring-2 focus:ring-blue-400" min="1">
                    <p class="text-sm text-gray-600 mt-1">Stok tersedia: 10</p>
                </div>
            </div>

            <!-- Form untuk Ruangan -->
            <div id="ruangan-fields" class="hidden">
                <label for="ruangan" class="block text-sm font-semibold text-gray-700 mb-2">Pilih Ruangan</label>
                <select id="ruangan" name="ruangan" class="w-full sm:w-96 md:w-80 border border-gray-300 rounded-lg shadow-sm p-3 focus:outline-none focus:ring-2 focus:ring-blue-400">
                    <option value="1">Ruang Meeting 1</option>
                    <option value="2">Ruang Presentasi</option>
                    <option value="3">Auditorium</option>
                </select>

                <!-- Grid untuk Tanggal -->
                <div class="mt-4 grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label for="tanggal_mulai" class="block text-sm font-semibold text-gray-700 mb-2">Tanggal Mulai</label>
                        <input type="date" id="tanggal_mulai" name="tanggal_mulai" class="w-full border border-gray-300 rounded-lg shadow-sm p-3 focus:outline-none focus:ring-2 focus:ring-blue-400">
                    </div>
                    <div>
                        <label for="tanggal_selesai" class="block text-sm font-semibold text-gray-700 mb-2">Tanggal Selesai</label>
                        <input type="date" id="tanggal_selesai" name="tanggal_selesai" class="w-full border border-gray-300 rounded-lg shadow-sm p-3 focus:outline-none focus:ring-2 focus:ring-blue-400">
                    </div>
                </div>

                <!-- Grid untuk Jam -->
                <div class="mt-4 grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label for="jam_mulai" class="block text-sm font-semibold text-gray-700 mb-2">Jam Mulai</label>
                        <input type="time" id="jam_mulai" name="jam_mulai" class="w-full border border-gray-300 rounded-lg shadow-sm p-3 focus:outline-none focus:ring-2 focus:ring-blue-400">
                    </div>
                    <div>
                        <label for="jam_selesai" class="block text-sm font-semibold text-gray-700 mb-2">Jam Selesai</label>
                        <input type="time" id="jam_selesai" name="jam_selesai" class="w-full border border-gray-300 rounded-lg shadow-sm p-3 focus:outline-none focus:ring-2 focus:ring-blue-400">
                    </div>
                </div>
            </div>

            <!-- Submit Button -->
            <div class="text-center mt-6">
                <button type="submit" class="bg-gradient-to-r from-blue-500 to-blue-600 text-white px-6 py-3 rounded-lg shadow-lg hover:from-blue-600 hover:to-blue-700 transition duration-200 ease-in-out">Tambah ke Keranjang</button>
            </div>
        </form>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const jenisPeminjaman = document.getElementById('jenis_peminjaman');
        const assetFields = document.getElementById('asset-fields');
        const ruanganFields = document.getElementById('ruangan-fields');

        jenisPeminjaman.addEventListener('change', function () {
            if (this.value === 'asset') {
                assetFields.classList.remove('hidden');
                ruanganFields.classList.add('hidden');
            } else {
                assetFields.classList.add('hidden');
                ruanganFields.classList.remove('hidden');
            }
        });
    });
</script>
@endsection
