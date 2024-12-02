@extends('layout.TemplateAdminSekretariat')

@section('title', isset($ruangan) ? 'Edit Ruangan' : 'Tambah Ruangan')

@section('content')
    <div class="py-8 px-4 mx-auto max-w-7xl lg:py-8 rounded-lg bg-gray-100">
        <h2 class="mb-6 text-2xl font-bold text-center">{{ isset($ruangan) ? 'Edit Ruangan' : 'Tambah Ruangan' }}</h2>

        @if (session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                <strong class="font-bold">Sukses: </strong>
                <span class="block sm:inline">{{ session('success') }}</span>
            </div>
        @endif
        @if (session('message'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                <strong class="font-bold">Sukses: </strong>
                <span class="block sm:inline">{{ session('message') }}</span>
            </div>
        @endif
        @if (session('error'))
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
                <strong class="font-bold">Error: </strong>
                <span class="block sm:inline">{{ session('error') }}</span>
            </div>
        @endif

        <form action="{{ isset($ruangan) ? route('ruangan.update', $ruangan->id) : route('ruangan.store') }}" method="POST"
            enctype="multipart/form-data">
            @csrf
            @if (isset($ruangan))
                @method('PUT')
            @endif

            <div class="grid gap-4 sm:grid-cols-2 sm:gap-6">
                <!-- Nama Ruangan -->
                <div class="sm:col-span-2">
                    <label for="nama" class="block text-sm font-medium text-gray-700">Nama Ruangan</label>
                    <input type="text" name="nama" id="nama" value="{{ old('nama', $ruangan->nama ?? '') }}"
                        class="bg-gray-50 border border-gray-300 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5"
                        required>
                    @error('nama')
                        <p class="text-red-500 text-xs mt-2">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Kapasitas Ruangan -->
                <div class="sm:col-span-1">
                    <label for="kapasitas" class="block text-sm font-medium text-gray-700">Kapasitas Ruangan</label>
                    <input type="number" name="kapasitas" id="kapasitas"
                        value="{{ old('kapasitas', $ruangan->kapasitas ?? '') }}"
                        class="bg-gray-50 border border-gray-300 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5"
                        required>
                    @error('kapasitas')
                        <p class="text-red-500 text-xs mt-2">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Kondisi Ruangan -->
                <div class="sm:col-span-1">
                    <label for="kondisi" class="block text-sm font-medium text-gray-700">Kondisi Ruangan</label>
                    <select id="kondisi" name="kondisi"
                        class="bg-gray-50 border border-gray-300 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5"
                        required>
                        <option value="baik" {{ old('kondisi', $ruangan->kondisi ?? '') == 'baik' ? 'selected' : '' }}>
                            Baik</option>
                        <option value="dalam_perbaikan"
                            {{ old('kondisi', $ruangan->kondisi ?? '') == 'dalam_perbaikan' ? 'selected' : '' }}>Dalam
                            Perbaikan</option>
                    </select>
                    @error('kondisi')
                        <p class="text-red-500 text-xs mt-2">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Deskripsi Ruangan -->
                <div class="sm:col-span-2">
                    <label for="deskripsi" class="block text-sm font-medium text-gray-700">Deskripsi Ruangan</label>
                    <textarea id="deskripsi" name="deskripsi" rows="4"
                        class="bg-gray-50 border border-gray-300 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5"
                        required>{{ old('deskripsi', $ruangan->deskripsi ?? '') }}</textarea>
                    @error('deskripsi')
                        <p class="text-red-500 text-xs mt-2">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Fasilitas Ruangan -->
                <div class="sm:col-span-2">
                    <label for="fasilitas" class="block text-sm font-medium text-gray-700">Fasilitas Ruangan</label>
                    <div id="fasilitas-container">
                        @foreach (old('fasilitas', isset($fasilitas) ? $fasilitas : []) as $index => $fasilitasItem)
                            <div class="fasilitas-item mb-2 flex items-center">
                                <input type="text" name="fasilitas[]" value="{{ $fasilitasItem }}"
                                    class="form-input mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-2 focus:ring-blue-500"
                                    placeholder="Masukkan fasilitas" required />
                                <button type="button" class="remove-fasilitas text-red-500 ml-2">Hapus</button>
                            </div>
                        @endforeach
                    </div>
                    <button type="button" id="tambah-fasilitas" class="text-blue-500 mt-2">Tambah Fasilitas</button>
                    @error('fasilitas.*')
                        <p class="text-red-500 text-xs mt-2">{{ $message }}</p>
                    @enderror
                </div>
                <div class="sm:col-span-2">
                    <label for="gambar" class="block text-sm font-medium text-gray-700">Gambar Ruangan</label>
                    <input type="file" name="gambar" id="gambar"
                        class="bg-gray-50 border border-gray-300 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5">
                    @error('gambar')
                        <p class="text-red-500 text-xs mt-2">{{ $message }}</p>
                    @enderror

                    <!-- Preview Gambar -->
                    <div id="gambar-preview" class="mt-4">
                        @if (isset($ruangan) && $ruangan->gambar)
                            <img src="{{ asset('storage/' . $ruangan->gambar) }}" alt="Preview Gambar"
                                class="w-32 h-32 object-cover rounded-lg">
                        @else
                            <img id="preview-img" class="hidden w-32 h-32 object-cover rounded-lg" />
                        @endif
                    </div>
                </div>
            </div>

            <div class="mt-6">
                <button type="submit"
                    class="bg-blue-600 text-white py-2.5 px-5 rounded-lg hover:bg-blue-700 focus:ring-4 focus:ring-blue-200">
                    {{ isset($ruangan) ? 'Update Ruangan' : 'Tambah Ruangan' }}
                </button>
                <a href="{{ request()->routeIs('ruangan.edit') ? route('lihatSemuaRuangan') : route('ruangan.create') }}"
                    class="ml-4 bg-red-600 text-white py-2.5 px-5 rounded-lg hover:bg-red-700 focus:ring-4 focus:ring-red-200">
                    Batal
                </a>

            </div>
        </form>
    </div>

    <script>
        // Menambah fasilitas baru
        document.getElementById('tambah-fasilitas').addEventListener('click', function() {
            let fasilitasContainer = document.getElementById('fasilitas-container');
            let fasilitasItem = document.createElement('div');
            fasilitasItem.classList.add('fasilitas-item', 'mb-2', 'flex', 'items-center');
            fasilitasItem.innerHTML = `
            <input type="text" name="fasilitas[]" class="form-input mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-2 focus:ring-blue-500" placeholder="Masukkan fasilitas" required />
            <button type="button" class="remove-fasilitas text-red-500 ml-2">Hapus</button>
        `;
            fasilitasContainer.appendChild(fasilitasItem);
        });

        // Menghapus fasilitas yang ada
        document.addEventListener('click', function(event) {
            if (event.target.classList.contains('remove-fasilitas')) {
                event.target.closest('.fasilitas-item').remove();
            }
        });
        document.getElementById('gambar').addEventListener('change', function(event) {
            const file = event.target.files[0];
            const previewImg = document.getElementById('preview-img');
            const previewContainer = document.getElementById('gambar-preview');

            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    previewImg.src = e.target.result;
                    previewImg.classList.remove('hidden');
                    previewContainer.appendChild(previewImg);
                };
                reader.readAsDataURL(file);
            }
        });
    </script>
@endsection
