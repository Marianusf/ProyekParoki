@extends('layout.TemplatePeminjam')

@section('title', 'Login')

@section('content')
<script src="https://cdn.tailwindcss.com"></script>
<!-- Mengubah latar belakang menjadi biru muda -->
<style>
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

<!-- Menambahkan pustaka Flatpickr -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<nav class="bg-gray-800 p-4">
  <div class="max-w-7xl mx-auto px-2 sm:px-6 lg:px-8">
    <div class="flex items-center justify-between h-16">
      <button class="sm:hidden p-2 text-gray-400 hover:bg-gray-700 hover:text-white" aria-controls="mobile-menu" aria-expanded="false">
        <span class="sr-only">Open main menu</span>
        <svg class="block h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" /></svg>
        <svg class="hidden h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" /></svg>
      </button>
      <div class="flex items-center ">
      <img class="h-30 w-30" src="/Gambar/logo.png" alt="Logo">
      <div class="ml-4 flex flex-col items-start">
                <span class="text-white font-serif mb-2 text-xl shadow-sm">Gereja Santo Petrus dan Paulus</span>
                <span class="text-white text-2xl md:text-4xl font-bold p-2 rounded-lg shadow-lg transition duration-300">
                    PAROKI BABADAN
                </span>
            </div>
        <div class="hidden sm:flex space-x-4 ml-6">
          <a href="#" class="bg-gray-900 text-white px-3 py-2 text-sm font-medium">Dashboard</a>
          <a href="#" class="text-gray-300 hover:bg-gray-700 hover:text-white px-3 py-2 text-sm font-medium">Team</a>
          <a href="#" class="text-gray-300 hover:bg-gray-700 hover:text-white px-3 py-2 text-sm font-medium">Projects</a>
          <a href="#" class="text-gray-300 hover:bg-gray-700 hover:text-white px-3 py-2 text-sm font-medium">Calendar</a>
        </div>
      </div>
      <div class="flex items-center">
        <button class="p-1 text-gray-400 hover:text-white" aria-label="View notifications">
          <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M14.857 17.082a23.848 23.848 0 0 0 5.454-1.31A8.967 8.967 0 0 1 18 9.75V9A6 6 0 0 0 6 9v.75a8.967 8.967 0 0 1-2.312 6.022c1.733.64 3.56 1.085 5.455 1.31m5.714 0a24.255 24.255 0 0 1-5.714 0m5.714 0a3 3 0 1 1-5.714 0" /></svg>
        </button>
        <div class="relative ml-3">
          <button id="user-menu-button" aria-expanded="false">
            <span class="sr-only">Open user menu</span>
            <img class="h-8 w-8 rounded-full" src="https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?auto=format&fit=facearea&facepad=2&w=256&h=256&q=80" alt="">
          </button>
          <div class="hidden" id="user-menu">
            <a href="#" class="block px-4 py-2 text-sm text-gray-700">Your Profile</a>
            <a href="#" class="block px-4 py-2 text-sm text-gray-700">Settings</a>
            <a href="#" class="block px-4 py-2 text-sm text-gray-700">Sign out</a>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="sm:hidden" id="mobile-menu">
    <a href="#" class="block bg-gray-900 text-white px-3 py-2">Dashboard</a>
    <a href="#" class="block text-gray-300 hover:bg-gray-700 hover:text-white px-3 py-2">Team</a>
    <a href="#" class="block text-gray-300 hover:bg-gray-700 hover:text-white px-3 py-2">Projects</a>
    <a href="#" class="block text-gray-300 hover:bg-gray-700 hover:text-white px-3 py-2">Calendar</a>
  </div>
</nav>

<section class="w-full h-full min-h-screen">
    <div class="bg-cover bg-white bg-center w-full h-full min-h-screen" style="background-image: url('/Gambar/.png');">
        <div id="main-content" class="main-content p-4 md:p-8 relative pt-16 min-h-screen">
           

            <!-- Tambahkan div untuk border melingkar di sekitar h1 -->
            <div class="flex justify-center items-center p-9">
            <div class="border-4 border-gray-800 rounded-full py-4 px-8 inline-block mx-auto text-center">
                <h1 id="room-title" class="text-3xl md:text-6xl font-semibold text-gray-700 text-center">Ruangan</h1>
                
</div>
          
</div>
            <div class="bg-blue-200 rounded-3xl shadow-lg  md:p-6 text-center">
                <div class="mt-8">
                <div id="room-grid" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
    <a href="{{ route('peminjam.Ruangan', ['id' => 1]) }}" class="card bg-white p-4 rounded-lg shadow-lg hover:shadow-xl transition-shadow">
        <div class="flex justify-between items-center">
            
            <span class="text-lg font-semibold">Aula Gereja 1</span>
            <span class="bg-red-200 text-red-600 px-2 py-1 rounded">Digunakan</span>
            <button class="w-6 h-6 flex items-center justify-center ml-2 text-gray-600 hover:bg-gray-200 rounded" aria-label="More options">
                <i class="bi bi-three-dots-vertical" style="font-size:18px;"></i>
            </button>
        </div>
       
    </a>
                     
                        <a href="{{ route('peminjam.Ruangan', ['id' => 2]) }}" class="card bg-white p-4 rounded-lg shadow-lg">
        <div class="flex justify-between items-center">
            <span class="text-lg font-semibold">Aula Gereja</span>
            <span class="bg-red-200 text-red-600 px-2 py-1 rounded">Digunakan</span>
            <span class=" text-red-600 px-2 py-1 rounded">Dari Jam:10:00</span>
            <span class=" text-red-600 px-2 py-1 rounded">Sampai:11:00</span>
            <button class="w-6 h-6 flex items-center justify-center ml-0 text-gray-600 hover:bg-gray-200 rounded">
                <i class="bi bi-three-dots-vertical" style="font-size:18px;"></i>
            </button>
        </div>
    </a>
                           
    <a href="{{ route('peminjam.Ruangan', ['id' => 2]) }}" class="card bg-white p-4 rounded-lg shadow-lg">
        <div class="flex justify-between items-center">
            <span class="text-lg font-semibold">Aula Gereja</span>
            <span class="bg-red-200 text-red-600 px-2 py-1 rounded">Digunakan</span>
            <button class="w-6 h-6 flex items-center justify-center ml-2 text-gray-600 hover:bg-gray-200 rounded">
                <i class="bi bi-three-dots-vertical" style="font-size:18px;"></i>
            </button>
        </div>
    </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <footer class="bg-gray-800 text-white py-2 text-center">
        <p>&copy; {{ date('Y') }} Babadan Application. All rights reserved.</p>
    </footer>
</section>

@endsection

@section('scripts')
<script>
    // Your custom JavaScript can go here.
</script>
@endsection
