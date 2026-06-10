{{-- HALAMAN PSKS --}}
{{-- LAYOUT YANG DIGUNAKAN --}}
@extends('layouts.app')

{{-- JUDUL HALAMAN --}}
@section('title', 'REKAP PSKS - DTSEN Jawa Tengah')

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
    | Mengatur judul utama halaman rekap PSKS.
    |--------------------------------------------------------------------------
    */

    .psks-header {
        text-align: center;
        padding: 40px 0 28px;
        background: #fff;
        animation: fadeInUp 0.5s ease both;
    }

    .psks-header h1 {
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
    | Mengatur container grafik rekap PSKS.
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
    | Mengatur container utama tabel rekap PSKS.
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
    | Mengatur kolom pencarian pada tabel rekap jenis PSKS.
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
        width: 200px;
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
    | Mengatur tampilan tabel rekap PSKS beserta header dan isi tabel.
    |--------------------------------------------------------------------------
    */

    .psks-table {
        width: 100%;
        border-collapse: collapse;
        font-size: 13px;
    }

    .psks-table thead tr {
        background: #1565C0;
        color: #fff;
    }

    .psks-table thead th {
        padding: 11px 14px;
        font-weight: 700;
        font-size: 13px;
        white-space: nowrap;
        border: none;
    }

    .psks-table thead th:first-child {
        width: 48px;
        text-align: center;
    }

    .psks-table tbody tr {
        border-bottom: 1px solid #F1F3F5;
        transition: background 0.15s;
    }

    .psks-table tbody tr:hover {
        background: #F0F7FF;
    }

    .psks-table tbody td {
        padding: 10px 14px;
        color: #212529;
        vertical-align: middle;
    }

    .psks-table tbody td.td-no {
        color: #6C757D;
        text-align: center;
    }

    .psks-table tbody td.td-num {
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
        display: inline-flex;
        align-items: center;
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

    .page-btn.disabled {
        opacity: 0.45;
        pointer-events: none;
    }

    /*
    |--------------------------------------------------------------------------
    | PER PAGE SELECT
    |--------------------------------------------------------------------------
    | Mengatur dropdown jumlah data yang ditampilkan.
    |--------------------------------------------------------------------------
    */

    .per-page-select {
        border: 1px solid #C9D8EC;
        border-radius: 7px;
        padding: 5px 10px;
        font-family: 'Plus Jakarta Sans', sans-serif;
        font-size: 12.5px;
        color: #212529;
        background: #f8f9fa;
        cursor: pointer;
    }

    .per-page-select:focus {
        outline: none;
        border-color: #1565C0;
    }
</style>
@endpush

{{-- KONTEN HALAMAN --}}
@section('content')

{{--
|--------------------------------------------------------------------------
| PAGE HEADER
|--------------------------------------------------------------------------
| Menampilkan judul utama halaman rekap PSKS.
|--------------------------------------------------------------------------
--}}
<div class="psks-header">
    <h1>REKAP PSKS</h1>
</div>

<div class="container pb-4">

    {{--
    |--------------------------------------------------------------------------
    | CHART REKAP PSKS
    |--------------------------------------------------------------------------
    | Menampilkan grafik perkembangan total PSKS berdasarkan tahun.
    |--------------------------------------------------------------------------
    --}}
    <div class="chart-card">
        <div class="chart-legend">
            <div class="chart-legend-dot"></div>
            PSKS
        </div>
        <canvas id="chartPsks" height="90"></canvas>
    </div>

    {{--
    |--------------------------------------------------------------------------
    | TABEL REKAP PER JENIS PSKS
    |--------------------------------------------------------------------------
    | Menampilkan total PSKS berdasarkan jenis kategori dan tahun.
    |--------------------------------------------------------------------------
    --}}
    <div class="table-card">
        <div class="table-card-header">
            <span class="tbl-title">Rekap PSKS Per Jenis</span>

            <div class="search-wrap">
                <label for="searchJenis">Search:</label>
                <input
                    type="text"
                    id="searchJenis"
                    class="search-input"
                    placeholder="Search..."
                    value="{{ $searchJenis }}"
                >
            </div>
        </div>

        <div style="overflow-x:auto;">
            {{-- TABEL DATA --}}
<table class="psks-table" id="tblJenis">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Jenis</th>

                        {{-- LOOPING DATA --}}
@foreach($tahunKolom as $thn)
                            <th>{{ $thn }}</th>
                        @endforeach
                    </tr>
                </thead>

                <tbody>
                    @forelse($rekapJenis as $i => $row)
                        <tr>
                            <td class="td-no">{{ ($page - 1) * $perPage + $i + 1 }}</td>
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
                        | Menampilkan pesan ketika data rekap jenis PSKS tidak tersedia.
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
        | PAGINATION DATA PSKS
        |--------------------------------------------------------------------------
        | Menampilkan informasi jumlah data dan navigasi halaman tabel PSKS.
        |--------------------------------------------------------------------------
        --}}
        <div class="pagination-wrap">
            <div style="display:flex;align-items:center;gap:8px;">
                <span class="pagination-info">
                    @php
                        $from = $total > 0 ? ($page - 1) * $perPage + 1 : 0;
                        $to = min($page * $perPage, $total);
                    @endphp

                    Showing {{ $from }} to {{ $to }} of {{ $total }} entries
                </span>
            </div>

            <div class="pagination-btns">
                @php
                    $totalPages = $total > 0 ? (int) ceil($total / $perPage) : 1;
                @endphp

                <a
                    href="{{ request()->fullUrlWithQuery(['page' => max(1, $page - 1)]) }}"
                    class="page-btn {{ $page <= 1 ? 'disabled' : '' }}"
                >
                    Previous
                </a>

                @for($p = 1; $p <= $totalPages; $p++)
                    <a
                        href="{{ request()->fullUrlWithQuery(['page' => $p]) }}"
                        class="page-btn {{ $p == $page ? 'active' : '' }}"
                    >
                        {{ $p }}
                    </a>
                @endfor

                <a
                    href="{{ request()->fullUrlWithQuery(['page' => min($totalPages, $page + 1)]) }}"
                    class="page-btn {{ $page >= $totalPages ? 'disabled' : '' }}"
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
    | CHART REKAP PSKS
    |--------------------------------------------------------------------------
    | Membuat grafik garis untuk menampilkan total PSKS per tahun.
    |--------------------------------------------------------------------------
    */

    const chartLabels = @json($chartData->pluck('tahun'));
    const chartValues = @json($chartData->pluck('total'));

    const ctx = document.getElementById('chartPsks').getContext('2d');

    const grad = ctx.createLinearGradient(0, 0, 0, 280);
    grad.addColorStop(0, 'rgba(21,101,192,0.25)');
    grad.addColorStop(1, 'rgba(21,101,192,0)');

    new Chart(ctx, {
        type: 'line',
        data: {
            labels: chartLabels,
            datasets: [{
                label: 'PSKS',
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
    | SEARCH JENIS PSKS
    |--------------------------------------------------------------------------
    | Menjalankan pencarian jenis PSKS secara otomatis dengan debounce.
    |--------------------------------------------------------------------------
    */

    let searchTimer;

    document.getElementById('searchJenis').addEventListener('input', function () {
        clearTimeout(searchTimer);

        const val = this.value;

        searchTimer = setTimeout(() => {
            const url = new URL(window.location.href);

            url.searchParams.set('search', val);
            url.searchParams.set('page', 1);

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