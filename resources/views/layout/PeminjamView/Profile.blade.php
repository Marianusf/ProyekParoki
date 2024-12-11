@extends('layout.TemplatePeminjam')
@section('title', 'profileku')
@section('content')
    <section class="min-h-screen bg-gradient-to-tr from-gray-100 to-gray-300 py-12 flex justify-center items-center">
        <div class="bg-white w-full max-w-4xl p-8 rounded-xl shadow-lg">
            {{-- Header --}}
            <div class="flex flex-col items-center mb-8">
                <h2 class="text-3xl font-bold text-gray-800 flex items-center gap-3">
                    <i class="fas fa-user-circle text-blue-600"></i> Profil Saya
                </h2>
                <p class="text-sm text-gray-500">Paroki St Petrus dan Paulus</p>
            </div>
            <hr class="mb-6 border-gray-300">

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

            @if (session('message'))
                <script>
                    Swal.fire({
                        icon: 'info',
                        title: 'PESAN:',
                        text: '{{ session('message') }}',
                        confirmButtonText: 'OK'
                    });
                </script>
            @endif

            @if (session('error'))
                <script>
                    Swal.fire({
                        icon: 'error',
                        title: 'Error:',
                        text: '{{ session('error') }}',
                        confirmButtonText: 'OK'
                    });
                </script>
            @endif



            <form action="{{ route('profile.update') }}" method="POST" id="profilForm" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="flex justify-center mb-8">
                    <div class="relative w-36 h-36 rounded-full shadow-md overflow-hidden">
                        <img src="{{ $peminjam->poto_profile ? asset('storage/' . $peminjam->poto_profile) : asset('default.png') }}"
                            alt="Foto Profil" class="w-full h-full object-cover">
                        <label for="editFotoProfil"
                            class="absolute bottom-2 right-2 bg-blue-500 text-white rounded-full p-2 cursor-pointer hover:bg-blue-600 transition duration-200">
                            <i class="fas fa-camera"></i>
                        </label>
                    </div>
                    <input type="file" name="poto_profile" id="editFotoProfil" class="hidden">
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    {{-- Loop untuk menampilkan fields --}}
                    @php
                        $fields = [
                            [
                                'label' => 'Nama Lengkap',
                                'name' => 'name',
                                'value' => $peminjam->name,
                                'icon' => 'fas fa-user',
                            ],
                            [
                                'label' => 'Email',
                                'name' => 'email',
                                'value' => $peminjam->email,
                                'icon' => 'fas fa-envelope',
                            ],
                            [
                                'label' => 'Tanggal Lahir',
                                'name' => 'tanggal_lahir',
                                'value' => \Carbon\Carbon::parse($peminjam->tanggal_lahir)->format('Y-m-d'), // Format View
                                'icon' => 'fas fa-calendar-alt',
                                'type' => 'date',
                                'inputValue' => old(
                                    'tanggal_lahir',
                                    \Carbon\Carbon::parse($peminjam->tanggal_lahir)->format('d-m-Y'), // Format untuk input date
                                ), // Format Input untuk date input
                            ],

                            [
                                'label' => 'Nomor Telepon',
                                'name' => 'nomor_telepon',
                                'value' => $peminjam->nomor_telepon,
                                'icon' => 'fas fa-phone',
                            ],
                            [
                                'label' => 'Lingkungan',
                                'name' => 'lingkungan',
                                'value' => $peminjam->lingkungan,
                                'icon' => 'fas fa-home',
                            ],
                            [
                                'label' => 'Alamat',
                                'name' => 'alamat',
                                'value' => $peminjam->alamat,
                                'icon' => 'fas fa-map-marker-alt',
                            ],
                        ];
                    @endphp

                    @foreach ($fields as $field)
                        <div>
                            <label class="block text-sm font-semibold text-gray-600 mb-2 flex items-center gap-2">
                                <i class="{{ $field['icon'] }} text-blue-500"></i> {{ $field['label'] }}
                            </label>
                            <div id="view{{ ucfirst($field['name']) }}" class="text-gray-800 font-medium">
                                {{ $field['value'] }}
                            </div>
                            <input type="{{ $field['type'] ?? 'text' }}" name="{{ $field['name'] }}"
                                value="{{ old($field['name'], $field['value']) }}"
                                class="w-full bg-gray-100 border border-gray-300 rounded-lg p-2 text-gray-700 hidden focus:ring-2 focus:ring-blue-500 transition duration-150"
                                id="edit{{ ucfirst($field['name']) }}">
                        </div>
                    @endforeach
                </div>

                {{-- Sticky Footer Buttons --}}
                <div class="flex justify-center space-x-4 mt-10 sticky bottom-4 bg-white py-4">
                    <button type="button" id="editButton"
                        class="flex items-center gap-2 bg-blue-600 hover:bg-blue-700 text-white py-2 px-6 rounded-lg shadow-md transition duration-200 flex-grow-0 flex-shrink-0">
                        <i class="fas fa-edit"></i> Edit
                    </button>
                    <button type="submit" id="saveButton"
                        class="flex items-center gap-2 bg-green-500 hover:bg-green-600 text-white py-2 px-6 rounded-lg shadow-md hidden transition duration-200 flex-grow-0 flex-shrink-0">
                        <i class="fas fa-save"></i> Simpan
                    </button>
                    <button type="button" id="cancelButton"
                        class="flex items-center gap-2 bg-red-500 hover:bg-red-600 text-white py-2 px-6 rounded-lg shadow-md hidden transition duration-200 flex-grow-0 flex-shrink-0">
                        <i class="fas fa-times"></i> Batal
                    </button>
                </div>

            </form>

        </div>
    </section>
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const editButton = document.getElementById('editButton');
            const saveButton = document.getElementById('saveButton');
            const cancelButton = document.getElementById('cancelButton');
            const viewElements = document.querySelectorAll('[id^="view"]');
            const editElements = document.querySelectorAll('[id^="edit"]');
            const inputs = document.querySelectorAll('[name]'); // Mengambil semua input

            // Fungsi untuk masuk ke mode edit
            const enableEditMode = () => {
                viewElements.forEach(el => el.classList.add('hidden'));
                editElements.forEach(el => el.classList.remove('hidden'));
                editButton.classList.add('hidden');
                saveButton.classList.remove('hidden');
                cancelButton.classList.remove('hidden');
            };

            // Fungsi untuk keluar dari mode edit
            const disableEditMode = () => {
                viewElements.forEach(el => el.classList.remove('hidden'));
                editElements.forEach(el => el.classList.add('hidden'));
                editButton.classList.remove('hidden');
                saveButton.classList.add('hidden');
                cancelButton.classList.add('hidden');
            };

            // Event Listener untuk tombol Edit
            editButton.addEventListener('click', () => {
                Swal.fire({
                    title: 'Apakah Anda Yakin?',
                    text: 'Anda akan mulai mengedit profil Anda!',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Ya, Edit!',
                    cancelButtonText: 'Batal',
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                }).then((result) => {
                    if (result.isConfirmed) {
                        enableEditMode(); // Masuk ke mode edit hanya setelah konfirmasi
                    }
                });
            });

            // Event Listener untuk tombol Cancel
            cancelButton.addEventListener('click', (event) => {
                event.preventDefault();

                Swal.fire({
                    title: 'Apakah Anda Yakin?',
                    text: 'Perubahan akan dibatalkan dan tidak akan disimpan!',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Ya, Batal!',
                    cancelButtonText: 'Tidak, Kembali',
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                }).then((result) => {
                    if (result.isConfirmed) {
                        disableEditMode(); // Kembali ke mode awal hanya setelah konfirmasi
                    }
                });
            });

            // Event Listener untuk tombol Simpan
            saveButton.addEventListener('click', (event) => {
                event.preventDefault();

                Swal.fire({
                    title: 'Apakah Anda Yakin?',
                    text: 'Perubahan profil Anda akan disimpan!',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Ya, Simpan!',
                    cancelButtonText: 'Batal',
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                }).then((result) => {
                    if (result.isConfirmed) {
                        document.getElementById('profilForm')
                            .submit(); // Submit form jika konfirmasi diterima
                    }
                });
            });

            // Perubahan input akan menampilkan tombol simpan
            inputs.forEach(input => {
                input.addEventListener('input', () => {
                    saveButton.classList.remove('hidden'); // Tampilkan tombol Simpan
                });
            });
        });
    </script>
@endsection
