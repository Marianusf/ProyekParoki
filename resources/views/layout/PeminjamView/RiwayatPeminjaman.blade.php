@extends('layout.TemplatePeminjam')

@section('title', 'Riwayat Peminjaman')

@section('content')
    <div class="container mx-auto py-8">
        <h1 class="text-3xl font-semibold mb-6">Riwayat Peminjaman</h1>

        <!-- Filter dan Pencarian -->
        <div class="flex justify-between items-center mb-4">
            <div class="flex space-x-4 items-center">
                <!-- Dropdown Jumlah Item yang Ditampilkan -->
                <label for="itemsPerPage" class="text-lg">Tampilkan:</label>
                <select id="itemsPerPage" class="bg-gray-100 p-2 rounded-md text-base font-medium">
                    <option value="10">10</option>
                    <option value="20">20</option>
                    <option value="50">50</option>
                    <option value="100">100</option>
                </select>
            </div>

            <div class="flex space-x-4 items-center">
                <!-- Input Pencarian -->
                <input type="text" id="search"
                    class="p-3 w-96 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 text-lg"
                    placeholder="Cari berdasarkan nama asset..." />
            </div>
        </div>

        <!-- Filter Status dan Bulan -->
        <div class="flex justify-between mb-4 space-x-4">
            <div class="flex items-center space-x-4 w-1/2 sm:w-1/4">
                <label for="statusFilter" class="text-lg">Filter Status:</label>
                <select id="statusFilter" class="bg-gray-100 p-2 rounded-md text-base">
                    <option value="">Semua Status</option>
                    <option value="menunggu persetujuan">Menunggu Persetujuan</option>
                    <option value="disetujui">Disetujui</option>
                    <option value="ditolak">Ditolak</option>
                </select>
            </div>

            <div class="flex items-center space-x-4 w-1/2 sm:w-1/4">
                <label for="monthFilter" class="text-lg">Filter Bulan:</label>
                <select id="monthFilter" class="bg-gray-100 p-2 rounded-md text-base">
                    <option value="">Semua Bulan</option>
                    <option value="01">Januari</option>
                    <option value="02">Februari</option>
                    <option value="03">Maret</option>
                    <option value="04">April</option>
                    <option value="05">Mei</option>
                    <option value="06">Juni</option>
                    <option value="07">Juli</option>
                    <option value="08">Agustus</option>
                    <option value="09">September</option>
                    <option value="10">Oktober</option>
                    <option value="11">November</option>
                    <option value="12">Desember</option>
                </select>
            </div>
        </div>

        <!-- Tabel Riwayat Peminjaman -->
        <div class="overflow-x-auto shadow-md sm:rounded-lg">
            <table class="min-w-full text-sm text-left text-gray-500">
                <thead class="text-xs text-gray-700 uppercase bg-gray-200 sticky top-0">
                    <tr>
                        <th scope="col" class="px-6 py-3 cursor-pointer">Nama Asset</th>
                        <th scope="col" class="px-6 py-3 cursor-pointer">Jumlah</th>
                        <th scope="col" class="px-6 py-3 cursor-pointer">Tanggal Pengajuan</th>
                        <th scope="col" class="px-6 py-3 cursor-pointer">Tanggal Peminjaman</th>
                        <th scope="col" class="px-6 py-3 cursor-pointer">Tanggal Pengembalian</th>
                        <th scope="col" class="px-6 py-3 cursor-pointer">Status Peminjaman</th>
                    </tr>
                </thead>
                <tbody id="tableBody">
                    @foreach ($riwayatPeminjaman as $peminjaman)
                        <tr class="bg-white border-b hover:bg-gray-50 transition duration-150">
                            <td class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap">
                                {{ $peminjaman->asset->nama_barang }}
                            </td>
                            <td class="px-6 py-4">{{ $peminjaman->jumlah }}</td>
                            <td class="px-6 py-4">{{ \Carbon\Carbon::parse($peminjaman->created_at)->format('d F Y H:i') }}
                            </td>
                            <td class="px-6 py-4">
                                {{ \Carbon\Carbon::parse($peminjaman->tanggal_peminjaman)->format('d F Y') }}</td>
                            <td class="px-6 py-4">
                                {{ \Carbon\Carbon::parse($peminjaman->tanggal_pengembalian)->format('d F Y') }}</td>
                            <td class="px-6 py-4">
                                @if ($peminjaman->status_peminjaman == 'pending')
                                    <span class="text-yellow-500 flex items-center space-x-1">
                                        <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="none"
                                            viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M12 8v4m0 4h0M12 4v.01M16.05 4.95a9 9 0 11-12.1 0 9 9 0 0112.1 0z" />
                                        </svg>
                                        <span>Menunggu Persetujuan</span>
                                    </span>
                                @elseif($peminjaman->status_peminjaman == 'disetujui')
                                    <span class="text-green-500 flex items-center space-x-1">
                                        <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="none"
                                            viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M5 13l4 4L19 7" />
                                        </svg>
                                        <span>Disetujui</span>
                                    </span>
                                @else
                                    <span class="text-red-500 flex items-center space-x-1">
                                        <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="none"
                                            viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M6 18L18 6M6 6l12 12" />
                                        </svg>
                                        <span>Ditolak</span>
                                    </span>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Pemberitahuan Jumlah Item yang Tersedia -->
        <div id="itemCount" class="mt-4 text-lg font-medium"></div>
    </div>

    <script>
        const searchInput = document.getElementById('search');
        const statusFilter = document.getElementById('statusFilter');
        const monthFilter = document.getElementById('monthFilter');
        const itemsPerPageSelect = document.getElementById('itemsPerPage');
        const itemCount = document.getElementById('itemCount');
        const tableBody = document.getElementById('tableBody');

        function updateDisplay() {
            const rows = Array.from(tableBody.getElementsByTagName('tr'));
            const searchTerm = searchInput.value.toLowerCase();
            const filterStatus = statusFilter.value.toLowerCase();
            const filterMonth = monthFilter.value;

            let visibleCount = 0;

            rows.forEach((row) => {
                const assetName = row.cells[0].textContent.toLowerCase();
                const statusText = row.cells[5].textContent.trim().toLowerCase();
                const createdAt = row.cells[2].textContent.trim(); // Tanggal Pengajuan
                const monthFromDate = new Date(createdAt).getMonth() + 1; // Get month index

                const matchesSearch = assetName.includes(searchTerm);
                const matchesStatus = filterStatus === '' || statusText.includes(filterStatus);
                const matchesMonth = filterMonth === '' || monthFromDate === parseInt(filterMonth);

                if (matchesSearch && matchesStatus && matchesMonth) {
                    row.style.display = '';
                    visibleCount++;
                } else {
                    row.style.display = 'none';
                }
            });

            itemCount.textContent = `Tampilkan ${visibleCount} item`;
        }

        searchInput.addEventListener('input', updateDisplay);
        statusFilter.addEventListener('change', updateDisplay);
        monthFilter.addEventListener('change', updateDisplay);
        itemsPerPageSelect.addEventListener('change', updateDisplay);

        updateDisplay(); // Initial call to display rows
    </script>
@endsection
