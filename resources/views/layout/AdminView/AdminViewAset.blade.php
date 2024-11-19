@extends('layout.TemplateAdmin')

@section('title', 'Lihat Aset')

@section('content')

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lihat Aset</title>
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<section class="p-6 bg-gray-100 min-h-screen rounded-md ">
    <div class="max-w-7xl mx-auto bg-white shadow-md rounded-md">
        <div class="px-6 py-4 border-b rounded-t-md flex">
            <div class="basis-1/2">
                <h2 class="text-xl font-semibold basis-0">Aset</h2>
                <p class="text-gray-500 basis-1">List Atribut Aset</p>
            </div>
            <div class="basis-1/2  ml-auto flex justify-end items-center space-x-2 ">
                <input type="text" id="cari_aset" value="" placeholder="Masukkan nama aset">
                <input type="button" id="myButton" value="Cari" onclick="alert('Mencari...')"
                    class="px-4 py-2 bg-blue-500 text-white font-semibold rounded-lg shadow-md hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-400 focus:ring-opacity-75 cursor-pointer">
            </div>
        </div>

        <div class="px-6 py-4 h-screen border border-black"> <!-- induk tinggi screen disini -->
            <div class="overflow-y-auto border rounded-lg max-h-[80%]"> <!-- ubah ketinggian jika memakai max-h-96 pakai overflow-y-scroll -->
                <table class="w-full text-left">
                    <thead>
                        <tr class="sticky top-0 z-10 bg-blue-300 ">
                            <th class="py-2 px-4 border-b-2 font-semibold text-gray-700">ID Aset</th>
                            <th class="py-2 px-4 border-b-2 font-semibold text-gray-700">Nama Aset</th>
                            <th class="py-2 px-4 border-b-2 font-semibold text-gray-700">Deskripsi</th>
                            <th class="py-2 px-4 border-b-2 font-semibold text-gray-700">Status</th>
                            <th class="py-2 px-4 border-b-2 font-semibold text-gray-700">Jenis Aset</th>
                        </tr>
                    </thead>
                    <tbody class="text-gray-600">
                        <?php if (!empty($asetModel) && is_array($asetModel)) : ?>
                            <?php foreach ($asetModel as $aset) : ?>
                                <tr class="border-b odd:bg-white even:bg-blue-100 hover:bg-blue-200">
                                    <td class="py-3 px-4"><?= $aset['idaset'] ?></td>
                                    <td class="py-3 px-4"><?= $aset['nama'] ?></td>
                                    <td class="py-3 px-4"><?= $aset['deskripsi'] ?></td>
                                    <td class="py-3 px-4"><?= $aset['status'] ?></td>
                                    <td class="py-3 px-4"><?= $aset['jenis'] ?></td>
                                </tr>
                            <?php endforeach ?>
                        <?php else : ?>
                            <tr class="border-b odd:bg-white even:bg-blue-100 ">
                                <td class="py-3 px-4">Tidak ada data aset.</td>
                            </tr>
                        <?php endif ?>
                        <tr class="border-b odd:bg-white even:bg-blue-100 hover:bg-blue-200">
                            <td class="py-3 px-4">1</td>
                            <td class="py-3 px-4">Laptop Dell XPS</td>
                            <td class="py-3 px-4">Laptop untuk pengembangan software</td>
                            <td class="py-3 px-4">Aktif</td>
                            <td class="py-3 px-4">Elektronik</td>
                        </tr>
                        <tr class="border-b odd:bg-white even:bg-blue-100 hover:bg-blue-200">
                            <td class="py-3 px-4">1</td>
                            <td class="py-3 px-4">Meja Kantor</td>
                            <td class="py-3 px-4">Meja kerja kayu jati</td>
                            <td class="py-3 px-4">Dipakai</td>
                            <td class="py-3 px-4">Furniture</td>
                        </tr>
                        <tr class="border-b odd:bg-white even:bg-blue-100 hover:bg-blue-200">
                            <td class="py-3 px-4">1</td>
                            <td class="py-3 px-4">Proyektor Epson</td>
                            <td class="py-3 px-4">Proyektor untuk presentasi</td>
                            <td class="py-3 px-4">Aktif</td>
                            <td class="py-3 px-4">Elektronik</td>
                        </tr>
                        <tr class="border-b odd:bg-white even:bg-blue-100 hover:bg-blue-200">
                            <td class="py-3 px-4">1</td>
                            <td class="py-3 px-4">Kursi Ergonomis</td>
                            <td class="py-3 px-4">Kursi dengan penyangga punggung</td>
                            <td class="py-3 px-4">Dipakai</td>
                            <td class="py-3 px-4">Furniture</td>
                        </tr>
                        <tr class="border-b odd:bg-white even:bg-blue-100 hover:bg-blue-200">
                            <td class="py-3 px-4">1</td>
                            <td class="py-3 px-4">Printer HP LaserJet</td>
                            <td class="py-3 px-4">Printer untuk kebutuhan kantor</td>
                            <td class="py-3 px-4">Aktif</td>
                            <td class="py-3 px-4">Elektronik</td>
                        </tr>
                        <tr class="border-b odd:bg-white even:bg-blue-100 hover:bg-blue-200">
                            <td class="py-3 px-4">1</td>
                            <td class="py-3 px-4">Mobil Operasional</td>
                            <td class="py-3 px-4">Mobil untuk perjalanan dinas</td>
                            <td class="py-3 px-4">Aktif</td>
                            <td class="py-3 px-4">Kendaraan</td>
                        </tr>
                        <tr class="border-b odd:bg-white even:bg-blue-100 hover:bg-blue-200">
                            <td class="py-3 px-4">1</td>
                            <td class="py-3 px-4">Laptop Dell XPS</td>
                            <td class="py-3 px-4">Laptop untuk pengembangan software</td>
                            <td class="py-3 px-4">Aktif</td>
                            <td class="py-3 px-4">Elektronik</td>
                        </tr>
                        <tr class="border-b odd:bg-white even:bg-blue-100 hover:bg-blue-200">
                            <td class="py-3 px-4">1</td>
                            <td class="py-3 px-4">Meja Kantor</td>
                            <td class="py-3 px-4">Meja kerja kayu jati</td>
                            <td class="py-3 px-4">Dipakai</td>
                            <td class="py-3 px-4">Furniture</td>
                        </tr>
                        <tr class="border-b odd:bg-white even:bg-blue-100 hover:bg-blue-200">
                            <td class="py-3 px-4">1</td>
                            <td class="py-3 px-4">Proyektor Epson</td>
                            <td class="py-3 px-4">Proyektor untuk presentasi</td>
                            <td class="py-3 px-4">Aktif</td>
                            <td class="py-3 px-4">Elektronik</td>
                        </tr>
                        <tr class="border-b odd:bg-white even:bg-blue-100 hover:bg-blue-200">
                            <td class="py-3 px-4">1</td>
                            <td class="py-3 px-4">Kursi Ergonomis</td>
                            <td class="py-3 px-4">Kursi dengan penyangga punggung</td>
                            <td class="py-3 px-4">Dipakai</td>
                            <td class="py-3 px-4">Furniture</td>
                        </tr>
                        <tr class="border-b odd:bg-white even:bg-blue-100 hover:bg-blue-200">
                            <td class="py-3 px-4">1</td>
                            <td class="py-3 px-4">Printer HP LaserJet</td>
                            <td class="py-3 px-4">Printer untuk kebutuhan kantor</td>
                            <td class="py-3 px-4">Aktif</td>
                            <td class="py-3 px-4">Elektronik</td>
                        </tr>
                        <tr class="border-b odd:bg-white even:bg-blue-100 hover:bg-blue-200">
                            <td class="py-3 px-4">1</td>
                            <td class="py-3 px-4">Mobil Operasional</td>
                            <td class="py-3 px-4">Mobil untuk perjalanan dinas</td>
                            <td class="py-3 px-4">Aktif</td>
                            <td class="py-3 px-4">Kendaraan</td>
                        </tr>
                        <tr class="border-b odd:bg-white even:bg-blue-100 hover:bg-blue-200">
                            <td class="py-3 px-4">1</td>
                            <td class="py-3 px-4">Laptop Dell XPS</td>
                            <td class="py-3 px-4">Laptop untuk pengembangan software</td>
                            <td class="py-3 px-4">Aktif</td>
                            <td class="py-3 px-4">Elektronik</td>
                        </tr>
                        <tr class="border-b odd:bg-white even:bg-blue-100 hover:bg-blue-200">
                            <td class="py-3 px-4">1</td>
                            <td class="py-3 px-4">Meja Kantor</td>
                            <td class="py-3 px-4">Meja kerja kayu jati</td>
                            <td class="py-3 px-4">Dipakai</td>
                            <td class="py-3 px-4">Furniture</td>
                        </tr>
                        <tr class="border-b odd:bg-white even:bg-blue-100 hover:bg-blue-200">
                            <td class="py-3 px-4">1</td>
                            <td class="py-3 px-4">Proyektor Epson</td>
                            <td class="py-3 px-4">Proyektor untuk presentasi</td>
                            <td class="py-3 px-4">Aktif</td>
                            <td class="py-3 px-4">Elektronik</td>
                        </tr>
                        <tr class="border-b odd:bg-white even:bg-blue-100 hover:bg-blue-200">
                            <td class="py-3 px-4">1</td>
                            <td class="py-3 px-4">Kursi Ergonomis</td>
                            <td class="py-3 px-4">Kursi dengan penyangga punggung</td>
                            <td class="py-3 px-4">Dipakai</td>
                            <td class="py-3 px-4">Furniture</td>
                        </tr>
                        <tr class="border-b odd:bg-white even:bg-blue-100 hover:bg-blue-200">
                            <td class="py-3 px-4">1</td>
                            <td class="py-3 px-4">Printer HP LaserJet</td>
                            <td class="py-3 px-4">Printer untuk kebutuhan kantor</td>
                            <td class="py-3 px-4">Aktif</td>
                            <td class="py-3 px-4">Elektronik</td>
                        </tr>
                        <tr class="border-b odd:bg-white even:bg-blue-100 hover:bg-blue-200">
                            <td class="py-3 px-4">1</td>
                            <td class="py-3 px-4">Mobil Operasional</td>
                            <td class="py-3 px-4">Mobil untuk perjalanan dinas</td>
                            <td class="py-3 px-4">Aktif</td>
                            <td class="py-3 px-4">Kendaraan</td>
                        </tr>
                        <tr class="border-b odd:bg-white even:bg-blue-100 hover:bg-blue-200">
                            <td class="py-3 px-4">1</td>
                            <td class="py-3 px-4">Laptop Dell XPS</td>
                            <td class="py-3 px-4">Laptop untuk pengembangan software</td>
                            <td class="py-3 px-4">Aktif</td>
                            <td class="py-3 px-4">Elektronik</td>
                        </tr>
                        <tr class="border-b odd:bg-white even:bg-blue-100 hover:bg-blue-200">
                            <td class="py-3 px-4">1</td>
                            <td class="py-3 px-4">Meja Kantor</td>
                            <td class="py-3 px-4">Meja kerja kayu jati</td>
                            <td class="py-3 px-4">Dipakai</td>
                            <td class="py-3 px-4">Furniture</td>
                        </tr>
                        <tr class="border-b odd:bg-white even:bg-blue-100 hover:bg-blue-200">
                            <td class="py-3 px-4">1</td>
                            <td class="py-3 px-4">Proyektor Epson</td>
                            <td class="py-3 px-4">Proyektor untuk presentasi</td>
                            <td class="py-3 px-4">Aktif</td>
                            <td class="py-3 px-4">Elektronik</td>
                        </tr>
                        <tr class="border-b odd:bg-white even:bg-blue-100 hover:bg-blue-200">
                            <td class="py-3 px-4">1</td>
                            <td class="py-3 px-4">Kursi Ergonomis</td>
                            <td class="py-3 px-4">Kursi dengan penyangga punggung</td>
                            <td class="py-3 px-4">Dipakai</td>
                            <td class="py-3 px-4">Furniture</td>
                        </tr>
                        <tr class="border-b odd:bg-white even:bg-blue-100 hover:bg-blue-200">
                            <td class="py-3 px-4">1</td>
                            <td class="py-3 px-4">Printer HP LaserJet</td>
                            <td class="py-3 px-4">Printer untuk kebutuhan kantor</td>
                            <td class="py-3 px-4">Aktif</td>
                            <td class="py-3 px-4">Elektronik</td>
                        </tr>
                        <tr class="border-b odd:bg-white even:bg-blue-100 hover:bg-blue-200">
                            <td class="py-3 px-4">1</td>
                            <td class="py-3 px-4">Mobil Operasional</td>
                            <td class="py-3 px-4">Mobil untuk perjalanan dinas</td>
                            <td class="py-3 px-4">Aktif</td>
                            <td class="py-3 px-4">Kendaraan</td>
                        </tr>
                        <tr class="border-b odd:bg-white even:bg-blue-100 hover:bg-blue-200">
                            <td class="py-3 px-4">1</td>
                            <td class="py-3 px-4">Laptop Dell XPS</td>
                            <td class="py-3 px-4">Laptop untuk pengembangan software</td>
                            <td class="py-3 px-4">Aktif</td>
                            <td class="py-3 px-4">Elektronik</td>
                        </tr>
                        <tr class="border-b odd:bg-white even:bg-blue-100 hover:bg-blue-200">
                            <td class="py-3 px-4">1</td>
                            <td class="py-3 px-4">Meja Kantor</td>
                            <td class="py-3 px-4">Meja kerja kayu jati</td>
                            <td class="py-3 px-4">Dipakai</td>
                            <td class="py-3 px-4">Furniture</td>
                        </tr>
                        <tr class="border-b odd:bg-white even:bg-blue-100 hover:bg-blue-200">
                            <td class="py-3 px-4">1</td>
                            <td class="py-3 px-4">Proyektor Epson</td>
                            <td class="py-3 px-4">Proyektor untuk presentasi</td>
                            <td class="py-3 px-4">Aktif</td>
                            <td class="py-3 px-4">Elektronik</td>
                        </tr>
                        <tr class="border-b odd:bg-white even:bg-blue-100 hover:bg-blue-200">
                            <td class="py-3 px-4">1</td>
                            <td class="py-3 px-4">Kursi Ergonomis</td>
                            <td class="py-3 px-4">Kursi dengan penyangga punggung</td>
                            <td class="py-3 px-4">Dipakai</td>
                            <td class="py-3 px-4">Furniture</td>
                        </tr>
                        <tr class="border-b odd:bg-white even:bg-blue-100 hover:bg-blue-200">
                            <td class="py-3 px-4">1</td>
                            <td class="py-3 px-4">Printer HP LaserJet</td>
                            <td class="py-3 px-4">Printer untuk kebutuhan kantor</td>
                            <td class="py-3 px-4">Aktif</td>
                            <td class="py-3 px-4">Elektronik</td>
                        </tr>
                        <tr class="border-b odd:bg-white even:bg-blue-100 hover:bg-blue-200">
                            <td class="py-3 px-4">1</td>
                            <td class="py-3 px-4">Mobil Operasional</td>
                            <td class="py-3 px-4">Mobil untuk perjalanan dinas</td>
                            <td class="py-3 px-4">Aktif</td>
                            <td class="py-3 px-4">Kendaraan</td>
                        </tr>
                        <tr class="border-b odd:bg-white even:bg-blue-100 hover:bg-blue-200">
                            <td class="py-3 px-4">1</td>
                            <td class="py-3 px-4">Laptop Dell XPS</td>
                            <td class="py-3 px-4">Laptop untuk pengembangan software</td>
                            <td class="py-3 px-4">Aktif</td>
                            <td class="py-3 px-4">Elektronik</td>
                        </tr>
                        <tr class="border-b odd:bg-white even:bg-blue-100 hover:bg-blue-200">
                            <td class="py-3 px-4">1</td>
                            <td class="py-3 px-4">Meja Kantor</td>
                            <td class="py-3 px-4">Meja kerja kayu jati</td>
                            <td class="py-3 px-4">Dipakai</td>
                            <td class="py-3 px-4">Furniture</td>
                        </tr>
                        <tr class="border-b odd:bg-white even:bg-blue-100 hover:bg-blue-200">
                            <td class="py-3 px-4">1</td>
                            <td class="py-3 px-4">Proyektor Epson</td>
                            <td class="py-3 px-4">Proyektor untuk presentasi</td>
                            <td class="py-3 px-4">Aktif</td>
                            <td class="py-3 px-4">Elektronik</td>
                        </tr>
                        <tr class="border-b odd:bg-white even:bg-blue-100 hover:bg-blue-200">
                            <td class="py-3 px-4">1</td>
                            <td class="py-3 px-4">Kursi Ergonomis</td>
                            <td class="py-3 px-4">Kursi dengan penyangga punggung</td>
                            <td class="py-3 px-4">Dipakai</td>
                            <td class="py-3 px-4">Furniture</td>
                        </tr>
                        <tr class="border-b odd:bg-white even:bg-blue-100 hover:bg-blue-200">
                            <td class="py-3 px-4">1</td>
                            <td class="py-3 px-4">Printer HP LaserJet</td>
                            <td class="py-3 px-4">Printer untuk kebutuhan kantor</td>
                            <td class="py-3 px-4">Aktif</td>
                            <td class="py-3 px-4">Elektronik</td>
                        </tr>
                        <tr class="border-b odd:bg-white even:bg-blue-100 hover:bg-blue-200">
                            <td class="py-3 px-4">1</td>
                            <td class="py-3 px-4">Mobil Operasional</td>
                            <td class="py-3 px-4">Mobil untuk perjalanan dinas</td>
                            <td class="py-3 px-4">Aktif</td>
                            <td class="py-3 px-4">Kendaraan</td>
                        </tr>
                        <tr class="border-b odd:bg-white even:bg-blue-100 hover:bg-blue-200">
                            <td class="py-3 px-4">1</td>
                            <td class="py-3 px-4">Laptop Dell XPS</td>
                            <td class="py-3 px-4">Laptop untuk pengembangan software</td>
                            <td class="py-3 px-4">Aktif</td>
                            <td class="py-3 px-4">Elektronik</td>
                        </tr>
                        <tr class="border-b odd:bg-white even:bg-blue-100 hover:bg-blue-200">
                            <td class="py-3 px-4">1</td>
                            <td class="py-3 px-4">Meja Kantor</td>
                            <td class="py-3 px-4">Meja kerja kayu jati</td>
                            <td class="py-3 px-4">Dipakai</td>
                            <td class="py-3 px-4">Furniture</td>
                        </tr>
                        <tr class="border-b odd:bg-white even:bg-blue-100 hover:bg-blue-200">
                            <td class="py-3 px-4">1</td>
                            <td class="py-3 px-4">Proyektor Epson</td>
                            <td class="py-3 px-4">Proyektor untuk presentasi</td>
                            <td class="py-3 px-4">Aktif</td>
                            <td class="py-3 px-4">Elektronik</td>
                        </tr>
                        <tr class="border-b odd:bg-white even:bg-blue-100 hover:bg-blue-200">
                            <td class="py-3 px-4">1</td>
                            <td class="py-3 px-4">Kursi Ergonomis</td>
                            <td class="py-3 px-4">Kursi dengan penyangga punggung</td>
                            <td class="py-3 px-4">Dipakai</td>
                            <td class="py-3 px-4">Furniture</td>
                        </tr>
                        <tr class="border-b odd:bg-white even:bg-blue-100 hover:bg-blue-200">
                            <td class="py-3 px-4">1</td>
                            <td class="py-3 px-4">Printer HP LaserJet</td>
                            <td class="py-3 px-4">Printer untuk kebutuhan kantor</td>
                            <td class="py-3 px-4">Aktif</td>
                            <td class="py-3 px-4">Elektronik</td>
                        </tr>
                        <tr class="border-b odd:bg-white even:bg-blue-100 hover:bg-blue-200">
                            <td class="py-3 px-4">1</td>
                            <td class="py-3 px-4">Mobil Operasional</td>
                            <td class="py-3 px-4">Mobil untuk perjalanan dinas</td>
                            <td class="py-3 px-4">Aktif</td>
                            <td class="py-3 px-4">Kendaraan</td>
                        </tr>
                        <tr class="border-b odd:bg-white even:bg-blue-100 hover:bg-blue-200">
                            <td class="py-3 px-4">1</td>
                            <td class="py-3 px-4">Laptop Dell XPS</td>
                            <td class="py-3 px-4">Laptop untuk pengembangan software</td>
                            <td class="py-3 px-4">Aktif</td>
                            <td class="py-3 px-4">Elektronik</td>
                        </tr>
                        <tr class="border-b odd:bg-white even:bg-blue-100 hover:bg-blue-200">
                            <td class="py-3 px-4">1</td>
                            <td class="py-3 px-4">Meja Kantor</td>
                            <td class="py-3 px-4">Meja kerja kayu jati</td>
                            <td class="py-3 px-4">Dipakai</td>
                            <td class="py-3 px-4">Furniture</td>
                        </tr>
                        <tr class="border-b odd:bg-white even:bg-blue-100 hover:bg-blue-200">
                            <td class="py-3 px-4">1</td>
                            <td class="py-3 px-4">Proyektor Epson</td>
                            <td class="py-3 px-4">Proyektor untuk presentasi</td>
                            <td class="py-3 px-4">Aktif</td>
                            <td class="py-3 px-4">Elektronik</td>
                        </tr>
                        <tr class="border-b odd:bg-white even:bg-blue-100 hover:bg-blue-200">
                            <td class="py-3 px-4">1</td>
                            <td class="py-3 px-4">Kursi Ergonomis</td>
                            <td class="py-3 px-4">Kursi dengan penyangga punggung</td>
                            <td class="py-3 px-4">Dipakai</td>
                            <td class="py-3 px-4">Furniture</td>
                        </tr>
                        <tr class="border-b odd:bg-white even:bg-blue-100 hover:bg-blue-200">
                            <td class="py-3 px-4">1</td>
                            <td class="py-3 px-4">Printer HP LaserJet</td>
                            <td class="py-3 px-4">Printer untuk kebutuhan kantor</td>
                            <td class="py-3 px-4">Aktif</td>
                            <td class="py-3 px-4">Elektronik</td>
                        </tr>
                        <tr class="border-b odd:bg-white even:bg-blue-100 hover:bg-blue-200">
                            <td class="py-3 px-4">1</td>
                            <td class="py-3 px-4">Mobil Operasional</td>
                            <td class="py-3 px-4">Mobil untuk perjalanan dinas</td>
                            <td class="py-3 px-4">Aktif</td>
                            <td class="py-3 px-4">Kendaraan</td>
                        </tr>
                        <tr class="border-b odd:bg-white even:bg-blue-100 hover:bg-blue-200">
                            <td class="py-3 px-4">1</td>
                            <td class="py-3 px-4">Laptop Dell XPS</td>
                            <td class="py-3 px-4">Laptop untuk pengembangan software</td>
                            <td class="py-3 px-4">Aktif</td>
                            <td class="py-3 px-4">Elektronik</td>
                        </tr>
                        <tr class="border-b odd:bg-white even:bg-blue-100 hover:bg-blue-200">
                            <td class="py-3 px-4">1</td>
                            <td class="py-3 px-4">Meja Kantor</td>
                            <td class="py-3 px-4">Meja kerja kayu jati</td>
                            <td class="py-3 px-4">Dipakai</td>
                            <td class="py-3 px-4">Furniture</td>
                        </tr>
                        <tr class="border-b odd:bg-white even:bg-blue-100 hover:bg-blue-200">
                            <td class="py-3 px-4">1</td>
                            <td class="py-3 px-4">Proyektor Epson</td>
                            <td class="py-3 px-4">Proyektor untuk presentasi</td>
                            <td class="py-3 px-4">Aktif</td>
                            <td class="py-3 px-4">Elektronik</td>
                        </tr>
                        <tr class="border-b odd:bg-white even:bg-blue-100 hover:bg-blue-200">
                            <td class="py-3 px-4">1</td>
                            <td class="py-3 px-4">Kursi Ergonomis</td>
                            <td class="py-3 px-4">Kursi dengan penyangga punggung</td>
                            <td class="py-3 px-4">Dipakai</td>
                            <td class="py-3 px-4">Furniture</td>
                        </tr>
                        <tr class="border-b odd:bg-white even:bg-blue-100 hover:bg-blue-200">
                            <td class="py-3 px-4">1</td>
                            <td class="py-3 px-4">Printer HP LaserJet</td>
                            <td class="py-3 px-4">Printer untuk kebutuhan kantor</td>
                            <td class="py-3 px-4">Aktif</td>
                            <td class="py-3 px-4">Elektronik</td>
                        </tr>
                        <tr class="border-b odd:bg-white even:bg-blue-100 hover:bg-blue-200">
                            <td class="py-3 px-4">1</td>
                            <td class="py-3 px-4">Mobil Operasional</td>
                            <td class="py-3 px-4">Mobil untuk perjalanan dinas</td>
                            <td class="py-3 px-4">Aktif</td>
                            <td class="py-3 px-4">Kendaraan</td>
                        </tr>
                        <tr class="border-b odd:bg-white even:bg-blue-100 hover:bg-blue-200">
                            <td class="py-3 px-4">1</td>
                            <td class="py-3 px-4">Laptop Dell XPS</td>
                            <td class="py-3 px-4">Laptop untuk pengembangan software</td>
                            <td class="py-3 px-4">Aktif</td>
                            <td class="py-3 px-4">Elektronik</td>
                        </tr>
                        <tr class="border-b odd:bg-white even:bg-blue-100 hover:bg-blue-200">
                            <td class="py-3 px-4">1</td>
                            <td class="py-3 px-4">Meja Kantor</td>
                            <td class="py-3 px-4">Meja kerja kayu jati</td>
                            <td class="py-3 px-4">Dipakai</td>
                            <td class="py-3 px-4">Furniture</td>
                        </tr>
                        <tr class="border-b odd:bg-white even:bg-blue-100 hover:bg-blue-200">
                            <td class="py-3 px-4">1</td>
                            <td class="py-3 px-4">Proyektor Epson</td>
                            <td class="py-3 px-4">Proyektor untuk presentasi</td>
                            <td class="py-3 px-4">Aktif</td>
                            <td class="py-3 px-4">Elektronik</td>
                        </tr>
                        <tr class="border-b odd:bg-white even:bg-blue-100 hover:bg-blue-200">
                            <td class="py-3 px-4">1</td>
                            <td class="py-3 px-4">Kursi Ergonomis</td>
                            <td class="py-3 px-4">Kursi dengan penyangga punggung</td>
                            <td class="py-3 px-4">Dipakai</td>
                            <td class="py-3 px-4">Furniture</td>
                        </tr>
                        <tr class="border-b odd:bg-white even:bg-blue-100 hover:bg-blue-200">
                            <td class="py-3 px-4">1</td>
                            <td class="py-3 px-4">Printer HP LaserJet</td>
                            <td class="py-3 px-4">Printer untuk kebutuhan kantor</td>
                            <td class="py-3 px-4">Aktif</td>
                            <td class="py-3 px-4">Elektronik</td>
                        </tr>
                        <tr class="border-b odd:bg-white even:bg-blue-100 hover:bg-blue-200">
                            <td class="py-3 px-4">1</td>
                            <td class="py-3 px-4">Mobil Operasional</td>
                            <td class="py-3 px-4">Mobil untuk perjalanan dinas</td>
                            <td class="py-3 px-4">Aktif</td>
                            <td class="py-3 px-4">Kendaraan</td>
                        </tr>
                        <tr class="border-b odd:bg-white even:bg-blue-100 hover:bg-blue-200">
                            <td class="py-3 px-4">1</td>
                            <td class="py-3 px-4">Laptop Dell XPS</td>
                            <td class="py-3 px-4">Laptop untuk pengembangan software</td>
                            <td class="py-3 px-4">Aktif</td>
                            <td class="py-3 px-4">Elektronik</td>
                        </tr>
                        <tr class="border-b odd:bg-white even:bg-blue-100 hover:bg-blue-200">
                            <td class="py-3 px-4">1</td>
                            <td class="py-3 px-4">Meja Kantor</td>
                            <td class="py-3 px-4">Meja kerja kayu jati</td>
                            <td class="py-3 px-4">Dipakai</td>
                            <td class="py-3 px-4">Furniture</td>
                        </tr>
                        <tr class="border-b odd:bg-white even:bg-blue-100 hover:bg-blue-200">
                            <td class="py-3 px-4">1</td>
                            <td class="py-3 px-4">Proyektor Epson</td>
                            <td class="py-3 px-4">Proyektor untuk presentasi</td>
                            <td class="py-3 px-4">Aktif</td>
                            <td class="py-3 px-4">Elektronik</td>
                        </tr>
                        <tr class="border-b odd:bg-white even:bg-blue-100 hover:bg-blue-200">
                            <td class="py-3 px-4">1</td>
                            <td class="py-3 px-4">Kursi Ergonomis</td>
                            <td class="py-3 px-4">Kursi dengan penyangga punggung</td>
                            <td class="py-3 px-4">Dipakai</td>
                            <td class="py-3 px-4">Furniture</td>
                        </tr>
                        <tr class="border-b odd:bg-white even:bg-blue-100 hover:bg-blue-200">
                            <td class="py-3 px-4">1</td>
                            <td class="py-3 px-4">Printer HP LaserJet</td>
                            <td class="py-3 px-4">Printer untuk kebutuhan kantor</td>
                            <td class="py-3 px-4">Aktif</td>
                            <td class="py-3 px-4">Elektronik</td>
                        </tr>
                        <tr class="border-b odd:bg-white even:bg-blue-100 hover:bg-blue-200">
                            <td class="py-3 px-4">1</td>
                            <td class="py-3 px-4">Mobil Operasional</td>
                            <td class="py-3 px-4">Mobil untuk perjalanan dinas</td>
                            <td class="py-3 px-4">Aktif</td>
                            <td class="py-3 px-4">Kendaraan</td>
                        </tr>
                        <tr class="border-b odd:bg-white even:bg-blue-100 hover:bg-blue-200">
                            <td class="py-3 px-4">1</td>
                            <td class="py-3 px-4">Laptop Dell XPS</td>
                            <td class="py-3 px-4">Laptop untuk pengembangan software</td>
                            <td class="py-3 px-4">Aktif</td>
                            <td class="py-3 px-4">Elektronik</td>
                        </tr>
                        <tr class="border-b odd:bg-white even:bg-blue-100 hover:bg-blue-200">
                            <td class="py-3 px-4">1</td>
                            <td class="py-3 px-4">Meja Kantor</td>
                            <td class="py-3 px-4">Meja kerja kayu jati</td>
                            <td class="py-3 px-4">Dipakai</td>
                            <td class="py-3 px-4">Furniture</td>
                        </tr>
                        <tr class="border-b odd:bg-white even:bg-blue-100 hover:bg-blue-200">
                            <td class="py-3 px-4">1</td>
                            <td class="py-3 px-4">Proyektor Epson</td>
                            <td class="py-3 px-4">Proyektor untuk presentasi</td>
                            <td class="py-3 px-4">Aktif</td>
                            <td class="py-3 px-4">Elektronik</td>
                        </tr>
                        <tr class="border-b odd:bg-white even:bg-blue-100 hover:bg-blue-200">
                            <td class="py-3 px-4">1</td>
                            <td class="py-3 px-4">Kursi Ergonomis</td>
                            <td class="py-3 px-4">Kursi dengan penyangga punggung</td>
                            <td class="py-3 px-4">Dipakai</td>
                            <td class="py-3 px-4">Furniture</td>
                        </tr>
                        <tr class="border-b odd:bg-white even:bg-blue-100 hover:bg-blue-200">
                            <td class="py-3 px-4">1</td>
                            <td class="py-3 px-4">Printer HP LaserJet</td>
                            <td class="py-3 px-4">Printer untuk kebutuhan kantor</td>
                            <td class="py-3 px-4">Aktif</td>
                            <td class="py-3 px-4">Elektronik</td>
                        </tr>
                        <tr class="border-b odd:bg-white even:bg-blue-100 hover:bg-blue-200">
                            <td class="py-3 px-4">1</td>
                            <td class="py-3 px-4">Mobil Operasional</td>
                            <td class="py-3 px-4">Mobil untuk perjalanan dinas</td>
                            <td class="py-3 px-4">Aktif</td>
                            <td class="py-3 px-4">Kendaraan</td>
                        </tr>
                        <tr class="border-b odd:bg-white even:bg-blue-100 hover:bg-blue-200">
                            <td class="py-3 px-4">1</td>
                            <td class="py-3 px-4">Laptop Dell XPS</td>
                            <td class="py-3 px-4">Laptop untuk pengembangan software</td>
                            <td class="py-3 px-4">Aktif</td>
                            <td class="py-3 px-4">Elektronik</td>
                        </tr>
                        <tr class="border-b odd:bg-white even:bg-blue-100 hover:bg-blue-200">
                            <td class="py-3 px-4">1</td>
                            <td class="py-3 px-4">Meja Kantor</td>
                            <td class="py-3 px-4">Meja kerja kayu jati</td>
                            <td class="py-3 px-4">Dipakai</td>
                            <td class="py-3 px-4">Furniture</td>
                        </tr>
                        <tr class="border-b odd:bg-white even:bg-blue-100 hover:bg-blue-200">
                            <td class="py-3 px-4">1</td>
                            <td class="py-3 px-4">Proyektor Epson</td>
                            <td class="py-3 px-4">Proyektor untuk presentasi</td>
                            <td class="py-3 px-4">Aktif</td>
                            <td class="py-3 px-4">Elektronik</td>
                        </tr>
                        <tr class="border-b odd:bg-white even:bg-blue-100 hover:bg-blue-200">
                            <td class="py-3 px-4">1</td>
                            <td class="py-3 px-4">Kursi Ergonomis</td>
                            <td class="py-3 px-4">Kursi dengan penyangga punggung</td>
                            <td class="py-3 px-4">Dipakai</td>
                            <td class="py-3 px-4">Furniture</td>
                        </tr>
                        <tr class="border-b odd:bg-white even:bg-blue-100 hover:bg-blue-200">
                            <td class="py-3 px-4">1</td>
                            <td class="py-3 px-4">Printer HP LaserJet</td>
                            <td class="py-3 px-4">Printer untuk kebutuhan kantor</td>
                            <td class="py-3 px-4">Aktif</td>
                            <td class="py-3 px-4">Elektronik</td>
                        </tr>
                        <tr class="border-b odd:bg-white even:bg-blue-100 hover:bg-blue-200">
                            <td class="py-3 px-4">1</td>
                            <td class="py-3 px-4">Mobil Operasional</td>
                            <td class="py-3 px-4">Mobil untuk perjalanan dinas</td>
                            <td class="py-3 px-4">Aktif</td>
                            <td class="py-3 px-4">Kendaraan</td>
                        </tr>
                    </tbody>

                </table>
            </div>
        </div>
    </div>


</section>
@endsection

@section('scripts')
<script>
    // Additional JavaScript specific to this page
    console.log('Home page script loaded.');
</script>
@endsection