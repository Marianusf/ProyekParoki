<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@200;300;400;500;600;800&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css">
</head>

<body class="bg-blue-600 font-[Poppins]">
    <!-- Toggle Sidebar Button -->
    <span class="absolute text-white text-4xl top-5 left-4 cursor-pointer" onclick="Openbar()">
        <i class="bi bi-filter-left px-2 bg-gray-900 rounded-md"></i>
    </span>


    <div
        class="sidebar fixed top-0 bottom-0 lg:left-0 left-[-300px] duration-1000 p-2 w-[300px] overflow-y-auto text-center bg-gray-900 shadow h-screen">
        <div class="text-gray-100 text-xl">


            <div class="p-2.5 mt-1 flex items-center rounded-md">
                <img src="{{ asset('/logo.png') }}" alt="Logo Paroki Babadan" class="w-8 h-8 rounded-md">
                <h1 class="text-[15px] ml-3 text-xl text-gray-200 font-bold">Paroki Babadan</h1>
                <i class="bi bi-x ml-20 cursor-pointer lg:hidden" onclick="Openbar()"></i>
            </div>
            <hr class="my-2 text-gray-600">

            <div>
                <div class="p-2.5 mt-3 flex items-center rounded-md px-4 duration-300 cursor-pointer bg-gray-700">
                    <i class="bi bi-search text-sm"></i>
                    <input id="searchInput" class="text-[15px] ml-4 w-full bg-transparent focus:outline-none"
                        placeholder="Cari aset" oninput="filterAssets()" />
                </div>


                <a href="/home"
                    class="p-2.5 mt-2 flex items-center rounded-md px-4 duration-300 cursor-pointer hover:bg-blue-600">
                    <i class="bi bi-house-door-fill"></i>
                    <span class="text-[15px] ml-4 text-gray-200">Home</span>
                </a>
                <a href="/requests"
                    class="p-2.5 mt-2 flex items-center rounded-md px-4 duration-300 cursor-pointer hover:bg-blue-600">
                    <i class="bi bi-person-check-fill"></i>
                    <span class="text-[15px] ml-4 text-gray-200">Persetujuan Akun</span>
                </a>
                <a href="/loan-requests"
                    class="p-2.5 mt-2 flex items-center rounded-md px-4 duration-300 cursor-pointer hover:bg-blue-600">
                    <i class="bi bi-check-square-fill"></i>
                    <span class="text-[15px] ml-4 text-gray-200">Persetujuan Peminjaman</span>
                </a>

                <a href="/add-asset"
                    class="p-2.5 mt-2 flex items-center rounded-md px-4 duration-300 cursor-pointer hover:bg-blue-600">
                    <i class="bi bi-plus-circle"></i>
                    <span class="text-[15px] ml-4 text-gray-200">Tambah Aset</span>
                </a>
                <a href="/view-assets"
                    class="p-2.5 mt-2 flex items-center rounded-md px-4 duration-300 cursor-pointer hover:bg-blue-600">
                    <i class="bi bi-list-ul"></i>
                    <span class="text-[15px] ml-4 text-gray-200">Lihat Aset</span>
                </a>
                <a href="/delete-asset"
                    class="p-2.5 mt-2 flex items-center rounded-md px-4 duration-300 cursor-pointer hover:bg-blue-600">
                    <i class="bi bi-trash-fill"></i>
                    <span class="text-[15px] ml-4 text-gray-200">Hapus Aset</span>
                </a>
                <a href="/check-availability"
                    class="p-2.5 mt-2 flex items-center rounded-md px-4 duration-300 cursor-pointer hover:bg-blue-600">
                    <i class="bi bi-eye-fill"></i>
                    <span class="text-[15px] ml-4 text-gray-200">Cek Ketersediaan Aset</span>
                </a>

                <hr class="my-4 text-gray-600">

                <a href="/members"
                    class="p-2.5 mt-2 flex items-center rounded-md px-4 duration-300 cursor-pointer hover:bg-blue-600">
                    <i class="bi bi-people-fill"></i>
                    <span class="text-[15px] ml-4 text-gray-200">Lihat Peminjam</span>
                </a>
                <a href="/login"
                    class="p-2.5 mt-3 flex items-center rounded-md px-4 duration-300 cursor-pointer hover:bg-blue-600">
                    <i class="bi bi-box-arrow-in-right"></i>
                    <span class="text-[15px] ml-4 text-gray-200">Logout</span>
                </a>
            </div>

        </div>
    </div>

    <script>
        function Openbar() {
            document.querySelector('.sidebar').classList.toggle('left-[-300px]');
        }

        // Event listener to close sidebar if clicked outside
        document.addEventListener('click', function(event) {
            const sidebar = document.querySelector('.sidebar');
            const toggleButton = document.querySelector('.absolute.text-white'); // Sidebar toggle button
            if (!sidebar.contains(event.target) && !toggleButton.contains(event.target)) {
                sidebar.classList.add('left-[-300px]');
            }
        });

        function filterAssets() {
            const filter = document.getElementById("searchInput").value.toLowerCase();
            const items = document.querySelectorAll(".asset-item");

            items.forEach(item => {
                const text = item.textContent.toLowerCase();
                item.style.display = text.includes(filter) ? "" : "none";
            });
        }
    </script>
</body>

</html>
