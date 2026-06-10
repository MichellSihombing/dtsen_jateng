{{-- HALAMAN DT JATENG --}}
{{-- LAYOUT YANG DIGUNAKAN --}}
@extends('layouts.app')

{{-- JUDUL HALAMAN --}}
@section('title', 'Data Kebutuhan Intervensi Penanggulangan Kemiskinan')

{{-- STYLE HALAMAN --}}
@push('styles')
{{-- STYLE CSS --}}
<style>
    @import url('https://fonts.bunny.net/css?family=inter:400,500,600,700,800,900&display=swap');

    /*
    |--------------------------------------------------------------------------
    | GLOBAL VARIABLE
    |--------------------------------------------------------------------------
    | Menyimpan font, warna, dan nilai dasar agar styling mudah dikelola.
    |--------------------------------------------------------------------------
    */

    :root {
        --public-font-main: 'Inter', ui-sans-serif, system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", sans-serif;
        --primary-blue: #1565C0;
        --primary-blue-dark: #0f4fa0;
        --primary-blue-soft: #E3F2FD;
        --text-dark: #111827;
        --text-main: #212529;
        --text-muted: #6C757D;
        --border-soft: #DEE2E6;
        --border-blue-soft: #C9D8EC;
        --bg-soft: #F8FAFC;
    }

    /*
    |--------------------------------------------------------------------------
    | GLOBAL FONT
    |--------------------------------------------------------------------------
    | Menerapkan font utama pada seluruh elemen halaman publik.
    |--------------------------------------------------------------------------
    */

    body,
    input,
    button,
    select,
    textarea,
    table,
    th,
    td,
    a,
    span,
    p,
    div,
    label,
    h1,
    h2,
    h3,
    h4,
    h5,
    h6 {
        font-family: var(--public-font-main) !important;
        -webkit-font-smoothing: antialiased;
        -moz-osx-font-smoothing: grayscale;
        text-rendering: geometricPrecision;
    }

    /*
    |--------------------------------------------------------------------------
    | ANIMASI HALAMAN
    |--------------------------------------------------------------------------
    | Menyediakan animasi dasar untuk elemen, footer, dan transisi konten.
    |--------------------------------------------------------------------------
    */

    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(20px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    @keyframes fadeInScale {
        from {
            opacity: 0;
            transform: scale(0.82) translateY(16px);
        }

        to {
            opacity: 1;
            transform: scale(1) translateY(0);
        }
    }

    @keyframes slideInBottom {
        from {
            opacity: 0;
            transform: translateY(36px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .footer-logo-item,
    .footer-bottom-inner {
        opacity: 0;
    }

    /*
    |--------------------------------------------------------------------------
    | PAGE HEADER
    |--------------------------------------------------------------------------
    | Mengatur judul utama dan sumber data pada halaman DT Jateng.
    |--------------------------------------------------------------------------
    */

    .dt-header {
        text-align: center;
        padding: 40px 20px 28px;
        background: #ffffff;
        animation: fadeInUp 0.5s ease both;
    }

    .dt-header h1 {
        font-size: 27px;
        font-weight: 800 !important;
        color: var(--text-dark);
        margin: 0 0 8px;
        letter-spacing: -0.045em !important;
        line-height: 1.25 !important;
    }

    .dt-header .dt-subtitle {
        font-size: 14px;
        color: var(--text-muted);
        margin-top: 8px;
        font-weight: 500 !important;
        letter-spacing: -0.015em !important;
        line-height: 1.5 !important;
    }

    /*
    |--------------------------------------------------------------------------
    | TABLE CARD
    |--------------------------------------------------------------------------
    | Mengatur container utama tabel data kebutuhan intervensi.
    |--------------------------------------------------------------------------
    */

    .table-card {
        background: #ffffff;
        border: 1px solid var(--border-soft);
        border-radius: 16px;
        overflow: hidden;
        margin-bottom: 28px;
        animation: fadeInUp 0.5s ease 0.1s both;
        box-shadow: 0 16px 38px rgba(15, 23, 42, 0.06);
    }

    /*
    |--------------------------------------------------------------------------
    | TABLE HEADER
    |--------------------------------------------------------------------------
    | Mengatur judul tabel dan input pencarian pada bagian atas tabel.
    |--------------------------------------------------------------------------
    */

    .table-card-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 16px 20px;
        border-bottom: 1px solid var(--border-soft);
        flex-wrap: wrap;
        gap: 12px;
        background: #ffffff;
    }

    .table-card-header .tbl-title {
        font-size: 16px;
        font-weight: 760 !important;
        color: var(--text-main);
        letter-spacing: -0.025em !important;
        line-height: 1.3 !important;
    }

    .search-wrap {
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .search-wrap label {
        font-size: 13px;
        color: var(--text-muted);
        white-space: nowrap;
        font-weight: 500 !important;
        letter-spacing: -0.012em !important;
    }

    /*
    |--------------------------------------------------------------------------
    | SEARCH INPUT
    |--------------------------------------------------------------------------
    | Mengatur tampilan input pencarian data kabupaten.
    |--------------------------------------------------------------------------
    */

    .search-input {
        border: 1px solid var(--border-blue-soft);
        border-radius: 9px;
        padding: 8px 12px 8px 34px;
        font-size: 13px;
        color: var(--text-main);
        font-weight: 500 !important;
        letter-spacing: -0.012em !important;
        background: var(--bg-soft) url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='14' height='14' viewBox='0 0 24 24' fill='none' stroke='%231565C0' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'%3E%3Ccircle cx='11' cy='11' r='8'/%3E%3Cpath d='m21 21-4.35-4.35'/%3E%3C/svg%3E") no-repeat 11px center;
        width: 220px;
        transition: border-color 0.2s ease, box-shadow 0.2s ease, background 0.2s ease;
    }

    .search-input:focus {
        outline: none;
        border-color: var(--primary-blue);
        background-color: #ffffff;
        box-shadow: 0 0 0 4px rgba(21, 101, 192, 0.10);
    }

    /*
    |--------------------------------------------------------------------------
    | TABLE SCROLL
    |--------------------------------------------------------------------------
    | Mengatur area scroll horizontal agar tabel tetap responsif.
    |--------------------------------------------------------------------------
    */

    .table-responsive-x {
        width: 100%;
        overflow-x: auto;
        overflow-y: hidden;
        scrollbar-width: thin;
        scrollbar-color: var(--primary-blue) #e5eaf1;
    }

    .table-responsive-x::-webkit-scrollbar {
        height: 12px;
    }

    .table-responsive-x::-webkit-scrollbar-track {
        background: #e5eaf1;
        border-radius: 999px;
    }

    .table-responsive-x::-webkit-scrollbar-thumb {
        background: var(--primary-blue);
        border-radius: 999px;
        border: 3px solid #e5eaf1;
    }

    /*
    |--------------------------------------------------------------------------
    | TABLE DATA
    |--------------------------------------------------------------------------
    | Mengatur tabel DT Jateng mulai dari header, baris, hingga kolom angka.
    |--------------------------------------------------------------------------
    */

    .dt-table {
        width: 100%;
        min-width: 1080px;
        border-collapse: collapse;
        font-size: 13px;
    }

    .dt-table thead tr {
        background: var(--primary-blue);
        color: #ffffff;
    }

    .dt-table thead th {
        padding: 12px 14px;
        font-weight: 760 !important;
        font-size: 12.5px;
        white-space: nowrap;
        border: none;
        vertical-align: middle;
        text-align: center;
        letter-spacing: -0.01em !important;
        line-height: 1.25 !important;
    }

    .th-sort-wrapper {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 4px;
        font-weight: 760 !important;
        letter-spacing: -0.01em !important;
    }

    .dt-table tbody tr {
        border-bottom: 1px solid #F1F3F5;
        transition: background 0.15s ease;
    }

    .dt-table tbody tr:hover {
        background: #F0F7FF;
    }

    .dt-table tbody td {
        padding: 11px 14px;
        color: var(--text-main);
        vertical-align: middle;
        font-size: 13px;
        font-weight: 500 !important;
        letter-spacing: -0.015em !important;
        line-height: 1.45 !important;
    }

    .dt-table tbody td.td-no {
        color: var(--text-muted);
        text-align: center;
        font-weight: 500 !important;
    }

    .dt-table tbody td.td-kabupaten {
        text-align: left;
        text-transform: uppercase;
        font-weight: 520 !important;
        letter-spacing: -0.012em !important;
        color: #343a40;
    }

    .dt-table tbody td.td-num {
        text-align: right;
        font-variant-numeric: tabular-nums;
        font-weight: 500 !important;
    }

    /*
    |--------------------------------------------------------------------------
    | PAGINATION
    |--------------------------------------------------------------------------
    | Mengatur informasi jumlah data dan tombol navigasi halaman.
    |--------------------------------------------------------------------------
    */

    .pagination-wrap {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 13px 20px;
        border-top: 1px solid var(--border-soft);
        flex-wrap: wrap;
        gap: 10px;
        background: #ffffff;
    }

    .pagination-info {
        font-size: 12.5px;
        color: var(--text-muted);
        font-weight: 500 !important;
        letter-spacing: -0.012em !important;
    }

    .pagination-btns {
        display: flex;
        align-items: center;
        gap: 5px;
        flex-wrap: wrap;
    }

    .page-btn {
        background: var(--bg-soft);
        border: 1px solid var(--border-soft);
        border-radius: 8px;
        padding: 6px 11px;
        font-size: 12.5px;
        color: var(--text-main);
        cursor: pointer;
        transition: background 0.15s ease, color 0.15s ease, border-color 0.15s ease, transform 0.15s ease;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        font-weight: 600 !important;
        letter-spacing: -0.012em !important;
        line-height: 1.2 !important;
    }

    .page-btn:hover {
        background: var(--primary-blue-soft);
        color: var(--primary-blue);
        border-color: #90CAF9;
        transform: translateY(-1px);
    }

    .page-btn.active {
        background: var(--primary-blue);
        color: #ffffff;
        border-color: var(--primary-blue);
        box-shadow: 0 8px 18px rgba(21, 101, 192, 0.20);
    }

    .page-btn.disabled {
        opacity: 0.45;
        pointer-events: none;
    }

    /*
    |--------------------------------------------------------------------------
    | KETERANGAN DATA
    |--------------------------------------------------------------------------
    | Mengatur bagian keterangan singkat terkait istilah KRT dan ART.
    |--------------------------------------------------------------------------
    */

    .keterangan-section {
        margin-top: 24px;
        margin-bottom: 24px;
        font-size: 13.5px;
        line-height: 1.8;
        animation: fadeInUp 0.5s ease 0.2s both;
    }

    .keterangan-section strong {
        display: block;
        color: var(--text-dark);
        margin-bottom: 4px;
        font-weight: 700 !important;
        letter-spacing: -0.018em !important;
        line-height: 1.55 !important;
    }

    /*
    |--------------------------------------------------------------------------
    | BUTTON PERMOHONAN DATA
    |--------------------------------------------------------------------------
    | Mengatur tombol untuk akses atau pengajuan permohonan data.
    |--------------------------------------------------------------------------
    */

    .btn-permohonan {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        background-color: #03A9F4;
        color: #ffffff;
        text-transform: uppercase;
        font-weight: 700 !important;
        font-size: 12px;
        padding: 9px 16px;
        border-radius: 8px;
        text-decoration: none;
        margin-bottom: 16px;
        border: none;
        cursor: pointer;
        transition: background 0.2s ease, transform 0.2s ease, box-shadow 0.2s ease;
        animation: fadeInUp 0.5s ease 0.3s both;
        letter-spacing: -0.01em !important;
        line-height: 1.2 !important;
        box-shadow: 0 10px 20px rgba(3, 169, 244, 0.18);
    }

    .btn-permohonan:hover {
        background-color: #0288D1;
        color: #ffffff;
        transform: translateY(-2px);
        box-shadow: 0 14px 26px rgba(3, 169, 244, 0.24);
    }

    /*
    |--------------------------------------------------------------------------
    | SYARAT PERMOHONAN DATA
    |--------------------------------------------------------------------------
    | Mengatur teks persyaratan akses data kebutuhan intervensi.
    |--------------------------------------------------------------------------
    */

    .syarat-info {
        font-size: 13.5px;
        font-weight: 600 !important;
        line-height: 1.75 !important;
        color: var(--text-main);
        animation: fadeInUp 0.5s ease 0.4s both;
        letter-spacing: -0.015em !important;
    }

    .syarat-list {
        margin-top: 6px;
        padding-left: 0;
        list-style: none;
        font-size: 13.5px;
        font-weight: 500 !important;
        line-height: 1.75 !important;
        color: var(--text-main);
        letter-spacing: -0.015em !important;
    }

    .syarat-list li {
        margin-bottom: 4px;
    }

    hr {
        border: none;
        border-top: 1px solid var(--border-blue-soft);
        margin: 24px 0;
        animation: fadeInUp 0.5s ease 0.25s both;
    }

    /*
    |--------------------------------------------------------------------------
    | RESPONSIVE MOBILE
    |--------------------------------------------------------------------------
    | Menyesuaikan header, pencarian, dan pagination pada layar kecil.
    |--------------------------------------------------------------------------
    */

    @media (max-width: 768px) {
        .dt-header {
            padding: 32px 16px 22px;
        }

        .dt-header h1 {
            font-size: 22px;
        }

        .table-card-header {
            align-items: flex-start;
            flex-direction: column;
        }

        .search-wrap {
            width: 100%;
            align-items: flex-start;
            flex-direction: column;
        }

        .search-input {
            width: 100%;
        }

        .pagination-wrap {
            align-items: flex-start;
            flex-direction: column;
        }
    }
</style>
@endpush

{{-- KONTEN HALAMAN --}}
@section('content')

{{--
|--------------------------------------------------------------------------
| PAGE HEADER
|--------------------------------------------------------------------------
| Menampilkan judul halaman dan sumber data DT Jateng.
|--------------------------------------------------------------------------
--}}
<div class="dt-header">
    <h1>Data Kebutuhan Intervensi Penanggulangan Kemiskinan</h1>
    <h1>Jawa Tengah</h1>
    <div class="dt-subtitle">Sumber: Penetapan DT Jateng 10 April 2023</div>
</div>

<div class="container pb-5">

    {{--
    |--------------------------------------------------------------------------
    | TABLE WRAPPER
    |--------------------------------------------------------------------------
    | Container utama untuk tabel data kebutuhan intervensi kabupaten.
    |--------------------------------------------------------------------------
    --}}
    <div class="table-card">
        <div class="table-card-header">
            <span class="tbl-title">Data Kabupaten</span>

            <div class="search-wrap">
                <label for="search">Search:</label>

                <input
                    type="text"
                    id="search"
                    class="search-input"
                    placeholder=""
                    value="{{ $search }}"
                >
            </div>
        </div>

        {{--
        |--------------------------------------------------------------------------
        | TABEL DT JATENG
        |--------------------------------------------------------------------------
        | Menampilkan data kebutuhan intervensi penanggulangan kemiskinan.
        |--------------------------------------------------------------------------
        --}}
        <div class="table-responsive-x">
            {{-- TABEL DATA --}}
<table class="dt-table">
                <thead>
                    <tr>
                        <th>No</th>

                        <th style="text-align: left;">
                            <div class="th-sort-wrapper" style="justify-content: flex-start;">
                                Kabupaten
                                <i class="fas fa-sort" style="opacity: 0.5; font-size:10px;"></i>
                            </div>
                        </th>

                        <th>
                            <div class="th-sort-wrapper">
                                RTLH
                                <i class="fas fa-sort" style="opacity: 0.5; font-size:10px;"></i>
                            </div>
                        </th>

                        <th>
                            <div class="th-sort-wrapper">
                                RTLH P1
                                <i class="fas fa-sort" style="opacity: 0.5; font-size:10px;"></i>
                            </div>
                        </th>

                        <th>
                            <div class="th-sort-wrapper">
                                RTLH P2
                                <i class="fas fa-sort" style="opacity: 0.5; font-size:10px;"></i>
                            </div>
                        </th>

                        <th>
                            <div class="th-sort-wrapper">
                                Listrik
                                <i class="fas fa-sort" style="opacity: 0.5; font-size:10px;"></i>
                            </div>
                        </th>

                        <th>
                            <div class="th-sort-wrapper">
                                Air
                                <i class="fas fa-sort" style="opacity: 0.5; font-size:10px;"></i>
                            </div>
                        </th>

                        <th>
                            <div class="th-sort-wrapper">
                                Jamban
                                <i class="fas fa-sort" style="opacity: 0.5; font-size:10px;"></i>
                            </div>
                        </th>

                        <th>
                            <div class="th-sort-wrapper">
                                ATS
                                <i class="fas fa-sort" style="opacity: 0.5; font-size:10px;"></i>
                            </div>
                        </th>

                        <th>
                            <div class="th-sort-wrapper" style="font-size:11px; white-space:normal; line-height:1.2; text-align:center;">
                                Tidak<br>Bekerja
                                <i class="fas fa-sort" style="opacity: 0.5; font-size:10px;"></i>
                            </div>
                        </th>

                        <th>
                            <div class="th-sort-wrapper">
                                % ART
                                <i class="fas fa-sort" style="opacity: 0.5; font-size:10px;"></i>
                            </div>
                        </th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($dtJateng as $i => $row)
                        <tr>
                            <td class="td-no">
                                {{ $dtJateng->firstItem() + $i }}
                            </td>

                            <td class="td-kabupaten">
                                {{ str_replace(['Kabupaten ', 'Kota '], '', $row->kabupaten->nama ?? '-') }}
                            </td>

                            <td class="td-num">
                                {{ number_format($row->rtlh, 0, ',', ',') }}
                            </td>

                            <td class="td-num">
                                {{ number_format($row->rtlh_p1, 0, ',', ',') }}
                            </td>

                            <td class="td-num">
                                {{ number_format($row->rtlh_p2, 0, ',', ',') }}
                            </td>

                            <td class="td-num">
                                {{ number_format($row->listrik, 0, ',', ',') }}
                            </td>

                            <td class="td-num">
                                {{ number_format($row->air, 0, ',', ',') }}
                            </td>

                            <td class="td-num">
                                {{ number_format($row->jamban, 0, ',', ',') }}
                            </td>

                            <td class="td-num">
                                {{ number_format($row->ats, 0, ',', ',') }}
                            </td>

                            <td class="td-num">
                                {{ number_format($row->tidak_bekerja, 0, ',', ',') }}
                            </td>

                            <td class="td-num">
                                {{ number_format((float)$row->pct_art, 2, ',', '.') }}%
                            </td>
                        </tr>
                    @empty
                        {{--
                        |--------------------------------------------------------------------------
                        | DATA KOSONG
                        |--------------------------------------------------------------------------
                        | Menampilkan pesan jika data DT Jateng tidak tersedia.
                        |--------------------------------------------------------------------------
                        --}}
                        <tr>
                            <td colspan="11" class="text-center py-4 text-muted">
                                Tidak ada data
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{--
        |--------------------------------------------------------------------------
        | PAGINATION DATA
        |--------------------------------------------------------------------------
        | Menampilkan informasi jumlah data dan tombol navigasi halaman.
        |--------------------------------------------------------------------------
        --}}
        <div class="pagination-wrap">
            <div class="pagination-info">
                @php
                    $from = $dtJateng->total() > 0 ? $dtJateng->firstItem() : 0;
                    $to = $dtJateng->total() > 0 ? $dtJateng->lastItem() : 0;
                    $total = $dtJateng->total();
                @endphp

                Showing {{ $from }} to {{ $to }} of {{ $total }} entries
            </div>

            {{-- KONDISI TAMPILAN --}}
@if($dtJateng->hasPages())
                <div class="pagination-btns">
                    <a
                        href="{{ $dtJateng->previousPageUrl() }}"
                        class="page-btn {{ $dtJateng->onFirstPage() ? 'disabled' : '' }}"
                    >
                        Previous
                    </a>

                    @if($dtJateng->lastPage() <= 5)
                        @for($p = 1; $p <= $dtJateng->lastPage(); $p++)
                            <a
                                href="{{ $dtJateng->url($p) }}"
                                class="page-btn {{ $dtJateng->currentPage() == $p ? 'active' : '' }}"
                            >
                                {{ $p }}
                            </a>
                        @endfor
                    @else
                        @php
                            $start = max(1, $dtJateng->currentPage() - 1);
                            $end = min($dtJateng->lastPage(), $dtJateng->currentPage() + 1);
                        @endphp

                        @if($start > 1)
                            <a href="{{ $dtJateng->url(1) }}" class="page-btn">1</a>

                            @if($start > 2)
                                <span style="color:#6C757D">...</span>
                            @endif
                        @endif

                        @for($p = $start; $p <= $end; $p++)
                            <a
                                href="{{ $dtJateng->url($p) }}"
                                class="page-btn {{ $dtJateng->currentPage() == $p ? 'active' : '' }}"
                            >
                                {{ $p }}
                            </a>
                        @endfor

                        @if($end < $dtJateng->lastPage())
                            @if($end < $dtJateng->lastPage() - 1)
                                <span style="color:#6C757D">...</span>
                            @endif

                            <a href="{{ $dtJateng->url($dtJateng->lastPage()) }}" class="page-btn">
                                {{ $dtJateng->lastPage() }}
                            </a>
                        @endif
                    @endif

                    <a
                        href="{{ $dtJateng->nextPageUrl() }}"
                        class="page-btn {{ !$dtJateng->hasMorePages() ? 'disabled' : '' }}"
                    >
                        Next
                    </a>
                </div>
            @else
                <div class="pagination-btns">
                    <a href="#" class="page-btn disabled">Previous</a>
                    <a href="#" class="page-btn active">1</a>
                    <a href="#" class="page-btn disabled">Next</a>
                </div>
            @endif
        </div>
    </div>

    {{--
    |--------------------------------------------------------------------------
    | KETERANGAN DATA
    |--------------------------------------------------------------------------
    | Menjelaskan singkatan yang digunakan pada data kebutuhan intervensi.
    |--------------------------------------------------------------------------
    --}}
    <div class="keterangan-section">
        <strong>Keterangan:</strong>
        <strong>KRT = Kepala Rumah Tangga</strong>
        <strong>ART = Anggota Rumah Tangga</strong>
    </div>

    <hr>

    {{--
    |--------------------------------------------------------------------------
    | PERMOHONAN DATA
    |--------------------------------------------------------------------------
    | hilangkan comment jika ingin dipakai
    |--------------------------------------------------------------------------
    
    <a href="#" class="btn-permohonan">PERMOHONAN DATA</a>

    <div class="syarat-info">
        Untuk kebutuhan intervensi data dapat diakses dengan syarat dan ketentuan sebagai berikut :

        <ol class="syarat-list">
            <li>1. Mengajukan permohonan kepada Kepala Dinas Sosial Prov Jateng</li>
            <li>2. Melampirkan profil lembaga/organisasi yang akan memberikan intervensi.</li>
            <li>3. Akan dilakukan verifikasi terkait permohonan data oleh dinas sosial</li>
            <li>4. Data akan diserahkan setelah seluruh persyaratan terpenuhi.</li>
        </ol>
    </div>
</div>
--}}

@endsection

{{-- SCRIPT HALAMAN --}}
@push('scripts')
{{-- SCRIPT JAVASCRIPT --}}
<script>
    /*
    |--------------------------------------------------------------------------
    | LIVE SEARCH
    |--------------------------------------------------------------------------
    | Menjalankan pencarian otomatis setelah pengguna berhenti mengetik.
    |--------------------------------------------------------------------------
    */

    let timer;

    const searchInput = document.getElementById('search');

    if (searchInput) {
        searchInput.addEventListener('input', function () {
            clearTimeout(timer);

            const val = this.value;

            timer = setTimeout(() => {
                const url = new URL(window.location.href);

                if (val) {
                    url.searchParams.set('search', val);
                } else {
                    url.searchParams.delete('search');
                }

                url.searchParams.delete('page');

                window.location.href = url.toString();
            }, 600);
        });
    }

    /*
    |--------------------------------------------------------------------------
    | OBSERVER ANIMASI SCROLL
    |--------------------------------------------------------------------------
    | Menampilkan animasi footer ketika elemen masuk ke area layar.
    |--------------------------------------------------------------------------
    */

    const opts = {
        threshold: 0.15,
        rootMargin: '0px 0px -30px 0px'
    };

    const scrollObs = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (!entry.isIntersecting) {
                return;
            }

            const el = entry.target;

            if (el.classList.contains('footer-logo-item')) {
                const delay = (el.dataset.logoIdx || 0) * 120;

                el.style.animation = `fadeInScale 0.5s ease ${delay}ms both`;
                el.style.opacity = '1';
            } else if (el.classList.contains('footer-bottom-inner')) {
                el.style.animation = 'slideInBottom 0.6s ease both';
                el.style.opacity = '1';
            }

            scrollObs.unobserve(el);
        });
    }, opts);

    /*
    |--------------------------------------------------------------------------
    | REGISTRASI ELEMEN FOOTER
    |--------------------------------------------------------------------------
    | Mendaftarkan elemen footer agar animasi berjalan saat discroll.
    |--------------------------------------------------------------------------
    */

    document.querySelectorAll('.footer-logo-item').forEach((el, i) => {
        el.dataset.logoIdx = i;
        scrollObs.observe(el);
    });

    const footerBottomInner = document.querySelector('.footer-bottom-inner');

    if (footerBottomInner) {
        scrollObs.observe(footerBottomInner);
    }
</script>
@endpush