<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- SweetAlert2 CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <!-- SweetAlert2 JS -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.all.min.js"></script>
    <!-- SweetAlert2 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" rel="stylesheet">

    <!-- SweetAlert2 JS -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <title>@yield('title', 'Authentication')</title>
    @vite('resources/css/app.css') <!-- Memuat Tailwind CSS -->
</head>

<body class="bg-[#7cb1ff] min-h-screen flex flex-col">
    <main class="flex-grow flex justify-center items-center">
        <div class="bg-[#7cb1ff] rounded-2xl flex max-w-3xl p-3 items-center">
            <div class="flex flex-col w-full max-w-3xl px-8 mx-auto">
                <header class="bg-[#3e73c9] text-white py-2 shadow-md">
                    <div class="container mx-auto flex justify-center items-center">
                        <div
                            class="container mx-auto flex flex-col items-center max-w-lg w-full p-4 shadow-lg transition-transform duration-100 transform hover:scale-105 bg-white rounded-xl">
                            {{-- <a href="/" class="flex items-center text-2xl font-bold"> --}}
                            <img src="/logo.png" alt="Logo" class="h-12 md:h-20 inline-block mr-2">
                            <span class="text-[#002D74]">PAROKI BABADAN</span>
                            {{-- </a> --}}
                        </div>
                    </div>
                </header>

                <div id="main-content" class="w-full p-0">
                    @yield('content')
                </div>
                <footer class="bg-gray-800 text-white py-2 text-center">
                    <p>&copy; {{ date('Y') }} Babadan Application. All rights reserved.</p>
                </footer>
            </div>
        </div>
    </main>

    @yield('scripts') <!-- Menambahkan skrip di sini -->
</body>

</html>
