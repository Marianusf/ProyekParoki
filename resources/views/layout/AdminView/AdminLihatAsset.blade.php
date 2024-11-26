@extends('layout.TemplateAdmin')

@section('title', 'DaftarAsset')

@section('content')
    <section class="p-6 bg-blue-100 min-h-screen">
        <div class="container mx-auto">
            <h2 class="text-2xl font-semibold text-gray-700 mb-4">Daftar Asset</h2>

            @if (session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4"
                    role="alert">
                    <strong class="font-bold">Sukses: </strong>
                    <span class="block sm:inline">{{ session('success') }}</span>
                </div>
            @endif
            @if (session('message'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4"
                    role="alert">
                    <strong class="font-bold">PESAN: </strong>
                    <span class="block sm:inline">{{ session('message') }}</span>
                </div>
            @endif

            @if (session('error'))
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
                    <strong class="font-bold">Error: </strong>
                    <span class="block sm:inline">{{ session('error') }}</span>
                </div>
            @endif
            @endif
            <div class="mb-4 text-right">
                <a href="{{ route('asset.create') }}" class="bg-blue-500 text-white px-4 py-2 rounded-md hover:bg-blue-600">
                    Tambah Asset Baru
                </a>
            </div>
            <div class="overflow-x-auto">
                <table class="min-w-full bg-white border border-gray-200 rounded-lg">
                    <thead>
                        <tr class="w-full bg-blue-600 text-white uppercase text-sm leading-normal">
                            <th scope="py-3 px-6 text-left">Nama Barang</th>
                            <th scope="py-3 px-6 text-left">Jenis Barang</th>
                            <th scope="py-3 px-6 text-left">Jumlah Barang</th>
                            <th scope="py-3 px-6 text-left">Kondisi</th>
                            <th scope="py-3 px-6 text-left">Deskripsi</th>
                            <th scope="py-3 px-6 text-left">Gambar</th>
                            <th scope="py-3 px-6 text-left">Tanggal Ditambahkan</th>
                            <th scope="py-3 px-6 text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="text-gray-700 text-sm font-light">
                        @foreach ($assets as $asset)
                            <tr class="border-b border-gray-200 hover:bg-gray-100">
                                <td class="py-3 px-6 text-left">{{ $asset->nama_barang }}</td>
                                <td class="py-3 px-6 text-left">{{ $asset->jenis_barang }}</td>
                                <td class="py-3 px-6 text-left">{{ $asset->jumlah_barang }}</td>
                                <td class="py-3 px-6 text-left">{{ $asset->kondisi }}</td>
                                <td class="py-3 px-6 text-left">{{ $asset->deskripsi }}</td>
                                <td class="py-3 px-6 text-left">
                                    @if ($asset->gambar)
                                        <!-- Debugging: Outputkan URL gambar untuk memeriksa jalur yang benar -->
                                        <img src="{{ asset('storage/' . $asset->gambar) }}"
                                            alt="Gambar {{ $asset->nama_barang }}"
                                            class="w-20 h-20 object-cover rounded-lg">
                                    @else
                                        <span class="text-gray-500">Tidak ada gambar</span>
                                    @endif
                                </td>



                                <td class="py-3 px-6 text-left">{{ $asset->created_at->format('d-m-Y') }}</td>
                                <td class="py-3 px-6 text-center">
                                    <a href="{{ route('asset.edit', $asset->id) }}"
                                        class="bg-yellow-500 text-white py-1 px-3 rounded hover:bg-yellow-700 edit-btn"
                                        onclick="event.preventDefault(); confirmEdit('{{ route('asset.edit', $asset->id) }}');">
                                        Edit
                                    </a>

                                    <button type="button" onclick="deleteAsset({{ $asset->id }})"
                                        class="bg-red-500 text-white py-1 px-3 rounded hover:bg-red-700">Hapus</button>
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
        </div>
    </section>

    {{-- Pagination --}}
    <div class="mt-4">
        {{ $assets->links() }}
    </div>
    <script>
        function deleteAsset(assetId) {
            Swal.fire({
                title: 'Apakah Anda yakin?',
                text: 'Tindakan ini tidak dapat dibatalkan!',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Hapus',
                cancelButtonText: 'Batal',
            }).then((result) => {
                if (result.isConfirmed) {
                    // Lakukan penghapusan jika dikonfirmasi
                    document.getElementById('delete-form-' + assetId).submit();
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
