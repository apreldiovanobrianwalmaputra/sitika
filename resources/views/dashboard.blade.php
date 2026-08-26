<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Dashboard - SITIKA</title>

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
            background: #ffffff;
            border-bottom: 1px solid #e5e7eb;
            padding: 0 30px;
            height: 70px;
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

        .navbar-right {
            display: flex;
            align-items: center;
            gap: 18px;
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

        .btn-logout {
            background: #dc2626;
            color: white;
            border: none;
            border-radius: 6px;
            padding: 9px 15px;
            cursor: pointer;
        }

        .btn-logout:hover {
            background: #b91c1c;
        }

        .container {
            max-width: 1200px;
            margin: 30px auto;
            padding: 0 20px;
        }

        .page-header {
            margin-bottom: 25px;
        }

        .page-header h2 {
            font-size: 26px;
            margin-bottom: 5px;
        }

        .page-header p {
            color: #6b7280;
            font-size: 14px;
        }

        .alert-success {
            background: #dcfce7;
            color: #166534;
            padding: 12px 15px;
            border-radius: 7px;
            margin-bottom: 20px;
        }

        .cards {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 20px;
            margin-bottom: 30px;
        }

        .card {
            background: white;
            padding: 22px;
            border-radius: 10px;
            border: 1px solid #e5e7eb;
        }

        .card-title {
            color: #6b7280;
            font-size: 13px;
            margin-bottom: 12px;
        }

        .card-value {
            font-size: 30px;
            font-weight: bold;
            color: #111827;
        }

        .ticket-section {
            background: white;
            border-radius: 10px;
            border: 1px solid #e5e7eb;
            overflow: hidden;
        }

        .section-header {
            padding: 20px;
            border-bottom: 1px solid #e5e7eb;
        }

        .section-header h3 {
            font-size: 18px;
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
            text-align: left;
            padding: 14px 18px;
            border-bottom: 1px solid #f3f4f6;
            font-size: 14px;
        }

        th {
            background: #f9fafb;
            color: #4b5563;
            font-size: 12px;
            text-transform: uppercase;
        }

        tr:last-child td {
            border-bottom: none;
        }

        .ticket-code {
            color: #2563eb;
            font-weight: bold;
        }

        .badge {
            display: inline-block;
            padding: 5px 9px;
            border-radius: 20px;
            font-size: 11px;
            font-weight: bold;
        }

        .status-open {
            background: #fee2e2;
            color: #991b1b;
        }

        .status-progress {
            background: #fef3c7;
            color: #92400e;
        }

        .status-resolved {
            background: #dcfce7;
            color: #166534;
        }

        .urgency-rendah {
            background: #f3f4f6;
            color: #4b5563;
        }

        .urgency-sedang {
            background: #dbeafe;
            color: #1e40af;
        }

        .urgency-tinggi {
            background: #fee2e2;
            color: #991b1b;
        }

        .empty-state {
            padding: 35px;
            text-align: center;
            color: #6b7280;
        }

        @media (max-width: 900px) {
            .cards {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        @media (max-width: 600px) {
            .navbar {
                height: auto;
                padding: 15px 20px;
                flex-direction: column;
                align-items: flex-start;
                gap: 15px;
            }

            .navbar-right {
                width: 100%;
                justify-content: space-between;
            }

            .user-info {
                text-align: left;
            }

            .cards {
                grid-template-columns: 1fr;
            }

            .container {
                margin-top: 20px;
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

    <div class="navbar-right">

        <div class="user-info">
            <div class="user-name">
                {{ auth()->user()->name }}
            </div>

            <div class="user-role">
                {{ auth()->user()->role }}
            </div>
        </div>

        <form action="{{ route('logout') }}" method="POST">
            @csrf

            <button type="submit" class="btn-logout">
                Logout
            </button>
        </form>

    </div>

</nav>


<div class="container">

    @if(session('success'))
        <div class="alert-success">
            {{ session('success') }}
        </div>
    @endif


    <div class="page-header">

        <h2>Dashboard</h2>

        @if(auth()->user()->role === 'PELAPOR')

            <p>
                Ringkasan tiket dukungan TI yang Anda laporkan.
            </p>

            <div style="margin-top: 15px;">

                <a
                    href="{{ route('tickets.create') }}"
                    style="
                        display: inline-block;
                        background: #2563eb;
                        color: white;
                        text-decoration: none;
                        padding: 10px 16px;
                        border-radius: 7px;
                        font-size: 14px;
                        font-weight: bold;
                    "
                >
                    + Buat Tiket
                </a>

            </div>

        @else

            <p>
                Ringkasan seluruh tiket dukungan TI.
            </p>

        @endif

    </div>


    <div class="cards">

        <div class="card">
            <div class="card-title">
                TOTAL TIKET
            </div>

            <div class="card-value">
                {{ $totalTickets }}
            </div>
        </div>


        <div class="card">
            <div class="card-title">
                OPEN
            </div>

            <div class="card-value">
                {{ $openTickets }}
            </div>
        </div>


        <div class="card">
            <div class="card-title">
                IN PROGRESS
            </div>

            <div class="card-value">
                {{ $inProgressTickets }}
            </div>
        </div>


        <div class="card">
            <div class="card-title">
                RESOLVED
            </div>

            <div class="card-value">
                {{ $resolvedTickets }}
            </div>
        </div>

    </div>


    <div class="ticket-section">

        <div class="section-header">
            <h3>5 Tiket Terbaru</h3>
        </div>


        @if($latestTickets->count() > 0)

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
                        </tr>
                    </thead>

                    <tbody>

                        @foreach($latestTickets as $ticket)

                            <tr>

                                <td>
                                    <span class="ticket-code">
                                        {{ $ticket->code }}
                                    </span>
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

                                    @if($ticket->urgency === 'RENDAH')

                                        <span class="badge urgency-rendah">
                                            RENDAH
                                        </span>

                                    @elseif($ticket->urgency === 'SEDANG')

                                        <span class="badge urgency-sedang">
                                            SEDANG
                                        </span>

                                    @else

                                        <span class="badge urgency-tinggi">
                                            TINGGI
                                        </span>

                                    @endif

                                </td>

                                <td>

                                    @if($ticket->status === 'OPEN')

                                        <span class="badge status-open">
                                            OPEN
                                        </span>

                                    @elseif($ticket->status === 'IN_PROGRESS')

                                        <span class="badge status-progress">
                                            IN PROGRESS
                                        </span>

                                    @else

                                        <span class="badge status-resolved">
                                            RESOLVED
                                        </span>

                                    @endif

                                </td>

                                <td>
                                    {{ $ticket->created_at->format('d/m/Y H:i') }}
                                </td>

                            </tr>

                        @endforeach

                    </tbody>

                </table>

            </div>

        @else

            <div class="empty-state">
                Belum ada tiket yang tersedia.
            </div>

        @endif

    </div>

</div>

</body>
</html>