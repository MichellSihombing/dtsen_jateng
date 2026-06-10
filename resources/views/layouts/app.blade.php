{{-- LAYOUT UTAMA --}}
{{-- STRUKTUR HTML --}}
<!DOCTYPE html>
<html lang="id">
{{-- BAGIAN HEAD --}}
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'DTSEN Jawa Tengah')</title>

    {{--
    |--------------------------------------------------------------------------
    | FAVICON WEBSITE
    |--------------------------------------------------------------------------
    | Mengatur ikon utama yang tampil pada tab browser dan perangkat mobile.
    |--------------------------------------------------------------------------
    --}}
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('assets/dinas-sosial-prov-jawa-tengah.png') }}">
    <link rel="icon" type="image/png" sizes="48x48" href="{{ asset('assets/dinas-sosial-prov-jawa-tengah.png') }}">
    <link rel="icon" type="image/png" sizes="96x96" href="{{ asset('assets/dinas-sosial-prov-jawa-tengah.png') }}">
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('assets/dinas-sosial-prov-jawa-tengah.png') }}">
    <link rel="shortcut icon" type="image/png" href="{{ asset('assets/dinas-sosial-prov-jawa-tengah.png') }}">

    {{--
    |--------------------------------------------------------------------------
    | LIBRARY CSS
    |--------------------------------------------------------------------------
    | Memuat Bootstrap dan Font Awesome sebagai kebutuhan tampilan antarmuka.
    |--------------------------------------------------------------------------
    --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">

    {{--
    |--------------------------------------------------------------------------
    | FONT WEBSITE
    |--------------------------------------------------------------------------
    | Menggunakan font utama untuk menjaga tampilan website tetap modern.
    |--------------------------------------------------------------------------
    --}}
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    {{-- STYLE CSS --}}
<style>
        /*
        |--------------------------------------------------------------------------
        | GLOBAL VARIABLE
        |--------------------------------------------------------------------------
        | Menyimpan warna dan nilai utama agar styling mudah dikelola.
        |--------------------------------------------------------------------------
        */

        :root {
            --primary: #1565C0;
            --primary-dark: #0D47A1;
            --accent-light: #E3F2FD;
            --nav-bg: #1565C0;
            --border: #DEE2E6;
            --text-dark: #212529;
            --text-muted: #6C757D;
            --white: #ffffff;
        }

        /*
        |--------------------------------------------------------------------------
        | RESET STYLE
        |--------------------------------------------------------------------------
        | Mengatur dasar elemen agar tampilan lebih konsisten di semua browser.
        |--------------------------------------------------------------------------
        */

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        /*
        |--------------------------------------------------------------------------
        | BODY
        |--------------------------------------------------------------------------
        | Mengatur font, warna, dan latar utama halaman publik.
        |--------------------------------------------------------------------------
        */

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background: var(--white);
            color: var(--text-dark);
            font-size: 14px;
        }

        /*
        |--------------------------------------------------------------------------
        | NAVBAR
        |--------------------------------------------------------------------------
        | Mengatur tampilan navigasi utama pada bagian atas website.
        |--------------------------------------------------------------------------
        */

        .navbar-dtsen {
            background: #1565C0;
            width: 100%;
            position: sticky;
            top: 0;
            z-index: 1000;
            box-shadow: 0 2px 8px rgba(0,0,0,0.10);
        }

        .navbar-dtsen .nav-inner {
            display: flex;
            align-items: center;
            justify-content: space-between;
            height: 66px;
            padding: 0 24px;
        }

        .navbar-dtsen .navbar-brand {
            display: flex;
            align-items: center;
            gap: 10px;
            text-decoration: none;
            flex-shrink: 0;
        }

        .navbar-dtsen .brand-logo {
            width: 66px;
            height: 66px;
            object-fit: contain;
        }

        .navbar-dtsen .brand-text {
            color: #fff;
            font-weight: 800;
            font-size: 18px;
            letter-spacing: 0.4px;
            white-space: nowrap;
        }

        .navbar-dtsen .navbar-nav {
            display: flex;
            flex-direction: row;
            align-items: center;
            gap: 0;
            list-style: none;
            margin: 0;
            padding: 0;
            height: 58px;
        }

        .navbar-dtsen .nav-item {
            position: relative;
        }

        .navbar-dtsen .nav-link {
            color: rgba(255,255,255,0.88) !important;
            font-weight: 600;
            font-size: 14px;
            padding: 0 16px !important;
            height: 36px;
            display: flex;
            align-items: center;
            border-bottom: 2px solid transparent;
            text-decoration: none;
            transition: 0.2s ease;
            white-space: nowrap;
            background: transparent;
            border-left: none;
            border-right: none;
            border-top: none;
            cursor: pointer;
            font-family: inherit;
        }

        .navbar-dtsen .nav-link:hover {
            color: #fff !important;
            transform: translateY(-1px);
        }

        .navbar-dtsen .nav-link.active {
            color: #fff !important;
            border-bottom: 2px solid #fff;
            font-weight: 700;
        }

        /*
        |--------------------------------------------------------------------------
        | CUSTOM DROPDOWN RILIS DATA
        |--------------------------------------------------------------------------
        | Mengatur dropdown menu Rilis Data agar tampil interaktif dan rapi.
        |--------------------------------------------------------------------------
        */

        .nav-dropdown {
            position: relative;
        }

        .nav-dropdown-toggle {
            display: flex;
            align-items: center;
            gap: 5px;
            outline: none;
        }

        .nav-dropdown-toggle:focus {
            outline: none;
        }

        .dropdown-icon {
            font-size: 10px;
            margin-top: 2px;
            transition: transform 0.28s cubic-bezier(.2,.8,.2,1);
        }

        .nav-dropdown.active .dropdown-icon {
            transform: rotate(180deg);
        }

        .nav-dropdown-menu {
            position: absolute;
            top: calc(100% + 12px);
            right: 0;
            min-width: 190px;
            padding: 8px;
            border-radius: 12px;
            background: #ffffff;
            border: 1px solid rgba(226, 232, 240, 0.95);
            box-shadow: 0 16px 40px rgba(15, 23, 42, 0.18);
            opacity: 0;
            visibility: hidden;
            pointer-events: none;
            transform: translateY(-10px) scale(0.96);
            transform-origin: top right;
            transition:
                opacity 0.22s ease,
                visibility 0.22s ease,
                transform 0.28s cubic-bezier(.2,.8,.2,1);
            z-index: 9999;
        }

        .nav-dropdown.active .nav-dropdown-menu {
            opacity: 1;
            visibility: visible;
            pointer-events: auto;
            transform: translateY(0) scale(1);
        }

        .nav-dropdown-menu::before {
            content: "";
            position: absolute;
            top: -6px;
            right: 26px;
            width: 12px;
            height: 12px;
            background: #ffffff;
            border-left: 1px solid rgba(226, 232, 240, 0.95);
            border-top: 1px solid rgba(226, 232, 240, 0.95);
            transform: rotate(45deg);
        }

        .nav-dropdown-item {
            display: flex;
            align-items: center;
            gap: 9px;
            padding: 10px 12px;
            border-radius: 9px;
            text-decoration: none;
            color: #212529;
            font-size: 13px;
            font-weight: 600;
            transition: 0.22s cubic-bezier(.2,.8,.2,1);
            white-space: nowrap;
        }

        .nav-dropdown-item i {
            width: 18px;
            color: #1565C0;
            font-size: 13px;
            transition: 0.22s ease;
        }

        .nav-dropdown-item:hover {
            background: #E3F2FD;
            color: #1565C0;
            transform: translateX(4px);
        }

        .nav-dropdown-item.active {
            background: #E3F2FD;
            color: #1565C0;
            font-weight: 700;
        }

        .nav-dropdown-item:hover i,
        .nav-dropdown-item.active i {
            color: #1565C0;
            transform: scale(1.08);
        }

        /*
        |--------------------------------------------------------------------------
        | MAIN CONTENT
        |--------------------------------------------------------------------------
        | Menentukan tinggi minimum area konten utama halaman.
        |--------------------------------------------------------------------------
        */

        main {
            min-height: 60vh;
        }

        /*
        |--------------------------------------------------------------------------
        | FOOTER LOGOS
        |--------------------------------------------------------------------------
        | Mengatur daftar logo tautan eksternal pada bagian footer.
        |--------------------------------------------------------------------------
        */

        .footer-logos-section {
            padding: 32px 0;
            border-top: 1px solid #DEE2E6;
            border-bottom: 1px solid #DEE2E6;
            background: #fff;
        }

        .footer-logos-wrap {
            display: flex;
            align-items: flex-start;
            justify-content: center;
            gap: 64px;
            flex-wrap: wrap;
            padding: 0 24px;
        }

        .footer-logo-item {
            display: flex;
            flex-direction: column;
            align-items: center;
            text-align: center;
            text-decoration: none;
            color: #212529;
            width: 170px;
            transition: opacity 0.2s;
        }

        .footer-logo-item:hover {
            opacity: 0.8;
        }

        .footer-logo-item img {
            height: 70px;
            object-fit: contain;
            margin-bottom: 12px;
            display: block;
            margin-left: auto;
            margin-right: auto;
        }

        .footer-logo-item .logo-name {
            font-size: 13px;
            font-weight: 700;
            color: #212529;
            line-height: 1.3;
            margin-bottom: 5px;
            text-align: center;
            width: 100%;
        }

        .footer-logo-item .logo-desc {
            font-size: 11.5px;
            color: #6C757D;
            line-height: 1.5;
            text-align: center;
            width: 100%;
        }

        /*
        |--------------------------------------------------------------------------
        | FOOTER BOTTOM
        |--------------------------------------------------------------------------
        | Mengatur informasi kontak dan media sosial pada footer bawah.
        |--------------------------------------------------------------------------
        */

        .footer-bottom {
            background: #0D47A1;
            padding: 24px 0;
            width: 100%;
        }

        .footer-bottom-inner {
            display: flex;
            align-items: center;
            gap: 24px;
            padding: 0 24px;
        }

        .footer-bottom .footer-dinsos-logo img {
            height: 56px;
            object-fit: contain;
            flex-shrink: 0;
        }

        .footer-bottom .footer-info {
            color: rgba(255,255,255,0.9);
            font-size: 13px;
            line-height: 1.8;
        }

        .footer-bottom .footer-info strong {
            font-size: 14px;
            font-weight: 700;
            color: #fff;
            display: block;
            margin-bottom: 2px;
        }

        .footer-social {
            display: flex;
            gap: 8px;
            margin-top: 10px;
        }

        .footer-social a {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 32px;
            height: 32px;
            border-radius: 50%;
            background: rgba(255,255,255,0.15);
            color: #fff;
            font-size: 14px;
            text-decoration: none;
            transition: background 0.2s;
        }

        .footer-social a:hover {
            background: rgba(255,255,255,0.3);
        }

        /*
        |--------------------------------------------------------------------------
        | RESPONSIVE TABLET
        |--------------------------------------------------------------------------
        | Menyesuaikan tampilan navbar dan footer pada ukuran layar menengah.
        |--------------------------------------------------------------------------
        */

        @media (max-width: 900px) {
            .navbar-dtsen .nav-inner {
                padding: 0 14px;
            }

            .navbar-dtsen .brand-text {
                font-size: 15px;
            }

            .navbar-dtsen .navbar-nav {
                gap: 0;
            }

            .navbar-dtsen .nav-link {
                font-size: 12px;
                padding: 0 8px !important;
            }

            .nav-dropdown-menu {
                right: -8px;
                min-width: 175px;
            }

            .footer-bottom-inner {
                flex-direction: column;
                align-items: flex-start;
            }
        }

        /*
        |--------------------------------------------------------------------------
        | RESPONSIVE MOBILE
        |--------------------------------------------------------------------------
        | Mengoptimalkan tampilan navigasi pada perangkat berukuran kecil.
        |--------------------------------------------------------------------------
        */

        @media (max-width: 650px) {
            .navbar-dtsen .brand-text {
                display: none;
            }

            .navbar-dtsen .brand-logo {
                width: 54px;
                height: 54px;
            }

            .navbar-dtsen .nav-link {
                font-size: 11px;
                padding: 0 6px !important;
            }

            .nav-dropdown-menu {
                position: fixed;
                top: 74px;
                right: 12px;
                left: auto;
                min-width: 180px;
            }

            .nav-dropdown-menu::before {
                display: none;
            }
        }
    </style>

    @stack('styles')
</head>
{{-- BAGIAN BODY --}}
<body>

{{--
|--------------------------------------------------------------------------
| NAVBAR UTAMA
|--------------------------------------------------------------------------
| Menampilkan logo, nama website, dan menu navigasi utama halaman publik.
|--------------------------------------------------------------------------
--}}
{{-- NAVBAR HALAMAN --}}
<nav class="navbar-dtsen">
    <div class="nav-inner">
        <a class="navbar-brand" href="{{ url('/') }}">
            <img src="{{ asset('assets/dinas-sosial-prov-jawa-tengah.png') }}" class="brand-logo" alt="Logo">
            <span class="brand-text">DTSEN JAWA TENGAH</span>
        </a>

        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link {{ request()->is('/') ? 'active' : '' }}"
                   href="{{ url('/') }}">
                    Beranda
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link {{ request()->is('daya-tampung-panti*') ? 'active' : '' }}"
                   href="{{ url('/daya-tampung-panti') }}">
                    Daya Tampung Panti
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link {{ request()->is('peta*') ? 'active' : '' }}"
                   href="{{ url('/peta') }}">
                    Peta
                </a>
            </li>

            {{--
            |--------------------------------------------------------------------------
            | MENU RILIS DATA
            |--------------------------------------------------------------------------
            | Menampilkan pilihan halaman data publik dalam bentuk dropdown.
            |--------------------------------------------------------------------------
            --}}
            <li class="nav-item nav-dropdown" id="rilisDropdown">
                <button type="button"
                        class="nav-link nav-dropdown-toggle {{ request()->is('dt-jateng*') || request()->is('ppks*') || request()->is('psks*') ? 'active' : '' }}">
                    <span>Rilis Data</span>
                    <i class="fa-solid fa-chevron-down dropdown-icon"></i>
                </button>

                <div class="nav-dropdown-menu">
                    <a href="{{ url('/dt-jateng') }}"
                       class="nav-dropdown-item {{ request()->is('dt-jateng*') ? 'active' : '' }}">
                        <i class="fa-solid fa-database"></i>
                        <span>DT Jateng</span>
                    </a>

                    <a href="{{ url('/ppks') }}"
                       class="nav-dropdown-item {{ request()->is('ppks*') ? 'active' : '' }}">
                        <i class="fa-solid fa-people-group"></i>
                        <span>PPKS</span>
                    </a>

                    <a href="{{ url('/psks') }}"
                       class="nav-dropdown-item {{ request()->is('psks*') ? 'active' : '' }}">
                        <i class="fa-solid fa-hand-holding-heart"></i>
                        <span>PSKS</span>
                    </a>
                </div>
            </li>

            {{--
            |--------------------------------------------------------------------------
            | MENU FAQ
            |--------------------------------------------------------------------------
            | Disiapkan sebagai menu tambahan jika halaman FAQ akan digunakan.
            |--------------------------------------------------------------------------
            --}}
            <li class="nav-item">
                {{-- <a class="nav-link {{ request()->is('faqs*') ? 'active' : '' }}"
                   href="{{ url('/faqs') }}">
                    FAQs
                </a> --}}
            </li>
        </ul>
    </div>
</nav>

{{--
|--------------------------------------------------------------------------
| KONTEN HALAMAN
|--------------------------------------------------------------------------
| Area utama untuk menampilkan konten dari setiap halaman yang menggunakan layout ini.
|--------------------------------------------------------------------------
--}}
{{-- KONTEN UTAMA --}}
<main>
    @yield('content')
</main>

{{--
|--------------------------------------------------------------------------
| FOOTER WEBSITE
|--------------------------------------------------------------------------
| Footer hanya ditampilkan jika halaman tidak mengisi section hide_footer.
|--------------------------------------------------------------------------
--}}
@hasSection('hide_footer')
@else
    {{--
    |--------------------------------------------------------------------------
    | FOOTER LOGOS
    |--------------------------------------------------------------------------
    | Menampilkan tautan cepat ke layanan atau website terkait.
    |--------------------------------------------------------------------------
    --}}
    <div class="footer-logos-section">
        <div class="container-fluid px-4">
            <div class="footer-logos-wrap">
                <a href="https://dinsos.jatengprov.go.id/webdinsos2024/public/" class="footer-logo-item">
                    <img src="{{ asset('assets/dinas-sosial-prov-jawa-tengah.png') }}" alt="Dinas Sosial">
                    <span class="logo-name">DINAS SOSIAL PROV JATENG</span>
                    <span class="logo-desc">Portal Website Milik Dinas Sosial, Provinsi Jawa Tengah</span>
                </a>

                <a href="https://caribdt.dinsos.jatengprov.go.id/" class="footer-logo-item">
                    <img src="{{ asset('assets/CariBDT.png') }}" alt="Caribot">
                    <span class="logo-name">CARIBDT</span>
                    <span class="logo-desc">Portal layanan pencarian data Data Tunggal Sosial dan Ekonomi Nasional berdasarkan NIK atau No.NIK khusus Provinsi Jawa Tengah</span>
                </a>

                <a href="https://kemensos.go.id/" class="footer-logo-item">
                    <img src="{{ asset('assets/Kemensos.png') }}" alt="Kemensos">
                    <span class="logo-name">KEMENSOS</span>
                    <span class="logo-desc">Portal Website Milik Kementerian Sosial Republik Indonesia</span>
                </a>

                <a href="https://cekbansos.kemensos.go.id/" class="footer-logo-item">
                    <img src="{{ asset('assets/cek Bansos Kemensos.png') }}" alt="Cekbansos">
                    <span class="logo-name">CEKBANSOS KEMENSOS</span>
                    <span class="logo-desc">Portal Website Milik Kementerian Sosial Republik Indonesia</span>
                </a>
            </div>
        </div>
    </div>

    {{--
    |--------------------------------------------------------------------------
    | FOOTER KONTAK
    |--------------------------------------------------------------------------
    | Menampilkan informasi alamat, kontak, dan media sosial instansi.
    |--------------------------------------------------------------------------
    --}}
    <div class="footer-bottom">
        <div class="footer-bottom-inner">
            <div class="footer-dinsos-logo">
                <img src="{{ asset('assets/dinsos_footer.png') }}" alt="Dinas Sosial">
            </div>

            <div class="footer-info">
                <strong>Dinas Sosial Provinsi Jawa Tengah</strong>
                Jl. Pahlawan No.12, Pleburan, Semarang Selatan, Kota Semarang<br>
                Telepon : (024) 8311729 / (024) 84507041<br>
                Helpdesk (WA Text Only) : +62 851-866-844-8

                <div class="footer-social">
                    <a href="https://www.facebook.com/dinsosjateng/"><i class="fab fa-facebook-f"></i></a>
                    <a href="https://x.com/dinsosjateng"><i class="fab fa-x-twitter"></i></a>
                    <a href="https://www.instagram.com/dinsosjtg/"><i class="fab fa-instagram"></i></a>
                    <a href="https://www.youtube.com/@dinsosjatengofficial"><i class="fab fa-youtube"></i></a>
                </div>
            </div>
        </div>
    </div>
@endif

{{--
|--------------------------------------------------------------------------
| LIBRARY JAVASCRIPT
|--------------------------------------------------------------------------
| Memuat Bootstrap JS sebagai pendukung komponen interaktif.
|--------------------------------------------------------------------------
--}}
{{-- SCRIPT JAVASCRIPT --}}
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

<script>
    /*
    |--------------------------------------------------------------------------
    | CUSTOM DROPDOWN RILIS DATA
    |--------------------------------------------------------------------------
    | Mengatur aksi buka, tutup, dan navigasi keyboard pada dropdown Rilis Data.
    |--------------------------------------------------------------------------
    */

    document.addEventListener('DOMContentLoaded', function () {
        const dropdown = document.getElementById('rilisDropdown');

        if (!dropdown) {
            return;
        }

        const toggle = dropdown.querySelector('.nav-dropdown-toggle');

        toggle.addEventListener('click', function (event) {
            event.preventDefault();
            event.stopPropagation();

            dropdown.classList.toggle('active');
        });

        document.addEventListener('click', function (event) {
            if (!dropdown.contains(event.target)) {
                dropdown.classList.remove('active');
            }
        });

        document.addEventListener('keydown', function (event) {
            if (event.key === 'Escape') {
                dropdown.classList.remove('active');
            }
        });
    });
</script>

@stack('scripts')
</body>
</html>