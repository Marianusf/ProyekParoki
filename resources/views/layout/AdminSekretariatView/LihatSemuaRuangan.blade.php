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
                <div class="w-full md:w-1/2">
                    <select id="filterCondition"
                        class="border border-gray-300 rounded-lg p-3 w-full focus:ring-2 focus:ring-blue-500">
                        <option value="">Semua Kondisi</option>
                        <option value="baik">Baik</option>
                        <option value="dalam_perbaikan">Dalam Perbaikan</option>
                    </select>
                </div>
            </div>
            <button onclick="window.location.reload();"
                class="bg-transparent text-blue-500 hover:text-blue-700 p-2 rounded-full transition duration-200 ease-in-out"
                title="Refresh halaman">
                <i class="fas fa-sync-alt text-xl"></i> <!-- Ikon refresh -->
            </button>
            <!-- Room Table -->
            <div class="overflow-x-auto overflow-y-auto max-h-[500px] bg-white shadow-md rounded-lg">
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
                                <th class="py-3 px-6 text-left">Tanggal Ditambahkan</th>
                                <th class="py-3 px-6 text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="text-gray-800 text-sm">
                            @foreach ($ruangan as $room)
                                <tr class="border-b hover:bg-gray-100 transition duration-300"
                                    data-condition="{{ strtolower(str_replace(' ', '_', $room->kondisi)) }}">
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
                                    <td class="py-3 px-6">{{ ucfirst(str_replace('_', ' ', $room->kondisi)) }}</td>
                                    <td class="py-3 px-6">{{ Str::limit($room->deskripsi, 70) }}</td>
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
                                    <td class="py-3 px-6">{{ $room->created_at->format('d-m-Y') }}</td>
                                    <td class="py-3 px-6 text-center flex justify-center space-x-2">
                                        <a href="{{ route('ruangan.edit', $room->id) }}"
                                            class="text-yellow-500 hover:text-yellow-700 transition duration-300 btn-edit"
                                            title="Edit Ruangan">
                                            <i class="fas fa-pencil-alt"></i>
                                        </a>
                                        <button type="button" onclick="deleteRoom({{ $room->id }})"
                                            class="text-red-500 hover:text-red-700 transition duration-300 btn-delete"
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
            const filterCondition = document.getElementById('filterCondition');
            const tableRows = document.querySelectorAll('#roomTable tbody tr');

            const filterTable = () => {
                const searchText = searchInput.value.toLowerCase();
                const conditionFilter = filterCondition.value.toLowerCase();

                tableRows.forEach(row => {
                    const name = row.querySelectorAll('td')[1]?.textContent.toLowerCase() || '';
                    const condition = row.dataset.condition || '';
                    let isMatch = true;

                    // Filter berdasarkan pencarian teks
                    if (searchText && !name.includes(searchText)) isMatch = false;

                    // Filter berdasarkan kondisi
                    if (conditionFilter && conditionFilter !== '' && condition !== conditionFilter) {
                        isMatch = false;
                    }

                    row.style.display = isMatch ? '' : 'none';
                });
            };

            searchInput.addEventListener('input', filterTable);
            filterCondition.addEventListener('change', filterTable);

            // SweetAlert untuk tombol
            document.querySelectorAll('.btn-delete').forEach(btn => {
                btn.addEventListener('click', function(e) {
                    e.preventDefault();
                    Swal.fire({
                        title: 'Anda yakin?',
                        text: "Data ruangan ini akan dihapus secara permanen!",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Ya, hapus!',
                        cancelButtonText: 'Batal'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            Swal.fire(
                                'Dihapus!',
                                'Ruangan berhasil dihapus.',
                                'success'
                            );
                        }
                    });
                });
            });

            document.querySelectorAll('.btn-edit').forEach(btn => {
                btn.addEventListener('click', function() {
                    Swal.fire({
                        icon: 'info',
                        title: 'Edit Ruangan',
                        text: 'Mengedit ruangan ini.',
                        showConfirmButton: false,
                        timer: 1500
                    });
                });
            });
        });
    </script>
@endsection
