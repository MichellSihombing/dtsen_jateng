{{-- HALAMAN BERANDA --}}
{{-- LAYOUT YANG DIGUNAKAN --}}
@extends('layouts.app')

{{-- JUDUL HALAMAN --}}
@section('title', 'Beranda - DTSEN Jawa Tengah')

{{-- STYLE HALAMAN --}}
@push('styles')
{{-- STYLE CSS --}}
<style>
    .hero-section {
        background: #ffffff;
        padding: 40px 0 44px;
    }

    .ilustrasi-col {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        min-height: 340px;
    }

    .ilustrasi-col img {
        width: 220px;
        max-width: 100%;
        animation: fadeInUp 0.6s ease both;
    }

    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(24px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    @keyframes slideInLeft {
        from {
            opacity: 0;
            transform: translateX(-16px);
        }

        to {
            opacity: 1;
            transform: translateX(0);
        }
    }

    @keyframes slideInRight {
        from {
            opacity: 0;
            transform: translateX(16px);
        }

        to {
            opacity: 1;
            transform: translateX(0);
        }
    }

    @keyframes dropdownPop {
        from {
            opacity: 0;
            transform: translateY(-10px) scale(0.98);
        }

        to {
            opacity: 1;
            transform: translateY(0) scale(1);
        }
    }

    @keyframes modalFade {
        from {
            opacity: 0;
        }

        to {
            opacity: 1;
        }
    }

    @keyframes modalPop {
        from {
            opacity: 0;
            transform: translateY(18px) scale(0.94);
        }

        to {
            opacity: 1;
            transform: translateY(0) scale(1);
        }
    }

    .cek-title {
        font-size: 26px;
        font-weight: 800;
        color: #1565C0;
        margin-bottom: 2px;
        text-align: center;
        animation: fadeInUp 0.5s ease both;
    }

    .cek-subtitle {
        font-size: 13px;
        color: #6C757D;
        margin-bottom: 20px;
        text-align: center;
        animation: fadeInUp 0.5s ease 0.1s both;
    }

    .card-cek {
        background: #fff;
        border-radius: 12px;
        border: 1px solid #DEE2E6;
        overflow: visible;
        animation: fadeInUp 0.5s ease 0.15s both;
        transition: box-shadow 0.3s;
        position: relative;
        z-index: 10;
    }

    .card-cek:hover {
        box-shadow: 0 8px 32px rgba(21, 101, 192, 0.10);
    }

    .tab-cek {
        display: flex;
        border-bottom: 1px solid #DEE2E6;
        overflow: hidden;
        border-radius: 12px 12px 0 0;
    }

    .tab-btn {
        flex: 1;
        padding: 14px 16px;
        background: #f8f9fa;
        border: none;
        font-family: 'Plus Jakarta Sans', sans-serif;
        font-size: 13px;
        font-weight: 600;
        color: #6C757D;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        border-bottom: 2px solid transparent;
        margin-bottom: -1px;
        transition: color 0.25s, background 0.25s, border-color 0.25s;
    }

    .tab-btn.active {
        background: #fff;
        color: #1565C0;
        border-bottom: 2px solid #1565C0;
    }

    .tab-btn .tab-icon {
        width: 20px;
        height: 20px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 10px;
        background: #E3F2FD;
        color: #1565C0;
        transition: background 0.25s, color 0.25s, transform 0.25s;
    }

    .tab-btn.active .tab-icon {
        background: #1565C0;
        color: #fff;
        transform: scale(1.15);
    }

    .tab-btn.spmb .tab-icon {
        background: #E8F5E9;
        color: #2E7D32;
    }

    .tab-btn.spmb.active {
        color: #2E7D32;
        border-bottom-color: #2E7D32;
    }

    .tab-btn.spmb.active .tab-icon {
        background: #2E7D32;
        color: #fff;
    }

    .tab-body {
        padding: 20px;
        position: relative;
        z-index: 15;
    }

    .tab-body.anim-left {
        animation: slideInLeft 0.28s ease both;
    }

    .tab-body.anim-right {
        animation: slideInRight 0.28s ease both;
    }

    .tab-label {
        font-size: 13px;
        font-weight: 700;
        color: #1565C0;
        margin-bottom: 14px;
    }

    .error-box {
        margin-bottom: 16px;
        border-radius: 12px;
        background: #FEE2E2;
        border: 1px solid #FCA5A5;
        color: #991B1B;
        padding: 12px 14px;
        font-size: 13px;
        font-weight: 700;
        animation: fadeInUp 0.35s ease both;
    }

    .error-box ul {
        padding-left: 18px;
        margin: 0;
    }

    .form-control-dtsen {
        width: 100%;
        border: 1px solid #C9D8EC;
        border-radius: 10px;
        padding: 10px 14px;
        font-family: 'Plus Jakarta Sans', sans-serif;
        font-size: 13.5px;
        color: #212529;
        background-color: #fff;
        margin-bottom: 10px;
        transition: border-color 0.2s, box-shadow 0.2s, transform 0.15s;
    }

    .form-control-dtsen:focus {
        outline: none;
        border-color: #1565C0;
        box-shadow: 0 0 0 3px rgba(21, 101, 192, 0.10);
        transform: translateY(-1px);
    }

    .nik-wrapper {
        position: relative;
        margin-bottom: 10px;
    }

    .nik-wrapper .nik-icon {
        position: absolute;
        left: 13px;
        top: 50%;
        transform: translateY(-50%);
        color: #90CAF9;
        font-size: 13px;
    }

    .nik-wrapper .form-control-dtsen {
        padding-left: 36px;
        margin-bottom: 0;
    }

    .modern-select {
        position: relative;
        width: 100%;
        margin-bottom: 10px;
        z-index: 20;
    }

    .modern-select.is-open {
        z-index: 999;
    }

    .modern-select.is-disabled {
        opacity: 0.68;
        pointer-events: none;
    }

    .modern-select-trigger {
        width: 100%;
        min-height: 46px;
        border: 1px solid #C9D8EC;
        border-radius: 12px;
        background: rgba(255, 255, 255, 0.96);
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 12px;
        padding: 0 12px 0 14px;
        cursor: pointer;
        transition: 0.25s ease;
        box-shadow: 0 8px 22px rgba(21, 101, 192, 0.04);
    }

    .modern-select-trigger:hover {
        border-color: #90CAF9;
        box-shadow: 0 12px 28px rgba(21, 101, 192, 0.10);
        transform: translateY(-1px);
    }

    .modern-select.is-open .modern-select-trigger {
        border-color: #1565C0;
        box-shadow: 0 0 0 3px rgba(21, 101, 192, 0.10), 0 16px 38px rgba(21, 101, 192, 0.14);
    }

    .modern-select-value {
        font-size: 13.5px;
        font-weight: 650;
        color: #212529;
        overflow: hidden;
        white-space: nowrap;
        text-overflow: ellipsis;
        display: block;
        background: transparent !important;
        opacity: 1 !important;
    }

    .modern-select-value.is-placeholder {
        color: #7b8a9c;
        font-weight: 600;
    }

    .modern-select-icon {
        width: 30px;
        height: 30px;
        border-radius: 999px;
        background: #E3F2FD;
        color: #1565C0;
        display: grid;
        place-items: center;
        flex-shrink: 0;
        transition: 0.25s ease;
    }

    .modern-select.is-open .modern-select-icon {
        background: #1565C0;
        color: #fff;
        transform: rotate(180deg);
    }

    .modern-select-menu {
        position: absolute;
        top: calc(100% + 10px);
        left: 0;
        right: 0;
        background: rgba(255, 255, 255, 0.98);
        border: 1px solid #DCE8F7;
        border-radius: 18px;
        box-shadow: 0 26px 70px rgba(15, 23, 42, 0.18);
        backdrop-filter: blur(14px);
        padding: 10px;
        visibility: hidden;
        opacity: 0;
        transform: translateY(-10px) scale(0.98);
        transition: 0.24s cubic-bezier(.2, .8, .2, 1);
        z-index: 9999;
    }

    .modern-select.is-open .modern-select-menu {
        visibility: visible;
        opacity: 1;
        transform: translateY(0) scale(1);
        animation: dropdownPop 0.22s ease both;
    }

    .modern-select-search-box {
        position: relative;
        margin-bottom: 8px;
    }

    .modern-select-search-box i {
        position: absolute;
        top: 50%;
        left: 14px;
        transform: translateY(-50%);
        color: #90CAF9;
        font-size: 12px;
        pointer-events: none;
        z-index: 2;
    }

    .modern-select-search {
        width: 100%;
        height: 42px;
        border: 1px solid #DCE8F7;
        border-radius: 14px;
        outline: none;
        padding: 0 13px 0 40px;
        font-family: 'Plus Jakarta Sans', sans-serif;
        font-size: 13px;
        font-weight: 650;
        color: #212529;
        background: #F8FBFF;
        transition: 0.22s ease;
    }

    .modern-select-search:focus {
        border-color: #1565C0;
        background: #ffffff;
        box-shadow: 0 0 0 3px rgba(21, 101, 192, 0.09);
    }

    .modern-select-options {
        max-height: 245px;
        overflow-y: auto;
        padding-right: 4px;
    }

    .modern-option {
        min-height: 42px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 10px;
        padding: 10px 12px;
        border-radius: 13px;
        cursor: pointer;
        font-size: 13px;
        font-weight: 700;
        color: #334155;
        transition: 0.18s ease;
    }

    .modern-option:hover {
        background: #E3F2FD;
        color: #1565C0;
        transform: translateX(3px);
    }

    .modern-option.selected {
        background: linear-gradient(135deg, #1565C0, #42A5F5);
        color: #fff;
        box-shadow: 0 12px 26px rgba(21, 101, 192, 0.20);
    }

    .modern-option.selected::after {
        content: "✓";
        width: 22px;
        height: 22px;
        border-radius: 999px;
        background: rgba(255, 255, 255, 0.22);
        display: grid;
        place-items: center;
        font-size: 11px;
        flex-shrink: 0;
    }

    .modern-select-empty,
    .modern-select-loading {
        padding: 14px 12px;
        text-align: center;
        color: #7b8a9c;
        font-size: 13px;
        font-weight: 700;
    }

    .modern-select-empty {
        display: none;
    }

    .modern-select.no-result .modern-select-empty {
        display: block;
    }

    .select-loading {
        opacity: 0.75;
        pointer-events: none;
    }

    .btn-cari {
        background: #1565C0;
        color: #fff;
        border: none;
        border-radius: 10px;
        padding: 10px 24px;
        font-family: 'Plus Jakarta Sans', sans-serif;
        font-size: 13.5px;
        font-weight: 700;
        cursor: pointer;
        margin-top: 4px;
        transition: background 0.2s, transform 0.15s, box-shadow 0.2s;
    }

    .btn-cari:hover {
        background: #0D47A1;
        transform: translateY(-2px);
        box-shadow: 0 4px 14px rgba(21, 101, 192, 0.35);
    }

    .btn-cari.loading {
        pointer-events: none;
        opacity: 0.8;
    }

    .btn-cari-spmb {
        background: #2E7D32;
    }

    .btn-cari-spmb:hover {
        background: #1B5E20;
        box-shadow: 0 4px 14px rgba(46, 125, 50, 0.35);
    }

    .info-section {
        border-top: 1px solid #b0c4de;
        border-bottom: 1px solid #b0c4de;
        padding: 32px 0;
        background: #fff;
    }

    .info-title {
        font-size: 28px;
        font-weight: 800;
        color: #111;
        text-align: center;
        line-height: 1.3;
        margin-bottom: 8px;
    }

    .info-subtitle {
        font-size: 13px;
        color: #6C757D;
        text-align: center;
        margin: 0;
    }

    .result-modal-overlay,
    .spmb-result-overlay {
        position: fixed;
        inset: 0;
        background:
            radial-gradient(circle at top, rgba(37, 99, 235, 0.20), transparent 42%),
            rgba(15, 23, 42, 0.62);
        backdrop-filter: blur(10px);
        -webkit-backdrop-filter: blur(10px);
        display: none;
        align-items: center;
        justify-content: center;
        padding: 20px;
        z-index: 99999;
    }

    .result-modal-overlay.show,
    .spmb-result-overlay.show {
        display: flex;
        animation: modalFade 0.18s ease both;
    }

    .result-modal-card,
    .spmb-result-card {
        position: relative;
        width: 520px;
        max-width: 100%;
        background: #ffffff;
        border-radius: 28px;
        padding: 0;
        box-shadow:
            0 28px 80px rgba(15, 23, 42, 0.28),
            0 0 0 1px rgba(226, 232, 240, 0.85);
        overflow: hidden;
        animation: modalPop 0.24s ease both;
    }

    .result-modal-top,
    .spmb-result-top {
        position: relative;
        padding: 36px 30px 30px;
        color: #ffffff;
        overflow: hidden;
        text-align: center;
        display: flex;
        flex-direction: column;
        align-items: center;
    }

    .result-modal-top {
        background: linear-gradient(135deg, rgba(21, 101, 192, 0.98), rgba(14, 165, 233, 0.95));
    }

    .spmb-result-top.success {
        background: linear-gradient(135deg, #1565C0, #22C1DC);
    }

    .spmb-result-top.failed {
        background: linear-gradient(135deg, #DC2626, #F97316);
    }

    .spmb-result-top::before,
    .result-modal-top::before {
        content: "";
        position: absolute;
        width: 220px;
        height: 220px;
        border-radius: 999px;
        right: -90px;
        top: -110px;
        background: rgba(255, 255, 255, 0.16);
    }

    .spmb-result-top::after,
    .result-modal-top::after {
        content: "";
        position: absolute;
        width: 130px;
        height: 130px;
        border-radius: 999px;
        left: -60px;
        bottom: -70px;
        background: rgba(255, 255, 255, 0.13);
    }

    .result-modal-close,
    .spmb-result-close {
        position: absolute;
        top: 16px;
        right: 16px;
        width: 38px;
        height: 38px;
        border: none;
        border-radius: 999px;
        background: rgba(255, 255, 255, 0.18);
        color: #ffffff;
        display: grid;
        place-items: center;
        cursor: pointer;
        transition: 0.2s ease;
        z-index: 5;
        font-size: 18px;
        font-weight: 900;
        line-height: 1;
    }

    .result-modal-close:hover,
    .spmb-result-close:hover {
        background: rgba(255, 255, 255, 0.28);
        transform: rotate(90deg) scale(1.05);
    }

    .spmb-icon-circle {
        width: 82px;
        height: 82px;
        border-radius: 999px;
        display: grid;
        place-items: center;
        margin: 0 auto 18px;
        position: relative;
        z-index: 2;
        background: rgba(255, 255, 255, 0.18);
        border: 2px solid rgba(255, 255, 255, 0.42);
        box-shadow: 0 18px 35px rgba(15, 23, 42, 0.16);
    }

    .spmb-icon-symbol {
        width: 52px;
        height: 52px;
        border-radius: 999px;
        background: #ffffff;
        display: grid;
        place-items: center;
        font-size: 30px;
        font-weight: 950;
        line-height: 1;
        text-align: center;
    }

    .spmb-icon-circle.success .spmb-icon-symbol {
        color: #16A34A;
    }

    .spmb-icon-circle.failed .spmb-icon-symbol {
        color: #DC2626;
    }

    .result-modal-title,
    .spmb-result-title {
        position: relative;
        z-index: 2;
        margin: 0;
        font-size: 24px;
        font-weight: 900;
        letter-spacing: -0.5px;
        line-height: 1.25;
        text-align: center;
    }

    .result-modal-subtitle,
    .spmb-result-subtitle {
        position: relative;
        z-index: 2;
        margin: 8px 0 0;
        font-size: 13.5px;
        font-weight: 600;
        color: rgba(255, 255, 255, 0.86);
        line-height: 1.5;
        text-align: center;
        max-width: 390px;
    }

    .result-modal-body,
    .spmb-result-body {
        padding: 24px 30px 28px;
        background: #ffffff;
    }

    .result-summary-pill,
    .spmb-summary-pill {
        width: fit-content;
        max-width: 100%;
        margin-bottom: 14px;
        padding: 7px 14px;
        border-radius: 999px;
        background: #eff6ff;
        color: #1565C0;
        font-size: 12.5px;
        font-weight: 900;
        letter-spacing: 0.2px;
        text-transform: uppercase;
    }

    .result-summary-pill.failed,
    .spmb-summary-pill.failed {
        background: #fef2f2;
        color: #dc2626;
    }

    .result-list-modern,
    .spmb-result-list {
        display: grid;
        gap: 8px;
    }

    .result-row-modern,
    .spmb-result-row {
        display: grid;
        grid-template-columns: 145px 8px minmax(0, 1fr);
        align-items: center;
        column-gap: 6px;
        min-height: 46px;
        padding: 10px 14px;
        border-radius: 15px;
        background: #f8fafc;
        border: 1px solid #edf2f7;
        transition: 0.18s ease;
    }

    .result-row-modern:hover,
    .spmb-result-row:hover {
        background: #F1F5F9;
        transform: translateX(2px);
    }

    .result-label-modern,
    .spmb-result-label {
        color: #64748b;
        font-size: 13px;
        font-weight: 900;
        text-transform: uppercase;
        letter-spacing: 0.2px;
        white-space: nowrap;
        line-height: 1.2;
    }

    .result-colon-modern,
    .spmb-result-colon {
        color: #94a3b8;
        font-size: 14px;
        font-weight: 900;
        text-align: center;
        line-height: 1;
    }

    .result-value-modern,
    .spmb-result-value {
        color: #0f172a;
        font-size: 14px;
        font-weight: 900;
        line-height: 1.25;
        word-break: break-word;
        text-align: right;
    }

    .spmb-status-badge {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        padding: 7px 12px;
        border-radius: 999px;
        font-size: 12px;
        font-weight: 900;
        line-height: 1.2;
        white-space: nowrap;
    }

    .spmb-status-badge.success {
        background: #DCFCE7;
        color: #166534;
    }

    .spmb-status-badge.failed {
        background: #FEE2E2;
        color: #991B1B;
    }

    .not-found-modern {
        text-align: center;
        padding: 6px 8px 2px;
    }

    .not-found-title-modern {
        margin: 0 0 8px;
        color: #111827;
        font-size: 24px;
        font-weight: 950;
        letter-spacing: -0.3px;
    }

    .not-found-desc-modern {
        margin: 0 auto;
        max-width: 350px;
        color: #64748b;
        font-size: 14px;
        font-weight: 650;
        line-height: 1.6;
    }

    .result-modal-action,
    .spmb-result-action {
        margin-top: 20px;
        width: 100%;
        height: 46px;
        border: none;
        border-radius: 15px;
        background: #0f172a;
        color: #ffffff;
        font-size: 13.5px;
        font-weight: 900;
        cursor: pointer;
        transition: 0.2s ease;
    }

    .result-modal-action:hover,
    .spmb-result-action:hover {
        background: #020617;
        transform: translateY(-2px);
        box-shadow: 0 16px 28px rgba(15, 23, 42, 0.22);
    }

    @media (max-width: 767px) {
        .hero-section {
            padding: 28px 0 36px;
        }

        .ilustrasi-col {
            min-height: 180px;
            margin-bottom: 12px;
        }

        .ilustrasi-col img {
            width: 160px;
        }

        .cek-title {
            font-size: 23px;
        }

        .tab-btn {
            font-size: 11.5px;
            padding: 12px 8px;
        }

        .tab-body {
            padding: 16px;
        }

        .result-modal-card,
        .spmb-result-card {
            border-radius: 24px;
        }

        .result-modal-top,
        .spmb-result-top {
            padding: 30px 22px 24px;
        }

        .result-modal-body,
        .spmb-result-body {
            padding: 22px;
        }

        .result-modal-title,
        .spmb-result-title {
            font-size: 21px;
            padding-right: 0;
        }

        .result-modal-subtitle,
        .spmb-result-subtitle {
            font-size: 13px;
        }

        .result-row-modern,
        .spmb-result-row {
            grid-template-columns: 125px 8px minmax(0, 1fr);
            column-gap: 5px;
            min-height: 44px;
            padding: 10px 12px;
        }

        .result-label-modern,
        .spmb-result-label {
            font-size: 11.5px;
        }

        .result-value-modern,
        .spmb-result-value {
            font-size: 12.5px;
        }

        .spmb-icon-circle {
            width: 72px;
            height: 72px;
        }

        .spmb-icon-symbol {
            width: 46px;
            height: 46px;
            font-size: 26px;
        }
    }
</style>
@endpush

{{-- KONTEN HALAMAN --}}
@section('content')

<section class="hero-section">
    <div class="container">
        <div class="row align-items-center justify-content-center">

            <div class="col-md-4 col-lg-3">
                <div class="ilustrasi-col">
                    <img src="{{ asset('assets/icon1.png') }}" alt="Ilustrasi">
                </div>
            </div>

            <div class="col-md-8 col-lg-9">
                <h1 class="cek-title">Cek Kepesertaan DTSEN</h1>
                <p class="cek-subtitle">Masukkan wilayah dan NIK untuk mengecek data</p>

                {{-- KONDISI TAMPILAN --}}
@if($errors->any())
                    <div class="error-box">
                        <ul>
                            {{-- LOOPING DATA --}}
@foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <div class="card-cek">
                    <div class="tab-cek">
                        <button type="button" class="tab-btn {{ ($activeResultTab ?? 'nik') !== 'spmb' ? 'active' : '' }}" id="btn-nik" onclick="switchTab('nik', this)">
                            <span class="tab-icon"><i class="fas fa-id-card"></i></span>
                            Cek Kepesertaan DTSEN (NIK)
                        </button>

                        <button type="button" class="tab-btn spmb {{ ($activeResultTab ?? null) === 'spmb' ? 'active' : '' }}" id="btn-spmb" onclick="switchTab('spmb', this)">
                            <span class="tab-icon"><i class="fas fa-check-circle"></i></span>
                            Cek Status Afirmasi SPMB 2026
                        </button>
                    </div>

                    <div id="tab-nik" class="tab-body anim-left" style="{{ ($activeResultTab ?? 'nik') === 'spmb' ? 'display:none;' : '' }}">
                        <p class="tab-label">CEK Kepesertaan DT Jateng Berdasarkan NIK</p>

                        {{-- FORM INPUT DATA --}}
<form action="{{ route('cek.kepesertaan') }}" method="POST" id="form-nik">
                            @csrf

                            <input type="hidden" name="kabupaten" id="sel-kabupaten" value="{{ old('kabupaten') }}" required>
                            <input type="hidden" name="kecamatan" id="sel-kecamatan" value="{{ old('kecamatan') }}" required>
                            <input type="hidden" name="desa" id="sel-desa" value="{{ old('desa') }}" required>

                            <div class="modern-select" data-select="kabupaten-nik">
                                <div class="modern-select-trigger" data-select-trigger>
                                    <span class="modern-select-value is-placeholder" data-select-label>Pilih Kabupaten/Kota</span>
                                    <span class="modern-select-icon"><i class="fas fa-chevron-down"></i></span>
                                </div>

                                <div class="modern-select-menu">
                                    <div class="modern-select-search-box">
                                        <i class="fas fa-search"></i>
                                        <input type="text" class="modern-select-search" placeholder="Cari kabupaten/kota..." data-select-search>
                                    </div>

                                    <div class="modern-select-options" data-select-options>
                                        @foreach($kabupaten ?? [] as $item)
                                            <div
                                                class="modern-option"
                                                data-select-option
                                                data-value="{{ $item->id }}"
                                                data-label="{{ $item->nama ?? $item->nama_kabupaten ?? '-' }}"
                                            >
                                                {{ $item->nama ?? $item->nama_kabupaten ?? '-' }}
                                            </div>
                                        @endforeach

                                        <div class="modern-select-empty">Data tidak ditemukan</div>
                                    </div>
                                </div>
                            </div>

                            <div class="modern-select is-disabled" data-select="kecamatan-nik">
                                <div class="modern-select-trigger" data-select-trigger>
                                    <span class="modern-select-value is-placeholder" data-select-label>Pilih Kecamatan</span>
                                    <span class="modern-select-icon"><i class="fas fa-chevron-down"></i></span>
                                </div>

                                <div class="modern-select-menu">
                                    <div class="modern-select-search-box">
                                        <i class="fas fa-search"></i>
                                        <input type="text" class="modern-select-search" placeholder="Cari kecamatan..." data-select-search>
                                    </div>

                                    <div class="modern-select-options" data-select-options>
                                        <div class="modern-select-empty" style="display:block;">Pilih kabupaten dulu</div>
                                    </div>
                                </div>
                            </div>

                            <div class="modern-select is-disabled" data-select="desa-nik">
                                <div class="modern-select-trigger" data-select-trigger>
                                    <span class="modern-select-value is-placeholder" data-select-label>Pilih Desa/Kelurahan</span>
                                    <span class="modern-select-icon"><i class="fas fa-chevron-down"></i></span>
                                </div>

                                <div class="modern-select-menu">
                                    <div class="modern-select-search-box">
                                        <i class="fas fa-search"></i>
                                        <input type="text" class="modern-select-search" placeholder="Cari desa/kelurahan..." data-select-search>
                                    </div>

                                    <div class="modern-select-options" data-select-options>
                                        <div class="modern-select-empty" style="display:block;">Pilih kecamatan dulu</div>
                                    </div>
                                </div>
                            </div>

                            <div class="nik-wrapper">
                                <i class="fas fa-fingerprint nik-icon"></i>
                                <input
                                    type="text"
                                    name="nik"
                                    class="form-control-dtsen"
                                    placeholder="NIK"
                                    maxlength="16"
                                    pattern="\d{16}"
                                    value="{{ old('nik') }}"
                                    required
                                >
                            </div>

                            <button type="submit" class="btn-cari" id="btn-cari">
                                <i class="fas fa-search me-1"></i> Cari
                            </button>
                        </form>
                    </div>

                    <div id="tab-spmb" class="tab-body {{ ($activeResultTab ?? null) === 'spmb' ? 'anim-right' : '' }}" style="{{ ($activeResultTab ?? null) === 'spmb' ? '' : 'display:none;' }}">
                        <p class="tab-label" style="color:#2E7D32;">CEK Status Afirmasi SPMB 2026</p>

                        <form action="{{ route('cek.spmb') }}" method="POST" id="form-spmb">
                            @csrf

                            <div class="nik-wrapper">
                                <i class="fas fa-fingerprint nik-icon"></i>
                                <input
                                    type="text"
                                    name="nik_spmb"
                                    class="form-control-dtsen"
                                    placeholder="NIK"
                                    maxlength="16"
                                    pattern="\d{16}"
                                    value="{{ old('nik_spmb') }}"
                                    required
                                >
                            </div>

                            <button type="submit" class="btn-cari btn-cari-spmb">
                                <i class="fas fa-search me-1"></i> Cari
                            </button>
                        </form>
                    </div>
                </div>
            </div>

        </div>
    </div>
</section>

<section class="info-section">
    <div class="container">
        <h2 class="info-title">DATA TUNGGAL SOSIAL DAN EKONOMI NASIONAL<br>PROVINSI JAWA TENGAH</h2>
        <p class="info-subtitle">Berdasarkan data Penetapan : KEPMENSOS/21/HUK/2022 (BULAN FEBRUARI TAHUN 2022)</p>
    </div>
</section>

@php
    $modalData = $hasilCek ?? null;
@endphp

@if(($activeResultTab ?? null) === 'spmb' && $hasilSpmb)
    @php
        $spmbTerdaftar = $hasilSpmb['terdaftar'] ?? false;
        $statusKelayakan = $hasilSpmb['status_kelayakan'] ?? 'Tidak Masuk Afirmasi';
        $isMasukAfirmasi = $statusKelayakan === 'Masuk Afirmasi';
    @endphp

    <div class="spmb-result-overlay show" id="spmbResultOverlay">
        <div class="spmb-result-card">
            <div class="spmb-result-top {{ $spmbTerdaftar ? 'success' : 'failed' }}">
                <button type="button" class="spmb-result-close" data-close-spmb-result>
                    ×
                </button>

                @if($spmbTerdaftar)
                    <div class="spmb-icon-circle success">
                        <div class="spmb-icon-symbol">✓</div>
                    </div>

                    <h3 class="spmb-result-title">Data Afirmasi Ditemukan</h3>
                    <p class="spmb-result-subtitle">
                        Data NIK cocok dengan basis data dan status afirmasi berhasil diproses.
                    </p>
                @else
                    <div class="spmb-icon-circle failed">
                        <div class="spmb-icon-symbol">×</div>
                    </div>

                    <h3 class="spmb-result-title">Data Afirmasi Tidak Ditemukan</h3>
                    <p class="spmb-result-subtitle">
                        NIK yang dimasukkan belum ditemukan pada basis data SPMB 2026.
                    </p>
                @endif
            </div>

            <div class="spmb-result-body">
                <div class="spmb-summary-pill {{ $spmbTerdaftar ? '' : 'failed' }}">
                    Hasil Pengecekan SPMB 2026
                </div>

                <div class="spmb-result-list">
                    <div class="spmb-result-row">
                        <div class="spmb-result-label">NIK</div>
                        <div class="spmb-result-colon">:</div>
                        <div class="spmb-result-value">{{ $hasilSpmb['nik'] ?? '-' }}</div>
                    </div>

                    <div class="spmb-result-row">
                        <div class="spmb-result-label">Desil Nasional</div>
                        <div class="spmb-result-colon">:</div>
                        <div class="spmb-result-value">
                            {{ $hasilSpmb['desil_nasional'] ?? '-' }}
                        </div>
                    </div>

                    <div class="spmb-result-row">
                        <div class="spmb-result-label">Status Kelayakan</div>
                        <div class="spmb-result-colon">:</div>
                        <div class="spmb-result-value">
                            <span class="spmb-status-badge {{ $isMasukAfirmasi ? 'success' : 'failed' }}">
                                {{ $statusKelayakan }}
                            </span>
                        </div>
                    </div>
                </div>

                <button type="button" class="spmb-result-action" data-close-spmb-result>
                    Oke, Mengerti
                </button>
            </div>
        </div>
    </div>
@elseif($modalData)
    <div class="result-modal-overlay show" id="resultModalOverlay">
        <div class="result-modal-card">
            <div class="result-modal-top">
                <button type="button" class="result-modal-close" id="resultModalClose">
                    ×
                </button>

                @if($modalData['terdaftar'] ?? false)
                    <h3 class="result-modal-title">Data Kepesertaan Ditemukan</h3>
                    <p class="result-modal-subtitle">
                        Data yang dimasukkan cocok dengan basis data DT Jateng.
                    </p>
                @else
                    <h3 class="result-modal-title">Data Belum Terdaftar</h3>
                    <p class="result-modal-subtitle">
                        Data yang dimasukkan belum ditemukan pada basis data DT Jateng.
                    </p>
                @endif
            </div>

            <div class="result-modal-body">
                @if($modalData['terdaftar'] ?? false)
                    <div class="result-summary-pill">
                        STATUS KEPESERTAAN DT JATENG
                    </div>

                    <div class="result-list-modern">
                        <div class="result-row-modern">
                            <div class="result-label-modern">KABUPATEN</div>
                            <div class="result-colon-modern">:</div>
                            <div class="result-value-modern">{{ $modalData['kabupaten'] ?? '-' }}</div>
                        </div>

                        <div class="result-row-modern">
                            <div class="result-label-modern">KECAMATAN</div>
                            <div class="result-colon-modern">:</div>
                            <div class="result-value-modern">{{ $modalData['kecamatan'] ?? '-' }}</div>
                        </div>

                        <div class="result-row-modern">
                            <div class="result-label-modern">DESA</div>
                            <div class="result-colon-modern">:</div>
                            <div class="result-value-modern">{{ $modalData['desa'] ?? '-' }}</div>
                        </div>

                        <div class="result-row-modern">
                            <div class="result-label-modern">NAMA</div>
                            <div class="result-colon-modern">:</div>
                            <div class="result-value-modern">{{ $modalData['nama'] ?? '-' }}</div>
                        </div>

                        <div class="result-row-modern">
                            <div class="result-label-modern">STATUS VERVAL</div>
                            <div class="result-colon-modern">:</div>
                            <div class="result-value-modern">{{ $modalData['status'] ?? '-' }}</div>
                        </div>
                    </div>

                    <button type="button" class="result-modal-action" data-close-result>
                        Oke, Mengerti
                    </button>
                @else
                    <div class="result-summary-pill failed">
                        STATUS KEPESERTAAN DT JATENG
                    </div>

                    <div class="not-found-modern">
                        <h3 class="not-found-title-modern">Mohon Maaf</h3>
                        <p class="not-found-desc-modern">
                            Status Anda belum terdaftar. Pastikan wilayah dan NIK yang dimasukkan sudah benar.
                        </p>
                    </div>

                    <button type="button" class="result-modal-action" data-close-result>
                        Coba Lagi
                    </button>
                @endif
            </div>
        </div>
    </div>
@endif

@endsection

{{-- SCRIPT HALAMAN --}}
@push('scripts')
{{-- SCRIPT JAVASCRIPT --}}
<script>
    let activeTab = @json(($activeResultTab ?? 'nik') === 'spmb' ? 'spmb' : 'nik');

    function switchTab(tab, btn) {
        if (tab === activeTab) return;

        const arahMasuk = tab === 'spmb' ? 'anim-right' : 'anim-left';
        const elAktif = document.getElementById('tab-' + activeTab);

        elAktif.style.display = 'none';
        elAktif.classList.remove('anim-left', 'anim-right');

        const elBaru = document.getElementById('tab-' + tab);

        elBaru.style.display = 'block';
        elBaru.classList.remove('anim-left', 'anim-right');

        void elBaru.offsetWidth;

        elBaru.classList.add(arahMasuk);

        document.querySelectorAll('.tab-btn').forEach(function (button) {
            button.classList.remove('active');
        });

        btn.classList.add('active');
        activeTab = tab;

        closeAllModernSelects();
    }

    function closeAllModernSelects(except = null) {
        document.querySelectorAll('.modern-select').forEach(function (select) {
            if (select !== except) {
                select.classList.remove('is-open');
            }
        });
    }

    function resetModernSelect(selectName, placeholderText, disabled = false) {
        const select = document.querySelector(`[data-select="${selectName}"]`);

        if (!select) return;

        const label = select.querySelector('[data-select-label]');
        const search = select.querySelector('[data-select-search]');
        const optionsBox = select.querySelector('[data-select-options]');

        label.textContent = placeholderText;
        label.classList.add('is-placeholder');

        if (search) {
            search.value = '';
        }

        select.classList.remove('is-open', 'no-result', 'select-loading');

        if (disabled) {
            select.classList.add('is-disabled');

            if (optionsBox) {
                optionsBox.innerHTML = `<div class="modern-select-empty" style="display:block;">${placeholderText}</div>`;
            }
        } else {
            select.classList.remove('is-disabled');
        }
    }

    function setModernSelectLoading(selectName, text) {
        const select = document.querySelector(`[data-select="${selectName}"]`);

        if (!select) return;

        const label = select.querySelector('[data-select-label]');
        const optionsBox = select.querySelector('[data-select-options]');

        select.classList.remove('is-disabled');
        select.classList.add('select-loading');

        label.textContent = text;
        label.classList.add('is-placeholder');

        if (optionsBox) {
            optionsBox.innerHTML = `<div class="modern-select-loading"><i class="fas fa-spinner fa-spin me-1"></i> ${text}</div>`;
        }
    }

    function buildModernOptions(selectName, data, emptyText) {
        const select = document.querySelector(`[data-select="${selectName}"]`);

        if (!select) return;

        const optionsBox = select.querySelector('[data-select-options]');

        select.classList.remove('select-loading', 'is-disabled', 'no-result');

        if (!optionsBox) return;

        if (!data || data.length === 0) {
            optionsBox.innerHTML = `<div class="modern-select-empty" style="display:block;">${emptyText}</div>`;
            return;
        }

        let html = '';

        data.forEach(function (item) {
            const nama = item.nama || item.nama_kecamatan || item.nama_desa || item.nama_kabupaten || '-';

            html += `
                <div
                    class="modern-option"
                    data-select-option
                    data-value="${item.id}"
                    data-label="${nama}"
                >
                    ${nama}
                </div>
            `;
        });

        html += `<div class="modern-select-empty">Data tidak ditemukan</div>`;

        optionsBox.innerHTML = html;
        bindOptionsForSelect(select);
    }

    function setSelectedLabel(selectName, value) {
        if (!value) return;

        const select = document.querySelector(`[data-select="${selectName}"]`);
        if (!select) return;

        const option = select.querySelector(`[data-select-option][data-value="${value}"]`);
        if (!option) return;

        const label = select.querySelector('[data-select-label]');
        label.textContent = option.dataset.label;
        label.classList.remove('is-placeholder');

        option.classList.add('selected');
    }

    function bindOptionsForSelect(select) {
        const options = select.querySelectorAll('[data-select-option]');

        options.forEach(function (option) {
            option.addEventListener('click', function (event) {
                event.stopPropagation();

                const value = option.dataset.value;
                const text = option.dataset.label;
                const selectName = select.dataset.select;
                const label = select.querySelector('[data-select-label]');

                label.textContent = text;
                label.classList.remove('is-placeholder');

                options.forEach(function (item) {
                    item.classList.remove('selected');
                });

                option.classList.add('selected');
                select.classList.remove('is-open');

                if (selectName === 'kabupaten-nik') {
                    document.getElementById('sel-kabupaten').value = value;
                    document.getElementById('sel-kecamatan').value = '';
                    document.getElementById('sel-desa').value = '';

                    resetModernSelect('kecamatan-nik', 'Pilih Kecamatan', true);
                    resetModernSelect('desa-nik', 'Pilih Desa/Kelurahan', true);

                    loadKecamatan(value);
                }

                if (selectName === 'kecamatan-nik') {
                    document.getElementById('sel-kecamatan').value = value;
                    document.getElementById('sel-desa').value = '';

                    resetModernSelect('desa-nik', 'Pilih Desa/Kelurahan', true);

                    loadDesa(value);
                }

                if (selectName === 'desa-nik') {
                    document.getElementById('sel-desa').value = value;
                }
            });
        });
    }

    function initModernSelects() {
        document.querySelectorAll('.modern-select').forEach(function (select) {
            const trigger = select.querySelector('[data-select-trigger]');
            const search = select.querySelector('[data-select-search]');

            trigger.addEventListener('click', function (event) {
                event.stopPropagation();

                if (select.classList.contains('is-disabled')) {
                    return;
                }

                closeAllModernSelects(select);
                select.classList.toggle('is-open');

                if (select.classList.contains('is-open') && search) {
                    setTimeout(function () {
                        search.focus();
                    }, 120);
                }
            });

            if (search) {
                search.addEventListener('click', function (event) {
                    event.stopPropagation();
                });

                search.addEventListener('input', function () {
                    const keyword = search.value.toLowerCase().trim();
                    const options = select.querySelectorAll('[data-select-option]');
                    let totalVisible = 0;

                    options.forEach(function (option) {
                        const label = option.dataset.label.toLowerCase();

                        if (label.includes(keyword)) {
                            option.style.display = 'flex';
                            totalVisible++;
                        } else {
                            option.style.display = 'none';
                        }
                    });

                    select.classList.toggle('no-result', totalVisible === 0);
                });
            }

            bindOptionsForSelect(select);
        });

        document.addEventListener('click', function () {
            closeAllModernSelects();
        });

        document.addEventListener('keydown', function (event) {
            if (event.key === 'Escape') {
                closeAllModernSelects();
                closeResultModal();
                closeSpmbResultModal();
            }
        });
    }

    function loadKecamatan(kabupatenId, selectedKecamatan = null, selectedDesa = null) {
        setModernSelectLoading('kecamatan-nik', 'Memuat kecamatan...');

        fetch(`/api/kecamatan/${kabupatenId}`)
            .then(function (response) {
                return response.json();
            })
            .then(function (data) {
                buildModernOptions('kecamatan-nik', data, 'Kecamatan tidak ditemukan');
                resetModernSelect('kecamatan-nik', 'Pilih Kecamatan', false);

                if (selectedKecamatan) {
                    document.getElementById('sel-kecamatan').value = selectedKecamatan;
                    setSelectedLabel('kecamatan-nik', selectedKecamatan);

                    loadDesa(selectedKecamatan, selectedDesa);
                }
            })
            .catch(function () {
                buildModernOptions('kecamatan-nik', [], 'Gagal memuat kecamatan');
                resetModernSelect('kecamatan-nik', 'Gagal memuat kecamatan', false);
            });
    }

    function loadDesa(kecamatanId, selectedDesa = null) {
        setModernSelectLoading('desa-nik', 'Memuat desa...');

        fetch(`/api/desa/${kecamatanId}`)
            .then(function (response) {
                return response.json();
            })
            .then(function (data) {
                buildModernOptions('desa-nik', data, 'Desa tidak ditemukan');
                resetModernSelect('desa-nik', 'Pilih Desa/Kelurahan', false);

                if (selectedDesa) {
                    document.getElementById('sel-desa').value = selectedDesa;
                    setSelectedLabel('desa-nik', selectedDesa);
                }
            })
            .catch(function () {
                buildModernOptions('desa-nik', [], 'Gagal memuat desa');
                resetModernSelect('desa-nik', 'Gagal memuat desa', false);
            });
    }

    function closeResultModal() {
        const modal = document.getElementById('resultModalOverlay');

        if (!modal) return;

        modal.classList.remove('show');

        setTimeout(function () {
            modal.remove();
        }, 180);
    }

    function closeSpmbResultModal() {
        const modal = document.getElementById('spmbResultOverlay');

        if (!modal) return;

        modal.classList.remove('show');

        setTimeout(function () {
            modal.remove();
        }, 180);
    }

    function initResultModal() {
        const modal = document.getElementById('resultModalOverlay');
        const closeBtn = document.getElementById('resultModalClose');
        const actionButtons = document.querySelectorAll('[data-close-result]');

        if (modal) {
            if (closeBtn) {
                closeBtn.addEventListener('click', closeResultModal);
            }

            actionButtons.forEach(function (button) {
                button.addEventListener('click', closeResultModal);
            });

            modal.addEventListener('click', function (event) {
                if (event.target === modal) {
                    closeResultModal();
                }
            });
        }

        const spmbModal = document.getElementById('spmbResultOverlay');
        const spmbButtons = document.querySelectorAll('[data-close-spmb-result]');

        if (spmbModal) {
            spmbButtons.forEach(function (button) {
                button.addEventListener('click', closeSpmbResultModal);
            });

            spmbModal.addEventListener('click', function (event) {
                if (event.target === spmbModal) {
                    closeSpmbResultModal();
                }
            });
        }
    }

    function initOldSelectedValues() {
        const oldKabupaten = @json(old('kabupaten'));
        const oldKecamatan = @json(old('kecamatan'));
        const oldDesa = @json(old('desa'));

        if (oldKabupaten) {
            document.getElementById('sel-kabupaten').value = oldKabupaten;
            setSelectedLabel('kabupaten-nik', oldKabupaten);
            loadKecamatan(oldKabupaten, oldKecamatan, oldDesa);
        }
    }

    document.addEventListener('DOMContentLoaded', function () {
        initModernSelects();
        initResultModal();
        initOldSelectedValues();

        const nikInputs = document.querySelectorAll('input[name="nik"], input[name="nik_spmb"]');

        nikInputs.forEach(function (input) {
            input.addEventListener('input', function () {
                this.value = this.value.replace(/\D/g, '').slice(0, 16);
            });
        });

        const formNik = document.getElementById('form-nik');
        const formSpmb = document.getElementById('form-spmb');

        if (formNik) {
            formNik.addEventListener('submit', function () {
                const btn = document.getElementById('btn-cari');

                if (btn) {
                    btn.classList.add('loading');
                    btn.innerHTML = '<i class="fas fa-spinner fa-spin me-1"></i> Mencari...';
                }
            });
        }

        if (formSpmb) {
            formSpmb.addEventListener('submit', function () {
                const btn = formSpmb.querySelector('.btn-cari');

                if (btn) {
                    btn.classList.add('loading');
                    btn.innerHTML = '<i class="fas fa-spinner fa-spin me-1"></i> Mencari...';
                }
            });
        }
    });
</script>
@endpush