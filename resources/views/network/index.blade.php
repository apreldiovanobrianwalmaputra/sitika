<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>Informasi Jaringan - SITIKA</title>

    <style>
        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background: #f3f4f6;
            color: #111827;
        }

        .navbar {
            background: white;
            padding: 16px 30px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-bottom: 1px solid #e5e7eb;
        }

        .brand {
            font-size: 20px;
            font-weight: bold;
        }

        .nav-right {
            display: flex;
            gap: 12px;
            align-items: center;
        }

        .nav-link {
            text-decoration: none;
            color: #374151;
            font-size: 14px;
        }

        .container {
            max-width: 1100px;
            margin: 30px auto;
            padding: 0 20px;
        }

        .page-header {
            margin-bottom: 22px;
        }

        .page-header h1 {
            margin: 0 0 6px;
            font-size: 25px;
        }

        .page-header p {
            color: #6b7280;
            margin: 0;
        }

        .network-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 16px;
        }

        .network-card {
            background: white;
            border: 1px solid #e5e7eb;
            border-radius: 10px;
            padding: 20px;
        }

        .network-card span {
            display: block;
            color: #6b7280;
            font-size: 13px;
            margin-bottom: 8px;
        }

        .network-card strong {
            display: block;
            font-size: 17px;
            word-break: break-word;
        }

        .full {
            grid-column: 1 / -1;
        }

        .info-box {
            margin-top: 22px;
            background: white;
            border: 1px solid #e5e7eb;
            border-radius: 10px;
            padding: 20px;
        }

        .info-box h2 {
            margin-top: 0;
            font-size: 18px;
        }

        .info-box p {
            color: #4b5563;
            line-height: 1.7;
            margin-bottom: 0;
        }

        @media (max-width: 650px) {
            .navbar {
                padding: 15px 20px;
                flex-direction: column;
                align-items: flex-start;
                gap: 14px;
            }

            .nav-right {
                width: 100%;
                flex-wrap: wrap;
            }

            .container {
                margin-top: 20px;
                padding: 0 15px;
            }

            .network-grid {
                grid-template-columns: 1fr;
            }

            .full {
                grid-column: auto;
            }
        }
    </style>
</head>

<body>

    <nav class="navbar">

        <div class="brand">
            SITIKA
        </div>

        <div class="nav-right">

            <a
                href="{{ route('dashboard') }}"
                class="nav-link"
            >
                Dashboard
            </a>

            <a
                href="{{ route('tickets.index') }}"
                class="nav-link"
            >
                Tiket
            </a>

        </div>

    </nav>

    <main class="container">

        <div class="page-header">
            <h1>Informasi Jaringan</h1>

            <p>
                Informasi koneksi antara client dan
                server aplikasi SITIKA.
            </p>
        </div>

        <div class="network-grid">

            <div class="network-card">
                <span>IP Client</span>
                <strong>{{ $clientIp }}</strong>
            </div>

            <div class="network-card">
                <span>Jenis IP Client</span>
                <strong>{{ $clientIpType }}</strong>
            </div>

            <div class="network-card">
                <span>IP Server</span>
                <strong>{{ $serverIp }}</strong>
            </div>

            <div class="network-card">
                <span>Jenis IP Server</span>
                <strong>{{ $serverIpType }}</strong>
            </div>

            <div class="network-card">
                <span>Host</span>
                <strong>{{ $host }}</strong>
            </div>

            <div class="network-card">
                <span>Port</span>
                <strong>{{ $port }}</strong>
            </div>

            <div class="network-card">
                <span>Protokol</span>
                <strong>{{ $protocol }}</strong>
            </div>

            <div class="network-card">
                <span>Skema</span>
                <strong>{{ $scheme }}</strong>
            </div>

            <div class="network-card full">
                <span>User Agent</span>
                <strong>{{ $userAgent }}</strong>
            </div>

        </div>

        <div class="info-box">
            <h2>Keterangan</h2>

            <p>
                Informasi ini digunakan sebagai
                pendukung diagnosis jaringan.
                Alamat loopback menunjukkan bahwa
                client mengakses server pada komputer
                yang sama. Alamat privat digunakan
                pada jaringan lokal, sedangkan alamat
                publik dapat digunakan untuk
                komunikasi melalui jaringan internet.
            </p>
        </div>

    </main>

</body>
</html>