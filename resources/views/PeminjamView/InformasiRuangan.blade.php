@extends('layout.TemplatePeminjam')

@section('title', 'Informasi Ruangan')

@section('content')
<script src="https://cdn.tailwindcss.com"></script>
<section class="w-full h-full max-h-screen flex justify-center items-center">
    <div class="container px-4 md:max-w-4xl w-full border rounded-lg"> <!-- Border tambahan pada container -->
        <div class="bg-cover bg-white bg-center w-full">
            <div id="main-content" class="main-content">

                <div class="flex justify-center items-center mb-10">
                    <div class="border-4 border-gray-800 rounded-full py-4 px-8 inline-block text-center">
                        <h1 id="room-title" class="text-3xl md:text-6xl font-semibold text-gray-700">Informasi Ruangan</h1>
                    </div>
                </div>
                <div class="container mx-auto p-6  bg-gray-300">
                    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-6">
                        <div class="flex space-x-0 sm:space-x-4 mb-4 sm:mb-0 w-full sm:w-auto">
                            <!-- Dropdown untuk Filter Status -->
                            <select id="statusFilter" class="bg-white border border-gray-300 rounded-md w-full sm:w-72 mb-4 sm:mb-0">
                                <option value="">Semua Status</option>
                                <option value="booking">Booking</option>
                                <option value="dipinjam">Dipinjam</option>
                            </select>

                            <!-- Search Bar -->
                            <input type="text" id="search" placeholder="Cari Data"
                                class="border border-gray-300 rounded-md p-2 w-full sm:w-72 mt-2 sm:mt-0 mb-4 sm:mb-0">

                            <!-- Cari Button -->
                            <button onclick="filterData()" class="bg-cyan-600 text-white rounded-md p-2 sm:w-auto mt-1 sm:mt-0">
                                Cari
                            </button>
                        </div>
                    </div>

                    <!-- Tabel Daftar Peminjaman -->
                    <div class="overflow-x-auto">
                        <table class="min-w-full bg-white border border-gray-300 rounded-lg">
                            <thead>
                                <tr class="bg-gray-200">
                                    <th class="py-3 px-4 text-left text-gray-600">No.</th>
                                    <th class="py-3 px-4 text-left text-gray-600">Nama Ruangan</th>
                                    <th class="py-3 px-4 text-left text-gray-600">Penanggung Jawab</th>
                                    <th class="py-3 px-4 text-left text-gray-600">Status</th>
                                    <th class="py-3 px-4 text-left text-gray-600">Tanggal Mulai</th>
                                    <th class="py-3 px-4 text-left text-gray-600">Tanggal Selesai</th>
                                    <th class="py-3 px-4 text-left text-gray-600">Jam Mulai</th>
                                    <th class="py-3 px-4 text-left text-gray-600">Jam Selesai</th>
                                </tr>
                            </thead>
                            <tbody id="roomTableBody">
                                <!-- Baris akan muncul di sini -->
                                <tr>
                                    <td class="py-3 px-4">1</td>
                                    <td class="py-3 px-4">Ruangan A</td>
                                    <td class="py-3 px-4">John Doe</td>
                                    <td class="py-3 px-4 text-red-700">Dipinjam</td>
                                    <td class="py-3 px-4">2024-11-13</td>
                                    <td class="py-3 px-4">2024-11-13</td>
                                    <td class="py-3 px-4">09:00</td>
                                    <td class="py-3 px-4">10:00</td>
                                </tr>
                                <tr>
                                    <td class="py-3 px-4">2</td>
                                    <td class="py-3 px-4">Ruangan B</td>
                                    <td class="py-3 px-4">Jane Smith</td>
                                    <td class="py-3 px-4 text-yellow-600">Booking</td>
                                    <td class="py-3 px-4">2024-11-13</td>
                                    <td class="py-3 px-4">2024-11-13</td>
                                    <td class="py-3 px-4">14:00</td>
                                    <td class="py-3 px-4">16:00</td>
                                </tr>
                                <tr>
                                    <td class="py-3 px-4">3</td>
                                    <td class="py-3 px-4">Ruangan C</td>
                                    <td class="py-3 px-4">Alice Johnson</td>
                                    <td class="py-3 px-4 text-red-700">Dipinjam</td>
                                    <td class="py-3 px-4">2024-11-12</td>
                                    <td class="py-3 px-4">2024-11-12</td>
                                    <td class="py-3 px-4">10:00</td>
                                    <td class="py-3 px-4">12:00</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <!-- Buttons -->
                    <div class="p-6 border-t border-gray-200 rounded-b flex justify-between">
                        <a href="{{ route('pinjam.ViewRuangan') }}">
                            <button class="text-white bg-cyan-600 hover:bg-cyan-700 focus:ring-4 focus:ring-cyan-200 font-medium rounded-lg text-sm px-5 py-2.5 text-center" type="submit">Kembali</button>
                        </a>
                    </div>
                </div>

            </div>
        </div>
    </div>
</section>
@endsection

@section('scripts')
<script>
    // Fungsi untuk melakukan pencarian dan filter status
    const searchInput = document.getElementById('search');
    const statusFilter = document.getElementById('statusFilter');
    const roomTableBody = document.getElementById('roomTableBody');

    const roomsData = [
        { id: 1, name: 'Ruangan A', user: 'John Doe', status: 'Sedang Dipinjam', start: '2024-11-13 09:00', end: '2024-11-13 10:00' },
        { id: 2, name: 'Ruangan B', user: 'Jane Smith', status: 'Sedang Booking', start: '2024-11-13 14:00', end: '2024-11-13 16:00' },
        { id: 3, name: 'Ruangan C', user: 'Alice Johnson', status: 'Sedang Dipinjam', start: '2024-11-12 10:00', end: '2024-11-12 12:00' }
    ];

    // Fungsi untuk menampilkan data pada tabel
    function renderTable(filteredRooms) {
        roomTableBody.innerHTML = '';
        filteredRooms.forEach((room, index) => {
            let statusClass = '';
            if (room.status === 'Sedang Dipinjam') {
                statusClass = 'text-white bg-red-500'; // Merah untuk sedang dipinjam
            } else if (room.status === 'Sedang Booking') {
                statusClass = 'text-white bg-yellow-500'; // Kuning untuk sedang booking
            }

            const row = `
                <tr>
                    <td class="py-3 px-4">${index + 1}</td>
                    <td class="py-3 px-4">${room.name}</td>
                    <td class="py-3 px-4">${room.user}</td>
                    <td class="py-3 px-4 ${statusClass}">${room.status}</td>
                    <td class="py-3 px-4">${room.start}</td>
                    <td class="py-3 px-4">${room.end}</td>
                    <td class="py-3 px-4">${room.start.slice(11, 16)}</td>
                    <td class="py-3 px-4">${room.end.slice(11, 16)}</td>
                </tr>
            `;
            roomTableBody.innerHTML += row;
        });
    }

    // Fungsi untuk memfilter dan mencari data
    function filterData() {
        const searchText = searchInput.value.toLowerCase();
        const status = statusFilter.value;

        const filteredRooms = roomsData.filter(room => {
            const matchesSearch = room.name.toLowerCase().includes(searchText) ||
                room.user.toLowerCase().includes(searchText);
            const matchesStatus = status ? room.status.toLowerCase() === status.toLowerCase() : true;
            return matchesSearch && matchesStatus;
        });

        renderTable(filteredRooms);
    }

    // Event listeners untuk search dan filter
    searchInput.addEventListener('input', filterData);
    statusFilter.addEventListener('change', filterData);

    // Tampilkan data awal
    renderTable(roomsData);
</script>
@endsection
