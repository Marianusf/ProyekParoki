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
        }

        /* Container styling */
        .container {
            max-width: 600px;
            margin: 0 auto;
            background-color: #ffffff;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            padding: 20px;
        }

        /* Header styling */
        .header {
            background-color: #7cb1ff;
            color: #002D74;
            text-align: center;
            padding: 20px;
        }

        /* Content styling */
        .content {
            padding: 20px;
            color: #4A5568;
        }

        /* Footer styling */
        .footer {
            text-align: center;
            padding: 10px;
            font-size: 14px;
            color: #4A5568;
            border-top: 1px solid #e2e8f0;
        }

        /* Button styling */
        .btn {
            display: inline-block;
            padding: 10px 15px;
            background-color: #002D74;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            margin-top: 20px;
            transition: background-color 0.3s;
        }

        .btn:hover {
            background-color: #206ab1;
        }
    </style>
</head>

<body>
    <div class="container">
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
</body>

</html>
