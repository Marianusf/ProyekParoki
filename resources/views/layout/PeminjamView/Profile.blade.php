@extends('layout.TemplatePeminjam')

@section('title', 'Profil')

@section('content')
    <section class="p-6 bg-gray-100 min-h-screen place-items-center">
        <div class="bg-white w-full max-w-7xl p-6 rounded-lg shadow-md border border-black">
            <h2 class="text-2xl font-semibold text-gray-800 mb-2">Profil</h2>
            <p class="text-gray-500 mb-4">PAROKI ST PETRUS DAN PAULUS</p>

            <!-- Form untuk Update Profil -->
            <form action="" method="POST" class="space-y-4">
                @csrf
                @method('PUT')

                <!-- Profile Picture -->
                <div class="flex justify-center mb-6">
                    <div class="w-24 h-24 rounded-full bg-gray-200 flex items-center justify-center">
                        <!-- Placeholder for profile picture -->
                        <img src="{{ asset('storage/' . $peminjam->profile_picture) }}" alt="Profile Picture"
                            class="rounded-full w-full h-full object-cover">
                    </div>
                </div>

                <!-- Form Fields -->
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm text-gray-600">Nama Lengkap</label>
                        <input type="text" name="nama_lengkap" value="{{ old('nama_lengkap', $peminjam->name) }}"
                            class="w-full bg-gray-100 border border-gray-200 rounded p-2 text-gray-700">
                    </div>
                    <div>
                        <label class="block text-sm text-gray-600">Email</label>
                        <input type="email" name="email" value="{{ old('email', $peminjam->email) }}"
                            class="w-full bg-gray-100 border border-gray-200 rounded p-2 text-gray-700">
                    </div>
                    <div>
                        <label class="block text-sm text-gray-600">NIK</label>
                        <input type="text" name="nik" value="{{ old('nik', $peminjam->nik) }}"
                            class="w-full bg-gray-100 border border-gray-200 rounded p-2 text-gray-700">
                    </div>
                    <div>
                        <label class="block text-sm text-gray-600">Tanggal Lahir</label>
                        <input type="text" name="tanggal_lahir"
                            value="{{ old('tanggal_lahir', $peminjam->tanggal_lahir) }}"
                            class="w-full bg-gray-100 border border-gray-200 rounded p-2 text-gray-700">
                    </div>
                    <div>
                        <label class="block text-sm text-gray-600">Jenis Kelamin</label>
                        <input type="text" name="jenis_kelamin"
                            value="{{ old('jenis_kelamin', $peminjam->jenis_kelamin) }}"
                            class="w-full bg-gray-100 border border-gray-200 rounded p-2 text-gray-700">
                    </div>
                    <div>
                        <label class="block text-sm text-gray-600">Lingkungan</label>
                        <input type="text" name="lingkungan" value="{{ old('lingkungan', $peminjam->lingkungan) }}"
                            class="w-full bg-gray-100 border border-gray-200 rounded p-2 text-gray-700">
                    </div>
                    <div>
                        <label class="block text-sm text-gray-600">Nomor Telepon</label>
                        <input type="text" name="nomor_telepon"
                            value="{{ old('nomor_telepon', $peminjam->nomor_telepon) }}"
                            class="w-full bg-gray-100 border border-gray-200 rounded p-2 text-gray-700">
                    </div>
                    <div>
                        <label class="block text-sm text-gray-600">Alamat Saat Ini</label>
                        <input type="text" name="alamat" value="{{ old('alamat', $peminjam->alamat) }}"
                            class="w-full bg-gray-100 border border-gray-200 rounded p-2 text-gray-700">
                    </div>
                </div>

                <!-- Buttons -->
                <div class="flex justify-center space-x-5 mt-6 mr-4">
                    <button type="submit" name="update"
                        class="bg-blue-500 hover:bg-blue-600 text-white py-2 px-4 rounded">Update Perubahan</button>
                    <button type="reset" name="reset"
                        class="bg-blue-100 hover:bg-blue-200 text-blue-700 py-2 px-4 rounded">Reset Perubahan</button>
                </div>
            </form>
        </div>
    </section>
@endsection

@section('scripts')
    <script>
        // Additional JavaScript specific to this page
        // console.log('Profile page script loaded.');
    </script>
@endsection
