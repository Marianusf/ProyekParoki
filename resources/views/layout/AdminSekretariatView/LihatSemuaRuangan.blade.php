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

            <!-- Room Table -->
            <div class="bg-white shadow-md rounded-lg overflow-hidden">
                @if ($ruangan->count() > 0)
                    <table class="min-w-full table-auto">
                        <thead class="bg-blue-600 text-white uppercase text-sm">
                            <tr>
                                <th class="py-3 px-6 text-left">Gambar</th>
                                <th class="py-3 px-6 text-left">Nama Ruangan</th>
                                <th class="py-3 px-6 text-left">Kapasitas</th>
                                <th class="py-3 px-6 text-left">Status</th>
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
                                    <td class="py-3 px-6">{{ $room->nama }}</td>

                                    <!-- Kapasitas -->
                                    <td class="py-3 px-6">{{ $room->kapasitas }}</td>
                                    <td class="py-3 px-6">{{ $room->kondisi }}</td>

                                    <!-- Deskripsi -->
                                    <td class="py-3 px-6">{{ Str::limit($room->deskripsi, 500) }}</td>

                                    <!-- Fasilitas -->
                                    <td class="py-3 px-6">
                                        @if ($room->fasilitas)
                                            <ul class="list-disc list-inside text-gray-600">
                                                @foreach (json_decode($room->fasilitas) as $fasilitas)
                                                    <li>{{ $fasilitas }}</li>
                                                @endforeach
                                            </ul>
                                        @else
                                            <span class="text-gray-500">Tidak ada fasilitas</span>
                                        @endif
                                    </td>
                                    <td class="py-3 px-6 text-center">
                                        <span
                                            class="px-3 py-1 rounded-full text-white text-xs 
                                            {{ $room->status == 'tidak_dapat_dipinjam'
                                                ? 'bg-red-500'
                                                : ($room->status == 'dipinjam'
                                                    ? 'bg-yellow-500'
                                                    : ($room->status == 'tersedia'
                                                        ? 'bg-green-500'
                                                        : 'bg-gray-500')) }} 
                                            inline-block overflow-hidden text-ellipsis whitespace-nowrap">
                                            @switch($room->status)
                                                @case('tidak_dapat_dipinjam')
                                                    Tidak Bisa Dipinjam
                                                @break

                                                @case('dipinjam')
                                                    Sedang Dipinjam
                                                @break

                                                @case('tersedia')
                                                    Tersedia
                                                @break

                                                @default
                                                    Status Tidak Diketahui
                                            @endswitch
                                        </span>
                                    </td>




                                    <!-- Tanggal Ditambahkan -->
                                    <td class="py-3 px-6">{{ $room->created_at->format('d-m-Y') }}</td>

                                    <!-- Aksi -->
                                    <td class="py-3 px-6 text-center flex justify-center space-x-2">
                                        <a href="{{ route('ruangan.edit', $room->id) }}"
                                            class="text-yellow-500 hover:text-yellow-700 transition duration-300"
                                            title="Edit Ruangan">
                                            <i class="bi bi-pencil-square text-lg"></i>
                                        </a>

                                        <button type="button" onclick="deleteRoom({{ $room->id }})"
                                            class="text-red-500 hover:text-red-700 transition duration-300"
                                            title="Hapus Ruangan">
                                            <i class="bi bi-trash-fill text-lg"></i>
                                        </button>

                                        <form id="delete-form-{{ $room->id }}"
                                            action="{{ route('ruangan.destroy', $room->id) }}" method="POST"
                                            class="hidden">
                                            @csrf
                                            @method('DELETE')
                                        </form>
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

            <!-- Pagination -->
            <div class="mt-6">
                {{ $ruangan->links() }}
            </div>
        </div>
    </section>

    <script>
        function deleteRoom(roomId) {
            Swal.fire({
                title: 'Apakah Anda yakin?',
                text: 'Tindakan ini tidak dapat dibatalkan!',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Hapus',
                cancelButtonText: 'Batal',
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('delete-form-' + roomId).submit();
                }
            });
        }
    </script>
@endsection
