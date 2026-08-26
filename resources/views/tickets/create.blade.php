<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Buat Tiket - SITIKA</title>

    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
            font-family: Arial, Helvetica, sans-serif;
        }

        body {
            background: #f3f4f6;
            color: #1f2937;
        }

        .navbar {
            background: white;
            border-bottom: 1px solid #e5e7eb;
            padding: 0 30px;
            min-height: 70px;

            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .brand h1 {
            color: #2563eb;
            font-size: 25px;
        }

        .brand p {
            color: #6b7280;
            font-size: 12px;
            margin-top: 2px;
        }

        .nav-right {
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .user-info {
            text-align: right;
        }

        .user-name {
            font-weight: bold;
            font-size: 14px;
        }

        .user-role {
            color: #6b7280;
            font-size: 12px;
            margin-top: 3px;
        }

        .btn-dashboard {
            text-decoration: none;
            background: #f3f4f6;
            color: #374151;
            padding: 9px 14px;
            border-radius: 6px;
            font-size: 14px;
        }

        .btn-logout {
            background: #dc2626;
            color: white;
            border: none;
            padding: 9px 14px;
            border-radius: 6px;
            cursor: pointer;
        }

        .container {
            max-width: 850px;
            margin: 30px auto;
            padding: 0 20px;
        }

        .page-header {
            margin-bottom: 20px;
        }

        .page-header h2 {
            margin-bottom: 5px;
        }

        .page-header p {
            color: #6b7280;
            font-size: 14px;
        }

        .form-card {
            background: white;
            border: 1px solid #e5e7eb;
            border-radius: 10px;
            padding: 25px;
        }

        .form-group {
            margin-bottom: 20px;
        }

        label {
            display: block;
            margin-bottom: 7px;
            font-weight: 600;
            font-size: 14px;
        }

        input,
        select,
        textarea {
            width: 100%;
            padding: 11px 13px;
            border: 1px solid #d1d5db;
            border-radius: 7px;
            outline: none;
            font-size: 14px;
            background: white;
        }

        input:focus,
        select:focus,
        textarea:focus {
            border-color: #2563eb;
        }

        textarea {
            resize: vertical;
            min-height: 130px;
        }

        .required {
            color: #dc2626;
        }

        .error {
            color: #dc2626;
            font-size: 13px;
            margin-top: 6px;
        }

        .alert-error {
            background: #fee2e2;
            color: #991b1b;
            padding: 14px;
            border-radius: 7px;
            margin-bottom: 20px;
        }

        .alert-error ul {
            margin: 8px 0 0 20px;
        }

        .actions {
            display: flex;
            justify-content: flex-end;
            gap: 10px;
            margin-top: 25px;
        }

        .btn-cancel {
            text-decoration: none;
            padding: 11px 18px;
            border-radius: 7px;
            background: #e5e7eb;
            color: #374151;
        }

        .btn-submit {
            border: none;
            background: #2563eb;
            color: white;
            padding: 11px 18px;
            border-radius: 7px;
            font-weight: bold;
            cursor: pointer;
        }

        .btn-submit:hover {
            background: #1d4ed8;
        }

        @media (max-width: 650px) {
            .navbar {
                padding: 15px 20px;
                align-items: flex-start;
                flex-direction: column;
                gap: 15px;
            }

            .nav-right {
                width: 100%;
                flex-wrap: wrap;
            }

            .user-info {
                text-align: left;
                flex: 1;
            }

            .container {
                margin-top: 20px;
                padding: 0 15px;
            }

            .form-card {
                padding: 18px;
            }

            .actions {
                flex-direction: column-reverse;
            }

            .btn-cancel,
            .btn-submit {
                width: 100%;
                text-align: center;
            }
        }
    </style>
</head>

<body>

<nav class="navbar">

    <div class="brand">
        <h1>SITIKA</h1>
        <p>Sistem Tiket Dukungan TI</p>
    </div>

    <div class="nav-right">

        <a
            href="{{ route('dashboard') }}"
            class="btn-dashboard"
        >
            Dashboard
        </a>

        <div class="user-info">
            <div class="user-name">
                {{ auth()->user()->name }}
            </div>

            <div class="user-role">
                {{ auth()->user()->role }}
            </div>
        </div>

        <form
            action="{{ route('logout') }}"
            method="POST"
        >
            @csrf

            <button
                type="submit"
                class="btn-logout"
            >
                Logout
            </button>
        </form>

    </div>

</nav>


<div class="container">

    <div class="page-header">
        <h2>Buat Tiket Dukungan TI</h2>

        <p>
            Lengkapi informasi kendala yang Anda alami.
        </p>
    </div>


    @if($errors->any())

        <div class="alert-error">

            <strong>
                Periksa kembali data yang Anda masukkan.
            </strong>

            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>

        </div>

    @endif


    <div class="form-card">

        <form
            action="{{ route('tickets.store') }}"
            method="POST"
        >

            @csrf


            <div class="form-group">

                <label for="category_id">
                    Kategori
                    <span class="required">*</span>
                </label>

                <select
                    id="category_id"
                    name="category_id"
                >

                    <option value="">
                        -- Pilih Kategori --
                    </option>

                    @foreach($categories as $category)

                        <option
                            value="{{ $category->id }}"
                            {{ old('category_id') == $category->id ? 'selected' : '' }}
                        >
                            {{ $category->name }}
                        </option>

                    @endforeach

                </select>

                @error('category_id')
                    <div class="error">
                        {{ $message }}
                    </div>
                @enderror

            </div>


            <div class="form-group">

                <label for="title">
                    Judul
                    <span class="required">*</span>
                </label>

                <input
                    type="text"
                    id="title"
                    name="title"
                    value="{{ old('title') }}"
                    placeholder="Contoh: Komputer tidak dapat menyala"
                >

                @error('title')
                    <div class="error">
                        {{ $message }}
                    </div>
                @enderror

            </div>


            <div class="form-group">

                <label for="location">
                    Lokasi
                    <span class="required">*</span>
                </label>

                <input
                    type="text"
                    id="location"
                    name="location"
                    value="{{ old('location') }}"
                    placeholder="Contoh: Ruang Administrasi"
                >

                @error('location')
                    <div class="error">
                        {{ $message }}
                    </div>
                @enderror

            </div>


            <div class="form-group">

                <label for="description">
                    Deskripsi
                    <span class="required">*</span>
                </label>

                <textarea
                    id="description"
                    name="description"
                    placeholder="Jelaskan kendala yang terjadi..."
                >{{ old('description') }}</textarea>

                @error('description')
                    <div class="error">
                        {{ $message }}
                    </div>
                @enderror

            </div>


            <div class="form-group">

                <label for="urgency">
                    Urgensi
                    <span class="required">*</span>
                </label>

                <select
                    id="urgency"
                    name="urgency"
                >

                    <option value="">
                        -- Pilih Urgensi --
                    </option>

                    <option
                        value="RENDAH"
                        {{ old('urgency') === 'RENDAH' ? 'selected' : '' }}
                    >
                        RENDAH
                    </option>

                    <option
                        value="SEDANG"
                        {{ old('urgency') === 'SEDANG' ? 'selected' : '' }}
                    >
                        SEDANG
                    </option>

                    <option
                        value="TINGGI"
                        {{ old('urgency') === 'TINGGI' ? 'selected' : '' }}
                    >
                        TINGGI
                    </option>

                </select>

                @error('urgency')
                    <div class="error">
                        {{ $message }}
                    </div>
                @enderror

            </div>


            <div class="actions">

                <a
                    href="{{ route('dashboard') }}"
                    class="btn-cancel"
                >
                    Batal
                </a>

                <button
                    type="submit"
                    class="btn-submit"
                >
                    Buat Tiket
                </button>

            </div>

        </form>

    </div>

</div>

</body>
</html>