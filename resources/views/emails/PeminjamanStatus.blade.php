<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $status == 'disetujui' ? 'Peminjaman Disetujui' : 'Peminjaman Ditolak' }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            padding: 20px;
            color: #333;
        }

        h2 {
            color: #4CAF50;
            /* Warna hijau untuk disetujui */
        }

        h2.ditolak {
            color: #F44336;
            /* Warna merah untuk ditolak */
        }

        p {
            font-size: 16px;
            margin-bottom: 10px;
        }

        strong {
            font-weight: bold;
        }

        .footer {
            font-size: 14px;
            color: #777;
            margin-top: 20px;
        }
    </style>
</head>

<body>
    <h2 class="{{ $status == 'disetujui' ? '' : 'ditolak' }}">
        {{ $status == 'disetujui' ? 'Permintaan Peminjaman Anda Disetujui' : 'Permintaan Peminjaman Anda Ditolak' }}
    </h2>

    <p>Yth. {{ $peminjamName }}</p>
    <p>Permintaan peminjaman Anda untuk asset <strong>{{ $assetName }}</strong> telah {{ $status }}.</p>

    @if ($status == 'ditolak')
        <p><strong>Alasan Penolakan:</strong> {{ $alasanPenolakan }}</p>
    @endif

    <p>Terima kasih atas perhatian Anda.</p>

    <p class="footer">Jika Anda memiliki pertanyaan, silakan hubungi kami.</p>
</body>

</html>
