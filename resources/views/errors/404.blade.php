<!DOCTYPE html>
<html lang="id">
<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>Halaman Tidak Ditemukan - SITIKA</title>

    <style>

        * {
            box-sizing: border-box;
            font-family: Arial, Helvetica, sans-serif;
        }

        body {
            margin: 0;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            background: #f3f4f6;
            padding: 20px;
        }

        .error-card {
            width: 100%;
            max-width: 500px;
            background: white;
            padding: 40px;
            border-radius: 12px;
            text-align: center;
            border: 1px solid #e5e7eb;
        }

        .code {
            font-size: 60px;
            font-weight: bold;
            color: #2563eb;
        }

        h1 {
            margin: 10px 0;
        }

        p {
            color: #6b7280;
            line-height: 1.6;
            margin-bottom: 25px;
        }

        a {
            display: inline-block;
            text-decoration: none;
            background: #2563eb;
            color: white;
            padding: 11px 18px;
            border-radius: 7px;
        }

    </style>

</head>

<body>

<div class="error-card">

    <div class="code">
        404
    </div>

    <h1>Halaman Tidak Ditemukan</h1>

    <p>
        Halaman atau tiket yang Anda cari tidak tersedia.
    </p>

    @auth

        <a href="{{ route('dashboard') }}">
            Kembali ke Dashboard
        </a>

    @else

        <a href="{{ route('login') }}">
            Kembali ke Login
        </a>

    @endauth

</div>

</body>
</html>