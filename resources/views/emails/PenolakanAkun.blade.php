<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pendaftaran Akun Ditolak</title>
    <style>
        /* Basic reset */
        body {
            margin: 0;
            padding: 0;
            font-family: Arial, sans-serif;
            background-color: #f7f7f7;
            color: #333;
        }

        /* Container styling */
        .container {
            max-width: 600px;
            margin: 50px auto;
            background-color: #ffffff;
            border-radius: 8px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            overflow: hidden;
        }

        /* Header styling */
        .header {
            background-color: #e53935;
            /* Warna merah terang */
            color: #ffffff;
            text-align: center;
            padding: 20px;
        }

        .header h1 {
            margin: 0;
            font-size: 24px;
        }

        /* Content styling */
        .content {
            padding: 20px;
            line-height: 1.6;
        }

        .content p {
            margin: 10px 0;
        }

        .reason-box {
            background-color: #ffebee;
            border-left: 5px solid #f44336;
            padding: 15px;
            margin: 15px 0;
            border-radius: 5px;
            color: #c62828;
        }

        /* Footer styling */
        .footer {
            text-align: center;
            padding: 15px;
            background-color: #f1f1f1;
            color: #555;
            font-size: 14px;
            border-top: 1px solid #ddd;
        }

        /* Button styling */
        .btn {
            display: inline-block;
            margin-top: 20px;
            padding: 10px 15px;
            background-color: #d32f2f;
            color: #fff;
            text-decoration: none;
            border-radius: 5px;
            font-weight: bold;
            transition: background-color 0.3s ease;
        }

        .btn:hover {
            background-color: #b71c1c;
        }
    </style>
</head>

<body>
    <div class="container">
        <!-- Header -->
        <div class="header">
            <h1>Pendaftaran Akun Ditolak</h1>
        </div>

        <div class="content">
            <p>Maaf, pendaftaran akun Anda tidak dapat disetujui. Berikut adalah alasan penolakan:</p>
            <p><strong>Alasan:</strong> {{ $reason }}</p>
            <p>Jika Anda memiliki pertanyaan lebih lanjut, silakan hubungi kami.</p>
        </div>
        <div class="footer">
            <p>&copy; {{ date('Y') }} Paroki Babadan. Semua Hak Dilindungi.</p>
        </div>
    </div>
    <!-- Footer -->
    <div class="footer">
        <p>&copy; {{ date('Y') }} Paroki Babadan. Semua Hak Dilindungi.</p>
    </div>
    </div>
</body>

</html>
