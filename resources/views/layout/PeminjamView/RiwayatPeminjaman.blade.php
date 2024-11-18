@extends('layout.TemplatePeminjam')

@section('title', 'Riwayat Peminjaman')

@section('content')
    <div class="container mx-auto py-8">
        <h1 class="text-2xl font-bold mb-6">Riwayat Peminjaman</h1>

        <!-- Dropdown Jumlah Item yang Ditampilkan -->
        <div class="flex items-center mb-4">
            <label for="itemsPerPage" class="mr-2">Tampilkan:</label>
            <select id="itemsPerPage" class="p-2 border rounded-md w-1/4">
                <option value="10">10</option>
                <option value="20">20</option>
                <option value="50">50</option>
                <option value="100">100</option>
            </select>
            <span id="itemCount" class="ml-4 text-sm text-gray-600"></span>
        </div>

        <!-- Pencarian -->
        <div class="flex items-center mb-4">
            <input type="text" id="search" class="p-2 border rounded-md w-full sm:w-1/3"
                placeholder="Cari berdasarkan nama asset..." />
        </div>

        <!-- Filter Status -->
        <div class="flex items-center mb-4">
            <label for="statusFilter" class="mr-2">Filter Status:</label>
            <select id="statusFilter" class="p-2 border rounded-md w-1/4">
                <option value="">Semua</option>
                <option value="pending">Menunggu Persetujuan</option>
                <option value="disetujui">Disetujui</option>
                <option value="ditolak">Ditolak</option>
            </select>
        </div>

        <div class="overflow-x-auto shadow-md sm:rounded-lg max-h-[500px] overflow-y-auto">
            <table class="min-w-full text-sm text-left text-gray-500" id="riwayatTable">
                <thead class="text-xs text-gray-700 uppercase bg-gray-200 sticky top-0">
                    <tr>
                        <th scope="col" class="px-6 py-3 cursor-pointer" onclick="sortTable(0)">Nama Asset <span
                                id="sort-arrow-0"></span></th>
                        <th scope="col" class="px-6 py-3 cursor-pointer" onclick="sortTable(1)">Jumlah <span
                                id="sort-arrow-1"></span></th>
                        <th scope="col" class="px-6 py-3 cursor-pointer" onclick="sortTable(2)">Tanggal Pengajuan <span
                                id="sort-arrow-2"></span></th>
                        <th scope="col" class="px-6 py-3 cursor-pointer" onclick="sortTable(3)">Tanggal Peminjaman <span
                                id="sort-arrow-3"></span></th>
                        <th scope="col" class="px-6 py-3 cursor-pointer" onclick="sortTable(4)">Tanggal Pengembalian
                            <span id="sort-arrow-4"></span>
                        </th>
                        <th scope="col" class="px-6 py-3 cursor-pointer" onclick="sortTable(5)">Status Peminjaman <span
                                id="sort-arrow-5"></span></th>
                    </tr>
                </thead>
                <tbody id="tableBody">
                    @foreach ($riwayatPeminjaman as $peminjaman)
                        <tr class="bg-white border-b hover:bg-gray-100 transition duration-150">
                            <td class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap">
                                {{ $peminjaman->asset->nama_barang }}
                            </td>
                            <td class="px-6 py-4">{{ $peminjaman->jumlah }}</td>
                            <td class="px-6 py-4">{{ $peminjaman->created_at }}</td>
                            <td class="px-6 py-4">{{ $peminjaman->tanggal_peminjaman }}</td>
                            <td class="px-6 py-4">{{ $peminjaman->tanggal_pengembalian }}</td>
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

    <script>
        const searchInput = document.getElementById('search');
        const statusFilter = document.getElementById('statusFilter');
        const itemsPerPageSelect = document.getElementById('itemsPerPage');
        const itemCount = document.getElementById('itemCount');
        const tableBody = document.getElementById('tableBody');
        let itemsPerPage = parseInt(itemsPerPageSelect.value);

        function updateDisplay() {
            const rows = Array.from(tableBody.getElementsByTagName('tr'));
            const searchTerm = searchInput.value.toLowerCase();
            const filterStatus = statusFilter.value.toLowerCase(); // status filter value in lowercase

            let visibleCount = 0;

            rows.forEach((row) => {
                const assetName = row.cells[0].textContent.toLowerCase(); // Asset name in lowercase
                const statusText = row.cells[5].textContent.trim()
                    .toLowerCase(); // Status text in lowercase and trimmed

                // Check if asset name contains search term
                const matchesSearch = assetName.includes(searchTerm);
                // Check if status matches filter
                const matchesStatus = filterStatus === "" || statusText === filterStatus;

                if (matchesSearch && matchesStatus) {
                    row.style.display = ''; // Show row if it matches search and status
                    visibleCount++;
                } else {
                    row.style.display = 'none'; // Hide row if it doesn't match
                }
            });

            // Update item count text
            itemCount.textContent = `Menampilkan ${visibleCount} dari ${rows.length} item`;
        }




        searchInput.addEventListener('keyup', updateDisplay);
        statusFilter.addEventListener('change', updateDisplay);
        itemsPerPageSelect.addEventListener('change', function() {
            itemsPerPage = parseInt(this.value);
            updateDisplay();
        });

        updateDisplay(); // Initial call to set up the display
    </script>
@endsection
