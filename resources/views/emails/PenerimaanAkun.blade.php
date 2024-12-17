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
            text-align: center;
        }

        /* Header styling */
        .header {
            background-color: #4CAF50;
            color: #ffffff;
            padding: 20px;
            text-align: center;
        }

        .header h1 {
            margin: 0;
            font-size: 26px;
        }

        /* Content styling */
        .content {
            padding: 25px 20px;
            text-align: left;
            color: #4A5568;
        }

        .content p {
            margin: 10px 0;
            line-height: 1.6;
        }

        .content ul {
            list-style: none;
            padding: 0;
        }

        .content ul li {
            margin: 10px 0;
        }

        .content ul li strong {
            color: #333;
        }

        /* Button styling */
        .btn {
            display: inline-block;
            margin-top: 20px;
            padding: 10px 20px;
            background-color: #4CAF50;
            color: #ffffff;
            text-decoration: none;
            border-radius: 5px;
            font-weight: bold;
            transition: background-color 0.3s ease;
        }

        .btn:hover {
            background-color: #388E3C;
        }

        /* Footer styling */
        .footer {
            background-color: #f1f1f1;
            padding: 15px;
            text-align: center;
            color: #666;
            font-size: 14px;
            border-top: 1px solid #ddd;
        }

        .footer a {
            color: #4CAF50;
            text-decoration: none;
            font-weight: bold;
        }

        .footer a:hover {
            text-decoration: underline;
        }
    </style>
</head>

<body>
    <div class="container">
        <!-- Header -->
        <div class="header">
            <h1>Pendaftaran Akun Disetujui</h1>
        </div>

        <!-- Content -->
        <div class="content">
            <p>Selamat, <strong>{{ $name }}</strong>!</p>
            <p>Pendaftaran akun Anda telah <strong>disetujui</strong>. Anda sekarang memiliki akses penuh untuk
                menggunakan layanan kami.</p>

            <p><strong>Detail Akun Anda:</strong></p>
            <ul>
                <li><strong>Nama:</strong> {{ $name }}</li>
                <li><strong>Email:</strong> {{ $email }}</li>
            </ul>

            <p>Silakan klik tombol di bawah ini untuk login ke akun Anda dan mulai menggunakan layanan kami:</p>
            <a href="{{ url('/login') }}" class="btn">Login Sekarang</a>
        </div>

        <!-- Footer -->
        <div class="footer">
            <p>&copy; {{ date('Y') }} Paroki Babadan. Semua Hak Dilindungi.</p>
            <p>Jika Anda mengalami kendala, silakan hubungi Jika ada pertanyaan</p>
        </div>
    </div>
</body>

</html>
