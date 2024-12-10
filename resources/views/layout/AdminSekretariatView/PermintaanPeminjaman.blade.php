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


        <div class="overflow-x-auto bg-white shadow-md rounded-lg">
            <table class="table-auto w-full" id="peminjamanTable">
                <thead class="bg-blue-500 text-white uppercase text-sm">
                    <tr>
                        <th class="py-4 px-6 text-left">Nama Peminjam</th>
                        <th class="py-4 px-6 text-left">Ruangan</th>
                        <th class="py-4 px-6 text-left">Tanggal Mulai</th>
                        <th class="py-4 px-6 text-left">Tanggal Selesai</th>
                        <th class="py-4 px-6 text-left">Durasi</th>
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
