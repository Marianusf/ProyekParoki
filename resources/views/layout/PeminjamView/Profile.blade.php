@extends('layout.TemplateAdmin')

@section('title', 'profilKu')

@section('content')

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Profil - Paroki St Petrus dan Paulus</title>
        <!-- Tailwind CSS CDN -->
        <script src="https://cdn.tailwindcss.com"></script>
    </head>
    <section class="p-6 bg-gray-100 min-h-screen">

        <body class="bg-gray-100 flex justify-center items-center min-h-screen">
            <div class="bg-white w-full max-w-2xl p-6 rounded-lg shadow-md">
                <h2 class="text-2xl font-semibold text-gray-800 mb-2">Profil</h2>
                <p class="text-gray-500 mb-4">PAROKI ST PETRUS DAN PAULUS</p>
                @if (session('success'))
                    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4"
                        role="alert">
                        <strong class="font-bold">Sukses: </strong>
                        <span class="block sm:inline">{{ session('success') }}</span>
                    </div>
                @endif
                @if (session('message'))
                    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4"
                        role="alert">
                        <strong class="font-bold">PESAN: </strong>
                        <span class="block sm:inline">{{ session('message') }}</span>
                    </div>
                @endif

                @if (session('error'))
                    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4"
                        role="alert">
                        <strong class="font-bold">Error: </strong>
                        <span class="block sm:inline">{{ session('error') }}</span>
                    </div>
                @endif
                <form action="update_profile.php" method="post" class="space-y-4">
                    <!-- Profile Picture -->
                    <div class="flex justify-center mb-6">
                        <div class="w-24 h-24 rounded-full bg-gray-200 flex items-center justify-center">
                            <!-- Placeholder for profile picture -->
                            <img src="default-profile.png" alt="Profile Picture"
                                class="rounded-full w-full h-full object-cover">
                        </div>
                    </div>

                    <!-- Form Fields -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm text-gray-600">Nama Lengkap</label>
                            <input type="text" name="nama_lengkap" value="Santok Ajah" readonly
                                class="w-full bg-gray-100 border border-gray-200 rounded p-2 text-gray-700">
                        </div>
                        <div>
                            <label class="block text-sm text-gray-600">Email</label>
                            <input type="email" name="email" value="Santok Ganteng" readonly
                                class="w-full bg-gray-100 border border-gray-200 rounded p-2 text-gray-700">
                        </div>
                        <div>
                            <label class="block text-sm text-gray-600">NIK</label>
                            <input type="text" name="nik" value="2021205496876513" readonly
                                class="w-full bg-gray-100 border border-gray-200 rounded p-2 text-gray-700">
                        </div>
                        <div>
                            <label class="block text-sm text-gray-600">Tanggal Lahir</label>
                            <input type="text" name="tanggal_lahir" value="29 Februari 2000" readonly
                                class="w-full bg-gray-100 border border-gray-200 rounded p-2 text-gray-700">
                        </div>
                        <div>
                            <label class="block text-sm text-gray-600">Jenis Kelamin</label>
                            <input type="text" name="jenis_kelamin" value="Laki-laki" readonly
                                class="w-full bg-gray-100 border border-gray-200 rounded p-2 text-gray-700">
                        </div>
                        <div>
                            <label class="block text-sm text-gray-600">Lingkungan</label>
                            <input type="text" name="lingkungan" value="Lingkungan A" readonly
                                class="w-full bg-gray-100 border border-gray-200 rounded p-2 text-gray-700">
                        </div>
                        <div>
                            <label class="block text-sm text-gray-600">Nomor Telepon</label>
                            <input type="text" name="nomor_telepon" value="+62 81381800123" readonly
                                class="w-full bg-gray-100 border border-gray-200 rounded p-2 text-gray-700">
                        </div>
                        <div>
                            <label class="block text-sm text-gray-600">Alamat saat ini</label>
                            <input type="text" name="alamat" value="Jalan Babadan" readonly
                                class="w-full bg-gray-100 border border-gray-200 rounded p-2 text-gray-700">
                        </div>
                        <div>
                            <label class="block text-sm text-gray-600">Status di Lingkungan</label>
                            <input type="text" name="status" value="Ketua" readonly
                                class="w-full bg-gray-100 border border-gray-200 rounded p-2 text-gray-700">
                        </div>
                    </div>

                    <!-- Buttons -->
                    <div class="flex justify-center space-x-4 mt-6">
                        <button type="submit" name="update"
                            class="bg-blue-500 hover:bg-blue-600 text-white py-2 px-4 rounded">Update perubahan</button>
                        <button type="reset" name="reset"
                            class="bg-blue-100 hover:bg-blue-200 text-blue-700 py-2 px-4 rounded">Reset perubahan</button>
                    </div>
                </form>
            </div>
        </body>
    </section>
@endsection

@section('scripts')
    <script>
        // Additional JavaScript specific to this page
        console.log('Home page script loaded.');
    </script>
@endsection
