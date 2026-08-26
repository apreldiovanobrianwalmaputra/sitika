<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Login - SITIKA</title>

    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
            font-family: Arial, Helvetica, sans-serif;
        }

        body {
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 20px;
            background: #f3f4f6;
        }

        .login-card {
            width: 100%;
            max-width: 420px;
            background: #ffffff;
            padding: 35px;
            border-radius: 12px;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.08);
        }

        .header {
            text-align: center;
            margin-bottom: 30px;
        }

        .header h1 {
            color: #2563eb;
            font-size: 32px;
            margin-bottom: 5px;
        }

        .header p {
            color: #6b7280;
            font-size: 14px;
        }

        .form-group {
            margin-bottom: 18px;
        }

        label {
            display: block;
            margin-bottom: 7px;
            font-weight: 600;
            color: #374151;
        }

        input {
            width: 100%;
            padding: 12px 14px;
            border: 1px solid #d1d5db;
            border-radius: 7px;
            outline: none;
        }

        input:focus {
            border-color: #2563eb;
        }

        .btn-login {
            width: 100%;
            padding: 12px;
            background: #2563eb;
            border: none;
            border-radius: 7px;
            color: white;
            font-size: 15px;
            font-weight: bold;
            cursor: pointer;
        }

        .btn-login:hover {
            background: #1d4ed8;
        }

        .error {
            margin-top: 6px;
            color: #dc2626;
            font-size: 13px;
        }

        .success {
            margin-bottom: 18px;
            padding: 10px 12px;
            background: #dcfce7;
            color: #166534;
            border-radius: 7px;
        }

        .demo {
            margin-top: 25px;
            padding: 15px;
            background: #f9fafb;
            border-radius: 8px;
            color: #4b5563;
            font-size: 13px;
            line-height: 1.7;
        }

        .demo strong {
            color: #111827;
        }
    </style>
</head>

<body>

<div class="login-card">

    <div class="header">
        <h1>SITIKA</h1>
        <p>Sistem Tiket Dukungan TI</p>
    </div>

    @if(session('success'))
        <div class="success">
            {{ session('success') }}
        </div>
    @endif

    <form action="{{ route('login.process') }}" method="POST">

        @csrf

        <div class="form-group">
            <label for="email">Email</label>

            <input
                type="email"
                id="email"
                name="email"
                value="{{ old('email') }}"
                placeholder="Masukkan email"
                autofocus
            >

            @error('email')
                <div class="error">
                    {{ $message }}
                </div>
            @enderror
        </div>

        <div class="form-group">
            <label for="password">Password</label>

            <input
                type="password"
                id="password"
                name="password"
                placeholder="Masukkan password"
            >

            @error('password')
                <div class="error">
                    {{ $message }}
                </div>
            @enderror
        </div>

        <button type="submit" class="btn-login">
            Masuk
        </button>

    </form>

    <div class="demo">
        <strong>Akun Demo</strong><br><br>

        Pelapor:<br>
        pelapor1@demo.local<br><br>

        Teknisi:<br>
        teknisi@demo.local<br><br>

        Password:<br>
        Magang123!
    </div>

</div>

</body>
</html>