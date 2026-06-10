<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Admin Login - DTSEN Jawa Tengah</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    {{-- Favicon --}}
    <link rel="icon" type="image/png" href="{{ asset('assets/dinas-sosial-prov-jawa-tengah.png') }}">

    {{-- Font --}}
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    {{-- Icons --}}
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">

    <style>
        /*
        |--------------------------------------------------------------------------
        | RESET
        |--------------------------------------------------------------------------
        */

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        html,
        body {
            min-height: 100%;
        }

        body {
            font-family: 'Inter', sans-serif;
            background:
                radial-gradient(circle at top left, rgba(37, 99, 235, 0.20), transparent 32%),
                radial-gradient(circle at bottom right, rgba(14, 165, 233, 0.22), transparent 34%),
                linear-gradient(135deg, #f8fafc 0%, #eef5ff 45%, #f8fafc 100%);
            color: #0f172a;
            overflow-x: hidden;
        }

        /*
        |--------------------------------------------------------------------------
        | BACKGROUND ORNAMENT
        |--------------------------------------------------------------------------
        */

        .page-bg {
            position: fixed;
            inset: 0;
            overflow: hidden;
            pointer-events: none;
            z-index: 0;
        }

        .blob {
            position: absolute;
            border-radius: 999px;
            filter: blur(18px);
            opacity: 0.6;
            animation: floatBlob 9s ease-in-out infinite;
        }

        .blob-1 {
            width: 260px;
            height: 260px;
            background: rgba(37, 99, 235, 0.18);
            top: 10%;
            left: 12%;
        }

        .blob-2 {
            width: 320px;
            height: 320px;
            background: rgba(14, 165, 233, 0.18);
            bottom: 7%;
            right: 10%;
            animation-delay: 1.2s;
        }

        .blob-3 {
            width: 160px;
            height: 160px;
            background: rgba(59, 130, 246, 0.13);
            top: 55%;
            left: 4%;
            animation-delay: 2.1s;
        }

        @keyframes floatBlob {
            0%, 100% {
                transform: translate3d(0, 0, 0) scale(1);
            }

            50% {
                transform: translate3d(18px, -22px, 0) scale(1.06);
            }
        }

        /*
        |--------------------------------------------------------------------------
        | LAYOUT
        |--------------------------------------------------------------------------
        */

        .login-page {
            position: relative;
            z-index: 1;
            min-height: 100vh;
            display: grid;
            place-items: center;
            padding: 32px 18px;
        }

        .login-shell {
            width: min(960px, 100%);
            display: grid;
            grid-template-columns: 0.95fr 1.05fr;
            background: rgba(255, 255, 255, 0.72);
            border: 1px solid rgba(255, 255, 255, 0.82);
            border-radius: 28px;
            overflow: hidden;
            box-shadow:
                0 28px 70px rgba(15, 23, 42, 0.14),
                inset 0 1px 0 rgba(255, 255, 255, 0.72);
            backdrop-filter: blur(18px);
            animation: cardIn 0.75s cubic-bezier(.2,.8,.2,1) both;
        }

        @keyframes cardIn {
            from {
                opacity: 0;
                transform: translateY(24px) scale(0.98);
            }

            to {
                opacity: 1;
                transform: translateY(0) scale(1);
            }
        }

        /*
        |--------------------------------------------------------------------------
        | LEFT PANEL
        |--------------------------------------------------------------------------
        */

        .brand-panel {
            position: relative;
            padding: 48px;
            color: white;
            background:
                linear-gradient(145deg, rgba(21, 101, 192, 0.96), rgba(14, 116, 144, 0.92)),
                url("data:image/svg+xml,%3Csvg width='140' height='140' viewBox='0 0 140 140' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' stroke='%23ffffff' stroke-opacity='0.12'%3E%3Cpath d='M0 70h140M70 0v140'/%3E%3Ccircle cx='70' cy='70' r='42'/%3E%3C/g%3E%3C/svg%3E");
            isolation: isolate;
        }

        .brand-panel::before {
            content: "";
            position: absolute;
            width: 240px;
            height: 240px;
            border-radius: 999px;
            background: rgba(255, 255, 255, 0.14);
            right: -90px;
            top: -90px;
            z-index: -1;
        }

        .brand-panel::after {
            content: "";
            position: absolute;
            width: 160px;
            height: 160px;
            border-radius: 999px;
            background: rgba(255, 255, 255, 0.10);
            left: -50px;
            bottom: -50px;
            z-index: -1;
        }

        .brand-badge {
            width: fit-content;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 8px 12px;
            border-radius: 999px;
            background: rgba(255, 255, 255, 0.16);
            border: 1px solid rgba(255, 255, 255, 0.25);
            font-size: 12px;
            font-weight: 700;
            letter-spacing: 0.3px;
            margin-bottom: 36px;
        }

        .logo-wrap {
            width: 92px;
            height: 92px;
            display: grid;
            place-items: center;
            border-radius: 26px;
            background: rgba(255, 255, 255, 0.16);
            border: 1px solid rgba(255, 255, 255, 0.25);
            box-shadow: 0 18px 34px rgba(15, 23, 42, 0.18);
            margin-bottom: 28px;
            animation: logoFloat 4.2s ease-in-out infinite;
        }

        @keyframes logoFloat {
            0%, 100% {
                transform: translateY(0);
            }

            50% {
                transform: translateY(-8px);
            }
        }

        .logo-wrap img {
            width: 68px;
            height: 68px;
            object-fit: contain;
        }

        .brand-title {
            font-size: 34px;
            line-height: 1.12;
            font-weight: 800;
            letter-spacing: -1px;
            margin-bottom: 16px;
        }

        .brand-desc {
            max-width: 360px;
            color: rgba(255, 255, 255, 0.82);
            font-size: 14px;
            line-height: 1.75;
            margin-bottom: 34px;
        }

        .feature-list {
            display: grid;
            gap: 12px;
        }

        .feature-item {
            display: flex;
            align-items: center;
            gap: 11px;
            color: rgba(255, 255, 255, 0.92);
            font-size: 13px;
            font-weight: 600;
        }

        .feature-item i {
            width: 28px;
            height: 28px;
            display: grid;
            place-items: center;
            border-radius: 999px;
            background: rgba(255, 255, 255, 0.16);
        }

        /*
        |--------------------------------------------------------------------------
        | FORM PANEL
        |--------------------------------------------------------------------------
        */

        .form-panel {
            padding: 54px 52px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            background: rgba(255, 255, 255, 0.88);
        }

        .form-top {
            margin-bottom: 34px;
            animation: fadeUp 0.65s ease both;
            animation-delay: 0.12s;
        }

        .eyebrow {
            color: #2563eb;
            font-size: 13px;
            font-weight: 800;
            letter-spacing: 0.9px;
            text-transform: uppercase;
            margin-bottom: 10px;
        }

        .form-title {
            font-size: 32px;
            font-weight: 800;
            letter-spacing: -0.8px;
            margin-bottom: 10px;
            color: #0f172a;
        }

        .form-subtitle {
            color: #64748b;
            font-size: 14px;
            line-height: 1.6;
        }

        @keyframes fadeUp {
            from {
                opacity: 0;
                transform: translateY(12px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .alert {
            display: flex;
            align-items: flex-start;
            gap: 10px;
            background: #fef2f2;
            color: #991b1b;
            border: 1px solid #fecaca;
            padding: 12px 14px;
            border-radius: 14px;
            margin-bottom: 18px;
            font-size: 13px;
            line-height: 1.5;
            animation: shakeSoft 0.42s ease both;
        }

        @keyframes shakeSoft {
            0%, 100% { transform: translateX(0); }
            25% { transform: translateX(-4px); }
            75% { transform: translateX(4px); }
        }

        .form-group {
            position: relative;
            margin-bottom: 16px;
            animation: fadeUp 0.65s ease both;
        }

        .form-group:nth-of-type(1) {
            animation-delay: 0.18s;
        }

        .form-group:nth-of-type(2) {
            animation-delay: 0.24s;
        }

        .input-icon {
            position: absolute;
            left: 16px;
            top: 50%;
            transform: translateY(-50%);
            color: #94a3b8;
            transition: 0.22s ease;
            pointer-events: none;
        }

        .form-control {
            width: 100%;
            height: 52px;
            border: 1px solid #dbe4ef;
            border-radius: 16px;
            padding: 0 48px;
            outline: none;
            font-size: 14px;
            font-weight: 500;
            color: #0f172a;
            background: #ffffff;
            transition: 0.24s ease;
        }

        .form-control::placeholder {
            color: #94a3b8;
        }

        .form-control:focus {
            border-color: #2563eb;
            box-shadow: 0 0 0 5px rgba(37, 99, 235, 0.10);
            transform: translateY(-1px);
        }

        .form-control:focus + .input-icon {
            color: #2563eb;
        }

        .password-toggle {
            position: absolute;
            right: 14px;
            top: 50%;
            transform: translateY(-50%);
            width: 34px;
            height: 34px;
            border: none;
            border-radius: 10px;
            background: transparent;
            color: #94a3b8;
            cursor: pointer;
            transition: 0.2s ease;
        }

        .password-toggle:hover {
            background: #f1f5f9;
            color: #2563eb;
        }

        .form-meta {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin: 6px 0 22px;
            color: #64748b;
            font-size: 13px;
            animation: fadeUp 0.65s ease both;
            animation-delay: 0.30s;
        }

        .remember {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            cursor: pointer;
            user-select: none;
        }

        .remember input {
            accent-color: #2563eb;
        }

        .mini-link {
            color: #2563eb;
            text-decoration: none;
            font-weight: 700;
        }

        .mini-link:hover {
            text-decoration: underline;
        }

        .btn-row {
            display: grid;
            grid-template-columns: 1fr auto;
            gap: 12px;
            animation: fadeUp 0.65s ease both;
            animation-delay: 0.36s;
        }

        .btn-login {
            position: relative;
            height: 52px;
            border: none;
            border-radius: 16px;
            cursor: pointer;
            color: white;
            font-size: 14px;
            font-weight: 800;
            letter-spacing: 0.2px;
            background: linear-gradient(135deg, #2563eb, #0ea5e9);
            box-shadow: 0 18px 30px rgba(37, 99, 235, 0.24);
            overflow: hidden;
            transition: 0.25s ease;
        }

        .btn-login::before {
            content: "";
            position: absolute;
            inset: 0;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.35), transparent);
            transform: translateX(-120%);
            transition: 0.55s ease;
        }

        .btn-login:hover {
            transform: translateY(-2px);
            box-shadow: 0 22px 34px rgba(37, 99, 235, 0.32);
        }

        .btn-login:hover::before {
            transform: translateX(120%);
        }

        .btn-reset {
            width: 52px;
            height: 52px;
            border: 1px solid #dbe4ef;
            border-radius: 16px;
            background: white;
            color: #64748b;
            cursor: pointer;
            transition: 0.22s ease;
        }

        .btn-reset:hover {
            color: #ef4444;
            border-color: #fecaca;
            background: #fef2f2;
            transform: rotate(-8deg) scale(1.03);
        }

        .login-footer {
            margin-top: 30px;
            color: #94a3b8;
            font-size: 12px;
            text-align: center;
            animation: fadeUp 0.65s ease both;
            animation-delay: 0.42s;
        }

        /*
        |--------------------------------------------------------------------------
        | RESPONSIVE
        |--------------------------------------------------------------------------
        */

        @media (max-width: 860px) {
            .login-shell {
                grid-template-columns: 1fr;
                border-radius: 24px;
            }

            .brand-panel {
                padding: 36px 30px;
            }

            .brand-title {
                font-size: 28px;
            }

            .brand-desc,
            .feature-list {
                display: none;
            }

            .logo-wrap {
                width: 76px;
                height: 76px;
                margin-bottom: 18px;
            }

            .logo-wrap img {
                width: 56px;
                height: 56px;
            }

            .form-panel {
                padding: 36px 28px;
            }
        }

        @media (max-width: 480px) {
            .login-page {
                padding: 18px 12px;
            }

            .brand-panel {
                padding: 28px 22px;
            }

            .form-panel {
                padding: 30px 20px;
            }

            .form-title {
                font-size: 27px;
            }

            .btn-row {
                grid-template-columns: 1fr;
            }

            .btn-reset {
                width: 100%;
            }
        }
    </style>
</head>
<body>

<div class="page-bg">
    <div class="blob blob-1"></div>
    <div class="blob blob-2"></div>
    <div class="blob blob-3"></div>
</div>

<main class="login-page">
    <section class="login-shell">

        {{-- PANEL BRAND --}}
        <aside class="brand-panel">
            <div class="brand-badge">
                <i class="fa-solid fa-shield-halved"></i>
                Admin Panel
            </div>

            <div class="logo-wrap">
                <img src="{{ asset('assets/dinas-sosial-prov-jawa-tengah.png') }}" alt="Logo Jawa Tengah">
            </div>

            <h1 class="brand-title">
                DTSEN<br>
                Jawa Tengah
            </h1>

            <p class="brand-desc">
                Panel pengelolaan data wilayah, data NIK, dan kebutuhan administrasi sistem DTSEN Jawa Tengah.
            </p>

            <div class="feature-list">
                <div class="feature-item">
                    <i class="fa-solid fa-map-location-dot"></i>
                    <span>Kelola Kabupaten, Kecamatan, dan Desa</span>
                </div>

                <div class="feature-item">
                    <i class="fa-solid fa-id-card"></i>
                    <span>Manajemen Data NIK Penduduk</span>
                </div>

                <div class="feature-item">
                    <i class="fa-solid fa-chart-line"></i>
                    <span>Siap dikembangkan untuk data resmi</span>
                </div>
            </div>
        </aside>

        {{-- PANEL FORM --}}
        <section class="form-panel">
            <div class="form-top">
                <div class="eyebrow">Secure Access</div>
                <h2 class="form-title">Masuk Admin</h2>
                <p class="form-subtitle">
                    Gunakan akun admin untuk mengelola data sistem.
                </p>
            </div>

            @if(session('error'))
                <div class="alert">
                    <i class="fa-solid fa-circle-exclamation"></i>
                    <span>{{ session('error') }}</span>
                </div>
            @endif

            <form action="{{ route('admin.login.process') }}" method="POST" id="login-form">
                @csrf

                {{-- USERNAME --}}
                <div class="form-group">
                    <input type="text"
                           name="username"
                           class="form-control"
                           placeholder="Username"
                           autocomplete="off"
                           required>

                    <i class="fa-regular fa-user input-icon"></i>
                </div>

                {{-- PASSWORD --}}
                <div class="form-group">
                    <input type="password"
                           name="password"
                           class="form-control"
                           id="password"
                           placeholder="Password"
                           required>

                    <i class="fa-solid fa-lock input-icon"></i>

                    <button type="button" class="password-toggle" id="toggle-password" aria-label="Tampilkan password">
                        <i class="fa-regular fa-eye"></i>
                    </button>
                </div>

                <div class="form-meta">
                    <label class="remember">
                        <input type="checkbox" name="remember">
                        <span>Ingat sesi</span>
                    </label>

                    <a href="{{ route('beranda') }}" class="mini-link">
                        Kembali
                    </a>
                </div>

                <div class="btn-row">
                    <button type="submit" class="btn-login" id="login-button">
                        Masuk Dashboard
                    </button>

                    <button type="reset" class="btn-reset" aria-label="Reset form">
                        <i class="fa-solid fa-rotate-right"></i>
                    </button>
                </div>
            </form>

            <div class="login-footer">
                DTSEN Jawa Tengah © {{ date('Y') }} · Admin Access
            </div>
        </section>
    </section>
</main>

<script>
    /*
    |--------------------------------------------------------------------------
    | TOGGLE PASSWORD
    |--------------------------------------------------------------------------
    */

    const passwordInput = document.getElementById('password');
    const togglePassword = document.getElementById('toggle-password');

    if (togglePassword && passwordInput) {
        togglePassword.addEventListener('click', function () {
            const icon = this.querySelector('i');
            const isPassword = passwordInput.type === 'password';

            passwordInput.type = isPassword ? 'text' : 'password';

            icon.classList.toggle('fa-eye', !isPassword);
            icon.classList.toggle('fa-eye-slash', isPassword);
        });
    }

    /*
    |--------------------------------------------------------------------------
    | BUTTON LOADING ANIMATION
    |--------------------------------------------------------------------------
    */

    const loginForm = document.getElementById('login-form');
    const loginButton = document.getElementById('login-button');

    if (loginForm && loginButton) {
        loginForm.addEventListener('submit', function () {
            loginButton.disabled = true;
            loginButton.innerHTML = '<i class="fa-solid fa-circle-notch fa-spin"></i> Memproses...';
            loginButton.style.opacity = '0.85';
            loginButton.style.cursor = 'wait';
        });
    }
</script>

</body>
</html>