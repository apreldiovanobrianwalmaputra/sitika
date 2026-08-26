<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

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
            align-items: center;
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

        .alert-success {
            background: #dcfce7;
            color: #166534;
            border: 1px solid #bbf7d0;
            padding: 12px 15px;
            border-radius: 8px;
            margin-bottom: 20px;
        }

        .alert-error {
            background: #fee2e2;
            color: #991b1b;
            border: 1px solid #fecaca;
            padding: 12px 15px;
            border-radius: 8px;
            margin-bottom: 20px;
        }

        .alert-error ul {
            margin: 8px 0 0 20px;
        }

        .form-group {
            margin-bottom: 18px;
        }

        .form-group label {
            display: block;
            margin-bottom: 7px;
            font-weight: 600;
            font-size: 14px;
        }

        .form-group textarea {
            width: 100%;
            padding: 12px 13px;
            border: 1px solid #d1d5db;
            border-radius: 7px;
            resize: vertical;
            outline: none;
            font-size: 14px;
        }

        .form-group textarea:focus {
            border-color: #2563eb;
        }

        .field-error {
            color: #dc2626;
            font-size: 13px;
            margin-top: 6px;
        }

        .btn-process {
            background: #2563eb;
            color: white;
            border: none;
            padding: 11px 18px;
            border-radius: 7px;
            font-weight: bold;
            cursor: pointer;
        }

        .btn-process:hover {
            background: #1d4ed8;
        }

        .btn-resolve {
            background: #16a34a;
            color: white;
            border: none;
            padding: 11px 18px;
            border-radius: 7px;
            font-weight: bold;
            cursor: pointer;
        }

        .btn-resolve:hover {
            background: #15803d;
        }

        .ajax-message-success {
            display: block !important;
            background: #dcfce7;
            color: #166534;
            border: 1px solid #bbf7d0;
            padding: 12px 15px;
            border-radius: 8px;
            margin-bottom: 20px;
        }

        .ajax-message-error {
            display: block !important;
            background: #fee2e2;
            color: #991b1b;
            border: 1px solid #fecaca;
            padding: 12px 15px;
            border-radius: 8px;
            margin-bottom: 20px;
        }

        button:disabled {
            opacity: 0.6;
            cursor: not-allowed;
        }

        @media (max-width: 650px) {
            .navbar {
                padding: 15px 20px;
                flex-direction: column;
                align-items: flex-start;
                gap: 15px;
            }

            .nav-right {
                width: 100%;
                flex-wrap: wrap;
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

    <div
        id="ajax-message"
        style="display: none;"
    ></div>

    @if(session('success'))

        <div class="alert-success">
            {{ session('success') }}
        </div>

    @endif


    @if($errors->any())

        <div class="alert-error">

            <strong>
                Terjadi kesalahan:
            </strong>

            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>

        </div>

    @endif

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

                        <span
                            id="ticket-status-badge"
                            class="badge open"
                        >
                            OPEN
                        </span>

                    @elseif($ticket->status === 'IN_PROGRESS')

                        <span
                            id="ticket-status-badge"
                            class="badge progress"
                        >
                            IN PROGRESS
                        </span>

                    @else

                        <span
                            id="ticket-status-badge"
                            class="badge resolved"
                        >
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

    <div id="resolution-container">

        @if(
            $ticket->status === 'RESOLVED'
            && $ticket->resolution_note
        )

            <div class="card resolution">

                <h3 style="margin-bottom: 10px;">
                    Catatan Penyelesaian
                </h3>

                <p>
                    {{ $ticket->resolution_note }}
                </p>

            </div>

        @endif

    </div>

    <div class="card">

        @if(auth()->user()->role === 'TEKNISI')

            <div id="ticket-process-panel">

                @if($ticket->status === 'OPEN')

                    <div class="card">

                        <h3 style="margin-bottom: 10px;">
                            Proses Tiket
                        </h3>

                        <p
                            style="
                                color: #6b7280;
                                margin-bottom: 18px;
                                line-height: 1.6;
                            "
                        >
                            Tiket ini belum ditangani.
                            Mulai proses untuk mengubah status
                            menjadi IN_PROGRESS.
                        </p>

                        <form
                            action="{{ route('tickets.status.update', $ticket) }}"
                            method="POST"
                            class="ajax-status-form"
                        >

                            @csrf
                            @method('PATCH')

                            <input
                                type="hidden"
                                name="status"
                                value="IN_PROGRESS"
                            >

                            <button
                                type="submit"
                                class="btn-process"
                            >
                                Mulai Proses
                            </button>

                        </form>

                    </div>

                @elseif($ticket->status === 'IN_PROGRESS')

                    <div class="card">

                        <h3 style="margin-bottom: 10px;">
                            Selesaikan Tiket
                        </h3>

                        <p
                            style="
                                color: #6b7280;
                                margin-bottom: 18px;
                                line-height: 1.6;
                            "
                        >
                            Masukkan catatan penyelesaian
                            sebelum mengubah status menjadi
                            RESOLVED.
                        </p>

                        <form
                            action="{{ route('tickets.status.update', $ticket) }}"
                            method="POST"
                            class="ajax-status-form"
                        >

                            @csrf
                            @method('PATCH')

                            <input
                                type="hidden"
                                name="status"
                                value="RESOLVED"
                            >

                            <div class="form-group">

                                <label for="resolution_note">
                                    Catatan Penyelesaian
                                </label>

                                <textarea
                                    id="resolution_note"
                                    name="resolution_note"
                                    rows="5"
                                    placeholder="Jelaskan tindakan yang telah dilakukan..."
                                ></textarea>

                                <div
                                    id="resolution-error"
                                    class="field-error"
                                ></div>

                            </div>

                            <button
                                type="submit"
                                class="btn-resolve"
                            >
                                Selesaikan Tiket
                            </button>

                        </form>

                    </div>

                @else

                    <div class="card">

                        <h3 style="margin-bottom: 10px;">
                            Tiket Selesai
                        </h3>

                        <p style="color: #6b7280;">
                            Tiket ini sudah diselesaikan dan
                            tidak dapat diubah lagi.
                        </p>

                    </div>

                @endif

            </div>

        @endif

        <h3>Riwayat Tiket</h3>

        <div
            class="timeline"
            id="ticket-history"
        >

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

<script>
document.addEventListener('submit', async function (event) {

    const form = event.target.closest('.ajax-status-form');

    if (!form) {
        return;
    }

    event.preventDefault();

    const button = form.querySelector(
        'button[type="submit"]'
    );

    const originalButtonText = button.textContent;

    const messageBox = document.getElementById(
        'ajax-message'
    );

    const statusInput = form.querySelector(
        'input[name="status"]'
    );

    const status = statusInput.value;

    const resolutionNote = form.querySelector(
        'textarea[name="resolution_note"]'
    );

    // Loading state
    button.disabled = true;
    button.textContent = 'Memproses...';

    messageBox.style.display = 'none';
    messageBox.className = '';
    messageBox.textContent = '';

    const payload = {
        status: status
    };

    if (resolutionNote) {
        payload.resolution_note =
            resolutionNote.value;
    }

    try {

        const csrfToken = document
            .querySelector('meta[name="csrf-token"]')
            .getAttribute('content');

        const response = await fetch(
            form.action,
            {
                method: 'PATCH',

                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': csrfToken
                },

                body: JSON.stringify(payload)
            }
        );

        const data = await response.json();

        if (!response.ok) {

            let message =
                data.message ||
                'Gagal memperbarui status tiket.';

            if (data.errors) {

                const firstError =
                    Object.values(data.errors)[0];

                if (firstError && firstError[0]) {
                    message = firstError[0];
                }
            }

            throw new Error(message);
        }

        // SUCCESS MESSAGE
        messageBox.className =
            'ajax-message-success';

        messageBox.textContent =
            data.message;

        // UPDATE STATUS BADGE
        updateStatusBadge(data.status);

        // UPDATE PANEL TEKNISI
        updateProcessPanel(
            data.status,
            form.action
        );

        // TAMBAH HISTORY
        appendHistory(data.log);

        // TAMPILKAN RESOLUTION NOTE
        if (
            data.status === 'RESOLVED'
            && data.resolution_note
        ) {
            showResolutionNote(
                data.resolution_note
            );
        }

    } catch (error) {

        messageBox.className =
            'ajax-message-error';

        messageBox.textContent =
            error.message;

        button.disabled = false;
        button.textContent =
            originalButtonText;
    }
});


function updateStatusBadge(status) {

    const badge = document.getElementById(
        'ticket-status-badge'
    );

    if (!badge) {
        return;
    }

    if (status === 'OPEN') {

        badge.className = 'badge open';
        badge.textContent = 'OPEN';

    } else if (status === 'IN_PROGRESS') {

        badge.className = 'badge progress';
        badge.textContent = 'IN PROGRESS';

    } else {

        badge.className = 'badge resolved';
        badge.textContent = 'RESOLVED';
    }
}


function updateProcessPanel(status, actionUrl) {

    const panel = document.getElementById(
        'ticket-process-panel'
    );

    if (!panel) {
        return;
    }

    if (status === 'IN_PROGRESS') {

        panel.innerHTML = `
            <div class="card">

                <h3 style="margin-bottom: 10px;">
                    Selesaikan Tiket
                </h3>

                <p
                    style="
                        color: #6b7280;
                        margin-bottom: 18px;
                        line-height: 1.6;
                    "
                >
                    Masukkan catatan penyelesaian
                    sebelum mengubah status menjadi
                    RESOLVED.
                </p>

                <form
                    action="${actionUrl}"
                    method="POST"
                    class="ajax-status-form"
                >

                    <input
                        type="hidden"
                        name="status"
                        value="RESOLVED"
                    >

                    <div class="form-group">

                        <label>
                            Catatan Penyelesaian
                        </label>

                        <textarea
                            name="resolution_note"
                            rows="5"
                            placeholder="Jelaskan tindakan yang telah dilakukan..."
                        ></textarea>

                    </div>

                    <button
                        type="submit"
                        class="btn-resolve"
                    >
                        Selesaikan Tiket
                    </button>

                </form>

            </div>
        `;

    } else if (status === 'RESOLVED') {

        panel.innerHTML = `
            <div class="card">

                <h3 style="margin-bottom: 10px;">
                    Tiket Selesai
                </h3>

                <p style="color: #6b7280;">
                    Tiket ini sudah diselesaikan
                    dan tidak dapat diubah lagi.
                </p>

            </div>
        `;
    }
}


function appendHistory(log) {

    const history = document.getElementById(
        'ticket-history'
    );

    if (!history) {
        return;
    }

    const item = document.createElement('div');

    item.className = 'timeline-item';

    item.innerHTML = `
        <div class="timeline-date">
            ${escapeHtml(log.created_at)}
        </div>

        <div class="timeline-user">
            ${escapeHtml(log.user)}
        </div>

        <div class="timeline-status">
            ${escapeHtml(log.old_status)}
            →
            ${escapeHtml(log.new_status)}
        </div>

        <div class="timeline-note">
            ${escapeHtml(log.note ?? '')}
        </div>
    `;

    history.appendChild(item);
}


function showResolutionNote(note) {

    const container = document.getElementById(
        'resolution-container'
    );

    if (!container) {
        return;
    }

    container.innerHTML = `
        <div class="card resolution">

            <h3 style="margin-bottom: 10px;">
                Catatan Penyelesaian
            </h3>

            <p>
                ${escapeHtml(note)}
            </p>

        </div>
    `;
}


function escapeHtml(value) {

    const div = document.createElement('div');

    div.textContent =
        value === null || value === undefined
            ? ''
            : value;

    return div.innerHTML;
}
</script>

</body>
</html>