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
    <!-- Tambahkan di <head> -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.2.0/fullcalendar.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

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
                    <div class="text-base font-medium text-white">Admin Sekretariat</div>
                    <div class="text-sm font-medium text-gray-400">Paroki Babadan</div>
                </div>
                <i class="bi bi-x ml-auto cursor-pointer" onclick="toggleSidebar()"></i>
            </div>
            <hr class="my-2 text-gray-600">
            <a href="{{ route('sekretariat.dashboard') }}"
                class="p-2.5 mt-2 flex items-center px-4 duration-300 cursor-pointer hover:bg-gray-700 {{ Request::routeIs('sekretariat.dashboard') ? 'bg-gray-700' : '' }}">
                <i class="bi bi-house-door"></i>
                <span class="text-[15px] ml-4 text-gray-200">Home</span>
            </a>
            <a href="{{ route('peminjaman.index') }}"
                class="p-2.5 mt-2 flex items-center px-4 duration-300 cursor-pointer hover:bg-gray-700 {{ Request::routeIs('peminjaman.index') ? 'bg-gray-700' : '' }}">
                <i class="bi bi-check-square-fill"></i>
                <span class="text-[15px] ml-4 text-gray-200">Persetujuan Peminjaman Ruangan</span>
            </a>

            <a href="{{ route('ruangan.create') }}"
                class="p-2.5 mt-2 flex items-center px-4 duration-300 cursor-pointer hover:bg-gray-700 {{ Request::is('ruangan.create') ? 'bg-gray-700' : '' }}">
                <i class="bi bi-plus-circle"></i>
                <span class="text-[15px] ml-4 text-gray-200">Tambah Ruangan</span>
            </a>
            <a href="{{ route('lihatSemuaRuangan') }}"
                class="p-2.5 mt-2 flex items-center px-4 duration-300 cursor-pointer hover:bg-gray-700 {{ Request::is('lihatSemuaRuangan') ? 'bg-gray-700' : '' }}">
                <i class="bi bi-list-ul"></i>
                <span class="text-[15px] ml-4 text-gray-200">Lihat Semua Ruangan</span>
            </a>
            <a href="{{ route('cekKetersediaanRuangan') }}"
                class="p-2.5 mt-2 flex items-center px-4 duration-300 cursor-pointer hover:bg-gray-700 {{ Request::is('cekKetersediaanRuangan') ? 'bg-gray-700' : '' }}">
                <i class="bi bi-eye-fill"></i>
                <span class="text-[15px] ml-4 text-gray-200">Cek Ketersediaan Ruangan</span>
            </a>
            <hr class="my-4 text-gray-600">
            <a href="{{ route('lihat.peminjam.aktif.bysekretariat') }}"
                class="p-2.5 mt-2 flex items-center px-4 duration-300 cursor-pointer hover:bg-gray-700 {{ Request::is('lihat.peminjam.aktif.bysekretariat') ? 'bg-gray-700' : '' }}">
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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.2.0/fullcalendar.min.js"></script>
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
