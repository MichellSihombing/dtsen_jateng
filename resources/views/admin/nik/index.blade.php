@extends('admin.layouts.app')

@section('title', 'Kelola Data NIK')
@section('breadcrumb', 'Data NIK')

@section('content')
{{-- STYLE HALAMAN DATA NIK --}}
<style>
    @import url('https://fonts.bunny.net/css?family=inter:400,500,600,700,800,900&display=swap');

    .nik-admin-page,
    .nik-admin-page *,
    .edit-modal-backdrop,
    .edit-modal-backdrop * {
        box-sizing: border-box;
        font-family: 'Inter', ui-sans-serif, system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", sans-serif !important;
    }

    .nik-admin-page {
        width: 100%;
        max-width: 100%;
        overflow-x: hidden;
        color: #0f172a;
        --primary: #2563eb;
        --primary-dark: #1d4ed8;
        --green: #16a34a;
        --line: #dbe4ef;
        --soft: #f8fafc;
        --text-soft: #64748b;
    }

    .nik-card {
        width: 100%;
        max-width: 100%;
        background: #ffffff;
        border: 1px solid rgba(226, 232, 240, 0.95);
        border-radius: 24px;
        padding: 18px;
        margin-bottom: 22px;
        box-shadow: 0 14px 34px rgba(15, 23, 42, 0.065);
        overflow: visible;
    }

    .nik-title {
        font-size: clamp(22px, 1.4vw, 26px);
        font-weight: 850;
        margin-bottom: 8px;
        color: #0f172a;
        letter-spacing: -0.04em;
        line-height: 1.15;
    }

    .nik-subtitle {
        color: var(--text-soft);
        font-size: 13.5px;
        margin-bottom: 18px;
        font-weight: 500;
        line-height: 1.6;
    }

    .alert-modern-error {
        background: #fee2e2;
        color: #991b1b;
        border: 1px solid #fecaca;
        padding: 13px 16px;
        border-radius: 16px;
        font-size: 14px;
        font-weight: 700;
        margin-bottom: 18px;
        line-height: 1.55;
    }

    .alert-modern-error ul {
        margin: 0;
        padding-left: 18px;
    }

    /* GRID FORM UTAMA */
    .nik-main-grid {
        display: grid;
        grid-template-columns: repeat(2, minmax(0, 1fr));
        gap: 14px;
    }

    .nik-wilayah-grid {
        display: grid;
        grid-template-columns: repeat(3, minmax(0, 1fr));
        gap: 14px;
        margin-top: 14px;
    }

    .nik-status-grid {
        display: grid;
        grid-template-columns: minmax(0, 1fr) minmax(160px, 210px);
        gap: 14px;
        margin-top: 14px;
        align-items: end;
    }

    .nik-button-row {
        margin-top: 14px;
        display: flex;
        justify-content: flex-end;
    }

    .nik-detail-grid {
        display: grid;
        grid-template-columns: repeat(2, minmax(0, 1fr));
        gap: 14px;
        margin-top: 14px;
    }

    .input-group {
        display: flex;
        flex-direction: column;
        gap: 7px;
        min-width: 0;
    }

    .input-label {
        font-size: 12.5px;
        font-weight: 760;
        color: #475569;
        line-height: 1.3;
    }

    .input-modern {
        width: 100%;
        min-width: 0;
        height: 46px;
        border: 1px solid var(--line);
        border-radius: 14px;
        padding: 0 14px;
        outline: none;
        background: #ffffff;
        font-size: 13.5px;
        color: #0f172a;
        font-weight: 650;
        line-height: 1.35;
        transition: 0.22s ease;
    }

    .input-modern:focus {
        border-color: var(--primary);
        box-shadow: 0 0 0 5px rgba(37, 99, 235, 0.10);
        transform: translateY(-1px);
    }

    .input-modern::placeholder {
        color: #94a3b8;
        font-weight: 500;
    }

    textarea.input-modern {
        height: auto;
        min-height: 82px;
        padding: 12px 14px;
        resize: vertical;
        line-height: 1.55;
    }

    /* CUSTOM SELECT */
    .select-modern {
        position: relative;
        width: 100%;
        min-width: 0;
        z-index: 10;
    }

    .select-modern.is-open {
        z-index: 9999;
    }

    .select-modern.is-disabled {
        opacity: 0.72;
        pointer-events: none;
    }

    .select-trigger {
        width: 100%;
        height: 46px;
        border: 1px solid var(--line);
        border-radius: 14px;
        background: #ffffff;
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 12px;
        padding: 0 12px 0 14px;
        cursor: pointer;
        transition: 0.22s ease;
        box-shadow: 0 8px 18px rgba(15, 23, 42, 0.025);
    }

    .select-trigger:hover {
        border-color: #93c5fd;
        box-shadow: 0 10px 24px rgba(37, 99, 235, 0.08);
        transform: translateY(-1px);
    }

    .select-modern.is-open .select-trigger {
        border-color: var(--primary);
        box-shadow: 0 0 0 5px rgba(37, 99, 235, 0.10), 0 16px 34px rgba(15, 23, 42, 0.11);
    }

    .select-label {
        overflow: hidden;
        white-space: nowrap;
        text-overflow: ellipsis;
        color: #0f172a;
        font-size: 13.5px;
        font-weight: 750;
        line-height: 1.2;
    }

    .select-label.placeholder {
        color: #64748b;
        font-weight: 650;
    }

    .select-arrow {
        width: 30px;
        height: 30px;
        border-radius: 999px;
        background: #eff6ff;
        display: grid;
        place-items: center;
        color: var(--primary);
        flex: 0 0 auto;
        transition: 0.22s ease;
        font-size: 12px;
        font-weight: 900;
    }

    .select-modern.is-open .select-arrow {
        background: var(--primary);
        color: #ffffff;
        transform: rotate(180deg);
    }

    .select-menu {
        position: absolute;
        top: calc(100% + 8px);
        left: 0;
        right: 0;
        background: rgba(255, 255, 255, 0.98);
        border: 1px solid #dbeafe;
        border-radius: 18px;
        box-shadow: 0 26px 70px rgba(15, 23, 42, 0.18);
        padding: 10px;
        visibility: hidden;
        opacity: 0;
        transform: translateY(-8px) scale(0.98);
        transform-origin: top center;
        transition: 0.22s cubic-bezier(.2, .8, .2, 1);
        backdrop-filter: blur(14px);
    }

    .select-modern.is-open .select-menu {
        visibility: visible;
        opacity: 1;
        transform: translateY(0) scale(1);
    }

    .select-search-wrap {
        position: relative;
        margin-bottom: 8px;
    }

    .select-search-wrap::before {
        content: "⌕";
        position: absolute;
        top: 50%;
        left: 13px;
        transform: translateY(-50%);
        color: #60a5fa;
        font-size: 17px;
        font-weight: 900;
        pointer-events: none;
        line-height: 1;
    }

    .select-search {
        width: 100%;
        height: 40px;
        border: 1px solid #dbeafe;
        border-radius: 13px;
        background: #f8fbff;
        outline: none;
        padding: 0 12px 0 38px;
        color: #0f172a;
        font-size: 13px;
        font-weight: 650;
        transition: 0.2s ease;
    }

    .select-search:focus {
        border-color: var(--primary);
        background: #ffffff;
        box-shadow: 0 0 0 4px rgba(37, 99, 235, 0.08);
    }

    .select-options {
        max-height: 238px;
        overflow-y: auto;
        padding-right: 3px;
    }

    .select-options::-webkit-scrollbar {
        width: 7px;
    }

    .select-options::-webkit-scrollbar-track {
        background: #e2e8f0;
        border-radius: 999px;
    }

    .select-options::-webkit-scrollbar-thumb {
        background: #94a3b8;
        border-radius: 999px;
    }

    .select-option {
        min-height: 40px;
        padding: 10px 12px;
        border-radius: 12px;
        cursor: pointer;
        color: #334155;
        font-size: 13px;
        font-weight: 750;
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 10px;
        transition: 0.16s ease;
        line-height: 1.25;
    }

    .select-option:hover {
        background: #eff6ff;
        color: var(--primary);
        transform: translateX(3px);
    }

    .select-option.is-selected {
        background: linear-gradient(135deg, #2563eb, #0ea5e9);
        color: #ffffff;
        box-shadow: 0 12px 24px rgba(37, 99, 235, 0.18);
    }

    .select-option.is-selected::after {
        content: "✓";
        width: 22px;
        height: 22px;
        border-radius: 999px;
        background: rgba(255, 255, 255, 0.20);
        display: grid;
        place-items: center;
        font-size: 11px;
        flex: 0 0 auto;
    }

    .select-empty {
        display: none;
        padding: 14px 10px;
        color: #64748b;
        font-size: 13px;
        font-weight: 700;
        text-align: center;
    }

    .select-modern.no-result .select-empty,
    .select-empty.show {
        display: block;
    }

    /* TOMBOL DETAIL TAMBAHAN */
    .detail-toggle {
        margin-top: 16px;
        border: none;
        background: #eff6ff;
        color: var(--primary);
        border-radius: 999px;
        padding: 10px 15px;
        font-size: 13.5px;
        font-weight: 760;
        cursor: pointer;
        transition: 0.2s ease;
    }

    .detail-toggle:hover {
        background: #dbeafe;
        transform: translateY(-1px);
    }

    .detail-area {
        display: none;
        animation: fadeUp 0.22s ease both;
    }

    .detail-area.show {
        display: block;
    }

    /* BUTTON */
    .btn-modern {
        border: none;
        border-radius: 14px;
        padding: 0 16px;
        font-size: 13.5px;
        font-weight: 760;
        cursor: pointer;
        transition: 0.22s ease;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        white-space: nowrap;
        min-height: 46px;
        line-height: 1.2;
    }

    .btn-modern:hover {
        transform: translateY(-2px);
    }

    .btn-green {
        background: var(--green);
        color: #ffffff;
        box-shadow: 0 14px 24px rgba(22, 163, 74, 0.20);
    }

    .btn-green:hover {
        background: #15803d;
    }

    .btn-blue {
        background: linear-gradient(135deg, #2563eb, #0ea5e9);
        color: #ffffff;
        box-shadow: 0 14px 24px rgba(37, 99, 235, 0.20);
    }

    .btn-gray {
        background: #eef2f7;
        color: #334155;
    }

    .btn-add-nik {
        min-width: 190px;
    }

    /* SEARCH DATA */
    .search-row {
        display: grid;
        grid-template-columns: minmax(0, 1fr) 84px 84px;
        gap: 10px;
        margin-bottom: 16px;
        align-items: center;
    }

    /* TABEL DATA NIK */
    .table-scroll-note {
        margin-bottom: 10px;
        color: #64748b;
        font-size: 12.5px;
        font-weight: 700;
    }

    .table-wrap {
        width: 100%;
        max-width: 100%;
        overflow-x: auto;
        overflow-y: hidden;
        border-radius: 20px;
        border: 1px solid #e5eaf1;
        -webkit-overflow-scrolling: touch;
        scrollbar-width: thin;
        scrollbar-color: #94a3b8 #e2e8f0;
    }

    .table-wrap::-webkit-scrollbar {
        height: 8px;
    }

    .table-wrap::-webkit-scrollbar-track {
        background: #e2e8f0;
        border-radius: 999px;
    }

    .table-wrap::-webkit-scrollbar-thumb {
        background: #94a3b8;
        border-radius: 999px;
    }

    .nik-table {
        width: 100%;
        min-width: 0;
        border-collapse: collapse;
        font-size: 12px;
        background: #ffffff;
        line-height: 1.42;
        table-layout: auto;
    }

    .nik-table th {
        background: #f8fafc;
        padding: 10px 7px;
        text-align: left;
        color: #475569;
        font-size: 10.5px;
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: 0.025em;
        border-bottom: 1px solid #e5eaf1;
        white-space: nowrap;
        line-height: 1.25;
    }

    .nik-table td {
        padding: 10px 7px;
        border-bottom: 1px solid #eef2f7;
        vertical-align: middle;
        color: #334155;
        font-weight: 560;
        white-space: normal;
        word-break: break-word;
        font-size: 11.5px;
    }

    .nik-table td strong {
        color: #0f172a;
        font-weight: 800;
    }

    .nik-table tr:hover {
        background: #f8fafc;
    }

    .col-no { width: 36px; }
    .col-nik { width: 130px; }
    .col-nama { width: 90px; }
    .col-jk { width: 62px; }
    .col-tgl { width: 84px; }
    .col-wilayah { width: 155px; }
    .col-status { width: 88px; }
    .col-desil { width: 78px; }
    .col-ket { width: 76px; }
    .col-aksi { width: 80px; }

    .badge-status {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        padding: 5px 8px;
        border-radius: 999px;
        font-size: 10.5px;
        font-weight: 800;
        line-height: 1.2;
        white-space: nowrap;
    }

    .badge-terdata {
        background: #dcfce7;
        color: #166534;
    }

    .badge-tidak {
        background: #fee2e2;
        color: #991b1b;
    }

    .badge-verifikasi {
        background: #fef3c7;
        color: #92400e;
    }

    .badge-desil {
        background: #e0f2fe;
        color: #075985;
    }

    .action-row {
        display: flex;
        flex-direction: column;
        gap: 5px;
        align-items: stretch;
        justify-content: center;
    }

    .btn-edit-icon,
    .btn-delete-icon {
        width: 100%;
        min-width: 0;
        height: 30px;
        min-height: 30px;
        border-radius: 10px;
        padding: 0 8px;
        font-size: 11px;
    }

    .btn-edit-icon {
        background: #dbeafe;
        color: #1d4ed8;
    }

    .btn-edit-icon:hover {
        background: var(--primary);
        color: #ffffff;
        box-shadow: 0 12px 20px rgba(37, 99, 235, 0.20);
    }

    .btn-delete-icon {
        background: #fee2e2;
        color: #991b1b;
    }

    .btn-delete-icon:hover {
        background: #dc2626;
        color: #ffffff;
        box-shadow: 0 12px 20px rgba(220, 38, 38, 0.20);
    }

    .empty-state {
        padding: 36px;
        text-align: center;
        color: #64748b;
        line-height: 1.6;
        font-weight: 500;
    }

    .empty-state strong {
        color: #0f172a;
        font-weight: 780;
    }

    .empty-icon {
        width: 68px;
        height: 68px;
        display: grid;
        place-items: center;
        margin: 0 auto 14px;
        border-radius: 24px;
        background: #eef5ff;
        color: var(--primary);
        font-size: 22px;
        font-weight: 800;
    }

    /* MODAL EDIT DATA */
    .edit-modal-backdrop {
        position: fixed;
        inset: 0;
        background: rgba(15, 23, 42, 0.58);
        backdrop-filter: blur(8px);
        z-index: 999999;
        display: none;
        align-items: flex-start;
        justify-content: center;
        padding: 40px 20px 20px;
        overflow-y: auto;
    }

    .edit-modal-backdrop.show {
        display: flex;
    }

    .edit-modal {
        width: 880px;
        max-width: 100%;
        flex-shrink: 0;
        margin: 0 auto;
        overflow-y: auto;
        background: #ffffff;
        border-radius: 28px;
        box-shadow: 0 30px 90px rgba(15, 23, 42, 0.35);
        animation: modalPop 0.2s ease both;
    }

    .edit-modal-header {
        padding: 24px;
        border-bottom: 1px solid #eef2f7;
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 16px;
    }

    .edit-modal-title {
        font-size: 22px;
        font-weight: 850;
        color: #0f172a;
        letter-spacing: -0.04em;
        line-height: 1.2;
    }

    .edit-modal-close {
        width: 38px;
        height: 38px;
        border: none;
        border-radius: 999px;
        background: #f1f5f9;
        color: #0f172a;
        font-weight: 900;
        cursor: pointer;
        font-size: 18px;
        line-height: 1;
        flex-shrink: 0;
    }

    .edit-modal-body {
        padding: 24px;
    }

    .edit-modal-footer {
        padding: 20px 24px;
        border-top: 1px solid #eef2f7;
        display: flex;
        justify-content: flex-end;
        gap: 10px;
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

    @keyframes modalPop {
        from {
            opacity: 0;
            transform: translateY(20px) scale(0.96);
        }

        to {
            opacity: 1;
            transform: translateY(0) scale(1);
        }
    }

    /* RESPONSIVE TABLET */
    @media (max-width: 1360px) {
        .nik-card {
            padding: 20px;
        }

        .nik-main-grid,
        .nik-wilayah-grid,
        .nik-status-grid,
        .nik-detail-grid {
            grid-template-columns: 1fr;
        }

        .nik-button-row {
            justify-content: stretch;
        }

        .btn-add-nik {
            width: 100%;
            min-width: 0;
        }
    }

    /* RESPONSIVE MOBILE */
    @media (max-width: 720px) {
        .nik-card {
            padding: 16px;
            border-radius: 20px;
        }

        .search-row {
            grid-template-columns: 1fr;
        }

        .btn-modern {
            width: 100%;
        }

        .edit-modal-footer {
            flex-direction: column;
        }

        .edit-modal {
            border-radius: 22px;
        }

        .nik-title {
            font-size: 22px;
        }

        .select-menu {
            position: fixed;
            left: 16px;
            right: 16px;
            top: auto;
            bottom: 16px;
            max-height: 70vh;
        }

        .select-options {
            max-height: 48vh;
        }
    }
</style>

{{-- HALAMAN UTAMA DATA NIK --}}
<div class="nik-admin-page">
    @if($errors->any())
        {{-- PESAN ERROR VALIDASI --}}
        <div class="alert-modern-error">
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- CARD FORM TAMBAH DATA NIK --}}
    <div class="nik-card">
        <div class="nik-title">Tambah Data NIK</div>
        <div class="nik-subtitle">
            Silahkan isi data utama. Untuk detail tambahan dapat dibuka jika memang diperlukan.
        </div>

        <form action="{{ route('admin.nik.store') }}" method="POST" id="nik-form">
            @csrf

            {{-- INPUT DATA UTAMA --}}
            <div class="nik-main-grid">
                <div class="input-group">
                    <label class="input-label">NIK *</label>
                    <input
                        class="input-modern nik-only"
                        name="nik"
                        placeholder="Masukkan NIK 16 digit"
                        maxlength="16"
                        value="{{ old('nik') }}"
                        required
                    >
                </div>

                <div class="input-group">
                    <label class="input-label">Nama Lengkap *</label>
                    <input
                        class="input-modern"
                        name="nama_lengkap"
                        placeholder="Masukkan nama lengkap"
                        value="{{ old('nama_lengkap') }}"
                        required
                    >
                </div>
            </div>

            {{-- INPUT WILAYAH --}}
            <div class="nik-wilayah-grid">
                <div class="input-group">
                    <label class="input-label">Kabupaten/Kota *</label>
                    <input type="hidden" name="kabupaten_id" id="kabupaten_id" value="{{ old('kabupaten_id') }}" required>

                    <div class="select-modern" data-select="kabupaten_id" data-placeholder="Pilih Kabupaten/Kota">
                        <button type="button" class="select-trigger">
                            <span class="select-label placeholder">Pilih Kabupaten/Kota</span>
                            <span class="select-arrow">⌄</span>
                        </button>

                        <div class="select-menu">
                            <div class="select-search-wrap">
                                <input type="text" class="select-search" placeholder="Cari kabupaten/kota...">
                            </div>

                            <div class="select-options">
                                @foreach($kabupatens ?? [] as $kabupaten)
                                    <div
                                        class="select-option"
                                        data-value="{{ $kabupaten->id }}"
                                        data-label="{{ $kabupaten->nama_kabupaten ?? $kabupaten->nama ?? '-' }}"
                                    >
                                        {{ $kabupaten->nama_kabupaten ?? $kabupaten->nama ?? '-' }}
                                    </div>
                                @endforeach

                                <div class="select-empty">Data tidak ditemukan</div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="input-group">
                    <label class="input-label">Kecamatan *</label>
                    <input type="hidden" name="kecamatan_id" id="kecamatan_id" value="{{ old('kecamatan_id') }}" required>

                    <div class="select-modern is-disabled" data-select="kecamatan_id" data-placeholder="Pilih Kabupaten dulu">
                        <button type="button" class="select-trigger">
                            <span class="select-label placeholder">Pilih Kabupaten dulu</span>
                            <span class="select-arrow">⌄</span>
                        </button>

                        <div class="select-menu">
                            <div class="select-search-wrap">
                                <input type="text" class="select-search" placeholder="Cari kecamatan...">
                            </div>

                            <div class="select-options">
                                <div class="select-empty show">Pilih kabupaten dulu</div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="input-group">
                    <label class="input-label">Desa/Kelurahan *</label>
                    <input type="hidden" name="desa_id" id="desa_id" value="{{ old('desa_id') }}" required>

                    <div class="select-modern is-disabled" data-select="desa_id" data-placeholder="Pilih Kecamatan dulu">
                        <button type="button" class="select-trigger">
                            <span class="select-label placeholder">Pilih Kecamatan dulu</span>
                            <span class="select-arrow">⌄</span>
                        </button>

                        <div class="select-menu">
                            <div class="select-search-wrap">
                                <input type="text" class="select-search" placeholder="Cari desa/kelurahan...">
                            </div>

                            <div class="select-options">
                                <div class="select-empty show">Pilih kecamatan dulu</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- INPUT STATUS DAN DESIL --}}
            <div class="nik-status-grid">
                <div class="input-group">
                    <label class="input-label">Status DTSEN *</label>
                    <input type="hidden" name="status_dtsen" id="status_dtsen" value="{{ old('status_dtsen', 'Terdata') }}" required>

                    <div class="select-modern" data-select="status_dtsen" data-placeholder="Pilih Status DTSEN">
                        <button type="button" class="select-trigger">
                            <span class="select-label placeholder">Pilih Status DTSEN</span>
                            <span class="select-arrow">⌄</span>
                        </button>

                        <div class="select-menu">
                            <div class="select-search-wrap">
                                <input type="text" class="select-search" placeholder="Cari status...">
                            </div>

                            <div class="select-options">
                                <div class="select-option" data-value="Terdata" data-label="Terdata">Terdata</div>
                                <div class="select-option" data-value="Tidak Terdata" data-label="Tidak Terdata">Tidak Terdata</div>
                                <div class="select-option" data-value="Perlu Verifikasi" data-label="Perlu Verifikasi">Perlu Verifikasi</div>
                                <div class="select-empty">Data tidak ditemukan</div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="input-group">
                    <label class="input-label">Desil Nasional *</label>
                    <input type="hidden" name="desil_nasional" id="desil_nasional" value="{{ old('desil_nasional', 1) }}" required>

                    <div class="select-modern" data-select="desil_nasional" data-placeholder="Pilih Desil Nasional">
                        <button type="button" class="select-trigger">
                            <span class="select-label placeholder">Pilih Desil Nasional</span>
                            <span class="select-arrow">⌄</span>
                        </button>

                        <div class="select-menu">
                            <div class="select-search-wrap">
                                <input type="text" class="select-search" placeholder="Cari desil...">
                            </div>

                            <div class="select-options">
                                @for($i = 1; $i <= 10; $i++)
                                    <div class="select-option" data-value="{{ $i }}" data-label="Desil {{ $i }}">
                                        Desil {{ $i }}
                                    </div>
                                @endfor
                                <div class="select-empty">Data tidak ditemukan</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- TOMBOL TAMBAH DATA --}}
            <div class="nik-button-row">
                <button class="btn-modern btn-green btn-add-nik" type="submit">
                    + Tambah Data NIK
                </button>
            </div>

            {{-- DETAIL TAMBAHAN --}}
            <button type="button" class="detail-toggle" id="detailToggle">
                + Detail Tambahan
            </button>

            <div class="detail-area" id="detailArea">
                <div class="nik-detail-grid">
                    <div class="input-group">
                        <label class="input-label">Jenis Kelamin</label>
                        <input type="hidden" name="jenis_kelamin" id="jenis_kelamin" value="{{ old('jenis_kelamin') }}">

                        <div class="select-modern" data-select="jenis_kelamin" data-placeholder="Pilih Jenis Kelamin">
                            <button type="button" class="select-trigger">
                                <span class="select-label placeholder">Pilih Jenis Kelamin</span>
                                <span class="select-arrow">⌄</span>
                            </button>

                            <div class="select-menu">
                                <div class="select-search-wrap">
                                    <input type="text" class="select-search" placeholder="Cari jenis kelamin...">
                                </div>

                                <div class="select-options">
                                    <div class="select-option" data-value="" data-label="Tidak dipilih">Tidak dipilih</div>
                                    <div class="select-option" data-value="Laki-laki" data-label="Laki-laki">Laki-laki</div>
                                    <div class="select-option" data-value="Perempuan" data-label="Perempuan">Perempuan</div>
                                    <div class="select-empty">Data tidak ditemukan</div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="input-group">
                        <label class="input-label">Tanggal Lahir</label>
                        <input
                            class="input-modern"
                            type="date"
                            name="tanggal_lahir"
                            value="{{ old('tanggal_lahir') }}"
                        >
                    </div>

                    <div class="input-group">
                        <label class="input-label">Alamat</label>
                        <textarea
                            class="input-modern"
                            name="alamat"
                            placeholder="Alamat"
                        >{{ old('alamat') }}</textarea>
                    </div>

                    <div class="input-group">
                        <label class="input-label">Keterangan</label>
                        <textarea
                            class="input-modern"
                            name="keterangan"
                            placeholder="Keterangan"
                        >{{ old('keterangan') }}</textarea>
                    </div>
                </div>
            </div>
        </form>
    </div>

    {{-- CARD TABEL DATA NIK --}}
    <div class="nik-card">
        <div class="nik-title">Data NIK</div>
        <div class="nik-subtitle">
            Data NIK yang tersimpan dan bisa digunakan untuk pengecekan pada halaman beranda.
        </div>

        {{-- FORM PENCARIAN --}}
        <form method="GET" class="search-row">
            <input
                class="input-modern"
                name="search"
                value="{{ $search ?? request('search') }}"
                placeholder="Cari NIK / Nama / Wilayah / Status / Desil"
            >

            <button class="btn-modern btn-blue" type="submit">
                Cari
            </button>

            <a href="{{ route('admin.nik.index') }}" class="btn-modern btn-gray">
                Reset
            </a>
        </form>
        {{-- TABEL DATA --}}
        <div class="table-wrap">
            <table class="nik-table">
                <thead>
                    <tr>
                        <th class="col-no">No</th>
                        <th class="col-nik">NIK</th>
                        <th class="col-nama">Nama</th>
                        <th class="col-jk">JK</th>
                        <th class="col-tgl">Tanggal Lahir</th>
                        <th class="col-wilayah">Wilayah</th>
                        <th class="col-status">Status</th>
                        <th class="col-desil">Desil Nasional</th>
                        <th class="col-ket">Keterangan</th>
                        <th class="col-aksi">Aksi</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($items as $item)
                        <tr>
                            <td>{{ $loop->iteration + (($items->currentPage() - 1) * $items->perPage()) }}</td>

                            <td>
                                <strong>{{ $item->nik }}</strong>
                            </td>

                            <td>{{ $item->nama_lengkap ?? '-' }}</td>

                            <td>{{ $item->jenis_kelamin ?? '-' }}</td>

                            <td>
                                {{ $item->tanggal_lahir ? $item->tanggal_lahir->format('d-m-Y') : '-' }}
                            </td>

                            <td>
                                <strong>{{ $item->kabupaten?->nama_kabupaten ?? '-' }}</strong><br>
                                {{ $item->kecamatan?->nama_kecamatan ?? '-' }}<br>
                                {{ $item->desa?->nama_desa ?? '-' }}
                            </td>

                            <td>
                                @if($item->status_dtsen === 'Terdata')
                                    <span class="badge-status badge-terdata">Terdata</span>
                                @elseif($item->status_dtsen === 'Tidak Terdata')
                                    <span class="badge-status badge-tidak">Tidak Terdata</span>
                                @else
                                    <span class="badge-status badge-verifikasi">Perlu Verifikasi</span>
                                @endif
                            </td>

                            <td>
                                <span class="badge-status badge-desil">
                                    Desil {{ $item->desil_nasional ?? 1 }}
                                </span>
                            </td>

                            <td>{{ $item->keterangan ?? '-' }}</td>

                            <td>
                                <div class="action-row">
                                    <button
                                        class="btn-modern btn-edit-icon"
                                        type="button"
                                        onclick='openEditModal(@json($item))'
                                    >
                                        Edit
                                    </button>

                                    <form
                                        action="{{ route('admin.nik.destroy', $item->id) }}"
                                        method="POST"
                                        onsubmit="return confirm('Yakin hapus data NIK ini?')"
                                    >
                                        @csrf
                                        @method('DELETE')

                                        <button class="btn-modern btn-delete-icon" type="submit">
                                            Hapus
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="10">
                                <div class="empty-state">
                                    <div class="empty-icon">ID</div>
                                    <strong>Belum ada data NIK</strong>
                                    <div>Tambahkan data NIK melalui form di atas.</div>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- PAGINATION --}}
        @if($items && method_exists($items, 'links'))
            <div style="margin-top: 18px;">
                {{ $items->links() }}
            </div>
        @endif
    </div>
</div>

{{-- MODAL EDIT DATA NIK --}}
<div class="edit-modal-backdrop" id="editModalBackdrop">
    <div class="edit-modal">
        <form method="POST" id="editForm">
            @csrf
            @method('PUT')

            <div class="edit-modal-header">
                <div class="edit-modal-title">Edit Data NIK</div>
                <button type="button" class="edit-modal-close" onclick="closeEditModal()">×</button>
            </div>

            <div class="edit-modal-body">
                {{-- INPUT UTAMA EDIT --}}
                <div class="nik-main-grid">
                    <div class="input-group">
                        <label class="input-label">NIK *</label>
                        <input class="input-modern nik-only" name="nik" id="edit_nik" maxlength="16" required>
                    </div>

                    <div class="input-group">
                        <label class="input-label">Nama Lengkap *</label>
                        <input class="input-modern" name="nama_lengkap" id="edit_nama_lengkap" required>
                    </div>
                </div>

                {{-- INPUT WILAYAH EDIT --}}
                <div class="nik-wilayah-grid">
                    <div class="input-group">
                        <label class="input-label">Kabupaten/Kota *</label>
                        <input type="hidden" name="kabupaten_id" id="edit_kabupaten_id" required>

                        <div class="select-modern" data-select="edit_kabupaten_id" data-placeholder="Pilih Kabupaten/Kota">
                            <button type="button" class="select-trigger">
                                <span class="select-label placeholder">Pilih Kabupaten/Kota</span>
                                <span class="select-arrow">⌄</span>
                            </button>

                            <div class="select-menu">
                                <div class="select-search-wrap">
                                    <input type="text" class="select-search" placeholder="Cari kabupaten/kota...">
                                </div>

                                <div class="select-options">
                                    @foreach($kabupatens ?? [] as $kabupaten)
                                        <div
                                            class="select-option"
                                            data-value="{{ $kabupaten->id }}"
                                            data-label="{{ $kabupaten->nama_kabupaten ?? $kabupaten->nama ?? '-' }}"
                                        >
                                            {{ $kabupaten->nama_kabupaten ?? $kabupaten->nama ?? '-' }}
                                        </div>
                                    @endforeach

                                    <div class="select-empty">Data tidak ditemukan</div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="input-group">
                        <label class="input-label">Kecamatan *</label>
                        <input type="hidden" name="kecamatan_id" id="edit_kecamatan_id" required>

                        <div class="select-modern is-disabled" data-select="edit_kecamatan_id" data-placeholder="Pilih Kabupaten dulu">
                            <button type="button" class="select-trigger">
                                <span class="select-label placeholder">Pilih Kabupaten dulu</span>
                                <span class="select-arrow">⌄</span>
                            </button>

                            <div class="select-menu">
                                <div class="select-search-wrap">
                                    <input type="text" class="select-search" placeholder="Cari kecamatan...">
                                </div>

                                <div class="select-options">
                                    <div class="select-empty show">Pilih kabupaten dulu</div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="input-group">
                        <label class="input-label">Desa/Kelurahan *</label>
                        <input type="hidden" name="desa_id" id="edit_desa_id" required>

                        <div class="select-modern is-disabled" data-select="edit_desa_id" data-placeholder="Pilih Kecamatan dulu">
                            <button type="button" class="select-trigger">
                                <span class="select-label placeholder">Pilih Kecamatan dulu</span>
                                <span class="select-arrow">⌄</span>
                            </button>

                            <div class="select-menu">
                                <div class="select-search-wrap">
                                    <input type="text" class="select-search" placeholder="Cari desa/kelurahan...">
                                </div>

                                <div class="select-options">
                                    <div class="select-empty show">Pilih kecamatan dulu</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- INPUT STATUS EDIT --}}
                <div class="nik-status-grid">
                    <div class="input-group">
                        <label class="input-label">Status DTSEN *</label>
                        <input type="hidden" name="status_dtsen" id="edit_status_dtsen" required>

                        <div class="select-modern" data-select="edit_status_dtsen" data-placeholder="Pilih Status DTSEN">
                            <button type="button" class="select-trigger">
                                <span class="select-label placeholder">Pilih Status DTSEN</span>
                                <span class="select-arrow">⌄</span>
                            </button>

                            <div class="select-menu">
                                <div class="select-search-wrap">
                                    <input type="text" class="select-search" placeholder="Cari status...">
                                </div>

                                <div class="select-options">
                                    <div class="select-option" data-value="Terdata" data-label="Terdata">Terdata</div>
                                    <div class="select-option" data-value="Tidak Terdata" data-label="Tidak Terdata">Tidak Terdata</div>
                                    <div class="select-option" data-value="Perlu Verifikasi" data-label="Perlu Verifikasi">Perlu Verifikasi</div>
                                    <div class="select-empty">Data tidak ditemukan</div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="input-group">
                        <label class="input-label">Desil Nasional *</label>
                        <input type="hidden" name="desil_nasional" id="edit_desil_nasional" required>

                        <div class="select-modern" data-select="edit_desil_nasional" data-placeholder="Pilih Desil Nasional">
                            <button type="button" class="select-trigger">
                                <span class="select-label placeholder">Pilih Desil Nasional</span>
                                <span class="select-arrow">⌄</span>
                            </button>

                            <div class="select-menu">
                                <div class="select-search-wrap">
                                    <input type="text" class="select-search" placeholder="Cari desil...">
                                </div>

                                <div class="select-options">
                                    @for($i = 1; $i <= 10; $i++)
                                        <div class="select-option" data-value="{{ $i }}" data-label="Desil {{ $i }}">
                                            Desil {{ $i }}
                                        </div>
                                    @endfor
                                    <div class="select-empty">Data tidak ditemukan</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- INPUT DETAIL EDIT --}}
                <div class="nik-detail-grid">
                    <div class="input-group">
                        <label class="input-label">Jenis Kelamin</label>
                        <input type="hidden" name="jenis_kelamin" id="edit_jenis_kelamin">

                        <div class="select-modern" data-select="edit_jenis_kelamin" data-placeholder="Pilih Jenis Kelamin">
                            <button type="button" class="select-trigger">
                                <span class="select-label placeholder">Pilih Jenis Kelamin</span>
                                <span class="select-arrow">⌄</span>
                            </button>

                            <div class="select-menu">
                                <div class="select-search-wrap">
                                    <input type="text" class="select-search" placeholder="Cari jenis kelamin...">
                                </div>

                                <div class="select-options">
                                    <div class="select-option" data-value="" data-label="Tidak dipilih">Tidak dipilih</div>
                                    <div class="select-option" data-value="Laki-laki" data-label="Laki-laki">Laki-laki</div>
                                    <div class="select-option" data-value="Perempuan" data-label="Perempuan">Perempuan</div>
                                    <div class="select-empty">Data tidak ditemukan</div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="input-group">
                        <label class="input-label">Tanggal Lahir</label>
                        <input class="input-modern" type="date" name="tanggal_lahir" id="edit_tanggal_lahir">
                    </div>

                    <div class="input-group">
                        <label class="input-label">Alamat</label>
                        <textarea class="input-modern" name="alamat" id="edit_alamat"></textarea>
                    </div>

                    <div class="input-group">
                        <label class="input-label">Keterangan</label>
                        <textarea class="input-modern" name="keterangan" id="edit_keterangan"></textarea>
                    </div>
                </div>
            </div>

            {{-- TOMBOL MODAL --}}
            <div class="edit-modal-footer">
                <button type="button" class="btn-modern btn-gray" onclick="closeEditModal()">
                    Batal
                </button>

                <button type="submit" class="btn-modern btn-blue">
                    Simpan Perubahan
                </button>
            </div>
        </form>
    </div>
</div>

{{-- SCRIPT HALAMAN DATA NIK --}}
<script>
    const oldKabupatenId = @json(old('kabupaten_id'));
    const oldKecamatanId = @json(old('kecamatan_id'));
    const oldDesaId = @json(old('desa_id'));

    // Membatasi input agar hanya berisi angka.
    function onlyDigits(value, maxLength = 16) {
        return String(value || '').replace(/\D/g, '').slice(0, maxLength);
    }

    // Mengambil nama kecamatan dari beberapa kemungkinan field.
    function getNamaKecamatan(item) {
        return item.nama_kecamatan || item.nama || item.nama_wilayah || '-';
    }

    // Mengambil nama desa dari beberapa kemungkinan field.
    function getNamaDesa(item) {
        return item.nama_desa || item.nama || item.nama_wilayah || '-';
    }

    // Menutup semua dropdown kecuali dropdown yang sedang aktif.
    function closeAllSelects(except = null) {
        document.querySelectorAll('.select-modern.is-open').forEach(function(select) {
            if (select !== except) {
                select.classList.remove('is-open');
            }
        });
    }

    // Mengambil elemen custom select berdasarkan nama input.
    function getSelectElement(name) {
        return document.querySelector(`.select-modern[data-select="${name}"]`);
    }

    // Mengambil hidden input berdasarkan id.
    function getHiddenInput(name) {
        return document.getElementById(name);
    }

    // Mengisi nilai custom select dan hidden input.
    function setCustomSelectValue(name, value, label = null) {
        const select = getSelectElement(name);
        const input = getHiddenInput(name);

        if (!select || !input) return;

        const labelEl = select.querySelector('.select-label');
        const options = select.querySelectorAll('.select-option');

        input.value = value ?? '';

        options.forEach(function(option) {
            option.classList.remove('is-selected');

            if (String(option.dataset.value) === String(value ?? '')) {
                option.classList.add('is-selected');

                if (!label) {
                    label = option.dataset.label;
                }
            }
        });

        if (label && String(value ?? '') !== '') {
            labelEl.textContent = label;
            labelEl.classList.remove('placeholder');
        } else if (label && String(value ?? '') === '') {
            labelEl.textContent = label;
            labelEl.classList.remove('placeholder');
        } else {
            labelEl.textContent = select.dataset.placeholder || 'Pilih data';
            labelEl.classList.add('placeholder');
        }
    }

    // Mengosongkan custom select dan mengatur status disabled.
    function resetCustomSelect(name, placeholder, disabled = true) {
        const select = getSelectElement(name);
        const input = getHiddenInput(name);

        if (!select || !input) return;

        input.value = '';

        select.dataset.placeholder = placeholder;
        select.classList.toggle('is-disabled', disabled);
        select.classList.remove('is-open', 'no-result');

        const labelEl = select.querySelector('.select-label');
        const optionsBox = select.querySelector('.select-options');
        const search = select.querySelector('.select-search');

        labelEl.textContent = placeholder;
        labelEl.classList.add('placeholder');

        if (search) {
            search.value = '';
        }

        if (optionsBox) {
            optionsBox.innerHTML = `<div class="select-empty show">${placeholder}</div>`;
        }
    }

    // Membuat pilihan dropdown dari data API.
    function buildCustomOptions(name, items, placeholder, labelGetter, selectedValue = null) {
        const select = getSelectElement(name);
        const optionsBox = select?.querySelector('.select-options');

        if (!select || !optionsBox) return;

        select.classList.remove('is-disabled', 'no-result');
        select.dataset.placeholder = placeholder;

        if (!items || items.length === 0) {
            optionsBox.innerHTML = `<div class="select-empty show">Data tidak ditemukan</div>`;
            setCustomSelectValue(name, '', placeholder);
            return;
        }

        let html = '';

        items.forEach(function(item) {
            const label = labelGetter(item);

            html += `
                <div class="select-option" data-value="${item.id}" data-label="${label}">
                    ${label}
                </div>
            `;
        });

        html += `<div class="select-empty">Data tidak ditemukan</div>`;

        optionsBox.innerHTML = html;
        bindSelectOptions(select);

        if (selectedValue) {
            const selected = items.find(item => String(item.id) === String(selectedValue));
            setCustomSelectValue(name, selectedValue, selected ? labelGetter(selected) : null);
        } else {
            setCustomSelectValue(name, '', placeholder);
        }
    }

    // Mengambil data JSON dari endpoint.
    async function fetchJson(url) {
        const response = await fetch(url, {
            headers: {
                'Accept': 'application/json',
                'X-Requested-With': 'XMLHttpRequest'
            }
        });

        if (!response.ok) {
            throw new Error('Gagal memuat data.');
        }

        return await response.json();
    }

    // Memberikan event klik pada pilihan dropdown.
    function bindSelectOptions(select) {
        select.querySelectorAll('.select-option').forEach(function(option) {
            option.addEventListener('click', function(event) {
                event.stopPropagation();

                const name = select.dataset.select;
                const value = option.dataset.value;
                const label = option.dataset.label;

                setCustomSelectValue(name, value, label);
                select.classList.remove('is-open');

                if (name === 'kabupaten_id') {
                    setCustomSelectValue('kecamatan_id', '', 'Pilih Kabupaten dulu');
                    setCustomSelectValue('desa_id', '', 'Pilih Kecamatan dulu');
                    resetCustomSelect('kecamatan_id', 'Memuat kecamatan...', true);
                    resetCustomSelect('desa_id', 'Pilih Kecamatan dulu', true);
                    loadKecamatan(value);
                }

                if (name === 'kecamatan_id') {
                    setCustomSelectValue('desa_id', '', 'Pilih Kecamatan dulu');
                    resetCustomSelect('desa_id', 'Memuat desa...', true);
                    loadDesa(value);
                }

                if (name === 'edit_kabupaten_id') {
                    setCustomSelectValue('edit_kecamatan_id', '', 'Pilih Kabupaten dulu');
                    setCustomSelectValue('edit_desa_id', '', 'Pilih Kecamatan dulu');
                    resetCustomSelect('edit_kecamatan_id', 'Memuat kecamatan...', true);
                    resetCustomSelect('edit_desa_id', 'Pilih Kecamatan dulu', true);
                    loadEditKecamatan(value);
                }

                if (name === 'edit_kecamatan_id') {
                    setCustomSelectValue('edit_desa_id', '', 'Pilih Kecamatan dulu');
                    resetCustomSelect('edit_desa_id', 'Memuat desa...', true);
                    loadEditDesa(value);
                }
            });
        });
    }

    // Mengaktifkan semua custom select.
    function initCustomSelects() {
        document.querySelectorAll('.select-modern').forEach(function(select) {
            const trigger = select.querySelector('.select-trigger');
            const search = select.querySelector('.select-search');

            trigger.addEventListener('click', function(event) {
                event.preventDefault();
                event.stopPropagation();

                if (select.classList.contains('is-disabled')) {
                    return;
                }

                closeAllSelects(select);
                select.classList.toggle('is-open');

                if (select.classList.contains('is-open') && search) {
                    setTimeout(function() {
                        search.focus();
                    }, 120);
                }
            });

            if (search) {
                search.addEventListener('click', function(event) {
                    event.stopPropagation();
                });

                search.addEventListener('input', function() {
                    const keyword = search.value.toLowerCase().trim();
                    const options = select.querySelectorAll('.select-option');
                    let shown = 0;

                    options.forEach(function(option) {
                        const label = option.dataset.label.toLowerCase();

                        if (label.includes(keyword)) {
                            option.style.display = 'flex';
                            shown++;
                        } else {
                            option.style.display = 'none';
                        }
                    });

                    select.classList.toggle('no-result', shown === 0);
                });
            }

            bindSelectOptions(select);
        });

        document.addEventListener('click', function() {
            closeAllSelects();
        });

        document.addEventListener('keydown', function(event) {
            if (event.key === 'Escape') {
                closeAllSelects();
                closeEditModal();
            }
        });
    }

    // Memuat data kecamatan berdasarkan kabupaten.
    async function loadKecamatan(kabupatenId, selectedKecamatan = null, selectedDesa = null) {
        if (!kabupatenId) {
            resetCustomSelect('kecamatan_id', 'Pilih Kabupaten dulu', true);
            return;
        }

        try {
            const data = await fetchJson(`/api/kecamatan/${kabupatenId}`);
            buildCustomOptions('kecamatan_id', data, 'Pilih Kecamatan', getNamaKecamatan, selectedKecamatan);

            if (selectedKecamatan) {
                await loadDesa(selectedKecamatan, selectedDesa);
            }
        } catch (error) {
            resetCustomSelect('kecamatan_id', 'Gagal memuat kecamatan', true);
        }
    }

    // Memuat data desa berdasarkan kecamatan.
    async function loadDesa(kecamatanId, selectedDesa = null) {
        if (!kecamatanId) {
            resetCustomSelect('desa_id', 'Pilih Kecamatan dulu', true);
            return;
        }

        try {
            const data = await fetchJson(`/api/desa/${kecamatanId}`);
            buildCustomOptions('desa_id', data, 'Pilih Desa/Kelurahan', getNamaDesa, selectedDesa);
        } catch (error) {
            resetCustomSelect('desa_id', 'Gagal memuat desa', true);
        }
    }

    // Memuat kecamatan pada modal edit.
    async function loadEditKecamatan(kabupatenId, selectedKecamatan = null, selectedDesa = null) {
        if (!kabupatenId) {
            resetCustomSelect('edit_kecamatan_id', 'Pilih Kabupaten dulu', true);
            return;
        }

        try {
            const data = await fetchJson(`/api/kecamatan/${kabupatenId}`);
            buildCustomOptions('edit_kecamatan_id', data, 'Pilih Kecamatan', getNamaKecamatan, selectedKecamatan);

            if (selectedKecamatan) {
                await loadEditDesa(selectedKecamatan, selectedDesa);
            }
        } catch (error) {
            resetCustomSelect('edit_kecamatan_id', 'Gagal memuat kecamatan', true);
        }
    }

    // Memuat desa pada modal edit.
    async function loadEditDesa(kecamatanId, selectedDesa = null) {
        if (!kecamatanId) {
            resetCustomSelect('edit_desa_id', 'Pilih Kecamatan dulu', true);
            return;
        }

        try {
            const data = await fetchJson(`/api/desa/${kecamatanId}`);
            buildCustomOptions('edit_desa_id', data, 'Pilih Desa/Kelurahan', getNamaDesa, selectedDesa);
        } catch (error) {
            resetCustomSelect('edit_desa_id', 'Gagal memuat desa', true);
        }
    }

    // Mengubah tanggal agar cocok untuk input type date.
    function formatDateForInput(value) {
        if (!value) return '';

        const stringValue = String(value);

        if (stringValue.length >= 10) {
            return stringValue.substring(0, 10);
        }

        return '';
    }

    const detailToggle = document.getElementById('detailToggle');
    const detailArea = document.getElementById('detailArea');

    // Membuka dan menutup detail tambahan.
    if (detailToggle && detailArea) {
        detailToggle.addEventListener('click', function() {
            detailArea.classList.toggle('show');
            detailToggle.textContent = detailArea.classList.contains('show')
                ? '- Tutup Detail Tambahan'
                : '+ Detail Tambahan';
        });

        const shouldShowDetail =
            @json(old('jenis_kelamin')) ||
            @json(old('tanggal_lahir')) ||
            @json(old('alamat')) ||
            @json(old('keterangan'));

        if (shouldShowDetail) {
            detailArea.classList.add('show');
            detailToggle.textContent = '- Tutup Detail Tambahan';
        }
    }

    // Membatasi input NIK agar hanya angka.
    document.querySelectorAll('.nik-only').forEach(function(input) {
        input.addEventListener('input', function() {
            this.value = onlyDigits(this.value, 16);
        });
    });

    const editModalBackdrop = document.getElementById('editModalBackdrop');
    const editForm = document.getElementById('editForm');

    // Membuka modal edit dan mengisi data lama.
    function openEditModal(item) {
        if (!item || !item.id) {
            return;
        }

        editForm.action = `/admin/nik/${item.id}`;

        document.getElementById('edit_nik').value = item.nik || '';
        document.getElementById('edit_nama_lengkap').value = item.nama_lengkap || '';
        document.getElementById('edit_tanggal_lahir').value = formatDateForInput(item.tanggal_lahir);
        document.getElementById('edit_alamat').value = item.alamat || '';
        document.getElementById('edit_keterangan').value = item.keterangan || '';

        setCustomSelectValue('edit_kabupaten_id', item.kabupaten_id || '', item.kabupaten?.nama_kabupaten || null);
        setCustomSelectValue('edit_status_dtsen', item.status_dtsen || 'Terdata', item.status_dtsen || 'Terdata');
        setCustomSelectValue('edit_desil_nasional', item.desil_nasional || 1, `Desil ${item.desil_nasional || 1}`);
        setCustomSelectValue('edit_jenis_kelamin', item.jenis_kelamin || '', item.jenis_kelamin || 'Tidak dipilih');

        resetCustomSelect('edit_kecamatan_id', 'Memuat kecamatan...', true);
        resetCustomSelect('edit_desa_id', 'Pilih Kecamatan dulu', true);

        loadEditKecamatan(item.kabupaten_id, item.kecamatan_id, item.desa_id);

        editModalBackdrop.classList.add('show');
        document.body.style.overflow = 'hidden';
    }

    // Menutup modal edit.
    function closeEditModal() {
        if (!editModalBackdrop) return;

        editModalBackdrop.classList.remove('show');
        document.body.style.overflow = '';
    }

    // Menutup modal ketika area luar diklik.
    if (editModalBackdrop) {
        editModalBackdrop.addEventListener('click', function(event) {
            if (event.target === editModalBackdrop) {
                closeEditModal();
            }
        });
    }

    // Inisialisasi halaman setelah DOM siap.
    document.addEventListener('DOMContentLoaded', function() {
        // Pindahkan modal edit ke body agar terhindar dari transform parent (.content) yang membatasi positioning fixed
        const editModal = document.getElementById('editModalBackdrop');
        if (editModal) {
            document.body.appendChild(editModal);
        }

        initCustomSelects();

        setCustomSelectValue('status_dtsen', @json(old('status_dtsen', 'Terdata')), @json(old('status_dtsen', 'Terdata')));
        setCustomSelectValue('desil_nasional', @json(old('desil_nasional', 1)), 'Desil ' + @json(old('desil_nasional', 1)));
        setCustomSelectValue('jenis_kelamin', @json(old('jenis_kelamin')), @json(old('jenis_kelamin') ?: 'Tidak dipilih'));

        if (oldKabupatenId) {
            const kabupatenSelect = getSelectElement('kabupaten_id');
            const selectedOption = kabupatenSelect?.querySelector(`.select-option[data-value="${oldKabupatenId}"]`);
            setCustomSelectValue('kabupaten_id', oldKabupatenId, selectedOption?.dataset.label || null);
            loadKecamatan(oldKabupatenId, oldKecamatanId, oldDesaId);
        }
    });
</script>
@endsection