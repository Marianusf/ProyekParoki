@extends('layout.TemplateAdmin')

@section('title', isset($asset) ? 'Edit Asset' : 'Tambah Asset')

@section('content')
    <div class="container mx-auto px-6 py-8">
        <h2 class="text-3xl font-semibold text-center mb-8 text-gray-800">{{ isset($asset) ? 'Edit Asset' : 'Tambah Asset' }}
        </h2>

        <!-- Menampilkan notifikasi sukses jika ada -->
        @if (session('success'))
            <div class="bg-green-500 text-white p-4 rounded-lg mb-6">
                {{ session('success') }}
            </div>
        @endif

        <form action="{{ isset($asset) ? route('asset.update', $asset->id) : route('asset.store') }}" method="POST"
            enctype="multipart/form-data">
            @csrf
            @if (isset($asset))
                @method('PUT')
            @endif

            <!-- Nama Barang -->
            <div class="mb-6">
                <label for="nama_barang" class="block text-sm font-medium text-gray-700">Nama Barang</label>
                <input type="text"
                    class="mt-2 block w-full border-2 border-gray-300 rounded-md p-3 text-gray-700 shadow-sm focus:ring-2 focus:ring-blue-500 focus:outline-none"
                    id="nama_barang" name="nama_barang" value="{{ old('nama_barang', $asset->nama_barang ?? '') }}"
                    required>
                @error('nama_barang')
                    <p class="text-red-500 text-xs mt-2">{{ $message }}</p>
                @enderror
            </div>

            <!-- Jenis Barang -->
            <div class="mb-6">
                <label for="jenis_barang" class="block text-sm font-medium text-gray-700">Jenis Barang</label>
                <select
                    class="mt-2 block w-full border-2 border-gray-300 rounded-md p-3 text-gray-700 shadow-sm focus:ring-2 focus:ring-blue-500 focus:outline-none"
                    id="jenis_barang" name="jenis_barang" required>
                    <option value="" disabled
                        {{ old('jenis_barang', $asset->jenis_barang ?? '') == '' ? 'selected' : '' }}>Pilih Jenis Barang
                    </option>
                    <option value="elektronik"
                        {{ old('jenis_barang', $asset->jenis_barang ?? '') == 'elektronik' ? 'selected' : '' }}>Elektronik
                    </option>
                    <option value="furniture"
                        {{ old('jenis_barang', $asset->jenis_barang ?? '') == 'furniture' ? 'selected' : '' }}>Furniture
                    </option>
                    <option value="rumah tangga"
                        {{ old('jenis_barang', $asset->jenis_barang ?? '') == 'rumahtangga' ? 'selected' : '' }}>Rumah
                        Tangga
                    </option>
                    <option value="alat tulis kantor"
                        {{ old('jenis_barang', $asset->jenis_barang ?? '') == 'alat tulis kantor' ? 'selected' : '' }}>Alat
                        Tulis Kantor</option>
                    <option value="perangkat keras"
                        {{ old('jenis_barang', $asset->jenis_barang ?? '') == 'perangkat keras' ? 'selected' : '' }}>
                        Perangkat Keras</option>
                    <option value="lainnya"
                        {{ old('jenis_barang', $asset->jenis_barang ?? '') == 'lainnya' ? 'selected' : '' }}>Lainnya
                    </option>
                </select>
                @error('jenis_barang')
                    <p class="text-red-500 text-xs mt-2">{{ $message }}</p>
                @enderror
            </div>

            <!-- Jumlah Barang -->
            <div class="mb-6">
                <label for="jumlah_barang" class="block text-sm font-medium text-gray-700">Jumlah Barang</label>
                <input type="number"
                    class="mt-2 block w-full border-2 border-gray-300 rounded-md p-3 text-gray-700 shadow-sm focus:ring-2 focus:ring-blue-500 focus:outline-none"
                    id="jumlah_barang" name="jumlah_barang" value="{{ old('jumlah_barang', $asset->jumlah_barang ?? '') }}"
                    required>
                @error('jumlah_barang')
                    <p class="text-red-500 text-xs mt-2">{{ $message }}</p>
                @enderror
            </div>

            <!-- Kondisi Barang -->
            <div class="mb-6">
                <label for="kondisi" class="block text-sm font-medium text-gray-700">Kondisi Barang</label>
                <select
                    class="mt-2 block w-full border-2 border-gray-300 rounded-md p-3 text-gray-700 shadow-sm focus:ring-2 focus:ring-blue-500 focus:outline-none"
                    id="kondisi" name="kondisi" required>
                    <option value="baik" {{ old('kondisi', $asset->kondisi ?? '') == 'baik' ? 'selected' : '' }}>Baik
                    </option>
                    <option value="rusak" {{ old('kondisi', $asset->kondisi ?? '') == 'rusak' ? 'selected' : '' }}>Rusak
                    </option>
                    <option value="perlu perbaikan"
                        {{ old('kondisi', $asset->kondisi ?? '') == 'perlu perbaikan' ? 'selected' : '' }}>Perlu Perbaikan
                    </option>
                </select>
                @error('kondisi')
                    <p class="text-red-500 text-xs mt-2">{{ $message }}</p>
                @enderror
            </div>


            <!-- Deskripsi Barang -->
            <div class="mb-6">
                <label for="deskripsi" class="block text-sm font-medium text-gray-700">Deskripsi Barang</label>
                <textarea
                    class="mt-2 block w-full border-2 border-gray-300 rounded-md p-3 text-gray-700 shadow-sm focus:ring-2 focus:ring-blue-500 focus:outline-none"
                    id="deskripsi" name="deskripsi" rows="4" required>{{ old('deskripsi', $asset->deskripsi ?? '') }}</textarea>
                @error('deskripsi')
                    <p class="text-red-500 text-xs mt-2">{{ $message }}</p>
                @enderror
            </div>

            <!-- Gambar Barang -->
            <div class="mb-6">
                <label for="gambar" class="block text-sm font-medium text-gray-700">Gambar Barang</label>
                <input type="file"
                    class="mt-2 block w-full border-2 border-gray-300 rounded-md p-3 text-gray-700 shadow-sm focus:ring-2 focus:ring-blue-500 focus:outline-none"
                    id="gambar" name="gambar" accept="image/*" onchange="previewImage(event)">

                <div class="mt-4">
                    <p class="text-sm text-gray-600">Pratinjau Gambar:</p>
                    <img id="preview"
                        src="{{ isset($asset) && $asset->gambar ? asset('storage/' . $asset->gambar) : '' }}"
                        alt="Pratinjau Gambar"
                        class="mt-2 rounded-md w-48 h-auto {{ isset($asset) && $asset->gambar ? 'block' : 'hidden' }}">
                </div>
            </div>

            <!-- Tombol Submit -->
            <div class="mb-6">
                <button type="submit"
                    class="w-full bg-blue-600 text-white py-3 rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-opacity-50">
                    {{ isset($asset) ? 'Update Asset' : 'Tambah Asset' }}
                </button>
            </div>
        </form>
    </div>

    <script>
        function previewImage(event) {
            const input = event.target;
            const preview = document.getElementById('preview');

            if (input.files && input.files[0]) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    preview.src = e.target.result;
                    preview.style.display = 'block';
                };
                reader.readAsDataURL(input.files[0]);
            } else {
                preview.src = '';
                preview.style.display = 'none';
            }
        }
    </script>
@endsection
