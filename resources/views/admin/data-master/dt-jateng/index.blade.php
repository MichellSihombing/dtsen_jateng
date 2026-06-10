@extends('admin.layouts.app')

@section('title', 'Kelola DT Jateng')
@section('breadcrumb', 'DT Jateng')

@section('content')
<style>
    @import url('https://fonts.bunny.net/css?family=inter:400,500,600,700,800,900&display=swap');

    /*
    |--------------------------------------------------------------------------
    | GLOBAL VARIABLE
    |--------------------------------------------------------------------------
    | Menyimpan font utama yang digunakan pada halaman admin DT Jateng.
    |--------------------------------------------------------------------------
    */

    :root {
        --admin-font-main: 'Inter', ui-sans-serif, system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", sans-serif;
    }

    /*
    |--------------------------------------------------------------------------
    | ADMIN LAYOUT FIX
    |--------------------------------------------------------------------------
    | Menjaga layout admin agar konten tabel lebar tidak merusak struktur halaman.
    |--------------------------------------------------------------------------
    */

    .admin-body {
        grid-template-columns: var(--sidebar-width) minmax(0, 1fr) !important;
    }

    .content {
        min-width: 0 !important;
        max-width: 100% !important;
        overflow-x: hidden !important;
    }

    .admin-card {
        min-width: 0 !important;
        max-width: 100% !important;
        overflow: visible !important;
    }

    /*
    |--------------------------------------------------------------------------
    | RESET HALAMAN DT
    |--------------------------------------------------------------------------
    | Mengatur box sizing agar seluruh elemen halaman DT Jateng tetap stabil.
    |--------------------------------------------------------------------------
    */

    .dt-page,
    .dt-page *,
    .dt-page *::before,
    .dt-page *::after {
        box-sizing: border-box;
    }

    .dt-page {
        width: 100%;
        max-width: 100%;
        min-width: 0;
    }

    /*
    |--------------------------------------------------------------------------
    | HERO SECTION
    |--------------------------------------------------------------------------
    | Mengatur banner utama halaman Kelola DT Jateng.
    |--------------------------------------------------------------------------
    */

    .dt-hero {
        position: relative;
        overflow: hidden;
        background: linear-gradient(135deg, #2563eb, #0ea5e9);
        border-radius: 28px;
        padding: 32px;
        color: #ffffff;
        margin-bottom: 24px;
        box-shadow: 0 24px 50px rgba(37, 99, 235, 0.20);
        animation: dtFadeUp 0.45s ease both;
    }

    .dt-hero::after {
        content: "";
        position: absolute;
        right: -80px;
        bottom: -100px;
        width: 260px;
        height: 260px;
        border-radius: 999px;
        background: rgba(255, 255, 255, 0.14);
    }

    .dt-hero-content {
        position: relative;
        z-index: 2;
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 20px;
    }

    .dt-hero h1 {
        font-size: 30px;
        font-weight: 850 !important;
        margin: 0 0 8px;
        letter-spacing: -0.045em !important;
        line-height: 1.15 !important;
    }

    .dt-hero p {
        color: rgba(255, 255, 255, 0.86);
        font-size: 15px;
        line-height: 1.65 !important;
        margin: 0;
        font-weight: 500 !important;
        letter-spacing: -0.015em !important;
    }

    .dt-badge {
        padding: 11px 18px;
        border-radius: 999px;
        background: rgba(255, 255, 255, 0.18);
        border: 1px solid rgba(255, 255, 255, 0.24);
        font-size: 13px;
        font-weight: 700 !important;
        white-space: nowrap;
        letter-spacing: -0.012em !important;
    }

    /*
    |--------------------------------------------------------------------------
    | CARD UTAMA
    |--------------------------------------------------------------------------
    | Mengatur container form tambah data dan daftar tabel DT Jateng.
    |--------------------------------------------------------------------------
    */

    .dt-card {
        width: 100%;
        max-width: 100%;
        min-width: 0;
        background: #ffffff;
        border-radius: 24px;
        padding: 24px;
        margin-bottom: 24px;
        border: 1px solid #e5eaf1;
        box-shadow: 0 18px 45px rgba(15, 23, 42, 0.07);
        animation: dtFadeUp 0.45s ease both;
    }

    .dt-card-visible {
        overflow: visible;
        position: relative;
        z-index: 30;
    }

    .dt-card-hidden {
        overflow: visible;
        position: relative;
        z-index: 10;
    }

    .dt-card h2 {
        font-size: 23px;
        font-weight: 850 !important;
        color: #0f172a;
        margin: 0 0 6px;
        letter-spacing: -0.045em !important;
        line-height: 1.15 !important;
    }

    .dt-card p {
        color: #64748b;
        font-size: 13px;
        font-weight: 500 !important;
        margin: 0 0 18px;
        line-height: 1.65 !important;
        letter-spacing: -0.015em !important;
    }

    /*
    |--------------------------------------------------------------------------
    | ALERT MESSAGE
    |--------------------------------------------------------------------------
    | Mengatur tampilan pesan sukses, error, dan validasi pada halaman DT Jateng.
    |--------------------------------------------------------------------------
    */

    .dt-alert-success {
        padding: 13px 16px;
        border-radius: 16px;
        margin-bottom: 16px;
        background: #dcfce7;
        border: 1px solid #bbf7d0;
        color: #166534;
        font-size: 14px;
        font-weight: 700;
    }

    .dt-alert-error {
        padding: 13px 16px;
        border-radius: 16px;
        margin-bottom: 16px;
        background: #fee2e2;
        border: 1px solid #fecaca;
        color: #991b1b;
        font-size: 14px;
        font-weight: 700;
    }

    /*
    |--------------------------------------------------------------------------
    | FORM TAMBAH DATA
    |--------------------------------------------------------------------------
    | Mengatur form tambah kabupaten/kota untuk data DT Jateng.
    |--------------------------------------------------------------------------
    */

    .dt-add-form {
        display: grid;
        grid-template-columns: minmax(260px, 560px) auto;
        gap: 14px;
        align-items: end;
    }

    .dt-form-group label {
        display: block;
        font-size: 12px;
        font-weight: 760 !important;
        color: #475569;
        margin-bottom: 8px;
        letter-spacing: -0.018em !important;
        line-height: 1.3 !important;
    }

    .dt-add-btn {
        height: 48px;
        border: none;
        border-radius: 16px;
        padding: 0 22px;
        cursor: pointer;
        color: #ffffff;
        background: linear-gradient(135deg, #2563eb, #0ea5e9);
        font-size: 13px;
        font-weight: 760 !important;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 9px;
        white-space: nowrap;
        box-shadow: 0 14px 28px rgba(37, 99, 235, 0.20);
        transition: 0.22s ease;
        letter-spacing: -0.018em !important;
        line-height: 1.2 !important;
    }

    .dt-add-btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 18px 36px rgba(37, 99, 235, 0.28);
    }

    /*
    |--------------------------------------------------------------------------
    | SEARCH ROW
    |--------------------------------------------------------------------------
    | Mengatur form pencarian data DT Jateng pada daftar data.
    |--------------------------------------------------------------------------
    */

    .dt-search-row {
        display: grid;
        grid-template-columns: minmax(0, 1fr) auto auto;
        gap: 10px;
        align-items: center;
        margin-bottom: 16px;
    }

    .dt-search-row input {
        width: 100%;
        min-width: 0;
        height: 46px;
        border: 1px solid #dbe4ef;
        border-radius: 15px;
        padding: 0 15px;
        outline: none;
        font-size: 14px;
        font-weight: 600 !important;
        color: #0f172a;
        background: #ffffff;
        transition: 0.22s ease;
        letter-spacing: -0.015em !important;
        line-height: 1.35 !important;
    }

    .dt-search-row input:focus {
        border-color: #2563eb;
        box-shadow: 0 0 0 5px rgba(37, 99, 235, 0.10);
        transform: translateY(-1px);
    }

    .dt-search-row button,
    .dt-search-row a {
        height: 46px;
        border-radius: 15px;
        border: none;
        padding: 0 20px;
        font-size: 13px;
        font-weight: 760 !important;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        transition: 0.22s ease;
        white-space: nowrap;
        cursor: pointer;
        letter-spacing: -0.018em !important;
        line-height: 1.2 !important;
    }

    .dt-search-row button {
        background: linear-gradient(135deg, #2563eb, #0ea5e9);
        color: #ffffff;
    }

    .dt-search-row a {
        background: #eef2f7;
        color: #334155;
    }

    .dt-search-row button:hover,
    .dt-search-row a:hover {
        transform: translateY(-2px);
    }

    /*
    |--------------------------------------------------------------------------
    | MODERN SELECT
    |--------------------------------------------------------------------------
    | Mengatur custom dropdown kabupaten/kota dengan pencarian dan portal menu.
    |--------------------------------------------------------------------------
    */

    .modern-select {
        position: relative;
        width: 100%;
        user-select: none;
        z-index: 20;
    }

    .modern-select.is-open {
        z-index: 999999;
    }

    .modern-select-trigger {
        width: 100%;
        min-height: 48px;
        border: 1px solid #dbe4ef;
        border-radius: 15px;
        background: #ffffff;
        color: #0f172a;
        padding: 12px 44px 12px 14px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 10px;
        cursor: pointer;
        transition: 0.25s cubic-bezier(.2,.8,.2,1);
        font-size: 13px;
        text-align: left;
        position: relative;
        box-shadow: 0 8px 22px rgba(15, 23, 42, 0.03);
        font-weight: 600 !important;
        letter-spacing: -0.015em !important;
        line-height: 1.35 !important;
        text-transform: none !important;
    }

    .modern-select-trigger:hover {
        border-color: #93c5fd;
        box-shadow: 0 10px 20px rgba(37, 99, 235, 0.08);
        transform: translateY(-1px);
    }

    .modern-select.is-open .modern-select-trigger {
        border-color: #2563eb;
        box-shadow: 0 0 0 5px rgba(37, 99, 235, 0.10);
    }

    .modern-select-label {
        display: block;
        min-width: 0;
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
        color: #0f172a;
        font-size: 13px;
        font-weight: 650 !important;
        letter-spacing: -0.015em !important;
        text-transform: none !important;
    }

    .modern-select-label.is-placeholder {
        color: #64748b;
        font-weight: 500 !important;
        letter-spacing: -0.01em !important;
    }

    .modern-select-arrow {
        position: absolute;
        right: 15px;
        top: 50%;
        transform: translateY(-50%) rotate(0deg);
        color: #64748b;
        transition: 0.25s ease;
        pointer-events: none;
        font-size: 13px;
        background: transparent;
        width: auto;
        height: auto;
        min-width: auto;
        border-radius: 0;
        display: inline-flex;
        align-items: center;
        justify-content: center;
    }

    .modern-select.is-open .modern-select-arrow {
        transform: translateY(-50%) rotate(180deg);
        color: #2563eb;
        background: transparent;
    }

    /*
    |--------------------------------------------------------------------------
    | MODERN SELECT MENU
    |--------------------------------------------------------------------------
    | Mengatur dropdown menu yang dipindahkan ke body agar tidak terpotong tabel.
    |--------------------------------------------------------------------------
    */

    .modern-select-menu {
        position: fixed;
        left: 0;
        top: 0;
        width: 320px;
        max-width: calc(100vw - 24px);
        background: #ffffff;
        border: 1px solid #dbe4ef;
        border-radius: 18px;
        box-shadow: 0 24px 55px rgba(15, 23, 42, 0.22);
        overflow: hidden;
        opacity: 0;
        visibility: hidden;
        pointer-events: none;
        transform: translateY(-8px) scale(0.98);
        transition:
            opacity 0.22s cubic-bezier(.2,.8,.2,1),
            transform 0.22s cubic-bezier(.2,.8,.2,1),
            visibility 0s linear 0.22s;
        z-index: 999999999;
        will-change: opacity, transform;
    }

    .modern-select-menu.is-positioned {
        transition: none !important;
    }

    .modern-select-menu.is-portal-open {
        opacity: 1;
        visibility: visible;
        pointer-events: auto;
        transform: translateY(0) scale(1);
        transition:
            opacity 0.22s cubic-bezier(.2,.8,.2,1),
            transform 0.22s cubic-bezier(.2,.8,.2,1),
            visibility 0s linear 0s;
    }

    /*
    |--------------------------------------------------------------------------
    | MODERN SELECT SEARCH
    |--------------------------------------------------------------------------
    | Mengatur input pencarian di dalam dropdown kabupaten/kota.
    |--------------------------------------------------------------------------
    */

    .modern-select-search-wrap {
        position: relative;
        padding: 10px;
        border-bottom: 1px solid #eef2f7;
        background: #f8fafc;
        margin-bottom: 0;
    }

    .modern-select-search-wrap i {
        position: absolute;
        left: 22px;
        top: 50%;
        transform: translateY(-50%);
        color: #94a3b8;
        font-size: 12px;
        pointer-events: none;
        z-index: 2;
    }

    .modern-select-search {
        width: 100% !important;
        height: 42px !important;
        border: 1px solid #dbe4ef !important;
        border-radius: 13px !important;
        padding: 10px 12px 10px 34px !important;
        outline: none !important;
        font-size: 13px !important;
        font-weight: 600 !important;
        color: #0f172a !important;
        background: #ffffff !important;
        transition: 0.22s ease !important;
        box-sizing: border-box !important;
        letter-spacing: -0.015em !important;
        line-height: 1.35 !important;
        text-transform: none !important;
    }

    .modern-select-search:focus {
        border-color: #2563eb !important;
        box-shadow: 0 0 0 4px rgba(37, 99, 235, 0.08) !important;
    }

    /*
    |--------------------------------------------------------------------------
    | MODERN SELECT OPTIONS
    |--------------------------------------------------------------------------
    | Mengatur daftar pilihan, empty state, dan selected state pada dropdown.
    |--------------------------------------------------------------------------
    */

    .modern-select-options {
        max-height: 250px;
        overflow-y: auto;
        overflow-x: hidden;
        padding: 8px;
        background: #ffffff;
        overscroll-behavior: contain;
    }

    .modern-select-options::-webkit-scrollbar {
        width: 7px;
    }

    .modern-select-options::-webkit-scrollbar-track {
        background: transparent;
    }

    .modern-select-options::-webkit-scrollbar-thumb {
        background: #cbd5e1;
        border-radius: 999px;
    }

    .modern-select-option {
        min-height: 42px;
        padding: 11px 12px;
        border-radius: 13px;
        font-size: 13px;
        color: #334155;
        cursor: pointer;
        transition: 0.18s ease;
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 10px;
        background: #ffffff;
        font-weight: 650 !important;
        letter-spacing: -0.012em !important;
        text-transform: none !important;
    }

    .modern-select-option:hover {
        background: #eef5ff;
        color: #2563eb;
        transform: translateX(4px);
    }

    .modern-select-option.selected {
        background: linear-gradient(135deg, #2563eb, #0ea5e9);
        color: #ffffff;
        font-weight: 700 !important;
        box-shadow: 0 10px 18px rgba(37, 99, 235, 0.20);
        text-transform: none !important;
    }

    .modern-select-option.selected::after {
        content: "✓";
        font-weight: 900;
        font-size: 13px;
        width: auto;
        height: auto;
        border-radius: 0;
        background: transparent;
        display: inline-block;
        flex-shrink: 0;
    }

    .modern-select-empty {
        padding: 22px 12px;
        text-align: center;
        color: #94a3b8;
        font-size: 13px;
        background: #ffffff;
        font-weight: 700 !important;
        display: none;
        letter-spacing: -0.012em !important;
    }

    .modern-select.no-result .modern-select-empty {
        display: block;
    }

    /*
    |--------------------------------------------------------------------------
    | SCROLL NOTE DAN BUTTON
    |--------------------------------------------------------------------------
    | Mengatur informasi serta tombol bantu geser tabel ke kanan atau kiri.
    |--------------------------------------------------------------------------
    */

    .dt-scroll-note {
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
        font-weight: 700 !important;
        border: 1px solid #dbeafe;
        letter-spacing: -0.012em !important;
    }

    .dt-scroll-note i {
        margin-right: 8px;
    }

    .dt-scroll-buttons {
        display: flex;
        align-items: center;
        gap: 10px;
        margin-bottom: 12px;
        flex-wrap: wrap;
    }

    .dt-scroll-buttons button {
        border: none;
        height: 40px;
        padding: 0 15px;
        border-radius: 13px;
        cursor: pointer;
        font-weight: 760 !important;
        font-size: 13px;
        color: #ffffff;
        background: linear-gradient(135deg, #2563eb, #0ea5e9);
        display: inline-flex;
        align-items: center;
        gap: 8px;
        transition: 0.22s ease;
        letter-spacing: -0.018em !important;
        line-height: 1.2 !important;
    }

    .dt-scroll-buttons button:hover {
        transform: translateY(-2px);
        box-shadow: 0 12px 24px rgba(37, 99, 235, 0.22);
    }

    /*
    |--------------------------------------------------------------------------
    | TABLE SCROLL AREA
    |--------------------------------------------------------------------------
    | Mengatur area scroll horizontal agar tabel DT Jateng bisa digeser.
    |--------------------------------------------------------------------------
    */

    .dt-table-viewport {
        width: 100%;
        max-width: 100%;
        overflow: hidden !important;
        border-radius: 22px;
        border: 1px solid #e5eaf1;
        background: #ffffff;
        position: relative;
        z-index: 1;
    }

    .dt-table-scroll {
        width: 100%;
        max-width: 100%;
        overflow-x: scroll !important;
        overflow-y: hidden !important;
        background: #ffffff;
        scroll-behavior: auto;
        scrollbar-width: auto;
        scrollbar-color: #2563eb #e5eaf1;
        cursor: grab !important;
        overscroll-behavior-x: contain;
        overscroll-behavior-y: auto;
        touch-action: pan-y pan-x;
        position: relative;
        z-index: 1;
    }

    .dt-table-scroll.dragging {
        cursor: grabbing !important;
        user-select: none;
        scroll-behavior: auto;
    }

    body.dt-table-is-dragging,
    body.dt-table-is-dragging * {
        cursor: grabbing !important;
    }

    .dt-table-scroll::-webkit-scrollbar {
        height: 18px;
    }

    .dt-table-scroll::-webkit-scrollbar:vertical {
        width: 0;
        display: none;
    }

    .dt-table-scroll::-webkit-scrollbar-track {
        background: #e5eaf1;
        border-radius: 999px;
    }

    .dt-table-scroll::-webkit-scrollbar-thumb {
        background: linear-gradient(135deg, #2563eb, #0ea5e9);
        border-radius: 999px;
        border: 4px solid #e5eaf1;
        cursor: grab;
    }

    /*
    |--------------------------------------------------------------------------
    | WIDE TABLE
    |--------------------------------------------------------------------------
    | Mengatur tabel lebar DT Jateng beserta header dan isi tabel.
    |--------------------------------------------------------------------------
    */

    .dt-wide-table {
        width: max-content;
        min-width: 1900px;
        border-collapse: separate;
        border-spacing: 0;
        margin: 0;
        cursor: grab;
    }

    .dt-wide-table th,
    .dt-wide-table td {
        white-space: nowrap;
        background: #ffffff;
        border-bottom: 1px solid #eef2f7;
        cursor: grab;
        padding: 13px 14px;
    }

    .dt-wide-table th {
        background: #f8fafc;
        position: sticky;
        top: 0;
        z-index: 4;
        font-size: 12px;
        font-weight: 780 !important;
        color: #475569;
        text-transform: uppercase;
        letter-spacing: 0.035em !important;
        line-height: 1.35 !important;
    }

    .dt-wide-table td {
        font-weight: 520 !important;
        letter-spacing: -0.015em !important;
        line-height: 1.45 !important;
    }

    .dt-wide-table tbody tr:hover td {
        background: #f8fafc;
    }

    /*
    |--------------------------------------------------------------------------
    | STICKY COLUMN
    |--------------------------------------------------------------------------
    | Mengatur kolom nomor dan kabupaten agar tetap terlihat saat tabel digeser.
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
        cursor: grab;
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
        cursor: grab;
        font-weight: 650 !important;
        letter-spacing: -0.018em !important;
        text-transform: none !important;
    }

    thead .sticky-name {
        background: #f8fafc !important;
        z-index: 9;
        text-transform: uppercase !important;
    }

    .sticky-action {
        min-width: 130px;
        width: 130px;
        text-align: center;
        background: #ffffff !important;
        cursor: default;
    }

    thead .sticky-action {
        background: #f8fafc !important;
    }

    /*
    |--------------------------------------------------------------------------
    | INPUT TABEL DT
    |--------------------------------------------------------------------------
    | Mengatur input angka dan persentase pada tabel edit DT Jateng.
    |--------------------------------------------------------------------------
    */

    .dt-input {
        width: 125px !important;
        min-width: 125px;
        height: 44px;
        text-align: right;
        font-size: 13px;
        font-weight: 600 !important;
        border: 1px solid #dbe4ef;
        border-radius: 14px;
        padding: 0 13px;
        outline: none;
        background: #ffffff;
        transition: 0.22s ease;
        cursor: text !important;
        letter-spacing: -0.015em !important;
        line-height: 1.35 !important;
    }

    .dt-input-percent {
        width: 120px !important;
        min-width: 120px;
        text-align: center;
    }

    .dt-input:focus {
        border-color: #2563eb;
        box-shadow: 0 0 0 4px rgba(37, 99, 235, 0.09);
    }

    .modern-select,
    .modern-select *,
    .modern-select-trigger,
    .modern-select-option {
        cursor: pointer !important;
    }

    /*
    |--------------------------------------------------------------------------
    | AKSI TABEL
    |--------------------------------------------------------------------------
    | Mengatur tombol simpan dan hapus pada setiap baris data DT Jateng.
    |--------------------------------------------------------------------------
    */

    .action-button-group {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        cursor: default;
    }

    .dt-save-btn,
    .dt-delete-btn {
        width: 44px;
        height: 44px;
        border: none;
        border-radius: 14px;
        cursor: pointer !important;
        transition: 0.22s ease;
        display: inline-grid;
        place-items: center;
    }

    .dt-save-btn {
        background: #16a34a;
        color: #ffffff;
        box-shadow: 0 10px 20px rgba(22, 163, 74, 0.18);
    }

    .dt-save-btn:hover {
        transform: translateY(-2px);
        background: #15803d;
        box-shadow: 0 12px 24px rgba(22, 163, 74, 0.28);
    }

    .dt-delete-btn {
        background: #fee2e2;
        color: #dc2626;
    }

    .dt-delete-btn:hover {
        transform: translateY(-2px);
        background: #dc2626;
        color: #ffffff;
        box-shadow: 0 12px 24px rgba(220, 38, 38, 0.22);
    }

    /*
    |--------------------------------------------------------------------------
    | PAGINATION
    |--------------------------------------------------------------------------
    | Mengatur informasi data dan tombol navigasi halaman.
    |--------------------------------------------------------------------------
    */

    .custom-pagination {
        margin-top: 18px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 14px;
        flex-wrap: wrap;
    }

    .pagination-info {
        color: #64748b;
        font-size: 13px;
        font-weight: 700 !important;
        letter-spacing: -0.012em !important;
    }

    .pagination-links {
        display: flex;
        align-items: center;
        gap: 7px;
        flex-wrap: wrap;
    }

    .page-link-custom,
    .page-link-disabled,
    .page-link-active {
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
    }

    .page-link-custom {
        background: #ffffff;
        color: #334155;
    }

    .page-link-custom:hover {
        background: #eff6ff;
        color: #2563eb;
        border-color: #bfdbfe;
        transform: translateY(-1px);
    }

    .page-link-active {
        background: #2563eb;
        color: #ffffff;
        border-color: #2563eb;
        box-shadow: 0 10px 22px rgba(37, 99, 235, 0.22);
    }

    .page-link-disabled {
        background: #f8fafc;
        color: #cbd5e1;
        cursor: not-allowed;
    }

    /*
    |--------------------------------------------------------------------------
    | GLOBAL FONT
    |--------------------------------------------------------------------------
    | Menerapkan font Inter ke seluruh elemen halaman admin DT Jateng.
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
    | ANIMASI HALAMAN
    |--------------------------------------------------------------------------
    | Menyediakan animasi masuk untuk hero dan card halaman DT Jateng.
    |--------------------------------------------------------------------------
    */

    @keyframes dtFadeUp {
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
    | RESPONSIVE TABLET
    |--------------------------------------------------------------------------
    | Menyesuaikan layout form, search, dan sticky column pada layar sedang.
    |--------------------------------------------------------------------------
    */

    @media (max-width: 1000px) {
        .dt-hero-content {
            flex-direction: column;
            align-items: flex-start;
        }

        .dt-add-form,
        .dt-search-row {
            grid-template-columns: 1fr;
        }

        .dt-add-btn,
        .dt-search-row button,
        .dt-search-row a {
            width: 100%;
        }

        .sticky-name {
            min-width: 250px;
            width: 250px;
        }

        .dt-wide-table {
            min-width: 1850px;
        }
    }
</style>

{{--
|--------------------------------------------------------------------------
| HALAMAN KELOLA DT JATENG
|--------------------------------------------------------------------------
| Container utama untuk menambah, mencari, mengedit, dan menghapus data DT Jateng.
|--------------------------------------------------------------------------
--}}
<div class="dt-page">
    @php
        /*
        |--------------------------------------------------------------------------
        | FORMAT NAMA KABUPATEN
        |--------------------------------------------------------------------------
        | Mengubah nama kabupaten/kota menjadi format title case agar lebih rapi.
        |--------------------------------------------------------------------------
        */

        $formatKabupatenName = function ($name) {
            if (!$name) {
                return 'Pilih Kabupaten/Kota';
            }

            return \Illuminate\Support\Str::of($name)
                ->lower()
                ->title()
                ->toString();
        };
    @endphp

    {{--
    |--------------------------------------------------------------------------
    | HERO HALAMAN
    |--------------------------------------------------------------------------
    | Menampilkan judul, deskripsi, dan badge halaman Kelola DT Jateng.
    |--------------------------------------------------------------------------
    --}}
    <div class="dt-hero">
        <div class="dt-hero-content">
            <div>
                <h1>Kelola DT Jateng</h1>
                <p>
                    Tambah kabupaten/kota, lalu edit data kebutuhan intervensi seperti RTLH,
                    listrik, air, jamban, ATS, tidak bekerja, dan % ART.
                </p>
            </div>

            <span class="dt-badge">DT JATENG</span>
        </div>
    </div>

    {{--
    |--------------------------------------------------------------------------
    | ALERT SUCCESS
    |--------------------------------------------------------------------------
    | Menampilkan pesan sukses dari session setelah aksi berhasil.
    |--------------------------------------------------------------------------
    --}}
    @if(session('success'))
        <div class="dt-alert-success">
            {{ session('success') }}
        </div>
    @endif

    {{--
    |--------------------------------------------------------------------------
    | ALERT ERROR
    |--------------------------------------------------------------------------
    | Menampilkan pesan error dari session ketika aksi gagal.
    |--------------------------------------------------------------------------
    --}}
    @if(session('error'))
        <div class="dt-alert-error">
            {{ session('error') }}
        </div>
    @endif

    {{--
    |--------------------------------------------------------------------------
    | VALIDATION ERROR
    |--------------------------------------------------------------------------
    | Menampilkan seluruh error validasi dari Laravel.
    |--------------------------------------------------------------------------
    --}}
    @if($errors->any())
        <div class="dt-alert-error">
            <ul style="margin:0; padding-left:18px;">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{--
    |--------------------------------------------------------------------------
    | KONDISI TABEL BELUM ADA
    |--------------------------------------------------------------------------
    | Menampilkan informasi jika tabel dt_jateng belum tersedia di database.
    |--------------------------------------------------------------------------
    --}}
    @if($tableMissing)
        <div class="dt-card dt-card-hidden">
            <h2>Tabel belum ditemukan</h2>
            <p>Tabel <strong>dt_jateng</strong> belum ada di database.</p>
        </div>
    @else
        {{--
        |--------------------------------------------------------------------------
        | FORM TAMBAH DATA
        |--------------------------------------------------------------------------
        | Form untuk menambahkan kabupaten/kota ke daftar DT Jateng.
        |--------------------------------------------------------------------------
        --}}
        <div class="dt-card dt-card-visible">
            <h2>Tambah Data</h2>
            <p>Cukup pilih kabupaten/kota terlebih dahulu. Nilai detail dapat diedit langsung di daftar data.</p>

            <form action="{{ route('admin.data.store', 'dt-jateng') }}" method="POST" class="dt-add-form">
                @csrf

                <div class="dt-form-group">
                    <label>Kabupaten/Kota *</label>

                    <input type="hidden" name="kabupaten_id" id="add-kabupaten-id" required>

                    {{--
                    |--------------------------------------------------------------------------
                    | DROPDOWN TAMBAH KABUPATEN
                    |--------------------------------------------------------------------------
                    | Custom select untuk memilih kabupaten/kota yang akan ditambahkan.
                    |--------------------------------------------------------------------------
                    --}}
                    <div class="modern-select" data-modern-select data-target="add-kabupaten-id">
                        <div class="modern-select-trigger" data-modern-trigger>
                            <span class="modern-select-label is-placeholder" data-modern-label>
                                Pilih Kabupaten/Kota
                            </span>

                            <span class="modern-select-arrow">
                                <i class="fa fa-chevron-down"></i>
                            </span>
                        </div>

                        <div class="modern-select-menu">
                            <div class="modern-select-search-wrap">
                                <i class="fa fa-search"></i>
                                <input type="text" class="modern-select-search" placeholder="Cari kabupaten/kota..." data-modern-search>
                            </div>

                            <div class="modern-select-options" data-modern-options>
                                @foreach($kabupatens as $kabupaten)
                                    @php
                                        $namaKabupatenFormatted = $formatKabupatenName($kabupaten->nama_kabupaten);
                                    @endphp

                                    <div
                                        class="modern-select-option"
                                        data-modern-option
                                        data-value="{{ $kabupaten->id }}"
                                        data-label="{{ $namaKabupatenFormatted }}"
                                    >
                                        {{ $namaKabupatenFormatted }}
                                    </div>
                                @endforeach

                                <div class="modern-select-empty">Data tidak ditemukan</div>
                            </div>
                        </div>
                    </div>
                </div>

                <button type="submit" class="dt-add-btn">
                    <i class="fa fa-plus"></i>
                    Tambah Kabupaten/Kota
                </button>
            </form>
        </div>

        {{--
        |--------------------------------------------------------------------------
        | DAFTAR DATA DT JATENG
        |--------------------------------------------------------------------------
        | Menampilkan tabel data DT Jateng yang dapat dicari, diedit, dan dihapus.
        |--------------------------------------------------------------------------
        --}}
        <div class="dt-card dt-card-hidden">
            <h2>Daftar Data</h2>
            <p>
                Edit nilai RTLH, RTLH P1, RTLH P2, Listrik, Air, Jamban, ATS,
                Tidak Bekerja, dan % ART langsung pada tabel.
            </p>

            {{--
            |--------------------------------------------------------------------------
            | FORM PENCARIAN
            |--------------------------------------------------------------------------
            | Mencari data DT Jateng berdasarkan keyword yang dikirim melalui query string.
            |--------------------------------------------------------------------------
            --}}
            <form method="GET" action="{{ route('admin.data.index', 'dt-jateng') }}" class="dt-search-row">
                <input
                    type="text"
                    name="search"
                    value="{{ request('search') }}"
                    placeholder="Cari data DT Jateng..."
                >

                <button type="submit">
                    <i class="fa fa-search"></i>
                    Cari
                </button>

                <a href="{{ route('admin.data.index', 'dt-jateng') }}">
                    Reset
                </a>
            </form>

            {{--
            |--------------------------------------------------------------------------
            | INFORMASI SCROLL TABEL
            |--------------------------------------------------------------------------
            | Memberi instruksi bahwa tabel dapat digeser secara horizontal.
            |--------------------------------------------------------------------------
            --}}
            <div class="dt-scroll-note">
                <span>
                    <i class="fa fa-arrows-left-right"></i>
                    Geser tabel ke kanan/kiri untuk mengedit semua kolom.
                </span>
            </div>

            {{--
            |--------------------------------------------------------------------------
            | TOMBOL SCROLL TABEL
            |--------------------------------------------------------------------------
            | Tombol bantu untuk menggeser tabel ke kiri atau kanan secara halus.
            |--------------------------------------------------------------------------
            --}}
            <div class="dt-scroll-buttons">
                <button type="button" data-scroll-left="dt-jateng">
                    <i class="fa fa-arrow-left"></i>
                    Geser Kiri
                </button>

                <button type="button" data-scroll-right="dt-jateng">
                    Geser Kanan
                    <i class="fa fa-arrow-right"></i>
                </button>
            </div>

            {{--
            |--------------------------------------------------------------------------
            | TABEL DATA DT JATENG
            |--------------------------------------------------------------------------
            | Tabel lebar untuk mengedit seluruh indikator kebutuhan intervensi.
            |--------------------------------------------------------------------------
            --}}
            <div class="dt-table-viewport">
                <div class="dt-table-scroll" data-scroll-area="dt-jateng">
                    <table class="dt-wide-table">
                        <thead>
                            <tr>
                                <th class="sticky-no">No</th>
                                <th class="sticky-name">Kabupaten/Kota</th>
                                <th>RTLH</th>
                                <th>RTLH P1</th>
                                <th>RTLH P2</th>
                                <th>Listrik</th>
                                <th>Air</th>
                                <th>Jamban</th>
                                <th>ATS</th>
                                <th>Tidak Bekerja</th>
                                <th>% ART</th>
                                <th class="sticky-action">Aksi</th>
                            </tr>
                        </thead>

                        <tbody>
                            @forelse($items as $index => $item)
                                @php
                                    $formId = 'form-update-dt-jateng-' . $item->id;
                                    $deleteFormId = 'form-delete-dt-jateng-' . $item->id;

                                    $selectedKabupaten = $kabupatens->firstWhere('id', $item->kabupaten_id ?? 0);
                                    $selectedKabupatenName = $formatKabupatenName($selectedKabupaten->nama_kabupaten ?? null);
                                @endphp

                                <tr>
                                    <td class="sticky-no">
                                        {{ method_exists($items, 'firstItem') ? $items->firstItem() + $index : $index + 1 }}
                                    </td>

                                    <td class="sticky-name">
                                        <input
                                            form="{{ $formId }}"
                                            type="hidden"
                                            name="kabupaten_id"
                                            id="edit-kabupaten-id-{{ $item->id }}"
                                            value="{{ $item->kabupaten_id ?? '' }}"
                                            required
                                        >

                                        {{--
                                        |--------------------------------------------------------------------------
                                        | DROPDOWN EDIT KABUPATEN
                                        |--------------------------------------------------------------------------
                                        | Custom select untuk mengubah kabupaten/kota pada baris data.
                                        |--------------------------------------------------------------------------
                                        --}}
                                        <div class="modern-select" data-modern-select data-target="edit-kabupaten-id-{{ $item->id }}">
                                            <div class="modern-select-trigger" data-modern-trigger>
                                                <span class="modern-select-label {{ ($item->kabupaten_id ?? null) ? '' : 'is-placeholder' }}" data-modern-label>
                                                    {{ $selectedKabupatenName }}
                                                </span>

                                                <span class="modern-select-arrow">
                                                    <i class="fa fa-chevron-down"></i>
                                                </span>
                                            </div>

                                            <div class="modern-select-menu">
                                                <div class="modern-select-search-wrap">
                                                    <i class="fa fa-search"></i>
                                                    <input type="text" class="modern-select-search" placeholder="Cari kabupaten/kota..." data-modern-search>
                                                </div>

                                                <div class="modern-select-options" data-modern-options>
                                                    @foreach($kabupatens as $kabupaten)
                                                        @php
                                                            $namaKabupatenFormatted = $formatKabupatenName($kabupaten->nama_kabupaten);
                                                        @endphp

                                                        <div
                                                            class="modern-select-option {{ (int)($item->kabupaten_id ?? 0) === (int)$kabupaten->id ? 'selected' : '' }}"
                                                            data-modern-option
                                                            data-value="{{ $kabupaten->id }}"
                                                            data-label="{{ $namaKabupatenFormatted }}"
                                                        >
                                                            {{ $namaKabupatenFormatted }}
                                                        </div>
                                                    @endforeach

                                                    <div class="modern-select-empty">Data tidak ditemukan</div>
                                                </div>
                                            </div>
                                        </div>
                                    </td>

                                    <td>
                                        <input form="{{ $formId }}" class="dt-input" type="number" name="rtlh" value="{{ $item->rtlh ?? 0 }}" min="0" required>
                                    </td>

                                    <td>
                                        <input form="{{ $formId }}" class="dt-input" type="number" name="rtlh_p1" value="{{ $item->rtlh_p1 ?? 0 }}" min="0" required>
                                    </td>

                                    <td>
                                        <input form="{{ $formId }}" class="dt-input" type="number" name="rtlh_p2" value="{{ $item->rtlh_p2 ?? 0 }}" min="0" required>
                                    </td>

                                    <td>
                                        <input form="{{ $formId }}" class="dt-input" type="number" name="listrik" value="{{ $item->listrik ?? 0 }}" min="0" required>
                                    </td>

                                    <td>
                                        <input form="{{ $formId }}" class="dt-input" type="number" name="air" value="{{ $item->air ?? 0 }}" min="0" required>
                                    </td>

                                    <td>
                                        <input form="{{ $formId }}" class="dt-input" type="number" name="jamban" value="{{ $item->jamban ?? 0 }}" min="0" required>
                                    </td>

                                    <td>
                                        <input form="{{ $formId }}" class="dt-input" type="number" name="ats" value="{{ $item->ats ?? 0 }}" min="0" required>
                                    </td>

                                    <td>
                                        <input form="{{ $formId }}" class="dt-input" type="number" name="tidak_bekerja" value="{{ $item->tidak_bekerja ?? 0 }}" min="0" required>
                                    </td>

                                    <td>
                                        <input
                                            form="{{ $formId }}"
                                            class="dt-input dt-input-percent"
                                            type="text"
                                            name="pct_art"
                                            value="{{ number_format((float)($item->pct_art ?? 0), 2, ',', '') }}"
                                            required
                                        >
                                    </td>

                                    {{--
                                    |--------------------------------------------------------------------------
                                    | AKSI BARIS DATA
                                    |--------------------------------------------------------------------------
                                    | Tombol simpan dan hapus untuk masing-masing data DT Jateng.
                                    |--------------------------------------------------------------------------
                                    --}}
                                    <td class="sticky-action">
                                        <div class="action-button-group">
                                            <button form="{{ $formId }}" type="submit" class="dt-save-btn" title="Simpan">
                                                <i class="fa fa-save"></i>
                                            </button>

                                            <button form="{{ $deleteFormId }}" type="submit" class="dt-delete-btn" title="Hapus">
                                                <i class="fa fa-trash"></i>
                                            </button>
                                        </div>

                                        <form
                                            id="{{ $formId }}"
                                            action="{{ route('admin.data.update', ['module' => 'dt-jateng', 'id' => $item->id]) }}"
                                            method="POST"
                                            style="display:none;"
                                        >
                                            @csrf
                                            @method('PUT')
                                        </form>

                                        <form
                                            id="{{ $deleteFormId }}"
                                            action="{{ route('admin.data.destroy', ['module' => 'dt-jateng', 'id' => $item->id]) }}"
                                            method="POST"
                                            style="display:none;"
                                            onsubmit="return confirm('Yakin ingin menghapus data DT Jateng ini?')"
                                        >
                                            @csrf
                                            @method('DELETE')
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                {{--
                                |--------------------------------------------------------------------------
                                | DATA KOSONG
                                |--------------------------------------------------------------------------
                                | Menampilkan pesan ketika belum ada data DT Jateng.
                                |--------------------------------------------------------------------------
                                --}}
                                <tr>
                                    <td colspan="12" style="padding:28px; text-align:center; color:#64748b; font-weight:700;">
                                        Belum ada data DT Jateng.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            {{--
            |--------------------------------------------------------------------------
            | PAGINATION DATA
            |--------------------------------------------------------------------------
            | Menampilkan informasi jumlah data dan navigasi halaman.
            |--------------------------------------------------------------------------
            --}}
            @if(method_exists($items, 'total'))
                <div class="custom-pagination">
                    <div class="pagination-info">
                        @if($items->total() > 0)
                            Menampilkan {{ $items->firstItem() }} - {{ $items->lastItem() }} dari {{ $items->total() }} data
                        @else
                            Belum ada data
                        @endif
                    </div>

                    @if(method_exists($items, 'lastPage') && $items->lastPage() > 1)
                        <div class="pagination-links">
                            @if($items->onFirstPage())
                                <span class="page-link-disabled">Previous</span>
                            @else
                                <a class="page-link-custom" href="{{ $items->previousPageUrl() }}">Previous</a>
                            @endif

                            @php
                                $start = max($items->currentPage() - 2, 1);
                                $end = min($items->currentPage() + 2, $items->lastPage());
                            @endphp

                            @if($start > 1)
                                <a class="page-link-custom" href="{{ $items->url(1) }}">1</a>

                                @if($start > 2)
                                    <span class="page-link-disabled">...</span>
                                @endif
                            @endif

                            @for($page = $start; $page <= $end; $page++)
                                @if($page === $items->currentPage())
                                    <span class="page-link-active">{{ $page }}</span>
                                @else
                                    <a class="page-link-custom" href="{{ $items->url($page) }}">{{ $page }}</a>
                                @endif
                            @endfor

                            @if($end < $items->lastPage())
                                @if($end < $items->lastPage() - 1)
                                    <span class="page-link-disabled">...</span>
                                @endif

                                <a class="page-link-custom" href="{{ $items->url($items->lastPage()) }}">
                                    {{ $items->lastPage() }}
                                </a>
                            @endif

                            @if($items->hasMorePages())
                                <a class="page-link-custom" href="{{ $items->nextPageUrl() }}">Next</a>
                            @else
                                <span class="page-link-disabled">Next</span>
                            @endif
                        </div>
                    @endif
                </div>
            @endif
        </div>
    @endif
</div>

<script>
    /*
    |--------------------------------------------------------------------------
    | INISIALISASI HALAMAN
    |--------------------------------------------------------------------------
    | Menjalankan fungsi utama setelah seluruh elemen halaman selesai dimuat.
    |--------------------------------------------------------------------------
    */

    document.addEventListener('DOMContentLoaded', function () {
        initModernSelect();
        initDtHorizontalScroll();
        initPercentInput();
    });

    /*
    |--------------------------------------------------------------------------
    | CLOSE MODERN SELECT
    |--------------------------------------------------------------------------
    | Menutup satu dropdown modern dan mengembalikan menu ke posisi awal.
    |--------------------------------------------------------------------------
    */

    function closeModernSelect(select) {
        if (!select) {
            return;
        }

        const menu = select._modernMenu;
        const originalParent = select._originalMenuParent;
        const originalNextSibling = select._originalMenuNextSibling;

        select.classList.remove('is-open');

        if (menu) {
            menu.classList.remove('is-portal-open');
            menu.classList.remove('is-positioned');

            menu.style.left = '';
            menu.style.top = '';
            menu.style.width = '';
            menu.style.maxHeight = '';
            menu.style.position = '';
            menu.style.zIndex = '';

            const optionBox = menu.querySelector('[data-modern-options]');

            if (optionBox) {
                optionBox.style.maxHeight = '';
            }

            if (originalParent && menu.parentElement === document.body) {
                if (originalNextSibling && originalNextSibling.parentElement === originalParent) {
                    originalParent.insertBefore(menu, originalNextSibling);
                } else {
                    originalParent.appendChild(menu);
                }
            }
        }
    }

    /*
    |--------------------------------------------------------------------------
    | CLOSE ALL MODERN SELECTS
    |--------------------------------------------------------------------------
    | Menutup seluruh dropdown modern yang sedang aktif.
    |--------------------------------------------------------------------------
    */

    function closeAllModernSelects() {
        document.querySelectorAll('[data-modern-select].is-open').forEach(function (select) {
            closeModernSelect(select);
        });
    }

    /*
    |--------------------------------------------------------------------------
    | INIT MODERN SELECT
    |--------------------------------------------------------------------------
    | Mengaktifkan custom dropdown kabupaten/kota pada form tambah dan tabel edit.
    |--------------------------------------------------------------------------
    */

    function initModernSelect() {
        const selects = document.querySelectorAll('[data-modern-select]');

        selects.forEach(function (select) {
            const trigger = select.querySelector('[data-modern-trigger]');
            const label = select.querySelector('[data-modern-label]');
            const menu = select.querySelector('.modern-select-menu');
            const search = select.querySelector('[data-modern-search]');
            const options = select.querySelectorAll('[data-modern-option]');
            const targetId = select.dataset.target;
            const target = document.getElementById(targetId);

            if (!trigger || !label || !menu || !target) {
                return;
            }

            select._modernMenu = menu;
            select._originalMenuParent = menu.parentElement;
            select._originalMenuNextSibling = menu.nextElementSibling;

            /*
            |--------------------------------------------------------------------------
            | MOVE MENU TO BODY
            |--------------------------------------------------------------------------
            | Memindahkan dropdown ke body agar tidak terpotong area tabel atau card.
            |--------------------------------------------------------------------------
            */

            function moveMenuToBody() {
                if (menu.parentElement !== document.body) {
                    document.body.appendChild(menu);
                }
            }

            /*
            |--------------------------------------------------------------------------
            | SET MENU POSITION
            |--------------------------------------------------------------------------
            | Mengatur posisi dropdown berdasarkan letak trigger yang diklik.
            |--------------------------------------------------------------------------
            */

            function setMenuPosition() {
                const rect = trigger.getBoundingClientRect();
                const viewportWidth = window.innerWidth;
                const viewportHeight = window.innerHeight;

                let width = rect.width;
                let left = rect.left;
                let top = rect.bottom + 8;

                if (width < 320) {
                    width = 320;
                }

                if (left + width > viewportWidth - 14) {
                    left = viewportWidth - width - 14;
                }

                if (left < 14) {
                    left = 14;
                }

                let availableBelow = viewportHeight - top - 18;

                if (availableBelow < 180) {
                    availableBelow = 180;
                }

                const menuHeight = Math.min(330, availableBelow);
                const optionHeight = Math.max(105, menuHeight - 64);

                menu.style.position = 'fixed';
                menu.style.left = left + 'px';
                menu.style.top = top + 'px';
                menu.style.width = width + 'px';
                menu.style.maxHeight = menuHeight + 'px';
                menu.style.zIndex = '999999999';

                const optionBox = menu.querySelector('[data-modern-options]');

                if (optionBox) {
                    optionBox.style.maxHeight = optionHeight + 'px';
                }
            }

            /*
            |--------------------------------------------------------------------------
            | RESET SEARCH AND OPTIONS
            |--------------------------------------------------------------------------
            | Mengosongkan pencarian dan menampilkan ulang seluruh opsi dropdown.
            |--------------------------------------------------------------------------
            */

            function resetSearchAndOptions() {
                if (search) {
                    search.value = '';
                }

                options.forEach(function (option) {
                    option.style.display = 'flex';
                });

                select.classList.remove('no-result');
            }

            /*
            |--------------------------------------------------------------------------
            | OPEN SELECT
            |--------------------------------------------------------------------------
            | Membuka dropdown, menentukan posisi, dan memberi fokus ke input pencarian.
            |--------------------------------------------------------------------------
            */

            function openSelect() {
                const wasOpen = select.classList.contains('is-open');

                closeAllModernSelects();

                if (wasOpen) {
                    return;
                }

                moveMenuToBody();
                resetSearchAndOptions();

                select.classList.add('is-open');

                menu.classList.remove('is-portal-open');
                menu.classList.add('is-positioned');

                setMenuPosition();

                void menu.offsetHeight;

                menu.classList.remove('is-positioned');

                requestAnimationFrame(function () {
                    menu.classList.add('is-portal-open');
                });

                if (search) {
                    setTimeout(function () {
                        search.focus();
                    }, 80);
                }
            }

            /*
            |--------------------------------------------------------------------------
            | EVENT TRIGGER DROPDOWN
            |--------------------------------------------------------------------------
            | Membuka dropdown saat trigger custom select diklik.
            |--------------------------------------------------------------------------
            */

            trigger.addEventListener('click', function (event) {
                event.preventDefault();
                event.stopPropagation();
                openSelect();
            });

            /*
            |--------------------------------------------------------------------------
            | EVENT PROTECTION MENU
            |--------------------------------------------------------------------------
            | Mencegah klik dan scroll dalam dropdown menutup menu secara tidak sengaja.
            |--------------------------------------------------------------------------
            */

            menu.addEventListener('click', function (event) {
                event.stopPropagation();
            });

            menu.addEventListener('mousedown', function (event) {
                event.stopPropagation();
            });

            menu.addEventListener('wheel', function (event) {
                event.stopPropagation();
            }, {
                passive: true
            });

            /*
            |--------------------------------------------------------------------------
            | EVENT PILIH OPTION
            |--------------------------------------------------------------------------
            | Mengisi hidden input dan label dropdown sesuai opsi yang dipilih.
            |--------------------------------------------------------------------------
            */

            options.forEach(function (option) {
                option.addEventListener('click', function (event) {
                    event.preventDefault();
                    event.stopPropagation();

                    const value = option.dataset.value;
                    const text = option.dataset.label || option.textContent.trim();

                    target.value = value;
                    label.textContent = text;
                    label.classList.remove('is-placeholder');

                    options.forEach(function (item) {
                        item.classList.remove('selected');
                    });

                    option.classList.add('selected');

                    closeModernSelect(select);
                });
            });

            /*
            |--------------------------------------------------------------------------
            | EVENT SEARCH OPTION
            |--------------------------------------------------------------------------
            | Menyaring daftar kabupaten/kota berdasarkan teks yang diketik.
            |--------------------------------------------------------------------------
            */

            if (search) {
                search.addEventListener('click', function (event) {
                    event.stopPropagation();
                });

                search.addEventListener('mousedown', function (event) {
                    event.stopPropagation();
                });

                search.addEventListener('keydown', function (event) {
                    event.stopPropagation();
                });

                search.addEventListener('input', function () {
                    const keyword = search.value.toLowerCase().trim();
                    let visibleCount = 0;

                    options.forEach(function (option) {
                        const text = option.textContent.toLowerCase();

                        if (text.includes(keyword)) {
                            option.style.display = 'flex';
                            visibleCount++;
                        } else {
                            option.style.display = 'none';
                        }
                    });

                    select.classList.toggle('no-result', visibleCount === 0);
                });
            }
        });

        /*
        |--------------------------------------------------------------------------
        | EVENT CLOSE DROPDOWN
        |--------------------------------------------------------------------------
        | Menutup dropdown ketika klik luar, tombol Escape, resize, atau scroll halaman.
        |--------------------------------------------------------------------------
        */

        document.addEventListener('click', function () {
            closeAllModernSelects();
        });

        document.addEventListener('keydown', function (event) {
            if (event.key === 'Escape') {
                closeAllModernSelects();
            }
        });

        window.addEventListener('resize', function () {
            closeAllModernSelects();
        });

        window.addEventListener('scroll', function (event) {
            const target = event.target;

            if (
                target &&
                target.nodeType === 1 &&
                (
                    target.closest('.modern-select-menu') ||
                    target.closest('.modern-select-options')
                )
            ) {
                return;
            }

            closeAllModernSelects();
        }, true);

        const tableScrollArea = document.querySelector('[data-scroll-area="dt-jateng"]');

        if (tableScrollArea) {
            tableScrollArea.addEventListener('scroll', function () {
                closeAllModernSelects();
            });
        }
    }

    /*
    |--------------------------------------------------------------------------
    | INIT HORIZONTAL SCROLL
    |--------------------------------------------------------------------------
    | Mengaktifkan scroll horizontal tabel menggunakan tombol, drag mouse, dan touchpad.
    |--------------------------------------------------------------------------
    */

    function initDtHorizontalScroll() {
        const scrollArea = document.querySelector('[data-scroll-area="dt-jateng"]');
        const leftBtn = document.querySelector('[data-scroll-left="dt-jateng"]');
        const rightBtn = document.querySelector('[data-scroll-right="dt-jateng"]');

        if (!scrollArea) {
            return;
        }

        /*
        |--------------------------------------------------------------------------
        | SCROLL BUTTON
        |--------------------------------------------------------------------------
        | Menggeser tabel ke kiri atau kanan ketika tombol scroll diklik.
        |--------------------------------------------------------------------------
        */

        if (leftBtn) {
            leftBtn.addEventListener('click', function () {
                closeAllModernSelects();

                scrollArea.scrollBy({
                    left: -900,
                    behavior: 'smooth'
                });
            });
        }

        if (rightBtn) {
            rightBtn.addEventListener('click', function () {
                closeAllModernSelects();

                scrollArea.scrollBy({
                    left: 900,
                    behavior: 'smooth'
                });
            });
        }

        let isDown = false;
        let startX = 0;
        let scrollLeft = 0;

        /*
        |--------------------------------------------------------------------------
        | DRAG SCROLL START
        |--------------------------------------------------------------------------
        | Memulai proses drag horizontal pada area tabel.
        |--------------------------------------------------------------------------
        */

        scrollArea.addEventListener('mousedown', function (event) {
            const ignored = event.target.closest('input, button, textarea, select, a, [data-modern-select]');

            if (ignored) {
                return;
            }

            closeAllModernSelects();

            isDown = true;
            scrollArea.classList.add('dragging');
            document.body.classList.add('dt-table-is-dragging');

            startX = event.pageX - scrollArea.offsetLeft;
            scrollLeft = scrollArea.scrollLeft;
        });

        /*
        |--------------------------------------------------------------------------
        | DRAG SCROLL END
        |--------------------------------------------------------------------------
        | Menghentikan proses drag ketika mouse dilepas atau keluar area tabel.
        |--------------------------------------------------------------------------
        */

        window.addEventListener('mouseup', function () {
            isDown = false;
            scrollArea.classList.remove('dragging');
            document.body.classList.remove('dt-table-is-dragging');
        });

        scrollArea.addEventListener('mouseleave', function () {
            isDown = false;
            scrollArea.classList.remove('dragging');
            document.body.classList.remove('dt-table-is-dragging');
        });

        /*
        |--------------------------------------------------------------------------
        | DRAG SCROLL MOVE
        |--------------------------------------------------------------------------
        | Menggeser tabel berdasarkan arah gerakan mouse.
        |--------------------------------------------------------------------------
        */

        scrollArea.addEventListener('mousemove', function (event) {
            if (!isDown) {
                return;
            }

            event.preventDefault();

            const x = event.pageX - scrollArea.offsetLeft;
            const walk = (x - startX) * 3.2;

            scrollArea.scrollLeft = scrollLeft - walk;
        });

        /*
        |--------------------------------------------------------------------------
        | TOUCHPAD HORIZONTAL SCROLL
        |--------------------------------------------------------------------------
        | Mempercepat scroll horizontal saat pengguna memakai touchpad.
        |--------------------------------------------------------------------------
        */

        scrollArea.addEventListener('wheel', function (event) {
            closeAllModernSelects();

            if (Math.abs(event.deltaX) > Math.abs(event.deltaY)) {
                event.preventDefault();
                scrollArea.scrollLeft += event.deltaX * 4;
            }
        }, {
            passive: false
        });
    }

    /*
    |--------------------------------------------------------------------------
    | INIT PERCENT INPUT
    |--------------------------------------------------------------------------
    | Membatasi input % ART agar hanya menerima angka, koma, dan titik.
    |--------------------------------------------------------------------------
    */

    function initPercentInput() {
        document.querySelectorAll('input[name="pct_art"]').forEach(function (input) {
            input.addEventListener('input', function () {
                this.value = this.value.replace(/[^0-9,.]/g, '');
            });
        });
    }
</script>
@endsection