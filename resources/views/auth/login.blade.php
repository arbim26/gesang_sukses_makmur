<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login — InvoiceApp</title>
    <link href="https://fonts.googleapis.com/css2?family=Instrument+Serif:ital@0;1&family=DM+Sans:wght@300;400;500;600&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        :root {
            --brand:   #1a1a2e;
            --accent:  #4f46e5;
            --surface: #f8f7f4;
            --border:  #e5e3dc;
        }
        * { box-sizing: border-box; }
        body {
            font-family: 'DM Sans', sans-serif;
            background: var(--surface);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0;
        }

        /* subtle dot grid background */
        body::before {
            content: '';
            position: fixed;
            inset: 0;
            background-image: radial-gradient(circle, #1a1a2e18 1px, transparent 1px);
            background-size: 28px 28px;
            pointer-events: none;
        }

        .login-wrap {
            display: flex;
            width: 860px;
            max-width: 96vw;
            min-height: 500px;
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 24px 64px rgba(26,26,46,.13);
            position: relative;
            z-index: 1;
        }

        /* ── Left panel ── */
        .login-brand {
            width: 320px;
            flex-shrink: 0;
            background: var(--brand);
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            padding: 2.5rem 2rem;
            position: relative;
            overflow: hidden;
        }
        .login-brand::before {
            content: '';
            position: absolute;
            width: 340px; height: 340px;
            background: radial-gradient(circle, rgba(79,70,229,.35) 0%, transparent 70%);
            bottom: -80px; right: -80px;
            pointer-events: none;
        }
        .brand-logo {
            font-family: 'Instrument Serif', serif;
            font-size: 1.9rem;
            color: #fff;
            line-height: 1.1;
        }
        .brand-logo small {
            display: block;
            font-family: 'DM Sans', sans-serif;
            font-size: .68rem;
            color: rgba(255,255,255,.4);
            text-transform: uppercase;
            letter-spacing: 2px;
            margin-top: 4px;
        }
        .brand-tagline {
            color: rgba(255,255,255,.55);
            font-size: .875rem;
            line-height: 1.6;
        }
        .brand-tagline strong {
            color: #fff;
            font-weight: 500;
        }

        /* ── Right panel (form) ── */
        .login-form-panel {
            flex: 1;
            background: #fff;
            padding: 2.75rem 2.5rem;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }
        .login-heading {
            font-family: 'Instrument Serif', serif;
            font-size: 1.65rem;
            color: var(--brand);
            margin-bottom: .25rem;
        }
        .login-sub {
            font-size: .825rem;
            color: #6b7280;
            margin-bottom: 2rem;
        }

        .form-label {
            font-size: .78rem;
            font-weight: 500;
            color: var(--brand);
            margin-bottom: .3rem;
        }
        .input-group-custom {
            position: relative;
        }
        .input-icon {
            position: absolute;
            left: .85rem;
            top: 50%;
            transform: translateY(-50%);
            color: #9ca3af;
            font-size: .9rem;
            pointer-events: none;
            z-index: 2;
        }
        .form-control {
            border: 1px solid var(--border);
            border-radius: 10px;
            font-size: .875rem;
            padding: .6rem .85rem .6rem 2.4rem;
            width: 100%;
            transition: border-color .15s, box-shadow .15s;
        }
        .form-control:focus {
            border-color: var(--accent);
            box-shadow: 0 0 0 3px rgba(79,70,229,.12);
            outline: none;
        }
        .form-control.is-invalid {
            border-color: #ef4444;
        }
        .invalid-feedback { font-size: .78rem; }

        .toggle-pw {
            position: absolute;
            right: .85rem;
            top: 50%;
            transform: translateY(-50%);
            background: none;
            border: none;
            color: #9ca3af;
            cursor: pointer;
            font-size: .9rem;
            padding: 0;
            z-index: 2;
        }
        .toggle-pw:hover { color: var(--accent); }

        .form-check-label { font-size: .82rem; color: #6b7280; }

        .btn-login {
            background: var(--accent);
            color: #fff;
            border: none;
            border-radius: 10px;
            font-size: .9rem;
            font-weight: 500;
            padding: .65rem 1.5rem;
            width: 100%;
            transition: background .15s, transform .1s;
            margin-top: .5rem;
        }
        .btn-login:hover {
            background: #4338ca;
            transform: translateY(-1px);
        }
        .btn-login:active { transform: none; }

        .alert {
            border-radius: 10px;
            font-size: .825rem;
            border: none;
            padding: .65rem 1rem;
        }
        .divider {
            display: flex;
            align-items: center;
            gap: .75rem;
            margin: 1.5rem 0 1.25rem;
            color: #d1d5db;
            font-size: .75rem;
        }
        .divider::before, .divider::after {
            content: '';
            flex: 1;
            height: 1px;
            background: var(--border);
        }

        @media (max-width: 600px) {
            .login-brand { display: none; }
            .login-form-panel { padding: 2rem 1.5rem; }
        }
    </style>
</head>
<body>

<div class="login-wrap">
    {{-- Left brand panel --}}
    <div class="login-brand">
        <div class="brand-logo">
            InvoiceApp
            <small>Gesang Sukses Makmur</small>
        </div>
        <div class="brand-tagline">
            <strong>Sistem Manajemen Invoice</strong><br>
            Kelola purchase order, invoice, dan surat jalan dengan mudah dan efisien.
        </div>
    </div>

    {{-- Right form panel --}}
    <div class="login-form-panel">
        <p class="login-heading">Masuk</p>
        <p class="login-sub">Masukkan ID Pegawai dan password Anda</p>

        @if(session('success'))
            <div class="alert alert-success d-flex align-items-center gap-2 mb-3">
                <i class="bi bi-check-circle-fill"></i> {{ session('success') }}
            </div>
        @endif

        @if($errors->any())
            <div class="alert alert-danger d-flex align-items-center gap-2 mb-3">
                <i class="bi bi-exclamation-circle-fill"></i>
                {{ $errors->first() }}
            </div>
        @endif

        <form action="{{ route('login.post') }}" method="POST" autocomplete="off">
            @csrf

            <div class="mb-3">
                <label class="form-label" for="Id_Pegawai">ID Pegawai</label>
                <div class="input-group-custom">
                    <i class="bi bi-person input-icon"></i>
                    <input
                        type="text"
                        id="id_pegawai"
                        name="id_pegawai"
                        class="form-control @error('Id_Pegawai') is-invalid @enderror"
                        value="{{ old('Id_Pegawai') }}"
                        placeholder="Contoh: PGW001"
                        autofocus
                        required
                    >
                </div>
            </div>

            <div class="mb-3">
                <label class="form-label" for="password">Password</label>
                <div class="input-group-custom">
                    <i class="bi bi-lock input-icon"></i>
                    <input
                        type="password"
                        id="password"
                        name="password"
                        class="form-control"
                        placeholder="••••••••"
                        required
                    >
                    <button type="button" class="toggle-pw" onclick="togglePw()">
                        <i class="bi bi-eye" id="pw-icon"></i>
                    </button>
                </div>
            </div>

            <div class="d-flex align-items-center justify-content-between mb-1">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="remember" id="remember">
                    <label class="form-check-label" for="remember">Ingat saya</label>
                </div>
            </div>

            <button type="submit" class="btn-login">
                <i class="bi bi-box-arrow-in-right me-1"></i> Masuk
            </button>
        </form>
    </div>
</div>

<script>
function togglePw() {
    const input = document.getElementById('password');
    const icon  = document.getElementById('pw-icon');
    if (input.type === 'password') {
        input.type = 'text';
        icon.className = 'bi bi-eye-slash';
    } else {
        input.type = 'password';
        icon.className = 'bi bi-eye';
    }
}
</script>
</body>
</html>
