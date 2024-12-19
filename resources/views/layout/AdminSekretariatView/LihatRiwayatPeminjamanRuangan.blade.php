@extends('layout.TemplateAdminSekretariat')

@section('title', 'Riwayat Peminjaman Ruangan')

@section('content')
    <div class="container mx-auto py-8">
        <h1 class="text-3xl font-semibold mb-6 flex items-center">
            <i class="fas fa-calendar-check mr-2"></i> Riwayat Peminjaman Ruangan
        </h1>

        <!-- Filter & Search -->
        <div class="flex items-center mb-4">
            <div class="mr-4">
                <label for="statusFilter" class="text-lg font-semibold">Filter Status:</label>
                <select id="statusFilter" class="p-2 border rounded-lg">
                    <option value="">Semua</option>
                    <option value="Sedang Aktif">Sedang Aktif</option>
                    <option value="Selesai">Selesai</option>
                    <option value="Akan Datang">Akan Datang</option>
                </select>
            </div>
            <div class="flex-1">
                <input type="text" id="searchInput" placeholder="Cari data..." class="p-2 border rounded-lg w-full">
            </div>
        </div>

        <!-- Table -->
        <div class="overflow-x-auto border rounded-lg shadow">
            <table class="w-full text-sm text-left text-gray-500" id="dataTable">
                <thead class="text-xs text-gray-700 uppercase bg-gray-200 sticky top-0">
                    <tr>
                        <th class="px-4 py-3 cursor-pointer" onclick="sortTable(0)">Nama Ruangan <span
                                class="sort-icon">&#8597;</span></th>
                        <th class="px-4 py-3 cursor-pointer" onclick="sortTable(1)">Peminjam <span
                                class="sort-icon">&#8597;</span></th>
                        <th class="px-4 py-3 cursor-pointer" onclick="sortTable(2)">Waktu Mulai <span
                                class="sort-icon">&#8597;</span></th>
                        <th class="px-4 py-3 cursor-pointer" onclick="sortTable(3)">Waktu Selesai <span
                                class="sort-icon">&#8597;</span></th>
                        <th class="px-4 py-3 cursor-pointer" onclick="sortTable(4)">Tanggal Dibuat <span
                                class="sort-icon">&#8597;</span></th>
                        <th class="px-4 py-3 cursor-pointer" onclick="sortTable(5)">Status <span
                                class="sort-icon">&#8597;</span></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($peminjaman as $item)
                        @php
                            $tanggalMulai = \Carbon\Carbon::parse($item->tanggal_mulai);
                            $tanggalSelesai = \Carbon\Carbon::parse($item->tanggal_selesai);

                            if (\Carbon\Carbon::now()->between($tanggalMulai, $tanggalSelesai)) {
                                $status = 'Sedang Aktif';
                                $warna = 'text-blue-500';
                                $icon = 'fas fa-play-circle';
                            } elseif (\Carbon\Carbon::now()->greaterThan($tanggalSelesai)) {
                                $status = 'Selesai';
                                $warna = 'text-green-500';
                                $icon = 'fas fa-check-circle';
                            } else {
                                $status = 'Akan Datang';
                                $warna = 'text-yellow-500';
                                $icon = 'fas fa-clock';
                            }
                        @endphp
                        <tr class="hover:bg-gray-100 transition" data-status="{{ $status }}">
                            <td class="px-4 py-3">{{ $item->ruangan->nama }}</td>
                            <td class="px-4 py-3">{{ $item->peminjam->name }}</td>
                            <td class="px-4 py-3">{{ $tanggalMulai->format('H:i d F Y') }}</td>
                            <td class="px-4 py-3">{{ $tanggalSelesai->format('H:i d F Y') }}</td>
                            <td class="px-4 py-3">{{ $item->created_at->format('H:i d F Y') }}</td>
                            <td class="px-4 py-3 font-semibold {{ $warna }}">
                                <i class="{{ $icon }} mr-2"></i> <span
                                    class="status-text">{{ $status }}</span>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <!-- Scripts -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const statusFilter = document.getElementById('statusFilter');
            const searchInput = document.getElementById('searchInput');
            const rows = document.querySelectorAll('#dataTable tbody tr');

            // Filtering & Searching
            function filterAndSearch() {
                const selectedStatus = statusFilter.value.toLowerCase();
                const searchQuery = searchInput.value.toLowerCase();

                rows.forEach(row => {
                    const rowStatus = row.getAttribute('data-status').toLowerCase();
                    const rowText = row.innerText.toLowerCase();
                    const statusMatch = selectedStatus === '' || rowStatus === selectedStatus;
                    const searchMatch = rowText.includes(searchQuery);

                    // Toggle row display
                    row.style.display = statusMatch && searchMatch ? '' : 'none';

                    // Highlight search results while keeping icons intact
                    row.querySelectorAll('.status-text').forEach(cell => {
                        cell.innerHTML = cell.textContent.replace(new RegExp(searchQuery, 'gi'),
                            match =>
                            `<span class="bg-yellow-200">${match}</span>`
                        );
                    });
                });
            }

            statusFilter.addEventListener('change', filterAndSearch);
            searchInput.addEventListener('input', filterAndSearch);

            // Sorting
            let currentSortCol = -1,
                currentSortDir = 'asc';

            function sortTable(column) {
                const table = document.getElementById('dataTable');
                const rowsArray = Array.from(table.tBodies[0].rows);
                const sortDir = (currentSortCol === column && currentSortDir === 'asc') ? 'desc' : 'asc';

                rowsArray.sort((a, b) => {
                    const cellA = a.cells[column].textContent.trim().toLowerCase();
                    const cellB = b.cells[column].textContent.trim().toLowerCase();
                    return (sortDir === 'asc') ? cellA.localeCompare(cellB) : cellB.localeCompare(cellA);
                });

                rowsArray.forEach(row => table.tBodies[0].appendChild(row));
                currentSortCol = column;
                currentSortDir = sortDir;

                // Update sort icons
                document.querySelectorAll('.sort-icon').forEach((icon, index) => {
                    icon.textContent = (index === column) ? (sortDir === 'asc' ? '▲' : '▼') : '↕';
                });
            }
        });
    </script>
@endsection
