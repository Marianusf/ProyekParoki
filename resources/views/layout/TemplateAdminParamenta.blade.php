<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Home Page Admin')</title>
    @vite('resources/css/app.css')
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@200;300;400;500;600;800&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <!-- SweetAlert2 JS -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.all.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2"></script>
    <!-- SweetAlert2 CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.6.0/dist/sweetalert2.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"
        integrity="sha512-Kfw6bRRXLgXjOd+7Kf4Yx8qEzHGGw5FZZDdJx/0SGpBrlgqeycZTArbJm/MJlyZ5ATh8WlhjZGvj7ZwQ3NA76g=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
    <!-- SweetAlert2 JS -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.6.0/dist/sweetalert2.all.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"
        integrity="sha512-KfwQ4T91FQmNZ5SRA6d8b6ozV00JwQx6Z/BHdBmyM6sk4EUvsVoRwhPyK78iA61UO0APcFXk5sKPn7Em79/5KQ=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"
        integrity="sha512-dlFJSlZQvD1vRC2/Qw7sQ6WdBKP0pB/rChtZ01fG07FaP4E98oUWEW3CbNCBqWjRbGC6K6Vw5BlFPOmM/8DaFw=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />

    <style>
        body {
            overflow: hidden;
        }

        .sidebar {
            position: fixed;
            top: 64px;
            /* Adjust this value based on your navbar height */
            bottom: 0;
            left: -300px;
            /* Hidden by default */
            width: 250px;
            background-color: #1f2937;
            /* Tailwind's gray-900 */
            height: calc(100vh - 64px);
            /* Full height minus navbar height */
            overflow-y: auto;
            transition: left 0.2s ease;
            /* Smooth transition */
            z-index: 10;
            /* Ensure it’s above other content */
        }

        .sidebar.show {
            left: 0;
            /* Show sidebar */
        }

        .main-content {
            transition: margin-left 0.3s ease;
            /* Smooth transition */
            margin-left: 0;
            /* Initially fullscreen */
            padding: 16px;
            /* Adjust as needed */
            height: 100vh;
            /* Full height */
            overflow-y: auto;
            /* Scroll if content is too long */
        }

        .main-content.shifted {
            margin-left: 300px;
            /* Adjust for the sidebar width */
        }

        @media (min-width: 640px) {
            .sidebar {
                width: 300px;
            }
        }
    </style>
</head>

<body>
    <nav class="bg-gray-800">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="flex h-16 items-center justify-between">
                <!-- Bagian Sidebar Icon -->
                <div class="flex-1">
                    <span class="absolute text-white text-3xl top-4 left-2 cursor-pointer" onclick="toggleSidebar()">
                        <i class="bi bi-filter-left px-2 bg-gray-800 hover:bg-gray-600 rounded-md"></i>
                    </span>
                </div>
                <!-- Bagian Tengah: Logo dan Judul -->
                <div class="flex items-center justify-center">
                    <img src="{{ asset('/logo.png') }}" alt="Logo Paroki Babadan" class="w-8 h-8 sm:w-10 sm:h-10">
                    <div class="ml-4">
                        <div class="text-sm sm:text-base font-medium text-white">
                            Sistem Peminjaman Gereja Babadan
                        </div>
                        <div class="text-sm sm:text-base font-medium text-gray-400">
                            Paroki ST Petrus dan Paulus
                        </div>
                    </div>
                </div>
                <!-- Spacer Kanan -->
                <div class="flex-1"></div>
            </div>
        </div>
    </nav>

    <div class="sidebar" id="sidebar">
        <div class="text-gray-100 text-sm sm:text-md">
            <div class="p-2.5 mt-1 flex items-center">
                <img src="{{ asset('/logo.png') }}" alt="Logo Paroki Babadan" class="w-10 h-10 rounded-full">
                <div class="ml-5">
                    <div class="text-base font-medium text-white">Admin Paramenta</div>
                    <div class="text-sm font-medium text-gray-400">Paroki Babadan</div>
                </div>
                <i class="bi bi-x ml-auto cursor-pointer" onclick="toggleSidebar()"></i>
            </div>
            <hr class="my-2 text-gray-600">
            <a href="{{ route('paramenta.dashboard') }}"
                class="p-2.5 mt-2 flex items-center px-4 duration-300 cursor-pointer hover:bg-gray-700 {{ Request::routeIs('paramenta.dashboard') ? 'bg-gray-700' : '' }}">
                <i class="bi bi-house-door"></i>
                <span class="text-[15px] ml-4 text-gray-200">Home</span>
            </a>

            <a href="{{ route('lihatPermintaanPeminjamanAlatMisa') }}"
                class="p-2.5 mt-2 flex items-center px-4 duration-300 cursor-pointer hover:bg-gray-700 {{ Request::routeIs('lihatPermintaanPeminjamanAlatMisa') ? 'bg-gray-700' : '' }}">
                <i class="bi bi-check-square-fill"></i>
                <span class="text-[15px] ml-4 text-gray-200">Persetujuan Peminjaman Alat Misa</span>
            </a>
            <a href="{{ route('admin.PermintaanPengembalianALatMisa') }}"
                class="p-2.5 mt-2 flex items-center px-4 duration-300 cursor-pointer hover:bg-gray-700 {{ Request::routeIs('admin.PermintaanPengembalianALatMisa') ? 'bg-gray-700' : '' }}">
                <i class="bi bi-arrow-return-left"></i>
                <span class="text-[15px] ml-4 text-gray-200">Persetujuan Pengembalian Alat Misa</span>
            </a>
            <a href="{{ route('alat_misa.create') }}"
                class="p-2.5 mt-2 flex items-center px-4 duration-300 cursor-pointer hover:bg-gray-700 {{ Request::routeIs('alat_misa.create') ? 'bg-gray-700' : '' }}">
                <i class="bi bi-plus-circle"></i>
                <span class="text-[15px] ml-4 text-gray-200">Tambah Alat Misa</span>
            </a>
            <a href="{{ route('alat_misa.index') }}"
                class="p-2.5 mt-2 flex items-center px-4 duration-300 cursor-pointer hover:bg-gray-700 {{ Request::routeIs('alat_misa.index') ? 'bg-gray-700' : '' }}">
                <i class="bi bi-list-ul"></i>
                <span class="text-[15px] ml-4 text-gray-200">Lihat Alat Misa</span>
            </a>
            <a href="{{ route('lihatKetersediaanAlatMisa') }}"
                class="p-2.5 mt-2 flex items-center px-4 duration-300 cursor-pointer hover:bg-gray-700 {{ Request::routeIs('lihatKetersediaanAlatMisa') ? 'bg-gray-700' : '' }}">
                <i class="bi bi-eye-fill"></i>
                <span class="text-[15px] ml-4 text-gray-200">Cek Ketersediaan Alat Misa</span>
            </a>
            <a href="{{ route('lihat.riwayat.peminjaman-alatmisa') }}"
                class="p-2.5 mt-2 flex items-center px-4 duration-300 cursor-pointer hover:bg-gray-700 {{ Request::routeIs('lihat.riwayat.peminjaman-alatmisa') ? 'bg-gray-700' : '' }}">
                <i class="bi bi-clock-history"></i>
                <span class="text-[15px] ml-4 text-gray-200">Riwayat Peminjaman Alat Misa</span>
            </a>
            <hr class="my-4 text-gray-600">
            <a href="{{ route('lihat.peminjam.aktif.byparamenta') }}"
                class="p-2.5 mt-2 flex items-center px-4 duration-300 cursor-pointer hover:bg-gray-700 {{ Request::routeIs('lihat.peminjam.aktif.byparamenta') ? 'bg-gray-700' : '' }}">
                <i class="bi bi-people-fill"></i>
                <span class="text-[15px] ml-4 text-gray-200">Lihat Peminjam Terdaftar</span>
            </a>
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit"
                    class="p-2.5 mt-2 flex items-center px-4 duration-300 cursor-pointer hover:bg-gray-700 w-full">
                    <i class="bi bi-box-arrow-in-right"></i>
                    <span class="text-[15px] ml-4 text-gray-200">Logout</span>
                </button>
            </form>
        </div>
    </div>

    <div class="main-content" id="mainContent">
        @yield('content')
    </div>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        const sidebar = document.getElementById('sidebar');
        const mainContent = document.getElementById('mainContent');

        function toggleSidebar() {
            sidebar.classList.toggle('show'); // Toggle sidebar visibility
            mainContent.classList.toggle('shifted'); // Shift main content
        }

        sidebar.addEventListener('mouseenter', () => {
            sidebar.classList.add('show');
            mainContent.classList.add('shifted');
        });

        sidebar.addEventListener('mouseleave', () => {
            sidebar.classList.remove('show');
            mainContent.classList.remove('shifted');
        });

        // Optional: Ensure the sidebar is hidden when the page loads
        window.onload = () => {
            sidebar.classList.remove('show');
            mainContent.classList.remove('shifted');
        };
    </script>
    <script>
        @yield('scripts')
    </script>
</body>

</html>
