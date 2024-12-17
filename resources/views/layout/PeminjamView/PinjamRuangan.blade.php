@extends('layout.TemplatePeminjam')
@section('title', 'Pinjam Ruangan')
@section('content')
    <div class="container mx-auto p-6">
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

        <button onclick="window.location.reload();"
            class="bg-transparent text-blue-500 hover:text-blue-700 p-2 rounded-full transition duration-200 ease-in-out"
            title="Refresh halaman">
            <i class="fas fa-sync-alt text-xl"></i> <!-- Ikon refresh -->
        </button>
        <!-- Formulir Peminjaman -->
        <div id="form-tab" class="tab-content">
            <h1 class="text-3xl font-extrabold text-center text-gray-800 mb-8">Ajukan Peminjaman Ruangan</h1>

            <form method="POST" action="{{ route('peminjaman.store') }}"
                class="bg-white rounded-lg shadow-lg p-8 space-y-6 transition-all duration-300 ease-in-out transform hover:scale-105">
                @csrf

                <!-- Input Hidden untuk Peminjam ID -->
                <input type="hidden" name="peminjam_id" value="{{ Auth::user()->id }}">
                <div class="container mx-auto py-10 px-4">
                    <div class="mb-6">
                        <!-- Dropdown Pilih Ruangan -->
                        <label for="ruangan_id" class="block text-lg font-semibold text-gray-700 flex items-center">
                            <i class="fas fa-door-open mr-2 text-blue-500"></i> Pilih Ruangan
                        </label>
                        <select id="ruangan_id" name="ruangan_id"
                            class="w-full border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-blue-300 py-3 mt-2 transition duration-300 ease-in-out hover:ring-blue-500">
                            <option value="" disabled selected>Pilih ruangan...</option>
                            @foreach ($ruangan_baik as $ruang)
                                <option value="{{ $ruang->id }}" data-fasilitas="{{ json_encode($ruang->fasilitas) }}">
                                    {{ $ruang->nama }}
                                </option>
                            @endforeach
                        </select>

                        <!-- Detail Fasilitas -->
                        <div id="fasilitas_container" class="mt-6 p-6 bg-gray-100 rounded-lg shadow hidden">
                            <h3 class="text-xl font-bold text-gray-700 mb-4">Detail Fasilitas</h3>
                            <ul id="fasilitas_list" class="list-disc list-inside text-gray-600 space-y-2"></ul>
                        </div>
                    </div>
                </div>
                <!-- Tanggal Mulai -->
                <div class="mb-6">
                    <label for="tanggal_mulai" class="block text-lg font-semibold text-gray-700 flex items-center">
                        <i class="fas fa-calendar-alt mr-2 text-blue-500"></i> Tanggal Mulai
                    </label>
                    <input type="datetime-local" id="tanggal_mulai" name="tanggal_mulai"
                        class="w-full border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-blue-300 py-3 mt-2 transition duration-300 ease-in-out hover:ring-blue-500"
                        value="{{ old('tanggal_mulai') }}">
                    @error('tanggal_mulai')
                        <div class="text-red-500 text-sm mt-2">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Tanggal Selesai -->
                <div class="mb-6">
                    <label for="tanggal_selesai" class="block text-lg font-semibold text-gray-700 flex items-center">
                        <i class="fas fa-calendar-check mr-2 text-blue-500"></i> Tanggal Selesai
                    </label>
                    <input type="datetime-local" id="tanggal_selesai" name="tanggal_selesai"
                        class="w-full border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-blue-300 py-3 mt-2 transition duration-300 ease-in-out hover:ring-blue-500"
                        value="{{ old('tanggal_selesai') }}">
                    @error('tanggal_selesai')
                        <div class="text-red-500 text-sm mt-2">{{ $message }}</div>
                    @enderror
                </div>
                <!-- Tujuan Peminjaman -->
                <div class="mb-6">
                    <label for="tujuan_peminjaman" class="block text-lg font-semibold text-gray-700 flex items-center">
                        <i class="fas fa-info-circle mr-2 text-blue-500"></i> Tujuan Peminjaman
                    </label>
                    <textarea id="tujuan_peminjaman" name="tujuan_peminjaman" rows="4"
                        class="w-full border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-blue-300 py-3 mt-2 transition duration-300 ease-in-out hover:ring-blue-500"
                        placeholder="Jelaskan tujuan peminjaman ruangan...">{{ old('tujuan_peminjaman') }}</textarea>

                    @error('tujuan_peminjaman')
                        <div class="text-red-500 text-sm mt-2">{{ $message }}</div>
                    @enderror
                </div>


                <!-- Button Submit -->
                <div class="mb-6">
                    <button type="submit"
                        class="w-full bg-blue-500 text-white py-3 rounded-lg text-lg font-semibold transition-all duration-300 hover:bg-blue-600">
                        Ajukan Peminjaman
                    </button>

                </div>

            </form>

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

        document.addEventListener('DOMContentLoaded', function() {
            const ruanganSelect = document.getElementById('ruangan_id');
            const fasilitasContainer = document.getElementById('fasilitas_container');
            const fasilitasList = document.getElementById('fasilitas_list');

            // Event listener untuk dropdown
            ruanganSelect.addEventListener('change', function() {
                const selectedOption = ruanganSelect.options[ruanganSelect.selectedIndex];
                const fasilitasJSON = selectedOption.getAttribute('data-fasilitas');

                if (fasilitasJSON) {
                    try {
                        // Parse JSON data-fasilitas
                        const fasilitasArray = JSON.parse(fasilitasJSON);

                        // Clear list sebelumnya
                        fasilitasList.innerHTML = '';

                        // Tambahkan fasilitas ke list
                        fasilitasArray.forEach(item => {
                            const listItem = document.createElement('li');
                            listItem.classList.add('flex', 'items-center', 'gap-2');

                            listItem.innerHTML = `
                            <i class="fas fa-check-circle text-green-500"></i>
                            <span>${item}</span>
                        `;
                            fasilitasList.appendChild(listItem);
                        });

                        // Tampilkan container fasilitas
                        fasilitasContainer.classList.remove('hidden');
                    } catch (e) {
                        console.error("Error parsing JSON:", e);
                        fasilitasList.innerHTML = '<li class="text-red-500">Gagal memuat fasilitas</li>';
                        fasilitasContainer.classList.remove('hidden');
                    }
                } else {
                    fasilitasList.innerHTML =
                        '<li class="text-gray-500 italic">Tidak ada fasilitas tersedia.</li>';
                    fasilitasContainer.classList.remove('hidden');
                }
            });
        });
    </script>
@endsection
