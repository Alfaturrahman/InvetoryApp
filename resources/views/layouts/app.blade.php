<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'Inventaris MTI' }}</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Sora:wght@400;500;600;700&family=JetBrains+Mono:wght@500&display=swap" rel="stylesheet">
    <style>
        :root {
            --bg: #f6f8f3;
            --bg-soft: #eef3e7;
            --panel: rgba(255, 255, 255, 0.9);
            --line: #d7dfd1;
            --text: #203024;
            --muted: #5f7263;
            --brand: #1c7c54;
            --brand-2: #2e9b6b;
            --ok: #2f8f62;
            --warn: #d4870a;
            --bad: #bf4538;
            --shadow: 0 18px 36px rgba(32, 48, 36, 0.12);
        }
        * { box-sizing: border-box; }
        body {
            margin: 0;
            font-family: "Sora", sans-serif;
            background: var(--bg);
            color: var(--text);
            min-height: 100vh;
            background-image:
                radial-gradient(circle at 12% 14%, rgba(46, 155, 107, 0.24), transparent 28%),
                radial-gradient(circle at 92% 6%, rgba(212, 135, 10, 0.18), transparent 22%),
                linear-gradient(160deg, var(--bg), var(--bg-soft));
        }
        .bg-shape {
            position: fixed;
            z-index: 0;
            pointer-events: none;
            border-radius: 999px;
            filter: blur(70px);
            opacity: 0.45;
        }
        .bg-shape.a {
            width: 320px;
            height: 320px;
            left: -120px;
            top: -90px;
            background: #9cdcbf;
        }
        .bg-shape.b {
            width: 360px;
            height: 360px;
            right: -130px;
            bottom: -120px;
            background: #efd08b;
        }
        .topbar {
            position: sticky;
            top: 0;
            z-index: 8;
            background: linear-gradient(90deg, #1e5f43, #2f8f62);
            color: #f4fff7;
            padding: 14px 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 12px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.24);
            box-shadow: 0 8px 22px rgba(20, 66, 47, 0.22);
        }
        .topbar h1 {
            font-size: 1.02rem;
            margin: 0;
            letter-spacing: .3px;
        }
        .topbar small { color: #d8efe2; }
        .topbar .identity strong {
            font-family: "JetBrains Mono", monospace;
            font-size: .88rem;
            letter-spacing: .2px;
        }
        .container {
            position: relative;
            z-index: 1;
            max-width: 1200px;
            margin: 20px auto;
            padding: 0 14px;
        }
        .panel {
            background: var(--panel);
            border: 1px solid var(--line);
            border-radius: 14px;
            padding: 16px 16px 14px;
            margin-bottom: 14px;
            box-shadow: var(--shadow);
            backdrop-filter: blur(4px);
        }
        .grid {
            display: grid;
            gap: 12px;
        }
        .grid.cols-4 { grid-template-columns: repeat(4, minmax(120px, 1fr)); }
        .grid.cols-2 { grid-template-columns: repeat(2, minmax(220px, 1fr)); }
        .nav {
            display: flex;
            flex-wrap: wrap;
            gap: 8px;
            margin-bottom: 12px;
            background: linear-gradient(180deg, rgba(255, 255, 255, 0.82), rgba(244, 250, 244, 0.82));
        }
        .btn, button {
            border: 1px solid var(--line);
            background: #ffffff;
            padding: 9px 12px;
            border-radius: 10px;
            color: var(--text);
            cursor: pointer;
            text-decoration: none;
            font-size: .9rem;
            font-family: inherit;
            font-weight: 500;
            transition: transform .16s ease, box-shadow .16s ease, background-color .16s ease;
            min-height: 40px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 6px;
        }
        .btn:hover, button:hover {
            transform: translateY(-1px);
            box-shadow: 0 7px 16px rgba(34, 52, 38, 0.11);
        }
        .btn:disabled, button:disabled {
            cursor: not-allowed;
            opacity: .56;
            transform: none;
            box-shadow: none;
        }
        .btn.primary { background: linear-gradient(135deg, var(--brand), var(--brand-2)); color: #fff; border-color: transparent; }
        .btn.warn { background: linear-gradient(135deg, #cb7c05, var(--warn)); color: #fff; border-color: transparent; }
        .btn.bad { background: linear-gradient(135deg, #b1392d, var(--bad)); color: #fff; border-color: transparent; }
        .btn.ok { background: linear-gradient(135deg, #2a7652, var(--ok)); color: #fff; border-color: transparent; }
        .btn.ghost {
            background: rgba(255, 255, 255, 0.65);
        }
        .btn-sm {
            min-height: 34px;
            padding: 6px 10px;
            font-size: .82rem;
        }
        .btn-full {
            width: 100%;
        }
        .muted { color: var(--muted); }
        .stat h3 { margin: 8px 0 0; font-size: 1.6rem; }
        .stat p { margin: 0; color: var(--muted); }
        .table-wrap { overflow-x: auto; }
        table {
            width: 100%;
            border-collapse: collapse;
            min-width: 720px;
        }
        th, td {
            border-bottom: 1px solid var(--line);
            text-align: left;
            padding: 10px 9px;
            font-size: .9rem;
            vertical-align: top;
        }
        th {
            background: #f0f6ee;
            color: #314739;
            font-weight: 600;
            letter-spacing: .1px;
        }
        input, select, textarea {
            width: 100%;
            border: 1px solid var(--line);
            border-radius: 10px;
            padding: 8px 10px;
            font: inherit;
            margin-top: 4px;
            background: #ffffff;
            color: var(--text);
        }
        input:focus, select:focus, textarea:focus {
            outline: 2px solid rgba(46, 155, 107, 0.26);
            border-color: #77be9b;
        }
        textarea { min-height: 70px; }
        .form-grid {
            display: grid;
            grid-template-columns: repeat(4, minmax(150px, 1fr));
            gap: 10px;
            align-items: end;
        }
        .badge {
            display: inline-block;
            border-radius: 999px;
            padding: 4px 9px;
            font-size: .75rem;
            font-weight: 600;
            letter-spacing: .2px;
        }
        .badge.ok { background: #dff4e8; color: #0f9d58; }
        .badge.warn { background: #fff3dd; color: #b06d07; }
        .badge.bad { background: #fee7e5; color: #b3261e; }
        .flash {
            border-radius: 10px;
            padding: 10px 12px;
            margin-bottom: 10px;
            border: 1px solid;
            box-shadow: 0 4px 14px rgba(22, 58, 34, 0.08);
        }
        .flash.success { background: #e8f6ef; border-color: #bde7cf; color: #16643a; }
        .flash.error { background: #fdecec; border-color: #f6c6c2; color: #8f2118; }
        .actions {
            display: flex;
            gap: 6px;
            flex-wrap: wrap;
        }
        details > summary {
            cursor: pointer;
            color: #2e6f50;
            font-weight: 600;
            margin-bottom: 8px;
        }
        .identity {
            display: flex;
            align-items: center;
            gap: 8px;
            flex-wrap: wrap;
        }
        .inline { display: inline; }
        .ui-modal {
            position: fixed;
            inset: 0;
            display: none;
            z-index: 60;
        }
        .ui-modal.is-open {
            display: block;
        }
        .ui-modal-backdrop {
            position: absolute;
            inset: 0;
            background: rgba(16, 24, 18, 0.56);
            backdrop-filter: blur(2px);
        }
        .ui-modal-panel {
            position: relative;
            width: min(680px, calc(100vw - 22px));
            max-height: calc(100vh - 26px);
            margin: 14px auto;
            background: #ffffff;
            border: 1px solid var(--line);
            border-radius: 14px;
            box-shadow: 0 22px 50px rgba(18, 35, 21, 0.28);
            overflow: hidden;
            animation: modal-in .18s ease;
        }
        .ui-modal-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 8px;
            padding: 14px 16px;
            border-bottom: 1px solid var(--line);
            background: linear-gradient(180deg, #f4f8f2, #f8fbf7);
        }
        .ui-modal-header h3 {
            margin: 0;
            font-size: 1rem;
        }
        .ui-modal-close {
            min-width: 36px;
            min-height: 36px;
            font-size: 20px;
            line-height: 1;
            border-radius: 10px;
        }
        .ui-modal-body {
            padding: 14px 16px 16px;
            overflow: auto;
            max-height: calc(100vh - 110px);
        }
        @keyframes modal-in {
            from {
                transform: translateY(6px);
                opacity: 0;
            }
            to {
                transform: translateY(0);
                opacity: 1;
            }
        }
        @media (max-width: 980px) {
            .grid.cols-4, .grid.cols-2, .form-grid {
                grid-template-columns: 1fr;
            }
            .topbar { flex-direction: column; align-items: flex-start; }
            .nav .btn {
                flex: 1 1 calc(50% - 8px);
            }
            .container {
                padding: 0 10px;
            }
            .panel {
                padding: 14px 12px;
                border-radius: 12px;
            }
            .actions .btn,
            .actions button {
                width: 100%;
            }
        }
        @media (max-width: 820px) {
            .table-wrap {
                overflow: visible;
            }
            table {
                min-width: 100%;
                border-collapse: separate;
                border-spacing: 0 10px;
            }
            thead {
                display: none;
            }
            tbody,
            tr,
            td {
                display: block;
                width: 100%;
            }
            tr {
                background: rgba(255, 255, 255, 0.92);
                border: 1px solid var(--line);
                border-radius: 12px;
                padding: 6px 8px;
                box-shadow: 0 8px 18px rgba(34, 52, 38, 0.08);
            }
            td {
                border: none;
                border-bottom: 1px dashed var(--line);
                padding: 9px 8px 9px 45%;
                position: relative;
                min-height: 34px;
            }
            td:last-child {
                border-bottom: none;
            }
            td[data-label]::before {
                content: attr(data-label);
                position: absolute;
                left: 8px;
                top: 9px;
                width: 40%;
                font-weight: 700;
                color: #415747;
                font-size: .8rem;
            }
            td[colspan] {
                padding: 10px;
            }
            td[colspan]::before {
                content: none;
            }
            td .inline,
            td form {
                width: 100%;
            }
            td form button,
            td form .btn,
            td .btn {
                width: 100%;
            }
            .topbar .identity {
                width: 100%;
                justify-content: space-between;
            }
            .nav .btn {
                flex: 1 1 100%;
            }
            .ui-modal-panel {
                width: calc(100vw - 12px);
                margin: 6px auto;
                border-radius: 10px;
            }
            .ui-modal-body {
                padding: 12px;
            }
        }
    </style>
</head>
<body>
<div class="bg-shape a"></div>
<div class="bg-shape b"></div>
<header class="topbar">
    <div>
        <h1>Inventaris Fiber Optic - PT Multitech Infomedia</h1>
        <small>Laravel App Demo</small>
    </div>
    @auth
        <div class="identity">
            <strong>{{ auth()->user()->name }}</strong>
            <small>({{ auth()->user()->role }})</small>
            <form action="{{ route('logout') }}" method="POST" class="inline" data-confirm data-confirm-title="Keluar dari sistem?" data-confirm-text="Sesi login Anda akan diakhiri." data-confirm-icon="question" data-confirm-button="Ya, logout">
                @csrf
                <x-ui.button type="submit">Logout</x-ui.button>
            </form>
        </div>
    @endauth
</header>

<div class="container">
    @auth
        <nav class="nav panel">
            @if(auth()->user()->isAdmin())
                <x-ui.button :href="route('admin.dashboard')">Dashboard</x-ui.button>
                <x-ui.button :href="route('admin.items.index')">Data Alat</x-ui.button>
                <x-ui.button :href="route('admin.technicians.index')">Data Teknisi</x-ui.button>
                <x-ui.button :href="route('admin.loans.index')">Peminjaman</x-ui.button>
                <x-ui.button :href="route('admin.maintenances.index')">Maintenance</x-ui.button>
                <x-ui.button :href="route('admin.reports.index')">Laporan</x-ui.button>
            @else
                <x-ui.button :href="route('teknisi.items.index')">Data Alat</x-ui.button>
                <x-ui.button :href="route('teknisi.loans.index')">Riwayat Peminjaman</x-ui.button>
            @endif
        </nav>
    @endauth

    @yield('content')
</div>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    (function () {
        const successMessage = @json(session('success'));
        const errorMessage = @json(session('error'));
        const validationErrors = @json($errors->all());

        const toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 2800,
            timerProgressBar: true,
        });

        if (successMessage) {
            toast.fire({
                icon: 'success',
                title: successMessage,
            });
        }

        if (errorMessage) {
            toast.fire({
                icon: 'error',
                title: errorMessage,
            });
        }

        if (!errorMessage && Array.isArray(validationErrors) && validationErrors.length > 0) {
            Swal.fire({
                icon: 'error',
                title: 'Validasi gagal',
                html: '<ul style="text-align:left;margin:0;padding-left:18px;">' +
                    validationErrors.map(function (msg) {
                        return '<li>' + msg + '</li>';
                    }).join('') +
                    '</ul>',
            });
        }

        document.querySelectorAll('form[data-confirm]').forEach(function (form) {
            form.addEventListener('submit', function (event) {
                if (form.dataset.confirmed === 'true') {
                    return;
                }

                event.preventDefault();

                Swal.fire({
                    title: form.dataset.confirmTitle || 'Yakin melanjutkan?',
                    text: form.dataset.confirmText || 'Aksi ini tidak dapat dibatalkan.',
                    icon: form.dataset.confirmIcon || 'warning',
                    showCancelButton: true,
                    confirmButtonText: form.dataset.confirmButton || 'Ya, lanjutkan',
                    cancelButtonText: 'Batal',
                    confirmButtonColor: '#2e9b6b',
                    cancelButtonColor: '#647b6a',
                }).then(function (result) {
                    if (result.isConfirmed) {
                        form.dataset.confirmed = 'true';
                        form.submit();
                    }
                });
            });
        });

        const closeModal = function (modal) {
            if (!modal) {
                return;
            }
            modal.classList.remove('is-open');
            modal.setAttribute('aria-hidden', 'true');
            document.body.style.overflow = '';
        };

        const openModal = function (modal) {
            if (!modal) {
                return;
            }
            modal.classList.add('is-open');
            modal.setAttribute('aria-hidden', 'false');
            document.body.style.overflow = 'hidden';
        };

        document.querySelectorAll('[data-modal-open]').forEach(function (trigger) {
            trigger.addEventListener('click', function () {
                const targetId = trigger.getAttribute('data-modal-open');
                const modal = document.getElementById(targetId);
                openModal(modal);
            });
        });

        document.querySelectorAll('.ui-modal [data-modal-close]').forEach(function (el) {
            el.addEventListener('click', function () {
                const modal = el.closest('.ui-modal');
                closeModal(modal);
            });
        });

        document.addEventListener('keydown', function (event) {
            if (event.key !== 'Escape') {
                return;
            }
            const opened = document.querySelector('.ui-modal.is-open');
            if (opened) {
                closeModal(opened);
            }
        });
    })();
</script>
</body>
</html>
