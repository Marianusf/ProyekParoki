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

            <!-- Searching -->
            <div class="relative mb-6">
                <input type="text" id="search"
                    class="border border-gray-300 rounded-lg p-3 w-full pl-12 focus:ring-2 focus:ring-blue-500"
                    placeholder="Cari ruangan...">
                <span class="absolute left-4 top-3 text-gray-400">
                    <i class="fas fa-search text-lg"></i> <!-- FontAwesome Icon -->
                </span>
            </div>

            <!-- Room Table -->
            <div class="bg-white shadow-lg rounded-lg overflow-auto">
                @if ($room->count() > 0)
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
                            @foreach ($room as $room)
                                <tr class="border-b hover:bg-gray-100 transition duration-300">
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
                                    <td class="py-3 px-6 highlight-cell" data-highlight="true">{{ $room->nama }}</td>

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
                                        <span
                                            class="px-3 py-1 rounded-full text-white text-xs 
                                        {{ $room->status == 'tersedia' ? 'bg-green-500' : 'bg-red-500' }}">
                                            {{ ucfirst($room->status) }}
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
                        <p class="text-gray-500">Anda dapat menambahkan ruangan baru dengan tombol di atas.</p>
                    </div>
                @endif
            </div>
        </div>
    </section>
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const searchInput = document.getElementById('search');
            const tableRows = document.querySelectorAll('#roomTable tbody tr');

            const filterTable = () => {
                const searchText = searchInput.value.toLowerCase();

                tableRows.forEach(row => {
                    const cells = row.querySelectorAll('td');
                    let isMatch = false;

                    cells.forEach(cell => {
                        // Abaikan cell yang memiliki elemen HTML lain (seperti gambar)
                        if (cell.querySelector('img') || cell.querySelector('ol')) {
                            return;
                        }

                        const originalContent = cell.getAttribute('data-original-content') ||
                            cell.textContent.trim();
                        cell.setAttribute('data-original-content',
                        originalContent); // Simpan teks asli

                        if (originalContent.toLowerCase().includes(searchText) && searchText) {
                            isMatch = true;
                            const regex = new RegExp(`(${searchText})`, 'gi');
                            cell.innerHTML = originalContent.replace(regex,
                                `<span class="bg-yellow-200">$1</span>`);
                        } else {
                            cell.innerHTML = originalContent; // Kembalikan teks asli
                        }
                    });

                    row.style.display = isMatch || searchText === '' ? '' : 'none';
                });
            };

            searchInput.addEventListener('input', filterTable);
        });
    </script>


@endsection
