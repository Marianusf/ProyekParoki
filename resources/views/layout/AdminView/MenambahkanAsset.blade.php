@extends('layout.TemplateAdmin')

@section('title', isset($asset) ? 'Edit Asset' : 'Tambah Asset')

@section('content')
    <div class="container mx-auto px-6 py-8">
        <h2 class="text-3xl font-semibold text-center mb-8 text-gray-800">
            {{ isset($asset) ? 'Edit Asset' : 'Tambah Asset' }}
        </h2>

        <!-- Notifikasi -->
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
        @if (session('error'))
            <script>
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: '{{ session('error') }}',
                    confirmButtonText: 'OK'
                });
            </script>
        @endif

        <!-- Form Asset -->
        <form action="{{ isset($asset) ? route('asset.update', $asset->id) : route('asset.store') }}" method="POST"
            enctype="multipart/form-data"
            class="bg-white rounded-lg shadow-md p-8 space-y-6 transition-all duration-300 hover:shadow-lg">
            @csrf
            @if (isset($asset))
                @method('PUT')
            @endif

            <!-- Input Nama Barang -->
            <div>
                <label for="nama_barang" class="block text-sm font-medium text-gray-700">
                    <i class="fas fa-box-open mr-2 text-blue-500"></i> Nama Barang
                </label>
                <input type="text" id="nama_barang" name="nama_barang"
                    value="{{ old('nama_barang', $asset->nama_barang ?? '') }}"
                    class="mt-2 w-full rounded-lg border-gray-300 p-3 shadow-sm focus:ring-2 focus:ring-blue-500"
                    placeholder="Masukkan nama barang" required>
                @error('nama_barang')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Dropdown Jenis Barang -->
            <div>
                <label for="jenis_barang" class="block text-sm font-medium text-gray-700">
                    <i class="fas fa-tags mr-2 text-blue-500"></i> Jenis Barang
                </label>
                <select id="jenis_barang" name="jenis_barang"
                    class="mt-2 w-full rounded-lg border-gray-300 p-3 shadow-sm focus:ring-2 focus:ring-blue-500" required>
                    <option value="" disabled selected>Pilih jenis barang</option>
                    <option value="elektronik"
                        {{ old('jenis_barang', $asset->jenis_barang ?? '') == 'elektronik' ? 'selected' : '' }}>Elektronik
                    </option>
                    <option value="furniture"
                        {{ old('jenis_barang', $asset->jenis_barang ?? '') == 'furniture' ? 'selected' : '' }}>Furniture
                    </option>
                    <option value="rumah tangga"
                        {{ old('jenis_barang', $asset->jenis_barang ?? '') == 'rumah tangga' ? 'selected' : '' }}>Rumah
                        Tangga</option>
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
            </div>

            <!-- Jumlah Barang -->
            <div>
                <label for="jumlah_barang" class="block text-sm font-medium text-gray-700">
                    <i class="fas fa-sort-numeric-up mr-2 text-blue-500"></i> Jumlah Barang
                </label>
                <input type="number" id="jumlah_barang" name="jumlah_barang"
                    class="mt-2 w-full rounded-lg border-gray-300 p-3 shadow-sm focus:ring-2 focus:ring-blue-500"
                    value="{{ old('jumlah_barang', $asset->jumlah_barang ?? '') }}" placeholder="Masukkan jumlah barang"
                    required>
            </div>

            <!-- Kondisi Barang -->
            <div>
                <label for="kondisi" class="block text-sm font-medium text-gray-700">
                    <i class="fas fa-wrench mr-2 text-blue-500"></i> Kondisi Barang
                </label>
                <select id="kondisi" name="kondisi"
                    class="mt-2 w-full rounded-lg border-gray-300 p-3 shadow-sm focus:ring-2 focus:ring-blue-500">
                    <option value="baik" {{ old('kondisi', $asset->kondisi ?? '') == 'baik' ? 'selected' : '' }}>Baik
                    </option>
                    <option value="rusak" {{ old('kondisi', $asset->kondisi ?? '') == 'rusak' ? 'selected' : '' }}>Rusak
                    </option>
                    <option value="perlu perbaikan"
                        {{ old('kondisi', $asset->kondisi ?? '') == 'perlu perbaikan' ? 'selected' : '' }}>Perlu Perbaikan
                    </option>
                </select>
            </div>

            <!-- Deskripsi -->
            <div>
                <label for="deskripsi" class="block text-sm font-medium text-gray-700">
                    <i class="fas fa-align-left mr-2 text-blue-500"></i> Deskripsi Barang
                </label>
                <textarea id="deskripsi" name="deskripsi" rows="4"
                    class="mt-2 w-full rounded-lg border-gray-300 p-3 shadow-sm focus:ring-2 focus:ring-blue-500"
                    placeholder="Jelaskan kondisi barang">{{ old('deskripsi', $asset->deskripsi ?? '') }}</textarea>
            </div>

            <!-- Gambar -->
            <div>
                <label for="gambar" class="block text-sm font-medium text-gray-700">
                    <i class="fas fa-image mr-2 text-blue-500"></i> Upload Gambar
                </label>
                <input type="file" id="gambar" name="gambar"
                    class="mt-2 w-full border-2 rounded-lg p-2 focus:ring-2 focus:ring-blue-500"
                    onchange="previewImage(event)">
                <div class="mt-4">
                    <img id="preview"
                        src="{{ isset($asset) && $asset->gambar ? asset('storage/' . $asset->gambar) : '' }}"
                        alt="Pratinjau Gambar" class="rounded-lg shadow w-48 {{ isset($asset) ? '' : 'hidden' }}">
                </div>
            </div>

            <!-- Tombol Submit -->
            <div>
                <button type="submit"
                    class="w-full bg-blue-600 text-white py-3 rounded-lg hover:bg-blue-700 transition duration-300">
                    {{ isset($asset) ? 'Update Asset' : 'Tambah Asset' }}
                </button>
            </div>
        </form>
    </div>

    <script>
        function previewImage(event) {
            const preview = document.getElementById('preview');
            const file = event.target.files[0];

            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    preview.src = e.target.result;
                    preview.classList.remove('hidden');
                };
                reader.readAsDataURL(file);
            } else {
                preview.classList.add('hidden');
            }
        }
    </script>
@endsection
