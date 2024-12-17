@extends('layout.TemplatePeminjam')

@section('title', 'Daftar Ruangan')

@section('content')
    <section class="p-6 bg-gray-100 min-h-screen">
        <div class="container mx-auto">
            <!-- Header Section -->
            <div class="flex justify-between items-center mb-6">
                <h2 class="text-3xl font-bold text-gray-800">Daftar Ketersediaan Ruangan</h2>
            </div>

            <!-- Flash Messages -->
            @if (session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4">
                    <strong class="font-bold">Sukses:</strong>
                    <span class="block sm:inline">{{ session('success') }}</span>
                </div>
            @endif

            @if (session('error'))
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4">
                    <strong class="font-bold">Error:</strong>
                    <span class="block sm:inline">{{ session('error') }}</span>
                </div>
            @endif

            <!-- Refresh Button -->
            <button onclick="window.location.reload();"
                class="bg-transparent text-blue-500 hover:text-blue-700 p-2 rounded-full transition duration-200 ease-in-out"
                title="Refresh halaman">
                <i class="fas fa-sync-alt text-xl"></i>
            </button>

            <!-- Filter dan Search -->
            <div class="flex space-x-4 mb-6">
                <div class="relative flex-grow">
                    <!-- Input Search -->
                    <input type="text" id="search"
                        class="border border-gray-300 rounded-lg p-3 w-full pl-12 pr-10 focus:ring-2 focus:ring-blue-500"
                        placeholder="Cari ruangan...">

                    <!-- Ikon Search -->
                    <span class="absolute left-4 top-3 text-gray-400">
                        <i class="fas fa-search text-lg"></i>
                    </span>

                    <!-- Tombol Clear Search -->
                    <button id="clearSearch"
                        class="absolute right-3 top-3 text-gray-400 hover:text-gray-600 focus:outline-none hidden"
                        title="Hapus pencarian">
                        <i class="fas fa-times"></i>
                    </button>
                </div>

                <!-- Filter Dropdown -->
                <select id="statusFilter" class="border border-gray-300 rounded-lg p-2 focus:ring-2 focus:ring-blue-500">
                    <option value="all">Semua</option>
                    <option value="tersedia">Tersedia</option>
                    <option value="dipinjam">Dipinjam</option>
                </select>

                <!-- Sorting Buttons -->
                <button id="sortByName" class="bg-blue-500 text-white px-4 py-2 rounded-lg hover:bg-blue-600 transition">
                    Urutkan Berdasarkan Nama
                </button>
                <button id="sortByStatus"
                    class="bg-yellow-500 text-white px-4 py-2 rounded-lg hover:bg-yellow-600 transition">
                    Urutkan Berdasarkan Status
                </button>
            </div>

            <!-- Room Table -->
            <div class="overflow-x-auto overflow-y-auto max-h-[500px] bg-white shadow-md rounded-lg">
                @if ($rooms->count() > 0)
                    <table id="roomTable" class="min-w-full table-auto">
                        <thead class="bg-indigo-600 text-white text-sm uppercase">
                            <tr>
                                <th class="py-3 px-6 text-left">Gambar</th>
                                <th class="py-3 px-6 text-left">Nama Ruangan</th>
                                <th class="py-3 px-6 text-left">Kapasitas</th>
                                <th class="py-3 px-6 text-left">Deskripsi</th>
                                <th class="py-3 px-6 text-left">Fasilitas</th>
                                <th class="py-3 px-6 text-center">Status</th>
                            </tr>
                        </thead>
                        <tbody class="text-gray-800 text-sm">
                            @foreach ($rooms as $room)
                                <tr class="border-b hover:bg-gray-100 transition duration-300"
                                    data-status="{{ strtolower($room->status_peminjaman) }}">
                                    <!-- Gambar -->
                                    <td class="py-3 px-6">
                                        @if ($room->gambar)
                                            <img src="{{ asset('storage/' . $room->gambar) }}"
                                                alt="Gambar {{ $room->nama }}"
                                                class="w-20 h-20 object-cover rounded-lg shadow">
                                        @else
                                            <span class="text-gray-500">Tidak ada gambar</span>
                                        @endif
                                    </td>

                                    <!-- Nama -->
                                    <td class="py-3 px-6 highlight-cell">{{ $room->nama }}</td>

                                    <!-- Kapasitas -->
                                    <td class="py-3 px-6">{{ $room->kapasitas }}</td>

                                    <!-- Deskripsi -->
                                    <td class="py-3 px-6">{{ Str::limit($room->deskripsi, 50) }}</td>

                                    <!-- Fasilitas -->
                                    <td class="py-3 px-6">
                                        @if ($room->fasilitas)
                                            <ol class="list-decimal list-inside text-gray-600">
                                                @foreach (json_decode($room->fasilitas) as $fasilitas)
                                                    <li>{{ $fasilitas }}</li>
                                                @endforeach
                                            </ol>
                                        @else
                                            <span class="text-gray-500">Tidak ada fasilitas</span>
                                        @endif
                                    </td>

                                    <!-- Status -->
                                    <td class="py-3 px-6 text-center">
                                        @if ($room->status_peminjaman === 'dipinjam')
                                            <span
                                                class="flex items-center justify-center px-3 py-1 rounded-full text-xs bg-red-500 text-white">
                                                <i class="fas fa-times-circle mr-2"></i> Dipinjam
                                            </span>
                                        @else
                                            <span
                                                class="flex items-center justify-center px-3 py-1 rounded-full text-xs bg-green-500 text-white">
                                                <i class="fas fa-check-circle mr-2"></i> Tersedia
                                            </span>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @else
                    <!-- Empty State -->
                    <div class="p-6 text-center">
                        <h3 class="text-gray-600 text-lg">Belum ada ruangan yang tersedia.</h3>
                    </div>
                @endif
            </div>
        </div>
    </section>

    <!-- Script untuk Filtering, Sorting, dan Pencarian -->
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const searchInput = document.getElementById('search');
            const clearSearchButton = document.getElementById('clearSearch');
            const statusFilter = document.getElementById('statusFilter');
            const sortByNameButton = document.getElementById('sortByName');
            const sortByStatusButton = document.getElementById('sortByStatus');
            const tableRows = document.querySelectorAll('#roomTable tbody tr');

            // Filter tabel berdasarkan input search dan filter status
            const filterTable = () => {
                const searchText = searchInput.value.toLowerCase();
                const selectedStatus = statusFilter.value;

                tableRows.forEach(row => {
                    const rowStatus = row.getAttribute('data-status').toLowerCase();
                    const rowText = row.textContent.toLowerCase();

                    const matchesSearch = rowText.includes(searchText);
                    const matchesStatus = (selectedStatus === 'all' || rowStatus === selectedStatus);

                    row.style.display = (matchesSearch && matchesStatus) ? '' : 'none';
                });
            };

            // Sorting berdasarkan nama ruangan
            sortByNameButton.addEventListener('click', () => {
                sortTable(1); // Kolom ke-2: Nama
            });

            // Sorting berdasarkan status
            sortByStatusButton.addEventListener('click', () => {
                sortTable(5); // Kolom ke-5: Status
            });

            // Fungsi sorting tabel
            function sortTable(columnIndex) {
                const tableBody = document.querySelector('#roomTable tbody');
                const rowsArray = Array.from(tableRows);

                rowsArray.sort((a, b) => {
                    const aValue = a.children[columnIndex].textContent.trim().toLowerCase();
                    const bValue = b.children[columnIndex].textContent.trim().toLowerCase();
                    return aValue.localeCompare(bValue);
                });

                rowsArray.forEach(row => tableBody.appendChild(row));
            }

            // Tampilkan/Sembunyikan tombol clear berdasarkan input search
            searchInput.addEventListener('input', () => {
                clearSearchButton.classList.toggle('hidden', searchInput.value.length === 0);
                filterTable();
            });

            // Event klik tombol clear search
            clearSearchButton.addEventListener('click', () => {
                searchInput.value = '';
                clearSearchButton.classList.add('hidden');
                filterTable();
            });

            // Event listener untuk filter status
            statusFilter.addEventListener('change', filterTable);
        });
    </script>
@endsection
