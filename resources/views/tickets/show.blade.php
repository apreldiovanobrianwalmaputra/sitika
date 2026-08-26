<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>{{ $ticket->code }} - SITIKA</title>

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
            justify-content: space-between;
            align-items: center;
        }

        .brand h1 {
            color: #2563eb;
        }

        .brand p {
            color: #6b7280;
            font-size: 12px;
        }

        .nav-right {
            display: flex;
            gap: 10px;
        }

        .nav-link {
            text-decoration: none;
            background: #f3f4f6;
            color: #374151;
            padding: 9px 14px;
            border-radius: 6px;
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
            max-width: 1000px;
            margin: 30px auto;
            padding: 0 20px;
        }

        .header {
            margin-bottom: 20px;
        }

        .header .code {
            color: #2563eb;
            font-weight: bold;
            margin-bottom: 5px;
        }

        .card {
            background: white;
            border: 1px solid #e5e7eb;
            border-radius: 10px;
            padding: 24px;
            margin-bottom: 20px;
        }

        .detail-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 20px;
        }

        .detail-label {
            color: #6b7280;
            font-size: 12px;
            margin-bottom: 5px;
        }

        .detail-value {
            font-weight: 600;
        }

        .description {
            margin-top: 25px;
            line-height: 1.7;
        }

        .description h3 {
            margin-bottom: 10px;
        }

        .badge {
            display: inline-block;
            border-radius: 20px;
            padding: 5px 10px;
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

        .timeline {
            margin-top: 20px;
        }

        .timeline-item {
            position: relative;
            border-left: 3px solid #dbeafe;
            padding: 0 0 25px 20px;
            margin-left: 5px;
        }

        .timeline-item:last-child {
            padding-bottom: 0;
        }

        .timeline-item::before {
            content: "";
            position: absolute;
            width: 11px;
            height: 11px;
            border-radius: 50%;
            background: #2563eb;
            left: -7px;
            top: 4px;
        }

        .timeline-date {
            color: #6b7280;
            font-size: 12px;
            margin-bottom: 5px;
        }

        .timeline-user {
            font-weight: bold;
            margin-bottom: 5px;
        }

        .timeline-status {
            font-size: 14px;
        }

        .timeline-note {
            color: #4b5563;
            font-size: 13px;
            margin-top: 5px;
        }

        .resolution {
            background: #ecfdf5;
            border: 1px solid #a7f3d0;
        }

        @media (max-width: 650px) {
            .navbar {
                padding: 15px 20px;
                flex-direction: column;
                align-items: flex-start;
                gap: 15px;
            }

            .detail-grid {
                grid-template-columns: 1fr;
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

        <a href="{{ route('tickets.index') }}" class="nav-link">
            Tiket
        </a>

        <form action="{{ route('logout') }}" method="POST">
            @csrf

            <button type="submit" class="btn-logout">
                Logout
            </button>
        </form>

    </div>

</nav>


<div class="container">

    <div class="header">
        <div class="code">
            {{ $ticket->code }}
        </div>

        <h2>
            {{ $ticket->title }}
        </h2>
    </div>


    <div class="card">

        <div class="detail-grid">

            <div>
                <div class="detail-label">Pelapor</div>

                <div class="detail-value">
                    {{ $ticket->reporter->name }}
                </div>
            </div>

            <div>
                <div class="detail-label">Kategori</div>

                <div class="detail-value">
                    {{ $ticket->category->name }}
                </div>
            </div>

            <div>
                <div class="detail-label">Lokasi</div>

                <div class="detail-value">
                    {{ $ticket->location }}
                </div>
            </div>

            <div>
                <div class="detail-label">Urgensi</div>

                <div class="detail-value">
                    {{ $ticket->urgency }}
                </div>
            </div>

            <div>
                <div class="detail-label">Status</div>

                <div class="detail-value">

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

                </div>
            </div>

            <div>
                <div class="detail-label">Dibuat</div>

                <div class="detail-value">
                    {{ $ticket->created_at->format('d/m/Y H:i') }}
                </div>
            </div>

        </div>


        <div class="description">

            <h3>Deskripsi</h3>

            <p>
                {{ $ticket->description }}
            </p>

        </div>

    </div>


    @if($ticket->status === 'RESOLVED' && $ticket->resolution_note)

        <div class="card resolution">

            <h3 style="margin-bottom: 10px;">
                Catatan Penyelesaian
            </h3>

            <p>
                {{ $ticket->resolution_note }}
            </p>

        </div>

    @endif


    <div class="card">

        <h3>Riwayat Tiket</h3>

        <div class="timeline">

            @foreach($ticket->logs->sortBy('created_at') as $log)

                <div class="timeline-item">

                    <div class="timeline-date">
                        {{ $log->created_at->format('d/m/Y H:i') }}
                    </div>

                    <div class="timeline-user">
                        {{ $log->user->name }}
                    </div>

                    <div class="timeline-status">

                        @if($log->old_status)

                            {{ $log->old_status }}
                            →
                            {{ $log->new_status }}

                        @else

                            Status:
                            {{ $log->new_status }}

                        @endif

                    </div>

                    @if($log->note)

                        <div class="timeline-note">
                            {{ $log->note }}
                        </div>

                    @endif

                </div>

            @endforeach

        </div>

    </div>

</div>

</body>
</html>