<!-- resources/views/layout/AdminView/LihatPeminjamAktif.blade.php -->

@extends('layout.TemplateAdminParamenta')
@section('title', 'Peminjam Aktif')

@section('content')
    <div class="container mx-auto py-8">
        <h1 class="text-2xl font-bold mb-6">Daftar Peminjam Aktif</h1>

        <!-- Session Alerts -->
        @if (session('success'))
            <script>
                Swal.fire({
                    icon: 'success',
                    title: 'Sukses!',
                    text: '{{ session('success') }}',
                    confirmButtonText: 'OK'
                });
            </script>
        @endif

        @if (session('message'))
            <script>
                Swal.fire({
                    icon: 'info',
                    title: 'PESAN:',
                    text: '{{ session('message') }}',
                    confirmButtonText: 'OK'
                });
            </script>
        @endif

        @if (session('error'))
            <script>
                Swal.fire({
                    icon: 'error',
                    title: 'Error:',
                    text: '{{ session('error') }}',
                    confirmButtonText: 'OK'
                });
            </script>
        @endif

        <!-- Search Input -->
        <div class="mb-4 flex">
            <input type="text" id="searchInput" placeholder="Cari berdasarkan nama, email, atau alamat..."
                class="p-2 border rounded w-full" />
        </div>

        <!-- Table with Sorting and Searching -->
        <div class="overflow-x-auto max-h-[500px] bg-white shadow-md rounded-lg">
            <table class="w-full text-sm text-left text-gray-500">
                <thead class="text-xs text-gray-700 uppercase bg-gray-200 sticky top-0">
                    <tr>
                        <th class="px-6 py-3">Foto Profil</th>
                        <th class="px-6 py-3 cursor-pointer" onclick="sortTable(0)">
                            Nama <span id="icon-0" class="ml-1"></span>
                        </th>
                        <th class="px-6 py-3 cursor-pointer" onclick="sortTable(1)">
                            Email <span id="icon-1" class="ml-1"></span>
                        </th>
                        <th class="px-6 py-3 cursor-pointer" onclick="sortTable(2)">
                            Tanggal Lahir <span id="icon-2" class="ml-1"></span>
                        </th>
                        <th class="px-6 py-3 cursor-pointer" onclick="sortTable(3)">
                            Lingkungan <span id="icon-3" class="ml-1"></span>
                        </th>
                        <th class="px-6 py-3 cursor-pointer" onclick="sortTable(4)">
                            Alamat <span id="icon-4" class="ml-1"></span>
                        </th>
                        <th class="px-6 py-3 cursor-pointer" onclick="sortTable(5)">
                            Nomor Telepon <span id="icon-5" class="ml-1"></span>
                        </th>
                    </tr>
                </thead>
                <tbody id="tableBody">
                    @foreach ($peminjam as $item)
                        <tr class="bg-white border-b hover:bg-gray-100 cursor-pointer" data-name="{{ $item->name }}"
                            data-email="{{ $item->email }}" data-tanggal-lahir="{{ $item->tanggal_lahir }}"
                            data-lingkungan="{{ $item->lingkungan }}" data-alamat="{{ $item->alamat }}"
                            data-telepon="{{ $item->nomor_telepon }}"
                            data-foto="{{ $item->poto_profile ? Storage::url($item->poto_profile) : asset('images/default.jpg') }}"
                            onclick="showDetails(this)">
                            <!-- Foto Profil -->
                            <td class="px-6 py-4">
                                <img src="{{ $item->poto_profile ? Storage::url($item->poto_profile) : asset('images/default.jpg') }}"
                                    alt="Foto Profil" class="w-10 h-10 rounded-full object-cover">
                            </td>
                            <td class="px-6 py-4">{{ $item->name }}</td>
                            <td class="px-6 py-4">{{ $item->email }}</td>
                            <td class="px-6 py-4">{{ $item->tanggal_lahir }}</td>
                            <td class="px-6 py-4">{{ $item->lingkungan }}</td>
                            <td class="px-6 py-4">{{ $item->alamat }}</td>
                            <td class="px-6 py-4">{{ $item->nomor_telepon }}</td>
                        </tr>
                    @endforeach
                </tbody>

            </table>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <!-- JavaScript for Searching and Sorting -->
    <script>
        let currentSortCol = null;
        let sortDirection = "asc";

        // Searching Function
        document.getElementById('searchInput').addEventListener('input', function() {
            const searchQuery = this.value.toLowerCase();
            const rows = document.querySelectorAll('#tableBody tr');
            rows.forEach(row => {
                const rowText = row.innerText.toLowerCase();
                row.style.display = rowText.includes(searchQuery) ? '' : 'none';
            });
        });

        // Sorting Function
        function sortTable(columnIndex) {
            const table = document.querySelector('table');
            const rows = Array.from(table.querySelectorAll('tbody tr'));
            const icon = document.getElementById(`icon-${columnIndex}`);

            // Reset all icons
            document.querySelectorAll("thead span").forEach(i => i.innerHTML = "");

            // Toggle direction
            if (currentSortCol === columnIndex) {
                sortDirection = sortDirection === "asc" ? "desc" : "asc";
            } else {
                sortDirection = "asc";
            }
            currentSortCol = columnIndex;

            // Sorting logic
            rows.sort((rowA, rowB) => {
                const cellA = rowA.children[columnIndex].innerText.toLowerCase();
                const cellB = rowB.children[columnIndex].innerText.toLowerCase();

                if (cellA < cellB) return sortDirection === "asc" ? -1 : 1;
                if (cellA > cellB) return sortDirection === "asc" ?
                    1 : -1;
                return 0;
            });

            // Update icon
            icon.innerHTML = sortDirection === "asc" ? "&#9650;" : "&#9660;";

            // Re-render rows
            const tbody = table.querySelector('tbody');
            tbody.innerHTML = "";
            rows.forEach(row => tbody.appendChild(row));
        }

        function showDetails(row) {
            const name = row.dataset.name;
            const email = row.dataset.email;
            const tanggalLahir = row.dataset.tanggalLahir;
            const lingkungan = row.dataset.lingkungan;
            const alamat = row.dataset.alamat;
            const telepon = row.dataset.telepon;
            const foto = row.dataset.foto;

            Swal.fire({
                title: `<h2 style="font-weight: bold; color: #333;">${name}</h2>`,
                html: `
                <div style="text-align: center;">
                    <img src="${foto}" alt="Foto Profil" 
                        style="width: 120px; height: 120px; border-radius: 50%; object-fit: cover; margin-bottom: 10px; box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);">
                </div>
                <div style="text-align: left; margin-top: 10px; font-size: 16px;">
                    <p><strong style="color: #333;">Email:</strong> ${email}</p>
                    <p><strong style="color: #333;">Tanggal Lahir:</strong> ${tanggalLahir}</p>
                    <p><strong style="color: #333;">Lingkungan:</strong> ${lingkungan}</p>
                    <p><strong style="color: #333;">Alamat:</strong> ${alamat}</p>
                    <p><strong style="color: #333;">Telepon:</strong> ${telepon}</p>
                </div>
            `,
                showCloseButton: true,
                confirmButtonText: 'Tutup',
                confirmButtonColor: '#6f42c1',
                width: '400px'
            });
        }
    </script>
@endsection
