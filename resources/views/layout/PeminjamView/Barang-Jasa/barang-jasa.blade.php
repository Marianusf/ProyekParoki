@extends('layout.TemplateAdmin')

@section('title', 'profil')

@section('content')

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil - Paroki St Petrus dan Paulus</title>
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<section class="p-6 bg-gray-100 min-h-screen">
<body class="bg-gray-100 flex justify-center items-center min-h-screen">
    <div class="bg-white w-full max-w-2xl p-6 rounded-lg shadow-md">
        <h2 class="text-2xl font-semibold text-gray-800 mb-2">Barang Dan Aset</h2>
        <p class="text-gray-500 mb-4">PAROKI ST PETRUS DAN PAULUS</p>
    </div>
</body>
</section>
@endsection

@section('scripts')
<script>
// Additional JavaScript specific to this page
console.log('Home page script loaded.');
</script>
@endsection