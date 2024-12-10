@extends('layout.TemplatePeminjam') {{-- Layout utama untuk peminjam --}}

@section('content')
    <div class="container mx-auto p-6">
        <h1 class="text-3xl font-extrabold text-center text-gray-800 mb-8">Ajukan Peminjaman Ruangan</h1>

        <!-- Form Peminjaman Ruangan -->
        <form method="POST" action="{{ route('peminjaman.store') }}"
            class="bg-white rounded-lg shadow-lg p-8 space-y-6 transition-all duration-300 ease-in-out transform hover:scale-105">
            @csrf
            <!-- Input Hidden untuk Peminjam ID -->
            <input type="hidden" name="peminjam_id" value="{{ Auth::user()->id }}">

            <!-- Pilih Ruangan -->
            <div class="mb-6">
                <label for="ruangan_id" class="block text-lg font-semibold text-gray-700">Pilih Ruangan</label>
                <select id="ruangan_id" name="ruangan_id"
                    class="w-full border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-blue-300 py-3 mt-2 transition duration-300 ease-in-out hover:ring-blue-500">
                    @foreach ($ruangan_baik as $item)
                        <option value="{{ $item->id }}">{{ $item->nama }}</option>
                    @endforeach
                </select>
            </div>

            <!-- Tanggal Mulai -->
            <div class="mb-6">
                <label for="tanggal_mulai" class="block text-lg font-semibold text-gray-700">Tanggal Mulai</label>
                <input type="datetime-local" id="tanggal_mulai" name="tanggal_mulai"
                    class="w-full border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-blue-300 py-3 mt-2 transition duration-300 ease-in-out hover:ring-blue-500"
                    required>
            </div>

            <!-- Tanggal Selesai -->
            <div class="mb-6">
                <label for="tanggal_selesai" class="block text-lg font-semibold text-gray-700">Tanggal Selesai</label>
                <input type="datetime-local" id="tanggal_selesai" name="tanggal_selesai"
                    class="w-full border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-blue-300 py-3 mt-2 transition duration-300 ease-in-out hover:ring-blue-500"
                    required>
            </div>

            <!-- Submit Button -->
            <div class="text-right">
                <button type="submit"
                    class="bg-blue-500 text-white px-6 py-3 rounded-lg hover:bg-blue-600 transition duration-200 transform hover:scale-105">
                    Ajukan Peminjaman
                </button>
            </div>
        </form>
    </div>

    <!-- Jadwal Peminjaman Ruangan -->
    <div class="container mx-auto mt-12">
        <h2 class="text-2xl font-semibold text-center text-gray-800 mb-8">Jadwal Peminjaman Ruangan</h2>
        <div id="calendar"></div>
    </div>

    <!-- SweetAlert Success -->
    @if (session('success'))
        <script>
            Swal.fire({
                icon: 'success',
                title: 'Berhasil',
                text: '{{ session('success') }}',
                confirmButtonText: 'Tutup'
            });
        </script>
    @endif
    @if (session('error'))
        <script>
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: '{{ session('error') }}',
                confirmButtonText: 'Tutup'
            });
        </script>
    @endif

    <!-- FullCalendar -->
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.0/main.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.0/main.min.css" rel="stylesheet" />

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var calendarEl = document.getElementById('calendar');

            var calendar = new FullCalendar.Calendar(calendarEl, {
                headerToolbar: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'dayGridMonth,timeGridWeek,timeGridDay'
                },
                initialView: 'dayGridMonth',
                events: {!! json_encode($events) !!}, // Data dari controller

                dateClick: function(info) {
                    // Isi tanggal peminjaman berdasarkan tanggal yang diklik di kalender
                    document.getElementById('tanggal_mulai').value = info.dateStr;
                    document.getElementById('tanggal_selesai').value = info.dateStr;
                },

                eventClick: function(info) {
                    var event = info.event;

                    // Menyiapkan detail event untuk SweetAlert
                    var startDate = event.start.toLocaleDateString('id-ID', {
                        day: '2-digit',
                        month: '2-digit',
                        year: 'numeric',
                        hour: '2-digit',
                        minute: '2-digit',
                    });
                    var endDate = event.end ? event.end.toLocaleDateString('id-ID', {
                        day: '2-digit',
                        month: '2-digit',
                        year: 'numeric',
                        hour: '2-digit',
                        minute: '2-digit',
                    }) : 'Belum selesai';

                    var peminjamanDetail = `
                <p><strong>Peminjam:</strong> ${event.title}</p>
                <p><strong>Tanggal Mulai:</strong> ${startDate}</p>
                <p><strong>Tanggal Selesai:</strong> ${endDate}</p>
                <p><strong>Status:</strong> ${event.extendedProps.status || 'Menunggu Persetujuan'}</p>
            `;

                    // Menampilkan detail peminjaman dengan SweetAlert
                    Swal.fire({
                        title: 'Detail Peminjaman',
                        html: peminjamanDetail,
                        icon: 'info',
                        confirmButtonText: 'Tutup'
                    });
                }
            });

            calendar.render();
        });
    </script>
@endsection
