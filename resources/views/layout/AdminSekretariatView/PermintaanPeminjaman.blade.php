@extends('layout.TemplateAdminSekretariat')

@section('content')
    <div class="container mx-auto p-6">
        <h1 class="text-3xl font-bold mb-6 text-gray-800">Kelola Peminjaman Ruangan</h1>
        @if (session('sweet-alert'))
            <script>
                Swal.fire({
                    icon: '{{ session('sweet-alert.icon') }}',
                    title: '{{ session('sweet-alert.title') }}',
                    text: '{{ session('sweet-alert.text') }}',
                    showConfirmButton: true,
                    timer: 5000
                });
            </script>
        @endif

        <!-- Notifikasi -->
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

        <div class="relative mb-4">
            <span class="absolute inset-y-0 left-0 flex items-center pl-3">
                <i class="fas fa-search text-gray-400"></i>
            </span>
            <input type="text" id="search" class="p-3 pl-10 border rounded w-1/3"
                placeholder="Cari berdasarkan nama peminjam, ruangan..." onkeyup="searchTable()">
        </div>

        <!-- Sorting Dropdown -->
        <div class="mb-4 flex justify-end">
            <label for="sort" class="mr-2 text-gray-600">Sortir Berdasarkan:</label>
            <select id="sort" class="p-2 border rounded" onchange="sortTable()">
                <option value="nama_peminjam">Nama Peminjam</option>
                <option value="ruangan">Ruangan</option>
                <option value="tanggal_mulai">Tanggal Mulai</option>
                <option value="created_at" selected>Tanggal Permintaan</option>
            </select>

        </div>
        <div class="overflow-x-auto overflow-y-auto max-h-[500px] bg-white shadow-md rounded-lg">
            <button onclick="window.location.reload();"
                class="bg-transparent text-blue-500 hover:text-blue-700 p-2 rounded-full transition duration-200 ease-in-out"
                title="Refresh halaman">
                <i class="fas fa-sync-alt text-xl"></i> <!-- Ikon refresh -->
            </button>
            <table class="table-auto w-full" id="peminjamanTable">
                <thead class="bg-blue-500 text-white uppercase text-sm">
                    <tr>
                        <th class="py-4 px-6 text-left">Nama Peminjam</th>
                        <th class="py-4 px-6 text-left">Ruangan</th>
                        <th class="py-4 px-6 text-left">Tanggal Mulai</th>
                        <th class="py-4 px-6 text-left">Tanggal Selesai</th>
                        <th class="py-4 px-6 text-left">Durasi</th>
                        <th class="py-4 px-6 text-left">Tujuan</th>
                        <th class="py-4 px-6 text-left">Tanggal Permintaan</th>
                        <th class="py-4 px-6 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="text-gray-800">
                    @foreach ($peminjaman as $item)
                        <tr class="border-b hover:bg-gray-100">
                            <td class="py-3 px-6">{{ $item->peminjam->name }}</td>
                            <td class="py-3 px-6">{{ $item->ruangan->nama }}</td>
                            <td class="py-3 px-6">{{ \Carbon\Carbon::parse($item->tanggal_mulai)->format('d M Y H:i') }}
                            </td>
                            <td class="py-3 px-6">{{ \Carbon\Carbon::parse($item->tanggal_selesai)->format('d M Y H:i') }}
                            </td>
                            <td class="py-3 px-6">
                                @php
                                    $mulai = \Carbon\Carbon::parse($item->tanggal_mulai);
                                    $selesai = \Carbon\Carbon::parse($item->tanggal_selesai);
                                    $totalMenit = $mulai->diffInMinutes($selesai);
                                    $hari = floor($totalMenit / 1440);
                                    $jam = floor(($totalMenit % 1440) / 60);
                                    $menit = $totalMenit % 60;
                                    $durasi =
                                        $hari > 0
                                            ? "$hari hari $jam jam"
                                            : ($jam > 0
                                                ? "$jam jam $menit menit"
                                                : "$menit menit");
                                @endphp
                                {{ $durasi }}
                            </td>
                            <td class="py-3 px-6">{{ $item->tujuan_peminjaman }}</td>
                            <td class="py-3 px-6">{{ \Carbon\Carbon::parse($item->created_at)->format('d M Y H:i') }}
                            </td>
                            <td class="py-3 px-6 text-center">
                                <div class="flex justify-between items-center space-x-2">
                                    <!-- Tombol Setujui -->
                                    <form id="approveForm-{{ $item->id }}" method="POST"
                                        action="{{ route('peminjaman.approve', $item->id) }}">
                                        @csrf
                                        <button type="button" onclick="approveRequest({{ $item->id }})"
                                            class="bg-green-500 hover:bg-green-600 text-white font-semibold px-4 py-2 rounded-md">
                                            <i class="fas fa-check"></i> Setujui
                                        </button>
                                    </form>
                                    <!-- Tombol Tolak -->
                                    <button type="button" onclick="rejectRequest({{ $item->id }})"
                                        class="bg-red-500 hover:bg-red-600 text-white font-semibold px-4 py-2 rounded-md">
                                        <i class="fas fa-times"></i> Tolak
                                    </button>
                                </div>
                            </td>

                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <script>
        function sortTable() {
            const table = document.getElementById("peminjamanTable");
            const tbody = table.querySelector("tbody");
            const rows = Array.from(tbody.querySelectorAll("tr"));
            const sortBy = document.getElementById("sort").value;

            let columnIndex;

            // Tentukan kolom berdasarkan pilihan sorting
            switch (sortBy) {
                case "nama_peminjam":
                    columnIndex = 0; // Kolom Nama Peminjam
                    break;
                case "ruangan":
                    columnIndex = 1; // Kolom Ruangan
                    break;
                case "tanggal_mulai":
                    columnIndex = 2; // Kolom Tanggal Mulai
                    break;
                case "created_at":
                    columnIndex = 6; // Kolom Tanggal Permintaan
                    break;
                default:
                    columnIndex = 0; // Default ke Nama Peminjam
            }

            // Sorting berdasarkan kolom yang dipilih
            rows.sort((a, b) => {
                const cellA = a.querySelectorAll("td")[columnIndex].textContent.trim();
                const cellB = b.querySelectorAll("td")[columnIndex].textContent.trim();

                // Jika kolom adalah tanggal, gunakan Date untuk sorting
                if (["tanggal_mulai", "created_at"].includes(sortBy) || columnIndex === 2 || columnIndex === 6) {
                    const dateA = parseDate(cellA);
                    const dateB = parseDate(cellB);
                    return dateA - dateB; // Ascending order (terdekat ke terlama)
                }

                // Sorting string (Nama Peminjam atau Ruangan)
                return cellA.localeCompare(cellB);
            });

            // Tambahkan kembali baris ke tbody
            rows.forEach(row => tbody.appendChild(row));
        }

        // Fungsi untuk memastikan parsing tanggal sesuai format
        function parseDate(dateString) {
            // Pastikan format tanggal: "dd MMM yyyy HH:mm"
            const parts = dateString.split(" ");
            const day = parseInt(parts[0], 10);
            const month = ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"].indexOf(
                parts[1]);
            const year = parseInt(parts[2], 10);
            const time = parts[3].split(":");
            const hours = parseInt(time[0], 10);
            const minutes = parseInt(time[1], 10);

            // Buat objek Date
            return new Date(year, month, day, hours, minutes);
        }


        // Fungsi untuk mencari tabel
        function searchTable() {
            var input = document.getElementById("search");
            var filter = input.value.toLowerCase();
            var table = document.getElementById("peminjamanTable");
            var tr = table.getElementsByTagName("tr");

            for (var i = 1; i < tr.length; i++) {
                var tdName = tr[i].getElementsByTagName("td")[0];
                var tdRoom = tr[i].getElementsByTagName("td")[1];
                if (tdName || tdRoom) {
                    var txtName = tdName.textContent || tdName.innerText;
                    var txtRoom = tdRoom.textContent || tdRoom.innerText;

                    if (txtName.toLowerCase().indexOf(filter) > -1 ||
                        txtRoom.toLowerCase().indexOf(filter) > -1) {
                        tr[i].style.display = "";
                    } else {
                        tr[i].style.display = "none";
                    }
                }
            }
        }

        function approveRequest(id) {
            Swal.fire({
                title: 'Setujui Peminjaman',
                text: "Apakah Anda yakin ingin menyetujui peminjaman ini?",
                icon: 'info',
                showCancelButton: true,
                confirmButtonText: 'Ya, Setujui',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    const form = document.getElementById(`approveForm-${id}`);
                    form.submit();
                }
            });
        }

        function rejectRequest(id) {
            Swal.fire({
                title: 'Tolak Peminjaman',
                input: 'textarea',
                inputPlaceholder: 'Masukkan alasan penolakan...',
                inputAttributes: {
                    'aria-label': 'Masukkan alasan penolakan'
                },
                showCancelButton: true,
                confirmButtonText: 'Kirim',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed && result.value) {
                    const rejectionForm = document.createElement('form');
                    rejectionForm.method = 'POST';
                    rejectionForm.action = `/peminjaman/reject/${id}`;
                    rejectionForm.innerHTML = `
                        @csrf
                        <input type="hidden" name="alasan_penolakan" value="${result.value}">
                    `;
                    document.body.appendChild(rejectionForm);
                    rejectionForm.submit();
                }
            });
        }
    </script>
@endsection
