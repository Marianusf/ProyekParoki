@extends('layout.TemplatePeminjam')
@section('title', 'profileku')
@section('content')
    <section class="p-6 bg-gray-100 min-h-screen place-items-center">
        <div class="bg-white w-full max-w-7xl p-6 rounded-lg shadow-md border border-black">
            <h2 class="text-2xl font-semibold text-gray-800 mb-2">Profil</h2>
            <p class="text-gray-500 mb-4">PAROKI ST PETRUS DAN PAULUS</p>

            <div class="flex justify-center mb-6">
                <div class="w-24 h-24 rounded-full bg-gray-200 flex items-center justify-center">
                    <img src="{{ asset('storage/' . $peminjam->profile_picture) }}" alt="Profile Picture"
                        class="rounded-full w-full h-full object-cover">
                </div>
            </div>

            <form action="" method="POST" id="profilForm">
                @csrf
                @method('PUT')

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <!-- Nama Lengkap -->
                    <div>
                        <label class="block text-sm text-gray-600">Nama Lengkap</label>
                        <div id="viewNamaLengkap" class="text-gray-700">{{ $peminjam->name }}</div>
                        <input type="text" name="nama_lengkap" value="{{ $peminjam->name }}"
                            class="w-full bg-gray-100 border border-gray-200 rounded p-2 text-gray-700 hidden"
                            id="editNamaLengkap">
                    </div>

                    <div>
                        <label class="block text-sm text-gray-600">Email</label>
                        <div id="viewEmail" class="text-gray-700">{{ $peminjam->email }}</div>
                        <input type="email" name="email" value="{{ $peminjam->email }}"
                            class="w-full bg-gray-100 border border-gray-200 rounded p-2 text-gray-700 hidden"
                            id="editEmail">
                    </div>

                    <div>
                        <label class="block text-sm text-gray-600">Tanggal Lahir</label>
                        <div id="viewTanggalLahir" class="text-gray-700">
                            {{ \Carbon\Carbon::parse($peminjam->tanggal_lahir)->format('d-m-Y') }}
                        </div>
                        <input type="date" name="tanggal_lahir" value="{{ $peminjam->tanggal_lahir }}"
                            class="w-full bg-gray-100 border border-gray-200 rounded p-2 text-gray-700 hidden"
                            id="editTanggalLahir">
                    </div>

                    <div>
                        <label class="block text-sm text-gray-600">Nomor Telepon</label>
                        <div id="viewNomorTelepon" class="text-gray-700">{{ $peminjam->nomor_telepon }}</div>
                        <input type="text" name="nomor_telepon" value="{{ $peminjam->nomor_telepon }}"
                            class="w-full bg-gray-100 border border-gray-200 rounded p-2 text-gray-700 hidden"
                            id="editNomorTelepon">
                    </div>
                    <div>
                        <label class="block text-sm text-gray-600">Lingkungan</label>
                        <div id="viewLingkungan" class="text-gray-700">{{ $peminjam->lingkungan }}</div>
                        <input type="text" name="lingkungan" value="{{ $peminjam->lingkungan }}"
                            class="w-full bg-gray-100 border border-gray-200 rounded p-2 text-gray-700 hidden"
                            id="editLingkungan">
                    </div>
                    <div>
                        <label class="block text-sm text-gray-600">Alamat</label>
                        <div id="viewAlamat" class="text-gray-700">{{ $peminjam->alamat }}</div>
                        <input type="text" name="alamat" value="{{ $peminjam->alamat }}"
                            class="w-full bg-gray-100 border border-gray-200 rounded p-2 text-gray-700 hidden"
                            id="editAlamat">
                    </div>
                </div>

                <!-- Tombol -->
                <div class="flex justify-center space-x-5 mt-6">
                    <button type="button" id="editButton"
                        class="bg-blue-500 hover:bg-blue-600 text-white py-2 px-4 rounded">
                        Edit
                    </button>
                    <button type="submit" id="saveButton"
                        class="bg-green-500 hover:bg-green-600 text-white py-2 px-4 rounded hidden">
                        Simpan
                    </button>
                    <button type="button" id="cancelButton"
                        class="bg-red-500 hover:bg-red-600 text-white py-2 px-4 rounded hidden">
                        Batal
                    </button>
                </div>
            </form>
        </div>
        <script>
            document.addEventListener('DOMContentLoaded', () => {
                const editButton = document.getElementById('editButton');
                const saveButton = document.getElementById('saveButton');
                const cancelButton = document.getElementById('cancelButton');
                const viewElements = document.querySelectorAll('[id^="view"]');
                const editElements = document.querySelectorAll('[id^="edit"]');

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

                // Event Listener
                editButton.addEventListener('click', enableEditMode);
                cancelButton.addEventListener('click', disableEditMode);
            });
        </script>
    @endsection
