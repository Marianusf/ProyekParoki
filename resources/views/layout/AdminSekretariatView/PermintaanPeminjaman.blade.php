@extends('layout.TemplateAdminSekretariat')

@section('content')
    <div class="container mx-auto p-6">
        <h1 class="text-2xl font-semibold mb-6">Kelola Peminjaman Ruangan</h1>

        <!-- Form Batch Action -->
        {{-- <form method="POST" action="{{ route('peminjaman.batchAction') }}"> --}}
        @csrf
        <div class="flex justify-between mb-4">
            <div class="flex items-center space-x-2">
                <input type="checkbox" id="selectAll" class="form-checkbox text-green-500">
                <label for="selectAll" class="text-sm text-gray-600">Pilih Semua</label>
            </div>
            <div class="flex space-x-4">
                <button type="submit" name="action" value="approve"
                    class="bg-green-500 text-white px-6 py-2 rounded-lg hover:bg-green-600">
                    Setujui Semua
                </button>
                <button type="submit" name="action" value="reject"
                    class="bg-red-500 text-white px-6 py-2 rounded-lg hover:bg-red-600">
                    Tolak Semua
                </button>
            </div>
        </div>

        <table class="table-auto w-full bg-white border rounded-lg shadow-lg">
            <thead class="bg-gray-200 text-gray-600 uppercase text-sm leading-normal">
                <tr>
                    <th class="py-3 px-6 text-left">
                        <input type="checkbox" id="selectAllRows" class="form-checkbox">
                    </th>
                    <th class="py-3 px-6 text-left">Nama Peminjam</th>
                    <th class="py-3 px-6 text-left">Ruangan</th>
                    <th class="py-3 px-6 text-left">Tanggal Mulai</th>
                    <th class="py-3 px-6 text-left">Tanggal Selesai</th>
                    <th class="py-3 px-6 text-center">Status</th>
                    <th class="py-3 px-6 text-center">Aksi</th>
                </tr>
            </thead>
            <tbody class="text-gray-600 text-sm font-light">
                @foreach ($peminjaman as $item)
                    <tr class="border-b border-gray-200 hover:bg-gray-100">
                        <td class="py-3 px-6 text-left whitespace-nowrap">
                            <input type="checkbox" name="selected_peminjaman[]" value="{{ $item->id }}"
                                class="form-checkbox">
                        </td>
                        <td class="py-3 px-6 text-left">{{ $item->peminjam->name }}</td>
                        <td class="py-3 px-6 text-left">{{ $item->ruangan->nama }}</td>
                        <td class="py-3 px-6 text-left">{{ $item->tanggal_mulai }}</td>
                        <td class="py-3 px-6 text-left">{{ $item->tanggal_selesai }}</td>
                        <td class="py-3 px-6 text-center">
                            <span
                                class="py-1 px-3 rounded-full text-xs font-bold 
                                    @if ($item->status_peminjaman === 'pending') bg-yellow-300 text-yellow-900
                                    @elseif ($item->status_peminjaman === 'disetujui') bg-green-300 text-green-900
                                    @elseif ($item->status_peminjaman === 'ditolak') bg-red-300 text-red-900
                                    @else bg-gray-300 text-gray-900 @endif">
                                {{ ucfirst($item->status_peminjaman) }}
                            </span>
                        </td>
                        <td class="py-3 px-6 text-center">
                            @if ($item->status_peminjaman === 'pending')
                                <div class="flex items-center justify-center space-x-4">
                                    {{-- Tombol Setujui --}}
                                    <form method="POST" action="{{ route('peminjaman.approve', $item->id) }}">
                                        @csrf
                                        <button type="submit"
                                            class="bg-green-500 text-white px-4 py-2 rounded-lg hover:bg-green-600">
                                            Setujui
                                        </button>
                                    </form>

                                    {{-- Tombol Tolak --}}
                                    <button onclick="showRejectionModal({{ $item->id }})"
                                        class="bg-red-500 text-white px-4 py-2 rounded-lg hover:bg-red-600">
                                        Tolak
                                    </button>
                                </div>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        </form> <!-- Form Batch Action End -->

        <!-- Modal Penolakan -->
        <div id="rejectionModal"
            class="hidden fixed z-50 inset-0 bg-gray-600 bg-opacity-50 flex justify-center items-center">
            <div class="bg-white rounded-lg shadow-lg p-6 w-96">
                <h3 class="text-xl font-semibold mb-4">Alasan Penolakan</h3>
                {{-- <form method="POST" action="{{ route('batch.Action') }}" id="rejectionForm"> --}}
                @csrf
                <textarea name="alasan_penolakan" class="w-full border rounded p-2 mb-4" placeholder="Masukkan alasan..." required></textarea>
                <input type="hidden" name="selected_peminjaman[]" id="selected_peminjaman_ids">
                <div class="flex justify-end space-x-4">
                    <button type="button" onclick="closeRejectionModal()"
                        class="bg-gray-500 text-white px-4 py-2 rounded-lg">
                        Batal
                    </button>
                    <button type="submit" class="bg-red-500 text-white px-4 py-2 rounded-lg hover:bg-red-600">
                        Kirim
                    </button>
                </div>
                </form>
            </div>
        </div>

    </div>

    <script>
        // Menampilkan Modal Penolakan
        function showRejectionModal(id) {
            const selectedIds = document.querySelectorAll('input[name="selected_peminjaman[]"]:checked');
            const selectedIdsArray = Array.from(selectedIds).map(checkbox => checkbox.value);
            document.getElementById('selected_peminjaman_ids').value = selectedIdsArray.join(',');

            const form = document.getElementById('rejectionForm');
            form.action = `/peminjaman/batch-reject`; // Sesuaikan dengan route untuk batch reject
            document.getElementById('rejectionModal').classList.remove('hidden');
        }

        // Menutup Modal Penolakan
        function closeRejectionModal() {
            document.getElementById('rejectionModal').classList.add('hidden');
        }

        // Select/Deselect All Checkboxes
        document.getElementById('selectAll').addEventListener('change', function(e) {
            const checkboxes = document.querySelectorAll('input[name="selected_peminjaman[]"]');
            checkboxes.forEach(checkbox => checkbox.checked = e.target.checked);
        });
    </script>
@endsection
