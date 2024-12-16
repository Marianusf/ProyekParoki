@extends('layout.TemplatePeminjam')
@section('title', 'Pengajuan Peminjaman Alat Misa')
@section('content')
    <div class="container mx-auto py-10 px-6">
        <h2 class="text-4xl font-extrabold text-center text-gray-800 mb-10">Formulir Peminjaman Alat Misa</h2>

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
                    html: `<ul style="text-align: left;">@foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>`,
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
        <form action="{{ route('keranjangAlatMisa.tambah') }}" method="POST"
            class="bg-white shadow-lg rounded-xl p-8 space-y-6">
            @csrf
            <div class="container mx-auto py-10 px-4">
                <div class="mb-6">
                    <!-- Dropdown Pilih Alat Misa -->
                    <label for="id_alatmisa" class="block text-lg font-semibold text-gray-700 flex items-center">
                        <i class="fas fa-box mr-2 text-blue-500"></i> Pilih Alat Misa
                    </label>
                    <select id="id_alatmisa" name="id_alatmisa"
                        class="w-full border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-blue-300 py-3 mt-2 transition duration-300 ease-in-out hover:ring-blue-500">
                        <option value="" disabled selected>Pilih alat misa...</option>
                        @foreach ($alat_misa as $alat)
                            <option value="{{ $alat->id }}" data-detail="{{ json_encode($alat->detail_alat) }}"
                                data-stok="{{ $alat->stok_tersedia }}">
                                {{ $alat->nama_alat }} - {{ $alat->jenis_alat }}
                            </option>
                        @endforeach
                    </select>

                    <!-- Stok Tersedia -->
                    <div id="stok_container" class="mt-2 p-4 bg-gray-100 rounded-lg shadow hidden">
                        <h3 class="text-lg font-semibold text-gray-700 mb-2">Stok Tersedia</h3>
                        <p id="stok_info" class="text-green-600 font-bold"></p>
                    </div>

                    <!-- Detail Alat Misa -->
                    <div id="detail_alat_container" class="mt-6 p-6 bg-gray-100 rounded-lg shadow hidden">
                        <h3 class="text-xl font-bold text-gray-700 mb-4">Detail Alat Misa</h3>
                        <ul id="detail_alat_list" class="list-disc list-inside text-gray-600 space-y-2"></ul>
                    </div>
                </div>
            </div>
            <!-- Jumlah -->
            <div>
                <label for="jumlah" class="block text-lg font-semibold text-gray-700">
                    <i class="fas fa-sort-numeric-up text-green-500 mr-2"></i> Jumlah
                </label>
                <input type="number" id="jumlah" name="jumlah"
                    class="block w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-400 focus:border-blue-400 py-3"
                    required min="1">
            </div>

            <!-- Tanggal Pinjam dan Kembali -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <div>
                    <label for="tanggal_peminjaman" class="block text-lg font-semibold text-gray-700">
                        <i class="fas fa-calendar-alt text-purple-500 mr-2"></i> Tanggal Pinjam
                    </label>
                    <input type="date" id="tanggal_peminjaman" name="tanggal_peminjaman"
                        class="block w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-400 focus:border-blue-400 py-3"
                        required>
                </div>

                <div>
                    <label for="tanggal_pengembalian" class="block text-lg font-semibold text-gray-700">
                        <i class="fas fa-calendar-check text-green-500 mr-2"></i> Tanggal Kembali
                    </label>
                    <input type="date" id="tanggal_pengembalian" name="tanggal_pengembalian"
                        class="block w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-400 focus:border-blue-400 py-3"
                        required>
                </div>
            </div>

            <!-- Tombol -->
            <div class="flex items-center justify-between">
                <button type="submit"
                    class="bg-blue-500 text-white px-8 py-3 rounded-lg shadow-md hover:bg-blue-600 transition-transform transform hover:scale-105">
                    Tambah ke Keranjang
                </button>
                <a href="{{ route('lihatKeranjangAlatMisa') }}" class="text-blue-500 hover:text-blue-700 flex items-center">
                    <i class="fas fa-shopping-cart text-3xl"></i>
                    <span class="ml-2 font-semibold">Lihat Keranjang</span>
                </a>
            </div>
        </form>
    </div>

    <!-- Script JavaScript -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const alatMisaSelect = document.getElementById('id_alatmisa');
            const detailContainer = document.getElementById('detail_alat_container');
            const detailList = document.getElementById('detail_alat_list');
            const stokContainer = document.getElementById('stok_container');
            const stokInfo = document.getElementById('stok_info');

            alatMisaSelect.addEventListener('change', function() {
                const selectedOption = alatMisaSelect.options[alatMisaSelect.selectedIndex];
                const detailJSON = selectedOption.getAttribute('data-detail');
                const stokTersedia = selectedOption.getAttribute('data-stok');

                // Kosongkan list sebelumnya
                detailList.innerHTML = '';

                // Tampilkan stok
                if (stokTersedia) {
                    stokInfo.textContent = `Tersisa ${stokTersedia} item`;
                    stokContainer.classList.remove('hidden');
                }

                // Tampilkan detail alat misa
                if (detailJSON) {
                    try {
                        const detailArray = JSON.parse(detailJSON);

                        if (detailArray.length > 0) {
                            detailArray.forEach(item => {
                                const listItem = document.createElement('li');
                                listItem.textContent =
                                    `${item.nama_detail} - Jumlah: ${item.jumlah}`;
                                detailList.appendChild(listItem);
                            });
                        } else {
                            detailList.innerHTML =
                                '<li class="text-gray-500 italic">Tidak ada detail tersedia.</li>';
                        }
                        detailContainer.classList.remove('hidden');
                    } catch (error) {
                        console.error("Error parsing JSON:", error);
                        detailList.innerHTML = '<li class="text-red-500">Gagal memuat detail alat.</li>';
                        detailContainer.classList.remove('hidden');
                    }
                }
            });
        });
    </script>
@endsection
