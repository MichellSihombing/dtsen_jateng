@extends('admin.layouts.app')

@section('title', 'Kelola PPKS')
@section('breadcrumb', 'PPKS')

@section('content')
<style>
    @import url('https://fonts.bunny.net/css?family=inter:400,500,600,700,800,900&display=swap');

    /*
    |--------------------------------------------------------------------------
    | GLOBAL VARIABLE
    |--------------------------------------------------------------------------
    | Menyimpan font utama yang digunakan pada halaman admin PPKS.
    |--------------------------------------------------------------------------
    */

    :root {
        --admin-font-main: 'Inter', ui-sans-serif, system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", sans-serif;
    }

    /*
    |--------------------------------------------------------------------------
    | RESET HALAMAN PPKS
    |--------------------------------------------------------------------------
    | Menjaga ukuran seluruh elemen agar tetap stabil dan tidak keluar container.
    |--------------------------------------------------------------------------
    */

    .ppks-page,
    .ppks-page *,
    .ppks-page *::before,
    .ppks-page *::after {
        box-sizing: border-box;
    }

    .ppks-page {
        width: 100%;
        max-width: 100%;
        min-width: 0;
    }

    /*
    |--------------------------------------------------------------------------
    | ADMIN LAYOUT FIX
    |--------------------------------------------------------------------------
    | Mencegah konten tabel lebar merusak layout utama halaman admin.
    |--------------------------------------------------------------------------
    */

    .content,
    .main-content,
    .admin-content {
        min-width: 0 !important;
        max-width: 100% !important;
        overflow-x: hidden !important;
    }

    /*
    |--------------------------------------------------------------------------
    | HERO SECTION
    |--------------------------------------------------------------------------
    | Mengatur banner utama halaman Kelola PPKS.
    |--------------------------------------------------------------------------
    */

    .ppks-hero {
        position: relative;
        overflow: hidden;
        background: linear-gradient(135deg, #2563eb, #0ea5e9);
        border-radius: 28px;
        padding: 34px;
        color: #ffffff;
        margin-bottom: 24px;
        box-shadow: 0 24px 50px rgba(37, 99, 235, 0.20);
    }

    .ppks-hero::after {
        content: "";
        position: absolute;
        right: -80px;
        bottom: -100px;
        width: 260px;
        height: 260px;
        border-radius: 999px;
        background: rgba(255, 255, 255, 0.14);
    }

    .ppks-hero-content {
        position: relative;
        z-index: 2;
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 18px;
    }

    .ppks-hero h1 {
        margin: 0 0 8px;
        font-size: 30px;
        font-weight: 850 !important;
        letter-spacing: -0.045em !important;
        line-height: 1.15 !important;
    }

    .ppks-hero p {
        margin: 0;
        color: rgba(255, 255, 255, 0.88);
        font-size: 15px;
        line-height: 1.65 !important;
        font-weight: 500 !important;
        letter-spacing: -0.015em !important;
    }

    .ppks-badge {
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
    | ALERT MESSAGE
    |--------------------------------------------------------------------------
    | Mengatur tampilan pesan sukses, error, dan validasi pada halaman PPKS.
    |--------------------------------------------------------------------------
    */

    .ppks-alert-success {
        padding: 13px 16px;
        border-radius: 16px;
        margin-bottom: 16px;
        background: #dcfce7;
        border: 1px solid #bbf7d0;
        color: #166534;
        font-size: 14px;
        font-weight: 700;
    }

    .ppks-alert-error {
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
    | CARD UTAMA
    |--------------------------------------------------------------------------
    | Mengatur container utama untuk pilihan mode, form tambah, dan tabel data.
    |--------------------------------------------------------------------------
    */

    .ppks-card {
        width: 100%;
        max-width: 100%;
        min-width: 0;
        background: #ffffff;
        border-radius: 24px;
        padding: 24px;
        margin-bottom: 24px;
        border: 1px solid #e5eaf1;
        box-shadow: 0 18px 45px rgba(15, 23, 42, 0.07);
    }

    .ppks-card.ppks-overflow-visible {
        overflow: visible;
        position: relative;
        z-index: 30;
    }

    .ppks-card.ppks-overflow-hidden {
        overflow: hidden;
        position: relative;
        z-index: 10;
    }

    .ppks-card h2 {
        margin: 0 0 6px;
        font-size: 23px;
        font-weight: 850 !important;
        color: #0f172a;
        letter-spacing: -0.045em !important;
        line-height: 1.15 !important;
    }

    .ppks-card p {
        margin: 0 0 18px;
        color: #64748b;
        font-size: 13px;
        font-weight: 500 !important;
        line-height: 1.65 !important;
        letter-spacing: -0.015em !important;
    }

    /*
    |--------------------------------------------------------------------------
    | MODE CARD
    |--------------------------------------------------------------------------
    | Mengatur kartu pilihan rekap PPKS per kabupaten/kota dan per jenis.
    |--------------------------------------------------------------------------
    */

    .ppks-mode-grid {
        display: grid;
        grid-template-columns: repeat(2, minmax(0, 1fr));
        gap: 18px;
        margin-top: 18px;
    }

    .ppks-mode-card {
        position: relative;
        overflow: hidden;
        min-height: 190px;
        border-radius: 24px;
        padding: 24px;
        text-decoration: none;
        background: #ffffff;
        border: 1px solid #dbeafe;
        box-shadow: 0 18px 45px rgba(15, 23, 42, 0.07);
        transition: 0.24s ease;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
    }

    .ppks-mode-card:hover {
        transform: translateY(-5px);
        border-color: #93c5fd;
        box-shadow: 0 28px 60px rgba(37, 99, 235, 0.18);
    }

    .ppks-mode-icon {
        width: 54px;
        height: 54px;
        border-radius: 18px;
        background: linear-gradient(135deg, #2563eb, #0ea5e9);
        color: #ffffff;
        display: grid;
        place-items: center;
        font-size: 22px;
        margin-bottom: 16px;
        box-shadow: 0 14px 28px rgba(37, 99, 235, 0.25);
    }

    .ppks-mode-card h3 {
        margin: 0 0 8px;
        color: #0f172a;
        font-size: 19px;
        font-weight: 760 !important;
        letter-spacing: -0.018em !important;
        line-height: 1.25 !important;
    }

    .ppks-mode-card p {
        margin: 0;
        color: #64748b;
        font-size: 13px;
        font-weight: 500 !important;
        line-height: 1.65 !important;
    }

    .ppks-mode-action {
        margin-top: 18px;
        color: #2563eb;
        font-size: 13px;
        font-weight: 760 !important;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        letter-spacing: -0.018em !important;
    }

    /*
    |--------------------------------------------------------------------------
    | HEADER MODE DETAIL
    |--------------------------------------------------------------------------
    | Mengatur judul halaman detail rekap dan tombol kembali.
    |--------------------------------------------------------------------------
    */

    .ppks-header-row {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 16px;
        margin-bottom: 18px;
    }

    .ppks-page-title {
        margin: 0;
        font-size: 26px;
        font-weight: 850 !important;
        color: #0f172a;
        letter-spacing: -0.045em !important;
        line-height: 1.15 !important;
    }

    .ppks-back-link {
        text-decoration: none;
        color: #334155;
        background: #f1f5f9;
        border-radius: 999px;
        padding: 11px 16px;
        font-size: 13px;
        font-weight: 760 !important;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        transition: 0.22s ease;
        letter-spacing: -0.018em !important;
    }

    .ppks-back-link:hover {
        background: #e2e8f0;
        transform: translateY(-2px);
    }

    /*
    |--------------------------------------------------------------------------
    | FORM TAMBAH DATA
    |--------------------------------------------------------------------------
    | Mengatur layout form tambah data PPKS pada mode kabupaten maupun jenis.
    |--------------------------------------------------------------------------
    */

    .ppks-form-grid {
        display: grid;
        grid-template-columns: minmax(260px, 560px) max-content;
        gap: 14px;
        align-items: end;
        justify-content: start;
    }

    .ppks-form-group label {
        display: block;
        margin-bottom: 8px;
        color: #475569;
        font-size: 12px;
        font-weight: 760 !important;
        letter-spacing: -0.018em !important;
        line-height: 1.3 !important;
    }

    .ppks-input {
        width: 100%;
        height: 48px;
        border: 1px solid #dbe4ef;
        border-radius: 16px;
        padding: 0 15px;
        outline: none;
        color: #0f172a;
        font-size: 14px;
        font-weight: 600 !important;
        background: #ffffff;
        transition: 0.22s ease;
        letter-spacing: -0.015em !important;
        line-height: 1.35 !important;
    }

    .ppks-input:focus {
        border-color: #2563eb;
        box-shadow: 0 0 0 4px rgba(37, 99, 235, 0.09);
    }

    .ppks-submit-btn {
        height: 48px;
        min-width: 190px;
        width: auto;
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

    .ppks-submit-btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 18px 36px rgba(37, 99, 235, 0.28);
    }

    /*
    |--------------------------------------------------------------------------
    | CUSTOM DROPDOWN KABUPATEN
    |--------------------------------------------------------------------------
    | Mengatur dropdown modern untuk memilih kabupaten/kota pada form tambah.
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
        border-radius: 16px;
        background: #ffffff;
        color: #0f172a;
        padding: 12px 44px 12px 15px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 10px;
        cursor: pointer;
        transition: 0.25s cubic-bezier(.2,.8,.2,1);
        font-size: 14px;
        text-align: left;
        position: relative;
        box-shadow: 0 8px 22px rgba(15, 23, 42, 0.03);
        font-weight: 600 !important;
        letter-spacing: -0.015em !important;
        line-height: 1.35 !important;
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
        font-size: 14px;
        font-weight: 650 !important;
        letter-spacing: -0.015em !important;
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
        display: inline-flex;
        align-items: center;
        justify-content: center;
    }

    .modern-select.is-open .modern-select-arrow {
        transform: translateY(-50%) rotate(180deg);
        color: #2563eb;
    }

    /*
    |--------------------------------------------------------------------------
    | DROPDOWN PORTAL MENU
    |--------------------------------------------------------------------------
    | Mengatur panel dropdown yang dipindahkan ke body agar tidak terpotong card.
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
    | DROPDOWN SEARCH
    |--------------------------------------------------------------------------
    | Mengatur input pencarian di dalam dropdown kabupaten/kota.
    |--------------------------------------------------------------------------
    */

    .modern-select-search-wrap {
        position: relative;
        padding: 10px;
        border-bottom: 1px solid #eef2f7;
        background: #f8fafc;
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
    }

    .modern-select-search:focus {
        border-color: #2563eb !important;
        box-shadow: 0 0 0 4px rgba(37, 99, 235, 0.08) !important;
    }

    /*
    |--------------------------------------------------------------------------
    | DROPDOWN OPTIONS
    |--------------------------------------------------------------------------
    | Mengatur daftar pilihan kabupaten/kota, opsi terpilih, dan pesan kosong.
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
        font-weight: 700 !important;
        letter-spacing: -0.012em !important;
    }

    .modern-select-option:hover {
        background: #eef5ff;
        color: #2563eb;
        transform: translateX(4px);
    }

    .modern-select-option.selected {
        background: linear-gradient(135deg, #2563eb, #0ea5e9);
        color: #ffffff;
        font-weight: 760 !important;
        box-shadow: 0 10px 18px rgba(37, 99, 235, 0.20);
    }

    .modern-select-option.selected::after {
        content: "✓";
        font-weight: 900;
        font-size: 13px;
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
    | SEARCH ROW
    |--------------------------------------------------------------------------
    | Mengatur form pencarian data PPKS pada mode kabupaten maupun jenis.
    |--------------------------------------------------------------------------
    */

    .ppks-search-row {
        display: grid;
        grid-template-columns: minmax(0, 1fr) auto auto;
        gap: 10px;
        align-items: center;
        margin-bottom: 16px;
    }

    .ppks-search-row input {
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

    .ppks-search-row input:focus {
        border-color: #2563eb;
        box-shadow: 0 0 0 4px rgba(37, 99, 235, 0.09);
    }

    .ppks-search-row button,
    .ppks-search-row a {
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

    .ppks-search-row button {
        background: linear-gradient(135deg, #2563eb, #0ea5e9);
        color: #ffffff;
    }

    .ppks-search-row a {
        background: #eef2f7;
        color: #334155;
    }

    /*
    |--------------------------------------------------------------------------
    | SCROLL NOTE DAN BUTTON
    |--------------------------------------------------------------------------
    | Mengatur instruksi serta tombol geser tabel kanan dan kiri.
    |--------------------------------------------------------------------------
    */

    .ppks-scroll-note {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        margin: 0 0 12px;
        padding: 12px 14px;
        border-radius: 16px;
        background: #eff6ff;
        color: #1e40af;
        font-size: 13px;
        font-weight: 700 !important;
        border: 1px solid #dbeafe;
        letter-spacing: -0.012em !important;
    }

    .ppks-scroll-buttons {
        display: flex;
        align-items: center;
        gap: 10px;
        margin-bottom: 12px;
        flex-wrap: wrap;
    }

    .ppks-scroll-buttons button {
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

    .ppks-scroll-buttons button:hover {
        transform: translateY(-2px);
        box-shadow: 0 12px 24px rgba(37, 99, 235, 0.22);
    }

    /*
    |--------------------------------------------------------------------------
    | TABLE SCROLL AREA
    |--------------------------------------------------------------------------
    | Mengatur area tabel agar bisa digeser horizontal dengan mouse dan touchpad.
    |--------------------------------------------------------------------------
    */

    .ppks-table-viewport {
        width: 100%;
        max-width: 100%;
        min-width: 0;
        overflow: hidden;
        border-radius: 22px;
        border: 1px solid #e5eaf1;
        background: #ffffff;
    }

    .ppks-table-scroll {
        width: 100%;
        max-width: 100%;
        min-width: 0;
        overflow-x: scroll !important;
        overflow-y: hidden !important;
        background: #ffffff;
        cursor: grab;
        scrollbar-width: auto;
        scrollbar-color: #2563eb #e5eaf1;
        overscroll-behavior-x: contain;
        overscroll-behavior-y: auto;
        touch-action: auto;
        scroll-behavior: auto;
    }

    .ppks-table-scroll.dragging {
        cursor: grabbing;
        user-select: none;
    }

    .ppks-table-scroll::-webkit-scrollbar {
        height: 18px;
    }

    .ppks-table-scroll::-webkit-scrollbar:vertical {
        width: 0;
        display: none;
    }

    .ppks-table-scroll::-webkit-scrollbar-track {
        background: #e5eaf1;
        border-radius: 999px;
    }

    .ppks-table-scroll::-webkit-scrollbar-thumb {
        background: linear-gradient(135deg, #2563eb, #0ea5e9);
        border-radius: 999px;
        border: 4px solid #e5eaf1;
    }

    /*
    |--------------------------------------------------------------------------
    | WIDE TABLE
    |--------------------------------------------------------------------------
    | Mengatur tabel lebar PPKS untuk tahun 2015 sampai 2025.
    |--------------------------------------------------------------------------
    */

    .ppks-wide-table {
        width: max-content;
        min-width: 1900px;
        border-collapse: separate;
        border-spacing: 0;
        margin: 0;
    }

    .ppks-wide-table th,
    .ppks-wide-table td {
        white-space: nowrap;
        background: #ffffff;
        border-bottom: 1px solid #eef2f7;
        padding: 13px 14px;
    }

    .ppks-wide-table th {
        background: #f8fafc;
        color: #475569;
        font-size: 12px;
        font-weight: 780 !important;
        text-transform: uppercase;
        letter-spacing: 0.035em !important;
        line-height: 1.35 !important;
    }

    .ppks-wide-table td {
        color: #334155;
        font-size: 13px;
        font-weight: 520 !important;
        letter-spacing: -0.015em !important;
        line-height: 1.45 !important;
    }

    .ppks-wide-table tbody tr:hover td {
        background: #f8fafc;
    }

    /*
    |--------------------------------------------------------------------------
    | STICKY COLUMN
    |--------------------------------------------------------------------------
    | Mengatur kolom nomor dan nama agar tetap terlihat saat tabel digeser.
    |--------------------------------------------------------------------------
    */

    .sticky-no {
        position: sticky;
        left: 0;
        z-index: 5;
        min-width: 70px;
        width: 70px;
        background: #ffffff !important;
        box-shadow: 8px 0 14px rgba(15, 23, 42, 0.04);
        font-size: 13px !important;
        font-weight: 650 !important;
        color: #0f172a;
    }

    thead .sticky-no {
        background: #f8fafc !important;
        z-index: 8;
        font-size: 12px !important;
        font-weight: 780 !important;
    }

    .sticky-name {
        position: sticky;
        left: 70px;
        z-index: 5;
        min-width: 330px;
        width: 330px;
        background: #ffffff !important;
        box-shadow: 8px 0 14px rgba(15, 23, 42, 0.04);
        color: #0f172a;
    }

    thead .sticky-name {
        background: #f8fafc !important;
        z-index: 8;
        font-size: 12px !important;
        font-weight: 780 !important;
        color: #475569;
        text-transform: uppercase;
        letter-spacing: 0.035em !important;
    }

    /*
    |--------------------------------------------------------------------------
    | FONT KABUPATEN/KOTA PPKS
    |--------------------------------------------------------------------------
    | Mengatur ukuran dan gaya font isi kabupaten/kota agar tidak terlalu besar.
    |--------------------------------------------------------------------------
    */

    .ppks-wide-table tbody td.sticky-name {
        font-size: 13px !important;
        font-weight: 620 !important;
        letter-spacing: -0.012em !important;
        line-height: 1.35 !important;
        color: #0f172a !important;
    }

    .ppks-wide-table tbody td.sticky-name,
    .ppks-wide-table tbody td.sticky-name * {
        text-transform: none !important;
    }

    /*
    |--------------------------------------------------------------------------
    | INPUT TABEL PPKS
    |--------------------------------------------------------------------------
    | Mengatur input angka tahunan dan input nama jenis PPKS pada tabel.
    |--------------------------------------------------------------------------
    */

    .ppks-year-input {
        width: 130px;
        height: 44px;
        border: 1px solid #dbe4ef;
        border-radius: 14px;
        padding: 0 12px;
        text-align: right;
        outline: none;
        font-size: 13px;
        font-weight: 600 !important;
        background: #ffffff;
        transition: 0.22s ease;
        letter-spacing: -0.015em !important;
        line-height: 1.35 !important;
    }

    .ppks-year-input:focus {
        border-color: #2563eb;
        box-shadow: 0 0 0 4px rgba(37, 99, 235, 0.09);
    }

    .ppks-name-input {
        width: 280px;
        height: 44px;
        border: 1px solid #dbe4ef;
        border-radius: 14px;
        padding: 0 12px;
        outline: none;
        font-size: 13px;
        font-weight: 600 !important;
        background: #ffffff;
        letter-spacing: -0.015em !important;
        line-height: 1.35 !important;
    }

    /*
    |--------------------------------------------------------------------------
    | ACTION BUTTON
    |--------------------------------------------------------------------------
    | Mengatur tombol simpan dan hapus pada tabel PPKS.
    |--------------------------------------------------------------------------
    */

    .ppks-action-group {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
    }

    .ppks-save-btn,
    .ppks-delete-btn {
        width: 44px;
        height: 44px;
        border: none;
        border-radius: 14px;
        cursor: pointer;
        transition: 0.22s ease;
        display: inline-grid;
        place-items: center;
    }

    .ppks-save-btn {
        background: #16a34a;
        color: #ffffff;
        box-shadow: 0 10px 20px rgba(22, 163, 74, 0.18);
    }

    .ppks-save-btn:hover {
        transform: translateY(-2px);
        background: #15803d;
    }

    .ppks-delete-btn {
        background: #fee2e2;
        color: #dc2626;
    }

    .ppks-delete-btn:hover {
        transform: translateY(-2px);
        background: #dc2626;
        color: #ffffff;
    }

    /*
    |--------------------------------------------------------------------------
    | PAGINATION
    |--------------------------------------------------------------------------
    | Mengatur informasi jumlah data dan tombol navigasi halaman.
    |--------------------------------------------------------------------------
    */

    .custom-pagination {
        margin-top: 18px;
        display: flex !important;
        align-items: center;
        justify-content: space-between;
        gap: 14px;
        flex-wrap: wrap;
        width: 100%;
    }

    .pagination-info {
        color: #64748b;
        font-size: 13px;
        font-weight: 700 !important;
        letter-spacing: -0.012em !important;
    }

    .pagination-links {
        display: flex !important;
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
    }

    .page-link-active {
        background: #2563eb;
        color: #ffffff;
        border-color: #2563eb;
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
    | Menerapkan font Inter ke seluruh elemen halaman PPKS.
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
    .ppks-page,
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
    | RESPONSIVE TABLET
    |--------------------------------------------------------------------------
    | Menyesuaikan layout halaman PPKS pada ukuran layar sedang.
    |--------------------------------------------------------------------------
    */

    @media (max-width: 1000px) {
        .ppks-mode-grid,
        .ppks-form-grid,
        .ppks-search-row {
            grid-template-columns: 1fr;
        }

        .ppks-submit-btn,
        .ppks-search-row button,
        .ppks-search-row a {
            width: 100%;
        }

        .ppks-hero-content,
        .ppks-header-row {
            flex-direction: column;
            align-items: flex-start;
        }

        .ppks-wide-table {
            min-width: 1700px;
        }

        .sticky-name {
            min-width: 280px;
            width: 280px;
        }
    }
</style>

{{--
|--------------------------------------------------------------------------
| HALAMAN KELOLA PPKS
|--------------------------------------------------------------------------
| Container utama untuk memilih mode, menambah data, mencari, mengedit, dan menghapus data PPKS.
|--------------------------------------------------------------------------
--}}
<div class="ppks-page">

    {{--
    |--------------------------------------------------------------------------
    | HERO HALAMAN
    |--------------------------------------------------------------------------
    | Menampilkan judul, deskripsi, dan badge halaman Kelola PPKS.
    |--------------------------------------------------------------------------
    --}}
    <div class="ppks-hero">
        <div class="ppks-hero-content">
            <div>
                <h1>Kelola PPKS</h1>
                <p>Kelola data PPKS berdasarkan rekap kabupaten/kota dan rekap jenis secara terpisah.</p>
            </div>

            <span class="ppks-badge">PPKS</span>
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
        <div class="ppks-alert-success">
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
        <div class="ppks-alert-error">
            {{ session('error') }}
        </div>
    @endif

    {{--
    |--------------------------------------------------------------------------
    | VALIDATION ERROR
    |--------------------------------------------------------------------------
    | Menampilkan pesan validasi pertama dari Laravel.
    |--------------------------------------------------------------------------
    --}}
    @if($errors->any())
        <div class="ppks-alert-error">
            {{ $errors->first() }}
        </div>
    @endif

    {{--
    |--------------------------------------------------------------------------
    | PILIHAN MODE REKAP
    |--------------------------------------------------------------------------
    | Menampilkan pilihan untuk mengelola rekap per kabupaten/kota atau per jenis.
    |--------------------------------------------------------------------------
    --}}
    @if(($mode ?? 'cards') === 'cards')
        <div class="ppks-card ppks-overflow-hidden">
            <h2>Pilih Jenis Rekap</h2>
            <p>Pilih data PPKS yang ingin dikelola oleh admin.</p>

            <div class="ppks-mode-grid">
                <a href="{{ route('admin.ppks.index', ['mode' => 'kabupaten']) }}" class="ppks-mode-card">
                    <div>
                        <div class="ppks-mode-icon">
                            <i class="fa fa-map"></i>
                        </div>

                        <h3>Rekap PPKS Per Kabupaten/Kota</h3>
                        <p>Kelola angka PPKS berdasarkan kabupaten/kota untuk tahun 2015 sampai 2025.</p>
                    </div>

                    <span class="ppks-mode-action">
                        Kelola Data
                        <i class="fa fa-arrow-right"></i>
                    </span>
                </a>

                <a href="{{ route('admin.ppks.index', ['mode' => 'jenis']) }}" class="ppks-mode-card">
                    <div>
                        <div class="ppks-mode-icon">
                            <i class="fa fa-list"></i>
                        </div>

                        <h3>Rekap PPKS Per Jenis</h3>
                        <p>Kelola angka PPKS berdasarkan jenis kategori untuk tahun 2015 sampai 2025.</p>
                    </div>

                    <span class="ppks-mode-action">
                        Kelola Data
                        <i class="fa fa-arrow-right"></i>
                    </span>
                </a>
            </div>
        </div>
    @endif

    {{--
    |--------------------------------------------------------------------------
    | MODE REKAP KABUPATEN/KOTA
    |--------------------------------------------------------------------------
    | Menampilkan form tambah dan tabel edit rekap PPKS per kabupaten/kota.
    |--------------------------------------------------------------------------
    --}}
    @if(($mode ?? 'cards') === 'kabupaten')
        <div class="ppks-header-row">
            <h2 class="ppks-page-title">Rekap PPKS Per Kabupaten/Kota</h2>

            <a href="{{ route('admin.ppks.index') }}" class="ppks-back-link">
                <i class="fa fa-arrow-left"></i>
                Kembali ke Cardboard
            </a>
        </div>

        {{--
        |--------------------------------------------------------------------------
        | FORM TAMBAH KABUPATEN/KOTA
        |--------------------------------------------------------------------------
        | Menambahkan kabupaten/kota baru ke rekap PPKS.
        |--------------------------------------------------------------------------
        --}}
        <div class="ppks-card ppks-overflow-visible">
            <h2>Tambah Data</h2>
            <p>Pilih kabupaten/kota. Setelah ditambahkan, nilai tahun 2015 sampai 2025 bisa diedit di tabel.</p>

            <form action="{{ route('admin.ppks.kabupaten.store') }}" method="POST" class="ppks-form-grid">
                @csrf

                <div class="ppks-form-group">
                    <label>Kabupaten/Kota *</label>

                    <input type="hidden" name="kabupaten_id" id="ppks-add-kabupaten-id" required>

                    {{--
                    |--------------------------------------------------------------------------
                    | DROPDOWN KABUPATEN/KOTA
                    |--------------------------------------------------------------------------
                    | Custom dropdown untuk memilih kabupaten/kota yang akan ditambahkan.
                    |--------------------------------------------------------------------------
                    --}}
                    <div class="modern-select" data-modern-select data-target="ppks-add-kabupaten-id">
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
                                    <div
                                        class="modern-select-option"
                                        data-modern-option
                                        data-value="{{ $kabupaten->id }}"
                                        data-label="{{ $kabupaten->nama_kabupaten }}"
                                    >
                                        {{ $kabupaten->nama_kabupaten }}
                                    </div>
                                @endforeach

                                <div class="modern-select-empty">Data tidak ditemukan</div>
                            </div>
                        </div>
                    </div>
                </div>

                <button type="submit" class="ppks-submit-btn">
                    <i class="fa fa-plus"></i>
                    Tambah Kabupaten/Kota
                </button>
            </form>
        </div>

        {{--
        |--------------------------------------------------------------------------
        | TABEL EDIT REKAP KABUPATEN/KOTA
        |--------------------------------------------------------------------------
        | Menampilkan data rekap kabupaten/kota dan input jumlah per tahun.
        |--------------------------------------------------------------------------
        --}}
        <div class="ppks-card ppks-overflow-hidden">
            <h2>Edit Data</h2>
            <p>Ubah angka PPKS berdasarkan kabupaten/kota dan tahun.</p>

            <form method="GET" action="{{ route('admin.ppks.index') }}" class="ppks-search-row">
                <input type="hidden" name="mode" value="kabupaten">

                <input
                    type="text"
                    name="search"
                    value="{{ $search ?? '' }}"
                    placeholder="Cari kabupaten/kota..."
                >

                <button type="submit">
                    <i class="fa fa-search"></i>
                    Cari
                </button>

                <a href="{{ route('admin.ppks.index', ['mode' => 'kabupaten']) }}">
                    Reset
                </a>
            </form>

            <div class="ppks-scroll-note">
                <i class="fa fa-arrows-left-right"></i>
                Geser tabel kanan/kiri untuk mengedit tahun 2015 sampai 2025.
            </div>

            <div class="ppks-scroll-buttons">
                <button type="button" data-scroll-left="ppks-kabupaten">
                    <i class="fa fa-arrow-left"></i>
                    Geser Kiri
                </button>

                <button type="button" data-scroll-right="ppks-kabupaten">
                    Geser Kanan
                    <i class="fa fa-arrow-right"></i>
                </button>
            </div>

            <div class="ppks-table-viewport">
                <div class="ppks-table-scroll" data-scroll-area="ppks-kabupaten">
                    <table class="ppks-wide-table">
                        <thead>
                            <tr>
                                <th class="sticky-no">No</th>
                                <th class="sticky-name">Kabupaten/Kota</th>
                                @foreach($years as $year)
                                    <th>{{ $year }}</th>
                                @endforeach
                                <th>Aksi</th>
                            </tr>
                        </thead>

                        <tbody>
                            @forelse($kabupatenRows as $index => $row)
                                @php
                                    /*
                                    |--------------------------------------------------------------------------
                                    | FORM ID KABUPATEN/KOTA
                                    |--------------------------------------------------------------------------
                                    | Membuat ID form update dan delete untuk setiap baris rekap kabupaten/kota.
                                    |--------------------------------------------------------------------------
                                    */

                                    $updateFormId = 'form-ppks-kabupaten-update-' . $row->id;
                                    $deleteFormId = 'form-ppks-kabupaten-delete-' . $row->id;
                                @endphp

                                <tr>
                                    <td class="sticky-no">
                                        {{ method_exists($kabupatenRows, 'firstItem') ? $kabupatenRows->firstItem() + $index : $index + 1 }}
                                    </td>

                                    <td class="sticky-name">
                                        {{ $row->nama_kabupaten }}
                                    </td>

                                    @foreach($years as $year)
                                        <td>
                                            <input
                                                form="{{ $updateFormId }}"
                                                type="number"
                                                name="jumlah[{{ $year }}]"
                                                class="ppks-year-input"
                                                value="{{ $row->year_values[$year] ?? 0 }}"
                                                min="0"
                                                required
                                            >
                                        </td>
                                    @endforeach

                                    <td>
                                        <div class="ppks-action-group">
                                            <button form="{{ $updateFormId }}" type="submit" class="ppks-save-btn" title="Simpan">
                                                <i class="fa fa-save"></i>
                                            </button>

                                            <button form="{{ $deleteFormId }}" type="submit" class="ppks-delete-btn" title="Hapus">
                                                <i class="fa fa-trash"></i>
                                            </button>
                                        </div>

                                        <form id="{{ $updateFormId }}" action="{{ route('admin.ppks.kabupaten.update', $row->id) }}" method="POST" style="display:none;">
                                            @csrf
                                            @method('PUT')
                                        </form>

                                        <form
                                            id="{{ $deleteFormId }}"
                                            action="{{ route('admin.ppks.kabupaten.destroy', $row->id) }}"
                                            method="POST"
                                            style="display:none;"
                                            onsubmit="return confirm('Yakin ingin menghapus rekap kabupaten/kota ini?')"
                                        >
                                            @csrf
                                            @method('DELETE')
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="{{ count($years) + 3 }}" style="padding: 28px; text-align: center; color: #64748b;">
                                        Belum ada data rekap PPKS per kabupaten/kota.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            {{--
            |--------------------------------------------------------------------------
            | PAGINATION KABUPATEN/KOTA
            |--------------------------------------------------------------------------
            | Menampilkan informasi jumlah data dan navigasi halaman rekap kabupaten/kota.
            |--------------------------------------------------------------------------
            --}}
            @if(method_exists($kabupatenRows, 'total'))
                <div class="custom-pagination">
                    <div class="pagination-info">
                        @if($kabupatenRows->total() > 0)
                            Menampilkan {{ $kabupatenRows->firstItem() }} - {{ $kabupatenRows->lastItem() }} dari {{ $kabupatenRows->total() }} data
                        @else
                            Belum ada data
                        @endif
                    </div>

                    @if($kabupatenRows->lastPage() > 1)
                        <div class="pagination-links">
                            @if($kabupatenRows->onFirstPage())
                                <span class="page-link-disabled">Previous</span>
                            @else
                                <a class="page-link-custom" href="{{ $kabupatenRows->previousPageUrl() }}">Previous</a>
                            @endif

                            @php
                                $start = max($kabupatenRows->currentPage() - 2, 1);
                                $end = min($kabupatenRows->currentPage() + 2, $kabupatenRows->lastPage());
                            @endphp

                            @if($start > 1)
                                <a class="page-link-custom" href="{{ $kabupatenRows->url(1) }}">1</a>
                                @if($start > 2)
                                    <span class="page-link-disabled">...</span>
                                @endif
                            @endif

                            @for($page = $start; $page <= $end; $page++)
                                @if($page === $kabupatenRows->currentPage())
                                    <span class="page-link-active">{{ $page }}</span>
                                @else
                                    <a class="page-link-custom" href="{{ $kabupatenRows->url($page) }}">{{ $page }}</a>
                                @endif
                            @endfor

                            @if($end < $kabupatenRows->lastPage())
                                @if($end < $kabupatenRows->lastPage() - 1)
                                    <span class="page-link-disabled">...</span>
                                @endif
                                <a class="page-link-custom" href="{{ $kabupatenRows->url($kabupatenRows->lastPage()) }}">{{ $kabupatenRows->lastPage() }}</a>
                            @endif

                            @if($kabupatenRows->hasMorePages())
                                <a class="page-link-custom" href="{{ $kabupatenRows->nextPageUrl() }}">Next</a>
                            @else
                                <span class="page-link-disabled">Next</span>
                            @endif
                        </div>
                    @endif
                </div>
            @endif
        </div>
    @endif

    {{--
    |--------------------------------------------------------------------------
    | MODE REKAP JENIS
    |--------------------------------------------------------------------------
    | Menampilkan form tambah dan tabel edit rekap PPKS per jenis.
    |--------------------------------------------------------------------------
    --}}
    @if(($mode ?? 'cards') === 'jenis')
        <div class="ppks-header-row">
            <h2 class="ppks-page-title">Rekap PPKS Per Jenis</h2>

            <a href="{{ route('admin.ppks.index') }}" class="ppks-back-link">
                <i class="fa fa-arrow-left"></i>
                Kembali ke Cardboard
            </a>
        </div>

        {{--
        |--------------------------------------------------------------------------
        | FORM TAMBAH JENIS PPKS
        |--------------------------------------------------------------------------
        | Menambahkan jenis PPKS baru ke tabel rekap jenis.
        |--------------------------------------------------------------------------
        --}}
        <div class="ppks-card ppks-overflow-visible">
            <h2>Tambah Data</h2>
            <p>Masukkan jenis PPKS. Setelah ditambahkan, nilai tahun 2015 sampai 2025 bisa diedit di tabel.</p>

            <form action="{{ route('admin.ppks.jenis.store') }}" method="POST" class="ppks-form-grid">
                @csrf

                <div class="ppks-form-group">
                    <label>Jenis PPKS *</label>
                    <input
                        type="text"
                        name="jenis_ppks"
                        class="ppks-input"
                        placeholder="Contoh: Anak Balita Terlantar (ABT)"
                        required
                    >
                </div>

                <button type="submit" class="ppks-submit-btn">
                    <i class="fa fa-plus"></i>
                    Tambah Jenis PPKS
                </button>
            </form>
        </div>

        {{--
        |--------------------------------------------------------------------------
        | TABEL EDIT REKAP JENIS
        |--------------------------------------------------------------------------
        | Menampilkan data rekap jenis dan input jumlah per tahun.
        |--------------------------------------------------------------------------
        --}}
        <div class="ppks-card ppks-overflow-hidden">
            <h2>Edit Data</h2>
            <p>Ubah angka PPKS berdasarkan jenis dan tahun.</p>

            <form method="GET" action="{{ route('admin.ppks.index') }}" class="ppks-search-row">
                <input type="hidden" name="mode" value="jenis">

                <input
                    type="text"
                    name="search"
                    value="{{ $search ?? '' }}"
                    placeholder="Cari jenis PPKS..."
                >

                <button type="submit">
                    <i class="fa fa-search"></i>
                    Cari
                </button>

                <a href="{{ route('admin.ppks.index', ['mode' => 'jenis']) }}">
                    Reset
                </a>
            </form>

            <div class="ppks-scroll-note">
                <i class="fa fa-arrows-left-right"></i>
                Geser tabel kanan/kiri untuk mengedit tahun 2015 sampai 2025.
            </div>

            <div class="ppks-scroll-buttons">
                <button type="button" data-scroll-left="ppks-jenis">
                    <i class="fa fa-arrow-left"></i>
                    Geser Kiri
                </button>

                <button type="button" data-scroll-right="ppks-jenis">
                    Geser Kanan
                    <i class="fa fa-arrow-right"></i>
                </button>
            </div>

            <div class="ppks-table-viewport">
                <div class="ppks-table-scroll" data-scroll-area="ppks-jenis">
                    <table class="ppks-wide-table">
                        <thead>
                            <tr>
                                <th class="sticky-no">No</th>
                                <th class="sticky-name">Jenis PPKS</th>
                                @foreach($years as $year)
                                    <th>{{ $year }}</th>
                                @endforeach
                                <th>Aksi</th>
                            </tr>
                        </thead>

                        <tbody>
                            @forelse($jenisRows as $index => $row)
                                @php
                                    /*
                                    |--------------------------------------------------------------------------
                                    | FORM ID JENIS PPKS
                                    |--------------------------------------------------------------------------
                                    | Membuat ID form update dan delete berdasarkan hash jenis PPKS.
                                    |--------------------------------------------------------------------------
                                    */

                                    $safeKey = md5($row->jenis_ppks);
                                    $updateFormId = 'form-ppks-jenis-update-' . $safeKey;
                                    $deleteFormId = 'form-ppks-jenis-delete-' . $safeKey;
                                @endphp

                                <tr>
                                    <td class="sticky-no">
                                        {{ method_exists($jenisRows, 'firstItem') ? $jenisRows->firstItem() + $index : $index + 1 }}
                                    </td>

                                    <td class="sticky-name">
                                        <input
                                            form="{{ $updateFormId }}"
                                            type="hidden"
                                            name="jenis_key"
                                            value="{{ $row->jenis_ppks }}"
                                        >

                                        <input
                                            form="{{ $updateFormId }}"
                                            type="text"
                                            name="jenis_ppks"
                                            class="ppks-name-input"
                                            value="{{ $row->jenis_ppks }}"
                                            required
                                        >
                                    </td>

                                    @foreach($years as $year)
                                        <td>
                                            <input
                                                form="{{ $updateFormId }}"
                                                type="number"
                                                name="jumlah[{{ $year }}]"
                                                class="ppks-year-input"
                                                value="{{ $row->year_values[$year] ?? 0 }}"
                                                min="0"
                                                required
                                            >
                                        </td>
                                    @endforeach

                                    <td>
                                        <div class="ppks-action-group">
                                            <button form="{{ $updateFormId }}" type="submit" class="ppks-save-btn" title="Simpan">
                                                <i class="fa fa-save"></i>
                                            </button>

                                            <button form="{{ $deleteFormId }}" type="submit" class="ppks-delete-btn" title="Hapus">
                                                <i class="fa fa-trash"></i>
                                            </button>
                                        </div>

                                        <form id="{{ $updateFormId }}" action="{{ route('admin.ppks.jenis.update') }}" method="POST" style="display:none;">
                                            @csrf
                                            @method('PUT')
                                        </form>

                                        <form
                                            id="{{ $deleteFormId }}"
                                            action="{{ route('admin.ppks.jenis.destroy') }}"
                                            method="POST"
                                            style="display:none;"
                                            onsubmit="return confirm('Yakin ingin menghapus jenis PPKS ini?')"
                                        >
                                            @csrf
                                            @method('DELETE')
                                            <input type="hidden" name="jenis_key" value="{{ $row->jenis_ppks }}">
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="{{ count($years) + 3 }}" style="padding: 28px; text-align: center; color: #64748b;">
                                        Belum ada data rekap PPKS per jenis.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            {{--
            |--------------------------------------------------------------------------
            | PAGINATION JENIS
            |--------------------------------------------------------------------------
            | Menampilkan informasi jumlah data dan navigasi halaman rekap jenis.
            |--------------------------------------------------------------------------
            --}}
            @if(method_exists($jenisRows, 'total'))
                <div class="custom-pagination">
                    <div class="pagination-info">
                        @if($jenisRows->total() > 0)
                            Menampilkan {{ $jenisRows->firstItem() }} - {{ $jenisRows->lastItem() }} dari {{ $jenisRows->total() }} data
                        @else
                            Belum ada data
                        @endif
                    </div>

                    @if($jenisRows->lastPage() > 1)
                        <div class="pagination-links">
                            @if($jenisRows->onFirstPage())
                                <span class="page-link-disabled">Previous</span>
                            @else
                                <a class="page-link-custom" href="{{ $jenisRows->previousPageUrl() }}">Previous</a>
                            @endif

                            @php
                                $start = max($jenisRows->currentPage() - 2, 1);
                                $end = min($jenisRows->currentPage() + 2, $jenisRows->lastPage());
                            @endphp

                            @if($start > 1)
                                <a class="page-link-custom" href="{{ $jenisRows->url(1) }}">1</a>
                                @if($start > 2)
                                    <span class="page-link-disabled">...</span>
                                @endif
                            @endif

                            @for($page = $start; $page <= $end; $page++)
                                @if($page === $jenisRows->currentPage())
                                    <span class="page-link-active">{{ $page }}</span>
                                @else
                                    <a class="page-link-custom" href="{{ $jenisRows->url($page) }}">{{ $page }}</a>
                                @endif
                            @endfor

                            @if($end < $jenisRows->lastPage())
                                @if($end < $jenisRows->lastPage() - 1)
                                    <span class="page-link-disabled">...</span>
                                @endif
                                <a class="page-link-custom" href="{{ $jenisRows->url($jenisRows->lastPage()) }}">{{ $jenisRows->lastPage() }}</a>
                            @endif

                            @if($jenisRows->hasMorePages())
                                <a class="page-link-custom" href="{{ $jenisRows->nextPageUrl() }}">Next</a>
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
    | Menjalankan custom dropdown dan fitur scroll horizontal setelah halaman siap.
    |--------------------------------------------------------------------------
    */

    document.addEventListener('DOMContentLoaded', function () {
        initModernSelect();
        initPpksHorizontalScroll();
    });

    /*
    |--------------------------------------------------------------------------
    | CLOSE MODERN SELECT
    |--------------------------------------------------------------------------
    | Menutup dropdown modern dan mengembalikan menu ke parent awal.
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
    | Menutup semua dropdown modern yang sedang terbuka.
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
    | Mengaktifkan custom dropdown kabupaten/kota lengkap dengan search dan portal.
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
            | Memindahkan dropdown ke body agar tidak terpotong oleh card atau tabel.
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
            | Mengatur posisi dropdown berdasarkan posisi trigger yang diklik.
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
            | Mengosongkan pencarian dan menampilkan ulang seluruh pilihan.
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
            | Membuka dropdown, mengatur posisi, dan memberi fokus ke search input.
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
            | EVENT TRIGGER
            |--------------------------------------------------------------------------
            | Membuka dropdown ketika trigger diklik.
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
            | Mencegah klik, mousedown, dan scroll dalam dropdown menutup menu.
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
            | Mengisi hidden input dan label dropdown sesuai pilihan yang dipilih.
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
            | Menyaring daftar kabupaten/kota berdasarkan keyword yang diketik.
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
        | Menutup dropdown saat klik luar, tekan Escape, resize, atau scroll halaman.
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
    }

    /*
    |--------------------------------------------------------------------------
    | INIT HORIZONTAL SCROLL
    |--------------------------------------------------------------------------
    | Mengaktifkan scroll horizontal tabel menggunakan tombol, touchpad, dan drag mouse.
    |--------------------------------------------------------------------------
    */

    function initPpksHorizontalScroll() {
        const scrollStep = 980;
        const touchpadSpeed = 2.5;
        const dragSpeed = 2.4;
        const animationDuration = 650;

        function getScrollArea(type) {
            return document.querySelector('[data-scroll-area="' + type + '"]');
        }

        function easeOutCubic(t) {
            return 1 - Math.pow(1 - t, 3);
        }

        /*
        |--------------------------------------------------------------------------
        | ANIMATED HORIZONTAL SCROLL
        |--------------------------------------------------------------------------
        | Menggeser tabel secara halus saat tombol geser kiri atau kanan diklik.
        |--------------------------------------------------------------------------
        */

        function animateHorizontalScroll(area, distance, duration) {
            if (!area) {
                return;
            }

            if (area._scrollAnimationFrame) {
                cancelAnimationFrame(area._scrollAnimationFrame);
            }

            const startLeft = area.scrollLeft;
            const maxLeft = area.scrollWidth - area.clientWidth;
            const targetLeft = Math.max(0, Math.min(startLeft + distance, maxLeft));
            const change = targetLeft - startLeft;
            const startTime = performance.now();

            function animate(now) {
                const elapsed = now - startTime;
                const progress = Math.min(elapsed / duration, 1);
                const eased = easeOutCubic(progress);

                area.scrollLeft = startLeft + (change * eased);

                if (progress < 1) {
                    area._scrollAnimationFrame = requestAnimationFrame(animate);
                }
            }

            area._scrollAnimationFrame = requestAnimationFrame(animate);
        }

        /*
        |--------------------------------------------------------------------------
        | BUTTON SCROLL LEFT
        |--------------------------------------------------------------------------
        | Menggeser tabel ke kiri berdasarkan tombol yang diklik.
        |--------------------------------------------------------------------------
        */

        document.querySelectorAll('[data-scroll-left]').forEach(function (button) {
            button.addEventListener('click', function () {
                closeAllModernSelects();

                const type = button.getAttribute('data-scroll-left');
                const area = getScrollArea(type);

                animateHorizontalScroll(area, -scrollStep, animationDuration);
            });
        });

        /*
        |--------------------------------------------------------------------------
        | BUTTON SCROLL RIGHT
        |--------------------------------------------------------------------------
        | Menggeser tabel ke kanan berdasarkan tombol yang diklik.
        |--------------------------------------------------------------------------
        */

        document.querySelectorAll('[data-scroll-right]').forEach(function (button) {
            button.addEventListener('click', function () {
                closeAllModernSelects();

                const type = button.getAttribute('data-scroll-right');
                const area = getScrollArea(type);

                animateHorizontalScroll(area, scrollStep, animationDuration);
            });
        });

        /*
        |--------------------------------------------------------------------------
        | TOUCHPAD HORIZONTAL SCROLL
        |--------------------------------------------------------------------------
        | Mempercepat scroll horizontal ketika pengguna memakai touchpad.
        |--------------------------------------------------------------------------
        */

        document.querySelectorAll('.ppks-table-scroll').forEach(function (slider) {
            slider.addEventListener('wheel', function (event) {
                const horizontalMove = Math.abs(event.deltaX);
                const verticalMove = Math.abs(event.deltaY);

                if (horizontalMove > verticalMove) {
                    slider.scrollLeft += event.deltaX * touchpadSpeed;
                    event.preventDefault();
                }
            }, { passive: false });
        });

        /*
        |--------------------------------------------------------------------------
        | DRAG TABLE SCROLL
        |--------------------------------------------------------------------------
        | Mengaktifkan geser tabel horizontal dengan klik tahan dan drag mouse.
        |--------------------------------------------------------------------------
        */

        document.querySelectorAll('.ppks-table-scroll').forEach(function (slider) {
            let isDown = false;
            let startX;
            let scrollLeft;

            slider.addEventListener('mousedown', function (event) {
                if (
                    event.target.closest('input') ||
                    event.target.closest('button') ||
                    event.target.closest('a') ||
                    event.target.closest('[data-modern-select]')
                ) {
                    return;
                }

                closeAllModernSelects();

                isDown = true;
                slider.classList.add('dragging');
                startX = event.pageX - slider.offsetLeft;
                scrollLeft = slider.scrollLeft;
            });

            function stopDragging() {
                isDown = false;
                slider.classList.remove('dragging');
            }

            slider.addEventListener('mouseleave', stopDragging);
            slider.addEventListener('mouseup', stopDragging);
            document.addEventListener('mouseup', stopDragging);

            slider.addEventListener('mousemove', function (event) {
                if (!isDown) {
                    return;
                }

                event.preventDefault();

                const x = event.pageX - slider.offsetLeft;
                const walk = (x - startX) * dragSpeed;

                slider.scrollLeft = scrollLeft - walk;
            });
        });
    }
</script>
@endsection