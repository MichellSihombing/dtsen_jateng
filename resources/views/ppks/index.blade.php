{{-- HALAMAN PPKS --}}
{{-- LAYOUT YANG DIGUNAKAN --}}
@extends('layouts.app')

{{-- JUDUL HALAMAN --}}
@section('title', 'REKAP PPKS - DTSEN Jawa Tengah')

{{-- STYLE HALAMAN --}}
@push('styles')
{{-- STYLE CSS --}}
<style>
    /*
    |--------------------------------------------------------------------------
    | ANIMASI HALAMAN
    |--------------------------------------------------------------------------
    | Menyediakan animasi dasar untuk header, chart, tabel, dan footer.
    |--------------------------------------------------------------------------
    */

    @keyframes fadeInUp {
        from { opacity: 0; transform: translateY(20px); }
        to   { opacity: 1; transform: translateY(0); }
    }

    @keyframes fadeInScale {
        from { opacity: 0; transform: scale(0.82) translateY(16px); }
        to   { opacity: 1; transform: scale(1) translateY(0); }
    }

    @keyframes slideInBottom {
        from { opacity: 0; transform: translateY(36px); }
        to   { opacity: 1; transform: translateY(0); }
    }

    .footer-logo-item,
    .footer-bottom-inner {
        opacity: 0;
    }

    /*
    |--------------------------------------------------------------------------
    | PAGE HEADER
    |--------------------------------------------------------------------------
    | Mengatur judul utama halaman rekap PPKS.
    |--------------------------------------------------------------------------
    */

    .ppks-header {
        text-align: center;
        padding: 40px 0 28px;
        background: #fff;
        animation: fadeInUp 0.5s ease both;
    }

    .ppks-header h1 {
        font-size: 28px;
        font-weight: 800;
        color: #111;
        margin: 0;
        letter-spacing: 0.5px;
    }

    /*
    |--------------------------------------------------------------------------
    | CHART CARD
    |--------------------------------------------------------------------------
    | Mengatur container grafik rekap PPKS.
    |--------------------------------------------------------------------------
    */

    .chart-card {
        background: #fff;
        border: 1px solid #DEE2E6;
        border-radius: 12px;
        padding: 20px 24px;
        margin-bottom: 28px;
        animation: fadeInUp 0.5s ease 0.1s both;
    }

    .chart-legend {
        display: flex;
        align-items: center;
        gap: 8px;
        font-size: 12px;
        font-weight: 600;
        color: #1565C0;
        margin-bottom: 12px;
    }

    .chart-legend-dot {
        width: 12px;
        height: 12px;
        background: #1565C0;
        border-radius: 2px;
        flex-shrink: 0;
    }

    /*
    |--------------------------------------------------------------------------
    | TABLE CARD
    |--------------------------------------------------------------------------
    | Mengatur container utama tabel rekap PPKS.
    |--------------------------------------------------------------------------
    */

    .table-card {
        background: #fff;
        border: 1px solid #DEE2E6;
        border-radius: 12px;
        overflow: hidden;
        margin-bottom: 28px;
        animation: fadeInUp 0.5s ease 0.2s both;
    }

    /*
    |--------------------------------------------------------------------------
    | TABLE HEADER
    |--------------------------------------------------------------------------
    | Mengatur judul tabel dan area pencarian data.
    |--------------------------------------------------------------------------
    */

    .table-card-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 14px 20px;
        border-bottom: 1px solid #DEE2E6;
        flex-wrap: wrap;
        gap: 10px;
    }

    .table-card-header .tbl-title {
        font-size: 14px;
        font-weight: 700;
        color: #212529;
    }

    /*
    |--------------------------------------------------------------------------
    | SEARCH INPUT
    |--------------------------------------------------------------------------
    | Mengatur kolom pencarian pada tabel kabupaten dan jenis PPKS.
    |--------------------------------------------------------------------------
    */

    .search-wrap {
        display: flex;
        align-items: center;
        gap: 6px;
    }

    .search-wrap label {
        font-size: 13px;
        color: #6C757D;
        white-space: nowrap;
    }

    .search-input {
        border: 1px solid #C9D8EC;
        border-radius: 7px;
        padding: 6px 12px 6px 32px;
        font-family: 'Plus Jakarta Sans', sans-serif;
        font-size: 13px;
        color: #212529;
        background: #f8f9fa url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='14' height='14' viewBox='0 0 24 24' fill='none' stroke='%231565C0' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'%3E%3Ccircle cx='11' cy='11' r='8'/%3E%3Cpath d='m21 21-4.35-4.35'/%3E%3C/svg%3E") no-repeat 10px center;
        width: 180px;
        transition: border-color 0.2s, box-shadow 0.2s;
    }

    .search-input:focus {
        outline: none;
        border-color: #1565C0;
        box-shadow: 0 0 0 3px rgba(21,101,192,0.10);
    }

    /*
    |--------------------------------------------------------------------------
    | TABLE DATA
    |--------------------------------------------------------------------------
    | Mengatur tampilan tabel rekap PPKS beserta header dan isi tabel.
    |--------------------------------------------------------------------------
    */

    .ppks-table {
        width: 100%;
        border-collapse: collapse;
        font-size: 13px;
    }

    .ppks-table thead tr {
        background: #1565C0;
        color: #fff;
    }

    .ppks-table thead th {
        padding: 11px 14px;
        font-weight: 700;
        font-size: 13px;
        white-space: nowrap;
        border: none;
    }

    .ppks-table thead th.sortable {
        cursor: pointer;
        user-select: none;
    }

    .ppks-table thead th.sortable:hover {
        background: #0D47A1;
    }

    .ppks-table tbody tr {
        border-bottom: 1px solid #F1F3F5;
        transition: background 0.15s;
    }

    .ppks-table tbody tr:hover {
        background: #F0F7FF;
    }

    .ppks-table tbody td {
        padding: 10px 14px;
        color: #212529;
        vertical-align: middle;
    }

    .ppks-table tbody td.td-no {
        color: #6C757D;
        width: 40px;
        text-align: center;
    }

    .ppks-table tbody td.td-num {
        text-align: right;
        font-variant-numeric: tabular-nums;
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
        padding: 12px 20px;
        border-top: 1px solid #DEE2E6;
        flex-wrap: wrap;
        gap: 8px;
    }

    .pagination-info {
        font-size: 12.5px;
        color: #6C757D;
    }

    .pagination-btns {
        display: flex;
        align-items: center;
        gap: 4px;
    }

    .pagination-btns span {
        font-size: 12.5px;
        color: #6C757D;
        margin: 0 6px;
    }

    .page-btn {
        background: #f8f9fa;
        border: 1px solid #DEE2E6;
        border-radius: 6px;
        padding: 4px 10px;
        font-family: 'Plus Jakarta Sans', sans-serif;
        font-size: 12.5px;
        color: #212529;
        cursor: pointer;
        transition: background 0.15s, color 0.15s;
        text-decoration: none;
    }

    .page-btn:hover {
        background: #E3F2FD;
        color: #1565C0;
        border-color: #90CAF9;
    }

    .page-btn.active {
        background: #1565C0;
        color: #fff;
        border-color: #1565C0;
    }

    .page-btn:disabled,
    .page-btn.disabled {
        opacity: 0.45;
        pointer-events: none;
    }
</style>
@endpush

{{-- KONTEN HALAMAN --}}
@section('content')

{{--
|--------------------------------------------------------------------------
| PAGE HEADER
|--------------------------------------------------------------------------
| Menampilkan judul utama halaman rekap PPKS.
|--------------------------------------------------------------------------
--}}
<div class="ppks-header">
    <h1>REKAP PPKS</h1>
</div>

<div class="container pb-4">

    {{--
    |--------------------------------------------------------------------------
    | CHART REKAP PPKS
    |--------------------------------------------------------------------------
    | Menampilkan grafik perkembangan total PPKS berdasarkan tahun.
    |--------------------------------------------------------------------------
    --}}
    <div class="chart-card">
        <div class="chart-legend">
            <div class="chart-legend-dot"></div>
            PPKS
        </div>

        <canvas id="chartPpks" height="90"></canvas>
    </div>

    {{--
    |--------------------------------------------------------------------------
    | TABEL REKAP PER KABUPATEN/KOTA
    |--------------------------------------------------------------------------
    | Menampilkan total PPKS berdasarkan kabupaten/kota dan tahun.
    |--------------------------------------------------------------------------
    --}}
    <div class="table-card">
        <div class="table-card-header">
            <span class="tbl-title">Rekap PPKS Per Kabupaten/Kota</span>

            <div class="search-wrap">
                <label>Search:</label>
                <input
                    type="text"
                    id="searchKab"
                    class="search-input"
                    placeholder="Cari kabupaten..."
                    value="{{ $searchKab }}"
                >
            </div>
        </div>

        <div style="overflow-x:auto;">
            {{-- TABEL DATA --}}
            <table class="ppks-table" id="tblKab">
                <thead>
                    <tr>
                        <th>No.</th>
                        <th class="sortable" data-col="nama">Kabupaten/Kota ↕</th>

                        {{-- LOOPING DATA TAHUN --}}
                        @foreach($tahunKolom as $thn)
                            <th class="sortable" data-col="{{ $thn }}">{{ $thn }} ↕</th>
                        @endforeach
                    </tr>
                </thead>

                <tbody id="bodyKab">
                    @forelse($rekapKab as $i => $row)
                        <tr>
                            <td class="td-no">{{ ($pageKab - 1) * $perPage + $i + 1 }}</td>
                            <td>{{ $row['nama'] }}</td>

                            @foreach($tahunKolom as $thn)
                                <td class="td-num">{{ number_format($row['data'][$thn] ?? 0) }}</td>
                            @endforeach
                        </tr>
                    @empty
                        {{--
                        |--------------------------------------------------------------------------
                        | DATA KABUPATEN KOSONG
                        |--------------------------------------------------------------------------
                        | Menampilkan pesan ketika rekap per kabupaten/kota tidak tersedia.
                        |--------------------------------------------------------------------------
                        --}}
                        <tr>
                            <td colspan="{{ count($tahunKolom) + 2 }}" class="text-center py-4 text-muted">
                                Tidak ada data
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{--
        |--------------------------------------------------------------------------
        | PAGINATION KABUPATEN
        |--------------------------------------------------------------------------
        | Menampilkan navigasi halaman untuk tabel rekap kabupaten/kota.
        |--------------------------------------------------------------------------
        --}}
        <div class="pagination-wrap">
            <div style="display:flex;align-items:center;gap:8px;">
                <span class="pagination-info">
                    Menampilkan {{ ($pageKab - 1) * $perPage + 1 }} –
                    {{ min($pageKab * $perPage, $totalKab) }} dari {{ $totalKab }} data
                </span>
            </div>

            <div class="pagination-btns">
                @php
                    $totalPagesKab = ceil($totalKab / $perPage);
                @endphp

                <a
                    href="{{ request()->fullUrlWithQuery(['page_kab' => max(1, $pageKab - 1)]) }}"
                    class="page-btn {{ $pageKab <= 1 ? 'disabled' : '' }}"
                >
                    Previous
                </a>

                @for($p = 1; $p <= $totalPagesKab; $p++)
                    <a
                        href="{{ request()->fullUrlWithQuery(['page_kab' => $p]) }}"
                        class="page-btn {{ $p == $pageKab ? 'active' : '' }}"
                    >
                        {{ $p }}
                    </a>
                @endfor

                <a
                    href="{{ request()->fullUrlWithQuery(['page_kab' => min($totalPagesKab, $pageKab + 1)]) }}"
                    class="page-btn {{ $pageKab >= $totalPagesKab ? 'disabled' : '' }}"
                >
                    Next
                </a>
            </div>
        </div>
    </div>

    {{--
    |--------------------------------------------------------------------------
    | TABEL REKAP PER JENIS PPKS
    |--------------------------------------------------------------------------
    | Menampilkan total PPKS berdasarkan jenis kategori dan tahun.
    |--------------------------------------------------------------------------
    --}}
    <div class="table-card">
        <div class="table-card-header">
            <span class="tbl-title">Rekap PPKS Per Jenis</span>

            <div class="search-wrap">
                <label>Search:</label>
                <input
                    type="text"
                    id="searchJenis"
                    class="search-input"
                    placeholder="Cari jenis PPKS..."
                    value="{{ $searchJenis }}"
                >
            </div>
        </div>

        <div style="overflow-x:auto;">
            <table class="ppks-table" id="tblJenis">
                <thead>
                    <tr>
                        <th>No.</th>
                        <th>Jenis</th>

                        @foreach($tahunKolom as $thn)
                            <th>{{ $thn }}</th>
                        @endforeach
                    </tr>
                </thead>

                <tbody id="bodyJenis">
                    @forelse($rekapJenis as $i => $row)
                        <tr>
                            <td class="td-no">{{ ($pageJenis - 1) * $perPageJenis + $i + 1 }}</td>
                            <td>{{ $row['nama'] }}</td>

                            @foreach($tahunKolom as $thn)
                                <td class="td-num">{{ number_format($row['data'][$thn] ?? 0) }}</td>
                            @endforeach
                        </tr>
                    @empty
                        {{--
                        |--------------------------------------------------------------------------
                        | DATA JENIS KOSONG
                        |--------------------------------------------------------------------------
                        | Menampilkan pesan ketika rekap per jenis PPKS tidak tersedia.
                        |--------------------------------------------------------------------------
                        --}}
                        <tr>
                            <td colspan="{{ count($tahunKolom) + 2 }}" class="text-center py-4 text-muted">
                                Tidak ada data
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{--
        |--------------------------------------------------------------------------
        | PAGINATION JENIS
        |--------------------------------------------------------------------------
        | Menampilkan jumlah data dan navigasi tabel jenis PPKS.
        |--------------------------------------------------------------------------
        --}}
        <div class="pagination-wrap">
            <div style="display:flex;align-items:center;gap:8px;">
                <span class="pagination-info">
                    Menampilkan {{ ($pageJenis - 1) * $perPageJenis + 1 }} –
                    {{ min($pageJenis * $perPageJenis, $totalJenis) }} dari {{ $totalJenis }} data
                </span>
            </div>

            <div class="pagination-btns">
                @php
                    $totalPagesJenis = ceil($totalJenis / $perPageJenis);
                @endphp

                <a
                    href="{{ request()->fullUrlWithQuery(['page_jenis' => max(1, $pageJenis - 1)]) }}"
                    class="page-btn {{ $pageJenis <= 1 ? 'disabled' : '' }}"
                >
                    Previous
                </a>

                @for($p = 1; $p <= $totalPagesJenis; $p++)
                    <a
                        href="{{ request()->fullUrlWithQuery(['page_jenis' => $p]) }}"
                        class="page-btn {{ $p == $pageJenis ? 'active' : '' }}"
                    >
                        {{ $p }}
                    </a>
                @endfor

                <a
                    href="{{ request()->fullUrlWithQuery(['page_jenis' => min($totalPagesJenis, $pageJenis + 1)]) }}"
                    class="page-btn {{ $pageJenis >= $totalPagesJenis ? 'disabled' : '' }}"
                >
                    Next
                </a>
            </div>
        </div>
    </div>

</div>
@endsection

{{-- SCRIPT HALAMAN --}}
@push('scripts')
{{-- SCRIPT JAVASCRIPT --}}
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.2/dist/chart.umd.min.js"></script>

<script>
    /*
    |--------------------------------------------------------------------------
    | CHART REKAP PPKS
    |--------------------------------------------------------------------------
    | Membuat grafik garis untuk menampilkan total PPKS per tahun.
    |--------------------------------------------------------------------------
    */

    const chartLabels = @json($chartData->pluck('tahun'));
    const chartValues = @json($chartData->pluck('total'));

    const ctx = document.getElementById('chartPpks').getContext('2d');

    const grad = ctx.createLinearGradient(0, 0, 0, 280);
    grad.addColorStop(0, 'rgba(21,101,192,0.25)');
    grad.addColorStop(1, 'rgba(21,101,192,0)');

    new Chart(ctx, {
        type: 'line',
        data: {
            labels: chartLabels,
            datasets: [{
                label: 'PPKS',
                data: chartValues,
                borderColor: '#1565C0',
                borderWidth: 2,
                backgroundColor: grad,
                fill: true,
                tension: 0.4,
                pointRadius: 4,
                pointBackgroundColor: '#1565C0',
                pointBorderColor: '#fff',
                pointBorderWidth: 2,
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: { display: false },
                tooltip: {
                    callbacks: {
                        label: ctx => ' ' + ctx.parsed.y.toLocaleString('id-ID')
                    }
                }
            },
            scales: {
                y: {
                    beginAtZero: false,
                    grid: { color: '#F1F3F5' },
                    ticks: {
                        font: { family: 'Plus Jakarta Sans', size: 11 },
                        callback: v => v >= 1000 ? (v / 1000).toFixed(0) + 'K' : v
                    }
                },
                x: {
                    grid: { display: false },
                    ticks: {
                        font: { family: 'Plus Jakarta Sans', size: 11 }
                    }
                }
            }
        }
    });

    /*
    |--------------------------------------------------------------------------
    | SEARCH KABUPATEN
    |--------------------------------------------------------------------------
    | Menjalankan pencarian kabupaten/kota secara otomatis dengan debounce.
    |--------------------------------------------------------------------------
    */

    let timerKab;

    document.getElementById('searchKab').addEventListener('input', function () {
        clearTimeout(timerKab);

        const val = this.value;

        timerKab = setTimeout(() => {
            const url = new URL(window.location.href);

            url.searchParams.set('search_kab', val);
            url.searchParams.set('page_kab', 1);

            window.location.href = url.toString();
        }, 500);
    });

    /*
    |--------------------------------------------------------------------------
    | SEARCH JENIS PPKS
    |--------------------------------------------------------------------------
    | Menjalankan pencarian jenis PPKS secara otomatis dengan debounce.
    |--------------------------------------------------------------------------
    */

    let timerJenis;

    document.getElementById('searchJenis').addEventListener('input', function () {
        clearTimeout(timerJenis);

        const val = this.value;

        timerJenis = setTimeout(() => {
            const url = new URL(window.location.href);

            url.searchParams.set('search_jenis', val);
            url.searchParams.set('page_jenis', 1);

            window.location.href = url.toString();
        }, 500);
    });

    /*
    |--------------------------------------------------------------------------
    | OBSERVER ANIMASI SCROLL
    |--------------------------------------------------------------------------
    | Menjalankan animasi footer ketika elemen masuk ke area layar.
    |--------------------------------------------------------------------------
    */

    const opts = {
        threshold: 0.15,
        rootMargin: '0px 0px -30px 0px'
    };

    const scrollObs = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (!entry.isIntersecting) return;

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
    | Mendaftarkan elemen footer agar animasi scroll dapat dijalankan.
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