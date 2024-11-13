<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Navbar</title>
    @vite('resources/css/app.css')
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@200;300;400;500;600;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.all.min.js"></script>
    
    <style>
        body {
            overflow: hidden;
        }

        .sidebar {
            position: fixed;
            top: 64px; /* Adjust this value based on your navbar height */
            bottom: 0;
            left: -300px; /* Hidden by default */
            width: 250px;
            background-color: #1f2937; /* Tailwind's gray-900 */
            height: calc(100vh - 64px); /* Full height minus navbar height */
            overflow-y: auto;
            transition: left 0.2s ease; /* Smooth transition */
            z-index: 10; /* Ensure it’s above other content */
        }

        .sidebar.show {
            left: 0; /* Show sidebar */
        }

        .main-content {
            transition: margin-left 0.3s ease; /* Smooth transition */
            margin-left: 0; /* Initially fullscreen */
            padding: 16px; /* Adjust as needed */
            height: 100vh; /* Full height */
            overflow-y: auto; /* Scroll if content is too long */
        }

        .main-content.shifted {
            margin-left: 300px; /* Adjust for the sidebar width */
        }

        @media (min-width: 640px) {
            .sidebar {
                width: 300px;
            }
        }
    </style>

</head>
<body>
    <nav class="bg-gray-900">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="flex h-16 items-center justify-between">
                <div class="flex items-center">
                    <div class="">
                        <span class="absolute text-white text-3xl top-4 left-2 cursor-pointer " onclick="toggleSidebar()">
                            <i class="bi bi-filter-left px-2 bg-gray-900 hover:bg-gray-700 rounded-md"></i>
                        </span>
                    </div>                    
                    <div class="p-2.5 mt-1 ml-10 sm:ml-10 flex items-center">
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
                </div>
            </div>
        </div>
    </nav>

    <div class="sidebar" id="sidebar">
        <div class="text-gray-100 text-sm sm:text-md">
            <div class="p-2.5 mt-1 flex items-center">
                <img src="https://i.pinimg.com/736x/08/f2/25/08f22527b5352c7acc4a14dc29ef2f95.jpg" alt="Logo Paroki Babadan" class="w-10 h-10 rounded-full">
                <div class="ml-5">
                    <div class="text-base/5 font-medium text-white">Santok</div>
                    <div class="text-sm font-medium text-gray-400">Lingkungan A</div>
                </div>
                <i class="bi bi-x ml-20 sm:ml-28 cursor-pointer" onclick="toggleSidebar()"></i>
            </div>
            <hr class="my-2 text-gray-600">
            <a href="/home" class="p-2.5 mt-2 flex items-center px-4 duration-300 cursor-pointer hover:bg-gray-700">
                <i class="bi bi-house-door"></i>
                <span class="text-[15px] ml-4 text-gray-200">Home</span>
            </a>
            <a href="ruangan" class="p-2.5 mt-2 flex items-center px-4 duration-300 cursor-pointer hover:bg-gray-700">
                <i class="bi bi-building"></i>
                <span class="text-[15px] ml-4 text-gray-200">Ruangan</span>
            </a>
            <a href="/loan-requests" class="p-2.5 mt-2 flex items-center px-4 duration-300 cursor-pointer hover:bg-gray-700">
                <i class="bi bi-box-seam"></i>
                <span class="text-[15px] ml-4 text-gray-200">Barang dan Aset</span>
            </a>
            <a href="/loan-requests" class="p-2.5 mt-2 flex items-center px-4 duration-300 cursor-pointer hover:bg-gray-700">
                <i class="bi bi-cart"></i>
                <span class="text-[15px] ml-4 text-gray-200">Keranjang</span>
            </a>
            <a href="/add-asset" class="p-2.5 mt-2 flex items-center px-4 duration-300 cursor-pointer hover:bg-gray-700">
                <i class="bi bi-clock-history"></i>
                <span class="text-[15px] ml-4 text-gray-200">Histori Peminjaman</span>
            </a>
            <a href="/view-assets" class="p-2.5 mt-2 flex items-center px-4 duration-300 cursor-pointer hover:bg-gray-700">
                <i class="bi bi-arrow-counterclockwise"></i>
                <span class="text-[15px] ml-4 text-gray-200">Pengembalian</span>
            </a>
            <a href="/delete-asset" class="p-2.5 mt-2 flex items-center px-4 duration-300 cursor-pointer hover:bg-gray-700">
                <i class="bi bi-person"></i>
                <span class="text-[15px] ml-4 text-gray-200">Profile</span>
            </a>
            <a href="/login" class="p-2.5 mt-3 flex items-center px-4 duration-300 cursor-pointer hover:bg-gray-700">
                <i class="bi bi-box-arrow-in-right"></i>
                <span class="text-[15px] ml-4 text-gray-200">Logout</span>
            </a>
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