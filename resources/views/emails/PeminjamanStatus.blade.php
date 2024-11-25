<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Status Peminjaman</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f7f7f7;
            color: #333;
        }

        .container {
            width: 100%;
            max-width: 600px;
            margin: 0 auto;
            background-color: #ffffff;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .header {
            background-color: #4CAF50;
            color: #fff;
            padding: 20px;
            text-align: center;
        }

        .content {
            padding: 20px;
            text-align: left;
        }

        .status-approved {
            color: #4CAF50;
            font-weight: bold;
        }

        .status-rejected {
            color: #f44336;
            font-weight: bold;
        }

        .reason {
            background-color: #ffebee;
            color: #f44336;
            padding: 10px;
            border-radius: 5px;
        }

        .item-list {
            list-style-type: none;
            padding-left: 0;
        }

        .item-list li {
            margin-bottom: 10px;
        }

        .footer {
            background-color: #f1f1f1;
            text-align: center;
            padding: 10px;
            font-size: 14px;
        }

        .footer a {
            color: #4CAF50;
            text-decoration: none;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="header">
            <h1>Status Peminjaman</h1>
        </div>

        <div class="content">
            <p>Halo, {{ $peminjamName }}.</p>

            @if ($status == 'disetujui')
                <p class="status-approved">Selamat! Peminjaman Anda telah disetujui untuk item berikut:</p>
            @else
                <p class="status-rejected">Maaf, peminjaman Anda untuk item berikut tidak disetujui:</p>
                @if ($alasan)
                    <p class="reason">Alasan Penolakan: {{ $alasan }}</p>
                @endif
            @endif
            <ul class="item-list">
                @foreach ($assetDetails as $item)
                    <li>{{ $item['nama_barang'] }} (Jumlah: {{ $item['jumlah'] }})</li>
                @endforeach
            </ul>

            <p>Jika Anda memiliki pertanyaan lebih lanjut, silakan hubungi kami.</p>
        </div>

        <div class="footer">
            &copy; {{ date('Y') }} Paroki Babadan. Semua Hak Dilindungi.
        </div>
    </div>
</body>

</html>
