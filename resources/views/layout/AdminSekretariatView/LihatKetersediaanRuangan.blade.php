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

            <!-- Room Table -->
            <div class="bg-white shadow-md rounded-lg overflow-hidden">
                @if ($room->count() > 0)
                    <table class="min-w-full table-auto">
                        <thead class="bg-blue-600 text-white uppercase text-sm">
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
                                    <td class="py-3 px-6">{{ $room->nama }}</td>

                                    <!-- Kapasitas -->
                                    <td class="py-3 px-6">{{ $room->kapasitas }}</td>

                                    <!-- Deskripsi -->
                                    <td class="py-3 px-6">{{ Str::limit($room->deskripsi, 50) }}</td>

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

@endsection
