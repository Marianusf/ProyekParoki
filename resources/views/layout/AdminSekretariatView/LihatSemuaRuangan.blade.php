@extends('layout.TemplateAdminSekretariat')

@section('title', 'Daftar Ruangan')

@section('content')
    <section class="p-6 bg-gray-100 min-h-screen">
        <div class="container mx-auto">
            <!-- Header Section -->
            <div class="flex justify-between items-center mb-6">
                <h2 class="text-3xl font-bold text-gray-800">Daftar Ruangan</h2>
                <a href="{{ route('ruangan.create') }}"
                    class="bg-blue-600 text-white px-6 py-2 rounded-md hover:bg-blue-700 transition duration-300">
                    Tambah Ruangan Baru
                </a>
            </div>

            <!-- Searching and Filtering -->
            <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-6">
                <!-- Searching -->
                <div class="relative w-full md:w-1/2">
                    <input type="text" id="search"
                        class="border border-gray-300 rounded-lg p-3 w-full pl-12 focus:ring-2 focus:ring-blue-500"
                        placeholder="Cari ruangan...">
                    <span class="absolute left-4 top-3 text-gray-400">
                        <i class="fas fa-search text-lg"></i>
                    </span>
                </div>
                <!-- Filtering -->
                <div class="flex gap-4 w-full md:w-1/2">
                    <select id="filterStatus"
                        class="border border-gray-300 rounded-lg p-3 w-full focus:ring-2 focus:ring-blue-500">
                        <option value="">Semua Status</option>
                        <option value="tersedia">Tersedia</option>
                        <option value="dipinjam">Sedang Dipinjam</option>
                        <option value="tidak_bisa_dipinjam">Tidak Bisa Dipinjam</option>
                    </select>
                    <select id="filterCondition"
                        class="border border-gray-300 rounded-lg p-3 w-full focus:ring-2 focus:ring-blue-500">
                        <option value="">Semua Kondisi</option>
                        <option value="baik">Baik</option>
                        <option value="dalam_perbaikan">Dalam Perbaikan</option>
                    </select>
                </div>
            </div>

            <!-- Room Table -->
            <div class="bg-white shadow-md rounded-lg overflow-x-auto">
                @if ($ruangan->count() > 0)
                    <table class="min-w-full table-auto" id="roomTable">
                        <thead class="bg-blue-600 text-white uppercase text-sm">
                            <tr>
                                <th class="py-3 px-6 text-left">Gambar</th>
                                <th class="py-3 px-6 text-left">Nama Ruangan</th>
                                <th class="py-3 px-6 text-left">Kapasitas</th>
                                <th class="py-3 px-6 text-left">Kondisi</th>
                                <th class="py-3 px-6 text-left">Deskripsi</th>
                                <th class="py-3 px-6 text-left">Fasilitas</th>
                                <th class="py-3 px-6 text-center">Status</th>
                                <th class="py-3 px-6 text-left">Tanggal Ditambahkan</th>
                                <th class="py-3 px-6 text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="text-gray-800 text-sm">
                            @foreach ($ruangan as $room)
                                <tr class="border-b hover:bg-gray-100 transition duration-300">
                                    <td class="py-3 px-6">
                                        @if ($room->gambar)
                                            <img src="{{ asset('storage/' . $room->gambar) }}"
                                                alt="Gambar {{ $room->nama }}"
                                                class="w-20 h-20 object-cover rounded-lg shadow">
                                        @else
                                            <span class="text-gray-500">Tidak ada gambar</span>
                                        @endif
                                    </td>
                                    <td class="py-3 px-6">{{ $room->nama }}</td>
                                    <td class="py-3 px-6">{{ $room->kapasitas }}</td>
                                    <td class="py-3 px-6">
                                        @if ($room->kondisi === 'dalam_perbaikan')
                                            <span class="text-yellow-500">Dalam Perbaikan</span>
                                        @elseif ($room->kondisi === 'baik')
                                            <span class="text-green-500">Baik</span>
                                        @else
                                            <span class="text-gray-500">Tidak diketahui</span>
                                        @endif
                                    </td>
                                    <td class="py-3 px-6">{{ Str::limit($room->deskripsi, 50) }}</td>
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
                                    <td class="py-3 px-6 text-center">
                                        <span
                                            class="px-3 py-1 rounded-full text-white text-xs
                                            {{ $room->status === 'tersedia'
                                                ? 'bg-green-500'
                                                : ($room->status === 'dipinjam'
                                                    ? 'bg-yellow-500'
                                                    : ($room->status === 'tidak_bisa_dipinjam'
                                                        ? 'bg-red-500'
                                                        : 'bg-gray-500')) }}">
                                            {{ ucfirst(str_replace('_', ' ', $room->status)) }}
                                        </span>
                                    </td>
                                    <td class="py-3 px-6">{{ $room->created_at->format('d-m-Y') }}</td>
                                    <td class="py-3 px-6 text-center flex justify-center space-x-2">
                                        <a href="{{ route('ruangan.edit', $room->id) }}"
                                            class="text-yellow-500 hover:text-yellow-700 transition duration-300"
                                            title="Edit Ruangan">
                                            <i class="fas fa-pencil-alt"></i>
                                        </a>
                                        <button type="button" onclick="deleteRoom({{ $room->id }})"
                                            class="text-red-500 hover:text-red-700 transition duration-300"
                                            title="Hapus Ruangan">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @else
                    <div class="p-6 text-center">
                        <h3 class="text-gray-600 text-lg">Belum ada ruangan yang tersedia.</h3>
                    </div>
                @endif
            </div>
        </div>
    </section>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const searchInput = document.getElementById('search');
            const filterStatus = document.getElementById('filterStatus');
            const filterCondition = document.getElementById('filterCondition');
            const tableRows = document.querySelectorAll('#roomTable tbody tr');

            const filterTable = () => {
                const searchText = searchInput.value.toLowerCase();
                const statusFilter = filterStatus.value.toLowerCase();
                const conditionFilter = filterCondition.value.toLowerCase();

                tableRows.forEach(row => {
                    const cells = row.querySelectorAll('td');
                    const name = cells[1]?.textContent.toLowerCase() || '';
                    const status = cells[6]?.textContent.toLowerCase().trim() ||
                    ''; // Pastikan status juga lowercase
                    const condition = cells[3]?.textContent.toLowerCase().trim() ||
                    ''; // Pastikan kondisi juga lowercase
                    let isMatch = true;

                    // Filter berdasarkan pencarian teks
                    if (searchText && !name.includes(searchText)) isMatch = false;

                    // Filter berdasarkan status
                    if (statusFilter && statusFilter !== '' && !status.includes(statusFilter)) isMatch =
                        false;

                    // Filter berdasarkan kondisi
                    if (conditionFilter && conditionFilter !== '' && !condition.includes(
                            conditionFilter)) isMatch = false;

                    row.style.display = isMatch ? '' : 'none';
                });
            };

            searchInput.addEventListener('input', filterTable);
            filterStatus.addEventListener('change', filterTable);
            filterCondition.addEventListener('change', filterTable);
        });
    </script>
@endsection
