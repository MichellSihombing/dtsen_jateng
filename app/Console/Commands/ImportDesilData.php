<?php

namespace App\Console\Commands;

use App\Models\Desa;
use App\Models\DesilDesa;
use App\Models\Kabupaten;
use App\Models\Kecamatan;
use Illuminate\Console\Command;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use PhpOffice\PhpSpreadsheet\Cell\Coordinate;
use PhpOffice\PhpSpreadsheet\IOFactory;

class ImportDesilData extends Command
{
    /*
    |--------------------------------------------------------------------------
    | NAMA COMMAND ARTISAN
    |--------------------------------------------------------------------------
    */
    protected $signature = 'import:desil {--file= : Lokasi file Excel desil}';

    /*
    |--------------------------------------------------------------------------
    | DESKRIPSI COMMAND
    |--------------------------------------------------------------------------
    */
    protected $description = 'Import data desil desa dari file Excel ke database';

    /*
    |--------------------------------------------------------------------------
    | PROSES UTAMA COMMAND
    |--------------------------------------------------------------------------
    */
    public function handle(): int
    {
        /*
        |--------------------------------------------------------------------------
        | MENENTUKAN LOKASI FILE
        |--------------------------------------------------------------------------
        */
        $filePath = $this->option('file')
            ? base_path($this->option('file'))
            : storage_path('app/import/kodewil_desil.xlsx');

        /*
        |--------------------------------------------------------------------------
        | VALIDASI FILE EXCEL
        |--------------------------------------------------------------------------
        */
        if (!file_exists($filePath)) {
            $this->error('File Excel tidak ditemukan.');
            $this->line('Pastikan file tersedia di:');
            $this->line($filePath);

            return self::FAILURE;
        }

        $this->info('Membaca file Excel desil...');
        $this->line($filePath);

        try {
            /*
            |--------------------------------------------------------------------------
            | MEMBACA FILE EXCEL
            |--------------------------------------------------------------------------
            */
            $spreadsheet = IOFactory::load($filePath);
            $sheet = $spreadsheet->getActiveSheet();

            /*
            |--------------------------------------------------------------------------
            | MENCARI BARIS HEADER
            |--------------------------------------------------------------------------
            */
            $headerRow = $this->findHeaderRow($sheet);

            if (!$headerRow) {
                $this->error('Header Excel tidak ditemukan.');
                $this->line('Pastikan file memiliki kolom NMKAB, NMKEC, NMDESA, kdkab, kdkec, kddesa, DESIL 1, dan TOTAL.');

                return self::FAILURE;
            }

            /*
            |--------------------------------------------------------------------------
            | MENYIAPKAN DATA AWAL
            |--------------------------------------------------------------------------
            */
            $headers = $this->readHeaders($sheet, $headerRow);
            $highestRow = $sheet->getHighestDataRow();

            $totalRows = 0;
            $successMapping = 0;
            $failedMapping = 0;
            $created = 0;
            $updated = 0;
            $skipped = 0;
            $autoCreatedDesa = 0;
            $failedSamples = [];

            $this->info("Header ditemukan pada baris: {$headerRow}");
            $this->info('Memulai import data desil...');

            /*
            |--------------------------------------------------------------------------
            | MEMULAI TRANSAKSI DATABASE
            |--------------------------------------------------------------------------
            */
            DB::beginTransaction();

            /*
            |--------------------------------------------------------------------------
            | MEMPROSES DATA EXCEL
            |--------------------------------------------------------------------------
            */
            for ($row = $headerRow + 1; $row <= $highestRow; $row++) {
                $rowData = $this->readRow($sheet, $row, $headers);

                /*
                |--------------------------------------------------------------------------
                | MELEWATI BARIS KOSONG
                |--------------------------------------------------------------------------
                */
                if ($this->isEmptyRow($rowData)) {
                    $skipped++;
                    continue;
                }

                $totalRows++;

                /*
                |--------------------------------------------------------------------------
                | MENGAMBIL KODE WILAYAH
                |--------------------------------------------------------------------------
                */
                $kodeKabupaten = $this->cleanCode($this->getValue($rowData, [
                    'kdkab',
                    'kodekabupaten',
                    'kodekab',
                    'kodekota',
                ]));

                $kodeKecamatan = $this->cleanCode($this->getValue($rowData, [
                    'kdkec',
                    'kodekecamatan',
                    'kodekec',
                ]));

                $kodeDesa = $this->cleanCode($this->getValue($rowData, [
                    'kddesa',
                    'kodedesa',
                    'kodekelurahan',
                    'kodedesakelurahan',
                ]));

                /*
                |--------------------------------------------------------------------------
                | MENGAMBIL NAMA WILAYAH
                |--------------------------------------------------------------------------
                */
                $namaKabupaten = $this->cleanName($this->getValue($rowData, [
                    'nmkab',
                    'namakabupaten',
                    'namakota',
                    'kabupaten',
                    'kota',
                ]));

                $namaKecamatan = $this->cleanName($this->getValue($rowData, [
                    'nmkec',
                    'namakecamatan',
                    'kecamatan',
                ]));

                $namaDesa = $this->cleanName($this->getValue($rowData, [
                    'nmdesa',
                    'namadesa',
                    'namakelurahan',
                    'desa',
                    'kelurahan',
                ]));

                /*
                |--------------------------------------------------------------------------
                | MENYESUAIKAN ALIAS WILAYAH
                |--------------------------------------------------------------------------
                */
                $namaKecamatan = $this->applyKecamatanAlias($namaKabupaten, $namaKecamatan);
                $namaDesa = $this->applyDesaAlias($namaKabupaten, $namaKecamatan, $namaDesa);

                /*
                |--------------------------------------------------------------------------
                | MENCARI DATA WILAYAH
                |--------------------------------------------------------------------------
                */
                $kabupaten = $this->findKabupaten($kodeKabupaten, $namaKabupaten);
                $kecamatan = $this->findKecamatan($kodeKecamatan, $namaKecamatan, $kabupaten?->id);
                $desa = $this->findDesa($kodeDesa, $namaDesa, $kecamatan?->id);

                /*
                |--------------------------------------------------------------------------
                | MELENGKAPI KECAMATAN DARI DESA
                |--------------------------------------------------------------------------
                */
                if ($desa && !$kecamatan && method_exists($desa, 'kecamatan')) {
                    $desa->loadMissing('kecamatan');
                    $kecamatan = $desa->kecamatan;
                }

                /*
                |--------------------------------------------------------------------------
                | MENCARI DESA DALAM KABUPATEN
                |--------------------------------------------------------------------------
                */
                if (!$desa && $kabupaten && $namaDesa) {
                    $desa = $this->findDesaInsideKabupaten($namaDesa, $kabupaten->id);

                    if ($desa) {
                        $desa->loadMissing('kecamatan');

                        if (!$kecamatan) {
                            $kecamatan = $desa->kecamatan;
                        }
                    }
                }

                /*
                |--------------------------------------------------------------------------
                | MEMBUAT DESA OTOMATIS
                |--------------------------------------------------------------------------
                */
                if (!$desa && $kabupaten && $kecamatan && $namaDesa) {
                    $desa = $this->createMissingDesaFromExcel(
                        kodeDesa: $kodeDesa,
                        namaDesa: $namaDesa,
                        kecamatanId: $kecamatan->id
                    );

                    if ($desa) {
                        $autoCreatedDesa++;
                    }
                }

                /*
                |--------------------------------------------------------------------------
                | MENENTUKAN STATUS MAPPING
                |--------------------------------------------------------------------------
                */
                $mappingStatus = 'success';
                $mappingNotes = [];

                if (!$kabupaten) {
                    $mappingStatus = 'failed';
                    $mappingNotes[] = 'Kabupaten tidak ditemukan';
                }

                if (!$kecamatan) {
                    $mappingStatus = 'failed';
                    $mappingNotes[] = 'Kecamatan tidak ditemukan';
                }

                if (!$desa) {
                    $mappingStatus = 'failed';
                    $mappingNotes[] = 'Desa tidak ditemukan';
                }

                /*
                |--------------------------------------------------------------------------
                | MENGHITUNG HASIL MAPPING
                |--------------------------------------------------------------------------
                */
                if ($mappingStatus === 'success') {
                    $successMapping++;
                } else {
                    $failedMapping++;

                    if (count($failedSamples) < 40) {
                        $failedSamples[] = "{$namaKabupaten} / {$namaKecamatan} / {$namaDesa} - " . implode(', ', $mappingNotes);
                    }
                }

                /*
                |--------------------------------------------------------------------------
                | MENYIAPKAN DATA DESIL
                |--------------------------------------------------------------------------
                */
                $payload = [
                    'kabupaten_id' => $kabupaten?->id,
                    'kecamatan_id' => $kecamatan?->id,
                    'desa_id' => $desa?->id,

                    'kode_kabupaten' => $kodeKabupaten,
                    'kode_kecamatan' => $kodeKecamatan,
                    'kode_desa' => $kodeDesa,

                    'nama_kabupaten' => $namaKabupaten,
                    'nama_kecamatan' => $namaKecamatan,
                    'nama_desa' => $namaDesa,

                    'desil_1' => $this->parseNumber($this->getValue($rowData, [
                        'desil1',
                        'desil01',
                    ])),

                    'desil_2' => $this->parseNumber($this->getValue($rowData, [
                        'desil2',
                        'desil02',
                    ])),

                    'desil_3' => $this->parseNumber($this->getValue($rowData, [
                        'desil3',
                        'desil03',
                    ])),

                    'desil_4' => $this->parseNumber($this->getValue($rowData, [
                        'desil4',
                        'desil04',
                    ])),

                    'total_d1_d4' => $this->parseNumber($this->getValue($rowData, [
                        'totald1-d4',
                        'totald1d4',
                        'totaldesil1-4',
                        'totaldesil14',
                    ])),

                    'desil_5' => $this->parseNumber($this->getValue($rowData, [
                        'desil5',
                        'desil05',
                    ])),

                    'desil_6' => $this->parseNumber($this->getValue($rowData, [
                        'desil6',
                        'desil06',
                    ])),

                    'desil_7_10' => $this->parseNumber($this->getValue($rowData, [
                        'desil7-10',
                        'desil710',
                        'desil7sd10',
                        'desil7sampai10',
                    ])),

                    'desil_null' => $this->parseNumber($this->getValue($rowData, [
                        'desilnull',
                        'desilkosong',
                        'desilnul',
                    ])),

                    'total' => $this->parseNumber($this->getValue($rowData, [
                        'total',
                        'jumlah',
                    ])),

                    'mapping_status' => $mappingStatus,
                    'mapping_note' => implode('; ', $mappingNotes),
                ];

                /*
                |--------------------------------------------------------------------------
                | MENENTUKAN DATA LOOKUP
                |--------------------------------------------------------------------------
                */
                if ($kodeKabupaten && $kodeKecamatan && $kodeDesa) {
                    $lookup = [
                        'kode_kabupaten' => $kodeKabupaten,
                        'kode_kecamatan' => $kodeKecamatan,
                        'kode_desa' => $kodeDesa,
                    ];
                } else {
                    $lookup = [
                        'nama_kabupaten' => $namaKabupaten,
                        'nama_kecamatan' => $namaKecamatan,
                        'nama_desa' => $namaDesa,
                    ];
                }

                /*
                |--------------------------------------------------------------------------
                | MENYIMPAN ATAU MEMPERBARUI DATA
                |--------------------------------------------------------------------------
                */
                $record = DesilDesa::updateOrCreate($lookup, $payload);

                if ($record->wasRecentlyCreated) {
                    $created++;
                } else {
                    $updated++;
                }
            }

            /*
            |--------------------------------------------------------------------------
            | MENYIMPAN TRANSAKSI
            |--------------------------------------------------------------------------
            */
            DB::commit();

            /*
            |--------------------------------------------------------------------------
            | MENAMPILKAN LAPORAN IMPORT
            |--------------------------------------------------------------------------
            */
            $this->newLine();
            $this->info('Import data desil selesai.');
            $this->line('============================================================');
            $this->line("Total baris Excel       : {$totalRows}");
            $this->line("Baris kosong dilewati   : {$skipped}");
            $this->line("Desa auto dibuat        : {$autoCreatedDesa}");
            $this->line("Berhasil mapping        : {$successMapping}");
            $this->line("Gagal mapping           : {$failedMapping}");
            $this->line("Data dibuat             : {$created}");
            $this->line("Data diperbarui         : {$updated}");
            $this->line('============================================================');

            /*
            |--------------------------------------------------------------------------
            | MENAMPILKAN CONTOH DATA GAGAL
            |--------------------------------------------------------------------------
            */
            if (!empty($failedSamples)) {
                $this->newLine();
                $this->warn('Contoh data gagal mapping:');

                foreach ($failedSamples as $sample) {
                    $this->line('- ' . $sample);
                }
            }

            $this->newLine();
            $this->info('Silakan cek tabel desil_desas di phpMyAdmin.');

            return self::SUCCESS;
        } catch (\Throwable $e) {
            /*
            |--------------------------------------------------------------------------
            | MEMBATALKAN TRANSAKSI JIKA ERROR
            |--------------------------------------------------------------------------
            */
            DB::rollBack();

            $this->error('Import data desil gagal.');
            $this->error($e->getMessage());

            return self::FAILURE;
        }
    }

    /*
    |--------------------------------------------------------------------------
    | MENGAMBIL NILAI CELL EXCEL
    |--------------------------------------------------------------------------
    */
    private function cellValue($sheet, int $column, int $row): string
    {
        $columnLetter = Coordinate::stringFromColumnIndex($column);

        return (string) $sheet->getCell($columnLetter . $row)->getFormattedValue();
    }

    /*
    |--------------------------------------------------------------------------
    | MENCARI BARIS HEADER
    |--------------------------------------------------------------------------
    */
    private function findHeaderRow($sheet): ?int
    {
        $highestColumn = Coordinate::columnIndexFromString($sheet->getHighestDataColumn());

        for ($row = 1; $row <= 15; $row++) {
            $headers = [];

            for ($col = 1; $col <= $highestColumn; $col++) {
                $headers[] = $this->normalizeHeader($this->cellValue($sheet, $col, $row));
            }

            if (
                in_array('nmkab', $headers, true) ||
                in_array('kdkab', $headers, true) ||
                in_array('nmdesa', $headers, true)
            ) {
                return $row;
            }
        }

        return null;
    }

    /*
    |--------------------------------------------------------------------------
    | MEMBACA HEADER EXCEL
    |--------------------------------------------------------------------------
    */
    private function readHeaders($sheet, int $headerRow): array
    {
        $highestColumn = Coordinate::columnIndexFromString($sheet->getHighestDataColumn());
        $headers = [];

        for ($col = 1; $col <= $highestColumn; $col++) {
            $key = $this->normalizeHeader($this->cellValue($sheet, $col, $headerRow));

            if ($key) {
                $headers[$col] = $key;
            }
        }

        return $headers;
    }

    /*
    |--------------------------------------------------------------------------
    | MEMBACA BARIS DATA
    |--------------------------------------------------------------------------
    */
    private function readRow($sheet, int $row, array $headers): array
    {
        $data = [];

        foreach ($headers as $col => $key) {
            $data[$key] = $this->cellValue($sheet, $col, $row);
        }

        return $data;
    }

    /*
    |--------------------------------------------------------------------------
    | MENORMALISASI HEADER
    |--------------------------------------------------------------------------
    */
    private function normalizeHeader($value): string
    {
        $value = strtolower(trim((string) $value));
        $value = str_replace([' ', '_', '.', '/', '\\', '(', ')'], '', $value);

        return $value;
    }

    /*
    |--------------------------------------------------------------------------
    | MENGAMBIL NILAI DARI BEBERAPA KEY
    |--------------------------------------------------------------------------
    */
    private function getValue(array $row, array $keys): mixed
    {
        foreach ($keys as $key) {
            if (array_key_exists($key, $row)) {
                return $row[$key];
            }
        }

        return null;
    }

    /*
    |--------------------------------------------------------------------------
    | MENGECEK BARIS KOSONG
    |--------------------------------------------------------------------------
    */
    private function isEmptyRow(array $row): bool
    {
        $importantValues = [
            $this->getValue($row, ['kdkab']),
            $this->getValue($row, ['kdkec']),
            $this->getValue($row, ['kddesa']),
            $this->getValue($row, ['nmkab']),
            $this->getValue($row, ['nmkec']),
            $this->getValue($row, ['nmdesa']),
        ];

        foreach ($importantValues as $value) {
            if (trim((string) $value) !== '') {
                return false;
            }
        }

        return true;
    }

    /*
    |--------------------------------------------------------------------------
    | MEMBERSIHKAN KODE WILAYAH
    |--------------------------------------------------------------------------
    */
    private function cleanCode($value): ?string
    {
        $value = trim((string) $value);

        if ($value === '') {
            return null;
        }

        $value = preg_replace('/[^0-9]/', '', $value);

        return $value !== '' ? $value : null;
    }

    /*
    |--------------------------------------------------------------------------
    | MEMBERSIHKAN NAMA WILAYAH
    |--------------------------------------------------------------------------
    */
    private function cleanName($value): ?string
    {
        $value = trim((string) $value);
        $value = preg_replace('/\s+/', ' ', $value);

        return $value !== '' ? strtoupper($value) : null;
    }

    /*
    |--------------------------------------------------------------------------
    | MENORMALISASI KEY ALIAS
    |--------------------------------------------------------------------------
    */
    private function normalizeAliasKey(?string $value): string
    {
        if (!$value) {
            return '';
        }

        $value = strtoupper(trim($value));
        $value = preg_replace('/\s+/', ' ', $value);

        return $value;
    }

    /*
    |--------------------------------------------------------------------------
    | MENYESUAIKAN ALIAS KECAMATAN
    |--------------------------------------------------------------------------
    */
    private function applyKecamatanAlias(?string $kabupaten, ?string $kecamatan): ?string
    {
        $kabupaten = $this->normalizeAliasKey($kabupaten);
        $kecamatan = $this->normalizeAliasKey($kecamatan);

        $aliases = [
            'BANJARNEGARA|PURWOREJA KLAMPOK' => 'PURWAREJA KLAMPOK',
            'PEKALONGAN|PETUNGKRIYONO' => 'PETUNGKRIONO',
        ];

        $key = "{$kabupaten}|{$kecamatan}";

        return $aliases[$key] ?? $kecamatan;
    }

    /*
    |--------------------------------------------------------------------------
    | MENYESUAIKAN ALIAS DESA
    |--------------------------------------------------------------------------
    */
    private function applyDesaAlias(?string $kabupaten, ?string $kecamatan, ?string $desa): ?string
    {
        $kabupaten = $this->normalizeAliasKey($kabupaten);
        $kecamatan = $this->normalizeAliasKey($kecamatan);
        $desa = $this->normalizeAliasKey($desa);

        $aliases = [
            'BREBES|BANJARHARJO|PAREGRAJA' => 'PAREREJA',
            'BREBES|BANJARHARJO|PAREREJA' => 'PAREREJA',
            'BREBES|BANJARHARJO|PARIREJA' => 'PAREREJA',
            'DEMAK|KARANGANYAR|KOTAAN' => 'KOTAKAN',
            'WONOSOBO|KERTEK|DAMARKASIYAN' => 'DAMARKASIAN',
            'KEBUMEN|KUTOWINANGUN|TANJUNGSETO' => 'TANJUNG SETO',
            'TEGAL|PANGKAH|PUBAYASA' => 'PURBAYASA',
            'GROBOGAN|PENAWANGAN|KARANGPAHING' => 'KARANGPAING',
            'PATI|MARGOYOSO|MARGOTOHU KIDUL' => 'MARGOTUHU KIDUL',
            'PATI|MARGOREJO|SOKOBUBUK' => 'SUKOBUBUK',
            'PATI|MARGOREJO|MATARAMAN' => 'MATARAMAN',
        ];

        $key = "{$kabupaten}|{$kecamatan}|{$desa}";

        return $aliases[$key] ?? $desa;
    }

    /*
    |--------------------------------------------------------------------------
    | MENORMALISASI NAMA UNTUK PENCARIAN
    |--------------------------------------------------------------------------
    */
    private function normalizeNameForSearch(?string $value): ?string
    {
        if (!$value) {
            return null;
        }

        $value = strtoupper(trim($value));
        $value = preg_replace('/\s+/', ' ', $value);

        $removeWords = [
            'KABUPATEN ',
            'KAB. ',
            'KAB ',
            'KOTA ',
            'KECAMATAN ',
            'KEC. ',
            'KEC ',
            'DESA ',
            'DS. ',
            'DS ',
            'KELURAHAN ',
            'KEL. ',
            'KEL ',
        ];

        foreach ($removeWords as $word) {
            if (str_starts_with($value, $word)) {
                $value = substr($value, strlen($word));
            }
        }

        $value = str_replace([' ', '.', '-', "'", '`', '’', '/', '\\'], '', $value);

        return trim($value);
    }

    /*
    |--------------------------------------------------------------------------
    | MENYUSUN SQL NORMALISASI NAMA
    |--------------------------------------------------------------------------
    */
    private function normalizedNameSql(string $column): string
    {
        $expression = "UPPER(`{$column}`)";

        $replaceList = [
            'KABUPATEN ',
            'KAB. ',
            'KAB ',
            'KOTA ',
            'KECAMATAN ',
            'KEC. ',
            'KEC ',
            'KELURAHAN ',
            'KEL. ',
            'KEL ',
            'DESA ',
            'DS. ',
            'DS ',
            ' ',
            '.',
            '-',
            '/',
        ];

        foreach ($replaceList as $item) {
            $safeItem = str_replace("'", "''", $item);
            $expression = "REPLACE({$expression}, '{$safeItem}', '')";
        }

        return "TRIM({$expression})";
    }

    /*
    |--------------------------------------------------------------------------
    | MENGUBAH NILAI MENJADI ANGKA
    |--------------------------------------------------------------------------
    */
    private function parseNumber($value): int
    {
        $value = trim((string) $value);

        if ($value === '' || $value === '-') {
            return 0;
        }

        $value = preg_replace('/[^0-9\-]/', '', $value);

        if ($value === '' || $value === '-') {
            return 0;
        }

        return (int) $value;
    }

    /*
    |--------------------------------------------------------------------------
    | MENCARI DATA KABUPATEN
    |--------------------------------------------------------------------------
    */
    private function findKabupaten(?string $kode, ?string $nama): ?Kabupaten
    {
        return $this->findModelByCodeOrName(
            modelClass: Kabupaten::class,
            tableName: 'kabupatens',
            code: $kode,
            codeColumns: ['kode_kabupaten', 'kode', 'kode_wilayah'],
            name: $nama,
            nameColumns: ['nama_kabupaten', 'nama', 'nama_wilayah']
        );
    }

    /*
    |--------------------------------------------------------------------------
    | MENCARI DATA KECAMATAN
    |--------------------------------------------------------------------------
    */
    private function findKecamatan(?string $kode, ?string $nama, ?int $kabupatenId): ?Kecamatan
    {
        return $this->findModelByCodeOrName(
            modelClass: Kecamatan::class,
            tableName: 'kecamatans',
            code: $kode,
            codeColumns: ['kode_kecamatan', 'kode', 'kode_wilayah'],
            name: $nama,
            nameColumns: ['nama_kecamatan', 'nama', 'nama_wilayah'],
            parentColumn: 'kabupaten_id',
            parentId: $kabupatenId
        );
    }

    /*
    |--------------------------------------------------------------------------
    | MENCARI DATA DESA
    |--------------------------------------------------------------------------
    */
    private function findDesa(?string $kode, ?string $nama, ?int $kecamatanId): ?Desa
    {
        return $this->findModelByCodeOrName(
            modelClass: Desa::class,
            tableName: 'desas',
            code: $kode,
            codeColumns: ['kode_desa', 'kode', 'kode_wilayah'],
            name: $nama,
            nameColumns: ['nama_desa', 'nama', 'nama_wilayah'],
            parentColumn: 'kecamatan_id',
            parentId: $kecamatanId
        );
    }

    /*
    |--------------------------------------------------------------------------
    | MENCARI DESA DALAM KABUPATEN
    |--------------------------------------------------------------------------
    */
    private function findDesaInsideKabupaten(?string $namaDesa, int $kabupatenId): ?Desa
    {
        if (!$namaDesa) {
            return null;
        }

        $normalizedTarget = $this->normalizeNameForSearch($namaDesa);
        $nameColumns = ['nama_desa', 'nama', 'nama_wilayah'];

        foreach ($nameColumns as $column) {
            if (!Schema::hasColumn('desas', $column)) {
                continue;
            }

            $desa = Desa::query()
                ->with('kecamatan')
                ->whereHas('kecamatan', function ($query) use ($kabupatenId) {
                    $query->where('kabupaten_id', $kabupatenId);
                })
                ->whereRaw(
                    $this->normalizedNameSql($column) . ' = ?',
                    [$normalizedTarget]
                )
                ->first();

            if ($desa) {
                return $desa;
            }
        }

        return $this->findDesaInsideKabupatenFuzzy($namaDesa, $kabupatenId);
    }

    /*
    |--------------------------------------------------------------------------
    | MENCARI DESA DENGAN KEMIRIPAN NAMA
    |--------------------------------------------------------------------------
    */
    private function findDesaInsideKabupatenFuzzy(?string $namaDesa, int $kabupatenId): ?Desa
    {
        if (!$namaDesa || !Schema::hasColumn('desas', 'nama_desa')) {
            return null;
        }

        $target = $this->normalizeNameForSearch($namaDesa);

        $candidates = Desa::query()
            ->with('kecamatan')
            ->whereHas('kecamatan', function ($query) use ($kabupatenId) {
                $query->where('kabupaten_id', $kabupatenId);
            })
            ->get();

        $bestMatch = null;
        $bestScore = 999;

        foreach ($candidates as $candidate) {
            $candidateName = $this->normalizeNameForSearch($candidate->nama_desa ?? '');

            if (!$candidateName) {
                continue;
            }

            if ($candidateName === $target) {
                return $candidate;
            }

            $distance = levenshtein($target, $candidateName);

            if ($distance < $bestScore) {
                $bestScore = $distance;
                $bestMatch = $candidate;
            }
        }

        if ($bestMatch && $bestScore <= 2) {
            return $bestMatch;
        }

        return null;
    }

    /*
    |--------------------------------------------------------------------------
    | MEMBUAT DESA DARI DATA EXCEL
    |--------------------------------------------------------------------------
    */
    private function createMissingDesaFromExcel(?string $kodeDesa, string $namaDesa, int $kecamatanId): ?Desa
    {
        if (!Schema::hasTable('desas')) {
            return null;
        }

        $payload = [
            'nama_desa' => $namaDesa,
            'kecamatan_id' => $kecamatanId,
        ];

        if (Schema::hasColumn('desas', 'kode_desa')) {
            $payload['kode_desa'] = $kodeDesa;
        }

        if (Schema::hasColumn('desas', 'geojson')) {
            $payload['geojson'] = null;
        }

        if (Schema::hasColumn('desas', 'created_at')) {
            $payload['created_at'] = now();
        }

        if (Schema::hasColumn('desas', 'updated_at')) {
            $payload['updated_at'] = now();
        }

        $id = DB::table('desas')->insertGetId($payload);

        return Desa::find($id);
    }

    /*
    |--------------------------------------------------------------------------
    | MENCARI MODEL BERDASARKAN KODE ATAU NAMA
    |--------------------------------------------------------------------------
    */
    private function findModelByCodeOrName(
        string $modelClass,
        string $tableName,
        ?string $code,
        array $codeColumns,
        ?string $name,
        array $nameColumns,
        ?string $parentColumn = null,
        ?int $parentId = null
    ): ?Model {
        $result = $this->searchByCode(
            modelClass: $modelClass,
            tableName: $tableName,
            code: $code,
            codeColumns: $codeColumns,
            parentColumn: $parentColumn,
            parentId: $parentId
        );

        if ($result) {
            return $result;
        }

        $result = $this->searchByName(
            modelClass: $modelClass,
            tableName: $tableName,
            name: $name,
            nameColumns: $nameColumns,
            parentColumn: $parentColumn,
            parentId: $parentId
        );

        if ($result) {
            return $result;
        }

        /*
        |--------------------------------------------------------------------------
        | PENCARIAN CADANGAN TANPA INDUK
        |--------------------------------------------------------------------------
        */
        if ($parentColumn && $parentId) {
            $result = $this->searchByCode(
                modelClass: $modelClass,
                tableName: $tableName,
                code: $code,
                codeColumns: $codeColumns,
                parentColumn: null,
                parentId: null
            );

            if ($result) {
                return $result;
            }

            $result = $this->searchByName(
                modelClass: $modelClass,
                tableName: $tableName,
                name: $name,
                nameColumns: $nameColumns,
                parentColumn: null,
                parentId: null
            );

            if ($result) {
                return $result;
            }
        }

        return null;
    }

    /*
    |--------------------------------------------------------------------------
    | MENCARI DATA BERDASARKAN KODE
    |--------------------------------------------------------------------------
    */
    private function searchByCode(
        string $modelClass,
        string $tableName,
        ?string $code,
        array $codeColumns,
        ?string $parentColumn = null,
        ?int $parentId = null
    ): ?Model {
        if (!$code) {
            return null;
        }

        foreach ($codeColumns as $column) {
            if (!Schema::hasColumn($tableName, $column)) {
                continue;
            }

            $query = $modelClass::query();

            if ($parentColumn && $parentId && Schema::hasColumn($tableName, $parentColumn)) {
                $query->where($parentColumn, $parentId);
            }

            /*
            |--------------------------------------------------------------------------
            | MENORMALISASI KOLOM KODE
            |--------------------------------------------------------------------------
            */
            $normalizedColumn = "REPLACE(REPLACE(REPLACE(CAST(`{$column}` AS CHAR), '.', ''), '-', ''), ' ', '')";

            $query->where(function ($q) use ($normalizedColumn, $code) {
                $q->whereRaw("{$normalizedColumn} = ?", [$code]);

                if (strlen($code) >= 2) {
                    $q->orWhereRaw("{$normalizedColumn} LIKE ?", ['%' . $code]);
                }
            });

            $result = $query->first();

            if ($result) {
                return $result;
            }
        }

        return null;
    }

    /*
    |--------------------------------------------------------------------------
    | MENCARI DATA BERDASARKAN NAMA
    |--------------------------------------------------------------------------
    */
    private function searchByName(
        string $modelClass,
        string $tableName,
        ?string $name,
        array $nameColumns,
        ?string $parentColumn = null,
        ?int $parentId = null
    ): ?Model {
        if (!$name) {
            return null;
        }

        $normalizedTarget = $this->normalizeNameForSearch($name);

        foreach ($nameColumns as $column) {
            if (!Schema::hasColumn($tableName, $column)) {
                continue;
            }

            $query = $modelClass::query();

            if ($parentColumn && $parentId && Schema::hasColumn($tableName, $parentColumn)) {
                $query->where($parentColumn, $parentId);
            }

            $query->whereRaw(
                $this->normalizedNameSql($column) . ' = ?',
                [$normalizedTarget]
            );

            $result = $query->first();

            if ($result) {
                return $result;
            }
        }

        return null;
    }
}