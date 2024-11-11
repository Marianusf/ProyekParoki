@extends('layout.TemplatePeminjam')

@section('title', 'Dashboard')

@section('content')
<script src="https://cdn.tailwindcss.com"></script>
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

<section class="w-full h-full min-h-screen flex justify-center items-center">
    <div class="container mx-auto">
        <div class="bg-cover bg-white bg-center w-full min-h-screen" style="background-image: url('/Gambar/.png');">
            <div id="main-content" class="main-content p-4 md:p-8 relative pt-16 min-h-screen">
                <div class="flex justify-center items-center p-9">
                    <div class="border-4 border-gray-800 rounded-full py-4 px-8 inline-block text-center">
                        <h1 id="room-title" class="text-3xl md:text-6xl font-semibold text-gray-700">Ruangan</h1>
                    </div>
                </div>
                <div class="bg-blue-200 rounded-3xl shadow-lg md:p-6 text-center">
                    <div class="mt-8">
                        <div id="room-grid" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
                            @php
                                $rooms = [
                                    ['id' => 1, 'name' => 'Aula Gereja 1','status'=>'Digunakan'],
                                    ['id' => 2, 'name' => 'Aula Gereja 2','status'=>'Booking'],
                                    ['id' => 3, 'name' => 'Aula Gereja 3','status'=>'Tersedia'],
                                ];
                            @endphp

                            @foreach($rooms as $room)
    <div class="card bg-white p-4 rounded-lg shadow-lg hover:shadow-xl">
        <div class="flex justify-between items-center">
            <span class="text-lg font-semibold text-gray-800">{{ $room['name'] }}</span>
            <span 
                class="
                    px-2 py-1 rounded 
                    @if($room['status'] == 'Booking') bg-yellow-200 text-yellow-600 
                    @elseif($room['status'] == 'Tersedia') bg-green-200 text-green-600 
                    @else bg-red-200 text-red-600 
                    @endif
                "
            >
                {{ $room['status'] }}
            </span>
        </div>
        <div class="flex justify-between items-center mt-4">
            <a href="{{ route('pinjam.Ruangan', ['id' => $room['id']]) }}" class="bg-green-700 text-white px-4 py-2 rounded hover:bg-green-800">Pinjam</a>
            <a href="{{ route('pinjam.InformasiRuangan', ['id' => $room['id']]) }}" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-500">Informasi</a>
        </div>
    </div>
@endforeach

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@section('scripts')
<script>
    // JavaScript tambahan
</script>
@endsection
