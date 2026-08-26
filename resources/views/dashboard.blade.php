<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Dashboard - SITIKA</title>

    <style>
        * {
            box-sizing: border-box;
            font-family: Arial, Helvetica, sans-serif;
        }

        body {
            margin: 0;
            padding: 40px 20px;
            background: #f3f4f6;
        }

        .container {
            max-width: 900px;
            margin: auto;
            background: white;
            padding: 30px;
            border-radius: 12px;
        }

        h1 {
            color: #2563eb;
        }

        .user-box {
            margin: 25px 0;
            padding: 20px;
            background: #f9fafb;
            border-radius: 8px;
        }

        .user-box p {
            margin: 8px 0;
        }

        .btn-logout {
            padding: 10px 20px;
            border: none;
            border-radius: 6px;
            background: #dc2626;
            color: white;
            cursor: pointer;
        }
    </style>
</head>

<body>

<div class="container">

    <h1>SITIKA</h1>
    <p>Sistem Tiket Dukungan TI</p>

    <hr>

    <h2>Dashboard</h2>

    @if(session('success'))
        <p style="color: green;">
            {{ session('success') }}
        </p>
    @endif

    <div class="user-box">

        <p>
            <strong>Nama:</strong>
            {{ auth()->user()->name }}
        </p>

        <p>
            <strong>Email:</strong>
            {{ auth()->user()->email }}
        </p>

        <p>
            <strong>Role:</strong>
            {{ auth()->user()->role }}
        </p>

    </div>

    <form action="{{ route('logout') }}" method="POST">
        @csrf

        <button type="submit" class="btn-logout">
            Logout
        </button>
    </form>

</div>

</body>
</html>