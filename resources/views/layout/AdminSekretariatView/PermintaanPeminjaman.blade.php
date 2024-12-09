@extends('layout.TemplateAdminSekretariat') {{-- Menggunakan template admin --}}
@section('content')
    <div class="container mx-auto p-6">
        <h1 class="text-2xl font-semibold mb-6">Kelola Peminjaman Ruangan</h1>

        <table class="table-auto w-full bg-white border rounded-lg shadow-lg">
            <thead class="bg-gray-200 text-gray-600 uppercase text-sm leading-normal">
                <tr>
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
                        <td class="py-3 px-6 text-left whitespace-nowrap">{{ $item->peminjam->name }}</td>
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
                                <div class="flex item-center justify-center space-x-4">
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
    </div>

    {{-- Modal Penolakan --}}
    <div id="rejectionModal" class="hidden fixed z-50 inset-0 bg-gray-600 bg-opacity-50 flex justify-center items-center">
        <div class="bg-white rounded-lg shadow-lg p-6 w-96">
            <h3 class="text-xl font-semibold mb-4">Alasan Penolakan</h3>
            <form method="POST" action="" id="rejectionForm">
                @csrf
                <textarea name="alasan_penolakan" class="w-full border rounded p-2 mb-4" placeholder="Masukkan alasan..." required></textarea>
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

    <script>
        function showRejectionModal(id) {
            const form = document.getElementById('rejectionForm');
            form.action = `/peminjaman/${id}/reject`; // Sesuaikan route
            document.getElementById('rejectionModal').classList.remove('hidden');
        }

        function closeRejectionModal() {
            document.getElementById('rejectionModal').classList.add('hidden');
        }
    </script>
@endsection
