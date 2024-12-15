@extends('layout.TemplateAdmin')

@section('title', 'DaftarAsset')

@section('content')
    <div class="container mx-auto py-8">
        <h2 class="text-3xl font-semibold text-center mb-6 text-gray-800">Daftar Asset</h2>

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

        @if ($assets->isEmpty())
            <p class="text-center text-gray-500">Belum ada data asset.</p>
        @else
            <div class="mb-4 text-right">
                <a href="{{ route('asset.create') }}"
                    class="bg-blue-500 text-white px-4 py-2 rounded-md hover:bg-blue-600 inline-flex items-center gap-2">
                    <i class="fas fa-plus-circle"></i>
                    Tambah Asset Baru
                </a>
            </div>

            <div class="overflow-x-auto bg-white shadow-md rounded-lg">
                <table class="min-w-full bg-white">
                    <thead class="bg-blue-600 text-white">
                        <tr>
                            <th class="py-3 px-6 text-left">Gambar</th>
                            <th class="py-3 px-6 text-left">Nama Barang</th>
                            <th class="py-3 px-6 text-left">Jenis Barang</th>
                            <th class="py-3 px-6 text-center">Jumlah</th>
                            <th class="py-3 px-6 text-center">Stok Tersedia</th>
                            <th class="py-3 px-6 text-center">Kondisi</th>
                            <th class="py-3 px-6 text-left">Deskripsi</th>
                            <th class="py-3 px-6 text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($assets as $asset)
                            <tr class="hover:bg-gray-100 border-b">
                                <!-- Gambar -->
                                <td class="py-4 px-6 text-left">
                                    @if ($asset->gambar)
                                        <img src="{{ asset('storage/' . $asset->gambar) }}" alt="{{ $asset->nama_barang }}"
                                            class="w-12 h-12 object-cover rounded-lg">
                                    @else
                                        <div class="w-12 h-12 bg-gray-200 rounded-lg flex items-center justify-center">
                                            <i class="fas fa-image text-gray-500"></i>
                                        </div>
                                    @endif
                                </td>

                                <!-- Nama Barang -->
                                <td class="py-4 px-6 text-left">{{ $asset->nama_barang }}</td>

                                <!-- Jenis Barang -->
                                <td class="py-4 px-6 text-left">{{ $asset->jenis_barang }}</td>

                                <!-- Jumlah Barang -->
                                <td class="py-4 px-6 text-center">{{ $asset->jumlah_barang }}</td>
                                <td class="py-4 px-6 text-center">{{ $asset->stok_tersedia }}</td>

                                <!-- Kondisi -->
                                <td class="py-4 px-6 text-center">
                                    <span
                                        class="px-3 py-1 rounded-full text-white
                                        {{ $asset->kondisi == 'baik' ? 'bg-green-500' : 'bg-yellow-500' }}">
                                        <i
                                            class="fas {{ $asset->kondisi == 'baik' ? 'fa-check-circle' : 'fa-exclamation-circle' }}"></i>
                                        {{ ucfirst($asset->kondisi) }}
                                    </span>
                                </td>

                                <!-- Deskripsi -->
                                <td class="py-4 px-6 text-left">{{ $asset->deskripsi }}</td>

                                <!-- Aksi -->
                                <td class="py-4 px-6 flex justify-center gap-2">
                                    <a href="{{ route('asset.edit', $asset->id) }}"
                                        class="bg-yellow-500 text-white px-3 py-2 rounded-lg hover:bg-yellow-600 inline-flex items-center gap-1">
                                        <i class="fas fa-edit"></i>
                                        Edit
                                    </a>
                                    <button onclick="deleteAsset({{ $asset->id }})"
                                        class="bg-red-500 text-white px-3 py-2 rounded-lg hover:bg-red-600 inline-flex items-center gap-1">
                                        <i class="fas fa-trash"></i>
                                        Hapus
                                    </button>
                                    <form id="delete-form-{{ $asset->id }}"
                                        action="{{ route('asset.delete', $asset->id) }}" method="POST" class="hidden">
                                        @csrf
                                        @method('DELETE')
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>

    {{-- Pagination --}}
    <div class="mt-4">
        {{ $assets->links() }}
    </div>

    <script>
        function deleteAsset(id) {
            Swal.fire({
                title: 'Apakah Anda Yakin?',
                text: 'Data akan dihapus secara permanen!',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Hapus',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('delete-form-' + id).submit();
                }
            });
        }

        function confirmEdit(url) {
            Swal.fire({
                title: 'Apakah Anda yakin?',
                text: "Anda akan mengedit data ini!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, Edit',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = url;
                }
            });
        }
    </script>
@endsection
