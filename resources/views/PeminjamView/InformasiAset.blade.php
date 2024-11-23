@extends('layout.TemplatePeminjam')

@section('content')
<section class="w-full h-full max-h-screen flex justify-center items-center">
    <div class="container px-4 md:max-w-4xl w-full border rounded-lg">
        <div class="bg-cover bg-white bg-center w-full">
            <div id="main-content" class="main-content">
                <div class="flex justify-center items-center mb-10">
                    <div class="border-4 border-gray-800 rounded-full py-4 px-8 inline-block text-center">
                        <h1 id="room-title" class="text-3xl md:text-6xl font-semibold text-gray-700">Informasi Peminjaman</h1>
                    </div>
                </div>

                <div class="container mx-auto p-6 bg-gray-300">
                    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-6">
                        <div class="flex space-x-0 sm:space-x-4 mb-4 sm:mb-0 w-full sm:w-auto">
                            <!-- Dropdown untuk Filter Kategori -->
                            <select id="categoryFilter" class="bg-white border border-gray-300 rounded-md w-full sm:w-72 mb-4 sm:mb-0">
                                <option value="">Semua Kategori</option>
                                <option value="ruangan">Ruangan</option>
                                <option value="aset">Aset</option>
                                <option value="perlengkapan">Perlengkapan</option>
                            </select>

                            <!-- Search Bar -->
                            <input type="text" id="search" placeholder="Cari Data"
                                class="border border-gray-300 rounded-md p-2 w-full sm:w-72 mt-2 sm:mt-0 mb-4 sm:mb-0">

                            <!-- Cari Button -->
                            <button onclick="filterData()" class="bg-cyan-600 text-white rounded-md p-2 sm:w-auto mt-1 sm:mt-0">
                                Cari
                            </button>
                        </div>
                    </div>

                    <!-- Tabel Daftar Peminjaman -->
                    <div class="overflow-x-auto">
                        <table class="min-w-full bg-white border border-gray-300 rounded-lg">
                            <thead>
                                <tr class="bg-gray-200">
                                    <th class="py-3 px-4 text-left text-gray-600">No.</th>
                                    <th class="py-3 px-4 text-left text-gray-600">Kategori</th>
                                    <th class="py-3 px-4 text-left text-gray-600">Nama</th>
                                    <th class="py-3 px-4 text-left text-gray-600">Jumlah</th>
                                    <th class="py-3 px-4 text-left text-gray-600">Penanggung Jawab</th>
                                    <th class="py-3 px-4 text-left text-gray-600">Status</th>
                                    <th class="py-3 px-4 text-left text-gray-600">Tanggal Mulai</th>
                                    <th class="py-3 px-4 text-left text-gray-600">Tanggal Selesai</th>
                                    <th class="py-3 px-4 text-left text-gray-600">Jam Mulai</th>
                                    <th class="py-3 px-4 text-left text-gray-600">Jam Selesai</th>
                                </tr>
                            </thead>
                            <tbody id="assetTableBody">
                                <!-- Baris akan muncul di sini -->
                            </tbody>
                        </table>
                    </div>
                    <!-- Tampilkan pesan jika tidak ada data -->
                    <div id="noDataMessage" class="text-center text-gray-600 py-4 hidden">
                        <p>Daftar Peminjaman Kosong</p>
                    </div>

                    <!-- Buttons -->
                    <div class="p-6 border-t border-gray-200 rounded-b flex justify-between">
                        <a href="{{ route('pinjam.InformasiAset') }}">
                            <button class="text-white bg-cyan-600 hover:bg-cyan-700 focus:ring-4 focus:ring-cyan-200 font-medium rounded-lg text-sm px-5 py-2.5 text-center" type="submit">Kembali</button>
                        </a>
                    </div>
                </div>

            </div>
        </div>
    </div>
</section>
@endsection

@section('scripts')
<script>
    const searchInput = document.getElementById('search');
    const categoryFilter = document.getElementById('categoryFilter');
    const assetTableBody = document.getElementById('assetTableBody');
    const noDataMessage = document.getElementById('noDataMessage');

    // Contoh data
    const assetsData = [
        { id: 1, category: 'Ruangan', name: 'Ruangan A', user: 'John Doe', status: 'Dipinjam', start: '2024-11-13 09:00', end: '2024-11-13 10:00' },
        { id: 2, category: 'Aset', name: 'Laptop Dell', user: 'Jane Smith', status: 'Booking', start: '2024-11-13 14:00', end: '2024-11-13 16:00' },
        { id: 3, category: 'Perlengkapan', name: 'Proyektor Epson', user: 'Alice Johnson', status: 'Dipinjam', start: '2024-11-12 10:00', end: '2024-11-12 12:00' },
        { id: 4, category: 'Ruangan', name: 'Ruangan B', user: 'Mike Brown', status: 'Dipinjam', start: '2024-11-12 13:00', end: '2024-11-12 15:00' },
    ];

    function renderTable(filteredAssets) {
        assetTableBody.innerHTML = '';
        if (filteredAssets.length === 0) {
            noDataMessage.classList.remove('hidden');
        } else {
            noDataMessage.classList.add('hidden');
            filteredAssets.forEach((asset, index) => {
                let statusClass = '';
                if (asset.status === 'Dipinjam') {
                    statusClass = 'text-white bg-red-500'; // Merah untuk sedang dipinjam
                } else if (asset.status === 'Booking') {
                    statusClass = 'text-white bg-yellow-500'; // Kuning untuk sedang booking
                }

                const row = `
                    <tr>
                        <td class="py-3 px-4">${index + 1}</td>
                        <td class="py-3 px-4">${asset.category}</td>
                        <td class="py-3 px-4">${asset.name}</td>
                        <td class="py-3 px-4">${asset.user}</td>
                        <td class="py-3 px-4 ${statusClass}">${asset.status}</td>
                        <td class="py-3 px-4">${asset.start}</td>
                        <td class="py-3 px-4">${asset.end}</td>
                        <td class="py-3 px-4">${asset.start.slice(11, 16)}</td>
                        <td class="py-3 px-4">${asset.end.slice(11, 16)}</td>
                    </tr>
                `;
                assetTableBody.innerHTML += row;
            });
        }
    }

    function filterData() {
        const searchText = searchInput.value.toLowerCase();
        const category = categoryFilter.value;

        const filteredAssets = assetsData.filter(asset => {
            const matchesSearch = asset.name.toLowerCase().includes(searchText) ||
                asset.user.toLowerCase().includes(searchText);
            const matchesCategory = category ? asset.category.toLowerCase() === category.toLowerCase() : true;
            return matchesSearch && matchesCategory;
        });

        renderTable(filteredAssets);
    }

    searchInput.addEventListener('input', filterData);
    categoryFilter.addEventListener('change', filterData);

    // Tampilkan data awal
    renderTable(assetsData);
</script>
@endsection
