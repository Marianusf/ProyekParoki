@extends('layout.TemplatePeminjam')

@section('title', 'Riwayat Peminjaman')

@section('content')
    <div class="container mx-auto py-8">
        <h1 class="text-3xl font-semibold mb-6">Riwayat Peminjaman</h1>

        <!-- Tabs Navigation -->
        <div class="flex mb-4">
            <button id="peminjamanTab" class="px-6 py-2 bg-blue-500 text-white rounded-l-lg focus:outline-none">
                Riwayat Peminjaman
            </button>
            <button id="pengembalianTab" class="px-6 py-2 bg-blue-500 text-white rounded-r-lg focus:outline-none">
                Riwayat Pengembalian
            </button>
        </div>

        <!-- Tab Content: Riwayat Peminjaman -->
        <div id="peminjamanContent" class="tab-content">
            <div class="flex justify-between items-center mb-4">
                <div class="flex space-x-4 items-center">
                    <label for="itemsPerPagePeminjaman" class="text-lg">Tampilkan:</label>
                    <select id="itemsPerPagePeminjaman" class="bg-gray-100 p-2 rounded-md text-base font-medium">
                        <option value="10">10</option>
                        <option value="20">20</option>
                        <option value="50">50</option>
                        <option value="100">100</option>
                    </select>
                </div>

                <div class="flex space-x-4 items-center">
                    <input type="text" id="searchPeminjaman"
                        class="p-3 w-96 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 text-lg"
                        placeholder="Cari berdasarkan nama alat..." />
                </div>
            </div>

            <div class="flex justify-between mb-4 space-x-4">
                <div class="flex items-center space-x-4 w-1/2 sm:w-1/4">
                    <label for="statusFilterPeminjaman" class="text-lg">Filter Status:</label>
                    <select id="statusFilterPeminjaman" class="bg-gray-100 p-2 rounded-md text-base">
                        <option value="">Semua Status</option>
                        <option value="menunggu persetujuan">Menunggu Persetujuan</option>
                        <option value="disetujui">Disetujui</option>
                        <option value="ditolak">Ditolak</option>
                    </select>
                </div>
            </div>

            <div class="overflow-x-auto max-h-[500px] bg-white shadow-md rounded-lg">
                <table class="min-w-full text-sm text-left text-gray-500">
                    <thead class="text-xs text-gray-700 uppercase bg-gray-200 sticky top-0">
                        <tr>
                            <th scope="col" class="px-6 py-3 cursor-pointer">Nama Alat</th>
                            <th scope="col" class="px-6 py-3 cursor-pointer">Jumlah</th>
                            <th scope="col" class="px-6 py-3 cursor-pointer">Tanggal Pengajuan</th>
                            <th scope="col" class="px-6 py-3 cursor-pointer">Tanggal Peminjaman</th>
                            <th scope="col" class="px-6 py-3 cursor-pointer">Tanggal Pengembalian</th>
                            <th scope="col" class="px-6 py-3 cursor-pointer">Status Peminjaman</th>
                        </tr>
                    </thead>
                    <tbody id="tableBodyPeminjaman">
                        @foreach ($riwayatPeminjaman as $peminjaman)
                            <tr class="bg-white border-b hover:bg-gray-100 transition duration-150"
                                data-type="riwayatPeminjaman">
                                <td class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap">
                                    {{ $peminjaman->asset->nama_barang }}</td>
                                <td class="px-6 py-4">{{ $peminjaman->jumlah }}</td>
                                <td class="px-6 py-4">
                                    {{ \Carbon\Carbon::parse($peminjaman->created_at)->format('d F Y H:i') }}</td>
                                <td class="px-6 py-4">
                                    {{ \Carbon\Carbon::parse($peminjaman->tanggal_peminjaman)->format('d F Y') }}</td>
                                <td class="px-6 py-4">
                                    {{ \Carbon\Carbon::parse($peminjaman->tanggal_pengembalian)->format('d F Y') }}</td>
                                <td class="px-6 py-4">
                                    @if ($peminjaman->status_peminjaman == 'pending')
                                        <span class="text-yellow-500">Menunggu Persetujuan</span>
                                    @elseif($peminjaman->status_peminjaman == 'disetujui')
                                        <span class="text-green-500">Disetujui</span>
                                    @else
                                        <span class="text-red-500">Ditolak</span>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Tab Content: Riwayat Pengembalian -->
        <div id="pengembalianContent" class="tab-content hidden">
            <div class="flex justify-between items-center mb-4">
                <div class="flex space-x-4 items-center">
                    <label for="itemsPerPagePengembalian" class="text-lg">Tampilkan:</label>
                    <select id="itemsPerPagePengembalian" class="bg-gray-100 p-2 rounded-md text-base font-medium">
                        <option value="10">10</option>
                        <option value="20">20</option>
                        <option value="50">50</option>
                        <option value="100">100</option>
                    </select>
                </div>

                <div class="flex space-x-4 items-center">
                    <input type="text" id="searchPengembalian"
                        class="p-3 w-96 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 text-lg"
                        placeholder="Cari berdasarkan nama alat..." />
                </div>
            </div>

            <div class="flex justify-between mb-4 space-x-4">
                <div class="flex items-center space-x-4 w-1/2 sm:w-1/4">
                    <label for="statusFilterPengembalian" class="text-lg">Filter Status:</label>
                    <select id="statusFilterPengembalian" class="bg-gray-100 p-2 rounded-md text-base">
                        <option value="">Semua Status</option>
                        <option value="menunggu persetujuan">Menunggu Persetujuan</option>
                        <option value="disetujui">Disetujui</option>
                        <option value="ditolak">Ditolak</option>
                    </select>
                </div>
            </div>

            <div class="overflow-x-auto max-h-[500px] bg-white shadow-md rounded-lg">
                <table class="min-w-full text-sm text-left text-gray-500">
                    <thead class="text-xs text-gray-700 uppercase bg-gray-200 sticky top-0">
                        <tr>
                            <th scope="col" class="px-6 py-3 cursor-pointer">Nama Alat</th>
                            <th scope="col" class="px-6 py-3 cursor-pointer">Jumlah</th>
                            <th scope="col" class="px-6 py-3 cursor-pointer">Tanggal Pengajuan</th>
                            <th scope="col" class="px-6 py-3 cursor-pointer">Tanggal Peminjaman</th>
                            <th scope="col" class="px-6 py-3 cursor-pointer">Tanggal Pengembalian</th>
                            <th scope="col" class="px-6 py-3 cursor-pointer">Status Pengembalian</th>
                        </tr>
                    </thead>
                    <tbody id="tableBodyPengembalian">
                        @foreach ($riwayatPengembalian as $pengembalian)
                            <tr class="bg-white border-b hover:bg-gray-100 transition duration-150"
                                data-type="riwayatPengembalian">
                                <td class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap">
                                    {{ $pengembalian->peminjaman->asset->nama_barang }}</td>
                                <td class="px-6 py-4">{{ $pengembalian->peminjaman->jumlah }}</td>
                                <td class="px-6 py-4">
                                    {{ \Carbon\Carbon::parse($pengembalian->created_at)->format('d F Y H:i') }}</td>
                                <td class="px-6 py-4">
                                    {{ \Carbon\Carbon::parse($pengembalian->tanggal_peminjaman)->format('d F Y') }}</td>
                                <td class="px-6 py-4">
                                    {{ \Carbon\Carbon::parse($pengembalian->tanggal_pengembalian)->format('d F Y') }}</td>
                                <td class="px-6 py-4">
                                    @if ($pengembalian->status == 'pending')
                                        <span class="text-yellow-500">Menunggu Persetujuan</span>
                                    @elseif($pengembalian->status == 'approved')
                                        <span class="text-green-500">Disetujui</span>
                                    @else
                                        <span class="text-red-500">Ditolak</span>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

    </div>

    <!-- JavaScript for Tabs and Filtering -->
    <script>
        const peminjamanTab = document.getElementById('peminjamanTab');
        const pengembalianTab = document.getElementById('pengembalianTab');
        const peminjamanContent = document.getElementById('peminjamanContent');
        const pengembalianContent = document.getElementById('pengembalianContent');

        // Switch between tabs
        peminjamanTab.addEventListener('click', () => {
            peminjamanContent.classList.remove('hidden');
            pengembalianContent.classList.add('hidden');
            peminjamanTab.classList.add('bg-blue-700');
            pengembalianTab.classList.remove('bg-blue-700');
        });

        pengembalianTab.addEventListener('click', () => {
            pengembalianContent.classList.remove('hidden');
            peminjamanContent.classList.add('hidden');
            pengembalianTab.classList.add('bg-blue-700');
            peminjamanTab.classList.remove('bg-blue-700');
        });

        // Filtering functions for each tab
        document.getElementById('searchPeminjaman').addEventListener('input', filterPeminjaman);
        document.getElementById('statusFilterPeminjaman').addEventListener('change', filterPeminjaman);

        document.getElementById('searchPengembalian').addEventListener('input', filterPengembalian);
        document.getElementById('statusFilterPengembalian').addEventListener('change', filterPengembalian);

        function filterPeminjaman() {
            const searchQuery = document.getElementById('searchPeminjaman').value.toLowerCase();
            const statusFilter = document.getElementById('statusFilterPeminjaman').value.toLowerCase();
            const rows = document.querySelectorAll('#tableBodyPeminjaman tr');
            rows.forEach(row => {
                const namaAlat = row.querySelector('td').textContent.toLowerCase();
                const status = row.querySelectorAll('td')[5].textContent.toLowerCase();
                const match = (namaAlat.includes(searchQuery) && (status.includes(statusFilter) || statusFilter ===
                    ''));
                row.style.display = match ? '' : 'none';
            });
        }

        function filterPengembalian() {
            const searchQuery = document.getElementById('searchPengembalian').value.toLowerCase();
            const statusFilter = document.getElementById('statusFilterPengembalian').value.toLowerCase();
            const rows = document.querySelectorAll('#tableBodyPengembalian tr');
            rows.forEach(row => {
                const namaAlat = row.querySelector('td').textContent.toLowerCase();
                const status = row.querySelectorAll('td')[5].textContent.toLowerCase();
                const match = (namaAlat.includes(searchQuery) && (status.includes(statusFilter) || statusFilter ===
                    ''));
                row.style.display = match ? '' : 'none';
            });
        }
    </script>
@endsection
