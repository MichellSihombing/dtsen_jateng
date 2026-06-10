@extends('admin.layouts.app')

@section('title', 'Kelola Daya Tampung Panti')
@section('breadcrumb', 'Daya Tampung Panti')

@section('content')
<style>
    @import url('https://fonts.bunny.net/css?family=inter:400,500,600,700,800,900&display=swap');

    /*
    |--------------------------------------------------------------------------
    | GLOBAL VARIABLE
    |--------------------------------------------------------------------------
    | Menyimpan font utama yang digunakan pada halaman admin Daya Tampung Panti.
    |--------------------------------------------------------------------------
    */

    :root {
        --admin-font-main: 'Inter', ui-sans-serif, system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", sans-serif;
    }

    /*
    |--------------------------------------------------------------------------
    | TABLE WRAPPER
    |--------------------------------------------------------------------------
    | Mengatur container tabel agar mendukung scroll horizontal saat kolom melebar.
    |--------------------------------------------------------------------------
    */

    .admin-table-wrap {
        width: 100%;
        overflow-x: auto;
        border-radius: 18px;
        border: 1px solid #e5eaf1;
        background: #ffffff;
    }

    /*
    |--------------------------------------------------------------------------
    | ADMIN TABLE
    |--------------------------------------------------------------------------
    | Mengatur struktur utama tabel data Daya Tampung Panti.
    |--------------------------------------------------------------------------
    */

    .admin-table {
        width: 100%;
        border-collapse: collapse;
        min-width: 900px;
    }

    .admin-table th {
        background: #f8fafc;
        color: #475569;
        font-size: 12px;
        font-weight: 900;
        text-transform: uppercase;
        letter-spacing: .3px;
        padding: 14px 16px;
        border-bottom: 1px solid #e5eaf1;
        text-align: left;
        white-space: nowrap;
    }

    .admin-table td {
        padding: 12px 16px;
        border-bottom: 1px solid #eef2f7;
        color: #0f172a;
        font-size: 13px;
        vertical-align: middle;
    }

    .admin-table tbody tr:hover td {
        background: #f8fafc;
    }

    /*
    |--------------------------------------------------------------------------
    | FORM INPUT
    |--------------------------------------------------------------------------
    | Mengatur tampilan input pada tabel, form tambah, dan form pencarian.
    |--------------------------------------------------------------------------
    */

    .admin-table input,
    .admin-table select,
    .admin-form-grid input,
    .admin-form-grid select,
    .admin-search-row input {
        width: 100%;
        height: 42px;
        border: 1px solid #dbe4ef;
        border-radius: 14px;
        padding: 0 13px;
        outline: none;
        font-size: 13px;
        background: #ffffff;
        transition: .22s ease;
    }

    .admin-table input:focus,
    .admin-table select:focus,
    .admin-form-grid input:focus,
    .admin-form-grid select:focus,
    .admin-search-row input:focus {
        border-color: #2563eb;
        box-shadow: 0 0 0 4px rgba(37, 99, 235, .09);
    }

    /*
    |--------------------------------------------------------------------------
    | FORM TAMBAH DATA
    |--------------------------------------------------------------------------
    | Mengatur layout form tambah data panti agar rapi dan proporsional.
    |--------------------------------------------------------------------------
    */

    .admin-form-grid {
        display: grid;
        grid-template-columns: 2fr 1fr 1fr 1fr auto;
        gap: 14px;
        align-items: end;
    }

    .admin-form-grid label {
        display: block;
        margin-bottom: 7px;
        color: #475569;
        font-size: 12px;
        font-weight: 850;
    }

    /*
    |--------------------------------------------------------------------------
    | BUTTON TAMBAH
    |--------------------------------------------------------------------------
    | Mengatur tombol submit untuk menambahkan data panti baru.
    |--------------------------------------------------------------------------
    */

    .admin-form-grid button {
        height: 42px;
        border: 0;
        border-radius: 14px;
        padding: 0 18px;
        background: linear-gradient(135deg, #2563eb, #0ea5e9);
        color: white;
        font-size: 13px;
        font-weight: 900;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        justify-content: center;
        transition: .22s ease;
    }

    .admin-form-grid button:hover {
        transform: translateY(-2px);
        box-shadow: 0 12px 24px rgba(37, 99, 235, .22);
    }

    /*
    |--------------------------------------------------------------------------
    | SEARCH ROW
    |--------------------------------------------------------------------------
    | Mengatur layout form pencarian data Daya Tampung Panti.
    |--------------------------------------------------------------------------
    */

    .admin-search-row {
        display: grid;
        grid-template-columns: 1fr auto auto;
        gap: 10px;
        align-items: center;
        margin: 18px 0 14px;
    }

    .admin-search-row button,
    .admin-search-row a {
        height: 42px;
        border-radius: 14px;
        border: none;
        padding: 0 18px;
        font-size: 13px;
        font-weight: 900;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        transition: .22s ease;
    }

    .admin-search-row button {
        background: linear-gradient(135deg, #2563eb, #0ea5e9);
        color: white;
        cursor: pointer;
    }

    .admin-search-row a {
        background: #eef2f7;
        color: #334155;
    }

    .admin-search-row button:hover,
    .admin-search-row a:hover {
        transform: translateY(-2px);
    }

    /*
    |--------------------------------------------------------------------------
    | ACTION WRAPPER
    |--------------------------------------------------------------------------
    | Mengatur posisi tombol aksi simpan dan hapus pada tabel.
    |--------------------------------------------------------------------------
    */

    .action-wrap {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
    }

    .action-btn {
        width: 42px;
        height: 42px;
        border: none;
        border-radius: 14px;
        cursor: pointer;
        transition: .22s ease;
    }

    /*
    |--------------------------------------------------------------------------
    | SAVE ACTION
    |--------------------------------------------------------------------------
    | Mengatur tombol untuk menyimpan perubahan data panti.
    |--------------------------------------------------------------------------
    */

    .action-save {
        background: #16a34a;
        color: white;
    }

    .action-save:hover {
        background: #15803d;
        transform: translateY(-2px);
        box-shadow: 0 12px 24px rgba(22, 163, 74, .24);
    }

    /*
    |--------------------------------------------------------------------------
    | DELETE ACTION
    |--------------------------------------------------------------------------
    | Mengatur tombol untuk menghapus data panti.
    |--------------------------------------------------------------------------
    */

    .action-delete {
        background: #fee2e2;
        color: #dc2626;
    }

    .action-delete:hover {
        background: #dc2626;
        color: white;
        transform: translateY(-2px);
        box-shadow: 0 12px 24px rgba(220, 38, 38, .22);
    }

    /*
    |--------------------------------------------------------------------------
    | CUSTOM PAGINATION
    |--------------------------------------------------------------------------
    | Mengatur container informasi data dan tombol navigasi halaman.
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
        gap: 7px;
        flex-wrap: wrap;
    }

    /*
    |--------------------------------------------------------------------------
    | PAGINATION BUTTON
    |--------------------------------------------------------------------------
    | Mengatur tombol halaman aktif, halaman biasa, dan tombol nonaktif.
    |--------------------------------------------------------------------------
    */

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
        font-weight: 850;
        transition: .2s ease;
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
        box-shadow: 0 10px 22px rgba(37, 99, 235, .22);
    }

    .page-link-disabled {
        background: #f8fafc;
        color: #cbd5e1;
        cursor: not-allowed;
    }

    /*
    |--------------------------------------------------------------------------
    | RESPONSIVE TABLET
    |--------------------------------------------------------------------------
    | Menyesuaikan form tambah data pada layar sedang.
    |--------------------------------------------------------------------------
    */

    @media (max-width: 1100px) {
        .admin-form-grid {
            grid-template-columns: 1fr 1fr;
        }
    }

    /*
    |--------------------------------------------------------------------------
    | RESPONSIVE MOBILE
    |--------------------------------------------------------------------------
    | Mengubah form tambah dan pencarian menjadi satu kolom pada layar kecil.
    |--------------------------------------------------------------------------
    */

    @media (max-width: 700px) {
        .admin-form-grid,
        .admin-search-row {
            grid-template-columns: 1fr;
        }
    }

    /*
    |--------------------------------------------------------------------------
    | MODERN FONT SYSTEM - INTER
    |--------------------------------------------------------------------------
    | Menyeragamkan font Inter agar tampilan halaman admin lebih modern dan bersih.
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
    | Mengatur ketebalan dan jarak huruf pada judul halaman dan card.
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
    | Mengatur teks deskripsi agar tetap nyaman dibaca.
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
    | Mengatur label input agar tampil tegas dan konsisten.
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
    | Mengatur teks pada input, select, textarea, dan komponen dropdown.
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
    | Mengatur teks tombol agar konsisten pada seluruh komponen admin.
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
    | Mengatur font header dan isi tabel agar lebih rapi.
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
    | Mengatur font badge, status, pagination, option, dan catatan kecil.
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
| HEADER HALAMAN
|--------------------------------------------------------------------------
| Menampilkan judul, deskripsi, dan badge halaman Kelola Daya Tampung Panti.
|--------------------------------------------------------------------------
--}}
<div class="admin-page-card">
    <div class="admin-page-header">
        <div>
            <h1>Kelola Daya Tampung Panti</h1>
            <p>Tambah, ubah, hapus, dan cari data daya tampung panti sosial.</p>
        </div>

        <span class="admin-page-badge">PANTI</span>
    </div>
</div>

{{--
|--------------------------------------------------------------------------
| KONDISI TABEL BELUM TERSEDIA
|--------------------------------------------------------------------------
| Menampilkan informasi jika tabel panti belum ada di database.
|--------------------------------------------------------------------------
--}}
@if($tableMissing)
    <div class="admin-card">
        <h2>Tabel belum ditemukan</h2>
        <p>Tabel <strong>panti</strong> belum ada di database.</p>
    </div>
@else

    {{--
    |--------------------------------------------------------------------------
    | FORM TAMBAH DATA
    |--------------------------------------------------------------------------
    | Form untuk menambahkan data daya tampung panti ke database.
    |--------------------------------------------------------------------------
    --}}
    <div class="admin-card">
        <h2>Tambah Data</h2>
        <p>Input nama panti, kuota, jumlah laki-laki, dan jumlah perempuan.</p>

        <form action="{{ route('admin.data.store', 'panti') }}" method="POST" class="admin-form-grid">
            @csrf

            <div>
                <label>Nama Panti *</label>
                <input type="text" name="nama_panti" placeholder="Nama Panti" required>
            </div>

            <div>
                <label>Kuota *</label>
                <input type="number" name="kuota" placeholder="Kuota" min="0" required>
            </div>

            <div>
                <label>Laki-laki *</label>
                <input type="number" name="laki_laki" placeholder="Laki-laki" min="0" required>
            </div>

            <div>
                <label>Perempuan *</label>
                <input type="number" name="perempuan" placeholder="Perempuan" min="0" required>
            </div>

            <button type="submit">
                <i class="fa fa-plus"></i>
                Tambah
            </button>
        </form>
    </div>

    {{--
    |--------------------------------------------------------------------------
    | DAFTAR DATA PANTI
    |--------------------------------------------------------------------------
    | Menampilkan data panti yang dapat dicari, diedit langsung, dan dihapus.
    |--------------------------------------------------------------------------
    --}}
    <div class="admin-card">
        <h2>Daftar Data</h2>
        <p>Data tersimpan pada tabel <strong>panti</strong>.</p>

        {{--
        |--------------------------------------------------------------------------
        | FORM PENCARIAN
        |--------------------------------------------------------------------------
        | Digunakan untuk mencari data Daya Tampung Panti berdasarkan keyword.
        |--------------------------------------------------------------------------
        --}}
        <form method="GET" class="admin-search-row">
            <input
                type="text"
                name="search"
                value="{{ request('search') }}"
                placeholder="Cari data Daya Tampung Panti..."
            >

            <button type="submit">
                <i class="fa fa-search"></i>
                Cari
            </button>

            <a href="{{ route('admin.data.index', 'panti') }}">
                Reset
            </a>
        </form>

        {{--
        |--------------------------------------------------------------------------
        | TABEL DATA PANTI
        |--------------------------------------------------------------------------
        | Menampilkan daftar panti beserta input edit langsung pada setiap baris.
        |--------------------------------------------------------------------------
        --}}
        <div class="admin-table-wrap">
            <table class="admin-table">
                <thead>
                    <tr>
                        <th width="70">No</th>
                        <th>Nama Panti</th>
                        <th width="160">Kuota</th>
                        <th width="160">Laki-laki</th>
                        <th width="160">Perempuan</th>
                        <th width="140">Aksi</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($items as $index => $item)
                        @php
                            /*
                            |--------------------------------------------------------------------------
                            | FORM ID PER BARIS
                            |--------------------------------------------------------------------------
                            | Membuat ID form update dan delete agar tombol aksi tetap terhubung.
                            |--------------------------------------------------------------------------
                            */

                            $formId = 'form-update-panti-' . $item->id;
                            $deleteFormId = 'form-delete-panti-' . $item->id;
                        @endphp

                        <tr>
                            <td>{{ $items->firstItem() + $index }}</td>

                            <td>
                                <input
                                    form="{{ $formId }}"
                                    type="text"
                                    name="nama_panti"
                                    value="{{ $item->nama_panti ?? '' }}"
                                    required
                                >
                            </td>

                            <td>
                                <input
                                    form="{{ $formId }}"
                                    type="number"
                                    name="kuota"
                                    value="{{ $item->kuota ?? 0 }}"
                                    min="0"
                                    required
                                >
                            </td>

                            <td>
                                <input
                                    form="{{ $formId }}"
                                    type="number"
                                    name="laki_laki"
                                    value="{{ $item->laki_laki ?? 0 }}"
                                    min="0"
                                    required
                                >
                            </td>

                            <td>
                                <input
                                    form="{{ $formId }}"
                                    type="number"
                                    name="perempuan"
                                    value="{{ $item->perempuan ?? 0 }}"
                                    min="0"
                                    required
                                >
                            </td>

                            {{--
                            |--------------------------------------------------------------------------
                            | AKSI DATA PANTI
                            |--------------------------------------------------------------------------
                            | Tombol simpan dan hapus untuk setiap baris data panti.
                            |--------------------------------------------------------------------------
                            --}}
                            <td>
                                <div class="action-wrap">
                                    <button
                                        form="{{ $formId }}"
                                        type="submit"
                                        class="action-btn action-save"
                                        title="Simpan"
                                    >
                                        <i class="fa fa-save"></i>
                                    </button>

                                    <button
                                        form="{{ $deleteFormId }}"
                                        type="submit"
                                        class="action-btn action-delete"
                                        title="Hapus"
                                    >
                                        <i class="fa fa-trash"></i>
                                    </button>
                                </div>

                                <form
                                    id="{{ $formId }}"
                                    action="{{ route('admin.data.update', ['module' => 'panti', 'id' => $item->id]) }}"
                                    method="POST"
                                    style="display:none;"
                                >
                                    @csrf
                                    @method('PUT')
                                </form>

                                <form
                                    id="{{ $deleteFormId }}"
                                    action="{{ route('admin.data.destroy', ['module' => 'panti', 'id' => $item->id]) }}"
                                    method="POST"
                                    style="display:none;"
                                    onsubmit="return confirm('Yakin ingin menghapus data panti ini?')"
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
                        | Menampilkan pesan jika belum ada data Daya Tampung Panti.
                        |--------------------------------------------------------------------------
                        --}}
                        <tr>
                            <td colspan="6">Belum ada data Daya Tampung Panti.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{--
        |--------------------------------------------------------------------------
        | PAGINATION DATA
        |--------------------------------------------------------------------------
        | Menampilkan informasi jumlah data dan navigasi halaman jika diperlukan.
        |--------------------------------------------------------------------------
        --}}
        @if(method_exists($items, 'lastPage') && $items->lastPage() > 1)
            <div class="custom-pagination">
                <div class="pagination-info">
                    Menampilkan {{ $items->firstItem() }} - {{ $items->lastItem() }} dari {{ $items->total() }} data
                </div>

                <div class="pagination-links">
                    @if($items->onFirstPage())
                        <span class="page-link-disabled">Previous</span>
                    @else
                        <a class="page-link-custom" href="{{ $items->previousPageUrl() }}">Previous</a>
                    @endif

                    @php
                        /*
                        |--------------------------------------------------------------------------
                        | RANGE PAGINATION
                        |--------------------------------------------------------------------------
                        | Menentukan rentang nomor halaman yang tampil di sekitar halaman aktif.
                        |--------------------------------------------------------------------------
                        */

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
            </div>
        @endif
    </div>
@endif
@endsection