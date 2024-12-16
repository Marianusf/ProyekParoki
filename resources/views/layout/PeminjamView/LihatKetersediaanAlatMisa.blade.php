@extends('layout.TemplatePeminjam')

@section('title', 'Ketersediaan Alat Misa')

@section('content')
    <div class="container mx-auto py-8">
        <h2 class="text-2xl font-semibold mb-6">Daftar Ketersediaan Alat Misa</h2>
        <!-- SweetAlert Notifications -->
        @if (session('success'))
            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    Swal.fire({
                        icon: 'success',
                        title: 'Sukses!',
                        text: '{{ session('success') }}',
                        confirmButtonText: 'OK'
                    });
                });
            </script>
        @endif

        @if (session('error'))
            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error!',
                        text: '{{ session('error') }}',
                        confirmButtonText: 'OK'
                    });
                });
            </script>
        @endif

        <!-- Search and Sort Options -->
        <div class="mb-4 flex justify-between items-center">
            <!-- Search Input -->
            <div class="flex items-center">
                <label for="search" class="mr-2">Cari Alat Misa:</label>
                <input type="text" id="search" name="search" class="p-2 border rounded"
                    placeholder="Cari berdasarkan nama alat..." onkeyup="searchAssets()" />
            </div>

            <!-- Sorting Options -->
            <div class="flex items-center">
                <label for="sort" class="mr-2">Sortir Berdasarkan:</label>
                <select id="sort" name="sort" class="p-2 border rounded" onchange="sortAssets()">
                    <option value="nama_alat">Nama Alat</option>
                    <option value="stok_tersedia">Stok Tersedia</option>
                </select>
            </div>
        </div>

        <!-- Table of Alat Misa -->
        <div class="overflow-x-auto overflow-y-auto max-h-[500px] bg-white shadow-md rounded-lg">
            <button onclick="window.location.reload();"
                class="bg-transparent text-blue-500 hover:text-blue-700 p-2 rounded-full transition duration-200 ease-in-out"
                title="Refresh halaman">
                <i class="fas fa-sync-alt text-xl"></i> <!-- Ikon refresh -->
            </button>
            <table class="min-w-full table-auto">
                <thead>
                    <tr class="bg-gray-100 text-left text-sm text-gray-600">
                        <th class="px-6 py-3">Gambar</th>
                        <th class="px-6 py-3">Nama Alat</th>
                        <th class="px-6 py-3">Jenis Alat</th>
                        <th class="px-6 py-3">Detail Alat</th>
                        <th class="px-6 py-3">Stok Tersedia</th>
                        <th class="px-6 py-3">Status</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($alatmisa as $alat)
                        <tr class="border-b">
                            <td class="px-6 py-4">
                                <img src="{{ asset('storage/' . $alat->gambar) }}" alt="{{ $alat->nama_alat }}"
                                    class="w-12 h-12 object-cover rounded">
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-800">{{ $alat->nama_alat }}</td>
                            <td class="px-6 py-4 text-sm text-gray-800">{{ $alat->jenis_alat }}</td>
                            <td class="px-6 py-4 text-sm">
                                @if ($alat->detail_alat && count($alat->detail_alat))
                                    <ul class="list-disc list-inside text-gray-700">
                                        @foreach ($alat->detail_alat as $detail)
                                            <li>{{ $detail['nama_detail'] }} - Jumlah: {{ $detail['jumlah'] }}</li>
                                        @endforeach
                                    </ul>
                                @else
                                    <span class="text-gray-500">Tidak ada detail</span>
                                @endif
                            </td>

                            <td class="px-6 py-4 text-sm text-gray-800">{{ $alat->stok_tersedia }}</td>
                            <td class="px-6 py-4 text-sm">
                                @if ($alat->stok_tersedia > 0)
                                    <span class="bg-green-500 text-white px-2 py-1 rounded-full text-xs">Tersedia</span>
                                @else
                                    <span class="bg-red-500 text-white px-2 py-1 rounded-full text-xs">Habis</span>
                                @endif
                            </td>
                            <!-- Detail Alat -->

                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <!-- Scripts -->
    <script>
        // Search Function
        function searchAssets() {
            const input = document.getElementById("search").value.toLowerCase();
            const rows = document.querySelectorAll("table tbody tr");

            rows.forEach(row => {
                const namaAlat = row.cells[1].textContent.toLowerCase();
                if (namaAlat.includes(input)) {
                    row.style.display = "";
                } else {
                    row.style.display = "none";
                }
            });
        }

        // Sort Function
        function sortAssets() {
            const table = document.querySelector("table tbody");
            const rows = Array.from(table.rows);
            const sortBy = document.getElementById("sort").value;

            rows.sort((a, b) => {
                const valA = a.cells[sortBy === "nama_alat" ? 1 : 4].textContent.trim().toLowerCase();
                const valB = b.cells[sortBy === "nama_alat" ? 1 : 4].textContent.trim().toLowerCase();

                return isNaN(valA) ? valA.localeCompare(valB) : valA - valB;
            });

            // Append rows in sorted order
            table.innerHTML = "";
            rows.forEach(row => table.appendChild(row));
        }
    </script>
@endsection
