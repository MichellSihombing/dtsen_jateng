@extends('admin.layouts.app')

@section('title', 'Kelola Wilayah')
@section('breadcrumb', 'Data Wilayah')

@section('content')
    <style>
        /*
        |--------------------------------------------------------------------------
        | WILAYAH CARD
        |--------------------------------------------------------------------------
        */

        .wilayah-card {
            position: relative;
            background: rgba(255,255,255,0.9);
            border: 1px solid rgba(226,232,240,0.9);
            border-radius: 26px;
            padding: 24px;
            box-shadow: 0 18px 45px rgba(15,23,42,0.07);
            margin-bottom: 22px;
            animation: fadeUp 0.55s ease both;
            overflow: visible;
        }

        .wilayah-form-card {
            z-index: 3000;
        }

        .wilayah-table-card {
            z-index: 1;
        }

        .wilayah-title {
            font-size: 22px;
            font-weight: 900;
            margin-bottom: 18px;
            color: #0f172a;
        }

        /*
        |--------------------------------------------------------------------------
        | TAB WILAYAH
        |--------------------------------------------------------------------------
        */

        .tabs-modern {
            display: flex;
            gap: 8px;
            margin-bottom: 16px;
            flex-wrap: wrap;
        }

        .tab-modern {
            padding: 10px 16px;
            border-radius: 999px;
            background: #eef2f7;
            color: #334155;
            text-decoration: none;
            font-weight: 900;
            font-size: 13px;
            transition: 0.22s ease;
        }

        .tab-modern:hover,
        .tab-modern.active {
            background: #2563eb;
            color: white;
            transform: translateY(-1px);
            box-shadow: 0 12px 20px rgba(37,99,235,0.20);
        }

        /*
        |--------------------------------------------------------------------------
        | FORM TAMBAH DATA
        |--------------------------------------------------------------------------
        */

        .form-grid-modern {
            position: relative;
            z-index: 3100;
            display: grid;
            grid-template-columns: repeat(4, minmax(0, 1fr));
            gap: 10px;
            align-items: start;
        }

        .input-modern {
            width: 100%;
            height: 46px;
            border: 1px solid #dbe4ef;
            border-radius: 14px;
            padding: 0 13px;
            outline: none;
            transition: 0.22s ease;
            background: white;
            font-size: 13px;
            font-weight: 650;
            color: #0f172a;
        }

        .input-modern:focus {
            border-color: #2563eb;
            box-shadow: 0 0 0 5px rgba(37,99,235,0.10);
        }

        .input-modern::placeholder {
            color: #94a3b8;
            font-weight: 600;
        }

        /*
        |--------------------------------------------------------------------------
        | CUSTOM DROPDOWN MODERN
        |--------------------------------------------------------------------------
        */

        .wilayah-select {
            position: relative;
            width: 100%;
            min-width: 0;
            z-index: 3200;
        }

        .wilayah-select.is-open {
            z-index: 99999;
        }

        .wilayah-select-trigger {
            width: 100%;
            height: 46px;
            border: 1px solid #dbe4ef;
            border-radius: 14px;
            background: #ffffff;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 12px;
            padding: 0 10px 0 14px;
            cursor: pointer;
            transition: 0.22s ease;
            box-shadow: 0 8px 18px rgba(15,23,42,0.025);
            color: #0f172a;
        }

        .wilayah-select-trigger:hover {
            border-color: #93c5fd;
            box-shadow: 0 10px 24px rgba(37,99,235,0.08);
            transform: translateY(-1px);
        }

        .wilayah-select.is-open .wilayah-select-trigger {
            border-color: #2563eb;
            box-shadow: 0 0 0 5px rgba(37,99,235,0.10), 0 16px 34px rgba(15,23,42,0.11);
        }

        .wilayah-select-label {
            overflow: hidden;
            white-space: nowrap;
            text-overflow: ellipsis;
            font-size: 13px;
            font-weight: 750;
            line-height: 1.2;
            color: #0f172a;
        }

        .wilayah-select-label.placeholder {
            color: #64748b;
            font-weight: 650;
        }

        .wilayah-select-arrow {
            width: 30px;
            height: 30px;
            border-radius: 999px;
            background: #eff6ff;
            display: grid;
            place-items: center;
            color: #2563eb;
            flex: 0 0 auto;
            transition: 0.22s ease;
            font-size: 13px;
            font-weight: 900;
        }

        .wilayah-select.is-open .wilayah-select-arrow {
            background: #2563eb;
            color: #ffffff;
            transform: rotate(180deg);
        }

        .wilayah-select-menu {
            position: absolute;
            top: calc(100% + 8px);
            left: 0;
            right: 0;
            z-index: 999999;
            background: rgba(255,255,255,0.98);
            border: 1px solid #dbeafe;
            border-radius: 18px;
            box-shadow: 0 26px 70px rgba(15,23,42,0.22);
            padding: 10px;
            visibility: hidden;
            opacity: 0;
            transform: translateY(-8px) scale(0.98);
            transform-origin: top center;
            transition: 0.22s cubic-bezier(.2, .8, .2, 1);
            backdrop-filter: blur(14px);
        }

        .wilayah-select.is-open .wilayah-select-menu {
            visibility: visible;
            opacity: 1;
            transform: translateY(0) scale(1);
        }

        .wilayah-select-search-wrap {
            position: relative;
            margin-bottom: 8px;
        }

        .wilayah-select-search-wrap::before {
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

        .wilayah-select-search {
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

        .wilayah-select-search:focus {
            border-color: #2563eb;
            background: #ffffff;
            box-shadow: 0 0 0 4px rgba(37,99,235,0.08);
        }

        .wilayah-select-options {
            max-height: 260px;
            overflow-y: auto;
            padding-right: 3px;
        }

        .wilayah-select-options::-webkit-scrollbar {
            width: 7px;
        }

        .wilayah-select-options::-webkit-scrollbar-track {
            background: #e2e8f0;
            border-radius: 999px;
        }

        .wilayah-select-options::-webkit-scrollbar-thumb {
            background: #94a3b8;
            border-radius: 999px;
        }

        .wilayah-select-option {
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

        .wilayah-select-option:hover {
            background: #eff6ff;
            color: #2563eb;
            transform: translateX(3px);
        }

        .wilayah-select-option.is-selected {
            background: linear-gradient(135deg, #2563eb, #0ea5e9);
            color: #ffffff;
            box-shadow: 0 12px 24px rgba(37,99,235,0.18);
        }

        .wilayah-select-option.is-selected::after {
            content: "✓";
            width: 22px;
            height: 22px;
            border-radius: 999px;
            background: rgba(255,255,255,0.20);
            display: grid;
            place-items: center;
            font-size: 11px;
            flex: 0 0 auto;
        }

        .wilayah-select-empty {
            display: none;
            padding: 14px 10px;
            color: #64748b;
            font-size: 13px;
            font-weight: 700;
            text-align: center;
        }

        .wilayah-select.no-result .wilayah-select-empty,
        .wilayah-select-empty.show {
            display: block;
        }

        /*
        |--------------------------------------------------------------------------
        | BUTTON MODERN
        |--------------------------------------------------------------------------
        */

        .btn-modern {
            border: none;
            border-radius: 14px;
            padding: 11px 15px;
            font-size: 13px;
            font-weight: 900;
            cursor: pointer;
            transition: 0.22s ease;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            white-space: nowrap;
            min-height: 46px;
        }

        .btn-modern:hover {
            transform: translateY(-2px);
        }

        .btn-add {
            background: #16a34a;
            color: white;
        }

        .btn-add:hover {
            background: #15803d;
            box-shadow: 0 12px 20px rgba(22,163,74,0.20);
        }

        .btn-save-icon {
            width: 42px;
            height: 42px;
            padding: 0;
            border-radius: 15px;
            background: #dcfce7;
            color: #166534;
        }

        .btn-delete-icon {
            width: 42px;
            height: 42px;
            padding: 0;
            border-radius: 15px;
            background: #fee2e2;
            color: #991b1b;
        }

        .btn-save-icon:hover {
            background: #16a34a;
            color: white;
            box-shadow: 0 12px 20px rgba(22,163,74,0.20);
        }

        .btn-delete-icon:hover {
            background: #dc2626;
            color: white;
            box-shadow: 0 12px 20px rgba(220,38,38,0.20);
        }

        /*
        |--------------------------------------------------------------------------
        | TABLE WRAPPER
        |--------------------------------------------------------------------------
        */

        .table-wrap-modern {
            position: relative;
            z-index: 1;
            width: 100%;
            overflow-x: auto;
            border-radius: 20px;
            border: 1px solid #e5eaf1;
        }

        /*
        |--------------------------------------------------------------------------
        | TABLE DATA WILAYAH
        |--------------------------------------------------------------------------
        */

        .table-modern {
            width: 100%;
            border-collapse: collapse;
            min-width: 1050px;
            font-size: 13px;
            background: white;
        }

        .table-modern th {
            background: #f8fafc;
            padding: 14px;
            text-align: left;
            color: #475569;
            font-size: 12px;
            font-weight: 900;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            border-bottom: 1px solid #e5eaf1;
            white-space: nowrap;
        }

        .table-modern td {
            padding: 12px 14px;
            border-bottom: 1px solid #eef2f7;
            vertical-align: middle;
        }

        .table-modern tr {
            transition: 0.18s ease;
        }

        .table-modern tr:hover {
            background: #f8fafc;
        }

        /*
        |--------------------------------------------------------------------------
        | INPUT TABLE
        |--------------------------------------------------------------------------
        */

        .table-input-modern {
            width: 100%;
            height: 42px;
            border: 1px solid #dbe4ef;
            border-radius: 12px;
            padding: 0 10px;
            outline: none;
            font-size: 13px;
            min-width: 150px;
            background: white;
        }

        .table-input-modern:focus {
            border-color: #2563eb;
            box-shadow: 0 0 0 4px rgba(37,99,235,0.08);
        }

        select.table-input-modern {
            appearance: none;
            background-image:
                linear-gradient(45deg, transparent 50%, #2563eb 50%),
                linear-gradient(135deg, #2563eb 50%, transparent 50%);
            background-position:
                calc(100% - 18px) 17px,
                calc(100% - 12px) 17px;
            background-size: 6px 6px, 6px 6px;
            background-repeat: no-repeat;
            padding-right: 34px;
            cursor: pointer;
        }

        .action-cell-modern {
            display: flex;
            gap: 8px;
            align-items: center;
        }

        /*
        |--------------------------------------------------------------------------
        | PAGINATION
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
            font-weight: 700;
        }

        .pagination-links {
            display: flex;
            align-items: center;
            gap: 8px;
            flex-wrap: wrap;
        }

        .page-link-custom {
            min-width: 38px;
            height: 38px;
            padding: 0 12px;
            border-radius: 13px;
            border: 1px solid #dbe4ef;
            background: white;
            color: #334155;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            text-decoration: none;
            font-size: 13px;
            font-weight: 900;
            transition: 0.22s ease;
        }

        .page-link-custom:hover {
            background: #eef5ff;
            border-color: #2563eb;
            color: #2563eb;
            transform: translateY(-1px);
        }

        .page-link-custom.active {
            background: #2563eb;
            border-color: #2563eb;
            color: white;
            box-shadow: 0 12px 20px rgba(37,99,235,0.20);
        }

        .page-link-custom.disabled {
            opacity: 0.45;
            pointer-events: none;
        }

        /*
        |--------------------------------------------------------------------------
        | ANIMASI HALAMAN
        |--------------------------------------------------------------------------
        */

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
        | RESPONSIVE TABLET
        |--------------------------------------------------------------------------
        */

        @media (max-width: 1100px) {
            .form-grid-modern {
                grid-template-columns: repeat(2, minmax(0, 1fr));
            }
        }

        /*
        |--------------------------------------------------------------------------
        | RESPONSIVE MOBILE
        |--------------------------------------------------------------------------
        */

        @media (max-width: 720px) {
            .wilayah-card {
                padding: 18px;
                border-radius: 22px;
            }

            .form-grid-modern {
                grid-template-columns: 1fr;
            }

            .custom-pagination {
                align-items: flex-start;
                flex-direction: column;
            }

            .wilayah-select-menu {
                position: fixed;
                left: 16px;
                right: 16px;
                top: auto;
                bottom: 16px;
                max-height: 70vh;
            }

            .wilayah-select-options {
                max-height: 48vh;
            }
        }
    </style>

    {{--
    |--------------------------------------------------------------------------
    | FORM TAMBAH WILAYAH
    |--------------------------------------------------------------------------
    --}}
    <div class="wilayah-card wilayah-form-card">
        <div class="wilayah-title">Kelola Data Wilayah</div>

        {{--
        |--------------------------------------------------------------------------
        | TAB PILIHAN WILAYAH
        |--------------------------------------------------------------------------
        --}}
        <div class="tabs-modern">
            <a
                href="{{ route('admin.wilayah.index', ['type' => 'kabupaten']) }}"
                class="tab-modern {{ $type === 'kabupaten' ? 'active' : '' }}"
            >
                Kabupaten/Kota
            </a>

            <a
                href="{{ route('admin.wilayah.index', ['type' => 'kecamatan']) }}"
                class="tab-modern {{ $type === 'kecamatan' ? 'active' : '' }}"
            >
                Kecamatan
            </a>

            <a
                href="{{ route('admin.wilayah.index', ['type' => 'desa']) }}"
                class="tab-modern {{ $type === 'desa' ? 'active' : '' }}"
            >
                Desa
            </a>
        </div>

        <form action="{{ route('admin.wilayah.store') }}" method="POST">
            @csrf
            <input type="hidden" name="type" value="{{ $type }}">

            {{--
            |--------------------------------------------------------------------------
            | FORM KABUPATEN/KOTA
            |--------------------------------------------------------------------------
            --}}
            @if($type === 'kabupaten')
                <div class="form-grid-modern">
                    <input class="input-modern" name="kode_kabupaten" placeholder="Kode Kabupaten" required>
                    <input class="input-modern" name="nama_kabupaten" placeholder="Nama Kabupaten/Kota" required>
                    <input class="input-modern" name="geojson_path" placeholder="GeoJSON Path">

                    <button class="btn-modern btn-add" type="submit">
                        <i class="fa fa-plus"></i>
                        Tambah
                    </button>
                </div>
            @endif

            {{--
            |--------------------------------------------------------------------------
            | FORM KECAMATAN
            |--------------------------------------------------------------------------
            --}}
            @if($type === 'kecamatan')
                <div class="form-grid-modern">
                    <input type="hidden" name="kabupaten_id" id="store_kabupaten_id" required>

                    <div
                        class="wilayah-select"
                        data-target="store_kabupaten_id"
                        data-placeholder="Pilih Kabupaten"
                    >
                        <button type="button" class="wilayah-select-trigger">
                            <span class="wilayah-select-label placeholder">Pilih Kabupaten</span>
                            <span class="wilayah-select-arrow">⌄</span>
                        </button>

                        <div class="wilayah-select-menu">
                            <div class="wilayah-select-search-wrap">
                                <input
                                    type="text"
                                    class="wilayah-select-search"
                                    placeholder="Cari kabupaten/kota..."
                                >
                            </div>

                            <div class="wilayah-select-options">
                                @foreach($kabupatens as $kabupaten)
                                    <div
                                        class="wilayah-select-option"
                                        data-value="{{ $kabupaten->id }}"
                                        data-label="{{ $kabupaten->nama_kabupaten }}"
                                    >
                                        {{ $kabupaten->nama_kabupaten }}
                                    </div>
                                @endforeach

                                <div class="wilayah-select-empty">Data tidak ditemukan</div>
                            </div>
                        </div>
                    </div>

                    <input class="input-modern" name="kode_kecamatan" placeholder="Kode Kecamatan" required>
                    <input class="input-modern" name="nama_kecamatan" placeholder="Nama Kecamatan" required>
                    <input class="input-modern" name="geojson_path" placeholder="GeoJSON Path">

                    <button class="btn-modern btn-add" type="submit">
                        <i class="fa fa-plus"></i>
                        Tambah
                    </button>
                </div>
            @endif

            {{--
            |--------------------------------------------------------------------------
            | FORM DESA
            |--------------------------------------------------------------------------
            --}}
            @if($type === 'desa')
                <div class="form-grid-modern">
                    <input type="hidden" name="kecamatan_id" id="store_kecamatan_id" required>

                    <div
                        class="wilayah-select"
                        data-target="store_kecamatan_id"
                        data-placeholder="Pilih Kecamatan"
                    >
                        <button type="button" class="wilayah-select-trigger">
                            <span class="wilayah-select-label placeholder">Pilih Kecamatan</span>
                            <span class="wilayah-select-arrow">⌄</span>
                        </button>

                        <div class="wilayah-select-menu">
                            <div class="wilayah-select-search-wrap">
                                <input
                                    type="text"
                                    class="wilayah-select-search"
                                    placeholder="Cari kecamatan..."
                                >
                            </div>

                            <div class="wilayah-select-options">
                                @foreach($kecamatans as $kecamatan)
                                    <div
                                        class="wilayah-select-option"
                                        data-value="{{ $kecamatan->id }}"
                                        data-label="{{ $kecamatan->nama_kecamatan }} - {{ $kecamatan->kabupaten?->nama_kabupaten }}"
                                    >
                                        {{ $kecamatan->nama_kecamatan }} - {{ $kecamatan->kabupaten?->nama_kabupaten }}
                                    </div>
                                @endforeach

                                <div class="wilayah-select-empty">Data tidak ditemukan</div>
                            </div>
                        </div>
                    </div>

                    <input class="input-modern" name="kode_desa" placeholder="Kode Desa" required>
                    <input class="input-modern" name="nama_desa" placeholder="Nama Desa" required>
                    <input class="input-modern" name="geojson_path" placeholder="GeoJSON Path">

                    <button class="btn-modern btn-add" type="submit">
                        <i class="fa fa-plus"></i>
                        Tambah
                    </button>
                </div>
            @endif
        </form>
    </div>

    {{--
    |--------------------------------------------------------------------------
    | TABEL DATA WILAYAH
    |--------------------------------------------------------------------------
    --}}
    <div class="wilayah-card wilayah-table-card">
        <div class="wilayah-title">
            Data {{ $type === 'kabupaten' ? 'Kabupaten/Kota' : ucfirst($type) }}
        </div>

        <div class="table-wrap-modern">
            <table class="table-modern">
                <thead>
                    <tr>
                        <th width="70">ID</th>
                        <th>Kode</th>
                        <th>Nama</th>
                        <th>Parent</th>
                        <th>GeoJSON</th>
                        <th width="120">Aksi</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach($items as $item)
                        @php
                            $updateFormId = 'update-wilayah-' . $type . '-' . $item->id;
                            $deleteFormId = 'delete-wilayah-' . $type . '-' . $item->id;
                        @endphp

                        <tr>
                            <td>
                                <strong>#{{ $item->id }}</strong>
                            </td>

                            {{--
                            |--------------------------------------------------------------------------
                            | ROW KABUPATEN/KOTA
                            |--------------------------------------------------------------------------
                            --}}
                            @if($type === 'kabupaten')
                                <td>
                                    <input
                                        class="table-input-modern"
                                        name="kode_kabupaten"
                                        value="{{ $item->kode_kabupaten }}"
                                        form="{{ $updateFormId }}"
                                    >
                                </td>

                                <td>
                                    <input
                                        class="table-input-modern"
                                        name="nama_kabupaten"
                                        value="{{ $item->nama_kabupaten }}"
                                        form="{{ $updateFormId }}"
                                    >
                                </td>

                                <td>-</td>

                                <td>
                                    <input
                                        class="table-input-modern"
                                        name="geojson_path"
                                        value="{{ $item->geojson_path }}"
                                        form="{{ $updateFormId }}"
                                    >
                                </td>
                            @endif

                            {{--
                            |--------------------------------------------------------------------------
                            | ROW KECAMATAN
                            |--------------------------------------------------------------------------
                            --}}
                            @if($type === 'kecamatan')
                                <td>
                                    <input
                                        class="table-input-modern"
                                        name="kode_kecamatan"
                                        value="{{ $item->kode_kecamatan }}"
                                        form="{{ $updateFormId }}"
                                    >
                                </td>

                                <td>
                                    <input
                                        class="table-input-modern"
                                        name="nama_kecamatan"
                                        value="{{ $item->nama_kecamatan }}"
                                        form="{{ $updateFormId }}"
                                    >
                                </td>

                                <td>
                                    <select
                                        class="table-input-modern"
                                        name="kabupaten_id"
                                        form="{{ $updateFormId }}"
                                    >
                                        @foreach($kabupatens as $kabupaten)
                                            <option value="{{ $kabupaten->id }}" {{ $item->kabupaten_id == $kabupaten->id ? 'selected' : '' }}>
                                                {{ $kabupaten->nama_kabupaten }}
                                            </option>
                                        @endforeach
                                    </select>
                                </td>

                                <td>
                                    <input
                                        class="table-input-modern"
                                        name="geojson_path"
                                        value="{{ $item->geojson_path }}"
                                        form="{{ $updateFormId }}"
                                    >
                                </td>
                            @endif

                            {{--
                            |--------------------------------------------------------------------------
                            | ROW DESA
                            |--------------------------------------------------------------------------
                            --}}
                            @if($type === 'desa')
                                <td>
                                    <input
                                        class="table-input-modern"
                                        name="kode_desa"
                                        value="{{ $item->kode_desa }}"
                                        form="{{ $updateFormId }}"
                                    >
                                </td>

                                <td>
                                    <input
                                        class="table-input-modern"
                                        name="nama_desa"
                                        value="{{ $item->nama_desa }}"
                                        form="{{ $updateFormId }}"
                                    >
                                </td>

                                <td>
                                    <select
                                        class="table-input-modern"
                                        name="kecamatan_id"
                                        form="{{ $updateFormId }}"
                                    >
                                        @foreach($kecamatans as $kecamatan)
                                            <option value="{{ $kecamatan->id }}" {{ $item->kecamatan_id == $kecamatan->id ? 'selected' : '' }}>
                                                {{ $kecamatan->nama_kecamatan }}
                                            </option>
                                        @endforeach
                                    </select>
                                </td>

                                <td>
                                    <input
                                        class="table-input-modern"
                                        name="geojson_path"
                                        value="{{ $item->geojson_path }}"
                                        form="{{ $updateFormId }}"
                                    >
                                </td>
                            @endif

                            {{--
                            |--------------------------------------------------------------------------
                            | AKSI DATA WILAYAH
                            |--------------------------------------------------------------------------
                            --}}
                            <td>
                                <div class="action-cell-modern">
                                    <form
                                        id="{{ $updateFormId }}"
                                        action="{{ route('admin.wilayah.update', [$type, $item->id]) }}"
                                        method="POST"
                                    >
                                        @csrf
                                        @method('PUT')

                                        <button class="btn-modern btn-save-icon" type="submit" title="Simpan">
                                            <i class="fa fa-save"></i>
                                        </button>
                                    </form>

                                    <form
                                        id="{{ $deleteFormId }}"
                                        action="{{ route('admin.wilayah.destroy', [$type, $item->id]) }}"
                                        method="POST"
                                        onsubmit="return confirm('Yakin hapus data ini?')"
                                    >
                                        @csrf
                                        @method('DELETE')

                                        <button class="btn-modern btn-delete-icon" type="submit" title="Hapus">
                                            <i class="fa fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        {{--
        |--------------------------------------------------------------------------
        | PAGINATION CUSTOM
        |--------------------------------------------------------------------------
        --}}
        @if($items && $items->total() > 0)
            <div class="custom-pagination">
                <div class="pagination-info">
                    Menampilkan {{ $items->firstItem() }} sampai {{ $items->lastItem() }}
                    dari {{ $items->total() }} data
                </div>

                <div class="pagination-links">
                    <a
                        class="page-link-custom {{ $items->onFirstPage() ? 'disabled' : '' }}"
                        href="{{ $items->previousPageUrl() ?? '#' }}"
                    >
                        <i class="fa fa-chevron-left"></i>
                    </a>

                    @php
                        $start = max(1, $items->currentPage() - 2);
                        $end = min($items->lastPage(), $items->currentPage() + 2);
                    @endphp

                    @if($start > 1)
                        <a class="page-link-custom" href="{{ $items->url(1) }}">1</a>

                        @if($start > 2)
                            <span class="page-link-custom disabled">...</span>
                        @endif
                    @endif

                    @for($page = $start; $page <= $end; $page++)
                        <a
                            class="page-link-custom {{ $page == $items->currentPage() ? 'active' : '' }}"
                            href="{{ $items->url($page) }}"
                        >
                            {{ $page }}
                        </a>
                    @endfor

                    @if($end < $items->lastPage())
                        @if($end < $items->lastPage() - 1)
                            <span class="page-link-custom disabled">...</span>
                        @endif

                        <a class="page-link-custom" href="{{ $items->url($items->lastPage()) }}">
                            {{ $items->lastPage() }}
                        </a>
                    @endif

                    <a
                        class="page-link-custom {{ $items->hasMorePages() ? '' : 'disabled' }}"
                        href="{{ $items->nextPageUrl() ?? '#' }}"
                    >
                        <i class="fa fa-chevron-right"></i>
                    </a>
                </div>
            </div>
        @endif
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const selects = document.querySelectorAll('.wilayah-select');

            selects.forEach(function (select) {
                const trigger = select.querySelector('.wilayah-select-trigger');
                const label = select.querySelector('.wilayah-select-label');
                const search = select.querySelector('.wilayah-select-search');
                const options = select.querySelectorAll('.wilayah-select-option');
                const empty = select.querySelector('.wilayah-select-empty');
                const targetId = select.dataset.target;
                const targetInput = document.getElementById(targetId);

                trigger.addEventListener('click', function (event) {
                    event.preventDefault();
                    event.stopPropagation();

                    document.querySelectorAll('.wilayah-select.is-open').forEach(function (opened) {
                        if (opened !== select) {
                            opened.classList.remove('is-open');
                        }
                    });

                    select.classList.toggle('is-open');

                    if (select.classList.contains('is-open') && search) {
                        setTimeout(function () {
                            search.focus();
                        }, 120);
                    }
                });

                options.forEach(function (option) {
                    option.addEventListener('click', function (event) {
                        event.stopPropagation();

                        const value = option.dataset.value;
                        const text = option.dataset.label;

                        if (targetInput) {
                            targetInput.value = value;
                        }

                        label.textContent = text;
                        label.classList.remove('placeholder');

                        options.forEach(function (item) {
                            item.classList.remove('is-selected');
                        });

                        option.classList.add('is-selected');
                        select.classList.remove('is-open');
                    });
                });

                if (search) {
                    search.addEventListener('click', function (event) {
                        event.stopPropagation();
                    });

                    search.addEventListener('input', function () {
                        const keyword = search.value.toLowerCase().trim();
                        let totalShown = 0;

                        options.forEach(function (option) {
                            const text = option.dataset.label.toLowerCase();

                            if (text.includes(keyword)) {
                                option.style.display = 'flex';
                                totalShown++;
                            } else {
                                option.style.display = 'none';
                            }
                        });

                        if (empty) {
                            empty.classList.toggle('show', totalShown === 0);
                        }

                        select.classList.toggle('no-result', totalShown === 0);
                    });
                }
            });

            document.addEventListener('click', function () {
                document.querySelectorAll('.wilayah-select.is-open').forEach(function (select) {
                    select.classList.remove('is-open');
                });
            });

            document.addEventListener('keydown', function (event) {
                if (event.key === 'Escape') {
                    document.querySelectorAll('.wilayah-select.is-open').forEach(function (select) {
                        select.classList.remove('is-open');
                    });
                }
            });
        });
    </script>
@endsection