<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistem Peminjaman Gereja</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@200;300;400;500;600;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css">
    @vite(['resources/css/app.css'])
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(135deg, #1e3a8a, #3b82f6, #60a5fa);
            background-size: 400% 400%;
            animation: gradientBG 10s ease infinite;
        }
        @keyframes gradientBG {
            0%, 100% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
        }
        .sidebar {
            transition: left 1.4s ease;
            background: linear-gradient(135deg, #1e293b, #334155);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.2);
            position: fixed;
            top: 0;
            bottom: 0;
            left: -300px;
            width: 300px;
            z-index: 1000;
        }
        @media (max-width: 768px) {
            .sidebar {
                width: 100%;
                left: -100%;
            }
        }
        .main-content {
            transition: margin-left 1.3s ease;
        }
        .sidebar i:hover {
            color: #60a5fa;
            transform: scale(1.1);
        }
        .sidebar .menu-item:hover {
            background-color: #2563eb;
            color: white;
            transition: background 0.3s ease;
        }
        .card {
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            background: #f3f4f6;
            background-image: linear-gradient(45deg, rgba(255, 255, 255, 0.15) 25%, transparent 25%, transparent 50%, rgba(255, 255, 255, 0.15) 50%, rgba(255, 255, 255, 0.15) 75%, transparent 75%, transparent);
            background-size: 40px 40px;
        }
        .card:hover {
            transform: translateY(-10px);
            box-shadow: 0 12px 25px rgba(0, 0, 0, 0.3);
        }
    </style>
</head>
<body>
<nav class="bg-white p-3">
    <div class="container mx-auto flex justify-between items-center">
        <div class="flex flex-shrink-0 items-center">
            <img class="h-40 w-40" src="/Gambar/logo.png" alt="Logo">
            <div class="container mx-auto flex flex-col items-center">
                <span class="text-gray-500 font-serif mb-2 text-xl shadow-sm">Gereja Santo Petrus dan Paulus</span>
                <span class="text-gray-700 text-4xl font-bold p-2 rounded-lg shadow-lg transition duration-300">
                    PAROKI BABADAN
                </span>
            </div>
        </div>
    </div>
</nav>

<div id="sidebar" class="sidebar">
    <div class="text-gray-100 text-xl">
        <div class="p-2.5 mt-1 flex items-center rounded-md">
            <div class="w-20 h-20 bg-gray-300 rounded-full"> <img  src="/Gambar/logo.png" alt="Logo"></div>
            <div class="ml-4">
                <h2 class="text-lg font-semibold text-gray-200">Daniel</h2>
                <p class="text-sm text-gray-200">Ketua Lingkungan</p>
            </div>
            <i class="bi bi-list ml-20 cursor-pointer lg:hidden" onclick="Openbar()"></i>
        </div>
        <hr class="my-2 text-gray-400">

        <div>
        <div class="menu-item p-2.5 mt-2 flex items-center rounded-md px-4 cursor-pointer hover:bg-blue-600">
                <i class="bi bi-person-circle"></i>
                <span class="text-[15px] ml-4 text-gray-200">Beranda</span>
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
                <i class="bi bi-bookmark-fill"></i>
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

<div class="bg-cover bg-center w-full h-full min-h-screen" style="background-image: url('/Gambar/gereja.png');">
    <div id="main-content" class="main-content ml-0 p-8 relative pt-16 min-h-screen">
        <span id="toggle-button" class="absolute text-white text-2xl top-5 left-6 cursor-pointer" onclick="Openbar()">
            <i class="bi bi-filter-left px-3 bg-gray-900 rounded-lg"></i>
        </span>
        <div class="container mx-auto mt-10">
      <div class="p-6 rounded-md bg-gray-100 h-90 w-auto">
        <h2 class="text-2xl font-bold mb-4">Peminjaman Ruangan</h2>
        <div class="mb-2">
          <input
            type="text"
            placeholder="RUANGAN 2"
            class="w-full p-3 rounded-md border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500"
            readonly
          />
        </div>
        <div class="mb-4">
          <label
            for="penanggung_jawab"
            class="block text-gray-700 text-sm font-bold mb-2"
            >Penanggung Jawab</label
          >
          <input
            type="text"
            id="penanggung_jawab"
            placeholder="Input penanggung jawab"
            class="w-full p-3 rounded-md border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500"
          />
        </div>
        <div class="grid grid-cols-3 gap-4 mb-4">
          <div>
            <label
              for="tanggal_peminjaman"
              class="block text-gray-700 text-sm font-bold mb-2"
              >Tanggal Peminjaman</label
            >
            <input
              type="date"
              id="tanggal_peminjaman"
              class="w-full p-3 rounded-md border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500"
            />
          </div>
          <div>
            <label
              for="jam_peminjaman"
              class="block text-gray-700 text-sm font-bold mb-2"
              >Jam Peminjaman</label
            >
            <input
              type="time"
              id="jam_peminjaman"
              class="w-full p-3 rounded-md border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500"
            />
          </div>
          <div>
            <label
              for="durasi_peminjaman"
              class="block text-gray-700 text-sm font-bold mb-2"
              >Durasi Peminjaman</label
            >
            <input
              type="number"
              id="durasi_peminjaman"
              class="w-full p-3 rounded-md border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500"
            />
          </div>
        </div>
        <button
          class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded"
        >Submit
        </button>
      </div>
      </div>
      </div>
      </div>

             
                <footer class="bg-gray-800 text-white py-2 text-center">
                    <p>&copy; {{ date('Y') }} Babadan Application. All rights reserved.</p>
                </footer>
            </div>

<script>
    function Openbar() {
        const sidebar = document.getElementById('sidebar');
        const mainContent = document.getElementById('main-content');

        if (sidebar.style.left === "0px" || sidebar.style.left === "") {
            sidebar.style.left = "-100%"; // Menyembunyikan sidebar di luar layar
            mainContent.style.marginLeft = "0px"; // Mengatur margin konten utama
        } else {
            sidebar.style.left = "0px"; // Menampilkan sidebar
            mainContent.style.marginLeft = "300px"; // Mengatur margin konten utama saat sidebar terbuka
        }
    }
</script>

</body>
</html>
