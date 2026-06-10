{{-- HALAMAN PETA DTSEN --}}
{{-- LAYOUT YANG DIGUNAKAN --}}
@extends('layouts.app')

{{-- JUDUL HALAMAN --}}
@section('title', 'Peta DTSEN Jawa Tengah')

{{--
|--------------------------------------------------------------------------
| HIDE FOOTER
|--------------------------------------------------------------------------
| Menyembunyikan footer agar halaman peta tampil fokus fullscreen.
|--------------------------------------------------------------------------
--}}
@section('hide_footer', true)

{{-- STYLE HALAMAN --}}
@push('styles')
    {{--
    |--------------------------------------------------------------------------
    | LEAFLET CSS
    |--------------------------------------------------------------------------
    | Library utama untuk menampilkan peta interaktif.
    |--------------------------------------------------------------------------
    --}}
    <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css"/>

    {{-- STYLE CSS --}}
<style>
        body {
            overflow: hidden;
            background: #f4f7fb;
        }

        :root {
            --peta-primary: #2f80d1;
            --peta-primary-dark: #1769b3;
            --peta-cyan: #24b7ea;
            --peta-soft: #eaf4ff;
            --peta-line: rgba(255,255,255,0.58);
            --peta-shadow: 0 10px 28px rgba(15, 23, 42, 0.18);
        }

        @keyframes fadeSlideIn {
            from { opacity: 0; transform: translateY(8px); }
            to { opacity: 1; transform: translateY(0); }
        }

        @keyframes dropdownOpen {
            from { opacity: 0; transform: translateY(-8px) scale(0.98); }
            to { opacity: 1; transform: translateY(0) scale(1); }
        }

        @keyframes statusGlow {
            0% { opacity: 0.75; }
            50% { opacity: 1; }
            100% { opacity: 0.75; }
        }

        @keyframes infoCardIn {
            from {
                opacity: 0;
                transform: translateX(28px) scale(0.97);
            }

            to {
                opacity: 1;
                transform: translateX(0) scale(1);
            }
        }

        .peta-wrapper {
            width: 100%;
            height: calc(100dvh - 58px);
            min-height: 560px;
            display: grid;
            grid-template-columns: clamp(250px, 15.7vw, 300px) minmax(0, 1fr);
            padding: clamp(12px, 1.25vw, 18px);
            gap: clamp(12px, 1.25vw, 18px);
            background: #f4f7fb;
            overflow: hidden;
        }

        #sidebar {
            width: 100%;
            min-width: 0;
            height: 100%;
            max-height: 100%;
            background: linear-gradient(180deg, #2f80d1 0%, #2877c6 100%);
            color: white;
            padding: clamp(14px, 1.1vw, 18px);
            border-radius: 14px;
            overflow-y: auto;
            overflow-x: hidden;
            box-shadow: var(--peta-shadow);
            animation: fadeSlideIn 0.45s ease both;
        }

        #sidebar::-webkit-scrollbar {
            width: 6px;
        }

        #sidebar::-webkit-scrollbar-thumb {
            background: rgba(255,255,255,0.45);
            border-radius: 999px;
        }

        .sidebar-title {
            font-size: 15px;
            font-weight: 800;
            margin-bottom: 10px;
            padding-bottom: 10px;
            border-bottom: 1px solid var(--peta-line);
            letter-spacing: 0.2px;
        }

        .section-block {
            animation: fadeSlideIn 0.35s ease both;
        }

        .section-title {
            font-size: 14px;
            font-weight: 800;
            margin-top: 12px;
            margin-bottom: 8px;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .section-title small {
            font-size: 10px;
            font-weight: 700;
            opacity: 0.95;
            background: rgba(255,255,255,0.18);
            padding: 2px 7px;
            border-radius: 999px;
        }

        .divider {
            height: 1px;
            background: var(--peta-line);
            margin: 13px 0;
        }

        .custom-select {
            position: relative;
            margin-bottom: 9px;
        }

        .custom-select-trigger {
            width: 100%;
            min-height: 34px;
            border: 1px solid rgba(255,255,255,0.72);
            border-radius: 8px;
            background: rgba(255,255,255,0.12);
            color: white;
            padding: 9px 34px 9px 10px;
            font-size: 13px;
            text-align: left;
            cursor: pointer;
            transition: 0.22s ease;
            position: relative;
        }

        .custom-select-trigger::after {
            content: "";
            position: absolute;
            right: 12px;
            top: 50%;
            width: 7px;
            height: 7px;
            border-right: 2px solid rgba(255,255,255,0.95);
            border-bottom: 2px solid rgba(255,255,255,0.95);
            transform: translateY(-65%) rotate(45deg);
            transition: 0.25s ease;
        }

        .custom-select.open .custom-select-trigger::after {
            transform: translateY(-35%) rotate(225deg);
        }

        .custom-select-trigger:hover {
            background: rgba(255,255,255,0.20);
            transform: translateY(-1px);
        }

        .custom-select.open .custom-select-trigger,
        .custom-select.has-value .custom-select-trigger {
            border-color: white;
            background: rgba(255,255,255,0.24);
        }

        .custom-select.disabled .custom-select-trigger {
            background: rgba(255,255,255,0.18);
            color: rgba(255,255,255,0.65);
            cursor: not-allowed;
            transform: none;
        }

        .custom-options {
            position: relative;
            width: 100%;
            margin-top: 6px;
            background: white;
            border-radius: 9px;
            box-shadow: 0 8px 18px rgba(15, 23, 42, 0.20);
            max-height: 220px;
            overflow-y: auto;
            display: none;
            padding: 6px;
            animation: dropdownOpen 0.22s ease both;
        }

        .custom-select.open .custom-options {
            display: block;
        }

        .custom-options::-webkit-scrollbar {
            width: 6px;
        }

        .custom-options::-webkit-scrollbar-thumb {
            background: #cbd5e1;
            border-radius: 999px;
        }

        .custom-option {
            color: #0f172a;
            padding: 9px 10px;
            border-radius: 7px;
            font-size: 12px;
            cursor: pointer;
            transition: 0.18s ease;
            line-height: 1.25;
        }

        .custom-option:hover {
            background: #eaf4ff;
            color: #1f6fbf;
            transform: translateX(3px);
        }

        .custom-option.selected {
            background: #2f80d1;
            color: white;
            font-weight: bold;
        }

        .custom-option.empty {
            color: #64748b;
            cursor: default;
        }

        .custom-option.empty:hover {
            background: transparent;
            transform: none;
        }

        .select-hint {
            font-size: 10px;
            margin-top: -3px;
            margin-bottom: 7px;
            opacity: 0.9;
            display: none;
            animation: fadeSlideIn 0.25s ease both;
        }

        .select-hint.show {
            display: block;
        }

        .is-loading .custom-select-trigger {
            background: rgba(36, 183, 234, 0.35);
            animation: statusGlow 0.9s ease infinite;
        }

        .pill-grid {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 8px;
            font-size: 12px;
        }

        .pill-grid-desil {
            grid-template-columns: repeat(2, minmax(0, 1fr));
        }

        .pill-item {
            position: relative;
            cursor: pointer;
            user-select: none;
            min-width: 0;
        }

        .pill-item input {
            position: absolute;
            opacity: 0;
            pointer-events: none;
        }

        .pill-box {
            min-height: 36px;
            border-radius: 9px;
            border: 1px solid rgba(255,255,255,0.48);
            background: rgba(255,255,255,0.10);
            display: flex;
            align-items: center;
            gap: 6px;
            padding: 7px 7px;
            transition: 0.22s ease;
            min-width: 0;
            overflow: visible;
        }

        .pill-dot {
            width: 12px;
            height: 12px;
            border-radius: 50%;
            border: 2px solid rgba(255,255,255,0.86);
            transition: 0.22s ease;
            flex-shrink: 0;
        }

        .pill-text {
            font-size: 11.2px;
            font-weight: 650;
            white-space: normal;
            overflow: visible;
            text-overflow: clip;
            line-height: 1.15;
            word-break: keep-all;
        }

        .pill-item:hover .pill-box {
            background: rgba(255,255,255,0.20);
            transform: translateY(-1px);
        }

        .pill-item input:checked + .pill-box {
            background: rgba(255,255,255,0.94);
            color: #1f6fbf;
            border-color: #ffffff;
            transform: translateY(-1px) scale(1.02);
            box-shadow: 0 6px 14px rgba(15, 23, 42, 0.16);
        }

        .pill-item input:checked + .pill-box .pill-dot {
            background: #24b7ea;
            border-color: #1f6fbf;
            box-shadow: inset 0 0 0 3px white;
        }

        .age-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 8px;
        }

        .age-field {
            background: rgba(255,255,255,0.12);
            border: 1px solid rgba(255,255,255,0.48);
            border-radius: 9px;
            padding: 7px;
            transition: 0.2s ease;
        }

        .age-field:hover {
            background: rgba(255,255,255,0.20);
            transform: translateY(-1px);
        }

        .age-field label {
            display: block;
            font-size: 10px;
            margin-bottom: 4px;
            opacity: 0.9;
        }

        .age-field input {
            width: 100%;
            border: none;
            outline: none;
            background: white;
            border-radius: 6px;
            padding: 6px;
            font-size: 12px;
            color: #0f172a;
        }

        .submit-btn {
            margin-top: 14px;
            background: #24b7ea;
            color: white;
            border: none;
            padding: 10px 18px;
            border-radius: 9px;
            font-size: 13px;
            font-weight: bold;
            cursor: pointer;
            transition: 0.22s ease;
            width: 100%;
        }

        .submit-btn:hover {
            background: #0ea5d7;
            transform: translateY(-1px);
            box-shadow: 0 8px 18px rgba(14, 165, 215, 0.28);
        }

        .reset-btn {
            margin-top: 8px;
            background: rgba(255,255,255,0.18);
            color: white;
            border: 1px solid rgba(255,255,255,0.55);
            padding: 10px 18px;
            border-radius: 9px;
            font-size: 13px;
            font-weight: bold;
            cursor: pointer;
            transition: 0.22s ease;
            width: 100%;
        }

        .reset-btn:hover {
            background: rgba(255,255,255,0.30);
            transform: translateY(-1px);
            box-shadow: 0 8px 18px rgba(15, 23, 42, 0.18);
        }

        .info-box {
            margin-top: 16px;
            background: rgba(10, 57, 113, 0.55);
            padding: 12px;
            border-radius: 10px;
            font-size: 12px;
            line-height: 1.5;
            transition: 0.25s ease;
        }

        .info-box strong {
            display: block;
            margin-bottom: 4px;
        }

        .info-box.is-loading {
            animation: statusGlow 0.8s ease infinite;
            background: rgba(10, 57, 113, 0.68);
        }

        .info-box.is-success {
            background: rgba(5, 115, 105, 0.55);
        }

        .info-box.is-error {
            background: rgba(150, 35, 35, 0.58);
        }

        .map-container {
            min-width: 0;
            width: 100%;
            height: 100%;
            background: white;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 4px 18px rgba(0,0,0,0.12);
            transition: 0.25s ease;
            position: relative;
        }

        #map {
            width: 100%;
            height: 100%;
            min-height: 560px;
        }

        .leaflet-container {
            font-family: Arial, sans-serif;
            background: #eaf3f8;
        }

        /*
        |--------------------------------------------------------------------------
        | HAPUS GARIS PUTIH TILE MAP
        |--------------------------------------------------------------------------
        | Pada beberapa kondisi zoom/browser, tile peta bisa terlihat seperti
        | memiliki garis putih panjang di batas antar tile. CSS ini memaksa tile
        | menempel rapi tanpa border/outline/box-shadow.
        |--------------------------------------------------------------------------
        */
        .leaflet-tile {
            border: 0 !important;
            outline: 0 !important;
            box-shadow: none !important;
            backface-visibility: hidden;
            transform: translateZ(0);
        }

        .leaflet-tile-container {
            backface-visibility: hidden;
            transform: translateZ(0);
        }

        .legend-excel {
            background: rgba(255, 255, 255, 0.96);
            padding: 10px 12px;
            border-radius: 10px;
            box-shadow: 0 4px 16px rgba(15, 23, 42, 0.18);
            font-size: clamp(10.5px, 0.72vw, 12px);
            line-height: 1.55;
        }

        .legend-excel strong {
            display: block;
            margin-bottom: 6px;
            font-size: clamp(11px, 0.76vw, 12.5px);
        }

        .legend-row {
            display: flex;
            align-items: center;
            gap: 6px;
            white-space: nowrap;
        }

        .legend-color {
            width: 12px;
            height: 12px;
            border-radius: 3px;
            display: inline-block;
        }

        .legend-dot {
            width: 11px;
            height: 11px;
            border-radius: 50%;
            display: inline-block;
        }

        .leaflet-bottom.leaflet-left .legend-excel {
            margin-left: clamp(12px, 1.2vw, 18px) !important;
            margin-bottom: clamp(12px, 1.2vw, 18px) !important;
        }

        .map-info-card {
            position: absolute;
            top: clamp(10px, 1.2vh, 16px);
            right: clamp(10px, 1.05vw, 16px);
            bottom: clamp(10px, 1.05vw, 16px);
            width: clamp(310px, 19vw, 365px);
            max-width: calc(100% - 20px);
            overflow-y: auto;
            overflow-x: hidden;
            background: #ffffff;
            border-radius: 14px;
            box-shadow: 0 20px 48px rgba(15, 23, 42, 0.28);
            z-index: 999;
            display: none;
            animation: infoCardIn 0.35s ease both;
        }

        .map-info-card.show {
            display: block;
        }

        .map-info-card::-webkit-scrollbar {
            width: 6px;
        }

        .map-info-card::-webkit-scrollbar-thumb {
            background: #cbd5e1;
            border-radius: 999px;
        }

        .map-info-header {
            position: sticky;
            top: 0;
            z-index: 2;
            background: #1769b3;
            color: white;
            padding: clamp(12px, 1.05vw, 16px);
        }

        .map-info-header h3 {
            margin: 0 34px 6px 0;
            font-size: clamp(17px, 1.1vw, 20px);
            font-weight: 800;
            letter-spacing: 0.2px;
            line-height: 1.18;
            word-break: break-word;
        }

        .map-info-header p {
            margin: 0 0 2px;
            font-size: clamp(12.5px, 0.84vw, 14px);
            line-height: 1.28;
            opacity: 0.96;
            word-break: break-word;
        }

        .map-info-close {
            position: absolute;
            top: 10px;
            right: 12px;
            width: 30px;
            height: 30px;
            border: none;
            border-radius: 999px;
            background: rgba(255,255,255,0.18);
            color: white;
            font-size: 18px;
            font-weight: 900;
            cursor: pointer;
            transition: 0.2s ease;
        }

        .map-info-close:hover {
            background: rgba(255,255,255,0.32);
            transform: scale(1.06);
        }

        .map-info-body {
            padding: clamp(8px, 0.95vw, 14px) clamp(12px, 1.05vw, 16px) clamp(12px, 1.05vw, 16px);
            color: #111827;
        }

        .info-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 12px;
            padding: clamp(6px, 0.62vh, 8px) 0;
            border-bottom: 1px solid #d7e3f0;
            font-size: clamp(12px, 0.82vw, 13px);
            line-height: 1.42;
        }

        .info-row:last-child {
            border-bottom: none;
        }

        .info-section {
            padding: clamp(7px, 0.85vh, 10px) 0;
            border-bottom: 1px solid #d7e3f0;
        }

        .info-section:last-child {
            border-bottom: none;
        }

        .info-section-title {
            font-size: clamp(14.5px, 0.96vw, 17px);
            font-weight: 800;
            margin-bottom: 6px;
            color: #111827;
        }

        .info-label {
            display: flex;
            align-items: center;
            gap: 8px;
            min-width: 0;
        }

        .info-check {
            color: #1769b3;
            font-weight: 900;
            flex-shrink: 0;
        }

        .info-badge {
            display: inline-flex;
            align-items: center;
            padding: 4px 8px;
            border-radius: 6px;
            background: #fbbf24;
            color: #111827;
            font-size: clamp(12px, 0.82vw, 13px);
            font-weight: 800;
            white-space: normal;
            line-height: 1.32;
        }

        .info-value {
            font-weight: 800;
            white-space: nowrap;
            text-align: right;
        }

        @media (min-width: 1600px) {
            .peta-wrapper {
                grid-template-columns: 300px minmax(0, 1fr);
                padding: 18px;
                gap: 18px;
            }

            .map-info-card {
                width: 365px;
                top: 14px;
                right: 14px;
                bottom: 14px;
            }
        }

        @media (max-width: 1200px) {
            .peta-wrapper {
                grid-template-columns: 280px minmax(0, 1fr);
                padding: 14px;
                gap: 14px;
            }

            .map-info-card {
                width: 330px;
                top: 12px;
                right: 12px;
                bottom: 12px;
            }
        }

        @media (max-width: 900px) {
            body {
                overflow-y: auto;
            }

            .peta-wrapper {
                grid-template-columns: 1fr;
                height: auto;
                min-height: calc(100dvh - 58px);
                overflow-y: auto;
            }

            #sidebar {
                width: 100%;
                height: auto;
                max-height: none;
            }

            .map-container {
                height: 620px;
                min-height: 620px;
            }

            .map-info-card {
                top: auto;
                right: 12px;
                left: 12px;
                bottom: 12px;
                width: auto;
                max-width: none;
                max-height: 52vh;
            }
        }

        @media (max-width: 720px) {
            .map-container {
                height: 70vh;
                min-height: 480px;
            }

            .map-info-card {
                max-height: 56vh;
            }
        }
    </style>
@endpush

{{-- KONTEN HALAMAN --}}
@section('content')
    <div class="peta-wrapper">
        <div id="sidebar">
            <div class="sidebar-title">Filter Data</div>

            <div class="section-block">
                <div class="section-title">
                    Wilayah
                    <small>Wajib</small>
                </div>

                <div class="custom-select" id="kabupaten-custom">
                    <button type="button" class="custom-select-trigger">Kabupaten</button>
                    <div class="custom-options"></div>
                </div>
                <div class="select-hint" id="kabupaten-hint">Memuat kecamatan dan polygon...</div>

                <div class="custom-select disabled" id="kecamatan-custom">
                    <button type="button" class="custom-select-trigger">Kecamatan</button>
                    <div class="custom-options"></div>
                </div>
                <div class="select-hint" id="kecamatan-hint">Memuat desa dan polygon...</div>

                <div class="custom-select disabled" id="desa-custom">
                    <button type="button" class="custom-select-trigger">Desa</button>
                    <div class="custom-options"></div>
                </div>
                <div class="select-hint" id="desa-hint">Memuat polygon desa...</div>
            </div>

            <div class="divider"></div>

            <div class="section-block">
                <div class="section-title">
                    Desil
                </div>

                <div class="pill-grid pill-grid-desil">
                    {{-- LOOPING DATA --}}
@foreach ([1,2,3,4,5] as $desil)
                        <label class="pill-item">
                            <input type="radio" name="desil" value="{{ $desil }}">
                            <span class="pill-box">
                                <span class="pill-dot"></span>
                                <span class="pill-text">Desil {{ $desil }}</span>
                            </span>
                        </label>
                    @endforeach

                    <label class="pill-item">
                        <input type="radio" name="desil" value="6-10">
                        <span class="pill-box">
                            <span class="pill-dot"></span>
                            <span class="pill-text">Desil 6-10</span>
                        </span>
                    </label>
                </div>
            </div>

            <div class="divider"></div>

            <div class="section-block">
                <div class="section-title">
                    Komponen Kebutuhan
                </div>

                <div class="pill-grid">
                    <label class="pill-item">
                        <input type="checkbox" name="komponen[]" value="rlth">
                        <span class="pill-box"><span class="pill-dot"></span><span class="pill-text">RLTH</span></span>
                    </label>

                    <label class="pill-item">
                        <input type="checkbox" name="komponen[]" value="air">
                        <span class="pill-box"><span class="pill-dot"></span><span class="pill-text">Air</span></span>
                    </label>

                    <label class="pill-item">
                        <input type="checkbox" name="komponen[]" value="jamban">
                        <span class="pill-box"><span class="pill-dot"></span><span class="pill-text">Jamban</span></span>
                    </label>

                    <label class="pill-item">
                        <input type="checkbox" name="komponen[]" value="listrik">
                        <span class="pill-box"><span class="pill-dot"></span><span class="pill-text">Listrik</span></span>
                    </label>

                    <label class="pill-item">
                        <input type="checkbox" name="komponen[]" value="ats">
                        <span class="pill-box"><span class="pill-dot"></span><span class="pill-text">ATS</span></span>
                    </label>

                    <label class="pill-item">
                        <input type="checkbox" name="komponen[]" value="disabilitas">
                        <span class="pill-box"><span class="pill-dot"></span><span class="pill-text">Disabilitas</span></span>
                    </label>

                    <label class="pill-item">
                        <input type="checkbox" name="komponen[]" value="tidak_bekerja">
                        <span class="pill-box"><span class="pill-dot"></span><span class="pill-text">Tidak Bekerja</span></span>
                    </label>
                </div>
            </div>

            <div class="divider"></div>

            <div class="section-block">
                <div class="section-title">
                    Usia
                </div>

                <div class="age-row">
                    <div class="age-field">
                        <label>Dari</label>
                        <input type="number" min="0" placeholder="0" id="usia_dari">
                    </div>

                    <div class="age-field">
                        <label>Sampai</label>
                        <input type="number" min="0" placeholder="100" id="usia_sampai">
                    </div>
                </div>
            </div>

            <div class="divider"></div>

            <div class="section-block">
                <div class="section-title">
                    Jenis Kelamin
                </div>

                <div class="pill-grid">
                    <label class="pill-item">
                        <input type="radio" name="jk" value="L">
                        <span class="pill-box"><span class="pill-dot"></span><span class="pill-text">Laki-laki</span></span>
                    </label>

                    <label class="pill-item">
                        <input type="radio" name="jk" value="P">
                        <span class="pill-box"><span class="pill-dot"></span><span class="pill-text">Perempuan</span></span>
                    </label>
                </div>
            </div>

            <div class="divider"></div>

            <div class="section-block">
                <div class="section-title">
                    Bansos
                </div>

                <div class="pill-grid">
                    <label class="pill-item">
                        <input type="checkbox" name="bansos[]" value="pkh">
                        <span class="pill-box"><span class="pill-dot"></span><span class="pill-text">PKH</span></span>
                    </label>

                    <label class="pill-item">
                        <input type="checkbox" name="bansos[]" value="sembako">
                        <span class="pill-box"><span class="pill-dot"></span><span class="pill-text">Sembako</span></span>
                    </label>

                    <label class="pill-item">
                        <input type="checkbox" name="bansos[]" value="pbi">
                        <span class="pill-box"><span class="pill-dot"></span><span class="pill-text">PBI</span></span>
                    </label>
                </div>
            </div>

            <button class="submit-btn" type="button" id="apply-filter-btn">Kirim</button>
            <button class="reset-btn" type="button" id="reset-page-btn">Reset</button>

            <div class="info-box" id="info-box">
                <strong>Status:</strong>
                <span id="status-text">Menunggu pilihan wilayah...</span>
                <br>
                <small id="debug-text"></small>
            </div>
        </div>

        <div class="map-container" id="map-container">
            <div id="map"></div>
            <div id="map-info-card" class="map-info-card"></div>
        </div>
    </div>
@endsection

{{-- SCRIPT HALAMAN --}}
@push('scripts')
    {{-- SCRIPT JAVASCRIPT --}}
<script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>

    <script>
        const map = L.map('map').setView([-7.2, 110.4], 8);

        /*
        |--------------------------------------------------------------------------
        | PANE KHUSUS TITIK KPM
        |--------------------------------------------------------------------------
        | Titik KPM dibuat di pane paling atas supaya tetap terlihat saat zoom in,
        | zoom out, hover polygon, atau setelah style polygon diperbarui.
        |--------------------------------------------------------------------------
        */
        map.createPane('kpmPointPane');
        map.getPane('kpmPointPane').style.zIndex = 780;
        map.getPane('kpmPointPane').style.pointerEvents = 'auto';

        L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '© OpenStreetMap'
        }).addTo(map);

        let geojsonLayer = null;
        let filterLayer = null;
        let pointLayer = null;
        let excelLegend = null;

        const MAX_KPM_POINTS = 650;

        const DEFAULT_POLYGON_STYLE = {
            color: '#2563eb',
            weight: 2,
            fillColor: '#60a5fa',
            fillOpacity: 0.18,
            opacity: 0.95
        };

        let activePolygonStyle = null;
        let activeDesil = null;
        let activeTotalKpm = 0;

        let selectedKabupatenId = '';
        let selectedKecamatanId = '';
        let selectedDesaId = '';
        let selectedLevel = '';
        let selectedWilayahId = '';

        const statusText = document.getElementById('status-text');
        const debugText = document.getElementById('debug-text');
        const infoBox = document.getElementById('info-box');
        const mapContainer = document.getElementById('map-container');
        const mapInfoCard = document.getElementById('map-info-card');

        const kabupatenDropdown = createDropdown({
            rootId: 'kabupaten-custom',
            placeholder: 'Kabupaten',
            onChange: onKabupatenChange
        });

        const kecamatanDropdown = createDropdown({
            rootId: 'kecamatan-custom',
            placeholder: 'Kecamatan',
            onChange: onKecamatanChange
        });

        const desaDropdown = createDropdown({
            rootId: 'desa-custom',
            placeholder: 'Desa',
            onChange: onDesaChange
        });

        function createDropdown({ rootId, placeholder, onChange }) {
            const root = document.getElementById(rootId);
            const trigger = root.querySelector('.custom-select-trigger');
            const optionsBox = root.querySelector('.custom-options');

            let value = '';
            let label = '';
            let options = [];
            let disabled = root.classList.contains('disabled');

            function renderOptions() {
                optionsBox.innerHTML = '';

                if (options.length === 0) {
                    optionsBox.innerHTML = `<div class="custom-option empty">Tidak ada data</div>`;
                    return;
                }

                options.forEach(option => {
                    const item = document.createElement('div');

                    item.className = 'custom-option';
                    item.textContent = option.label;
                    item.dataset.value = option.value;

                    if (String(option.value) === String(value)) {
                        item.classList.add('selected');
                    }

                    item.addEventListener('click', () => {
                        value = option.value;
                        label = option.label;

                        trigger.textContent = option.label;
                        root.classList.add('has-value');
                        root.classList.remove('open');

                        renderOptions();

                        if (typeof onChange === 'function') {
                            onChange(value, option);
                        }
                    });

                    optionsBox.appendChild(item);
                });
            }

            trigger.addEventListener('click', () => {
                if (disabled) return;

                document.querySelectorAll('.custom-select.open').forEach(opened => {
                    if (opened !== root) {
                        opened.classList.remove('open');
                    }
                });

                root.classList.toggle('open');
            });

            return {
                setOptions(newOptions) {
                    options = newOptions;
                    renderOptions();
                },

                setValue(newValue, newLabel = null) {
                    value = newValue;
                    label = newLabel || '';

                    if (!newValue) {
                        trigger.textContent = placeholder;
                        root.classList.remove('has-value');
                    } else {
                        trigger.textContent = newLabel || placeholder;
                        root.classList.add('has-value');
                    }

                    renderOptions();
                },

                setDisabled(isDisabled) {
                    disabled = isDisabled;

                    if (isDisabled) {
                        root.classList.add('disabled');
                        root.classList.remove('open');
                    } else {
                        root.classList.remove('disabled');
                    }
                },

                setLoading(isLoading) {
                    if (isLoading) {
                        root.classList.add('is-loading');
                    } else {
                        root.classList.remove('is-loading');
                    }
                },

                getValue() {
                    return value;
                },

                getLabel() {
                    return label || trigger.textContent;
                }
            };
        }

        document.addEventListener('click', function(e) {
            if (!e.target.closest('.custom-select')) {
                document.querySelectorAll('.custom-select.open').forEach(dropdown => {
                    dropdown.classList.remove('open');
                });
            }
        });

        function setStatus(message, debug = '', type = 'default') {
            statusText.innerHTML = message;
            debugText.innerHTML = debug;

            infoBox.classList.remove('is-loading', 'is-success', 'is-error');

            if (type === 'loading') infoBox.classList.add('is-loading');
            if (type === 'success') infoBox.classList.add('is-success');
            if (type === 'error') infoBox.classList.add('is-error');
        }

        function showHint(id, show) {
            const el = document.getElementById(id);
            if (!el) return;

            if (show) {
                el.classList.add('show');
            } else {
                el.classList.remove('show');
            }
        }

        function formatNumber(number) {
            return new Intl.NumberFormat('id-ID').format(Number(number || 0));
        }

        function refreshMapSize() {
            if (typeof map !== 'undefined' && map) {
                requestAnimationFrame(function () {
                    map.invalidateSize(false);
                });
            }
        }

        const resetPageBtn = document.getElementById('reset-page-btn');

        if (resetPageBtn) {
            resetPageBtn.addEventListener('click', function () {
                window.location.reload();
            });
        }

        function clearPolygon() {
            if (geojsonLayer) {
                map.removeLayer(geojsonLayer);
                geojsonLayer = null;
            }

            activePolygonStyle = null;
            activeDesil = null;
            activeTotalKpm = 0;
        }

        function clearFilterLayer() {
            if (filterLayer) {
                map.removeLayer(filterLayer);
                filterLayer = null;
            }

            if (pointLayer) {
                map.removeLayer(pointLayer);
                pointLayer = null;
            }

            if (excelLegend) {
                map.removeControl(excelLegend);
                excelLegend = null;
            }

            activePolygonStyle = null;
            activeDesil = null;
            activeTotalKpm = 0;

            if (geojsonLayer) {
                geojsonLayer.eachLayer(function (layer) {
                    if (layer && typeof layer.setStyle === 'function') {
                        layer.setStyle(DEFAULT_POLYGON_STYLE);
                    }
                });
            }

            hideMapInfoCard();
        }

        async function loadKabupaten() {
            try {
                setStatus('Memuat data kabupaten...', '', 'loading');
                kabupatenDropdown.setLoading(true);

                const response = await fetch('/api/kabupaten');

                if (!response.ok) {
                    throw new Error('Gagal mengambil data kabupaten');
                }

                const data = await response.json();

                kabupatenDropdown.setOptions(
                    data.map(item => ({
                        value: item.id,
                        label: item.nama_kabupaten || item.nama || item.nama_wilayah
                    }))
                );

                setStatus('Data kabupaten berhasil dimuat', '', 'success');

            } catch (error) {
                console.error(error);
                setStatus('Gagal memuat data kabupaten', error.message, 'error');
            } finally {
                kabupatenDropdown.setLoading(false);
            }
        }

        loadKabupaten();

        async function onKabupatenChange(id) {
            selectedKabupatenId = id;
            selectedKecamatanId = '';
            selectedDesaId = '';
            selectedLevel = id ? 'kabupaten' : '';
            selectedWilayahId = id || '';

            clearFilterLayer();

            kecamatanDropdown.setValue('');
            kecamatanDropdown.setOptions([]);
            kecamatanDropdown.setDisabled(true);

            desaDropdown.setValue('');
            desaDropdown.setOptions([]);
            desaDropdown.setDisabled(true);

            if (!id) {
                clearPolygon();
                setStatus('Menunggu pilihan wilayah...');
                return;
            }

            try {
                setStatus('Memuat kecamatan...', 'Mohon tunggu sebentar.', 'loading');
                kabupatenDropdown.setLoading(true);
                showHint('kabupaten-hint', true);

                const response = await fetch(`/api/kecamatan/${id}`);

                if (!response.ok) {
                    throw new Error('Gagal mengambil data kecamatan');
                }

                const data = await response.json();

                kecamatanDropdown.setOptions(
                    data.map(item => ({
                        value: item.id,
                        label: item.nama_kecamatan || item.nama || item.nama_wilayah
                    }))
                );

                kecamatanDropdown.setDisabled(false);

                await loadPolygon('kabupaten', id);

            } catch (error) {
                console.error(error);
                setStatus('Gagal memuat data kabupaten', error.message, 'error');
            } finally {
                kabupatenDropdown.setLoading(false);
                showHint('kabupaten-hint', false);
            }
        }

        async function onKecamatanChange(id) {
            selectedKecamatanId = id;
            selectedDesaId = '';
            selectedLevel = id ? 'kecamatan' : 'kabupaten';
            selectedWilayahId = id || selectedKabupatenId;

            clearFilterLayer();

            desaDropdown.setValue('');
            desaDropdown.setOptions([]);
            desaDropdown.setDisabled(true);

            if (!id) {
                setStatus('Silakan pilih kecamatan');
                return;
            }

            try {
                setStatus('Memuat desa...', 'Mohon tunggu sebentar.', 'loading');
                kecamatanDropdown.setLoading(true);
                showHint('kecamatan-hint', true);

                const response = await fetch(`/api/desa/${id}`);

                if (!response.ok) {
                    throw new Error('Gagal mengambil data desa');
                }

                const data = await response.json();

                desaDropdown.setOptions(
                    data.map(item => ({
                        value: item.id,
                        label: item.nama_desa || item.nama || item.nama_wilayah
                    }))
                );

                desaDropdown.setDisabled(false);

                await loadPolygon('kecamatan', id);

            } catch (error) {
                console.error(error);
                setStatus('Gagal memuat data kecamatan', error.message, 'error');
            } finally {
                kecamatanDropdown.setLoading(false);
                showHint('kecamatan-hint', false);
            }
        }

        async function onDesaChange(id) {
            selectedDesaId = id;
            selectedLevel = id ? 'desa' : 'kecamatan';
            selectedWilayahId = id || selectedKecamatanId;

            clearFilterLayer();

            if (!id) {
                setStatus('Silakan pilih desa');
                return;
            }

            try {
                setStatus('Memuat desa...', 'Menampilkan polygon desa.', 'loading');
                desaDropdown.setLoading(true);
                showHint('desa-hint', true);

                await loadPolygon('desa', id);

            } catch (error) {
                console.error(error);
                setStatus('Gagal memuat polygon desa', error.message, 'error');
            } finally {
                desaDropdown.setLoading(false);
                showHint('desa-hint', false);
            }
        }

        function isNumber(value) {
            return typeof value === 'number' && !Number.isNaN(value);
        }

        function isLngLatPair(value) {
            return Array.isArray(value)
                && value.length === 2
                && isNumber(value[0])
                && isNumber(value[1]);
        }

        function isFlatCoordinateArray(value) {
            return Array.isArray(value)
                && value.length >= 4
                && value.length % 2 === 0
                && value.every(item => isNumber(item));
        }

        function isNestedCoordinateArray(value) {
            return Array.isArray(value)
                && value.length > 0
                && Array.isArray(value[0]);
        }

        function flattenBorderToPairs(border) {
            let pairs = [];

            if (!Array.isArray(border)) {
                return pairs;
            }

            border.forEach(item => {
                if (isLngLatPair(item)) {
                    pairs.push(item);
                    return;
                }

                if (isFlatCoordinateArray(item)) {
                    for (let i = 0; i < item.length; i += 2) {
                        pairs.push([item[i], item[i + 1]]);
                    }
                    return;
                }

                if (isNestedCoordinateArray(item)) {
                    const nestedPairs = flattenBorderToPairs(item);
                    pairs = pairs.concat(nestedPairs);
                }
            });

            return pairs;
        }

        function cleanCoordinatePairs(pairs) {
            return pairs.filter(pair => {
                if (!isLngLatPair(pair)) return false;

                const lng = pair[0];
                const lat = pair[1];

                return lng >= -180 && lng <= 180 && lat >= -90 && lat <= 90;
            });
        }

        function closePolygonRing(ring) {
            if (ring.length === 0) return ring;

            const first = ring[0];
            const last = ring[ring.length - 1];

            if (first[0] !== last[0] || first[1] !== last[1]) {
                ring.push([...first]);
            }

            return ring;
        }

        function normalizeGeoJSON(data) {
            if (!data || !Array.isArray(data.features)) {
                throw new Error('Format GeoJSON tidak valid: features tidak ditemukan');
            }

            const normalizedFeatures = [];

            data.features.forEach(feature => {
                const props = feature.properties || {};

                if (
                    feature.geometry &&
                    (
                        feature.geometry.type === 'Polygon' ||
                        feature.geometry.type === 'MultiPolygon'
                    )
                ) {
                    normalizedFeatures.push(feature);
                    return;
                }

                const border = props.border;

                if (!border) return;

                let ring = flattenBorderToPairs(border);
                ring = cleanCoordinatePairs(ring);
                ring = closePolygonRing(ring);

                if (ring.length < 4) return;

                normalizedFeatures.push({
                    type: 'Feature',
                    properties: props,
                    geometry: {
                        type: 'Polygon',
                        coordinates: [ring]
                    }
                });
            });

            if (normalizedFeatures.length === 0) {
                throw new Error('Tidak ada polygon valid setelah normalisasi');
            }

            return {
                type: 'FeatureCollection',
                features: normalizedFeatures
            };
        }

        async function loadPolygon(level, id) {
            try {
                setStatus(`Memuat polygon ${level}...`, '', 'loading');

                const response = await fetch(`/api/geojson/${level}/${id}`);

                if (!response.ok) {
                    throw new Error('Endpoint GeoJSON gagal diakses');
                }

                const data = await response.json();

                if (!data.geojson_path) {
                    throw new Error('geojson_path tidak ditemukan dari server');
                }

                const geojsonResponse = await fetch(data.geojson_path);

                if (!geojsonResponse.ok) {
                    throw new Error(`File GeoJSON tidak ditemukan: ${data.geojson_path}`);
                }

                const rawGeoJSON = await geojsonResponse.json();
                const normalizedGeoJSON = normalizeGeoJSON(rawGeoJSON);

                clearPolygon();

                geojsonLayer = L.geoJSON(normalizedGeoJSON, {
                    style: DEFAULT_POLYGON_STYLE,

                    onEachFeature: function (feature, layer) {
                        const props = feature.properties || {};

                        const namaWilayah =
                            props.village ||
                            props.sub_district ||
                            props.district ||
                            data.nama ||
                            'Wilayah';

                        layer.bindPopup(`
                            <strong>${namaWilayah}</strong><br>
                            Provinsi: ${props.province || '-'}<br>
                            Kabupaten/Kota: ${props.district || '-'}<br>
                            Kecamatan: ${props.sub_district || '-'}<br>
                            Desa: ${props.village || '-'}
                        `);

                        layer.on({
                            mouseover: function (e) {
                                const currentStyle = activePolygonStyle || DEFAULT_POLYGON_STYLE;

                                e.target.setStyle({
                                    ...currentStyle,
                                    weight: Number(currentStyle.weight || 2) + 0.8,
                                    fillOpacity: Math.min(Number(currentStyle.fillOpacity || 0.18) + 0.08, 0.30)
                                });

                                if (!L.Browser.ie && !L.Browser.opera && !L.Browser.edge) {
                                    e.target.bringToFront();
                                }

                                if (pointLayer) {
                                    pointLayer.eachLayer(function (marker) {
                                        if (marker && typeof marker.bringToFront === 'function') {
                                            marker.bringToFront();
                                        }
                                    });
                                }
                            },

                            mouseout: function (e) {
                                const currentStyle = activePolygonStyle || DEFAULT_POLYGON_STYLE;

                                e.target.setStyle(currentStyle);

                                if (pointLayer) {
                                    pointLayer.eachLayer(function (marker) {
                                        if (marker && typeof marker.bringToFront === 'function') {
                                            marker.bringToFront();
                                        }
                                    });
                                }
                            }
                        });
                    }
                }).addTo(map);

                const bounds = geojsonLayer.getBounds();

                if (!bounds.isValid()) {
                    throw new Error('Bounds polygon tidak valid');
                }

                map.fitBounds(bounds, {
                    padding: [20, 20]
                });

                refreshMapSize();

                setStatus(`Polygon ${level} berhasil dimuat`, `${normalizedGeoJSON.features.length} fitur polygon terbaca`, 'success');

            } catch (error) {
                console.error(error);
                setStatus('Gagal memuat polygon', error.message, 'error');
            }
        }

        function getCheckedValues(name) {
            return Array.from(document.querySelectorAll(`input[name="${name}"]:checked`))
                .map(input => input.value);
        }

        function getSelectedDesil() {
            return document.querySelector('input[name="desil"]:checked')?.value || '';
        }

        function getSelectedExtraFilters() {
            return {
                komponen: getCheckedValues('komponen[]'),
                bansos: getCheckedValues('bansos[]'),
                jk: getCheckedValues('jk'),
                usia_dari: document.getElementById('usia_dari')?.value || '',
                usia_sampai: document.getElementById('usia_sampai')?.value || '',
            };
        }

        function getSelectedWilayahLabel() {
            return {
                kabupaten: kabupatenDropdown.getValue() ? kabupatenDropdown.getLabel() : 'Jawa Tengah',
                kecamatan: kecamatanDropdown.getValue() ? kecamatanDropdown.getLabel() : '-',
                desa: desaDropdown.getValue() ? desaDropdown.getLabel() : '-',
            };
        }

        function formatDesilLabel(desil) {
            return String(desil) === '6-10' ? 'Desil 6-10' : `Desil ${desil}`;
        }

        function formatDesilKpmLabel(desil) {
            return String(desil) === '6-10' ? 'Total KPM Desil 6-10' : `Total KPM Desil ${desil}`;
        }

        function getDesilPalette(desil) {
            const palettes = {
                /*
                |--------------------------------------------------------------------------
                | WARNA DESIL SESUAI REVISI PEMBIMBING
                |--------------------------------------------------------------------------
                | Desil 1    : Merah
                | Desil 2    : Oren
                | Desil 3    : Kuning
                | Desil 4    : Ijo muda
                | Desil 5    : Ijo tua
                | Desil 6-10 : Biru
                |
                | fill   = warna isi polygon / titik
                | stroke = warna garis polygon agar batas wilayah tetap jelas
                |--------------------------------------------------------------------------
                */
                '1': {
                    fill: '#ef4444',
                    stroke: '#b91c1c',
                    point: '#dc2626'
                },
                '2': {
                    fill: '#f97316',
                    stroke: '#c2410c',
                    point: '#ea580c'
                },
                '3': {
                    fill: '#facc15',
                    stroke: '#ca8a04',
                    point: '#eab308'
                },
                '4': {
                    fill: '#86efac',
                    stroke: '#16a34a',
                    point: '#22c55e'
                },
                '5': {
                    fill: '#15803d',
                    stroke: '#14532d',
                    point: '#166534'
                },
                '6-10': {
                    fill: '#3b82f6',
                    stroke: '#1d4ed8',
                    point: '#2563eb'
                },
                '6': {
                    fill: '#3b82f6',
                    stroke: '#1d4ed8',
                    point: '#2563eb'
                },
                '7': {
                    fill: '#3b82f6',
                    stroke: '#1d4ed8',
                    point: '#2563eb'
                },
                '8': {
                    fill: '#3b82f6',
                    stroke: '#1d4ed8',
                    point: '#2563eb'
                },
                '9': {
                    fill: '#3b82f6',
                    stroke: '#1d4ed8',
                    point: '#2563eb'
                },
                '10': {
                    fill: '#3b82f6',
                    stroke: '#1d4ed8',
                    point: '#2563eb'
                },
            };

            return palettes[String(desil)] || {
                fill: '#64748b',
                stroke: '#334155',
                point: '#475569'
            };
        }

        function getDesilColor(desil) {
            return getDesilPalette(desil).fill;
        }

        function getDesilStrokeColor(desil) {
            return getDesilPalette(desil).stroke;
        }

        function getDesilPointColor(desil) {
            return getDesilPalette(desil).point;
        }

        function getDesilFillOpacity(desil, totalKpm = 0) {
            if (Number(totalKpm || 0) <= 0) {
                return 0.14;
            }

            /*
            |--------------------------------------------------------------------------
            | TRANSPARANSI POLYGON
            |--------------------------------------------------------------------------
            | Dibuat tidak terlalu pekat agar jalan, nama wilayah, dan basemap
            | tetap mudah dibaca.
            |--------------------------------------------------------------------------
            */
            return String(desil) === '5' ? 0.30 : 0.34;
        }

        function getDesilHoverOpacity(desil, totalKpm = 0) {
            return Math.min(getDesilFillOpacity(desil, totalKpm) + 0.08, 0.46);
        }

        function normalizeWilayahText(value) {
            return String(value || '')
                .toUpperCase()
                .replace(/KABUPATEN/g, '')
                .replace(/KOTA/g, '')
                .replace(/KECAMATAN/g, '')
                .replace(/KELURAHAN/g, '')
                .replace(/DESA/g, '')
                .replace(/[^A-Z0-9]/g, '')
                .trim();
        }

        function getFeatureWilayah(feature) {
            const props = feature?.properties || {};

            return {
                kabupaten: normalizeWilayahText(
                    props.district ||
                    props.nama_kabupaten ||
                    props.kabupaten ||
                    props.WADMKK ||
                    props.KABUPATEN ||
                    ''
                ),
                kecamatan: normalizeWilayahText(
                    props.sub_district ||
                    props.nama_kecamatan ||
                    props.kecamatan ||
                    props.WADMKC ||
                    props.KECAMATAN ||
                    ''
                ),
                desa: normalizeWilayahText(
                    props.village ||
                    props.nama_desa ||
                    props.desa ||
                    props.WADMKD ||
                    props.DESA ||
                    props.KELURAHAN ||
                    ''
                )
            };
        }

        function getRecordWilayah(record) {
            return {
                kabupaten: normalizeWilayahText(record.nama_kabupaten),
                kecamatan: normalizeWilayahText(record.nama_kecamatan),
                desa: normalizeWilayahText(record.nama_desa)
            };
        }

        function findLayerForRecord(record) {
            if (!geojsonLayer) {
                return null;
            }

            const recordWilayah = getRecordWilayah(record);
            let fallbackLayer = null;
            let matchedLayer = null;

            geojsonLayer.eachLayer(function(layer) {
                if (matchedLayer) {
                    return;
                }

                fallbackLayer = fallbackLayer || layer;

                const featureWilayah = getFeatureWilayah(layer.feature);

                const desaMatch = recordWilayah.desa && featureWilayah.desa && recordWilayah.desa === featureWilayah.desa;
                const kecamatanMatch = recordWilayah.kecamatan && featureWilayah.kecamatan && recordWilayah.kecamatan === featureWilayah.kecamatan;
                const kabupatenMatch = recordWilayah.kabupaten && featureWilayah.kabupaten && recordWilayah.kabupaten === featureWilayah.kabupaten;

                if (selectedDesaId && desaMatch) {
                    matchedLayer = layer;
                    return;
                }

                if (selectedKecamatanId && desaMatch && kecamatanMatch) {
                    matchedLayer = layer;
                    return;
                }

                if (selectedKabupatenId && desaMatch && (kecamatanMatch || kabupatenMatch)) {
                    matchedLayer = layer;
                    return;
                }

                if (desaMatch) {
                    matchedLayer = layer;
                    return;
                }
            });

            return matchedLayer || fallbackLayer;
        }

        function flattenLatLngRings(latlngs, output = []) {
            if (!Array.isArray(latlngs)) {
                return output;
            }

            if (latlngs.length > 0 && latlngs[0] && typeof latlngs[0].lat === 'number' && typeof latlngs[0].lng === 'number') {
                output.push(latlngs);
                return output;
            }

            latlngs.forEach(item => flattenLatLngRings(item, output));
            return output;
        }

        function pointInsideRing(lat, lng, ring) {
            let inside = false;

            for (let i = 0, j = ring.length - 1; i < ring.length; j = i++) {
                const xi = ring[i].lng;
                const yi = ring[i].lat;
                const xj = ring[j].lng;
                const yj = ring[j].lat;

                const intersect = ((yi > lat) !== (yj > lat))
                    && (lng < (xj - xi) * (lat - yi) / ((yj - yi) || 0.0000001) + xi);

                if (intersect) {
                    inside = !inside;
                }
            }

            return inside;
        }

        function pointInsideLayer(lat, lng, layer) {
            const rings = flattenLatLngRings(layer.getLatLngs ? layer.getLatLngs() : []);

            if (rings.length === 0) {
                return false;
            }

            return rings.some(ring => pointInsideRing(lat, lng, ring));
        }

        function randomPointInsideLayer(layer) {
            if (!layer || !layer.getBounds) {
                return null;
            }

            const bounds = layer.getBounds();

            if (!bounds || !bounds.isValid()) {
                return null;
            }

            const south = bounds.getSouth();
            const north = bounds.getNorth();
            const west = bounds.getWest();
            const east = bounds.getEast();

            for (let i = 0; i < 120; i++) {
                const lat = south + Math.random() * (north - south);
                const lng = west + Math.random() * (east - west);

                if (pointInsideLayer(lat, lng, layer)) {
                    return [lat, lng];
                }
            }

            const center = bounds.getCenter();
            return [center.lat, center.lng];
        }

        function getFilteredRecordsWithKpm(result) {
            return (result.data || [])
                .map(record => ({
                    ...record,
                    jumlah_kpm: Number(record.jumlah_kpm || 0)
                }))
                .filter(record => record.jumlah_kpm > 0);
        }

        function calculateDotCount(recordKpm, totalKpm) {
            if (recordKpm <= 0 || totalKpm <= 0) {
                return 0;
            }

            if (totalKpm <= MAX_KPM_POINTS) {
                return Math.max(1, recordKpm);
            }

            return Math.max(1, Math.round((recordKpm / totalKpm) * MAX_KPM_POINTS));
        }

        function getKpmPointRadius() {
            const zoom = map.getZoom();

            if (zoom >= 16) return 6.8;
            if (zoom >= 15) return 6.3;
            if (zoom >= 14) return 5.8;
            if (zoom >= 13) return 5.2;
            if (zoom >= 12) return 4.8;

            return 4.3;
        }

        function getKpmPointStyle(selectedDesil) {
            return {
                pane: 'kpmPointPane',
                radius: getKpmPointRadius(),
                color: '#ffffff',
                weight: 2.4,
                fillColor: getDesilPointColor(selectedDesil),
                fillOpacity: 1,
                opacity: 1,
                interactive: true,
                bubblingMouseEvents: false
            };
        }

        function keepKpmPointsVisible() {
            if (!pointLayer) {
                return;
            }

            pointLayer.eachLayer(function (marker) {
                if (!marker) {
                    return;
                }

                if (typeof marker.setRadius === 'function') {
                    marker.setRadius(getKpmPointRadius());
                }

                if (typeof marker.bringToFront === 'function') {
                    marker.bringToFront();
                }
            });
        }

        function renderKpmPoints(result, selectedDesil) {
            if (pointLayer) {
                map.removeLayer(pointLayer);
                pointLayer = null;
            }

            const records = getFilteredRecordsWithKpm(result);
            const totalKpm = Number(result.total || 0);

            if (!geojsonLayer || records.length === 0 || totalKpm <= 0) {
                return;
            }

            pointLayer = L.layerGroup().addTo(map);

            let totalDotsRendered = 0;
            const scaleText = totalKpm > MAX_KPM_POINTS
                ? `1 titik mewakili sekitar ${formatNumber(Math.ceil(totalKpm / MAX_KPM_POINTS))} KPM`
                : `1 titik mewakili 1 KPM`;

            records.forEach(record => {
                if (totalDotsRendered >= MAX_KPM_POINTS) {
                    return;
                }

                const layer = findLayerForRecord(record);

                if (!layer) {
                    return;
                }

                let dotCount = calculateDotCount(record.jumlah_kpm, totalKpm);
                dotCount = Math.min(dotCount, MAX_KPM_POINTS - totalDotsRendered);

                for (let i = 0; i < dotCount; i++) {
                    const point = randomPointInsideLayer(layer);

                    if (!point) {
                        continue;
                    }

                    const marker = L.circleMarker(point, getKpmPointStyle(selectedDesil));

                    marker.bindPopup(`
                        <strong>${record.nama_desa || '-'}</strong><br>
                        Kecamatan: ${record.nama_kecamatan || '-'}<br>
                        Kabupaten/Kota: ${record.nama_kabupaten || '-'}<br>
                        ${formatDesilLabel(selectedDesil)}: ${formatNumber(record.jumlah_kpm)} KPM<br>
                        <small>${scaleText}</small>
                    `);

                    marker.addTo(pointLayer);
                    totalDotsRendered++;
                }
            });

            keepKpmPointsVisible();

            setStatus(
                'Data titik KPM berhasil ditampilkan',
                `${formatDesilLabel(selectedDesil)} | ${formatNumber(totalKpm)} KPM | ${formatNumber(totalDotsRendered)} titik tampil | ${scaleText}`,
                'success'
            );
        }

        function formatKomponenName(key) {
            const labels = {
                rlth: 'RLTH',
                air: 'Air Bersih',
                jamban: 'Jamban',
                listrik: 'Listrik',
                ats: 'ATS',
                disabilitas: 'Disabilitas',
                tidak_bekerja: 'Tidak Bekerja'
            };

            return labels[key] || key;
        }

        function formatBansosName(key) {
            const labels = {
                pkh: 'PKH',
                sembako: 'Sembako',
                pbi: 'PBI'
            };

            return labels[key] || key;
        }

        function formatJkName(key) {
            const labels = {
                L: 'Pria',
                P: 'Perempuan'
            };

            return labels[key] || key;
        }

        function buildAgeText(filters) {
            if (filters.usia_dari && filters.usia_sampai) {
                return `${filters.usia_dari}–${filters.usia_sampai} Tahun`;
            }

            if (filters.usia_dari) {
                return `Mulai ${filters.usia_dari} Tahun`;
            }

            if (filters.usia_sampai) {
                return `Sampai ${filters.usia_sampai} Tahun`;
            }

            return '-';
        }

        function addExcelLegend(desil, totalKpm) {
            if (excelLegend) {
                map.removeControl(excelLegend);
                excelLegend = null;
            }

            excelLegend = L.control({ position: 'bottomleft' });

            excelLegend.onAdd = function () {
                const div = L.DomUtil.create('div', 'legend-excel');

                div.innerHTML = `
                    <strong>Legenda Data Excel</strong>
                    <div class="legend-row">
                        <span class="legend-color" style="background:${DEFAULT_POLYGON_STYLE.fillColor}; border:1px solid ${DEFAULT_POLYGON_STYLE.color};"></span>
                        Batas Wilayah
                    </div>
                    <div class="legend-row">
                        <span class="legend-dot" style="background:${getDesilPointColor(desil)}"></span>
                        ${formatDesilLabel(desil)}: ${formatNumber(totalKpm)} KPM
                    </div>
                `;

                return div;
            };

            excelLegend.addTo(map);
        }

        function hideMapInfoCard() {
            if (!mapInfoCard) return;

            mapInfoCard.classList.remove('show');
            mapInfoCard.innerHTML = '';
        }

        function renderMapInfoCard(result) {
            if (!mapInfoCard) return;

            const wilayah = getSelectedWilayahLabel();
            const summary = result.summary || {};
            const selectedArea = result.selected_area || {};
            const desil = result.desil || getSelectedDesil();
            const totalKpm = result.total || summary.jumlah_kpm || 0;
            const totalRecord = result.total_record || summary.total_wilayah || 0;

            const extraFilters = getSelectedExtraFilters();
            const komponen = extraFilters.komponen;
            const bansos = extraFilters.bansos;
            const jk = extraFilters.jk;
            const ageText = buildAgeText(extraFilters);

            let komponenHtml = '';

            if (komponen.length > 0) {
                komponen.forEach(key => {
                    komponenHtml += `
                        <div class="info-row">
                            <div class="info-label">
                                <span class="info-check">✓</span>
                                <span>${formatKomponenName(key)}</span>
                            </div>
                            <div class="info-value">Dipilih</div>
                        </div>
                    `;
                });
            } else {
                komponenHtml = `
                    <div class="info-row">
                        <span>Komponen tidak dipilih</span>
                        <span class="info-value">-</span>
                    </div>
                `;
            }

            let jkHtml = '';

            if (jk.length > 0) {
                jk.forEach(key => {
                    jkHtml += `
                        <div class="info-row">
                            <span>${formatJkName(key)}</span>
                            <span class="info-value">Dipilih</span>
                        </div>
                    `;
                });
            } else {
                jkHtml = `
                    <div class="info-row">
                        <span>Jenis kelamin tidak dipilih</span>
                        <span class="info-value">-</span>
                    </div>
                `;
            }

            let bansosHtml = '';

            if (bansos.length > 0) {
                bansos.forEach(key => {
                    bansosHtml += `
                        <div class="info-row">
                            <span>${formatBansosName(key)}</span>
                            <span class="info-value">Dipilih</span>
                        </div>
                    `;
                });
            } else {
                bansosHtml = `
                    <div class="info-row">
                        <span>Bansos tidak dipilih</span>
                        <span class="info-value">-</span>
                    </div>
                `;
            }

            mapInfoCard.innerHTML = `
                <div class="map-info-header">
                    <button class="map-info-close" type="button" onclick="hideMapInfoCard()">×</button>
                    <h3>${wilayah.kabupaten || selectedArea.kabupaten || '-'}</h3>
                    <p>${wilayah.kecamatan || selectedArea.kecamatan || '-'}</p>
                    <p>${wilayah.desa || selectedArea.desa || '-'}</p>
                </div>

                <div class="map-info-body">
                    <div class="info-row">
                        <span class="info-badge">${formatDesilLabel(desil)}</span>
                        <span class="info-value">${formatNumber(totalKpm)} KPM</span>
                    </div>

                    <div class="info-section">
                        <div class="info-section-title">Data Desil:</div>

                        <div class="info-row">
                            <span>Total Wilayah Cocok</span>
                            <span class="info-value">${formatNumber(totalRecord)}</span>
                        </div>

                        <div class="info-row">
                            <span>${formatDesilKpmLabel(desil)}</span>
                            <span class="info-value">${formatNumber(totalKpm)}</span>
                        </div>
                    </div>

                    <div class="info-section">
                        <div class="info-section-title">Komponen kebutuhan:</div>
                        ${komponenHtml}
                    </div>

                    <div class="info-section">
                        <div class="info-section-title">Usia:</div>
                        <div class="info-row">
                            <span>${ageText}</span>
                            <span class="info-value">${ageText === '-' ? '-' : 'Dipilih'}</span>
                        </div>
                    </div>

                    <div class="info-section">
                        <div class="info-section-title">Jenis Kelamin:</div>
                        ${jkHtml}
                    </div>

                    <div class="info-section">
                        <div class="info-section-title">Bansos:</div>
                        ${bansosHtml}
                    </div>
                </div>
            `;

            mapInfoCard.classList.add('show');
        }

        async function applyExcelDesilFilter() {
            const selectedDesil = getSelectedDesil();

            if (!selectedLevel || !selectedWilayahId) {
                setStatus('Pilih wilayah terlebih dahulu', 'Minimal pilih Kabupaten/Kota sebelum klik Kirim.', 'error');
                return;
            }

            if (!selectedDesil) {
                setStatus('Pilih desil terlebih dahulu', 'Pilih Desil 1, 2, 3, 4, 5, atau Desil 6-10.', 'error');
                return;
            }

            try {
                clearFilterLayer();

                setStatus('Memuat data desil...', 'Data sedang diambil dari tabel desil_desas.', 'loading');

                const response = await fetch('/api/filter', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({
                        kabupaten_id: selectedKabupatenId,
                        kecamatan_id: selectedKecamatanId,
                        desa_id: selectedDesaId,
                        desil: selectedDesil,
                        komponen: getCheckedValues('komponen[]'),
                        usia_dari: document.getElementById('usia_dari')?.value || '',
                        usia_sampai: document.getElementById('usia_sampai')?.value || '',
                        jenis_kelamin: getCheckedValues('jk')[0] || '',
                        bansos: getCheckedValues('bansos[]')
                    })
                });

                const result = await response.json();

                if (!response.ok || !result.success) {
                    throw new Error(result.message || 'Gagal memuat data desil.');
                }

                result.desil = selectedDesil;

                renderMapInfoCard(result);
                addExcelLegend(selectedDesil, result.total || 0);
                highlightCurrentPolygon(selectedDesil, result.total || 0);
                renderKpmPoints(result, selectedDesil);

                setStatus(
                    'Data desil berhasil ditampilkan',
                    `${formatDesilLabel(selectedDesil)} | Total ${formatNumber(result.total || 0)} KPM | Wilayah cocok: ${formatNumber(result.total_record || 0)}`,
                    'success'
                );

            } catch (error) {
                console.error(error);
                setStatus('Gagal memuat data desil', error.message, 'error');
            }
        }

        function highlightCurrentPolygon(desil, totalKpm) {
            if (!geojsonLayer) {
                return;
            }

            /*
            |--------------------------------------------------------------------------
            | BATAS WILAYAH TETAP DEFAULT
            |--------------------------------------------------------------------------
            | Sesuai revisi: warna desil hanya dipakai untuk titik KPM.
            | Polygon/batas wilayah tidak ikut warna desil agar tampilan peta
            | tetap bersih dan tidak terlalu penuh warna.
            |--------------------------------------------------------------------------
            */
            activeDesil = desil;
            activeTotalKpm = Number(totalKpm || 0);

            activePolygonStyle = {
                ...DEFAULT_POLYGON_STYLE,
                weight: 2.2,
                fillOpacity: 0.18
            };

            geojsonLayer.eachLayer(function (layer) {
                if (layer && typeof layer.setStyle === 'function') {
                    layer.setStyle(activePolygonStyle);
                }

                layer.bindPopup(`
                    <strong>${formatDesilLabel(desil)}</strong><br>
                    Jumlah KPM: ${formatNumber(totalKpm)}
                `);
            });

            keepKpmPointsVisible();
        }

        const applyFilterBtn = document.getElementById('apply-filter-btn');

        if (applyFilterBtn) {
            applyFilterBtn.addEventListener('click', applyExcelDesilFilter);
        }

        document.querySelectorAll('input[name="desil"], input[name="komponen[]"], input[name="bansos[]"], input[name="jk"]').forEach(input => {
            input.addEventListener('change', () => {
                const selectedDesil = getSelectedDesil();
                const extra = getSelectedExtraFilters();

                const totalExtra =
                    extra.komponen.length +
                    extra.bansos.length +
                    extra.jk.length +
                    (extra.usia_dari ? 1 : 0) +
                    (extra.usia_sampai ? 1 : 0);

                if (selectedDesil) {
                    setStatus(
                        `${formatDesilLabel(selectedDesil)} dipilih`,
                        totalExtra > 0
                            ? `${totalExtra} filter tambahan dipilih. Klik Kirim untuk menampilkan data.`
                            : 'Klik Kirim untuk menampilkan data.',
                        'success'
                    );
                }
            });
        });

        map.on('zoomend moveend layeradd', keepKpmPointsVisible);

        window.addEventListener('load', refreshMapSize);
        window.addEventListener('resize', refreshMapSize);
        window.addEventListener('orientationchange', refreshMapSize);
        setTimeout(refreshMapSize, 250);
        setTimeout(refreshMapSize, 900);
    </script>
@endpush