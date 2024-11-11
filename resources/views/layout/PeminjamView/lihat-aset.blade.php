@extends('layout.TemplateAdmin')

@section('title', 'Lihat Aset')

@section('content')

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User List UI</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>

<section class="p-6 bg-gray-100 min-h-screen rounded-md">

    <body class="bg-gray-100 p-8">

        <div class="max-w-7xl mx-auto bg-white shadow-md rounded-lg">
            <div class="px-6 py-4 border-b">
                <h2 class="text-xl font-semibold">Aset</h2>
                <p class="text-gray-500">List Atribut Aset</p>
            </div>

            <div class="px-6 py-4">
                <div class="overflow-y-scroll max-h-80 border rounded-lg"> <!-- ubah ketinggian jika memakai max-h-96 pakai overflow-y-scroll -->
                    <table class="w-full text-left">
                        <thead>
                            <tr>
                                <th class="py-2 px-4 border-b-2 font-semibold text-gray-700">Nama Aset</th>
                                <th class="py-2 px-4 border-b-2 font-semibold text-gray-700">Deskripsi</th>
                                <th class="py-2 px-4 border-b-2 font-semibold text-gray-700">Status</th>
                                <th class="py-2 px-4 border-b-2 font-semibold text-gray-700">Jenis Aset</th>
                            </tr>
                        </thead>
                        <tbody class="text-gray-600">
                            <?php if (!empty($asetModel) && is_array($asetModel)) : ?>
                                <?php foreach ($asetModel as $aset) : ?>
                                    <tr class="border-b">
                                        <td class="py-3 px-4"><?= $aset['Nama'] ?></td>
                                        <td class="py-3 px-4"><?= $aset['Deskripsi'] ?></td>
                                        <td class="py-3 px-4"><?= $aset['Status'] ?></td>
                                        <td class="py-3 px-4"><?= $aset['Jenis'] ?></td>
                                    </tr>
                                <?php endforeach ?>
                            <?php else : ?>
                                <tr class="border-b">
                                    <td class="py-3 px-4">Tidak ada data aset.</td>
                                </tr>
                            <?php endif ?>
                            <tr class="border-b">
                                <td class="py-3 px-4">Laptop Dell XPS</td>
                                <td class="py-3 px-4">Laptop untuk pengembangan software</td>
                                <td class="py-3 px-4">Aktif</td>
                                <td class="py-3 px-4">Elektronik</td>
                            </tr>
                            <tr class="border-b">
                                <td class="py-3 px-4">Meja Kantor</td>
                                <td class="py-3 px-4">Meja kerja kayu jati</td>
                                <td class="py-3 px-4">Dipakai</td>
                                <td class="py-3 px-4">Furniture</td>
                            </tr>
                            <tr class="border-b">
                                <td class="py-3 px-4">Proyektor Epson</td>
                                <td class="py-3 px-4">Proyektor untuk presentasi</td>
                                <td class="py-3 px-4">Aktif</td>
                                <td class="py-3 px-4">Elektronik</td>
                            </tr>
                            <tr class="border-b">
                                <td class="py-3 px-4">Kursi Ergonomis</td>
                                <td class="py-3 px-4">Kursi dengan penyangga punggung</td>
                                <td class="py-3 px-4">Dipakai</td>
                                <td class="py-3 px-4">Furniture</td>
                            </tr>
                            <tr class="border-b">
                                <td class="py-3 px-4">Printer HP LaserJet</td>
                                <td class="py-3 px-4">Printer untuk kebutuhan kantor</td>
                                <td class="py-3 px-4">Aktif</td>
                                <td class="py-3 px-4">Elektronik</td>
                            </tr>
                            <tr class="border-b">
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

        <div class="max-w-7xl mx-auto bg-white shadow-md rounded-lg mt-8">
            <div class="px-6 py-4 border-b">
                <h2 class="text-xl font-semibold">Ruangan</h2>
                <p class="text-gray-500">List Atribut Ruangan</p>
            </div>

            <div class="px-6 py-4">
                <div class="overflow-y-scroll max-h-64 border rounded-lg"> <!-- ubah ketinggian jika memakai max-h-96 pakai overflow-y-scroll -->
                    <table class="w-full text-left"> <!-- <div class="overflow-y-scroll max-h-120 border rounded-lg"> ubah ketinggia di Max-h nya -->
                        <thead>
                            <tr>
                                <th class="py-2 px-4 border-b-2 font-semibold text-gray-700">Nama ruangan</th>
                                <th class="py-2 px-4 border-b-2 font-semibold text-gray-700">Deskripsi</th>
                                <th class="py-2 px-4 border-b-2 font-semibold text-gray-700">Status</th>
                            </tr>
                        </thead>
                        <tbody class="text-gray-600">
                            <?php if (!empty($ruanganModel) && is_array($ruangantModel)) : ?>
                                <?php foreach ($ruanganModel as $ruangan) : ?>
                                    <tr class="border-b">
                                        <td class="py-3 px-4"><?= $ruangan['Nama'] ?></td>
                                        <td class="py-3 px-4"><?= $ruangan['Deskripsi'] ?></td>
                                        <td class="py-3 px-4"><?= $ruangan['Status'] ?></td>
                                    </tr>
                                <?php endforeach ?>
                            <?php else : ?>
                                <tr class="border-b">
                                    <td class="py-3 px-4">Tidak ada data ruangan.</td>
                                </tr>
                            <?php endif ?>
                            <!-- <tr class="border-b">
                                <td class="py-3 px-4">Mobil Operasional</td>
                                <td class="py-3 px-4">Mobil untuk perjalanan dinas</td>
                                <td class="py-3 px-4">Aktif</td>
                            </tr><tr class="border-b">
                                <td class="py-3 px-4">Mobil Operasional</td>
                                <td class="py-3 px-4">Mobil untuk perjalanan dinas</td>
                                <td class="py-3 px-4">Aktif</td>
                            </tr><tr class="border-b">
                                <td class="py-3 px-4">Mobil Operasional</td>
                                <td class="py-3 px-4">Mobil untuk perjalanan dinas</td>
                                <td class="py-3 px-4">Aktif</td>
                            </tr><tr class="border-b">
                                <td class="py-3 px-4">Mobil Operasional</td>
                                <td class="py-3 px-4">Mobil untuk perjalanan dinas</td>
                                <td class="py-3 px-4">Aktif</td>
                            </tr><tr class="border-b">
                                <td class="py-3 px-4">Mobil Operasional</td>
                                <td class="py-3 px-4">Mobil untuk perjalanan dinas</td>
                                <td class="py-3 px-4">Aktif</td>
                            </tr><tr class="border-b">
                                <td class="py-3 px-4">Mobil Operasional</td>
                                <td class="py-3 px-4">Mobil untuk perjalanan dinas</td>
                                <td class="py-3 px-4">Aktif</td>
                            </tr><tr class="border-b">
                                <td class="py-3 px-4">Mobil Operasional</td>
                                <td class="py-3 px-4">Mobil untuk perjalanan dinas</td>
                                <td class="py-3 px-4">Aktif</td>
                            </tr><tr class="border-b">
                                <td class="py-3 px-4">Mobil Operasional</td>
                                <td class="py-3 px-4">Mobil untuk perjalanan dinas</td>
                                <td class="py-3 px-4">Aktif</td>
                            </tr><tr class="border-b">
                                <td class="py-3 px-4">Mobil Operasional</td>
                                <td class="py-3 px-4">Mobil untuk perjalanan dinas</td>
                                <td class="py-3 px-4">Aktif</td>
                            </tr> -->

                        </tbody>


                    </table>
                </div>
            </div>
        </div>
    </body>

</html>
</section>
@endsection

@section('scripts')
<script>
    // Additional JavaScript specific to this page
    console.log('Home page script loaded.');
</script>
@endsection