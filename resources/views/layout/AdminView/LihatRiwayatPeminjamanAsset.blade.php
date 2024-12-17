@extends('layout.TemplateAdmin')

@section('title', 'Riwayat Peminjaman, Pengembalian dan Selesai')

@section('content')
    <div class="container mx-auto py-8">
        <h1 class="text-3xl font-semibold mb-6 flex items-center">
            <i class="fas fa-history mr-2"></i> RIWAYAT PEMINJAMAN ASSET DAN BARANG
        </h1>

        <!-- Tabs Navigation -->
        <div class="flex mb-4">
            <button class="tab-btn bg-blue-500 text-white px-6 py-2 rounded-l-lg flex items-center"
                data-target="peminjamanContent">
                <i class="fas fa-book mr-2"></i> Peminjaman
            </button>
            <button class="tab-btn bg-blue-500 text-white px-6 py-2 flex items-center" data-target="pengembalianContent">
                <i class="fas fa-undo mr-2"></i> Pengembalian
            </button>
            <button class="tab-btn bg-blue-500 text-white px-6 py-2 rounded-r-lg flex items-center"
                data-target="selesaiContent">
                <i class="fas fa-check-circle mr-2"></i> Selesai
            </button>
        </div>

        <!-- Search Input -->
        <div class="mb-4">
            <input type="text" id="searchInput" placeholder="Cari data..." class="p-2 border rounded w-full">
        </div>

        <!-- Tab Content: Peminjaman -->
        <div id="peminjamanContent" class="tab-content">
            <div class="overflow-x-auto max-h-[400px] border rounded-lg">
                <table class="w-full text-left">
                    <thead class="bg-gray-200">
                        <tr>
                            <th class="px-4 py-2 cursor-pointer" onclick="sortTable(0)">Nama Barang <span>&#8597;</span>
                            </th>
                            <th class="px-4 py-2 cursor-pointer" onclick="sortTable(1)">Jumlah <span>&#8597;</span></th>
                            <th class="px-4 py-2 cursor-pointer" onclick="sortTable(2)">Peminjam <span>&#8597;</span></th>
                            <th class="px-4 py-2 cursor-pointer" onclick="sortTable(3)">Rencana Peminjaman
                                <span>&#8597;</span>
                            </th>
                            <th class="px-4 py-2 cursor-pointer" onclick="sortTable(4)">Rencana Pengembalian
                                <span>&#8597;</span>
                            </th>
                            <th class="px-4 py-2 cursor-pointer" onclick="sortTable(5)">Tanggal Pengajuan Peminjaman
                                <span>&#8597;</span>
                            </th>
                            <th class="px-4 py-2">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($peminjaman as $item)
                            <tr class="hover:bg-gray-100">
                                <td class="px-4 py-2">{{ $item->asset->nama_barang }}</td>
                                <td class="px-4 py-2">{{ $item->jumlah }}</td>
                                <td class="px-4 py-2">{{ $item->peminjam->name }}</td>
                                <td class="px-4 py-2 ">
                                    {{ \Carbon\Carbon::parse($item->tanggal_peminjaman)->format('d F Y   ') }}
                                </td>
                                <td class="px-4 py-2 ">
                                    {{ \Carbon\Carbon::parse($item->tanggal_pengembalian)->format('d F Y') }}
                                </td>
                                <td class="px-4 py-2 ">
                                    {{ \Carbon\Carbon::parse($item->created_at)->format('H:i d F Y   ') }}
                                </td>
                                <td class="px-4 py-2">
                                    @if ($item->status_peminjaman == 'disetujui')
                                        <i class="fas fa-check-circle text-green-500"></i> Disetujui
                                    @elseif ($item->status_peminjaman == 'pending')
                                        <i class="fas fa-hourglass-half text-yellow-500"></i> Pending
                                    @else
                                        <i class="fas fa-times-circle text-red-500"></i> Ditolak
                                        @if (!empty($item->alasan_penolakan))
                                            <div class="text-sm text-gray-700 mt-1">
                                                <strong>Alasan: </strong>{{ $item->alasan_penolakan }}
                                            </div>
                                        @endif
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Tab Content: Pengembalian -->
        <div id="pengembalianContent" class="tab-content hidden">
            <div class="overflow-x-auto max-h-[400px] border rounded-lg">
                <table class="w-full text-left">
                    <thead class="bg-gray-200">
                        <tr>
                            <th class="px-4 py-2 cursor-pointer" onclick="sortTable(0)">Nama Barang <span>&#8597;</span>
                            </th>
                            <th class="px-4 py-2 cursor-pointer" onclick="sortTable(1)">Jumlah <span>&#8597;</span></th>
                            <th class="px-4 py-2 cursor-pointer" onclick="sortTable(2)">Nama Peminjam <span>&#8597;</span>
                            </th>
                            <th class="px-4 py-2 cursor-pointer" onclick="sortTable(3)">Tanggal Pengajuan Pengembalian
                                <span>&#8597;</span>
                            </th>
                            <th class="px-4 py-2">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($pengembalian as $item)
                            <tr class="hover:bg-gray-100">
                                <td class="px-4 py-2">{{ $item->peminjaman->asset->nama_barang }}</td>
                                <td class="px-4 py-2">{{ $item->peminjaman->jumlah }}</td>
                                <td class="px-4 py-2">{{ $item->peminjaman->peminjam->name }}</td>
                                <td class="px-4 py-2 ">
                                    {{ \Carbon\Carbon::parse($item->created_at)->format('H:i d F Y   ') }}
                                </td>
                                <td class="px-4 py-2">
                                    @if ($item->status == 'approved')
                                        <i class="fas fa-check-circle text-green-500"></i> Disetujui
                                    @elseif ($item->status == 'pending')
                                        <i class="fas fa-hourglass-half text-yellow-500"></i> Pending
                                    @else
                                        <i class="fas fa-times-circle text-red-500"></i> Ditolak
                                        @if (!empty($item->alasan_penolakan))
                                            <div class="text-sm text-gray-700 mt-1">
                                                <strong>Alasan: </strong>{{ $item->alasan_penolakan }}
                                            </div>
                                        @endif
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Tab Content: Selesai -->
        <div id="selesaiContent" class="tab-content hidden">
            <div class="overflow-x-auto max-h-[400px] border rounded-lg">
                <table class="w-full text-left">
                    <thead class="bg-gray-200">
                        <tr>
                            <th class="px-4 py-2 cursor-pointer" onclick="sortTable(0)">Nama Barang <span>&#8597;</span>
                            </th>
                            <th class="px-4 py-2 cursor-pointer" onclick="sortTable(1)">Jumlah <span>&#8597;</span></th>
                            <th class="px-4 py-2 cursor-pointer" onclick="sortTable(2)">Nama Peminjam <span>&#8597;</span>
                            </th>
                            <th class="px-4 py-2 cursor-pointer" onclick="sortTable(3)">Tanggal Peminjaman
                            </th>
                            <th class="px-4 py-2 cursor-pointer" onclick="sortTable(4)">Tanggal Pengembalian
                            </th>
                            <th class="px-4 py-2 cursor-pointer" onclick="sortTable(5)">Tanggal Pengajuan Pengembalian
                                <span>&#8597;</span>
                            </th>
                            <th class="px-4 py-2 cursor-pointer" onclick="sortTable(6)">Tanggal Selesai <span>&#8597;</span>
                            </th>
                            <th class="px-4 py-2">Status</th>
                        </tr>

                    </thead>
                    <tbody>
                        @foreach ($selesai as $item)
                            @php
                                // Ambil tanggal pengajuan (created_at) dan tanggal target pengembalian
                                $tanggal_pengembalian = \Carbon\Carbon::parse($item->peminjaman->tanggal_pengembalian);
                                $tanggal_diajukan = \Carbon\Carbon::parse($item->created_at);

                                // Hitung selisih dalam hari dan jam
                                $selisih_hari = $tanggal_diajukan->diffInDays($tanggal_pengembalian, false);
                                $selisih_jam = $tanggal_diajukan->diffInHours($tanggal_pengembalian, false);

                                // Bulatkan ke bawah agar angka tidak memiliki desimal
                                $selisih_hari = abs((int) $selisih_hari);
                                $selisih_jam = abs((int) $selisih_jam);

                                // Tentukan status
                                if ($tanggal_diajukan < $tanggal_pengembalian) {
                                    $status = 'Lebih Awal';
                                    $warna = 'text-blue-500';
                                    $detail = "$selisih_hari hari lebih awal";
                                } elseif ($tanggal_diajukan > $tanggal_pengembalian) {
                                    $status = 'Telat';
                                    $warna = 'text-red-500';
                                    $detail = "$selisih_hari hari telat";
                                } else {
                                    $status = 'Tepat Waktu';
                                    $warna = 'text-green-500';
                                    $detail = 'Tepat waktu';
                                }
                            @endphp
                            <tr class="hover:bg-gray-100">
                                <td class="px-4 py-2">{{ $item->peminjaman->asset->nama_barang }}</td>
                                <td class="px-4 py-2">{{ $item->peminjaman->jumlah }}</td>
                                <td class="px-4 py-2">{{ $item->peminjaman->peminjam->name }}</td>
                                <td class="px-4 py-2">
                                    {{ \Carbon\Carbon::parse($item->peminjaman->tanggal_peminjaman)->format('d F Y') }}
                                </td>
                                <td class="px-4 py-2">
                                    {{ \Carbon\Carbon::parse($item->peminjaman->tanggal_pengembalian)->format('d F Y') }}
                                </td>
                                <td class="px-4 py-2">
                                    {{ \Carbon\Carbon::parse($item->created_at)->format('d F Y H:i') }}
                                </td>
                                <td class="px-4 py-2">{{ $item->updated_at->format('d F Y H:i') }}</td>
                                <td class="px-4 py-2 {{ $warna }}">
                                    <strong>{{ $status }}</strong>
                                    <div class="text-sm text-gray-600">
                                        {{ $detail }} ({{ $selisih_jam }} jam)
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>

                </table>
            </div>
        </div>
    </div>

    <!-- JavaScript -->
    <script>
        // Tab Navigation
        document.addEventListener('DOMContentLoaded', () => {
            const tabs = document.querySelectorAll('.tab-btn');
            const contents = document.querySelectorAll('.tab-content');
            tabs.forEach(tab => {
                tab.addEventListener('click', () => {
                    contents.forEach(content => content.classList.add('hidden'));
                    document.getElementById(tab.dataset.target).classList.remove('hidden');
                    tabs.forEach(t => t.classList.remove('bg-blue-700'));
                    tab.classList.add('bg-blue-700');
                });
            });
        });

        // Sorting
        function sortTable(n) {
            const table = document.querySelector('.tab-content:not(.hidden) table');
            let rows, switching, i, x, y, shouldSwitch, dir = "asc",
                switchcount = 0;
            switching = true;

            while (switching) {
                switching = false;
                rows = table.rows;
                for (i = 1; i < rows.length - 1; i++) {
                    shouldSwitch = false;
                    x = rows[i].getElementsByTagName("TD")[n];
                    y = rows[i + 1].getElementsByTagName("TD")[n];
                    if ((dir == "asc" && x.innerHTML.toLowerCase() > y.innerHTML.toLowerCase()) ||
                        (dir == "desc" && x.innerHTML.toLowerCase() < y.innerHTML.toLowerCase())) {
                        shouldSwitch = true;
                        break;
                    }
                }
                if (shouldSwitch) {
                    rows[i].parentNode.insertBefore(rows[i + 1], rows[i]);
                    switching = true;
                    switchcount++;
                } else if (switchcount == 0 && dir == "asc") {
                    dir = "desc";
                    switching = true;
                }
            }
        }

        // Searching
        document.getElementById("searchInput").addEventListener("input", function() {
            const search = this.value.toLowerCase();
            const rows = document.querySelector('.tab-content:not(.hidden) tbody').rows;
            for (let row of rows) {
                row.style.display = row.innerText.toLowerCase().includes(search) ? "" : "none";
            }
        });
    </script>
@endsection
