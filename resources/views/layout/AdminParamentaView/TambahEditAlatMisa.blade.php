@extends('layout.TemplateAdminParamenta')

@section('title', isset($alatMisa) ? 'Edit Alat Misa' : 'Tambah Alat Misa')

@section('content')
    <div class="container mx-auto px-6 py-8">
        <h2 class="text-3xl font-semibold text-center mb-8 text-gray-800">
            {{ isset($alatMisa) ? 'Edit Alat Misa' : 'Tambah Alat Misa' }}
        </h2>

        <!-- SweetAlert untuk Notifikasi -->
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
                    title: 'Error!',
                    text: '{{ session('error') }}',
                    confirmButtonText: 'OK'
                });
            </script>
        @endif

        @if ($errors->any())
            <script>
                Swal.fire({
                    icon: 'error',
                    title: 'Terjadi Kesalahan!',
                    text: '{{ implode(', ', $errors->all()) }}',
                    confirmButtonText: 'OK'
                });
            </script>
        @endif



        <!-- Form -->
        <form id="alatMisaForm"
            action="{{ isset($alatMisa) ? route('alat_misa.update', $alatMisa->id) : route('alat_misa.store') }}"
            method="POST" enctype="multipart/form-data">
            @csrf
            @if (isset($alatMisa))
                @method('PUT')
            @endif

            <!-- Nama Alat -->
            <label for="nama_alat" class="block text-sm font-medium text-gray-700">Nama Alat</label>
            <input type="text" name="nama_alat" id="nama_alat" value="{{ old('nama_alat', $alatMisa->nama_alat ?? '') }}"
                class="w-full border rounded-md p-2 shadow-sm mb-4" required>

            <!-- Jenis Alat -->
            <label for="jenis_alat" class="block text-sm font-medium text-gray-700">Jenis Alat</label>
            <select name="jenis_alat" id="jenis_alat" class="w-full border rounded-md p-2 shadow-sm mb-4" required>
                <option value="" disabled selected>Pilih Jenis Alat</option>
                <option value="liturgis"
                    {{ old('jenis_alat', $alatMisa->jenis_alat ?? '') == 'liturgis' ? 'selected' : '' }}>Liturgis</option>
                <option value="musik" {{ old('jenis_alat', $alatMisa->jenis_alat ?? '') == 'musik' ? 'selected' : '' }}>
                    Musik</option>
                <option value="dekorasi"
                    {{ old('jenis_alat', $alatMisa->jenis_alat ?? '') == 'dekorasi' ? 'selected' : '' }}>Dekorasi</option>
                <option value="prosesional"
                    {{ old('jenis_alat', $alatMisa->jenis_alat ?? '') == 'prosesional' ? 'selected' : '' }}>Prosesional
                </option>
                <option value="buku dan naskah"
                    {{ old('jenis_alat', $alatMisa->jenis_alat ?? '') == 'buku dan naskah' ? 'selected' : '' }}>Buku dan
                    Naskah</option>
                <option value="alat doa"
                    {{ old('jenis_alat', $alatMisa->jenis_alat ?? '') == 'alat doa' ? 'selected' : '' }}>Peralatan Doa
                </option>
                <option value="alat pendukung"
                    {{ old('jenis_alat', $alatMisa->jenis_alat ?? '') == 'alat pendukung' ? 'selected' : '' }}>Alat
                    Pendukung</option>
                <option value="lainnya"
                    {{ old('jenis_alat', $alatMisa->jenis_alat ?? '') == 'lainnya' ? 'selected' : '' }}>Lainya</option>
            </select>

            <!-- Jumlah -->
            <label for="jumlah" class="block text-sm font-medium text-gray-700">Jumlah</label>
            <input type="number" name="jumlah" id="jumlah" min="1"
                value="{{ old('jumlah', $alatMisa->jumlah ?? '') }}" class="w-full border rounded-md p-2 shadow-sm mb-4"
                required>

            <!-- Kondisi -->
            <label for="kondisi" class="block text-sm font-medium text-gray-700">Kondisi</label>
            <select name="kondisi" id="kondisi" class="w-full border rounded-md p-2 shadow-sm mb-4">
                <option value="baik" {{ old('kondisi', $alatMisa->kondisi ?? '') == 'baik' ? 'selected' : '' }}>Baik
                </option>
                <option value="perbaikan" {{ old('kondisi', $alatMisa->kondisi ?? '') == 'perbaikan' ? 'selected' : '' }}>
                    Perbaikan</option>
            </select>

            <!-- Deskripsi -->
            <label for="deskripsi" class="block text-sm font-medium text-gray-700">Deskripsi</label>
            <textarea name="deskripsi" id="deskripsi" rows="3" class="w-full border rounded-md p-2 shadow-sm mb-4">{{ old('deskripsi', $alatMisa->deskripsi ?? '') }}</textarea>

            <!-- Detail Alat -->
            <label for="detail_alat" class="block text-sm font-medium text-gray-700">Detail Alat</label>

            <div id="detail-container" class="space-y-2 mb-4">
                @php
                    $details =
                        isset($alatMisa->detail_alat) && is_array($alatMisa->detail_alat) ? $alatMisa->detail_alat : [];
                @endphp

                @if (!empty($details))
                    @foreach ($details as $index => $detail)
                        <div class="flex items-center gap-2" id="row-{{ $index }}">
                            <input type="text" name="detail_alat[{{ $index }}][nama_detail]"
                                placeholder="Nama Detail" class="nama-detail-input border rounded p-2 w-1/2"
                                value="{{ $detail['nama_detail'] ?? '' }}">
                            <input type="number" name="detail_alat[{{ $index }}][jumlah]" placeholder="Jumlah"
                                class="jumlah-input border rounded p-2 w-1/4" value="{{ $detail['jumlah'] ?? 0 }}"
                                min="1">
                            <button type="button" onclick="removeDetail(this)"
                                class="text-red-500 hover:text-red-700">Hapus</button>
                        </div>
                    @endforeach
                @endif
            </div>

            <!-- Tombol Tambah Detail -->
            <button type="button" onclick="addDetail()" class="px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600">
                Tambah Detail
            </button>

            <!-- Hidden Input untuk Detail Alat -->
            <input type="hidden" name="detail_alat_json" id="detail_alat_json">



            <!-- Gambar Barang -->
            <div class="mb-6">
                <label for="gambar" class="block text-sm font-medium text-gray-700">Gambar Barang</label>
                <input type="file"
                    class="mt-2 block w-full border-2 border-gray-300 rounded-md p-3 text-gray-700 shadow-sm focus:ring-2 focus:ring-blue-500 focus:outline-none"
                    id="gambar" name="gambar" accept="image/*" onchange="previewImage(event)">

                <div class="mt-4">
                    <p class="text-sm text-gray-600">Pratinjau Gambar:</p>
                    <img id="preview"
                        src="{{ isset($alatMisa) && $alatMisa->gambar ? asset('storage/' . $alatMisa->gambar) : '' }}"
                        alt="Pratinjau Gambar"
                        class="mt-2 rounded-md w-48 h-auto {{ isset($alatMisa) && $alatMisa->gambar ? 'block' : 'hidden' }}">
                </div>
            </div>
            <!-- Tombol Submit -->
            <button type="button" id="submit-btn"
                class="w-full bg-green-500 text-white py-3 rounded hover:bg-green-600 mt-4">
                {{ isset($alatMisa) ? 'Update Alat Misa' : 'Tambah Alat Misa' }}
            </button>
        </form>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const detailContainer = document.getElementById('detail-container');
            const detailInput = document.getElementById('detail_alat_json');

            // Fungsi untuk memperbarui JSON ke input hidden
            function updateJson() {
                const details = [];
                document.querySelectorAll('#detail-container .flex').forEach(function(row) {
                    const namaDetail = row.querySelector('.nama-detail-input').value.trim();
                    const jumlah = row.querySelector('.jumlah-input').value.trim();
                    if (namaDetail && jumlah) {
                        details.push({
                            nama_detail: namaDetail,
                            jumlah: parseInt(jumlah)
                        });
                    }
                });
                detailInput.value = JSON.stringify(details); // Set nilai ke hidden input
                console.log('Detail Alat JSON:', detailInput.value); // Debugging
            }

            // Fungsi Tambah Detail
            window.addDetail = function() {
                const index = Date.now(); // Gunakan timestamp unik
                const row = document.createElement('div');
                row.className = 'flex items-center gap-2';
                row.id = `row-${index}`;
                row.innerHTML = `
            <input type="text" name="detail_alat[${index}][nama_detail]" placeholder="Nama Detail" 
                class="nama-detail-input border rounded p-2 w-1/2">
            <input type="number" name="detail_alat[${index}][jumlah]" placeholder="Jumlah" 
                class="jumlah-input border rounded p-2 w-1/4" min="1">
            <button type="button" onclick="removeDetail(this)" class="text-red-500 hover:text-red-700">Hapus</button>
        `;
                detailContainer.appendChild(row);
                row.querySelectorAll('input').forEach(input => input.addEventListener('input', updateJson));
                updateJson();
            };

            // Fungsi Hapus Detail
            window.removeDetail = function(button) {
                button.parentElement.remove();
                updateJson();
            };

            // SweetAlert konfirmasi submit
            document.getElementById('submit-btn').addEventListener('click', function(event) {
                event.preventDefault(); // Hentikan pengiriman form sementara
                updateJson(); // Update JSON sebelum submit

                Swal.fire({
                    title: 'Apakah Anda Yakin?',
                    text: '{{ isset($alatMisa) ? 'Apakah Anda ingin menyimpan perubahan ini?' : 'Apakah Anda ingin menambahkan data ini?' }}',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Ya, Simpan!',
                    cancelButtonText: 'Batal',
                    confirmButtonColor: '#28a745',
                    cancelButtonColor: '#d33'
                }).then((result) => {
                    if (result.isConfirmed) {
                        document.getElementById('alatMisaForm').submit();
                    }
                });
            });

            // Fungsi untuk menampilkan pratinjau gambar
            window.previewImage = function(event) {
                const input = event.target; // Input file
                const preview = document.getElementById('preview'); // Elemen gambar preview

                // Cek jika ada file yang dipilih
                if (input.files && input.files[0]) {
                    const reader = new FileReader();

                    // Load file dan tampilkan di gambar preview
                    reader.onload = function(e) {
                        preview.src = e.target.result; // Atur src gambar
                        preview.classList.remove('hidden'); // Tampilkan gambar
                    };

                    reader.readAsDataURL(input.files[0]); // Baca file sebagai URL
                } else {
                    preview.src = ''; // Kosongkan gambar
                    preview.classList.add('hidden'); // Sembunyikan gambar
                }
            };

            // Update JSON saat halaman dimuat
            updateJson();
        });
    </script>

@endsection
