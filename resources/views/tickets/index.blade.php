<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Daftar Tiket - SITIKA</title>

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
            min-height: 70px;
            padding: 0 30px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .brand h1 {
            color: #2563eb;
            font-size: 25px;
        }

        .brand p {
            color: #6b7280;
            font-size: 12px;
        }

        .nav-right {
            display: flex;
            gap: 12px;
            align-items: center;
        }

        .nav-link {
            text-decoration: none;
            background: #f3f4f6;
            color: #374151;
            padding: 9px 14px;
            border-radius: 6px;
            font-size: 14px;
        }

        .btn-create {
            text-decoration: none;
            background: #2563eb;
            color: white;
            padding: 9px 14px;
            border-radius: 6px;
            font-size: 14px;
            font-weight: bold;
        }

        .btn-logout {
            border: none;
            background: #dc2626;
            color: white;
            padding: 9px 14px;
            border-radius: 6px;
            cursor: pointer;
        }

        .container {
            max-width: 1200px;
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

        .table-card {
            background: white;
            border: 1px solid #e5e7eb;
            border-radius: 10px;
            overflow: hidden;
        }

        .table-wrapper {
            overflow-x: auto;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th,
        td {
            padding: 14px 16px;
            text-align: left;
            border-bottom: 1px solid #f3f4f6;
            font-size: 14px;
        }

        th {
            background: #f9fafb;
            color: #4b5563;
            font-size: 12px;
            text-transform: uppercase;
        }

        .code {
            color: #2563eb;
            font-weight: bold;
        }

        .badge {
            display: inline-block;
            border-radius: 20px;
            padding: 5px 9px;
            font-size: 11px;
            font-weight: bold;
        }

        .open {
            background: #fee2e2;
            color: #991b1b;
        }

        .progress {
            background: #fef3c7;
            color: #92400e;
        }

        .resolved {
            background: #dcfce7;
            color: #166534;
        }

        .btn-detail {
            text-decoration: none;
            color: white;
            background: #2563eb;
            padding: 7px 11px;
            border-radius: 5px;
            font-size: 12px;
        }

        .empty {
            padding: 40px;
            text-align: center;
            color: #6b7280;
        }

        @media (max-width: 650px) {
            .navbar {
                padding: 15px 20px;
                flex-direction: column;
                align-items: flex-start;
                gap: 15px;
            }

            .nav-right {
                flex-wrap: wrap;
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

        <a href="{{ route('dashboard') }}" class="nav-link">
            Dashboard
        </a>

        @if(auth()->user()->role === 'PELAPOR')
            <a href="{{ route('tickets.create') }}" class="btn-create">
                + Buat Tiket
            </a>
        @endif

        <form action="{{ route('logout') }}" method="POST">
            @csrf

            <button class="btn-logout" type="submit">
                Logout
            </button>
        </form>

    </div>

</nav>

<div class="container">

    <div class="page-header">

        @if(auth()->user()->role === 'PELAPOR')
            <h2>Tiket Saya</h2>
            <p>Daftar tiket dukungan TI yang Anda laporkan.</p>
        @else
            <h2>Semua Tiket</h2>
            <p>Daftar seluruh tiket dukungan TI.</p>
        @endif

    </div>

    <div class="table-card">

        @if($tickets->count() > 0)

            <div class="table-wrapper">

                <table>

                    <thead>
                        <tr>
                            <th>Kode</th>
                            <th>Judul</th>

                            @if(auth()->user()->role === 'TEKNISI')
                                <th>Pelapor</th>
                            @endif

                            <th>Kategori</th>
                            <th>Urgensi</th>
                            <th>Status</th>
                            <th>Tanggal</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>

                    <tbody>

                        @foreach($tickets as $ticket)

                            <tr>

                                <td class="code">
                                    {{ $ticket->code }}
                                </td>

                                <td>
                                    {{ $ticket->title }}
                                </td>

                                @if(auth()->user()->role === 'TEKNISI')
                                    <td>
                                        {{ $ticket->reporter->name }}
                                    </td>
                                @endif

                                <td>
                                    {{ $ticket->category->name }}
                                </td>

                                <td>
                                    {{ $ticket->urgency }}
                                </td>

                                <td>

                                    @if($ticket->status === 'OPEN')

                                        <span class="badge open">
                                            OPEN
                                        </span>

                                    @elseif($ticket->status === 'IN_PROGRESS')

                                        <span class="badge progress">
                                            IN PROGRESS
                                        </span>

                                    @else

                                        <span class="badge resolved">
                                            RESOLVED
                                        </span>

                                    @endif

                                </td>

                                <td>
                                    {{ $ticket->created_at->format('d/m/Y H:i') }}
                                </td>

                                <td>
                                    <a
                                        href="{{ route('tickets.show', $ticket) }}"
                                        class="btn-detail"
                                    >
                                        Detail
                                    </a>
                                </td>

                            </tr>

                        @endforeach

                    </tbody>

                </table>

            </div>

        @else

            <div class="empty">
                Belum ada tiket yang tersedia.
            </div>

        @endif

    </div>

</div>

</body>
</html>