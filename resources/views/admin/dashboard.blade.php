@extends('admin.layouts.app')

@section('title', 'Dashboard Admin DTSEN')
@section('breadcrumb', 'Home')

@section('content')
    <style>
        @import url('https://fonts.bunny.net/css?family=inter:400,500,600,700,800,900&display=swap');

        /*
        |--------------------------------------------------------------------------
        | GLOBAL FONT VARIABLE
        |--------------------------------------------------------------------------
        | Menyimpan font utama dashboard admin agar konsisten di seluruh halaman.
        |--------------------------------------------------------------------------
        */

        :root {
            --admin-font-main: 'Inter', ui-sans-serif, system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", sans-serif;
        }

        /*
        |--------------------------------------------------------------------------
        | DASHBOARD HERO
        |--------------------------------------------------------------------------
        | Mengatur tampilan banner pembuka dashboard admin.
        |--------------------------------------------------------------------------
        */

        .dashboard-hero {
            position: relative;
            overflow: hidden;
            border-radius: 28px;
            padding: 28px;
            margin-bottom: 22px;
            color: white;
            background:
                radial-gradient(circle at top right, rgba(255,255,255,0.24), transparent 28%),
                linear-gradient(135deg, #2563eb, #0ea5e9);
            box-shadow: 0 24px 48px rgba(37, 99, 235, 0.22);
            animation: fadeUp 0.58s ease both;
        }

        .dashboard-hero::before {
            content: "";
            position: absolute;
            width: 260px;
            height: 260px;
            border-radius: 999px;
            background: rgba(255,255,255,0.13);
            right: -80px;
            bottom: -120px;
        }

        .hero-content {
            position: relative;
            z-index: 1;
            display: flex;
            justify-content: space-between;
            gap: 18px;
            align-items: center;
        }

        .hero-title {
            font-size: 28px;
            font-weight: 900;
            letter-spacing: -0.8px;
            margin-bottom: 8px;
        }

        .hero-desc {
            color: rgba(255,255,255,0.86);
            font-size: 14px;
            line-height: 1.65;
            max-width: 620px;
        }

        .hero-badge {
            min-width: 150px;
            padding: 14px 16px;
            border-radius: 20px;
            background: rgba(255,255,255,0.16);
            border: 1px solid rgba(255,255,255,0.20);
            text-align: center;
            backdrop-filter: blur(12px);
        }

        .hero-badge small {
            display: block;
            color: rgba(255,255,255,0.78);
            font-weight: 700;
            margin-bottom: 5px;
        }

        .hero-badge strong {
            font-size: 20px;
            font-weight: 900;
        }

        /*
        |--------------------------------------------------------------------------
        | STATS CARD
        |--------------------------------------------------------------------------
        | Mengatur kartu ringkasan jumlah data utama pada dashboard.
        |--------------------------------------------------------------------------
        */

        .stats-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 18px;
            margin-bottom: 22px;
        }

        .stat-card {
            position: relative;
            overflow: hidden;
            background: rgba(255, 255, 255, 0.88);
            border: 1px solid rgba(226, 232, 240, 0.88);
            border-radius: 24px;
            padding: 22px;
            box-shadow: 0 18px 45px rgba(15, 23, 42, 0.07);
            transition: 0.28s cubic-bezier(.2,.8,.2,1);
            animation: fadeUp 0.56s ease both;
        }

        .stat-card:nth-child(1) { animation-delay: 0.05s; }
        .stat-card:nth-child(2) { animation-delay: 0.10s; }
        .stat-card:nth-child(3) { animation-delay: 0.15s; }
        .stat-card:nth-child(4) { animation-delay: 0.20s; }

        .stat-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 24px 55px rgba(15, 23, 42, 0.11);
        }

        .stat-card::after {
            content: "";
            position: absolute;
            width: 120px;
            height: 120px;
            border-radius: 999px;
            right: -48px;
            top: -48px;
            background: rgba(37, 99, 235, 0.08);
        }

        .stat-top {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 18px;
        }

        .stat-icon {
            width: 44px;
            height: 44px;
            display: grid;
            place-items: center;
            border-radius: 16px;
            color: white;
            background: linear-gradient(135deg, #2563eb, #0ea5e9);
            box-shadow: 0 14px 22px rgba(37, 99, 235, 0.22);
        }

        .stat-growth {
            font-size: 12px;
            font-weight: 900;
            color: #16a34a;
            background: #dcfce7;
            padding: 5px 8px;
            border-radius: 999px;
        }

        .stat-label {
            color: #64748b;
            font-size: 13px;
            font-weight: 700;
        }

        .stat-number {
            margin-top: 8px;
            font-size: 34px;
            font-weight: 900;
            letter-spacing: 3px;
            color: #0f172a;
        }

        /*
        |--------------------------------------------------------------------------
        | MODERN CHART
        |--------------------------------------------------------------------------
        | Mengatur kartu grafik aktivitas data pada dashboard admin.
        |--------------------------------------------------------------------------
        */

        .chart-card {
            position: relative;
            overflow: hidden;
            background: rgba(255, 255, 255, 0.88);
            border: 1px solid rgba(226, 232, 240, 0.88);
            border-radius: 28px;
            padding: 26px;
            box-shadow: 0 18px 45px rgba(15, 23, 42, 0.07);
            animation: fadeUp 0.65s ease both;
            animation-delay: 0.24s;
            margin-bottom: 26px;
        }

        .chart-header {
            display: flex;
            align-items: flex-start;
            justify-content: space-between;
            gap: 16px;
            margin-bottom: 24px;
        }

        .chart-title {
            font-size: 22px;
            font-weight: 900;
            letter-spacing: 0.4px;
            margin-bottom: 6px;
        }

        .chart-subtitle {
            color: #64748b;
            font-size: 13px;
            line-height: 1.6;
        }

        .chart-actions {
            display: flex;
            gap: 8px;
            align-items: center;
            flex-wrap: wrap;
        }

        .chart-pill {
            border: none;
            padding: 9px 12px;
            border-radius: 999px;
            background: #eef5ff;
            color: #2563eb;
            font-size: 12px;
            font-weight: 900;
            cursor: pointer;
            transition: 0.22s ease;
        }

        .chart-pill:hover,
        .chart-pill.active {
            background: #2563eb;
            color: white;
            transform: translateY(-1px);
            box-shadow: 0 12px 20px rgba(37, 99, 235, 0.20);
        }

        .chart-area {
            position: relative;
            height: 340px;
            padding: 26px 14px 38px 14px;
            border-radius: 24px;
            background:
                linear-gradient(to top, rgba(37, 99, 235, 0.04), transparent),
                repeating-linear-gradient(
                    to top,
                    transparent 0,
                    transparent 67px,
                    rgba(148, 163, 184, 0.17) 68px
                );
            display: flex;
            align-items: end;
            gap: 18px;
        }

        .bar-item {
            flex: 1;
            height: 100%;
            display: flex;
            flex-direction: column;
            justify-content: end;
            align-items: center;
            gap: 10px;
            min-width: 34px;
        }

        .bar-wrap {
            width: 100%;
            height: 250px;
            display: flex;
            align-items: end;
            justify-content: center;
        }

        .bar {
            width: min(56px, 72%);
            height: var(--height);
            position: relative;
            border-radius: 18px 18px 8px 8px;
            background: linear-gradient(180deg, #38bdf8 0%, #2563eb 100%);
            box-shadow: 0 16px 26px rgba(37, 99, 235, 0.22);
            transform-origin: bottom;
            animation: growBar 1s cubic-bezier(.2,.8,.2,1) both;
            animation-delay: var(--delay);
            transition: 0.25s ease;
        }

        .bar::before {
            content: attr(data-value);
            position: absolute;
            top: -32px;
            left: 50%;
            transform: translateX(-50%) translateY(8px);
            background: #0f172a;
            color: white;
            font-size: 11px;
            font-weight: 900;
            padding: 5px 8px;
            border-radius: 999px;
            opacity: 0;
            pointer-events: none;
            transition: 0.2s ease;
        }

        .bar::after {
            content: "";
            position: absolute;
            inset: 8px 9px auto 9px;
            height: 34%;
            border-radius: 999px;
            background: linear-gradient(180deg, rgba(255,255,255,0.38), transparent);
        }

        .bar:hover {
            transform: translateY(-6px) scaleY(1.02);
            filter: saturate(1.12);
        }

        .bar:hover::before {
            opacity: 1;
            transform: translateX(-50%) translateY(0);
        }

        .bar-label {
            font-size: 13px;
            color: #334155;
            font-weight: 800;
        }

        .chart-footer {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-top: 18px;
            color: #64748b;
            font-size: 13px;
        }

        .legend-inline {
            display: flex;
            align-items: center;
            gap: 8px;
            font-weight: 700;
        }

        .legend-dot {
            width: 10px;
            height: 10px;
            border-radius: 999px;
            background: linear-gradient(135deg, #38bdf8, #2563eb);
        }

        /*
        |--------------------------------------------------------------------------
        | ANIMATION
        |--------------------------------------------------------------------------
        | Menyediakan animasi untuk grafik batang dan elemen dashboard.
        |--------------------------------------------------------------------------
        */

        @keyframes growBar {
            from {
                transform: scaleY(0);
                opacity: 0;
            }

            to {
                transform: scaleY(1);
                opacity: 1;
            }
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

        /*
        |--------------------------------------------------------------------------
        | RESPONSIVE
        |--------------------------------------------------------------------------
        | Menyesuaikan layout dashboard pada ukuran layar tablet dan mobile.
        |--------------------------------------------------------------------------
        */

        @media (max-width: 1100px) {
            .stats-grid {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        @media (max-width: 720px) {
            .hero-content {
                flex-direction: column;
                align-items: flex-start;
            }

            .stats-grid {
                grid-template-columns: 1fr;
            }

            .chart-header,
            .chart-footer {
                flex-direction: column;
                align-items: flex-start;
            }

            .chart-area {
                gap: 10px;
                overflow-x: auto;
            }

            .bar-item {
                min-width: 46px;
            }
        }

        /*
        |--------------------------------------------------------------------------
        | MODERN FONT SYSTEM - INTER
        |--------------------------------------------------------------------------
        | Menyeragamkan font Inter pada seluruh komponen halaman admin.
        |--------------------------------------------------------------------------
        */

        body,
        .admin-body,
        .admin-layout,
        .content,
        .main-content,
        .admin-content,
        .admin-page-card,
        .admin-card,
        .dt-page,
        .ppks-page,
        .psks-page,
        .dashboard-hero,
        .stats-grid,
        .chart-card,
        .admin-table,
        .dt-wide-table,
        .ppks-wide-table,
        .psks-wide-table,
        input,
        select,
        textarea,
        button,
        a,
        label,
        table,
        th,
        td,
        span,
        p,
        h1,
        h2,
        h3,
        h4,
        h5,
        h6 {
            font-family: var(--admin-font-main) !important;
            -webkit-font-smoothing: antialiased;
            -moz-osx-font-smoothing: grayscale;
            text-rendering: geometricPrecision;
        }

        /*
        |--------------------------------------------------------------------------
        | FONT HEADING
        |--------------------------------------------------------------------------
        | Mengatur ketebalan dan jarak huruf untuk judul utama.
        |--------------------------------------------------------------------------
        */

        .dt-hero h1,
        .ppks-hero h1,
        .psks-hero h1,
        .hero-title,
        .admin-page-header h1,
        .dt-card h2,
        .ppks-card h2,
        .admin-card h2,
        .chart-title,
        .nik-title,
        .ppks-page-title {
            font-weight: 850 !important;
            letter-spacing: -0.045em !important;
            line-height: 1.15 !important;
        }

        /*
        |--------------------------------------------------------------------------
        | FONT PARAGRAPH
        |--------------------------------------------------------------------------
        | Mengatur font deskripsi agar tetap nyaman dibaca.
        |--------------------------------------------------------------------------
        */

        .dt-hero p,
        .ppks-hero p,
        .psks-hero p,
        .hero-desc,
        .dt-card p,
        .ppks-card p,
        .admin-card p,
        .chart-subtitle,
        .admin-page-header p {
            font-weight: 500 !important;
            letter-spacing: -0.015em !important;
            line-height: 1.65 !important;
        }

        /*
        |--------------------------------------------------------------------------
        | FONT LABEL
        |--------------------------------------------------------------------------
        | Mengatur label form agar terlihat jelas dan profesional.
        |--------------------------------------------------------------------------
        */

        .dt-form-group label,
        .ppks-form-group label,
        .psks-form-row label,
        .admin-form-grid label,
        .input-label {
            font-weight: 760 !important;
            letter-spacing: -0.018em !important;
            line-height: 1.3 !important;
        }

        /*
        |--------------------------------------------------------------------------
        | FONT INPUT
        |--------------------------------------------------------------------------
        | Mengatur teks pada input, select, textarea, dan trigger dropdown.
        |--------------------------------------------------------------------------
        */

        input,
        select,
        textarea,
        .dt-search-row input,
        .ppks-search-row input,
        .psks-form-row input,
        .admin-form-grid input,
        .admin-form-grid select,
        .admin-search-row input,
        .modern-select-trigger,
        .smart-trigger,
        .modern-select-search,
        .smart-search,
        .year-input,
        .dt-field,
        .ppks-year-input,
        .psks-row-title input,
        .ppks-name-input {
            font-weight: 600 !important;
            letter-spacing: -0.015em !important;
            line-height: 1.35 !important;
        }

        input::placeholder,
        textarea::placeholder,
        .modern-select-label.is-placeholder,
        .smart-placeholder {
            font-weight: 500 !important;
            letter-spacing: -0.01em !important;
        }

        /*
        |--------------------------------------------------------------------------
        | FONT BUTTON
        |--------------------------------------------------------------------------
        | Mengatur font pada tombol dan elemen aksi interaktif.
        |--------------------------------------------------------------------------
        */

        button,
        .dt-add-btn,
        .dt-search-row button,
        .dt-search-row a,
        .dt-scroll-buttons button,
        .ppks-submit-btn,
        .ppks-search-row button,
        .ppks-search-row a,
        .ppks-scroll-buttons button,
        .psks-form-row button,
        .psks-scroll-buttons button,
        .admin-form-grid button,
        .admin-search-row button,
        .admin-search-row a,
        .chart-pill,
        .btn-modern,
        .action-btn,
        .page-link-custom,
        .page-link-disabled,
        .page-link-active {
            font-weight: 760 !important;
            letter-spacing: -0.018em !important;
            line-height: 1.2 !important;
        }

        /*
        |--------------------------------------------------------------------------
        | FONT TABLE
        |--------------------------------------------------------------------------
        | Mengatur font pada header dan isi tabel.
        |--------------------------------------------------------------------------
        */

        table th,
        .dt-wide-table th,
        .ppks-wide-table th,
        .psks-wide-table th,
        .admin-table th {
            font-weight: 780 !important;
            letter-spacing: 0.035em !important;
            line-height: 1.35 !important;
        }

        table td,
        .dt-wide-table td,
        .ppks-wide-table td,
        .psks-wide-table td,
        .admin-table td {
            font-weight: 520 !important;
            letter-spacing: -0.015em !important;
            line-height: 1.45 !important;
        }

        table td strong,
        .sticky-name,
        .dt-row-title,
        .psks-row-title,
        .ppks-mode-card h3,
        .stat-number,
        .hero-badge strong {
            font-weight: 760 !important;
            letter-spacing: -0.018em !important;
        }

        /*
        |--------------------------------------------------------------------------
        | FONT BADGE DAN NOTE
        |--------------------------------------------------------------------------
        | Mengatur teks kecil seperti badge, status, dropdown option, dan informasi.
        |--------------------------------------------------------------------------
        */

        .dt-badge,
        .ppks-badge,
        .psks-badge,
        .admin-page-badge,
        .badge-status,
        .stat-growth,
        .pagination-info,
        .modern-select-option,
        .smart-option,
        .modern-select-empty,
        .smart-empty,
        .dt-scroll-note,
        .ppks-scroll-note,
        .psks-scroll-note {
            font-weight: 700 !important;
            letter-spacing: -0.012em !important;
        }
    </style>

    {{--
    |--------------------------------------------------------------------------
    | HERO DASHBOARD
    |--------------------------------------------------------------------------
    | Menampilkan sapaan admin dan status sistem secara ringkas.
    |--------------------------------------------------------------------------
    --}}
    <section class="dashboard-hero">
        <div class="hero-content">
            <div>
                <h1 class="hero-title">Selamat Datang, {{ session('admin_username', 'Admin') }}</h1>
                <p class="hero-desc">
                    Kelola data wilayah, data NIK, data master sosial, dan kebutuhan sistem DTSEN Jawa Tengah dari satu dashboard.
                </p>
            </div>

            <div class="hero-badge">
                <small>Status</small>
                <strong>Online</strong>
            </div>
        </div>
    </section>

    {{--
    |--------------------------------------------------------------------------
    | STATISTIK UTAMA
    |--------------------------------------------------------------------------
    | Menampilkan ringkasan jumlah data kabupaten, kecamatan, desa, dan NIK.
    |--------------------------------------------------------------------------
    --}}
    <section class="stats-grid">
        <div class="stat-card">
            <div class="stat-top">
                <div class="stat-icon">
                    <i class="fa fa-city"></i>
                </div>
                <div class="stat-growth">+ Aktif</div>
            </div>
            <div class="stat-label">Total Kabupaten/Kota</div>
            <div class="stat-number">{{ number_format($totalKabupaten) }}</div>
        </div>

        <div class="stat-card">
            <div class="stat-top">
                <div class="stat-icon">
                    <i class="fa fa-map-location-dot"></i>
                </div>
                <div class="stat-growth">+ Aktif</div>
            </div>
            <div class="stat-label">Total Kecamatan</div>
            <div class="stat-number">{{ number_format($totalKecamatan) }}</div>
        </div>

        <div class="stat-card">
            <div class="stat-top">
                <div class="stat-icon">
                    <i class="fa fa-location-dot"></i>
                </div>
                <div class="stat-growth">+ Aktif</div>
            </div>
            <div class="stat-label">Total Desa</div>
            <div class="stat-number">{{ number_format($totalDesa) }}</div>
        </div>

        <div class="stat-card">
            <div class="stat-top">
                <div class="stat-icon">
                    <i class="fa fa-id-card"></i>
                </div>
                <div class="stat-growth">Data</div>
            </div>
            <div class="stat-label">Total Data NIK</div>
            <div class="stat-number">{{ number_format($totalNik) }}</div>
        </div>
    </section>

    {{--
    |--------------------------------------------------------------------------
    | GRAFIK AKTIVITAS DATA
    |--------------------------------------------------------------------------
    | Menampilkan grafik simulasi aktivitas pengelolaan data per bulan.
    |--------------------------------------------------------------------------
    --}}
    <section class="chart-card">
        <div class="chart-header">
            <div>
                <div class="chart-title">Statistik Aktivitas Data</div>
                <div class="chart-subtitle">
                    Grafik simulasi aktivitas pengelolaan data per bulan untuk kebutuhan tampilan dashboard admin.
                </div>
            </div>

            <div class="chart-actions">
                <button class="chart-pill active" type="button">2026</button>
                <button class="chart-pill" type="button">Wilayah</button>
                <button class="chart-pill" type="button">NIK</button>
                <button class="chart-pill" type="button">Master Data</button>
            </div>
        </div>

        {{--
        |--------------------------------------------------------------------------
        | DATA GRAFIK BULANAN
        |--------------------------------------------------------------------------
        | Menyediakan data simulasi untuk grafik batang dashboard.
        |--------------------------------------------------------------------------
        --}}
        @php
            $months = ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'];
            $values = [12, 22, 31, 15, 25, 68, 84, 22, 17, 29, 44, 59];
            $max = max($values);
        @endphp

        <div class="chart-area">
            @foreach($values as $index => $value)
                @php
                    $height = ($value / $max) * 100;
                    $delay = $index * 0.055;
                @endphp

                <div class="bar-item">
                    <div class="bar-wrap">
                        <div
                            class="bar"
                            style="--height: {{ $height }}%; --delay: {{ $delay }}s;"
                            data-value="{{ $value }}"
                        >
                        </div>
                    </div>
                    <div class="bar-label">{{ $months[$index] }}</div>
                </div>
            @endforeach
        </div>

        <div class="chart-footer">
            <div class="legend-inline">
                <span class="legend-dot"></span>
                <span>Aktivitas Data</span>
            </div>

            <div>
                Terakhir diperbarui: {{ date('d M Y') }}
            </div>
        </div>
    </section>
@endsection