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

    <style>
        body {
            overflow: hidden;

        }

        .sidebar {
            position: fixed;
            top: 0;
            bottom: 0;
            left: -300px;
            /* Hidden by default */
            width: 300px;
            background-color: #1f2937;
            /* Tailwind's gray-900 */
            height: 100vh;
            /* Full height */
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
    </style>
</head>

<body class="bg-blue-600 font-[Poppins]">
<span class="absolute text-white text-4xl top-5 left-4 cursor-pointer" onclick="toggleSidebar()">
    <i class="bi bi-filter-left px-2 bg-gray-900 rounded-md"></i>
</span>


    <div class="sidebar" id="sidebar">
        <div class="text-gray-100 text-xl">
            <div class="p-2.5 mt-1 flex items-center rounded-md">
                <img src="{{ asset('/logo.png') }}" alt="Logo Paroki Babadan" class="w-8 h-8 rounded-md">
                <h1 class="text-[15px] ml-3 text-xl text-gray-200 font-bold">Paroki Babadan</h1>
                <i class="bi bi-x ml-20 cursor-pointer" onclick="toggleSidebar()"></i>
            </div>
            <hr class="my-2 text-gray-600">
            <div class="menu-item p-2.5 mt-2 flex items-center rounded-md px-4 cursor-pointer hover:bg-blue-600">
            <i class="bi bi-window-sidebar"></i>
                <span class="text-[20px] ml-4 text-gray-200">Beranda</span>
            </div>
            <div class="menu-item p-2.5 mt-2 flex items-center rounded-md px-4 cursor-pointer hover:bg-blue-600">
                <i class="bi bi-person-circle"></i>
                <span class="text-[15px] ml-4 text-gray-200">Profil</span>
            </div>
            <div class="menu-item p-2.5 mt-2 flex items-center rounded-md px-4 cursor-pointer hover:bg-blue-600">
                <i class="bi bi-house-door-fill"></i>
                <span class="text-[15px] ml-4 text-gray-200" href="/Ruangan.blade.php"> Ruangan</span>
            </div>
            <div class="menu-item p-2.5 mt-2 flex items-center rounded-md px-4 cursor-pointer hover:bg-blue-600">
            <i class="bi bi-inboxes-fill"></i>
                <span class="text-[15px] ml-4 text-gray-200">Barang dan Aset</span>
            </div>
            <div class="menu-item p-2.5 mt-2 flex items-center rounded-md px-4 cursor-pointer hover:bg-blue-600">
                <i class="bi bi-clock-fill"></i>
                <span class="text-[15px] ml-4 text-gray-200">Histori Peminjaman</span>
            </div>
            <div class="menu-item p-2.5 mt-2 flex items-center rounded-md px-4 cursor-pointer hover:bg-blue-600">
                <i class="bi bi-arrow-return-left"></i>
                <span class="text-[15px] ml-4 text-gray-200">Pengembalian</span>
            </div>
            <hr class="my-4 text-gray-600">
            <div class="menu-item p-2.5 mt-3 flex items-center rounded-md px-4 cursor-pointer hover:bg-blue-600">
                <i class="bi bi-box-arrow-in-right"></i>
                <span class="text-[15px] ml-4 text-gray-200">Logout</span>
            </div>
        </div>
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