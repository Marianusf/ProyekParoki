@extends('layoutPeminjam')

@section('title','Ruangan')
    <!-- Main Content -->
    <div class="w-3/4 p-8">
        <div class="flex items-center justify-between">
            <h1 class="text-2xl font-semibold">Ruangan</h1>
            <button class="p-2 text-gray-500 hover:text-gray-700 focus:outline-none">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="w-6 h-6">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 15.158V11a8.001 8.001 0 10-8 8v-3h4v3z" />
                </svg>
            </button>
        </div>
        
        <div class="grid grid-cols-2 gap-4 mt-6">
            <!-- Room Card 1 -->
            <div class="bg-white p-4 rounded-lg shadow flex items-center justify-between">
                <div>
                    <h2 class="text-lg font-semibold">Aula Gereja</h2>
                    <span class="inline-block bg-red-200 text-red-800 px-2 py-1 text-xs font-semibold rounded">Digunakan</span>
                </div>
            </div>

            <!-- Room Card 2 -->
            <div class="bg-white p-4 rounded-lg shadow flex items-center justify-between">
                <div>
                    <h2 class="text-lg font-semibold">Ruangan 2</h2>
                    <span class="inline-block bg-yellow-200 text-yellow-800 px-2 py-1 text-xs font-semibold rounded">Booking</span>
                </div>
                </button>
            </div>

            <!-- Room Card 3 -->
            <div class="bg-white p-4 rounded-lg shadow flex items-center justify-between">
                <div>
                    <h2 class="text-lg font-semibold">Ruangan 4</h2>
                    <span class="inline-block bg-green-200 text-green-800 px-2 py-1 text-xs font-semibold rounded">Tersedia</span>
                </div>
            </div>
            <!-- Room Card 4 -->
            <div class="bg-white p-4 rounded-lg shadow flex items-center justify-between">
                <div>
                    <h2 class="text-lg font-semibold">Ruangan 5</h2>
                    <span class="inline-block bg-green-200 text-green-800 px-2 py-1 text-xs font-semibold rounded">Tersedia</span>
                </div>
            </div>
        </div>
    </div>
</div>

@section('scripts')
@endsection