@extends('layout.TemplatePeminjam')

@section('content')
    <div class="container mx-auto p-6">
        <!-- Tabs Navigasi -->
        <div class="tabs flex justify-center space-x-4 mb-8">
            <button onclick="switchTab('form')" id="tab-form"
                class="px-4 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600 transition">Ajukan Peminjaman</button>
            <button onclick="switchTab('history')" id="tab-history"
                class="px-4 py-2 bg-gray-200 text-gray-800 rounded-lg hover:bg-gray-300 transition">Histori
                Peminjaman</button>
        </div>

        <!-- Formulir Peminjaman -->
        <div id="form-tab" class="tab-content">
            <h1 class="text-3xl font-extrabold text-center text-gray-800 mb-8">Ajukan Peminjaman Ruangan</h1>
            <form method="POST" action="{{ route('peminjaman.store') }}"
                class="bg-white rounded-lg shadow-lg p-8 space-y-6 transition-all duration-300 ease-in-out transform hover:scale-105">
                @csrf
                <!-- Input Hidden untuk Peminjam ID -->
                <input type="hidden" name="peminjam_id" value="{{ Auth::user()->id }}">

                <!-- Pilih Ruangan -->
                <div class="mb-6">
                    <label for="ruangan_id" class="block text-lg font-semibold text-gray-700 flex items-center">
                        <i class="fas fa-door-open mr-2 text-blue-500"></i> Pilih Ruangan
                    </label>
                    <select id="ruangan_id" name="ruangan_id"
                        class="w-full border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-blue-300 py-3 mt-2 transition duration-300 ease-in-out hover:ring-blue-500">
                        <option value="" disabled selected>Pilih ruangan...</option>
                        @foreach ($ruangan_baik as $item)
                            <option value="{{ $item->id }}" data-fasilitas="{{ $item->fasilitas }}">{{ $item->nama }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Tampilkan Fasilitas -->
                <div class="mb-6">
                    <label for="fasilitas" class="block text-lg font-semibold text-gray-700 flex items-center">
                        <i class="fas fa-tools mr-2 text-green-500"></i> Fasilitas
                    </label>
                    <div id="fasilitas" class="p-4 border border-gray-300 rounded-lg bg-gray-100 text-gray-700">
                        Pilih ruangan untuk melihat fasilitas
                    </div>
                </div>

                <!-- Tanggal Mulai -->
                <div class="mb-6">
                    <label for="tanggal_mulai" class="block text-lg font-semibold text-gray-700 flex items-center">
                        <i class="fas fa-calendar-alt mr-2 text-purple-500"></i> Tanggal Mulai
                    </label>
                    <input type="datetime-local" id="tanggal_mulai" name="tanggal_mulai"
                        class="w-full border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-blue-300 py-3 mt-2 transition duration-300 ease-in-out hover:ring-blue-500"
                        required>
                </div>

                <!-- Tanggal Selesai -->
                <div class="mb-6">
                    <label for="tanggal_selesai" class="block text-lg font-semibold text-gray-700 flex items-center">
                        <i class="fas fa-calendar-check mr-2 text-green-500"></i> Tanggal Selesai
                    </label>
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

        <!-- Histori Peminjaman -->
        <div id="history-tab" class="tab-content hidden">
            <h2 class="text-2xl font-semibold text-center text-gray-800 mb-8">Histori Peminjaman Ruangan</h2>
            <div class="overflow-x-auto bg-white shadow-md rounded-lg">
                <table class="table-auto w-full text-left text-gray-800">
                    <thead class="bg-gray-200 text-gray-600 uppercase">
                        <tr>
                            <th class="px-4 py-2">Ruangan</th>
                            <th class="px-4 py-2">Tanggal Mulai</th>
                            <th class="px-4 py-2">Tanggal Selesai</th>
                            <th class="px-4 py-2">Durasi</th>
                            <th class="px-4 py-2">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($peminjaman as $item)
                            <tr class="border-t hover:bg-gray-100">
                                <td class="px-4 py-2">{{ $item->ruangan->nama }}</td>
                                <td class="px-4 py-2">{{ \Carbon\Carbon::parse($item->tanggal_mulai)->format('d M Y H:i') }}
                                </td>
                                <td class="px-4 py-2">
                                    {{ \Carbon\Carbon::parse($item->tanggal_selesai)->format('d M Y H:i') }}</td>
                                <td class="px-4 py-2">
                                    @php
                                        $mulai = \Carbon\Carbon::parse($item->tanggal_mulai);
                                        $selesai = \Carbon\Carbon::parse($item->tanggal_selesai);
                                        $totalMenit = $mulai->diffInMinutes($selesai);
                                        $hari = floor($totalMenit / 1440);
                                        $jam = floor(($totalMenit % 1440) / 60);
                                        $menit = $totalMenit % 60;
                                        $durasi =
                                            $hari > 0
                                                ? "$hari hari $jam jam"
                                                : ($jam > 0
                                                    ? "$jam jam $menit menit"
                                                    : "$menit menit");
                                    @endphp
                                    {{ $durasi }}
                                </td>
                                <td class="px-4 py-2">
                                    @if ($item->status === 'approved')
                                        <span class="text-green-500">Disetujui</span>
                                    @elseif ($item->status === 'rejected')
                                        <span class="text-red-500">Ditolak</span>
                                    @else
                                        <span class="text-yellow-500">Menunggu Persetujuan</span>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- FullCalendar -->
    <div class="container mx-auto mt-12">
        <h2 class="text-2xl font-semibold text-center text-gray-800 mb-8">Jadwal Peminjaman Ruangan</h2>
        <div id="calendar"></div>
    </div>

    <!-- JavaScript -->
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
                <p><strong>Nama Ruangan :</strong> ${event.title}</p>
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

        function switchTab(tab) {
            const formTab = document.getElementById('form-tab');
            const historyTab = document.getElementById('history-tab');
            const tabForm = document.getElementById('tab-form');
            const tabHistory = document.getElementById('tab-history');

            if (tab === 'form') {
                formTab.classList.remove('hidden');
                historyTab.classList.add('hidden');
                tabForm.classList.add('bg-blue-500', 'text-white');
                tabHistory.classList.remove('bg-blue-500', 'text-white');
            } else {
                formTab.classList.add('hidden');
                historyTab.classList.remove('hidden');
                tabHistory.classList.add('bg-blue-500', 'text-white');
                tabForm.classList.remove('bg-blue-500', 'text-white');
            }
        }
        document.addEventListener('DOMContentLoaded', function() {
            const selectRuangan = document.getElementById('ruangan_id');
            const fasilitasDiv = document.getElementById('fasilitas');

            // Event listener untuk perubahan pilihan ruangan
            selectRuangan.addEventListener('change', function() {
                const selectedOption = selectRuangan.options[selectRuangan.selectedIndex];
                const fasilitasJSON = selectedOption.getAttribute('data-fasilitas');

                if (fasilitasJSON) {
                    try {
                        // Parsing JSON dan membangun daftar fasilitas
                        const fasilitasList = JSON.parse(fasilitasJSON);
                        fasilitasDiv.innerHTML = `
                        <ul class="list-disc list-inside text-gray-700">
                            ${fasilitasList.map(item => `<li>${item}</li>`).join('')}
                        </ul>
                    `;
                    } catch (e) {
                        fasilitasDiv.innerHTML = '<p class="text-red-500">Fasilitas tidak valid</p>';
                    }
                } else {
                    fasilitasDiv.innerHTML =
                        '<p class="text-gray-500">Pilih ruangan untuk melihat fasilitas</p>';
                }
            });
        });
    </script>
@endsection
