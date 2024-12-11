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
            color: #fff;
            padding: 20px;
            text-align: center;
        }

        .header.approved {
            background-color: #4CAF50;
            /* Hijau untuk disetujui */
        }

        .header.rejected {
            background-color: #f44336;
            /* Merah untuk ditolak */
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
        <div class="header {{ $status == 'disetujui' ? 'approved' : 'rejected' }}">
            <h1>Status Peminjaman</h1>
        </div>

        <div class="content">
            <p>Halo, {{ $peminjamName }}.</p>

            @if ($status == 'disetujui')
                <p class="status-approved">Selamat! Peminjaman Anda untuk ruangan berikut telah disetujui:</p>
            @else
                <p class="status-rejected">Maaf, peminjaman Anda untuk ruangan berikut tidak disetujui:</p>
                @if ($alasan)
                    <p class="reason">Alasan Penolakan: {{ $alasan }}</p>
                @endif
            @endif

            <p><strong>Nama Ruangan:</strong> {{ $ruanganDetails['nama'] }}</p>
            <p><strong>Tanggal Mulai:</strong> {{ $ruanganDetails['tanggal_mulai'] }}</p>
            <p><strong>Tanggal Selesai:</strong> {{ $ruanganDetails['tanggal_selesai'] }}</p>

            <p>Jika Anda memiliki pertanyaan lebih lanjut, silakan hubungi kami.</p>
        </div>

        <div class="footer">
            &copy; {{ date('Y') }} Paroki Babadan. Semua Hak Dilindungi.
        </div>
    </div>
</body>

</html>
