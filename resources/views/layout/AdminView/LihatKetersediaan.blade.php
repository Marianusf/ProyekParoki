@extends('layout.TemplateAdmin')

@section('title', 'KetersediaanAsset')

@section('content')
    <div class="container mx-auto py-8">
        <h2 class="text-2xl font-semibold mb-6 text-gray-800">Daftar Ketersediaan Asset</h2>

        <!-- Session Alerts -->
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

        @if (session('message'))
            <script>
                Swal.fire({
                    icon: 'info',
                    title: 'Pesan:',
                    text: '{{ session('message') }}',
                    showConfirmButton: true,
                    timer: 5000
                });
            </script>
        @endif

        @if (session('error'))
            <script>
                Swal.fire({
                    icon: 'error',
                    title: 'Error:',
                    text: '{{ session('error') }}',
                    showConfirmButton: true,
                    timer: 5000
                });
            </script>
        @endif

        <!-- Search Bar -->
        <div class="mb-4">
            <input type="text" id="searchInput" placeholder="Cari berdasarkan nama barang..."
                class="w-full px-4 py-2 border rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
        </div>

        <!-- Asset Table -->
        <div class="overflow-x-auto overflow-y-auto max-h-[500px] bg-white shadow-md rounded-lg">
            <table class="min-w-full table-auto">
                <thead>
                    <tr class="bg-gray-100 text-left text-sm text-gray-600">
                        <th class="px-6 py-3">Nama Barang</th>
                        <th class="px-6 py-3">Gambar</th>
                        <th class="px-6 py-3">Jenis Barang</th>
                        <th class="px-6 py-3">Jumlah Tersedia</th>
                        <th class="px-6 py-3">Status</th>
                    </tr>
                </thead>
                <tbody id="assetTable">
                    @foreach ($assets as $asset)
                        <tr class="border-b hover:bg-gray-50">
                            <td class="px-6 py-4 text-sm text-gray-800">{{ $asset->nama_barang }}</td>
                            <td class="py-6 px-4 text-sm">
                                @if ($asset->gambar)
                                    <img src="{{ asset('storage/' . $asset->gambar) }}"
                                        alt="Gambar {{ $asset->nama_barang }}" class="w-20 h-20 object-cover rounded-lg">
                                @else
                                    <span class="text-gray-500">Tidak ada gambar</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-800">{{ $asset->jenis_barang }}</td>
                            <td class="px-6 py-4 text-sm text-gray-800">{{ $asset->stok_tersedia }}</td>
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

    <script>
        // Filter table rows based on search input
        document.getElementById('searchInput').addEventListener('input', function() {
            const searchText = this.value.toLowerCase();
            const rows = document.querySelectorAll('#assetTable tr');
            rows.forEach(row => {
                const itemName = row.querySelector('td:first-child').textContent.toLowerCase();
                row.style.display = itemName.includes(searchText) ? '' : 'none';
            });
        });
    </script>
@endsection
