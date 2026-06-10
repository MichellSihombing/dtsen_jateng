<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>@yield('title', 'Admin DTSEN')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    {{--
    |--------------------------------------------------------------------------
    | FAVICON ADMIN
    |--------------------------------------------------------------------------
    | Mengatur ikon website yang tampil pada tab browser halaman admin.
    |--------------------------------------------------------------------------
    --}}
    <link rel="icon" type="image/png" href="{{ asset('assets/dinas-sosial-prov-jawa-tengah.png') }}">

    {{--
    |--------------------------------------------------------------------------
    | FONT ADMIN
    |--------------------------------------------------------------------------
    | Memuat font Inter sebagai font utama untuk seluruh tampilan admin.
    |--------------------------------------------------------------------------
    --}}
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">

    {{--
    |--------------------------------------------------------------------------
    | FONT AWESOME
    |--------------------------------------------------------------------------
    | Memuat ikon Font Awesome untuk kebutuhan icon menu dan tombol.
    |--------------------------------------------------------------------------
    --}}
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">

    <style>
        /*
        |--------------------------------------------------------------------------
        | GLOBAL VARIABLE
        |--------------------------------------------------------------------------
        | Menyimpan warna, ukuran layout, radius, dan shadow utama halaman admin.
        |--------------------------------------------------------------------------
        */

        :root {
            --bg: #f5f7fb;
            --surface: #ffffff;
            --surface-soft: #f8fafc;
            --dark: #07111f;
            --text: #0f172a;
            --muted: #64748b;
            --line: #e5eaf1;
            --primary: #2563eb;
            --primary-soft: #dbeafe;
            --cyan: #0ea5e9;
            --danger: #ef4444;
            --success: #16a34a;
            --shadow: 0 18px 45px rgba(15, 23, 42, 0.08);
            --radius: 22px;
            --sidebar-width: 286px;
            --topbar-height: 74px;
            --breadcrumb-height: 58px;
        }

        /*
        |--------------------------------------------------------------------------
        | RESET STYLE
        |--------------------------------------------------------------------------
        | Mengatur dasar elemen agar layout lebih konsisten di seluruh browser.
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

        /*
        |--------------------------------------------------------------------------
        | BODY ADMIN
        |--------------------------------------------------------------------------
        | Mengatur font, warna teks, background, dan batas scroll horizontal.
        |--------------------------------------------------------------------------
        */

        body {
            font-family: 'Inter', sans-serif;
            background:
                radial-gradient(circle at top left, rgba(37, 99, 235, 0.08), transparent 30%),
                radial-gradient(circle at bottom right, rgba(14, 165, 233, 0.10), transparent 32%),
                var(--bg);
            color: var(--text);
            overflow-x: hidden;
        }

        a {
            color: inherit;
        }

        /*
        |--------------------------------------------------------------------------
        | ADMIN TOPBAR
        |--------------------------------------------------------------------------
        | Mengatur navbar atas admin yang berisi brand, pencarian, user, dan logout.
        |--------------------------------------------------------------------------
        */

        .admin-topbar {
            height: var(--topbar-height);
            background: rgba(7, 17, 31, 0.96);
            color: #ffffff;
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 26px;
            position: sticky;
            top: 0;
            z-index: 50;
            backdrop-filter: blur(16px);
            box-shadow: 0 12px 30px rgba(15, 23, 42, 0.18);
        }

        /*
        |--------------------------------------------------------------------------
        | BRAND ADMIN
        |--------------------------------------------------------------------------
        | Mengatur logo dan teks identitas aplikasi pada topbar admin.
        |--------------------------------------------------------------------------
        */

        .brand {
            display: flex;
            align-items: center;
            gap: 13px;
            min-width: 250px;
            text-decoration: none;
        }

        .brand-logo-wrap {
            width: 42px;
            height: 42px;
            display: grid;
            place-items: center;
            border-radius: 14px;
            background: rgba(255, 255, 255, 0.10);
            border: 1px solid rgba(255, 255, 255, 0.14);
        }

        .brand img {
            width: 31px;
            height: 31px;
            object-fit: contain;
        }

        .brand-title {
            font-size: 21px;
            font-weight: 900;
            letter-spacing: 3px;
            line-height: 1;
        }

        .brand-subtitle {
            font-size: 11px;
            color: #94a3b8;
            font-weight: 600;
            margin-top: 5px;
            letter-spacing: 0.4px;
        }

        /*
        |--------------------------------------------------------------------------
        | TOPBAR SEARCH
        |--------------------------------------------------------------------------
        | Mengatur kotak pencarian pada bagian tengah topbar admin.
        |--------------------------------------------------------------------------
        */

        .topbar-center {
            flex: 1;
            display: flex;
            justify-content: center;
        }

        .search-box {
            width: min(480px, 100%);
            height: 44px;
            background: rgba(255, 255, 255, 0.08);
            border: 1px solid rgba(255, 255, 255, 0.10);
            color: #cbd5e1;
            border-radius: 16px;
            display: flex;
            align-items: center;
            gap: 11px;
            padding: 0 16px;
            transition: 0.25s ease;
        }

        .search-box:hover {
            background: rgba(255, 255, 255, 0.12);
            transform: translateY(-1px);
        }

        .search-box i {
            color: #93c5fd;
        }

        .search-box input {
            width: 100%;
            border: none;
            outline: none;
            background: transparent;
            color: #ffffff;
            font-size: 14px;
        }

        .search-box input::placeholder {
            color: #94a3b8;
        }

        /*
        |--------------------------------------------------------------------------
        | ADMIN USER AREA
        |--------------------------------------------------------------------------
        | Mengatur informasi user aktif dan tombol logout pada sisi kanan topbar.
        |--------------------------------------------------------------------------
        */

        .admin-user {
            display: flex;
            align-items: center;
            justify-content: flex-end;
            gap: 12px;
            min-width: 250px;
        }

        .user-pill {
            display: flex;
            align-items: center;
            gap: 10px;
            color: #e2e8f0;
            font-size: 14px;
            font-weight: 700;
        }

        .user-avatar {
            width: 36px;
            height: 36px;
            display: grid;
            place-items: center;
            border-radius: 13px;
            background: linear-gradient(135deg, var(--primary), var(--cyan));
            color: white;
            box-shadow: 0 10px 22px rgba(37, 99, 235, 0.26);
        }

        .logout-btn {
            border: none;
            background: rgba(239, 68, 68, 0.14);
            color: #fecaca;
            padding: 10px 14px;
            border-radius: 14px;
            cursor: pointer;
            font-weight: 800;
            transition: 0.25s ease;
        }

        .logout-btn:hover {
            background: var(--danger);
            color: white;
            transform: translateY(-1px);
            box-shadow: 0 14px 24px rgba(239, 68, 68, 0.25);
        }

        /*
        |--------------------------------------------------------------------------
        | BREADCRUMB
        |--------------------------------------------------------------------------
        | Mengatur navigasi kecil di bawah topbar sebagai penanda posisi halaman.
        |--------------------------------------------------------------------------
        */

        .breadcrumb {
            height: var(--breadcrumb-height);
            background: rgba(255, 255, 255, 0.78);
            display: flex;
            align-items: center;
            gap: 11px;
            padding: 0 30px;
            border-bottom: 1px solid var(--line);
            color: var(--muted);
            backdrop-filter: blur(12px);
        }

        .breadcrumb i {
            color: var(--primary);
        }

        .breadcrumb strong {
            color: var(--text);
            font-weight: 800;
        }

        /*
        |--------------------------------------------------------------------------
        | ADMIN BODY LAYOUT
        |--------------------------------------------------------------------------
        | Mengatur layout utama yang terdiri dari sidebar dan area konten.
        |--------------------------------------------------------------------------
        */

        .admin-body {
            display: grid;
            grid-template-columns: var(--sidebar-width) minmax(0, 1fr);
            min-height: calc(100vh - var(--topbar-height) - var(--breadcrumb-height));
        }

        /*
        |--------------------------------------------------------------------------
        | SIDEBAR NAVIGATION
        |--------------------------------------------------------------------------
        | Mengatur panel menu samping agar tetap terlihat saat halaman discroll.
        |--------------------------------------------------------------------------
        */

        .sidebar {
            position: sticky;
            top: calc(var(--topbar-height) + var(--breadcrumb-height));
            height: calc(100vh - var(--topbar-height) - var(--breadcrumb-height));
            padding: 22px 16px;
            background: rgba(255, 255, 255, 0.72);
            border-right: 1px solid var(--line);
            backdrop-filter: blur(18px);
            overflow-y: auto;
        }

        .sidebar::-webkit-scrollbar {
            width: 6px;
        }

        .sidebar::-webkit-scrollbar-thumb {
            background: #cbd5e1;
            border-radius: 999px;
        }

        /*
        |--------------------------------------------------------------------------
        | SIDEBAR INFO CARD
        |--------------------------------------------------------------------------
        | Mengatur kartu informasi mode admin pada bagian atas sidebar.
        |--------------------------------------------------------------------------
        */

        .sidebar-card {
            background: linear-gradient(135deg, rgba(37, 99, 235, 0.12), rgba(14, 165, 233, 0.10));
            border: 1px solid rgba(37, 99, 235, 0.14);
            border-radius: 22px;
            padding: 16px;
            margin-bottom: 16px;
            animation: fadeUp 0.55s ease both;
        }

        .sidebar-card-title {
            font-size: 13px;
            font-weight: 900;
            color: #1e3a8a;
            margin-bottom: 6px;
        }

        .sidebar-card-desc {
            font-size: 12px;
            color: #475569;
            line-height: 1.55;
        }

        /*
        |--------------------------------------------------------------------------
        | SIDEBAR LABEL
        |--------------------------------------------------------------------------
        | Mengatur label pemisah menu pada sidebar.
        |--------------------------------------------------------------------------
        */

        .sidebar-label {
            font-size: 11px;
            font-weight: 900;
            color: #94a3b8;
            text-transform: uppercase;
            letter-spacing: 1px;
            margin: 18px 12px 9px;
        }

        /*
        |--------------------------------------------------------------------------
        | MENU ITEM
        |--------------------------------------------------------------------------
        | Mengatur tampilan link menu pada sidebar beserta hover dan active state.
        |--------------------------------------------------------------------------
        */

        .menu-item {
            position: relative;
            display: flex;
            align-items: center;
            gap: 13px;
            padding: 13px 14px;
            color: #334155;
            text-decoration: none;
            border-radius: 17px;
            margin-bottom: 7px;
            font-size: 14px;
            font-weight: 800;
            letter-spacing: 0.1px;
            transition: 0.24s cubic-bezier(.2,.8,.2,1);
            overflow: hidden;
            animation: fadeUp 0.55s ease both;
        }

        .menu-item::before {
            content: "";
            position: absolute;
            inset: 0;
            background: linear-gradient(135deg, rgba(37, 99, 235, 0.10), rgba(14, 165, 233, 0.08));
            opacity: 0;
            transition: 0.24s ease;
        }

        .menu-icon {
            position: relative;
            width: 38px;
            height: 38px;
            display: grid;
            place-items: center;
            border-radius: 14px;
            background: #eef5ff;
            color: var(--primary);
            transition: 0.24s ease;
            flex-shrink: 0;
        }

        .menu-item span {
            position: relative;
        }

        .menu-item:hover {
            transform: translateX(4px);
            color: #0f172a;
        }

        .menu-item:hover::before {
            opacity: 1;
        }

        .menu-item:hover .menu-icon {
            background: var(--primary);
            color: white;
            transform: rotate(-4deg) scale(1.04);
            box-shadow: 0 12px 22px rgba(37, 99, 235, 0.24);
        }

        .menu-item.active {
            color: #0f172a;
            background: #ffffff;
            box-shadow: 0 14px 30px rgba(15, 23, 42, 0.08);
        }

        .menu-item.active::after {
            content: "";
            position: absolute;
            right: 10px;
            width: 7px;
            height: 7px;
            border-radius: 999px;
            background: var(--primary);
            box-shadow: 0 0 0 5px rgba(37, 99, 235, 0.12);
        }

        .menu-item.active .menu-icon {
            background: linear-gradient(135deg, var(--primary), var(--cyan));
            color: white;
            box-shadow: 0 12px 22px rgba(37, 99, 235, 0.24);
        }

        /*
        |--------------------------------------------------------------------------
        | CONTENT AREA
        |--------------------------------------------------------------------------
        | Mengatur area utama tempat halaman admin ditampilkan.
        |--------------------------------------------------------------------------
        */

        .content {
            padding: 22px 20px;
            animation: pageIn 0.55s ease both;
            min-width: 0;
            overflow-x: auto;
        }

        /*
        |--------------------------------------------------------------------------
        | ALERT MESSAGE
        |--------------------------------------------------------------------------
        | Mengatur tampilan pesan sukses dan error dari session atau validasi.
        |--------------------------------------------------------------------------
        */

        .alert-success,
        .alert-success-admin {
            background: #dcfce7;
            color: #166534;
            padding: 12px 14px;
            border-radius: 14px;
            margin-bottom: 14px;
            font-weight: 700;
        }

        .alert-error,
        .alert-error-admin {
            background: #fee2e2;
            color: #991b1b;
            padding: 12px 14px;
            border-radius: 14px;
            margin-bottom: 14px;
            font-weight: 700;
        }

        /*
        |--------------------------------------------------------------------------
        | ADMIN PAGE HEADER CARD
        |--------------------------------------------------------------------------
        | Mengatur kartu hero yang dapat digunakan pada halaman admin tertentu.
        |--------------------------------------------------------------------------
        */

        .admin-page-card {
            background: linear-gradient(135deg, #2563eb, #0ea5e9);
            border-radius: 28px;
            padding: 30px;
            color: white;
            margin-bottom: 24px;
            box-shadow: 0 24px 50px rgba(37, 99, 235, 0.20);
        }

        .admin-page-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 20px;
        }

        .admin-page-header h1 {
            font-size: 28px;
            font-weight: 900;
            margin: 0 0 6px;
        }

        .admin-page-header p {
            margin: 0;
            color: rgba(255,255,255,0.85);
        }

        .admin-page-badge {
            background: rgba(255,255,255,0.18);
            border: 1px solid rgba(255,255,255,0.28);
            padding: 10px 16px;
            border-radius: 999px;
            font-size: 12px;
            font-weight: 900;
            white-space: nowrap;
        }

        /*
        |--------------------------------------------------------------------------
        | ADMIN CARD
        |--------------------------------------------------------------------------
        | Mengatur container umum untuk form, tabel, dan section halaman admin.
        |--------------------------------------------------------------------------
        */

        .admin-card {
            background: white;
            border: 1px solid #e5eaf1;
            border-radius: 24px;
            padding: 24px;
            margin-bottom: 24px;
            box-shadow: 0 18px 45px rgba(15,23,42,0.07);
        }

        .admin-card h2 {
            font-size: 22px;
            font-weight: 900;
            margin-bottom: 6px;
            color: #0f172a;
        }

        .admin-card p {
            color: #64748b;
            font-size: 13px;
        }

        /*
        |--------------------------------------------------------------------------
        | ADMIN FORM
        |--------------------------------------------------------------------------
        | Mengatur layout form admin, input, select, dan tombol submit.
        |--------------------------------------------------------------------------
        */

        .admin-form-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr) auto;
            gap: 14px;
            align-items: end;
        }

        .admin-form-grid label {
            display: block;
            font-size: 12px;
            font-weight: 800;
            color: #475569;
            margin-bottom: 7px;
        }

        .admin-form-grid input,
        .admin-form-grid select,
        .admin-search-row input,
        .admin-table input,
        .admin-table select {
            width: 100%;
            height: 44px;
            border: 1px solid #dbe4ef;
            border-radius: 14px;
            padding: 0 13px;
            outline: none;
            font-size: 13px;
            background: white;
        }

        .admin-form-grid input:focus,
        .admin-form-grid select:focus,
        .admin-search-row input:focus,
        .admin-table input:focus,
        .admin-table select:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 4px rgba(37,99,235,0.09);
        }

        .admin-form-grid button,
        .admin-search-row button,
        .admin-search-row a,
        .admin-table button {
            height: 44px;
            border: none;
            border-radius: 14px;
            padding: 0 16px;
            font-size: 13px;
            font-weight: 900;
            cursor: pointer;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            justify-content: center;
        }

        .admin-form-grid button,
        .admin-search-row button {
            background: linear-gradient(135deg, var(--primary), var(--cyan));
            color: white;
        }

        /*
        |--------------------------------------------------------------------------
        | ADMIN SEARCH ROW
        |--------------------------------------------------------------------------
        | Mengatur baris pencarian dan tombol reset pada halaman admin.
        |--------------------------------------------------------------------------
        */

        .admin-search-row a {
            background: #eef2f7;
            color: #334155;
        }

        .admin-search-row {
            display: grid;
            grid-template-columns: 1fr auto auto;
            gap: 10px;
            margin-bottom: 18px;
        }

        /*
        |--------------------------------------------------------------------------
        | ADMIN TABLE
        |--------------------------------------------------------------------------
        | Mengatur tabel standar admin beserta wrapper scroll horizontal.
        |--------------------------------------------------------------------------
        */

        .admin-table-wrap {
            overflow-x: auto;
            border: 1px solid #e5eaf1;
            border-radius: 20px;
        }

        .admin-table {
            width: 100%;
            min-width: 900px;
            border-collapse: collapse;
        }

        .admin-table th {
            background: #f8fafc;
            padding: 14px;
            text-align: left;
            font-size: 12px;
            font-weight: 900;
            color: #475569;
            text-transform: uppercase;
            border-bottom: 1px solid #e5eaf1;
        }

        .admin-table td {
            padding: 13px 14px;
            border-bottom: 1px solid #eef2f7;
            vertical-align: middle;
        }

        .admin-table tr:hover {
            background: #f8fafc;
        }

        /*
        |--------------------------------------------------------------------------
        | TABLE ACTION BUTTON
        |--------------------------------------------------------------------------
        | Mengatur tombol aksi simpan dan hapus pada tabel admin.
        |--------------------------------------------------------------------------
        */

        .action-wrap {
            display: flex;
            gap: 8px;
            align-items: center;
        }

        .action-btn {
            width: 44px;
            height: 44px;
            border-radius: 14px;
            border: none;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: 0.22s ease;
        }

        .action-btn:hover {
            transform: translateY(-2px);
        }

        .action-save {
            background: var(--primary);
            color: white;
        }

        .action-delete {
            background: #fee2e2;
            color: #991b1b;
        }

        .action-delete:hover {
            background: #dc2626;
            color: white;
        }

        /*
        |--------------------------------------------------------------------------
        | ADMIN FOOTER
        |--------------------------------------------------------------------------
        | Mengatur footer pada halaman admin yang berisi identitas sistem.
        |--------------------------------------------------------------------------
        */

        .admin-footer {
            position: relative;
            overflow: hidden;
            margin-top: 28px;
            padding: 18px 20px;
            border-radius: 24px;
            background:
                radial-gradient(circle at top right, rgba(14, 165, 233, 0.18), transparent 28%),
                linear-gradient(135deg, rgba(255,255,255,0.92), rgba(248,250,252,0.86));
            border: 1px solid rgba(226, 232, 240, 0.9);
            box-shadow: 0 18px 45px rgba(15, 23, 42, 0.07);
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 16px;
            animation: footerIn 0.55s ease both;
        }

        .admin-footer::before {
            content: "";
            position: absolute;
            width: 160px;
            height: 160px;
            right: -70px;
            bottom: -90px;
            border-radius: 999px;
            background: rgba(37, 99, 235, 0.10);
        }

        .footer-left {
            position: relative;
            z-index: 1;
            display: flex;
            align-items: center;
            gap: 13px;
        }

        .footer-logo {
            width: 44px;
            height: 44px;
            border-radius: 16px;
            display: grid;
            place-items: center;
            background: linear-gradient(135deg, var(--primary), var(--cyan));
            box-shadow: 0 12px 24px rgba(37, 99, 235, 0.22);
            flex-shrink: 0;
        }

        .footer-logo img {
            width: 30px;
            height: 30px;
            object-fit: contain;
        }

        .footer-title {
            font-size: 14px;
            font-weight: 900;
            color: #0f172a;
            margin-bottom: 3px;
        }

        .footer-subtitle {
            font-size: 12px;
            font-weight: 700;
            color: #64748b;
        }

        .footer-right {
            position: relative;
            z-index: 1;
            display: flex;
            align-items: center;
            gap: 8px;
            flex-wrap: wrap;
        }

        .footer-pill {
            display: inline-flex;
            align-items: center;
            gap: 7px;
            padding: 9px 12px;
            border-radius: 999px;
            background: #eef5ff;
            color: var(--primary);
            font-size: 12px;
            font-weight: 900;
            border: 1px solid rgba(37, 99, 235, 0.12);
        }

        /*
        |--------------------------------------------------------------------------
        | ANIMATION
        |--------------------------------------------------------------------------
        | Menyediakan animasi masuk untuk halaman, menu, card, dan footer admin.
        |--------------------------------------------------------------------------
        */

        @keyframes pageIn {
            from {
                opacity: 0;
                transform: translateY(12px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes fadeUp {
            from {
                opacity: 0;
                transform: translateY(10px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes footerIn {
            from {
                opacity: 0;
                transform: translateY(12px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /*
        |--------------------------------------------------------------------------
        | RESPONSIVE DESKTOP KECIL
        |--------------------------------------------------------------------------
        | Menyesuaikan sidebar dan form pada layar desktop berukuran sedang.
        |--------------------------------------------------------------------------
        */

        @media (max-width: 1100px) {
            :root {
                --sidebar-width: 92px;
            }

            .brand-text,
            .sidebar-card,
            .sidebar-label,
            .menu-item span {
                display: none;
            }

            .brand {
                min-width: auto;
            }

            .admin-user {
                min-width: auto;
            }

            .menu-item {
                justify-content: center;
                padding: 12px;
            }

            .menu-item:hover {
                transform: translateY(-2px);
            }

            .menu-item.active::after {
                right: 8px;
            }

            .admin-form-grid {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        /*
        |--------------------------------------------------------------------------
        | RESPONSIVE TABLET
        |--------------------------------------------------------------------------
        | Mengubah sidebar menjadi menu horizontal dan menyederhanakan layout.
        |--------------------------------------------------------------------------
        */

        @media (max-width: 820px) {
            .admin-body {
                grid-template-columns: 1fr;
            }

            .sidebar {
                position: static;
                height: auto;
                display: flex;
                overflow-x: auto;
                gap: 8px;
                padding: 12px;
            }

            .menu-item {
                min-width: 64px;
                margin-bottom: 0;
            }

            .topbar-center {
                display: none;
            }

            .content {
                padding: 18px;
            }

            .admin-form-grid,
            .admin-search-row {
                grid-template-columns: 1fr;
            }

            .admin-page-header,
            .admin-footer {
                flex-direction: column;
                align-items: flex-start;
            }
        }

        /*
        |--------------------------------------------------------------------------
        | RESPONSIVE MOBILE
        |--------------------------------------------------------------------------
        | Menyesuaikan topbar dan area user agar tetap rapi di layar kecil.
        |--------------------------------------------------------------------------
        */

        @media (max-width: 520px) {
            .admin-topbar {
                padding: 0 14px;
            }

            .logout-btn {
                padding: 9px 10px;
            }

            .user-pill span {
                display: none;
            }
        }
    </style>

    @stack('styles')
</head>
<body>

{{--
|--------------------------------------------------------------------------
| TOPBAR ADMIN
|--------------------------------------------------------------------------
| Menampilkan logo aplikasi, pencarian cepat, informasi user, dan logout.
|--------------------------------------------------------------------------
--}}
<header class="admin-topbar">
    <a href="{{ route('admin.dashboard') }}" class="brand">
        <div class="brand-logo-wrap">
            <img src="{{ asset('assets/dinas-sosial-prov-jawa-tengah.png') }}" alt="Logo">
        </div>

        <div class="brand-text">
            <div class="brand-title">DTSEN ADMIN</div>
            <div class="brand-subtitle">Management Console</div>
        </div>
    </a>

    <div class="topbar-center">
        <div class="search-box">
            <i class="fa fa-search"></i>
            <input type="text" placeholder="Search menu, data, wilayah...">
        </div>
    </div>

    <div class="admin-user">
        <div class="user-pill">
            <div class="user-avatar">
                <i class="fa fa-user"></i>
            </div>
            <span>{{ session('admin_username', 'Admin') }}</span>
        </div>

        <form action="{{ route('admin.logout') }}" method="POST">
            @csrf
            <button class="logout-btn">Logout</button>
        </form>
    </div>
</header>

{{--
|--------------------------------------------------------------------------
| BREADCRUMB ADMIN
|--------------------------------------------------------------------------
| Menampilkan posisi halaman saat ini berdasarkan section breadcrumb.
|--------------------------------------------------------------------------
--}}
<div class="breadcrumb">
    <i class="fa fa-bars"></i>
    <span>Dashboard</span>
    <span>/</span>
    <strong>@yield('breadcrumb', 'Home')</strong>
</div>

{{--
|--------------------------------------------------------------------------
| ADMIN LAYOUT WRAPPER
|--------------------------------------------------------------------------
| Membungkus sidebar dan konten utama halaman admin.
|--------------------------------------------------------------------------
--}}
<div class="admin-body">

    {{--
    |--------------------------------------------------------------------------
    | SIDEBAR ADMIN
    |--------------------------------------------------------------------------
    | Menampilkan menu navigasi utama untuk mengelola data sistem.
    |--------------------------------------------------------------------------
    --}}
    <aside class="sidebar">
        <div class="sidebar-card">
            <div class="sidebar-card-title">Admin Mode</div>
            <div class="sidebar-card-desc">
                Kelola data wilayah, NIK, data master, dan kebutuhan sistem DTSEN Jawa Tengah.
            </div>
        </div>

        {{--
        |--------------------------------------------------------------------------
        | MENU UTAMA
        |--------------------------------------------------------------------------
        | Berisi navigasi utama seperti dashboard, wilayah, dan data NIK.
        |--------------------------------------------------------------------------
        --}}
        <div class="sidebar-label">Main Menu</div>

        <a href="{{ route('admin.dashboard') }}"
           class="menu-item {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
            <div class="menu-icon">
                <i class="fa fa-house"></i>
            </div>
            <span>Dashboard</span>
        </a>

        <a href="{{ route('admin.wilayah.index') }}"
           class="menu-item {{ request()->routeIs('admin.wilayah.*') ? 'active' : '' }}">
            <div class="menu-icon">
                <i class="fa fa-map-location-dot"></i>
            </div>
            <span>Data Wilayah</span>
        </a>

        <a href="{{ route('admin.nik.index') }}"
           class="menu-item {{ request()->routeIs('admin.nik.*') ? 'active' : '' }}">
            <div class="menu-icon">
                <i class="fa fa-id-card"></i>
            </div>
            <span>Data NIK</span>
        </a>

        {{--
        |--------------------------------------------------------------------------
        | MENU DATA MASTER
        |--------------------------------------------------------------------------
        | Berisi navigasi untuk mengelola data publik dan data rekap sosial.
        |--------------------------------------------------------------------------
        --}}
        <div class="sidebar-label">Data Master</div>

        <a href="{{ route('admin.data.index', 'panti') }}"
           class="menu-item {{ request()->is('admin/data/panti*') ? 'active' : '' }}">
            <div class="menu-icon">
                <i class="fa fa-building-user"></i>
            </div>
            <span>Daya Tampung Panti</span>
        </a>

        <a href="{{ route('admin.data.index', 'dt-jateng') }}"
           class="menu-item {{ request()->is('admin/data/dt-jateng*') ? 'active' : '' }}">
            <div class="menu-icon">
                <i class="fa fa-database"></i>
            </div>
            <span>DT Jateng</span>
        </a>

        <a href="{{ route('admin.data.index', 'ppks') }}"
           class="menu-item {{ request()->is('admin/data/ppks*') || request()->is('admin/data/pks*') ? 'active' : '' }}">
            <div class="menu-icon">
                <i class="fa fa-people-group"></i>
            </div>
            <span>PPKS</span>
        </a>

        <a href="{{ route('admin.data.index', 'psks') }}"
           class="menu-item {{ request()->is('admin/data/psks*') ? 'active' : '' }}">
            <div class="menu-icon">
                <i class="fa fa-hand-holding-heart"></i>
            </div>
            <span>PSKS</span>
        </a>

        {{--
        |--------------------------------------------------------------------------
        | MENU SHORTCUT
        |--------------------------------------------------------------------------
        | Berisi tautan cepat menuju halaman publik yang sering dicek admin.
        |--------------------------------------------------------------------------
        --}}
        <div class="sidebar-label">Shortcut</div>

        <a href="{{ route('peta') }}" target="_blank" class="menu-item">
            <div class="menu-icon">
                <i class="fa fa-location-dot"></i>
            </div>
            <span>Lihat Peta</span>
        </a>

        <a href="{{ route('beranda') }}" target="_blank" class="menu-item">
            <div class="menu-icon">
                <i class="fa fa-globe"></i>
            </div>
            <span>Beranda Publik</span>
        </a>
    </aside>

    {{--
    |--------------------------------------------------------------------------
    | KONTEN ADMIN
    |--------------------------------------------------------------------------
    | Menampilkan pesan sistem, validasi, konten halaman, dan footer admin.
    |--------------------------------------------------------------------------
    --}}
    <main class="content">

        {{--
        |--------------------------------------------------------------------------
        | ALERT SUCCESS
        |--------------------------------------------------------------------------
        | Menampilkan pesan sukses dari session setelah aksi berhasil.
        |--------------------------------------------------------------------------
        --}}
        @if(session('success'))
            <div class="alert-success">{{ session('success') }}</div>
        @endif

        {{--
        |--------------------------------------------------------------------------
        | ALERT ERROR
        |--------------------------------------------------------------------------
        | Menampilkan pesan error dari session ketika proses gagal.
        |--------------------------------------------------------------------------
        --}}
        @if(session('error'))
            <div class="alert-error">{{ session('error') }}</div>
        @endif

        {{--
        |--------------------------------------------------------------------------
        | VALIDATION ERROR
        |--------------------------------------------------------------------------
        | Menampilkan daftar error validasi dari Laravel.
        |--------------------------------------------------------------------------
        --}}
        @if($errors->any())
            <div class="alert-error">
                @foreach($errors->all() as $error)
                    <div>{{ $error }}</div>
                @endforeach
            </div>
        @endif

        {{--
        |--------------------------------------------------------------------------
        | PAGE CONTENT
        |--------------------------------------------------------------------------
        | Area utama untuk menampilkan konten dari setiap halaman admin.
        |--------------------------------------------------------------------------
        --}}
        @yield('content')

        {{--
        |--------------------------------------------------------------------------
        | FOOTER ADMIN
        |--------------------------------------------------------------------------
        | Menampilkan informasi sistem, framework, dan identitas halaman admin.
        |--------------------------------------------------------------------------
        --}}
        <footer class="admin-footer">
            <div class="footer-left">
                <div class="footer-logo">
                    <img src="{{ asset('assets/dinas-sosial-prov-jawa-tengah.png') }}" alt="Logo">
                </div>

                <div>
                    <div class="footer-title">DTSEN Admin Page</div>
                    <div class="footer-subtitle">© 2026 Admin page untuk DTSEN Jawa Tengah.</div>
                </div>
            </div>

            <div class="footer-right">
                <span class="footer-pill">
                    <i class="fa fa-code"></i>
                    Laravel 12
                </span>

                <span class="footer-pill">
                    <i class="fa fa-heart"></i>
                    Built with effort
                </span>
            </div>
        </footer>
    </main>
</div>

{{--
|--------------------------------------------------------------------------
| STACK SCRIPT
|--------------------------------------------------------------------------
| Menyediakan tempat untuk script tambahan dari setiap halaman admin.
|--------------------------------------------------------------------------
--}}
@stack('scripts')
</body>
</html>