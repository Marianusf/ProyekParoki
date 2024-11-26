@extends('layout.TemplatePeminjam')

@section('title', 'RiwayatPeminjaman')

@section('content')
    <div class="container mx-auto py-8">
        <h1 class="text-3xl font-semibold mb-6">Riwayat Peminjaman</h1>

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
                <input type="text" id="search"
                    class="p-3 w-96 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 text-lg"
                    placeholder="Cari berdasarkan nama asset..." />
            </div>
        </div>
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

        <div class="mb-6">
            <label for="historyFilter" class="text-lg mr-4">Filter Riwayat:</label>
            <select id="historyFilter">
                <option value="riwayatSelesai" selected>Riwayat Selesai</option>
                <option value="riwayatPeminjaman">Riwayat Peminjaman</option>
                <option value="riwayatPengembalian">Riwayat Pengembalian</option>
            </select>
        </div>

        <div class="overflow-x-auto shadow-md sm:rounded-lg max-h-96">
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
                    @foreach ($riwayatSelesai as $riwayat)
                        @if (
                            $riwayat->pengembalian &&
                                $riwayat->pengembalian->status == 'approved' &&
                                $riwayat->status_peminjaman == 'disetujui')
                            <tr class="bg-white border-b hover:bg-gray-100 transition duration-150"
                                data-type="riwayatSelesai">
                                <td class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap">
                                    {{ $riwayat->asset->nama_barang }}
                                </td>

                                <td class="px-6 py-4">{{ $riwayat->jumlah }}</td>
                                <td class="px-6 py-4">
                                    {{ \Carbon\Carbon::parse($riwayat->created_at)->format('d F Y H:i') }}</td>
                                <td class="px-6 py-4">
                                    {{ \Carbon\Carbon::parse($riwayat->tanggal_peminjaman)->format('d F Y') }}</td>
                                <td class="px-6 py-4">
                                    {{ \Carbon\Carbon::parse($riwayat->pengembalian->tanggal_pengembalian)->format('d F Y') }}
                                </td>
                                <td class="px-6 py-4">
                                    <span class="text-green-500 flex items-center space-x-1">
                                        <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="none"
                                            viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M5 13l4 4L19 7" />
                                        </svg>
                                        <span>DISETUJUI</span>
                                    </span>
                                </td>
                            </tr>
                        @endif
                    @endforeach

                    @foreach ($riwayatPeminjaman as $peminjaman)
                        <tr class="bg-white border-b hover:bg-gray-100 transition duration-150"
                            data-type="riwayatPeminjaman">
                            <td class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap">
                                {{ $peminjaman->asset->nama_barang }}
                            </td>
                            <td class="px-6 py-4">{{ $peminjaman->jumlah }}</td>
                            <td class="px-6 py-4">
                                {{ \Carbon\Carbon::parse($peminjaman->created_at)->format('d F Y H:i') }}
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
                    @foreach ($riwayatPengembalian as $pengembalian)
                        <tr class="bg-white border-b hover:bg-gray-100 transition duration-150"
                            data-type="riwayatPengembalian">
                            <td class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap">
                                {{ $pengembalian->peminjaman->asset->nama_barang }}
                            </td>
                            <td class="px-6 py-4">{{ $pengembalian->peminjaman->jumlah }}</td>
                            <td class="px-6 py-4">
                                {{ \Carbon\Carbon::parse($pengembalian->created_at)->format('d F Y H:i') }}</td>
                            <td class="px-6 py-4">
                                {{ \Carbon\Carbon::parse($pengembalian->tanggal_peminjaman)->format('d F Y') }}</td>
                            <td class="px-6 py-4">
                                {{ \Carbon\Carbon::parse($pengembalian->tanggal_pengembalian)->format('d F Y') }}</td>
                            <td class="px-6 py-4">
                                @if ($pengembalian->status == 'pending')
                                    <span class="text-yellow-500 flex items-center space-x-1">
                                        <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="none"
                                            viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M12 8v4m0 4h0M12 4v.01M16.05 4.95a9 9 0 11-12.1 0 9 9 0 0112.1 0z" />
                                        </svg>
                                        <span>Menunggu Persetujuan</span>
                                    </span>
                                @elseif($pengembalian->status == 'approved')
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
    </div>

    <style>
        .highlight {
            background-color: #bfdbfe;
            /* Biru muda */
            font-weight: 600;
            /* Font tebal */
        }
    </style>

    <script>
        document.getElementById('historyFilter').addEventListener('change', function() {
            const selectedView = this.value;
            const tables = ['riwayatPeminjamanTable', 'riwayatPengembalianTable', 'riwayatSelesaiTable'];

            tables.forEach(function(tableId) {
                const table = document.getElementById(tableId);
                if (tableId === selectedView + 'Table') {
                    table.classList.remove('hidden');
                } else {
                    table.classList.add('hidden');
                }
            });
        });
        document.addEventListener('DOMContentLoaded', function() {
            // Set default filter berdasarkan value yang terpilih
            let selectedFilter = document.getElementById('historyFilter').value;
            let rows = document.querySelectorAll('tbody tr');

            rows.forEach(row => {
                if (row.dataset.type === selectedFilter) {
                    row.style.display = ''; // Menampilkan baris yang sesuai dengan filter default
                } else {
                    row.style.display = 'none'; // Menyembunyikan baris yang tidak sesuai
                }
            });
        });

        document.getElementById('historyFilter').addEventListener('change', function() {
            let selectedFilter = this.value;
            let rows = document.querySelectorAll('tbody tr');

            rows.forEach(row => {
                if (selectedFilter === row.dataset.type) {
                    row.style.display = ''; // Menampilkan baris yang sesuai dengan filter
                } else {
                    row.style.display = 'none'; // Menyembunyikan baris yang tidak sesuai
                }
            });
        });


        document.addEventListener('DOMContentLoaded', function() {
            const historyFilter = document.getElementById('historyFilter');
            const searchInput = document.getElementById('search');
            const statusFilter = document.getElementById('statusFilter');
            const monthFilter = document.getElementById('monthFilter');
            const itemsPerPageSelect = document.getElementById('itemsPerPage');
            const tableBody = document.getElementById('tableBody');

            function highlightText(text, term) {
                if (!term) return text; // Jika tidak ada term, tidak perlu highlight
                const regex = new RegExp(`(${term})`, 'gi'); // Regex untuk pencarian global dan case-insensitive
                return text.replace(regex, '<span class="highlight">$1</span>'); // Tambahkan kelas highlight
            }

            function filterRows() {
                const selectedFilter = historyFilter.value;
                const searchTerm = searchInput.value.toLowerCase();
                const filterStatus = statusFilter.value.toLowerCase();
                const filterMonth = monthFilter.value;

                const rows = Array.from(tableBody.querySelectorAll('tr'));

                rows.forEach(row => {
                    const rowType = row.dataset.type;
                    const assetNameCell = row.cells[0]; // Kolom Nama Asset
                    const assetName = assetNameCell.textContent.toLowerCase();
                    const statusText = row.cells[5].textContent.trim().toLowerCase();
                    const createdAt = row.cells[2].textContent.trim(); // Tanggal Pengajuan
                    const monthFromDate = new Date(createdAt).getMonth() + 1; // Get month index (1-based)

                    const matchesType = rowType === selectedFilter;
                    const matchesSearch = assetName.includes(searchTerm);
                    const matchesStatus = filterStatus === '' || statusText.includes(filterStatus);
                    const matchesMonth = filterMonth === '' || monthFromDate === parseInt(filterMonth);

                    if (matchesType && matchesSearch && matchesStatus && matchesMonth) {
                        row.style.display = ''; // Show row
                        assetNameCell.innerHTML = highlightText(assetNameCell.textContent, searchInput
                            .value);
                    } else {
                        row.style.display = 'none'; // Hide row
                    }
                });
            }

            historyFilter.addEventListener('change', filterRows);
            searchInput.addEventListener('input', filterRows);
            statusFilter.addEventListener('change', filterRows);
            monthFilter.addEventListener('change', filterRows);
            itemsPerPageSelect.addEventListener('change', filterRows);

            filterRows();
        });
    </script>
@endsection
