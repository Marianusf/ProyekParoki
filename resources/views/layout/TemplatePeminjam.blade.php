<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
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
        top: 0;
        bottom: 0;
        left: -300px; /* Hidden by default */
        width: 300px;
        background-color: #1f2937; /* Tailwind's gray-900 */
        height: 100vh; /* Full height */
        overflow-y: auto; /* Scroll if content is too long */
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

    /* Responsive adjustments */
    @media (max-width: 768px) {
        .sidebar {
            width: 80%; /* Change to a smaller width on mobile */
            left: -80%; /* Hide it off-screen initially */
        }

        .sidebar.show {
            left: 0; /* Show it when active */
        }

        .main-content.shifted {
            margin-left: 80%; /* Adjust main content for the sidebar width on mobile */
        }
    }
</style>

</head>

<body class="bg-blue-600">
    <span class="absolute text-white text-4xl top-5 left-4 cursor-pointer" onclick="toggleSidebar()">
        <i class="bi bi-filter-left px-2 bg-gray-900 rounded-md"></i>
    </span>

    <div class="sidebar" id="sidebar">
    <div class="text-gray-100 text-xl">
        <div class="p-2.5 mt-1 flex items-center rounded-md">
            <div class="w-20 h-20 bg-gray-300 rounded-full"> <img  src="/Gambar/logo.png" alt="Logo"></div>
            <div class="ml-4">
            
            <h2 class="text-lg font-semibold text-gray-200">Daniel</h2>
            <p class="text-sm text-gray-200">Ketua Lingkungan</p>
            </div>
                
                <i class="bi bi-x ml-auto cursor-pointer" onclick="toggleSidebar()"></i>
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
        let isManualToggle = false; // Track manual toggle

        function toggleSidebar() {
            isManualToggle = !isManualToggle;
            sidebar.classList.toggle('show');
            mainContent.classList.toggle('shifted');
        }

        sidebar.addEventListener('mouseenter', () => {
            if (!isManualToggle) {
                sidebar.classList.add('show');
                mainContent.classList.add('shifted');
            }
        });

        sidebar.addEventListener('mouseleave', () => {
            if (!isManualToggle) {
                sidebar.classList.remove('show');
                mainContent.classList.remove('shifted');
            }
        });

        // Ensure the sidebar is hidden on load
        window.onload = () => {
            sidebar.classList.remove('show');
            mainContent.classList.remove('shifted');
            isManualToggle = false;
        };
    </script>
    <script>
        @yield('scripts')
    </script>
</body>

</html>
