@extends('admin.layouts.app')

@section('title', 'Kelola PSKS')
@section('breadcrumb', 'PSKS')

@section('content')
<style>
    @import url('https://fonts.bunny.net/css?family=inter:400,500,600,700,800,900&display=swap');

    /*
    |--------------------------------------------------------------------------
    | GLOBAL VARIABLE
    |--------------------------------------------------------------------------
    | Menyimpan font utama yang digunakan pada halaman admin PSKS.
    |--------------------------------------------------------------------------
    */

    :root {
        --admin-font-main: 'Inter', ui-sans-serif, system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", sans-serif;
    }

    /*
    |--------------------------------------------------------------------------
    | FIX AREA ADMIN
    |--------------------------------------------------------------------------
    | Menjaga layout admin agar tabel lebar tidak merusak struktur halaman.
    |--------------------------------------------------------------------------
    */

    .admin-body {
        grid-template-columns: var(--sidebar-width) minmax(0, 1fr) !important;
    }

    .content {
        min-width: 0 !important;
        overflow-x: hidden !important;
    }

    .admin-card {
        min-width: 0 !important;
        max-width: 100% !important;
        overflow: visible !important;
    }

    /*
    |--------------------------------------------------------------------------
    | PSKS HERO
    |--------------------------------------------------------------------------
    | Mengatur banner utama halaman Kelola PSKS.
    |--------------------------------------------------------------------------
    */

    .psks-hero {
        position: relative;
        overflow: hidden;
        background: linear-gradient(135deg, #2563eb, #0ea5e9);
        border-radius: 28px;
        padding: 32px;
        color: white;
        margin-bottom: 24px;
        box-shadow: 0 24px 50px rgba(37, 99, 235, 0.20);
    }

    .psks-hero::after {
        content: "";
        position: absolute;
        right: -80px;
        bottom: -100px;
        width: 260px;
        height: 260px;
        border-radius: 999px;
        background: rgba(255, 255, 255, 0.14);
    }

    .psks-hero-content {
        position: relative;
        z-index: 2;
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 20px;
    }

    .psks-hero h1 {
        font-size: 30px;
        font-weight: 950;
        margin-bottom: 8px;
        letter-spacing: -0.6px;
    }

    .psks-hero p {
        color: rgba(255, 255, 255, 0.86);
        font-size: 15px;
        line-height: 1.6;
    }

    .psks-badge {
        padding: 11px 18px;
        border-radius: 999px;
        background: rgba(255, 255, 255, 0.18);
        border: 1px solid rgba(255, 255, 255, 0.24);
        font-size: 13px;
        font-weight: 950;
        white-space: nowrap;
    }

    /*
    |--------------------------------------------------------------------------
    | FORM TAMBAH DATA
    |--------------------------------------------------------------------------
    | Mengatur layout input untuk menambahkan jenis PSKS, tahun, dan jumlah.
    |--------------------------------------------------------------------------
    */

    .psks-form-row {
        display: grid;
        grid-template-columns: 1fr 1fr 1fr auto;
        gap: 14px;
        align-items: end;
    }

    .psks-form-row label {
        display: block;
        font-size: 12px;
        font-weight: 850;
        color: #475569;
        margin-bottom: 7px;
    }

    .psks-form-row input {
        width: 100%;
        height: 44px;
        border: 1px solid #dbe4ef;
        border-radius: 14px;
        padding: 0 13px;
        outline: none;
        font-size: 13px;
        background: #ffffff;
        transition: 0.22s ease;
    }

    .psks-form-row input:focus {
        border-color: #2563eb;
        box-shadow: 0 0 0 4px rgba(37, 99, 235, 0.09);
    }

    .psks-form-row button {
        height: 44px;
        border: none;
        border-radius: 14px;
        padding: 0 18px;
        font-size: 13px;
        font-weight: 900;
        cursor: pointer;
        color: white;
        background: linear-gradient(135deg, #2563eb, #0ea5e9);
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        transition: 0.22s ease;
    }

    .psks-form-row button:hover {
        transform: translateY(-2px);
        box-shadow: 0 12px 24px rgba(37, 99, 235, 0.22);
    }

    /*
    |--------------------------------------------------------------------------
    | SCROLL CONTROL
    |--------------------------------------------------------------------------
    | Mengatur catatan dan tombol bantu untuk menggeser tabel ke kiri atau kanan.
    |--------------------------------------------------------------------------
    */

    .psks-scroll-note {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 12px;
        margin: 14px 0;
        padding: 12px 14px;
        border-radius: 16px;
        background: #eff6ff;
        color: #1e40af;
        font-size: 13px;
        font-weight: 800;
        border: 1px solid #dbeafe;
    }

    .psks-scroll-note i {
        margin-right: 8px;
    }

    .psks-scroll-buttons {
        display: flex;
        align-items: center;
        gap: 10px;
        margin-bottom: 12px;
    }

    .psks-scroll-buttons button {
        border: none;
        height: 40px;
        padding: 0 15px;
        border-radius: 13px;
        cursor: pointer;
        font-weight: 900;
        font-size: 13px;
        color: #ffffff;
        background: linear-gradient(135deg, #2563eb, #0ea5e9);
        display: inline-flex;
        align-items: center;
        gap: 8px;
        transition: 0.22s ease;
    }

    .psks-scroll-buttons button:hover {
        transform: translateY(-2px);
        box-shadow: 0 12px 24px rgba(37, 99, 235, 0.22);
    }

    /*
    |--------------------------------------------------------------------------
    | TABLE WRAPPER
    |--------------------------------------------------------------------------
    | Mengatur area tabel agar dapat digeser horizontal tanpa merusak layout.
    |--------------------------------------------------------------------------
    */

    .psks-table-viewport {
        width: 100%;
        max-width: 100%;
        overflow: hidden;
        border-radius: 22px;
        border: 1px solid #e5eaf1;
        background: #ffffff;
    }

    .psks-table-scroll {
        width: 100%;
        max-width: 100%;
        overflow-x: scroll !important;
        overflow-y: visible;
        background: #ffffff;
        scroll-behavior: smooth;
        scrollbar-width: auto;
        scrollbar-color: #2563eb #e5eaf1;
        cursor: grab;
    }

    .psks-table-scroll.dragging {
        cursor: grabbing;
        user-select: none;
    }

    .psks-table-scroll::-webkit-scrollbar {
        height: 18px;
    }

    .psks-table-scroll::-webkit-scrollbar-track {
        background: #e5eaf1;
        border-radius: 999px;
    }

    .psks-table-scroll::-webkit-scrollbar-thumb {
        background: linear-gradient(135deg, #2563eb, #0ea5e9);
        border-radius: 999px;
        border: 4px solid #e5eaf1;
    }

    .psks-table-scroll::-webkit-scrollbar-thumb:hover {
        background: #1d4ed8;
    }

    /*
    |--------------------------------------------------------------------------
    | WIDE TABLE
    |--------------------------------------------------------------------------
    | Mengatur tabel lebar PSKS untuk data tahun 2013 sampai 2023.
    |--------------------------------------------------------------------------
    */

    .psks-wide-table {
        width: max-content;
        min-width: 1760px;
        border-collapse: separate;
        border-spacing: 0;
        margin: 0;
    }

    .psks-wide-table th,
    .psks-wide-table td {
        white-space: nowrap;
        background: #ffffff;
        border-bottom: 1px solid #eef2f7;
        padding: 13px 14px;
    }

    .psks-wide-table th {
        background: #f8fafc;
        position: sticky;
        top: 0;
        z-index: 4;
        font-size: 12px;
        font-weight: 900;
        color: #475569;
        text-transform: uppercase;
    }

    .psks-wide-table tbody tr:hover td {
        background: #f8fafc;
    }

    /*
    |--------------------------------------------------------------------------
    | STICKY COLUMN
    |--------------------------------------------------------------------------
    | Mengatur kolom nomor, jenis PSKS, dan aksi agar tetap terlihat saat tabel digeser.
    |--------------------------------------------------------------------------
    */

    .sticky-no {
        position: sticky;
        left: 0;
        z-index: 6;
        min-width: 70px;
        width: 70px;
        background: #ffffff !important;
        box-shadow: 8px 0 14px rgba(15, 23, 42, 0.04);
        font-size: 14px;
        font-weight: 700;
    }

    thead .sticky-no {
        background: #f8fafc !important;
        z-index: 9;
    }

    .sticky-name {
        position: sticky;
        left: 70px;
        z-index: 6;
        min-width: 330px;
        width: 330px;
        background: #ffffff !important;
        box-shadow: 8px 0 14px rgba(15, 23, 42, 0.04);
    }

    thead .sticky-name {
        background: #f8fafc !important;
        z-index: 9;
        font-size: 12px;
        font-weight: 900;
    }

    .sticky-action {
        min-width: 145px;
        width: 145px;
        text-align: center;
        background: #ffffff !important;
    }

    thead .sticky-action {
        background: #f8fafc !important;
    }

    /*
    |--------------------------------------------------------------------------
    | INPUT JENIS PSKS
    |--------------------------------------------------------------------------
    | Mengatur nama jenis PSKS dan input edit jenis pada tabel.
    |--------------------------------------------------------------------------
    */

    .psks-row-title {
        font-size: 13px !important;
        font-weight: 850 !important;
        color: #0f172a;
        line-height: 1.35;
    }

    .psks-row-title input {
        width: 285px !important;
        height: 42px;
        font-size: 13px !important;
        font-weight: 750 !important;
        border: 1px solid #dbe4ef;
        border-radius: 14px;
        padding: 0 13px;
        outline: none;
    }

    .psks-row-title input:focus {
        border-color: #2563eb;
        box-shadow: 0 0 0 4px rgba(37, 99, 235, 0.09);
    }

    /*
    |--------------------------------------------------------------------------
    | INPUT TAHUN
    |--------------------------------------------------------------------------
    | Mengatur input angka jumlah PSKS pada setiap kolom tahun.
    |--------------------------------------------------------------------------
    */

    .year-input {
        width: 120px !important;
        min-width: 120px;
        height: 44px;
        text-align: right;
        font-size: 13px;
        font-weight: 800;
        border: 1px solid #dbe4ef;
        border-radius: 14px;
        padding: 0 13px;
        outline: none;
        background: white;
    }

    .year-input:focus {
        border-color: #2563eb;
        box-shadow: 0 0 0 4px rgba(37, 99, 235, 0.09);
    }

    /*
    |--------------------------------------------------------------------------
    | ACTION BUTTON
    |--------------------------------------------------------------------------
    | Mengatur tombol simpan dan hapus pada setiap baris data PSKS.
    |--------------------------------------------------------------------------
    */

    .action-button-group {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
    }

    .psks-save-btn,
    .psks-delete-btn {
        width: 44px;
        height: 44px;
        border: none;
        border-radius: 14px;
        cursor: pointer;
        transition: 0.22s ease;
    }

    .psks-save-btn {
        background: #16a34a;
        color: #ffffff;
    }

    .psks-save-btn:hover {
        transform: translateY(-2px);
        background: #15803d;
        box-shadow: 0 12px 24px rgba(22, 163, 74, 0.24);
    }

    .psks-delete-btn {
        background: #fee2e2;
        color: #dc2626;
    }

    .psks-delete-btn:hover {
        transform: translateY(-2px);
        background: #dc2626;
        color: #ffffff;
        box-shadow: 0 12px 24px rgba(220, 38, 38, 0.22);
    }


    /*
    |--------------------------------------------------------------------------
    | PAGINATION PSKS
    |--------------------------------------------------------------------------
    | Mengatur paginator client-side agar tampilan PSKS mengikuti gaya PPKS.
    |--------------------------------------------------------------------------
    */

    .psks-client-pagination {
        margin-top: 18px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 14px;
        flex-wrap: wrap;
        width: 100%;
    }

    .psks-pagination-info {
        color: #64748b;
        font-size: 13px;
        font-weight: 700 !important;
        letter-spacing: -0.012em !important;
    }

    .psks-pagination-links {
        display: flex;
        align-items: center;
        gap: 7px;
        flex-wrap: wrap;
    }

    .psks-page-btn {
        min-width: 38px;
        height: 38px;
        padding: 0 13px;
        border-radius: 12px;
        border: 1px solid #e2e8f0;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        text-decoration: none;
        font-size: 13px;
        font-weight: 760 !important;
        transition: 0.2s ease;
        letter-spacing: -0.018em !important;
        line-height: 1.2 !important;
        background: #ffffff;
        color: #334155;
        cursor: pointer;
    }

    .psks-page-btn:hover {
        background: #eff6ff;
        color: #2563eb;
        border-color: #bfdbfe;
        transform: translateY(-1px);
    }

    .psks-page-btn.active {
        background: #2563eb;
        color: #ffffff;
        border-color: #2563eb;
    }

    .psks-page-btn.disabled {
        background: #f8fafc;
        color: #cbd5e1;
        cursor: not-allowed;
        pointer-events: none;
        transform: none;
    }

    /*
    |--------------------------------------------------------------------------
    | RESPONSIVE TABLET
    |--------------------------------------------------------------------------
    | Menyesuaikan layout hero, form, dan sticky column pada layar sedang.
    |--------------------------------------------------------------------------
    */

    @media (max-width: 1000px) {
        .psks-hero-content {
            flex-direction: column;
            align-items: flex-start;
        }

        .psks-form-row {
            grid-template-columns: 1fr;
        }

        .sticky-name {
            min-width: 250px;
            width: 250px;
        }
    }

    /*
    |--------------------------------------------------------------------------
    | MODERN FONT SYSTEM - INTER
    |--------------------------------------------------------------------------
    | Menyeragamkan font Inter agar tampilan halaman admin lebih modern dan konsisten.
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
    | Mengatur font judul agar lebih tegas dan modern.
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
    | FONT DESCRIPTION
    |--------------------------------------------------------------------------
    | Mengatur font deskripsi agar ringan dan nyaman dibaca.
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
    | Mengatur label input agar konsisten di seluruh halaman admin.
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
    | Mengatur teks pada input, select, textarea, dan custom select.
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
    | Mengatur font pada tombol agar terlihat konsisten dan profesional.
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
    | Mengatur font tabel agar header dan isi data lebih mudah dibaca.
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
    | FONT BADGE DAN INFO KECIL
    |--------------------------------------------------------------------------
    | Mengatur font badge, status, pagination, dan catatan kecil.
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
| HERO HALAMAN PSKS
|--------------------------------------------------------------------------
| Menampilkan judul, deskripsi, dan badge halaman Kelola PSKS.
|--------------------------------------------------------------------------
--}}
<div class="psks-hero">
    <div class="psks-hero-content">
        <div>
            <h1>Kelola PSKS</h1>
            <p>
                Tambah, ubah, dan hapus data Rekap Potensi dan Sumber Kesejahteraan Sosial
                berdasarkan jenis PSKS dan tahun.
            </p>
        </div>

        <span class="psks-badge">PSKS</span>
    </div>
</div>

{{--
|--------------------------------------------------------------------------
| KONDISI TABEL BELUM TERSEDIA
|--------------------------------------------------------------------------
| Menampilkan informasi jika tabel psks belum tersedia pada database.
|--------------------------------------------------------------------------
--}}
@if($tableMissing)
    <div class="admin-card">
        <h2>Tabel belum ditemukan</h2>
        <p>Tabel <strong>psks</strong> belum ada di database.</p>
    </div>
@else

    {{--
    |--------------------------------------------------------------------------
    | FORM TAMBAH DATA PSKS
    |--------------------------------------------------------------------------
    | Form untuk menambahkan data PSKS berdasarkan jenis, tahun, dan jumlah.
    |--------------------------------------------------------------------------
    --}}
    <div class="admin-card">
        <h2>Tambah Data</h2>
        <p>Input data PSKS berdasarkan jenis, tahun, dan jumlah.</p>

        <form action="{{ route('admin.data.psks.jenis.store') }}" method="POST" class="psks-form-row">
            @csrf

            <div>
                <label>Jenis PSKS *</label>
                <input type="text" name="jenis_psks" placeholder="Contoh: Dunia Usaha" required>
            </div>

            <div>
                <label>Tahun *</label>
                <input
                    type="number"
                    name="tahun"
                    placeholder="Contoh: 2023"
                    min="2013"
                    max="2023"
                    required
                >
            </div>

            <div>
                <label>Jumlah *</label>
                <input type="number" name="jumlah" placeholder="Jumlah" min="0" required>
            </div>

            <button type="submit">
                <i class="fa fa-plus"></i>
                Tambah
            </button>
        </form>
    </div>

    {{--
    |--------------------------------------------------------------------------
    | EDIT DATA PSKS
    |--------------------------------------------------------------------------
    | Menampilkan tabel rekap PSKS yang dapat diedit berdasarkan jenis dan tahun.
    |--------------------------------------------------------------------------
    --}}
    <div class="admin-card">
        <h2>Edit Data</h2>
        <p>Ubah angka PSKS berdasarkan jenis dan tahun 2013 sampai 2023.</p>

        {{--
        |--------------------------------------------------------------------------
        | INFORMASI SCROLL TABEL
        |--------------------------------------------------------------------------
        | Memberi petunjuk bahwa tabel dapat digeser ke kanan atau kiri.
        |--------------------------------------------------------------------------
        --}}
        <div class="psks-scroll-note">
            <span>
                <i class="fa fa-arrows-left-right"></i>
                Geser tabel ke kanan/kiri untuk mengedit tahun 2013 sampai 2023.
            </span>
        </div>

        {{--
        |--------------------------------------------------------------------------
        | TOMBOL SCROLL TABEL
        |--------------------------------------------------------------------------
        | Tombol bantu untuk menggeser tabel secara horizontal.
        |--------------------------------------------------------------------------
        --}}
        <div class="psks-scroll-buttons">
            <button type="button" data-scroll-left="psks">
                <i class="fa fa-arrow-left"></i>
                Geser Kiri
            </button>

            <button type="button" data-scroll-right="psks">
                Geser Kanan
                <i class="fa fa-arrow-right"></i>
            </button>
        </div>

        @php
            /*
            |--------------------------------------------------------------------------
            | TOTAL DATA PSKS
            |--------------------------------------------------------------------------
            | Menghitung jumlah baris untuk kebutuhan paginator.
            |--------------------------------------------------------------------------
            */

            $psksTotalRows = count($psksJenisRows);
        @endphp

        {{--
        |--------------------------------------------------------------------------
        | TABEL DATA PSKS
        |--------------------------------------------------------------------------
        | Tabel lebar untuk mengubah data PSKS per jenis dan per tahun.
        |--------------------------------------------------------------------------
        --}}
        <div class="psks-table-viewport">
            <div class="psks-table-scroll" data-scroll-area="psks">
                <table class="psks-wide-table">
                    <thead>
                        <tr>
                            <th class="sticky-no">No</th>
                            <th class="sticky-name">Jenis PSKS</th>

                            @foreach($psksTahunList as $tahun)
                                <th>{{ $tahun }}</th>
                            @endforeach

                            <th class="sticky-action">Aksi</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse($psksJenisRows as $index => $row)
                            @php
                                /*
                                |--------------------------------------------------------------------------
                                | FORM ID PER BARIS
                                |--------------------------------------------------------------------------
                                | Membuat ID form unik untuk setiap baris jenis PSKS.
                                |--------------------------------------------------------------------------
                                */

                                $formId = 'psks-form-' . $index;
                            @endphp

                            <tr class="psks-data-row" data-row-index="{{ $index + 1 }}">
                                <td class="sticky-no" data-row-number>{{ $index + 1 }}</td>

                                <td class="sticky-name psks-row-title">
                                    <form id="{{ $formId }}" action="{{ route('admin.data.psks.jenis.update') }}" method="POST">
                                        @csrf
                                        <input type="hidden" name="old_jenis_psks" value="{{ $row->jenis_psks }}">
                                        <input type="text" name="jenis_psks" value="{{ $row->jenis_psks }}" required>
                                    </form>
                                </td>

                                @foreach($psksTahunList as $tahun)
                                    <td>
                                        <input
                                            form="{{ $formId }}"
                                            type="number"
                                            name="jumlah[{{ $tahun }}]"
                                            class="year-input"
                                            value="{{ $row->tahun_data[$tahun] ?? 0 }}"
                                            min="0"
                                        >
                                    </td>
                                @endforeach

                                {{--
                                |--------------------------------------------------------------------------
                                | AKSI DATA PSKS
                                |--------------------------------------------------------------------------
                                | Tombol simpan perubahan dan hapus seluruh data berdasarkan jenis PSKS.
                                |--------------------------------------------------------------------------
                                --}}
                                <td class="sticky-action">
                                    <div class="action-button-group">
                                        <button form="{{ $formId }}" type="submit" class="psks-save-btn" title="Simpan">
                                            <i class="fa fa-save"></i>
                                        </button>

                                        <button
                                            form="{{ $formId }}"
                                            type="submit"
                                            class="psks-delete-btn"
                                            title="Hapus"
                                            formaction="{{ route('admin.data.psks.jenis.delete') }}"
                                            formmethod="POST"
                                            onclick="return confirm('Yakin ingin menghapus semua data jenis PSKS ini?')"
                                        >
                                            <i class="fa fa-trash"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            {{--
                            |--------------------------------------------------------------------------
                            | DATA KOSONG
                            |--------------------------------------------------------------------------
                            | Menampilkan pesan ketika belum ada data PSKS.
                            |--------------------------------------------------------------------------
                            --}}
                            <tr>
                                <td colspan="{{ count($psksTahunList) + 3 }}">Belum ada data PSKS.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        {{--
        |--------------------------------------------------------------------------
        | PAGINATION DATA PSKS
        |--------------------------------------------------------------------------
        | Menampilkan navigasi halaman untuk membatasi jumlah baris tabel.
        |--------------------------------------------------------------------------
        --}}
        @if($psksTotalRows > 0)
            <div class="psks-client-pagination" id="psksPagination" data-total="{{ $psksTotalRows }}" data-per-page="10">
                <div class="psks-pagination-info" id="psksPaginationInfo">
                    Menampilkan data PSKS
                </div>

                <div class="psks-pagination-links" id="psksPaginationLinks"></div>
            </div>
        @endif
    </div>
@endif

<script>
    /*
    |--------------------------------------------------------------------------
    | INISIALISASI HALAMAN
    |--------------------------------------------------------------------------
    | Menjalankan fitur tombol scroll dan drag scroll setelah halaman selesai dimuat.
    |--------------------------------------------------------------------------
    */

    document.addEventListener('DOMContentLoaded', function () {

        /*
        |--------------------------------------------------------------------------
        | PAGINATION DATA PSKS
        |--------------------------------------------------------------------------
        | Membagi data tabel PSKS menjadi beberapa halaman seperti halaman PPKS.
        |--------------------------------------------------------------------------
        */

        const psksRows = Array.from(document.querySelectorAll('.psks-data-row'));
        const psksPagination = document.getElementById('psksPagination');
        const psksPaginationInfo = document.getElementById('psksPaginationInfo');
        const psksPaginationLinks = document.getElementById('psksPaginationLinks');

        let psksCurrentPage = 1;
        const psksPerPage = psksPagination ? Number(psksPagination.dataset.perPage || 10) : 10;
        const psksTotalRows = psksRows.length;
        const psksTotalPages = Math.ceil(psksTotalRows / psksPerPage);

        function renderPsksPaginationButton(label, page, options = {}) {
            const button = document.createElement('button');

            button.type = 'button';
            button.textContent = label;
            button.className = 'psks-page-btn';

            if (options.active) {
                button.classList.add('active');
            }

            if (options.disabled) {
                button.classList.add('disabled');
            }

            if (!options.disabled && page) {
                button.addEventListener('click', function () {
                    showPsksPage(page);
                });
            }

            return button;
        }

        function renderPsksPaginationLinks() {
            if (!psksPaginationLinks || psksTotalPages <= 1) {
                return;
            }

            psksPaginationLinks.innerHTML = '';

            psksPaginationLinks.appendChild(
                renderPsksPaginationButton('Previous', psksCurrentPage - 1, {
                    disabled: psksCurrentPage === 1
                })
            );

            let startPage = Math.max(1, psksCurrentPage - 2);
            let endPage = Math.min(psksTotalPages, psksCurrentPage + 2);

            if (startPage > 1) {
                psksPaginationLinks.appendChild(renderPsksPaginationButton('1', 1));

                if (startPage > 2) {
                    psksPaginationLinks.appendChild(
                        renderPsksPaginationButton('...', null, { disabled: true })
                    );
                }
            }

            for (let page = startPage; page <= endPage; page++) {
                psksPaginationLinks.appendChild(
                    renderPsksPaginationButton(String(page), page, {
                        active: page === psksCurrentPage
                    })
                );
            }

            if (endPage < psksTotalPages) {
                if (endPage < psksTotalPages - 1) {
                    psksPaginationLinks.appendChild(
                        renderPsksPaginationButton('...', null, { disabled: true })
                    );
                }

                psksPaginationLinks.appendChild(
                    renderPsksPaginationButton(String(psksTotalPages), psksTotalPages)
                );
            }

            psksPaginationLinks.appendChild(
                renderPsksPaginationButton('Next', psksCurrentPage + 1, {
                    disabled: psksCurrentPage === psksTotalPages
                })
            );
        }

        function showPsksPage(page) {
            if (psksTotalRows === 0) {
                return;
            }

            psksCurrentPage = Math.min(Math.max(page, 1), psksTotalPages);

            const startIndex = (psksCurrentPage - 1) * psksPerPage;
            const endIndex = startIndex + psksPerPage;

            psksRows.forEach(function (row, index) {
                const isVisible = index >= startIndex && index < endIndex;
                row.style.display = isVisible ? '' : 'none';

                if (isVisible) {
                    const numberCell = row.querySelector('[data-row-number]');

                    if (numberCell) {
                        numberCell.textContent = index + 1;
                    }
                }
            });

            if (psksPaginationInfo) {
                const firstShown = startIndex + 1;
                const lastShown = Math.min(endIndex, psksTotalRows);

                psksPaginationInfo.textContent = 'Menampilkan ' + firstShown + ' - ' + lastShown + ' dari ' + psksTotalRows + ' data';
            }

            renderPsksPaginationLinks();

            const area = getScrollArea('psks');

            if (area) {
                area.scrollLeft = 0;
            }
        }

        if (psksPagination && psksTotalPages > 1) {
            showPsksPage(1);
        } else if (psksPagination && psksPaginationInfo) {
            psksPaginationInfo.textContent = psksTotalRows > 0
                ? 'Menampilkan 1 - ' + psksTotalRows + ' dari ' + psksTotalRows + ' data'
                : 'Belum ada data';
        }

        /*
        |--------------------------------------------------------------------------
        | BUTTON SCROLL
        |--------------------------------------------------------------------------
        | Mengatur tombol geser kiri dan kanan pada tabel PSKS.
        |--------------------------------------------------------------------------
        */

        function getScrollArea(type) {
            return document.querySelector('[data-scroll-area="' + type + '"]');
        }

        document.querySelectorAll('[data-scroll-left]').forEach(function (button) {
            button.addEventListener('click', function () {
                const type = button.getAttribute('data-scroll-left');
                const area = getScrollArea(type);

                if (area) {
                    area.scrollBy({
                        left: -520,
                        behavior: 'smooth'
                    });
                }
            });
        });

        document.querySelectorAll('[data-scroll-right]').forEach(function (button) {
            button.addEventListener('click', function () {
                const type = button.getAttribute('data-scroll-right');
                const area = getScrollArea(type);

                if (area) {
                    area.scrollBy({
                        left: 520,
                        behavior: 'smooth'
                    });
                }
            });
        });

        /*
        |--------------------------------------------------------------------------
        | DRAG SCROLL
        |--------------------------------------------------------------------------
        | Mengaktifkan scroll horizontal tabel dengan klik tahan dan geser mouse.
        |--------------------------------------------------------------------------
        */

        document.querySelectorAll('.psks-table-scroll').forEach(function (slider) {
            let isDown = false;
            let startX;
            let scrollLeft;

            slider.addEventListener('mousedown', function (e) {
                isDown = true;
                slider.classList.add('dragging');
                startX = e.pageX - slider.offsetLeft;
                scrollLeft = slider.scrollLeft;
            });

            slider.addEventListener('mouseleave', function () {
                isDown = false;
                slider.classList.remove('dragging');
            });

            slider.addEventListener('mouseup', function () {
                isDown = false;
                slider.classList.remove('dragging');
            });

            slider.addEventListener('mousemove', function (e) {
                if (!isDown) {
                    return;
                }

                e.preventDefault();

                const x = e.pageX - slider.offsetLeft;
                const walk = (x - startX) * 1.4;

                slider.scrollLeft = scrollLeft - walk;
            });
        });
    });
</script>
@endsection