@extends('layout.TemplatePeminjam')

@section('title', 'Riwayat Peminjaman Ruangan')

@section('content')
    <div class="container mx-auto py-8">
        <h1 class="text-3xl font-semibold mb-6">Riwayat Peminjaman Ruangan</h1>

        <!-- Filter and Search -->
        <div class="flex justify-between mb-6">
            <!-- Dropdown untuk jumlah data per halaman -->
            <div class="flex items-center space-x-4">
                <label for="itemsPerPage" class="text-lg font-medium">Tampilkan:</label>
                <select id="itemsPerPage" class="bg-gray-100 p-2 rounded-md text-base">
                    <option value="10">10</option>
                    <option value="20">20</option>
                    <option value="50">50</option>
                    <option value="100">100</option>
                </select>
            </div>

            <!-- Input pencarian -->
            <div class="relative w-1/3">
                <input type="text" id="search"
                    class="p-3 w-full border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 text-lg"
                    placeholder="Cari berdasarkan nama ruangan...">
                <span class="absolute right-3 top-3 text-gray-400 cursor-pointer" id="clearSearch" title="Hapus pencarian">
                    <i class="fas fa-times hidden"></i>
                </span>
            </div>

            <!-- Filter Status -->
            <div class="flex items-center space-x-4">
                <label for="statusFilter" class="text-lg font-medium">Filter Status:</label>
                <select id="statusFilter" class="bg-gray-100 p-2 rounded-md text-base">
                    <option value="">Semua Status</option>
                    <option value="menunggu persetujuan">Menunggu Persetujuan</option>
                    <option value="disetujui">Disetujui</option>
                    <option value="selesai">Selesai</option>
                </select>
            </div>
        </div>

        <!-- Table Riwayat Peminjaman -->
        <div class="overflow-x-auto bg-white shadow-md rounded-lg">
            <table class="min-w-full text-sm text-left text-gray-500">
                <thead class="text-xs text-gray-700 uppercase bg-gray-200">
                    <tr>
                        <th class="px-6 py-3">Nama Ruangan</th>
                        <th class="px-6 py-3">Tanggal Mulai</th>
                        <th class="px-6 py-3">Tanggal Selesai</th>
                        <th class="px-6 py-3">Tanggal Pengajuan</th>
                        <th class="px-6 py-3">Status Peminjaman</th>
                    </tr>
                </thead>
                <tbody id="tableBody">
                    @foreach ($riwayatPeminjaman as $peminjaman)
                        <tr class="bg-white border-b hover:bg-gray-100 transition duration-150"
                            data-status="{{ $peminjaman->status_peminjaman }}">
                            <td class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap">
                                {{ $peminjaman->ruangan->nama }}
                            </td>
                            <td class="px-6 py-4">
                                {{ \Carbon\Carbon::parse($peminjaman->tanggal_mulai)->format('d F Y') }}
                            </td>
                            <td class="px-6 py-4">
                                {{ \Carbon\Carbon::parse($peminjaman->tanggal_selesai)->format('d F Y') }}
                            </td>
                            <td class="px-6 py-4">
                                {{ \Carbon\Carbon::parse($peminjaman->created_at)->format('d F Y') }}
                            </td>

                            <td class="px-6 py-4">
                                @if ($peminjaman->status_peminjaman == 'menunggu persetujuan')
                                    <span
                                        class="inline-flex items-center px-3 py-1 rounded-full bg-yellow-100 text-yellow-800 border border-yellow-300">
                                        <i class="fas fa-clock mr-2"></i> Menunggu Persetujuan
                                    </span>
                                @elseif ($peminjaman->status_peminjaman == 'disetujui')
                                    <span
                                        class="inline-flex items-center px-3 py-1 rounded-full bg-green-100 text-green-800 border border-green-300">
                                        <i class="fas fa-check-circle mr-2"></i> Disetujui
                                    </span>
                                @elseif ($peminjaman->status_peminjaman == 'selesai')
                                    <span
                                        class="inline-flex items-center px-3 py-1 rounded-full bg-blue-100 text-blue-800 border border-blue-300">
                                        <i class="fas fa-flag-checkered mr-2"></i> Selesai
                                    </span>
                                @else
                                    <span
                                        class="inline-flex items-center px-3 py-1 rounded-full bg-red-100 text-red-800 border border-red-300">
                                        <i class="fas fa-times-circle mr-2"></i> Ditolak
                                    </span>
                                @endif
                            </td>


                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <!-- JavaScript for Search, Filter, and Pagination -->
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const searchInput = document.getElementById('search');
            const clearSearchButton = document.getElementById('clearSearch');
            const statusFilter = document.getElementById('statusFilter');
            const itemsPerPage = document.getElementById('itemsPerPage');
            const tableRows = document.querySelectorAll('#tableBody tr');

            const filterTable = () => {
                const searchQuery = searchInput.value.toLowerCase();
                const selectedStatus = statusFilter.value.toLowerCase();

                tableRows.forEach(row => {
                    const name = row.querySelector('td:nth-child(1)').textContent.toLowerCase();
                    const status = row.dataset.status.toLowerCase();

                    const matchesSearch = name.includes(searchQuery);
                    const matchesStatus = selectedStatus === '' || status === selectedStatus;

                    row.style.display = matchesSearch && matchesStatus ? '' : 'none';
                });
            };

            searchInput.addEventListener('input', () => {
                clearSearchButton.querySelector('i').classList.toggle('hidden', !searchInput.value);
                filterTable();
            });

            clearSearchButton.addEventListener('click', () => {
                searchInput.value = '';
                clearSearchButton.querySelector('i').classList.add('hidden');
                filterTable();
            });

            statusFilter.addEventListener('change', filterTable);
            itemsPerPage.addEventListener('change', filterTable);
        });
    </script>
@endsection
