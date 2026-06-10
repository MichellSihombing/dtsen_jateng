<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\DtJateng;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class AdminDataMasterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | NORMALISASI MODULE
    |--------------------------------------------------------------------------
    */

    private function normalizeModule(string $module): string
    {
        return match ($module) {
            'pks' => 'ppks',
            default => $module,
        };
    }

    /*
    |--------------------------------------------------------------------------
    | KONFIGURASI DATA MASTER
    |--------------------------------------------------------------------------
    */

    private function config(string $module): array
    {
        $module = $this->normalizeModule($module);

        return match ($module) {
            'panti' => [
                'module' => 'panti',
                'title' => 'Daya Tampung Panti',
                'badge' => 'PANTI',
                'table' => 'panti',
                'view' => 'admin.data-master.panti.index',
                'search_placeholder' => 'Cari nama panti...',
                'fields' => [
                    'nama_panti' => [
                        'label' => 'Nama Panti',
                        'type' => 'text',
                        'required' => true,
                    ],
                    'kuota' => [
                        'label' => 'Kuota',
                        'type' => 'number',
                        'required' => false,
                    ],
                    'laki_laki' => [
                        'label' => 'Laki-laki',
                        'type' => 'number',
                        'required' => false,
                    ],
                    'perempuan' => [
                        'label' => 'Perempuan',
                        'type' => 'number',
                        'required' => false,
                    ],
                ],
            ],

            'dt-jateng' => [
                'module' => 'dt-jateng',
                'title' => 'DT Jateng',
                'badge' => 'DT JATENG',
                'table' => 'dt_jateng',
                'view' => 'admin.data-master.dt-jateng.index',
                'search_placeholder' => 'Cari data DT Jateng...',
                'fields' => [
                    'kabupaten_id' => [
                        'label' => 'Kabupaten/Kota',
                        'type' => 'select-kabupaten',
                        'required' => true,
                    ],
                    'rtlh' => [
                        'label' => 'RTLH',
                        'type' => 'number',
                        'required' => false,
                    ],
                    'rtlh_p1' => [
                        'label' => 'RTLH P1',
                        'type' => 'number',
                        'required' => false,
                    ],
                    'rtlh_p2' => [
                        'label' => 'RTLH P2',
                        'type' => 'number',
                        'required' => false,
                    ],
                    'listrik' => [
                        'label' => 'Listrik',
                        'type' => 'number',
                        'required' => false,
                    ],
                    'air' => [
                        'label' => 'Air',
                        'type' => 'number',
                        'required' => false,
                    ],
                    'jamban' => [
                        'label' => 'Jamban',
                        'type' => 'number',
                        'required' => false,
                    ],
                    'ats' => [
                        'label' => 'ATS',
                        'type' => 'number',
                        'required' => false,
                    ],
                    'tidak_bekerja' => [
                        'label' => 'Tidak Bekerja',
                        'type' => 'number',
                        'required' => false,
                    ],
                    'pct_art' => [
                        'label' => '% ART',
                        'type' => 'percent',
                        'required' => false,
                    ],
                ],
            ],

            'psks' => [
                'module' => 'psks',
                'title' => 'PSKS',
                'badge' => 'PSKS',
                'table' => 'psks',
                'view' => 'admin.data-master.psks.index',
                'search_placeholder' => 'Cari data PSKS...',
                'fields' => [
                    'jenis_psks' => [
                        'label' => 'Jenis PSKS',
                        'type' => 'text',
                        'required' => true,
                    ],
                    'tahun' => [
                        'label' => 'Tahun',
                        'type' => 'select-tahun',
                        'required' => true,
                    ],
                    'jumlah' => [
                        'label' => 'Jumlah',
                        'type' => 'number',
                        'required' => true,
                    ],
                ],
            ],

            /*
            |--------------------------------------------------------------------------
            | PPKS SUDAH PAKAI AdminPpksController
            |--------------------------------------------------------------------------
            */

            'ppks' => [
                'module' => 'ppks',
                'title' => 'PPKS',
                'badge' => 'PPKS',
                'table' => 'ppks',
                'view' => 'admin.data-master.ppks.index',
                'search_placeholder' => 'Cari data PPKS...',
                'fields' => [],
            ],

            default => abort(404, 'Module data master tidak ditemukan.'),
        };
    }

    /*
    |--------------------------------------------------------------------------
    | HELPER TAHUN
    |--------------------------------------------------------------------------
    */

    private function tahunList(): array
    {
        return range(2015, 2025);
    }

    private function psksTahunList(): array
    {
        return range(2013, 2023);
    }

    /*
    |--------------------------------------------------------------------------
    | INDEX
    |--------------------------------------------------------------------------
    */

    public function index(Request $request, string $module)
    {
        $module = $this->normalizeModule($module);

        /*
        |--------------------------------------------------------------------------
        | Kalau PPKS sudah memakai AdminPpksController, lempar ke route PPKS baru.
        |--------------------------------------------------------------------------
        */

        if ($module === 'ppks' && route_exists('admin.ppks.index')) {
            return redirect()->route('admin.ppks.index', [
                'mode' => $request->query('mode', 'cards'),
            ]);
        }

        $config = $this->config($module);
        $table = $config['table'];

        $kabupatens = Schema::hasTable('kabupatens')
            ? DB::table('kabupatens')
                ->select('id', 'nama_kabupaten')
                ->orderBy('nama_kabupaten', 'asc')
                ->get()
            : collect();

        $tahunList = $this->tahunList();
        $psksTahunList = $this->psksTahunList();

        if (!Schema::hasTable($table)) {
            return view($config['view'], [
                'config' => $config,
                'items' => collect(),
                'tableMissing' => true,
                'columns' => [],
                'kabupatens' => $kabupatens,
                'tahunList' => $tahunList,
                'psksTahunList' => $psksTahunList,
                'psksJenisRows' => collect(),
            ]);
        }

        if ($module === 'dt-jateng') {
            return $this->indexDtJateng($request, $config, $kabupatens, $tahunList, $psksTahunList);
        }

        if ($module === 'psks') {
            return $this->indexPsks($request, $config, $kabupatens, $tahunList, $psksTahunList);
        }

        return $this->indexGeneric($request, $config, $kabupatens, $tahunList, $psksTahunList);
    }

    /*
    |--------------------------------------------------------------------------
    | INDEX DT JATENG
    |--------------------------------------------------------------------------
    */

    private function indexDtJateng(Request $request, array $config, $kabupatens, array $tahunList, array $psksTahunList)
    {
        $search = $request->query('search');

        $items = DtJateng::query()
            ->with('kabupaten')
            ->when($search, function ($query) use ($search) {
                $query->whereHas('kabupaten', function ($q) use ($search) {
                    $q->where('nama_kabupaten', 'like', "%{$search}%");
                });
            })
            ->leftJoin('kabupatens', 'dt_jateng.kabupaten_id', '=', 'kabupatens.id')
            ->select('dt_jateng.*')
            ->orderByRaw('kabupatens.nama_kabupaten IS NULL')
            ->orderBy('kabupatens.nama_kabupaten', 'asc')
            ->paginate(10)
            ->withQueryString();

        return view($config['view'], [
            'config' => $config,
            'items' => $items,
            'tableMissing' => false,
            'columns' => Schema::getColumnListing('dt_jateng'),
            'kabupatens' => $kabupatens,
            'tahunList' => $tahunList,
            'psksTahunList' => $psksTahunList,
            'psksJenisRows' => collect(),
        ]);
    }

    /*
    |--------------------------------------------------------------------------
    | INDEX PSKS
    |--------------------------------------------------------------------------
    */

    private function indexPsks(Request $request, array $config, $kabupatens, array $tahunList, array $psksTahunList)
    {
        $psksSource = DB::table('psks')
            ->select('jenis_psks', 'tahun', DB::raw('SUM(jumlah) as total'))
            ->groupBy('jenis_psks', 'tahun')
            ->orderBy('jenis_psks', 'asc')
            ->get();

        $psksMap = [];

        foreach ($psksSource as $row) {
            if (!isset($psksMap[$row->jenis_psks])) {
                $psksMap[$row->jenis_psks] = [];
            }

            $psksMap[$row->jenis_psks][$row->tahun] = $row->total;
        }

        $psksJenisRows = collect($psksMap)
            ->map(function ($tahunData, $jenis) use ($psksTahunList) {
                $cleanTahunData = [];

                foreach ($psksTahunList as $tahun) {
                    $cleanTahunData[$tahun] = $tahunData[$tahun] ?? 0;
                }

                return (object) [
                    'jenis_psks' => $jenis,
                    'tahun_data' => $cleanTahunData,
                ];
            })
            ->values();

        $items = DB::table('psks')
            ->orderBy('id', 'asc')
            ->paginate(10)
            ->withQueryString();

        return view($config['view'], [
            'config' => $config,
            'items' => $items,
            'tableMissing' => false,
            'columns' => Schema::getColumnListing('psks'),
            'kabupatens' => $kabupatens,
            'tahunList' => $tahunList,
            'psksTahunList' => $psksTahunList,
            'psksJenisRows' => $psksJenisRows,
        ]);
    }

    /*
    |--------------------------------------------------------------------------
    | INDEX GENERIC
    |--------------------------------------------------------------------------
    */

    private function indexGeneric(Request $request, array $config, $kabupatens, array $tahunList, array $psksTahunList)
    {
        $table = $config['table'];
        $columns = Schema::getColumnListing($table);

        $query = DB::table($table);

        if ($request->filled('search')) {
            $search = $request->search;

            $query->where(function ($q) use ($columns, $search) {
                foreach ($columns as $column) {
                    $q->orWhere($column, 'like', "%{$search}%");
                }
            });
        }

        if (Schema::hasColumn($table, 'id')) {
            $query->orderBy('id', 'asc');
        }

        $items = $query->paginate(10)->withQueryString();

        return view($config['view'], [
            'config' => $config,
            'items' => $items,
            'tableMissing' => false,
            'columns' => $columns,
            'kabupatens' => $kabupatens,
            'tahunList' => $tahunList,
            'psksTahunList' => $psksTahunList,
            'psksJenisRows' => collect(),
        ]);
    }

    /*
    |--------------------------------------------------------------------------
    | STORE
    |--------------------------------------------------------------------------
    */

    public function store(Request $request, string $module)
    {
        $module = $this->normalizeModule($module);

        if ($module === 'dt-jateng') {
            return $this->storeDtJateng($request);
        }

        $config = $this->config($module);
        $table = $config['table'];

        if (!Schema::hasTable($table)) {
            return back()->with('error', "Tabel {$table} belum ada di database.");
        }

        $data = $this->cleanRequestData($request, $table);

        if (empty($data)) {
            return back()->with('error', 'Tidak ada data yang bisa disimpan.');
        }

        if (Schema::hasColumn($table, 'created_at')) {
            $data['created_at'] = now();
        }

        if (Schema::hasColumn($table, 'updated_at')) {
            $data['updated_at'] = now();
        }

        DB::table($table)->insert($data);

        return back()->with('success', 'Data berhasil ditambahkan.');
    }

    /*
    |--------------------------------------------------------------------------
    | STORE DT JATENG
    |--------------------------------------------------------------------------
    */

    private function storeDtJateng(Request $request)
    {
        $request->validate([
            'kabupaten_id' => ['required', 'integer', 'exists:kabupatens,id'],
        ], [
            'kabupaten_id.required' => 'Kabupaten/Kota wajib dipilih.',
            'kabupaten_id.exists' => 'Kabupaten/Kota tidak valid.',
        ]);

        $exists = DtJateng::where('kabupaten_id', $request->kabupaten_id)->exists();

        if ($exists) {
            return back()->with('error', 'Kabupaten/Kota tersebut sudah ada di data DT Jateng.');
        }

        DtJateng::create([
            'kabupaten_id' => $request->kabupaten_id,
            'rtlh' => 0,
            'rtlh_p1' => 0,
            'rtlh_p2' => 0,
            'listrik' => 0,
            'air' => 0,
            'jamban' => 0,
            'ats' => 0,
            'tidak_bekerja' => 0,
            'pct_art' => 0,
        ]);

        return redirect()
            ->route('admin.data.index', 'dt-jateng')
            ->with('success', 'Kabupaten/Kota berhasil ditambahkan ke data DT Jateng.');
    }

    /*
    |--------------------------------------------------------------------------
    | UPDATE
    |--------------------------------------------------------------------------
    */

    public function update(Request $request, string $module, int $id)
    {
        $module = $this->normalizeModule($module);

        if ($module === 'dt-jateng') {
            return $this->updateDtJateng($request, $id);
        }

        $config = $this->config($module);
        $table = $config['table'];

        if (!Schema::hasTable($table)) {
            return back()->with('error', "Tabel {$table} belum ada di database.");
        }

        if (!Schema::hasColumn($table, 'id')) {
            return back()->with('error', "Tabel {$table} tidak memiliki kolom id.");
        }

        $data = $this->cleanRequestData($request, $table);

        if (empty($data)) {
            return back()->with('error', 'Tidak ada data yang bisa diperbarui.');
        }

        if (Schema::hasColumn($table, 'updated_at')) {
            $data['updated_at'] = now();
        }

        DB::table($table)
            ->where('id', $id)
            ->update($data);

        return back()->with('success', 'Data berhasil diperbarui.');
    }

    /*
    |--------------------------------------------------------------------------
    | UPDATE DT JATENG
    |--------------------------------------------------------------------------
    */

    private function updateDtJateng(Request $request, int $id)
    {
        $item = DtJateng::findOrFail($id);

        $request->validate([
            'kabupaten_id' => ['required', 'integer', 'exists:kabupatens,id'],
            'rtlh' => ['nullable'],
            'rtlh_p1' => ['nullable'],
            'rtlh_p2' => ['nullable'],
            'listrik' => ['nullable'],
            'air' => ['nullable'],
            'jamban' => ['nullable'],
            'ats' => ['nullable'],
            'tidak_bekerja' => ['nullable'],
            'pct_art' => ['nullable'],
        ]);

        $duplicate = DtJateng::where('kabupaten_id', $request->kabupaten_id)
            ->where('id', '!=', $item->id)
            ->exists();

        if ($duplicate) {
            return back()->with('error', 'Kabupaten/Kota tersebut sudah digunakan oleh data DT Jateng lain.');
        }

        $item->update([
            'kabupaten_id' => $request->kabupaten_id,
            'rtlh' => $this->cleanInteger($request->input('rtlh')),
            'rtlh_p1' => $this->cleanInteger($request->input('rtlh_p1')),
            'rtlh_p2' => $this->cleanInteger($request->input('rtlh_p2')),
            'listrik' => $this->cleanInteger($request->input('listrik')),
            'air' => $this->cleanInteger($request->input('air')),
            'jamban' => $this->cleanInteger($request->input('jamban')),
            'ats' => $this->cleanInteger($request->input('ats')),
            'tidak_bekerja' => $this->cleanInteger($request->input('tidak_bekerja')),
            'pct_art' => $this->cleanPercent($request->input('pct_art')),
        ]);

        return redirect()
            ->route('admin.data.index', 'dt-jateng')
            ->with('success', 'Data DT Jateng berhasil diperbarui.');
    }

    /*
    |--------------------------------------------------------------------------
    | DESTROY
    |--------------------------------------------------------------------------
    */

    public function destroy(string $module, int $id)
    {
        $module = $this->normalizeModule($module);

        if ($module === 'dt-jateng') {
            DtJateng::findOrFail($id)->delete();

            return redirect()
                ->route('admin.data.index', 'dt-jateng')
                ->with('success', 'Data DT Jateng berhasil dihapus.');
        }

        $config = $this->config($module);
        $table = $config['table'];

        if (!Schema::hasTable($table)) {
            return back()->with('error', "Tabel {$table} belum ada di database.");
        }

        if (!Schema::hasColumn($table, 'id')) {
            return back()->with('error', "Tabel {$table} tidak memiliki kolom id.");
        }

        DB::table($table)
            ->where('id', $id)
            ->delete();

        return back()->with('success', 'Data berhasil dihapus.');
    }

    /*
    |--------------------------------------------------------------------------
    | PSKS - STORE REKAP JENIS
    |--------------------------------------------------------------------------
    */

    public function storePsksJenis(Request $request)
    {
        $request->validate([
            'jenis_psks' => 'required|string|max:255',
            'tahun' => 'required|integer',
            'jumlah' => 'required|integer|min:0',
        ]);

        if (!Schema::hasTable('psks')) {
            return back()->with('error', 'Tabel psks belum tersedia.');
        }

        $query = DB::table('psks')
            ->where('jenis_psks', $request->jenis_psks)
            ->where('tahun', $request->tahun);

        if (Schema::hasColumn('psks', 'kabupaten_id')) {
            $query->whereNull('kabupaten_id');
        }

        $existing = $query->first();

        $payload = [
            'jenis_psks' => $request->jenis_psks,
            'tahun' => $request->tahun,
            'jumlah' => $request->jumlah,
        ];

        if (Schema::hasColumn('psks', 'kabupaten_id')) {
            $payload['kabupaten_id'] = null;
        }

        if (Schema::hasColumn('psks', 'updated_at')) {
            $payload['updated_at'] = now();
        }

        if ($existing) {
            DB::table('psks')
                ->where('id', $existing->id)
                ->update($payload);
        } else {
            if (Schema::hasColumn('psks', 'created_at')) {
                $payload['created_at'] = now();
            }

            DB::table('psks')->insert($payload);
        }

        return redirect()
            ->route('admin.data.index', 'psks')
            ->with('success', 'Data PSKS berhasil ditambahkan.');
    }

    /*
    |--------------------------------------------------------------------------
    | PSKS - UPDATE REKAP JENIS
    |--------------------------------------------------------------------------
    */

    public function updatePsksJenis(Request $request)
    {
        $request->validate([
            'old_jenis_psks' => 'required|string|max:255',
            'jenis_psks' => 'required|string|max:255',
        ]);

        if (!Schema::hasTable('psks')) {
            return back()->with('error', 'Tabel psks belum tersedia.');
        }

        $oldJenis = $request->old_jenis_psks;
        $newJenis = $request->jenis_psks;
        $jumlahPerTahun = $request->input('jumlah', []);

        foreach ($this->psksTahunList() as $tahun) {
            $jumlah = (int) ($jumlahPerTahun[$tahun] ?? 0);

            $query = DB::table('psks')
                ->where('jenis_psks', $oldJenis)
                ->where('tahun', $tahun);

            if (Schema::hasColumn('psks', 'kabupaten_id')) {
                $query->whereNull('kabupaten_id');
            }

            $existing = $query->first();

            $payload = [
                'jenis_psks' => $newJenis,
                'tahun' => $tahun,
                'jumlah' => $jumlah,
            ];

            if (Schema::hasColumn('psks', 'kabupaten_id')) {
                $payload['kabupaten_id'] = null;
            }

            if (Schema::hasColumn('psks', 'updated_at')) {
                $payload['updated_at'] = now();
            }

            if ($existing) {
                DB::table('psks')
                    ->where('id', $existing->id)
                    ->update($payload);
            } else {
                if (Schema::hasColumn('psks', 'created_at')) {
                    $payload['created_at'] = now();
                }

                DB::table('psks')->insert($payload);
            }
        }

        return redirect()
            ->route('admin.data.index', 'psks')
            ->with('success', 'Data rekap Jenis PSKS berhasil diperbarui.');
    }

    /*
    |--------------------------------------------------------------------------
    | PSKS - DELETE REKAP JENIS
    |--------------------------------------------------------------------------
    */

    public function destroyPsksJenis(Request $request)
    {
        $request->validate([
            'jenis_psks' => 'required|string|max:255',
        ]);

        if (!Schema::hasTable('psks')) {
            return back()->with('error', 'Tabel psks belum tersedia.');
        }

        $query = DB::table('psks')
            ->where('jenis_psks', $request->jenis_psks);

        if (Schema::hasColumn('psks', 'kabupaten_id')) {
            $query->whereNull('kabupaten_id');
        }

        $query->delete();

        return redirect()
            ->route('admin.data.index', 'psks')
            ->with('success', 'Data PSKS berhasil dihapus.');
    }

    /*
    |--------------------------------------------------------------------------
    | HELPER CLEAN DATA
    |--------------------------------------------------------------------------
    */

    private function cleanRequestData(Request $request, string $table): array
    {
        $columns = Schema::getColumnListing($table);
        $blockedColumns = ['id', 'created_at', 'updated_at'];

        $data = [];

        foreach ($columns as $column) {
            if (in_array($column, $blockedColumns, true)) {
                continue;
            }

            if ($request->has($column)) {
                $data[$column] = $request->input($column);
            }
        }

        return $data;
    }

    private function cleanInteger($value): int
    {
        if ($value === null || $value === '') {
            return 0;
        }

        $value = str_replace(['.', ',', ' '], '', (string) $value);
        $value = preg_replace('/[^0-9]/', '', $value);

        return (int) ($value ?: 0);
    }

    private function cleanPercent($value): float
    {
        if ($value === null || $value === '') {
            return 0;
        }

        $value = str_replace('%', '', (string) $value);
        $value = str_replace(' ', '', $value);
        $value = str_replace(',', '.', $value);

        return round((float) $value, 2);
    }
}

if (!function_exists('route_exists')) {
    function route_exists(string $name): bool
    {
        try {
            route($name);
            return true;
        } catch (\Throwable $e) {
            return false;
        }
    }
}