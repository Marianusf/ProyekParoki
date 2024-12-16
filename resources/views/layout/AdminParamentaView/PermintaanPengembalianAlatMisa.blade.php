@extends('layout.TemplateAdminParamenta')
@section('title', 'Kelola Permintaan Pengembalian Alat Misa')

@section('content')
    <div class="container mx-auto py-8">
        <h2 class="text-3xl font-bold text-gray-800 mb-6">Permintaan Pengembalian Alat Misa</h2>

        <!-- Notifikasi -->
        @if (session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                <strong class="font-bold">Sukses!</strong>
                <span class="block sm:inline">{{ session('success') }}</span>
            </div>
        @endif

        @if ($pengembalianAlatMisa->isEmpty())
            <p class="text-gray-600">Tidak ada permintaan pengembalian alat misa saat ini.</p>
        @else
            <form action="{{ route('pengembalianAlatMisa.batch_action') }}" method="POST" id="batch-form">
                @csrf
                <input type="hidden" name="action" value="">
                <input type="hidden" name="alasan_penolakan" value="">

                <!-- Tabel Data -->
                <div class="overflow-x-auto bg-white shadow-lg rounded-lg">
                    <table class="w-full text-sm text-gray-700">
                        <thead class="bg-gray-200 text-gray-800 uppercase">
                            <tr>
                                <th class="px-4 py-3">
                                    <input type="checkbox" id="select-all" class="form-checkbox">
                                </th>
                                <th class="px-4 py-3">Nama Alat Misa</th>
                                <th class="px-4 py-3">Peminjam</th>
                                <th class="px-4 py-3">Jumlah</th>
                                <th class="px-4 py-3">Tanggal Peminjaman</th>
                                <th class="px-4 py-3">Tanggal Pengembalian</th>
                                <th class="px-4 py-3">Status</th>
                                <th class="px-4 py-3">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($pengembalianAlatMisa as $request)
                                <tr class="hover:bg-gray-100">
                                    <td class="px-4 py-3 text-center">
                                        <input type="checkbox" name="selected_requests[]" value="{{ $request->id }}"
                                            class="form-checkbox">
                                    </td>
                                    <td class="px-4 py-3">{{ $request->peminjaman->alatMisa->nama_alat }}</td>
                                    <td class="px-4 py-3">{{ $request->peminjaman->peminjam->name }}</td>
                                    <td class="px-4 py-3">{{ $request->peminjaman->jumlah }}</td>
                                    <td class="px-4 py-3">
                                        {{ \Carbon\Carbon::parse($request->peminjaman->tanggal_peminjaman)->format('d M Y') }}
                                    </td>
                                    <td class="px-4 py-3">
                                        {{ \Carbon\Carbon::parse($request->peminjaman->tanggal_pengembalian)->format('d M Y') }}
                                    </td>
                                    <td class="px-4 py-3 text-blue-600 font-semibold">{{ ucfirst($request->status) }}</td>
                                    <td class="px-4 py-3 space-x-2">
                                        <button type="button" onclick="approveRequest('{{ $request->id }}')"
                                            class="px-3 py-1 bg-green-500 text-white rounded hover:bg-green-600">Setujui</button>
                                        <button type="button" onclick="rejectRequest('{{ $request->id }}')"
                                            class="px-3 py-1 bg-red-500 text-white rounded hover:bg-red-600">Tolak</button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Tombol Batch -->
                <div class="mt-4 flex justify-end space-x-2">
                    <button type="submit" name="action" value="approve"
                        class="px-4 py-2 bg-green-500 text-white rounded hover:bg-green-600">Setujui Terpilih</button>
                    <button type="button" id="batch-reject-btn"
                        class="px-4 py-2 bg-red-500 text-white rounded hover:bg-red-600">Tolak Terpilih</button>
                </div>
            </form>
        @endif
    </div>
@endsection

@section('scripts')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const selectAllCheckbox = document.getElementById('select-all');
            const checkboxes = document.querySelectorAll('input[name="selected_requests[]"]');
            const batchRejectBtn = document.getElementById('batch-reject-btn');

            // Select All Functionality
            selectAllCheckbox.addEventListener('change', () => {
                checkboxes.forEach(cb => cb.checked = selectAllCheckbox.checked);
            });

            // Approve Function
            window.approveRequest = (id) => {
                Swal.fire({
                    title: 'Konfirmasi Setujui',
                    text: 'Anda yakin ingin menyetujui pengembalian ini?',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Ya, Setujui',
                    cancelButtonText: 'Batal'
                }).then(result => {
                    if (result.isConfirmed) {
                        const form = document.createElement('form');
                        form.method = 'POST';
                        form.action = `{{ route('pengembalianAlatMisa.approve', ':id') }}`.replace(
                            ':id', id);
                        form.innerHTML = '@csrf';
                        document.body.appendChild(form);
                        form.submit();
                    }
                });
            };

            // Reject Function
            window.rejectRequest = (id) => {
                Swal.fire({
                    title: 'Tolak Pengembalian',
                    input: 'textarea',
                    inputPlaceholder: 'Alasan penolakan...',
                    showCancelButton: true,
                    confirmButtonText: 'Kirim',
                    inputValidator: value => !value ? 'Alasan harus diisi!' : undefined
                }).then(result => {
                    if (result.isConfirmed) {
                        const form = document.createElement('form');
                        form.method = 'POST';
                        form.action = `{{ route('pengembalianAlatMisa.reject', ':id') }}`.replace(
                            ':id', id);
                        form.innerHTML = '@csrf' +
                            `<input type="hidden" name="alasan_penolakan" value="${result.value}">`;
                        document.body.appendChild(form);
                        form.submit();
                    }
                });
            };

            // Batch Reject
            batchRejectBtn.addEventListener('click', () => {
                const selected = Array.from(checkboxes).filter(cb => cb.checked);
                if (!selected.length) {
                    Swal.fire('Error', 'Pilih setidaknya satu permintaan.', 'error');
                    return;
                }
                Swal.fire({
                    title: 'Tolak Semua Terpilih',
                    input: 'textarea',
                    inputPlaceholder: 'Alasan penolakan...',
                    showCancelButton: true,
                    confirmButtonText: 'Kirim',
                    inputValidator: value => !value ? 'Alasan harus diisi!' : undefined
                }).then(result => {
                    if (result.isConfirmed) {
                        document.querySelector('input[name="action"]').value = 'reject';
                        document.querySelector('input[name="alasan_penolakan"]').value = result
                            .value;
                        document.getElementById('batch-form').submit();
                    }
                });
            });
        });
    </script>
@endsection
