<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pendaftaran Akun Disetujui</title>
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
            background-color: #4CAF50;
            color: #ffffff;
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
            background-color: #4CAF50;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            margin-top: 20px;
            transition: background-color 0.3s;
        }

        .btn:hover {
            background-color: #388E3C;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="header">
            <h1>Pendaftaran Akun Disetujui</h1>
        </div>
        <div class="content">
            <p>Selamat! Pendaftaran akun Anda telah disetujui. Anda sekarang memiliki akses untuk menggunakan layanan
                kami.</p>
            <p><strong>Detail Akun:</strong></p>
            <ul>
                <li><strong>Nama:</strong> {{ $name }}</li>
                <li><strong>Email:</strong> {{ $email }}</li>
            </ul>
            <p>Silakan klik tombol di bawah ini untuk login ke akun Anda:</p>
            <a href="{{ url('/login') }}" class="btn">Login Sekarang</a>
        </div>
        <div class="footer">
            <p>&copy; {{ date('Y') }} Paroki Babadan. Semua Hak Dilindungi.</p>
        </div>
    </div>
</body>

</html>
