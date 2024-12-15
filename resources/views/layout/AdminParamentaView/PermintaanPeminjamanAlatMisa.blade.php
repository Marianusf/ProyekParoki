@extends('layout.TemplateAdminParamenta')
@section('title', 'Permintaan Alat Misa')
@section('content')
    <div class="container mx-auto py-8">
        <h2 class="text-2xl font-bold mb-6">Permintaan Peminjaman Alat Misa</h2>

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
        @if ($errors->any())
            <script>
                Swal.fire({
                    icon: 'error',
                    title: 'Validasi Gagal',
                    html: ` 
                <ul style="text-align: left;">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            `,
                    confirmButtonText: 'OK'
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

        @if ($alatMisaRequests->isEmpty())
            <p class="text-gray-700">Tidak ada permintaan alat misa saat ini.</p>
        @else
            <form action="{{ route('alatmisa.batch_action') }}" method="POST" id="batch-form">
                @csrf
                <div class="overflow-x-auto overflow-y-auto max-h-[500px] bg-white shadow-md rounded-lg">
                    <button onclick="window.location.reload();"
                        class="bg-transparent text-blue-500 hover:text-blue-700 p-2 rounded-full transition duration-200 ease-in-out"
                        title="Refresh halaman">
                        <i class="fas fa-sync-alt text-xl"></i> <!-- Ikon refresh -->
                    </button>
                    <table class="w-full text-sm text-left text-gray-500">
                        <thead class="text-xs text-gray-700 uppercase bg-gray-200 sticky top-0">
                            <tr>
                                <th scope="col" class="px-6 py-3">
                                    <input type="checkbox" id="select-all" class="form-checkbox">
                                </th>
                                <th scope="col" class="px-6 py-3">Nama Alat Misa</th>
                                <th scope="col" class="px-6 py-3">Dipinjam Oleh</th>
                                <th scope="col" class="px-6 py-3">Jumlah</th>
                                <th scope="col" class="px-6 py-3">Tanggal Peminjaman</th>
                                <th scope="col" class="px-6 py-3">Tanggal Pengembalian</th>
                                <th scope="col" class="px-6 py-3">Lama Peminjaman</th>
                                <th scope="col" class="px-6 py-3">Waktu Pengajuan</th>
                                <th scope="col" class="px-6 py-3">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($alatMisaRequests as $request)
                                <tr class="bg-white border-b hover:bg-gray-100 transition duration-150">
                                    <td class="px-6 py-4">
                                        <input type="checkbox" name="selected_requests[]" value="{{ $request->id }} "
                                            class="form-checkbox request-checkbox">
                                    </td>
                                    <td class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap">
                                        {{ $request->alatMisa->nama_alat }}
                                    </td>
                                    <td class="px-6 py-4">{{ $request->peminjam->name }}</td>
                                    <td class="px-6 py-4">{{ $request->jumlah }}</td>
                                    <td class="px-6 py-4">
                                        {{ \Carbon\Carbon::parse($request->tanggal_peminjaman)->format('d F Y') }}</td>
                                    <td class="px-6 py-4">
                                        {{ \Carbon\Carbon::parse($request->tanggal_pengembalian)->format('d F Y') }}</td>
                                    <td class="px-6 py-4">
                                        <?php
                                        $tanggalPeminjaman = \Carbon\Carbon::parse($request->tanggal_peminjaman);
                                        $tanggalPengembalian = \Carbon\Carbon::parse($request->tanggal_pengembalian);
                                        $selisihHari = $tanggalPeminjaman->diffInDays($tanggalPengembalian);
                                        ?>
                                        {{ $selisihHari }} Hari
                                    </td>
                                    <td class="px-6 py-4">
                                        {{ \Carbon\Carbon::parse($request->created_at)->format('d F Y H:m') }}</td>
                                    <td class="px-6 py-4">
                                        <button type="button"
                                            class="setujuButton px-4 py-2 bg-green-500 text-white rounded-md hover:bg-green-600 transition">
                                            Setujui
                                        </button>
                                        <button type="button"
                                            class="tolakButton px-4 py-2 bg-red-500 text-white rounded-md hover:bg-red-600 transition mt-2">
                                            Tolak
                                        </button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="mt-4 flex justify-end">
                    <button type="submit" name="action" value="approve"
                        class="px-4 py-2 bg-green-500 text-white rounded-md hover:bg-green-600 transition mr-2">
                        Setujui Semua Terpilih
                    </button>
                    <button type="button" id="batch-reject-btn"
                        class="px-4 py-2 bg-red-500 text-white rounded-md hover:bg-red-600 transition">
                        Tolak Semua Terpilih
                    </button>
                </div>
            </form>
        @endif
    </div>
@endsection

@section('scripts')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const setujuButtons = document.querySelectorAll('.setujuButton');
            const tolakButtons = document.querySelectorAll('.tolakButton');
            const selectAllCheckbox = document.getElementById('select-all');
            const requestCheckboxes = document.querySelectorAll('.request-checkbox');
            const batchRejectBtn = document.getElementById('batch-reject-btn');
            const batchForm = document.getElementById('batch-form');

            // Toggle select/deselect all checkboxes
            selectAllCheckbox.addEventListener('change', function() {
                requestCheckboxes.forEach((checkbox) => {
                    checkbox.checked = selectAllCheckbox.checked;
                });
            });

            // Event for Setujui button
            setujuButtons.forEach((button) => {
                button.addEventListener('click', function(event) {
                    event.preventDefault();
                    Swal.fire({
                        title: "Apakah anda Yakin?",
                        text: "Apakah Yakin Akan Setujui Peminjaman Alat Misa Ini?",
                        icon: "warning",
                        showCancelButton: true,
                        confirmButtonColor: "#3085d6",
                        cancelButtonColor: "#d33",
                        confirmButtonText: "Ya, Setujui!"
                    }).then((result) => {
                        if (result.isConfirmed) {
                            const setujuForm = document.createElement('form');
                            setujuForm.action = '{{ route('alatmisa.setujui', ':id') }}'
                                .replace(':id', button.closest('tr').querySelector(
                                    '.request-checkbox').value);
                            setujuForm.method = 'POST';
                            setujuForm.innerHTML = '@csrf';
                            document.body.appendChild(setujuForm);
                            setujuForm.submit();
                        }
                    });
                });
            });

            // Event for Tolak button
            tolakButtons.forEach((button) => {
                button.addEventListener('click', function(event) {
                    event.preventDefault();
                    Swal.fire({
                        title: "Tolak Peminjaman Alat Misa",
                        input: 'textarea',
                        inputPlaceholder: 'Alasan penolakan...',
                        showCancelButton: true,
                        confirmButtonText: 'Kirim Penolakan',
                        cancelButtonText: 'Batal',
                        inputValidator: (value) => {
                            if (!value) {
                                return 'Anda harus memberikan alasan!';
                            }
                        }
                    }).then((result) => {
                        if (result.isConfirmed) {
                            const reason = result.value;

                            // Create form to submit rejection
                            const tolakForm = document.createElement('form');
                            tolakForm.action = '{{ route('alatmisa.tolak', ':id') }}'
                                .replace(':id', button.closest('tr').querySelector(
                                    '.request-checkbox').value);
                            tolakForm.method = 'POST';
                            tolakForm.innerHTML =
                                '@csrf<input type="hidden" name="alasan_penolakan" value="' +
                                reason + '">';
                            document.body.appendChild(tolakForm);
                            tolakForm.submit();

                            // Show confirmation that email was sent after rejection
                            Swal.fire({
                                title: 'Peminjaman Alat Misa Ditolak',
                                text: 'Email penolakan telah dikirim!',
                                icon: 'success',
                                confirmButtonText: 'Tutup'
                            });
                        }
                    });
                });
            });

            // Event for batch reject
            batchRejectBtn.addEventListener('click', function(event) {
                event.preventDefault();
                Swal.fire({
                    title: "Tolak Peminjaman Alat Misa",
                    input: 'textarea',
                    inputPlaceholder: 'Alasan penolakan...',
                    showCancelButton: true,
                    confirmButtonText: 'Kirim Penolakan',
                    cancelButtonText: 'Batal',
                    inputValidator: (value) => {
                        if (!value) {
                            return 'Anda harus memberikan alasan!';
                        }
                    }
                }).then((result) => {
                    if (result.isConfirmed) {
                        const reason = result.value;

                        // Add hidden input for batch action 'reject'
                        const actionInput = document.createElement('input');
                        actionInput.type = 'hidden';
                        actionInput.name = 'action';
                        actionInput.value = 'reject';
                        batchForm.appendChild(actionInput);

                        // Add hidden input for alasan penolakan
                        const alasanInput = document.createElement('input');
                        alasanInput.type = 'hidden';
                        alasanInput.name = 'alasan_penolakan';
                        alasanInput.value = reason;
                        batchForm.appendChild(alasanInput);

                        batchForm.submit();

                        // Show confirmation that email was sent for batch rejection
                        Swal.fire({
                            title: 'Penolakan Terpenuhi',
                            text: 'Email penolakan untuk semua terpilih telah dikirim!',
                            icon: 'success',
                            confirmButtonText: 'Tutup'
                        });
                    }
                });
            });
        });
    </script>
@endsection
