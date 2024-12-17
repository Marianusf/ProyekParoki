@extends('layout.TemplateAdminParamenta')

@section('title', 'Ketersediaan Alat Misa')

@section('content')
    <div class="container mx-auto py-8">
        <h2 class="text-2xl font-semibold mb-6">Daftar Ketersediaan Alat Misa</h2>
<!-- SweetAlert2 Session Alerts -->
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

@if (session('error'))
    <script>
        Swal.fire({
            title: 'Error!',
            text: "{{ session('error') }}",
            icon: 'error',
            confirmButtonText: 'OK'
        });
    </script>
@endif

@if (session('message'))
    <script>
        Swal.fire({
            title: 'Informasi',
            text: "{{ session('message') }}",
            icon: 'info',
            confirmButtonText: 'OK'
        });
    </script>
@endif

        <!-- Flash Message -->
        @if (session('success'))
            <script>
                Swal.fire({
                    icon: 'success',
                    title: 'Sukses!',
                    text: '{{ session('success') }}',
                    showConfirmButton: true,
                    timer: 5000
                });
            </script>
        @endif

        <!-- Filter -->
        <div class="flex justify-end mb-4">
            <form action="" method="GET" class="flex gap-4 items-center">
                <select name="filter_ketersediaan" class="border rounded-lg p-2">
                    <option value="">Semua</option>
                    <option value="tersedia">Tersedia</option>
                    <option value="habis">Habis</option>
                </select>
                <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
                    Filter
                </button>
            </form>
        </div>

        <!-- Tabel Ketersediaan -->
        <div class="overflow-x-auto overflow-y-auto max-h-[500px] bg-white shadow-md rounded-lg">
            <table class="min-w-full table-auto">
                <thead>
                    <tr class="bg-gray-100 text-left text-sm text-gray-600">
                        <th class="px-6 py-3">Nama Alat</th>
                        <th class="px-6 py-3">Gambar</th>
                        <th class="px-6 py-3">Jenis Alat</th>
                        <th class="px-6 py-3">Jumlah Tersedia</th>
                        <th class="px-6 py-3">Detail</th>
                        <th class="px-6 py-3">Status</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($alatmisa as $asset)
                        <tr class="border-b hover:bg-gray-50">
                            <td class="px-6 py-4 text-sm text-gray-800">{{ $asset->nama_alat }}</td>

                            <td class="py-6 px-4 text-sm">
                                @if ($asset->gambar)
                                    <img src="{{ asset('storage/' . $asset->gambar) }}" alt="Gambar {{ $asset->nama_alat }}"
                                        class="w-20 h-20 object-cover rounded-lg">
                                @else
                                    <span class="text-gray-500">Tidak ada gambar</span>
                                @endif
                            </td>

                            <td class="px-6 py-4 text-sm text-gray-800">{{ $asset->jenis_alat }}</td>
                            <td class="px-6 py-4 text-sm text-gray-800">{{ $asset->stok_tersedia }}</td>

                            <!-- Detail Alat -->
                            <td class="px-6 py-4 text-sm">
                                @if ($asset->detail_alat && count($asset->detail_alat))
                                    <ul class="list-disc list-inside text-gray-700">
                                        @foreach ($asset->detail_alat as $detail)
                                            <li>{{ $detail['nama_detail'] }} - Jumlah: {{ $detail['jumlah'] }}</li>
                                        @endforeach
                                    </ul>
                                @else
                                    <span class="text-gray-500">Tidak ada detail</span>
                                @endif
                            </td>

                            <!-- Status -->
                            <td class="px-6 py-4 text-sm">
                                @if ($asset->stok_tersedia > 0)
                                    <span class="bg-green-500 text-white px-2 py-1 rounded-full text-xs">Tersedia</span>
                                @else
                                    <span class="bg-red-500 text-white px-2 py-1 rounded-full text-xs">Habis</span>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
