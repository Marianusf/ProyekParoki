<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Kata Sandi</title>
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
            height: 100px;
            /* Pastikan tinggi header */
            display: flex;
            align-items: center;
            justify-content: center;
            /* Pastikan teks di tengah horizontal */
            text-align: center;
            /* Pastikan teks di tengah */
            margin: 0;
        }

        .header h1 {
            margin: 0;
            /* Hapus margin default */
            font-size: 24px;
            /* Sesuaikan ukuran teks */
        }

        .content {
            padding: 20px;
            text-align: left;
        }

        .button {
            display: inline-block;
            background-color: #4CAF50;
            color: #fff;
            text-decoration: none;
            padding: 10px 20px;
            border-radius: 5px;
            font-weight: bold;
            margin: 20px 0;
            text-align: center;
        }

        .button:hover {
            background-color: #45a049;
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

        .subcopy {
            background-color: #f9f9f9;
            color: #666;
            padding: 10px;
            border-radius: 5px;
            font-size: 14px;
            margin-top: 20px;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="header">
            <h1>Reset Kata Sandi</h1>
        </div>

        <div class="content">
            <p>Halo User!</p>
            <p>Kami menerima permintaan untuk mereset kata sandi akun Anda. Jika ini adalah permintaan Anda, silakan
                klik tombol di bawah ini untuk melanjutkan proses reset kata sandi:</p>

            <a href="{{ $actionUrl }}" class="button">Reset Kata Sandi</a>

            <p>Jika Anda tidak merasa melakukan permintaan ini, abaikan email ini. Link ini hanya berlaku selama 60
                menit.</p>

            <div class="subcopy">
                <p>Jika tombol "Reset Kata Sandi" tidak berfungsi, salin dan tempel URL berikut ke browser Anda:</p>
                <p><a href="{{ $actionUrl }}">{{ $actionUrl }}</a></p>
            </div>
        </div>

        <div class="footer">
            &copy; {{ date('Y') }} Paroki Babadan. Semua Hak Dilindungi.
        </div>
    </div>
</body>

</html>
