@extends('layout.TemplateAdminParamenta')
@section('title', 'Permintaan Alat Misa')
@section('content')
    <div class="container mx-auto py-8">
        <h2 class="text-2xl font-bold mb-6">Permintaan Peminjaman Alat Misa</h2>

        <!-- SweetAlert Notifications -->
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
                    html: `<ul style="text-align: left;">@foreach ($errors->all() as $error) <li>{{ $error }}</li> @endforeach</ul>`,
                    confirmButtonText: 'OK'
                });
            </script>
        @endif

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


        <!-- Refresh Button -->
        <button onclick="window.location.reload();"
            class="bg-transparent text-blue-500 hover:text-blue-700 p-2 rounded-full transition duration-200 ease-in-out"
            title="Refresh halaman">
            <i class="fas fa-sync-alt text-xl"></i>
        </button>

        <!-- Table Section -->
        @if ($alatMisaRequests->isEmpty())
            <p class="text-gray-700 text-center">Tidak ada permintaan alat misa saat ini.</p>
        @else
            <form action="{{ route('alatmisa.batch_action') }}" method="POST" id="batch-form">
                @csrf
                <div class="overflow-x-auto bg-white shadow-lg rounded-lg">
                    <table id="roomTable" class="w-full text-sm text-left text-gray-700">
                        <thead class="bg-blue-600 text-white uppercase">
                            <tr>
                                <th scope="py-3" class="px-6 py-3">
                                    <input type="checkbox" id="select-all" class="form-checkbox">
                                </th>
                                <th class="py-3 px-6 text-left">Nama Alat Misa</th>
                                <th class="py-3 px-6 text-left">Dipinjam Oleh</th>
                                <th class="py-3 px-6 text-left">Jumlah</th>
                                <th class="py-3 px-6 text-left">Tanggal Peminjaman</th>
                                <th class="py-3 px-6 text-left">Tanggal Pengembalian</th>
                                <th class="py-3 px-6 text-left">Lama Peminjaman</th>
                                <th class="py-3 px-6 text-left">Waktu Pengajuan</th>
                                <th class="py-3 px-6 text-left">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="text-gray-800 text-sm">
                            @foreach ($alatMisaRequests as $request)
                                <tr class="bg-white border-b hover:bg-gray-100 transition duration-150">
                                    <td class="px-6 py-3">
                                        <input type="checkbox" name="selected_requests[]" value="{{ $request->id }}"
                                            class="form-checkbox request-checkbox">
                                    </td>
                                    <td class="px-6 py-3 font-medium text-gray-900 whitespace-nowrap">
                                        {{ $request->alatMisa->nama_alat }}
                                    </td>
                                    <td class="px-6 py-3">{{ $request->peminjam->name }}</td>
                                    <td class="px-6 py-3">{{ $request->jumlah }}</td>
                                    <td class="px-6 py-3">
                                        {{ \Carbon\Carbon::parse($request->tanggal_peminjaman)->format('d F Y') }}</td>
                                    <td class="px-6 py-3">
                                        {{ \Carbon\Carbon::parse($request->tanggal_pengembalian)->format('d F Y') }}</td>
                                    <td class="px-6 py-3">
                                        {{ \Carbon\Carbon::parse($request->tanggal_peminjaman)->diffInDays($request->tanggal_pengembalian) }}
                                        Hari
                                    </td>
                                    <td class="px-6 py-3">
                                        {{ \Carbon\Carbon::parse($request->created_at)->format('d F Y H:i') }}</td>
                                    <td class="px-6 py-3">
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

                <!-- Batch Actions -->
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
            const searchInput = document.getElementById('search');
            const tableRows = document.querySelectorAll('#roomTable tbody tr');

            document.addEventListener('DOMContentLoaded', function() {
                // Ambil elemen input pencarian dan tabel
                const searchInput = document.getElementById('search');
                const table = document.getElementById('roomTable');

                // Pastikan tabel dan input pencarian ada
                if (!searchInput || !table) {
                    console.error('Element input atau tabel tidak ditemukan.');
                    return;
                }

                const tableRows = table.querySelectorAll('tbody tr');

                // Fungsi untuk memfilter baris tabel
                const filterTable = () => {
                    const searchText = searchInput.value.toLowerCase(); // Ambil teks input pencarian

                    tableRows.forEach(row => {
                        // Ambil seluruh teks dalam baris
                        const rowText = row.textContent.toLowerCase();

                        // Tampilkan baris jika cocok, sembunyikan jika tidak cocok
                        row.style.display = rowText.includes(searchText) ? '' : 'none';
                    });
                };

                // Event listener untuk input pencarian
                searchInput.addEventListener('input', filterTable);

                console.log('Searching functionality initialized successfully.');
            });

            // Event for Individual Setujui Button
            setujuButtons.forEach(button => {
                button.addEventListener('click', function() {
                    Swal.fire({
                        title: 'Apakah Anda Yakin?',
                        text: 'Menyetujui peminjaman alat misa ini.',
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Ya, Setujui!'
                    }).then(result => {
                        if (result.isConfirmed) {
                            const form = document.createElement('form');
                            form.action = '{{ route('alatmisa.setujui', ':id') }}'.replace(
                                ':id', button.closest('tr').querySelector(
                                    '.request-checkbox').value);
                            form.method = 'POST';
                            form.innerHTML = '@csrf';
                            document.body.appendChild(form);
                            form.submit();
                        }
                    });
                });
            });

            // Event for Individual Tolak Button
            tolakButtons.forEach(button => {
                button.addEventListener('click', function() {
                    Swal.fire({
                        title: 'Tolak Peminjaman Alat Misa',
                        input: 'textarea',
                        inputPlaceholder: 'Alasan penolakan...',
                        showCancelButton: true,
                        confirmButtonText: 'Kirim Penolakan',
                        cancelButtonText: 'Batal',
                        inputValidator: value => !value ? 'Anda harus memberikan alasan!' :
                            null
                    }).then(result => {
                        if (result.isConfirmed) {
                            const reason = result.value;
                            const form = document.createElement('form');
                            form.action = '{{ route('alatmisa.tolak', ':id') }}'.replace(
                                ':id', button.closest('tr').querySelector(
                                    '.request-checkbox').value);
                            form.method = 'POST';
                            form.innerHTML =
                                `@csrf<input type="hidden" name="alasan_penolakan" value="${reason}">`;
                            document.body.appendChild(form);
                            form.submit();
                        }
                    });
                });
            });

            // Batch Reject
            batchRejectBtn.addEventListener('click', function() {
                Swal.fire({
                    title: 'Tolak Semua Peminjaman Alat Misa',
                    input: 'textarea',
                    inputPlaceholder: 'Alasan penolakan...',
                    showCancelButton: true,
                    confirmButtonText: 'Kirim Penolakan',
                    cancelButtonText: 'Batal',
                    inputValidator: value => !value ? 'Anda harus memberikan alasan!' : null
                }).then(result => {
                    if (result.isConfirmed) {
                        const reason = result.value;
                        const actionInput = document.createElement('input');
                        actionInput.type = 'hidden';
                        actionInput.name = 'action';
                        actionInput.value = 'reject';

                        const alasanInput = document.createElement('input');
                        alasanInput.type = 'hidden';
                        alasanInput.name = 'alasan_penolakan';
                        alasanInput.value = reason;

                        const batchForm = document.getElementById('batch-form');
                        batchForm.appendChild(actionInput);
                        batchForm.appendChild(alasanInput);
                        batchForm.submit();
                    }
                });
            });
        });
    </script>
@endsection
