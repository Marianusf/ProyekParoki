@extends('layout.TemplateAdmin')
@section('title', 'PermintaanPengembalian')
@section('content')
    <div class="container mx-auto py-8">
        <h2 class="text-2xl font-bold mb-6">Permintaan Pengembalian</h2>

        @if ($errors->any())
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4">
                <strong class="font-bold">Pemberitahuan: </strong>
                <ul class="list-disc pl-5">
                    @foreach ($errors->all() as $error)
                        <li><strong>{{ $error }}</strong></li>
                    @endforeach
                </ul>
            </div>
        @endif
        @if (session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                <strong class="font-bold">Sukses: </strong>
                <span class="block sm:inline">{{ session('success') }}</span>
            </div>
        @endif
        @if (session('message'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                <strong class="font-bold">PESAN : </strong>
                <span class="block sm:inline">{{ session('message') }}</span>
            </div>
        @endif

        @if ($pengembalian->isEmpty())
            <p class="text-gray-700">Tidak ada permintaan pengembalian saat ini.</p>
        @else
            <form action="{{ route('pengembalian.batch_action') }}" method="POST" id="batch-form">
                @csrf
                <div class="overflow-x-auto overflow-y-auto max-h-[500px] bg-white shadow-md rounded-lg">
                    <table class="w-full text-sm text-left text-gray-500">
                        <thead class="text-xs text-gray-700 uppercase bg-gray-200 sticky top-0">
                            <tr>
                                <th scope="col" class="px-6 py-3">
                                    <input type="checkbox" id="select-all" class="form-checkbox">
                                </th>
                                <th scope="col" class="px-6 py-3">Nama Asset</th>
                                <th scope="col" class="px-6 py-3">Dipinjam Oleh</th>
                                <th scope="col" class="px-6 py-3">Jumlah</th>
                                <th scope="col" class="px-6 py-3">Tanggal Peminjaman</th>
                                <th scope="col" class="px-6 py-3">Tanggal Pengembalian</th>
                                <th scope="col" class="px-6 py-3">Tanggal Permintaan</th>
                                <th scope="col" class="px-6 py-3">Sisa</th>
                                <th scope="col" class="px-6 py-3">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($pengembalian as $request)
                                <tr class="bg-white border-b hover:bg-gray-100 transition duration-150">
                                    <td class="px-6 py-4">
                                        <input type="checkbox" name="selected_requests[]" value="{{ $request->id }}"
                                            class="form-checkbox request-checkbox">
                                    </td>
                                    <td class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap">
                                        {{-- Menampilkan nama barang dari asset yang dipinjam --}}
                                        {{ $request->peminjaman->asset->nama_barang }}
                                    </td>
                                    <td class="px-6 py-4">
                                        {{-- Menampilkan nama peminjam --}}
                                        {{ $request->peminjaman->peminjam->name }}
                                    </td>
                                    <td class="px-6 py-4">{{ $request->peminjaman->jumlah }}</td>
                                    <td class="px-6 py-4">
                                        {{-- Menampilkan tanggal peminjaman --}}
                                        {{ \Carbon\Carbon::parse($request->peminjaman->tanggal_peminjaman)->format('d F Y') }}
                                    </td>
                                    <td class="px-6 py-4">
                                        {{-- Menampilkan tanggal pengembalian yang dijadwalkan --}}
                                        {{ \Carbon\Carbon::parse($request->peminjaman->tanggal_pengembalian)->format('d F Y') }}
                                    </td>
                                    <td class="px-6 py-4">
                                        {{-- Menampilkan tanggal pengembalian yang dijadwalkan --}}
                                        {{ \Carbon\Carbon::parse($request->created_at)->format('d F Y') }}
                                    </td>
                                    <td class="px-6 py-4">
                                        {{-- Menghitung durasi sisa dalam format hari, jam, atau menit --}}
                                        @php
                                            // Menggunakan tanggal pengajuan (created_at) dan tanggal pengembalian dari tabel peminjaman
                                            $tanggal_pengajuan = \Carbon\Carbon::parse($request->created_at); // Tanggal pengajuan
                                            $tanggal_pengembalian = \Carbon\Carbon::parse(
                                                $request->peminjaman->tanggal_pengembalian,
                                            ); // Tanggal pengembalian yang dijadwalkan
                                            $now = \Carbon\Carbon::now(); // Waktu sekarang

                                            // Menghitung selisih waktu berdasarkan pengajuan dan pengembalian
                                            $sisa_hari = $now->diffInDays($tanggal_pengembalian, false);
                                            $sisa_jam = $now->diffInHours($tanggal_pengembalian, false) % 24; // Menghitung sisa jam setelah hari penuh
                                            $sisa_menit = $now->diffInMinutes($tanggal_pengembalian, false) % 60; // Menghitung sisa menit setelah jam penuh

                                            // Menghitung keterlambatan jika sudah lewat
                                            $terlambat_hari = $now->diffInDays($tanggal_pengembalian, false);
                                            $terlambat_jam = $now->diffInHours($tanggal_pengembalian, false) % 24;
                                            $terlambat_menit = $now->diffInMinutes($tanggal_pengembalian, false) % 60;
                                        @endphp
                                        @if ($tanggal_pengembalian->isToday())
                                            {{-- Jika tanggal pengembalian adalah hari ini --}}
                                            <span class="text-orange-500">Hari Terakhir</span>
                                        @elseif ($sisa_hari > 0)
                                            {{-- Jika lebih dari 0 hari, tampilkan hari dan jam --}}
                                            <span class="text-green-500">{{ floor($sisa_hari) }} hari
                                                @if ($sisa_jam > 0)
                                                    {{ floor($sisa_jam) }} jam lagi
                                                @else
                                                    lagi
                                                @endif
                                            </span>
                                        @elseif ($sisa_hari == 0 && $sisa_jam > 0)
                                            {{-- Jika masih dalam 1 hari, tampilkan jam --}}
                                            <span class="text-green-500">{{ floor($sisa_jam) }} jam lagi</span>
                                        @elseif ($sisa_hari == 0 && $sisa_menit > 0)
                                            {{-- Jika masih dalam 1 jam, tampilkan menit --}}
                                            <span class="text-green-500">{{ floor($sisa_menit) }} menit lagi</span>
                                        @elseif ($sisa_hari < 0)
                                            {{-- Sudah terlambat --}}
                                            @php
                                                $terlambat_hari = abs(floor($terlambat_hari));
                                            @endphp
                                            <span class="text-red-500">{{ $terlambat_hari }} hari terlambat</span>
                                        @elseif ($sisa_hari == 0 && $terlambat_jam < 0)
                                            {{-- Jika terlambat jam --}}
                                            @php
                                                $terlambat_jam = abs(floor($terlambat_jam));
                                            @endphp
                                            <span class="text-red-500">{{ $terlambat_jam }} jam terlambat</span>
                                        @elseif ($sisa_hari == 0 && $terlambat_menit < 0)
                                            {{-- Jika terlambat menit --}}
                                            @php
                                                $terlambat_menit = abs(floor($terlambat_menit));
                                            @endphp
                                            <span class="text-red-500">{{ $terlambat_menit }} menit terlambat</span>
                                        @endif
                                    </td>



                                    <td class="px-6 py-4">
                                        {{-- Tombol untuk setujui --}}
                                        <button type="button"
                                            class="setujuButton px-4 py-2 bg-green-500 text-white rounded-md hover:bg-green-600 transition"
                                            data-id="{{ $request->id }}">
                                            Setujui
                                        </button>
                                        {{-- Tombol untuk tolak --}}
                                        <button type="button"
                                            class="tolakButton px-4 py-2 bg-red-500 text-white rounded-md hover:bg-red-600 transition mt-2"
                                            data-id="{{ $request->id }}">
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

            // Event for individual Setujui button
            document.querySelectorAll('.setujuButton').forEach(button => {
                button.addEventListener('click', function() {
                    const requestId = button.getAttribute('data-id');
                    approveRequest(requestId);
                });
            });

            // Event for individual Tolak button
            document.querySelectorAll('.tolakButton').forEach(button => {
                button.addEventListener('click', function() {
                    const requestId = button.getAttribute('data-id');
                    rejectRequest(requestId);
                });
            });

            // Event for batch reject button
            batchRejectBtn.addEventListener('click', function() {
                batchRejectRequests();
            });

            function approveRequest(id) {
                Swal.fire({
                    title: "Apakah anda Yakin?",
                    text: "Apakah Yakin Akan Setujui Pengembalian Ini?",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#3085d6",
                    cancelButtonColor: "#d33",
                    confirmButtonText: "Ya, Setujui!"
                }).then((result) => {
                    if (result.isConfirmed) {
                        submitActionForm('{{ route('pengembalian.setujui', ':id') }}'.replace(':id', id));
                    }
                });
            }

            function rejectRequest(id) {
                Swal.fire({
                    title: "Tolak Pengembalian",
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
                        submitActionForm('{{ route('pengembalian.tolak', ':id') }}'.replace(':id', id),
                            result.value);
                    }
                });
            }

            function batchRejectRequests() {
                Swal.fire({
                    title: "Tolak Pengembalian",
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
                        document.querySelector('input[name="action"]').value = 'reject';
                        document.querySelector('input[name="alasan_penolakan"]').value = result.value;
                        batchForm.submit();
                    }
                });
            }

            function submitActionForm(actionUrl, reason = null) {
                const form = document.createElement('form');
                form.action = actionUrl;
                form.method = 'POST';
                form.innerHTML = '@csrf';
                if (reason) {
                    const alasanInput = document.createElement('input');
                    alasanInput.type = 'hidden';
                    alasanInput.name = 'alasan_penolakan';
                    alasanInput.value = reason;
                    form.appendChild(alasanInput);
                }
                document.body.appendChild(form);
                form.submit();
            }
        });
    </script>
@endsection
