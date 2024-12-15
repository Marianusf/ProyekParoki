@extends('layout.TemplateAdminParamenta')

@section('title', 'Lihat Alat Misa')

@section('content')
    <div class="container mx-auto py-8">
        <h2 class="text-3xl font-semibold text-center mb-6 text-gray-800">Daftar Alat Misa</h2>

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

        @if ($alatMisa->isEmpty())
            <p class="text-center text-gray-500">Belum ada data alat misa.</p>
        @else
            <table class="min-w-full bg-white shadow-md rounded-lg">
                <thead class="bg-blue-600 text-white">
                    <tr>
                        <th class="py-3 px-6 text-left">Gambar</th>
                        <th class="py-3 px-6 text-left">Nama Alat</th>
                        <th class="py-3 px-6 text-left">Jenis</th>
                        <th class="py-3 px-6 text-center">Jumlah</th>
                        <th class="py-3 px-6 text-center">Detail Alat</th>
                        <th class="py-3 px-6 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($alatMisa as $alat)
                        <tr class="hover:bg-gray-100 border-b">
                            <td class="py-4 px-6 text-center">
                                @if (!empty($alat->gambar))
                                    <img src="{{ asset('storage/' . $alat->gambar) }}" alt="Gambar {{ $alat->nama_alat }}"
                                        class="w-16 h-16 rounded shadow">
                                @else
                                    <span class="text-gray-500">Tidak ada gambar</span>
                                @endif
                            </td>
                            <td class="py-4 px-6">{{ $alat->nama_alat }}</td>
                            <td class="py-4 px-6">{{ $alat->jenis_alat }}</td>
                            <td class="py-4 px-6 text-center">{{ $alat->jumlah }}</td>
                            <td class="py-4 px-6 text-center">
                                @if (!empty($alat->detail_alat) && is_array($alat->detail_alat))
                                    <ol class="list-decimal list-inside text-gray-600">
                                        @foreach ($alat->detail_alat as $detail)
                                            <li>{{ $detail['nama_detail'] ?? 'Nama Tidak Ada' }} (Jumlah:
                                                {{ $detail['jumlah'] ?? 0 }})</li>
                                        @endforeach
                                    </ol>
                                @else
                                    <span class="text-gray-500">Tidak ada Detail Alat</span>
                                @endif
                            </td>




                            <!-- Tombol Edit dan Hapus -->
                            <td class="py-4 px-6 flex justify-center gap-3">
                                <a href="{{ route('alat_misa.edit', $alat->id) }}"
                                    class="bg-yellow-500 text-white px-3 py-2 rounded-lg hover:bg-yellow-600">
                                    Edit
                                </a>

                                <form id="delete-form-{{ $alat->id }}"
                                    action="{{ route('alat_misa.destroy', $alat->id) }}" method="POST" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="button" onclick="confirmDelete({{ $alat->id }})"
                                        class="bg-red-500 text-white px-3 py-2 rounded-lg hover:bg-red-600">
                                        Hapus
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    </div>
    <script>
        function confirmDelete(id) {
            Swal.fire({
                title: 'Apakah Anda Yakin?',
                text: "Data akan dihapus secara permanen!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Ya, Hapus!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('delete-form-' + id).submit();
                }
            });
        }
        document.addEventListener('DOMContentLoaded', function() {
            const detailContainer = document.getElementById('detail-container');
            const detailInput = document.getElementById('detail_alat_json');

            function updateJson() {
                const details = [];
                document.querySelectorAll('#detail-container .flex').forEach(function(row) {
                    const namaDetail = row.querySelector('.nama-detail-input').value.trim();
                    const jumlah = row.querySelector('.jumlah-input').value.trim();

                    if (namaDetail && jumlah) {
                        details.push({
                            nama_detail: namaDetail,
                            jumlah: jumlah
                        });
                    }
                });

                detailInput.value = JSON.stringify(details);
            }

            window.addDetail = function() {
                const index = Date.now(); // Unique ID for each row
                const row = document.createElement('div');
                row.className = 'flex items-center gap-2';
                row.id = 'detail-row-' + index;

                row.innerHTML = `
            <input type="text" placeholder="Nama Detail" class="nama-detail-input border-gray-300 rounded p-2 w-1/2" />
            <input type="number" placeholder="Jumlah" class="jumlah-input border-gray-300 rounded p-2 w-1/4" min="1" />
            <button type="button" onclick="removeDetail(this)" class="text-red-500 hover:text-red-700">
                <i class="fas fa-trash"></i> Hapus
            </button>
        `;
                detailContainer.appendChild(row);

                row.querySelectorAll('input').forEach(input => input.addEventListener('input', updateJson));
                updateJson();
            };

            window.removeDetail = function(button) {
                button.parentElement.remove();
                updateJson();
            };

            document.querySelector('form').addEventListener('submit', function() {
                updateJson();
            });
        });

        // Fungsi untuk konfirmasi penghapusan
        function deleteAlat(id) {
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
    </script>
@endsection
