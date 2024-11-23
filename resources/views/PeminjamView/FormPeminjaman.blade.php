@extends('layout.TemplatePeminjam')

@section('content')
<div class="container mx-auto py-8 px-4 sm:px-6 lg:px-8">
    <h2 class="text-3xl font-extrabold mb-8 text-center text-blue-600">Form Peminjaman</h2>

    <div class="bg-gradient-to-r from-blue-50 via-blue-100 to-blue-50 border border-gray-300 shadow-xl rounded-xl p-8">
        <form action="{{ route('peminjaman.store') }}" method="POST" class="space-y-8">
            @csrf
            <!-- Penanggung Jawab -->
            <div>
                <label for="penanggung_jawab" class="block text-sm font-bold text-gray-700 mb-2">Penanggung Jawab</label>
                <input type="text" id="penanggung_jawab" name="penanggung_jawab" class="w-full sm:w-96 border border-gray-300 rounded-lg shadow-md p-3 focus:outline-none focus:ring-4 focus:ring-blue-300 transition-transform duration-200 transform hover:scale-105" placeholder="Masukkan nama penanggung jawab" required>
            </div>

            <!-- Divider -->
            <div class="border-t border-gray-300"></div>

            <!-- Pilih Jenis Peminjaman -->
            <div>
                <label for="jenis_peminjaman" class="block text-sm font-bold text-gray-700 mb-2">Jenis Peminjaman</label>
                <div class="relative">
                    <select id="jenis_peminjaman" name="jenis_peminjaman" class="w-full sm:w-72 border border-gray-300 rounded-lg shadow-md p-3 focus:outline-none focus:ring-4 focus:ring-blue-300 transition-transform duration-200 transform hover:scale-105">
                        <option value="asset">Asset</option>
                        <option value="ruangan">Ruangan</option>
                        <option value="alatMisa">Alat Misa</option>
                        <option value="perlengkapan">Perlengkapan</option>
                    </select>
                    <span class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                        <svg class="w-5 h-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </span>
                </div>
            </div>

            <!-- Form untuk Alat Misa -->
            <div id="alat-misa-fields" class="hidden">
                <label for="alat_misa" class="block text-sm font-bold text-gray-700 mb-2">Pilih Alat Misa</label>
                <select id="alat_misa" name="alat_misa" class="w-full sm:w-96 border border-gray-300 rounded-lg shadow-md p-3 focus:outline-none focus:ring-4 focus:ring-blue-300 transition-transform duration-200 transform hover:scale-105">
                    <option value="1">Alat Misa 1</option>
                    <option value="2">Alat Misa 2</option>
                    <option value="3">Alat Misa 3</option>
                </select>

                <!-- Gambar Alat Misa -->
                <div id="alat_misa_gambar" class="mt-4">
                    <img src="" alt="Gambar Alat Misa" id="gambar_alat_misa" class="w-full sm:w-96 h-auto rounded-lg">
                </div>
            </div>

            <!-- Form untuk Asset -->
            <div id="asset-fields" class="hidden">
                <label for="asset" class="block text-sm font-bold text-gray-700 mb-2">Pilih Asset</label>
                <select id="asset" name="asset" class="w-full sm:w-80 border border-gray-300 rounded-lg shadow-md p-3 focus:outline-none focus:ring-4 focus:ring-blue-300 transition-transform duration-200 transform hover:scale-105">
                    <option value="1">Proyektor</option>
                    <option value="2">Kamera</option>
                    <option value="3">Kursi</option>
                    <option value="4">Meja</option>
                    <option value="5">Speaker + Mic</option>
                    <option value="6">Alat Misa</option>
                </select>
                <div class="mt-4">
                    <label for="jumlah" class="block text-sm font-bold text-gray-700 mb-2">Jumlah</label>
                    <input type="number" id="jumlah" name="jumlah" class="w-full sm:w-96 border border-gray-300 rounded-lg shadow-md p-3 focus:outline-none focus:ring-4 focus:ring-blue-300 transition-transform duration-200 transform hover:scale-105" min="1">
                    <p class="text-sm text-gray-600 mt-1">Stok tersedia: 10</p>
                </div>
            </div>

            <!-- Form untuk Ruangan -->
            <div id="ruangan-fields" class="hidden">
                <label for="ruangan" class="block text-sm font-bold text-gray-700 mb-2">Pilih Ruangan</label>
                <select id="ruangan" name="ruangan" class="w-full sm:w-96 border border-gray-300 rounded-lg shadow-md p-3 focus:outline-none focus:ring-4 focus:ring-blue-300 transition-transform duration-200 transform hover:scale-105">
                    <option value="1">Ruangan Aula</option>
                </select>

                <!-- Grid untuk Tanggal -->
                <div class="mt-4 grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label for="tanggal_mulai" class="block text-sm font-bold text-gray-700 mb-2">Tanggal Mulai</label>
                        <input type="date" id="tanggal_mulai" name="tanggal_mulai" class="w-full border border-gray-300 rounded-lg shadow-md p-3 focus:outline-none focus:ring-4 focus:ring-blue-300 transition-transform duration-200 transform hover:scale-105">
                    </div>
                    <div>
                        <label for="tanggal_selesai" class="block text-sm font-bold text-gray-700 mb-2">Tanggal Selesai</label>
                        <input type="date" id="tanggal_selesai" name="tanggal_selesai" class="w-full border border-gray-300 rounded-lg shadow-md p-3 focus:outline-none focus:ring-4 focus:ring-blue-300 transition-transform duration-200 transform hover:scale-105">
                    </div>
                </div>

                <!-- Grid untuk Jam -->
                <div class="mt-4 grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label for="jam_mulai" class="block text-sm font-bold text-gray-700 mb-2">Jam Mulai</label>
                        <input type="time" id="jam_mulai" name="jam_mulai" class="w-full border border-gray-300 rounded-lg shadow-md p-3 focus:outline-none focus:ring-4 focus:ring-blue-300 transition-transform duration-200 transform hover:scale-105">
                    </div>
                    <div>
                        <label for="jam_selesai" class="block text-sm font-bold text-gray-700 mb-2">Jam Selesai</label>
                        <input type="time" id="jam_selesai" name="jam_selesai" class="w-full border border-gray-300 rounded-lg shadow-md p-3 focus:outline-none focus:ring-4 focus:ring-blue-300 transition-transform duration-200 transform hover:scale-105">
                    </div>
                </div>
            </div>

            <!-- Form untuk Perlengkapan -->
            <div id="perlengkapan-fields" class="hidden">
                <label for="perlengkapan" class="block text-sm font-bold text-gray-700 mb-2">Pilih Perlengkapan</label>
                <select id="perlengkapan" name="perlengkapan" class="w-full sm:w-96 border border-gray-300 rounded-lg shadow-md p-3 focus:outline-none focus:ring-4 focus:ring-blue-300 transition-transform duration-200 transform hover:scale-105">
                    <option value="1">Perlengkapan 1</option>
                    <option value="2">Perlengkapan 2</option>
                    <option value="3">Perlengkapan 3</option>
                </select>
                <div class="mt-4">
                    <label for="jumlah_perlengkapan" class="block text-sm font-bold text-gray-700 mb-2">Jumlah</label>
                    <input type="number" id="jumlah_perlengkapan" name="jumlah_perlengkapan" class="w-full sm:w-96 border border-gray-300 rounded-lg shadow-md p-3 focus:outline-none focus:ring-4 focus:ring-blue-300 transition-transform duration-200 transform hover:scale-105" min="1">
                    <p class="text-sm text-gray-600 mt-1">Stok tersedia: 10</p>
                </div>
            </div>

            <!-- Submit Button -->
            <div class="text-center mt-6">
                <button type="submit" class="bg-gradient-to-r from-blue-500 to-blue-600 text-white px-6 py-3 rounded-lg shadow-lg hover:from-blue-600 hover:to-blue-700 transition duration-300 ease-in-out transform hover:scale-105">
                    Tambah ke Keranjang
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const jenisPeminjaman = document.getElementById('jenis_peminjaman');
        const assetFields = document.getElementById('asset-fields');
        const ruanganFields = document.getElementById('ruangan-fields');
        const alatMisaFields = document.getElementById('alat-misa-fields');
        const perlengkapanFields = document.getElementById('perlengkapan-fields');
        const gambarAlatMisa = document.getElementById('gambar_alat_misa');
        const alatMisaDropdown = document.getElementById('alat_misa');

        jenisPeminjaman.addEventListener('change', function () {
            assetFields.classList.add('hidden');
            ruanganFields.classList.add('hidden');
            alatMisaFields.classList.add('hidden');
            perlengkapanFields.classList.add('hidden');

            if (this.value === 'asset') {
                assetFields.classList.remove('hidden');
            } else if (this.value === 'ruangan') {
                ruanganFields.classList.remove('hidden');
            } else if (this.value === 'alatMisa') {
                alatMisaFields.classList.remove('hidden');
            } else if (this.value === 'perlengkapan') {
                perlengkapanFields.classList.remove('hidden');
            }
        });

        // Event Listener untuk perubahan pilihan alat misa
        alatMisaDropdown.addEventListener('change', function () {
            const selectedOption = this.value;

            // Menampilkan gambar berdasarkan pilihan alat misa
            switch (selectedOption) {
                case '1':
                    gambarAlatMisa.src = '/images/alat_misa_1.jpg'; // Ganti dengan path gambar yang sesuai
                    break;
                case '2':
                    gambarAlatMisa.src = '/images/alat_misa_2.jpg'; // Ganti dengan path gambar yang sesuai
                    break;
                case '3':
                    gambarAlatMisa.src = '/images/alat_misa_3.jpg'; // Ganti dengan path gambar yang sesuai
                    break;
                default:
                    gambarAlatMisa.src = '';  // Jika tidak ada pilihan, sembunyikan gambar
                    break;
            }
        });
    });
</script>
@endsection
