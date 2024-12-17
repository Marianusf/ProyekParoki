@extends('layout.TemplatePeminjam')

@section('title', 'KetersediaanAsset')

@section('content')
    <div class="container mx-auto py-8">
        <h2 class="text-2xl font-semibold mb-6">Daftar Ketersediaan Asset</h2>

        <!-- SweetAlert2 Session Alerts -->
        @if (session('success'))
            <script>
                Swal.fire({
                    title: 'Berhasil!',
                    text: "{{ session('success') }}",
                    icon: 'success',
                    confirmButtonText: 'OK'
                });
            </script>
        @endif

        @if (session('error'))
            <script>
                Swal.fire({
                    title: 'Error!',
                    text: "{{ session('error') }}",
                    icon: 'error',
                    confirmButtonText: 'OK'
                });
            </script>
        @endif

        @if (session('message'))
            <script>
                Swal.fire({
                    title: 'Informasi',
                    text: "{{ session('message') }}",
                    icon: 'info',
                    confirmButtonText: 'OK'
                });
            </script>
        @endif


        <!-- Search Bar and Sorting Options -->
        <div class="mb-4 flex justify-between items-center">
            <!-- Search Input -->
            <div class="flex items-center">
                <label for="search" class="mr-2">Cari Barang:</label>
                <input type="text" id="search" name="search" class="p-2 border rounded"
                    placeholder="Cari berdasarkan nama barang..." onkeyup="searchAssets()" />
            </div>

            <!-- Sorting Options -->
            <div class="flex items-center">
                <label for="sort" class="mr-2">Sortir Berdasarkan:</label>
                <select id="sort" name="sort" class="p-2 border rounded" onchange="sortAssets()">
                    <option value="nama_barang">Nama Barang</option>
                    <option value="jumlah_tersedia">Jumlah Tersedia</option>
                </select>
            </div>
        </div>

        <!-- Tabel Ketersediaan Asset -->
        <div class="overflow-x-auto overflow-y-auto max-h-[500px] bg-white shadow-md rounded-lg">
            <table class="min-w-full table-auto">
                <thead>
                    <tr class="bg-gray-100 text-left text-sm text-gray-600">
                        <th class="px-6 py-3">Nama Barang</th>
                        <th class="px-6 py-3">Gambar</th>
                        <th class="px-6 py-3">Jenis Barang</th>
                        <th class="px-6 py-3">Jumlah Tersedia</th>
                        <th class="px-6 py-3">Status</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($assets as $asset)
                        <tr class="border-b">
                            <td class="px-6 py-4 text-sm text-gray-800">{{ $asset->nama_barang }}</td>
                            <td class="px-6 py-4 text-sm text-gray-800">
                                <img src="{{ asset('storage/' . $asset->gambar) }}" alt="{{ $asset->nama_barang }}"
                                    class="w-12 h-12 object-cover rounded">
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-800">{{ $asset->jenis_barang }}</td>
                            <td class="px-6 py-4 text-sm text-gray-800">{{ $asset->stok_tersedia }}</td>
                            <td class="px-6 py-4 text-sm">
                                @if ($asset->stok_tersedia > 0)
                                    <span class="bg-green-500 text-white px-2 py-1 rounded-full text-xs">Tersedia</span>
                                @else
                                    <span class="bg-red-500 text-white px-2 py-1 rounded-full text-xs">Habis</span>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>


        <!-- Scripts for Searching and Sorting -->
        <script>
            function searchAssets() {
                var input, filter, table, tr, td, i, txtValue;
                input = document.getElementById("search");
                filter = input.value.toLowerCase();
                table = document.querySelector("table");
                tr = table.getElementsByTagName("tr");

                for (i = 1; i < tr.length; i++) {
                    td = tr[i].getElementsByTagName("td");
                    if (td.length > 0) {
                        txtValue = td[0].textContent || td[0].innerText;
                        if (txtValue.toLowerCase().indexOf(filter) > -1) {
                            tr[i].style.display = "";
                        } else {
                            tr[i].style.display = "none";
                        }
                    }
                }
            }

            function sortAssets() {
                var table, rows, switching, i, x, y, shouldSwitch, dir, switchcount = 0;
                table = document.querySelector("table");
                switching = true;
                dir = "asc"; // Set the sorting direction to ascending

                while (switching) {
                    switching = false;
                    rows = table.rows;

                    for (i = 1; i < (rows.length - 1); i++) {
                        shouldSwitch = false;
                        x = rows[i].getElementsByTagName("TD")[document.getElementById("sort").selectedIndex];
                        y = rows[i + 1].getElementsByTagName("TD")[document.getElementById("sort").selectedIndex];

                        if (dir == "asc") {
                            if (x.innerHTML.toLowerCase() > y.innerHTML.toLowerCase()) {
                                shouldSwitch = true;
                                break;
                            }
                        } else if (dir == "desc") {
                            if (x.innerHTML.toLowerCase() < y.innerHTML.toLowerCase()) {
                                shouldSwitch = true;
                                break;
                            }
                        }
                    }

                    if (shouldSwitch) {
                        rows[i].parentNode.insertBefore(rows[i + 1], rows[i]);
                        switching = true;
                        switchcount++;
                    } else {
                        if (switchcount === 0 && dir === "asc") {
                            dir = "desc";
                            switching = true;
                        }
                    }
                }
            }
        </script>
    @endsection
