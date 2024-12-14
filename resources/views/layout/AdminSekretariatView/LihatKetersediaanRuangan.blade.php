@extends('layout.TemplateAdminSekretariat')

@section('title', 'Daftar Ruangan')

@section('content')
    <section class="p-6 bg-gray-100 min-h-screen">
        <div class="container mx-auto">
            <!-- Header Section -->
            <div class="flex justify-between items-center mb-6">
                <h2 class="text-3xl font-bold text-gray-800">Daftar Ruangan Aktif</h2>
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
            <button onclick="window.location.reload();"
                class="bg-transparent text-blue-500 hover:text-blue-700 p-2 rounded-full transition duration-200 ease-in-out"
                title="Refresh halaman">
                <i class="fas fa-sync-alt text-xl"></i> <!-- Ikon refresh -->
            </button>
            <!-- Filter dan Search -->
            <div class="flex space-x-4 mb-6">
                <!-- Search -->
                <div class="relative flex-grow">
                    <input type="text" id="search"
                        class="border border-gray-300 rounded-lg p-3 w-full pl-12 focus:ring-2 focus:ring-blue-500"
                        placeholder="Cari ruangan...">
                    <span class="absolute left-4 top-3 text-gray-400">
                        <i class="fas fa-search text-lg"></i> <!-- FontAwesome Icon -->
                    </span>
                </div>

                <!-- Filter Dropdown -->
                <select id="statusFilter" class="border border-gray-300 rounded-lg p-2 focus:ring-2 focus:ring-blue-500">
                    <option value="all">Semua</option>
                    <option value="tersedia">Tersedia</option>
                    <option value="dipinjam">Dipinjam</option>
                </select>

                <!-- Sorting Button -->
                <button id="sortByName" class="bg-blue-500 text-white px-4 py-2 rounded-lg hover:bg-blue-600 transition">
                    Urutkan Berdasarkan Nama
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
                                    data-status="{{ $room->status_peminjaman }}">
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
                                    <td class="py-3 px-6 text-center status-column">
                                        <span
                                            class="px-3 py-1 rounded-full text-white text-xs
                                            {{ $room->status_peminjaman == 'tersedia' ? 'bg-green-500' : 'bg-red-500' }}">
                                            {{ ucfirst($room->status_peminjaman) }}
                                        </span>
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
            const statusFilter = document.getElementById('statusFilter');
            const sortByNameButton = document.getElementById('sortByName');
            const tableRows = document.querySelectorAll('#roomTable tbody tr');

            // Filter berdasarkan pencarian
            const filterTable = () => {
                const searchText = searchInput.value.toLowerCase();

                tableRows.forEach(row => {
                    const cells = row.querySelectorAll('td');
                    let isMatch = false;

                    cells.forEach(cell => {
                        if (!cell.textContent) return; // Abaikan sel kosong
                        if (cell.textContent.toLowerCase().includes(searchText)) {
                            isMatch = true;
                        }
                    });

                    row.style.display = isMatch || searchText === '' ? '' : 'none';
                });
            };

            // Filter berdasarkan status
            const filterByStatus = () => {
                const selectedStatus = statusFilter.value;

                tableRows.forEach(row => {
                    const rowStatus = row.getAttribute('data-status');
                    row.style.display = (selectedStatus === 'all' || rowStatus === selectedStatus) ?
                        '' : 'none';
                });
            };

            // Sorting berdasarkan nama
            const sortByName = () => {
                const tableBody = document.querySelector('#roomTable tbody');
                const rowsArray = Array.from(tableRows);

                rowsArray.sort((a, b) => {
                    const nameA = a.querySelector('td:nth-child(2)').textContent.trim().toLowerCase();
                    const nameB = b.querySelector('td:nth-child(2)').textContent.trim().toLowerCase();
                    return nameA.localeCompare(nameB);
                });

                rowsArray.forEach(row => tableBody.appendChild(row));
            };

            // Event listeners
            searchInput.addEventListener('input', () => {
                filterTable();
                filterByStatus();
            });

            statusFilter.addEventListener('change', filterByStatus);
            sortByNameButton.addEventListener('click', sortByName);
        });
    </script>
@endsection
