<?php

namespace App\Console\Commands;

use App\Models\Kabupaten;
use App\Models\Kecamatan;
use App\Models\Desa;
use Illuminate\Console\Command;

class SplitJatengGeoJSON extends Command
{
    /*
    |--------------------------------------------------------------------------
    | NAMA COMMAND ARTISAN
    |--------------------------------------------------------------------------
    */
    protected $signature = 'geojson:split-jateng';

    /*
    |--------------------------------------------------------------------------
    | DESKRIPSI COMMAND
    |--------------------------------------------------------------------------
    */
    protected $description = 'Memecah GeoJSON Jawa Tengah menjadi file kabupaten, kecamatan, dan desa';

    /*
    |--------------------------------------------------------------------------
    | MENYESUAIKAN ALIAS KECAMATAN
    |--------------------------------------------------------------------------
    */
    private array $aliasKecamatan = [
        'KABUPATEN BANJARNEGARA|PURWOREJA KLAMPOK' => 'PURWAREJA KLAMPOK',
        'KABUPATEN KENDAL|PAGERUYUNG' => 'PAGERUYUNG',
        'KABUPATEN PEKALONGAN|PETUNGKRIYONO' => 'PETUNGKRIONO',
    ];

    /*
    |--------------------------------------------------------------------------
    | MENYESUAIKAN ALIAS DESA
    |--------------------------------------------------------------------------
    */
    private array $aliasDesa = [
        'NUSAWUNGU|PURWODADI' => 'PURWADADI',
        'MAOS|PANISIHAN' => 'PANISIHAN',
        'JERUKLEGI|MANDALA' => 'MANDALA',
        'KARANGPUCUNG|PANGAWAREN' => 'PANGAWAREN',
        'PATIMUAN|PURWADADI' => 'PURWODADI',
        'CILACAP SELATAN|TEGALREJA' => 'TEGALREJA',
        'WANGON|PENGADEGAN' => 'PENGADEGAN',
        'PATIKRAJA|SOKAWERA' => 'SOKAWERA',
        'KARANGLEWAS|KARANGGUDE' => 'KARANGGUDE KULON',
        'BATURRADEN|KARANGSALAM  LOR' => 'KARANGSALAM LOR',

        'KEMANGKON|PELUMUTAN' => 'PELUMUTAN',
        'SUSUKAN|PENARUSAN WETAN' => 'PENARUSAN WETAN',
        'SUSUKAN|PENARUSAN KULON' => 'PENARUSAN KULON',
        'PEJAWARAN|TLAHAP' => 'TLAHAB',
        'PEJAWARAN|DARMAYASA' => 'DARMAYASA',
        'BATUR|PASURENAN' => 'PASURENAN',
        'PURING|BANJAREJO' => 'BANJAREJO',
        'KUTOWINANGUN|TANJUNGSETO' => 'TANJUNGSETO',
        'ALIAN|KEMANGGUAN' => 'KEMANGGUAN',
        'PEJAGOAN|KEWAYUHAN' => 'KEWAYUHAN',

        'SRUWENG|SIDOARJO' => 'SIDOARJO',
        'ADIMULYO|TAMBAHARJO' => 'TAMBAHARJO',
        'ADIMULYO|SIDOMULYO' => 'SIDOMULYO',
        'ADIMULYO|SIDOMUKTI' => 'SIDOMUKTI',
        'KUWARASAN|BANJAREJO' => 'BANJAREJO',
        'KUWARASAN|JATIMULYO' => 'JATIMULYO',
        'SEMPOR|JATINEGARA' => 'JATINEGARA',
        'SEMPOR|DONOREJO' => 'DONOROJO',
        'PADURESO|KALIGUBUG' => 'KALIGUBUG',
        'NGOMBOL|SUMBERREJO' => 'SUMBERREJO',

        'PURWODADI|SUMBERREJO' => 'SUMBERREJO',
        'KALIGESING|SUMOWONO' => 'SUMOWONO',
        'KUTOARJO|TUNTUNGPAIT' => 'TUNTUNGPAIT',
        'BUTUH|PANGGELDLANGU' => 'PANGGELDLANGU',
        'KEMIRI|BEDONO KARANGDUWUR' => 'BEDONO KARANGDUWUR',
        'KEMIRI|SUKOGELAP' => 'SUKOGELAP',
        'KALIKAJAR|BUTUH LOR' => 'BUTUH LOR',
        'KERTEK|DAMARKASIHAN' => 'DAMARKASIHAN',
        'WONOSOBO|BUMIROSO' => 'BUMIROSO',
        'TEGALREJO|DONOREJO' => 'DONOROJO',

        'SECANG|MADYOCONDRO' => 'MADYOCONDRO',
        'AMPEL|NGARGOLOKA' => 'NGARGOLOKA',
        'BOYOLALI|SIWODIPURAN' => 'SISWODIPURAN',
        'POLANHARJO|KAHUMAN' => 'KAHUMAN',
        'GIRIWOYO|PIDEKSO' => 'PIDEKSO',
        'EROMOKO|SINDUKARTO' => 'SINDUKARTO',
        'WURYANTORO|MOJOPURO' => 'MOJOPURO',
        'JATIROTO|MOJOPURO' => 'MOJOPURO',
        'GIRIMARTO|SIDOKARTO' => 'SIDOKARTO',
        'GIRIMARTO|SEMAGAR' => 'SEMAGAR',
    ];

    /*
    |--------------------------------------------------------------------------
    | PROSES UTAMA COMMAND
    |--------------------------------------------------------------------------
    */
    public function handle(): void
    {
        /*
        |--------------------------------------------------------------------------
        | MENGATUR RESOURCE SERVER
        |--------------------------------------------------------------------------
        */
        ini_set('memory_limit', '-1');
        set_time_limit(0);

        /*
        |--------------------------------------------------------------------------
        | MENENTUKAN LOKASI FILE SUMBER
        |--------------------------------------------------------------------------
        */
        $sourcePath = storage_path('app/geojson/jawa-tengah.geojson');

        /*
        |--------------------------------------------------------------------------
        | VALIDASI FILE SUMBER
        |--------------------------------------------------------------------------
        */
        if (!file_exists($sourcePath)) {
            $this->error('File jawa-tengah.geojson tidak ditemukan!');
            $this->line('Letakkan file di: storage/app/geojson/jawa-tengah.geojson');
            return;
        }

        $this->info('🚀 Membaca file jawa-tengah.geojson...');

        /*
        |--------------------------------------------------------------------------
        | MEMBACA FILE GEOJSON
        |--------------------------------------------------------------------------
        */
        $json = json_decode(file_get_contents($sourcePath), true);

        /*
        |--------------------------------------------------------------------------
        | VALIDASI FORMAT GEOJSON
        |--------------------------------------------------------------------------
        */
        if (!$json || !isset($json['features']) || !is_array($json['features'])) {
            $this->error('Format GeoJSON tidak valid!');
            return;
        }

        $this->info('✅ File terbaca. Total fitur: ' . count($json['features']));

        /*
        |--------------------------------------------------------------------------
        | MENENTUKAN DIREKTORI OUTPUT
        |--------------------------------------------------------------------------
        */
        $kabupatenDir = public_path('data/kabupaten');
        $kecamatanDir = public_path('data/kecamatan');
        $desaDir = public_path('data/desa');

        /*
        |--------------------------------------------------------------------------
        | MEMBUAT FOLDER OUTPUT
        |--------------------------------------------------------------------------
        */
        $this->makeDir($kabupatenDir);
        $this->makeDir($kecamatanDir);
        $this->makeDir($desaDir);

        /*
        |--------------------------------------------------------------------------
        | MEMUAT DATA DARI DATABASE
        |--------------------------------------------------------------------------
        */
        $kabupatens = Kabupaten::all();
        $kecamatans = Kecamatan::all()->groupBy('kabupaten_id');
        $desas = Desa::all()->groupBy('kecamatan_id');

        /*
        |--------------------------------------------------------------------------
        | MENYIAPKAN PENAMPUNG HASIL SPLIT
        |--------------------------------------------------------------------------
        */
        $kabupatenFiles = [];
        $kecamatanFiles = [];
        $desaFiles = [];

        /*
        |--------------------------------------------------------------------------
        | MENYIAPKAN DATA TIDAK MATCH
        |--------------------------------------------------------------------------
        */
        $unmatchedKabupaten = [];
        $unmatchedKecamatan = [];
        $unmatchedDesa = [];

        /*
        |--------------------------------------------------------------------------
        | MENYIAPKAN DATA DESA OTOMATIS
        |--------------------------------------------------------------------------
        */
        $createdMissingDesa = [];

        /*
        |--------------------------------------------------------------------------
        | MEMPROSES SETIAP FEATURE GEOJSON
        |--------------------------------------------------------------------------
        */
        foreach ($json['features'] as $feature) {
            $props = $feature['properties'] ?? [];

            /*
            |--------------------------------------------------------------------------
            | MENORMALISASI DATA PROPERTIES
            |--------------------------------------------------------------------------
            */
            $province = $this->normalize($props['province'] ?? '');
            $district = $this->normalize($props['district'] ?? '');
            $subDistrict = $this->normalize($props['sub_district'] ?? '');
            $village = $this->normalize($props['village'] ?? '');

            /*
            |--------------------------------------------------------------------------
            | MEMFILTER DATA PROVINSI
            |--------------------------------------------------------------------------
            */
            if ($province !== 'JAWA TENGAH') {
                continue;
            }

            /*
            |--------------------------------------------------------------------------
            | VALIDASI DATA WILAYAH
            |--------------------------------------------------------------------------
            */
            if (!$district || !$subDistrict || !$village) {
                continue;
            }

            /*
            |--------------------------------------------------------------------------
            | MENCOCOKKAN KABUPATEN ATAU KOTA
            |--------------------------------------------------------------------------
            */
            $kabupaten = $kabupatens->first(function ($item) use ($district) {
                return $this->sameKabupatenName($item->nama_kabupaten, $district);
            });

            /*
            |--------------------------------------------------------------------------
            | MENCATAT KABUPATEN TIDAK MATCH
            |--------------------------------------------------------------------------
            */
            if (!$kabupaten) {
                $unmatchedKabupaten[$district] = true;
                continue;
            }

            /*
            |--------------------------------------------------------------------------
            | MENYIAPKAN FILE KABUPATEN
            |--------------------------------------------------------------------------
            */
            $kabupatenFileName = $this->slugFullName($kabupaten->nama_kabupaten) . '.geojson';
            $kabupatenPublicPath = 'data/kabupaten/' . $kabupatenFileName;

            if (!isset($kabupatenFiles[$kabupaten->id])) {
                $kabupatenFiles[$kabupaten->id] = [
                    'path' => $kabupatenDir . '/' . $kabupatenFileName,
                    'public_path' => $kabupatenPublicPath,
                    'data' => [
                        'type' => 'FeatureCollection',
                        'features' => []
                    ],
                    'aliases' => $this->kabupatenAliases($kabupaten->nama_kabupaten, $kabupatenDir)
                ];
            }

            /*
            |--------------------------------------------------------------------------
            | MENAMBAHKAN FEATURE KE KABUPATEN
            |--------------------------------------------------------------------------
            */
            $kabupatenFiles[$kabupaten->id]['data']['features'][] = $feature;

            /*
            |--------------------------------------------------------------------------
            | MENCOCOKKAN DATA KECAMATAN
            |--------------------------------------------------------------------------
            */
            $candidateKecamatans = $kecamatans->get($kabupaten->id, collect());

            $kecamatan = $this->findKecamatanMatch(
                $candidateKecamatans,
                $kabupaten->nama_kabupaten,
                $subDistrict
            );

            /*
            |--------------------------------------------------------------------------
            | MENCATAT KECAMATAN TIDAK MATCH
            |--------------------------------------------------------------------------
            */
            if (!$kecamatan) {
                $unmatchedKecamatan[$kabupaten->nama_kabupaten . ' / ' . $subDistrict] = true;
                continue;
            }

            /*
            |--------------------------------------------------------------------------
            | MENYIAPKAN FILE KECAMATAN
            |--------------------------------------------------------------------------
            */
            $kecamatanFileName = $this->slugCode($kecamatan->kode_kecamatan) . '.geojson';
            $kecamatanPublicPath = 'data/kecamatan/' . $kecamatanFileName;

            if (!isset($kecamatanFiles[$kecamatan->id])) {
                $kecamatanFiles[$kecamatan->id] = [
                    'path' => $kecamatanDir . '/' . $kecamatanFileName,
                    'public_path' => $kecamatanPublicPath,
                    'data' => [
                        'type' => 'FeatureCollection',
                        'features' => []
                    ],
                    'aliases' => [
                        $kecamatanDir . '/' . $this->slugSimpleName($kecamatan->nama_kecamatan) . '.geojson',
                        $kecamatanDir . '/' . $this->slugSimpleName($subDistrict) . '.geojson',
                    ]
                ];
            }

            /*
            |--------------------------------------------------------------------------
            | MENAMBAHKAN FEATURE KE KECAMATAN
            |--------------------------------------------------------------------------
            */
            $kecamatanFiles[$kecamatan->id]['data']['features'][] = $feature;

            /*
            |--------------------------------------------------------------------------
            | MENCOCOKKAN DATA DESA
            |--------------------------------------------------------------------------
            */
            $candidateDesas = $desas->get($kecamatan->id, collect());

            $desa = $this->findDesaMatch(
                $candidateDesas,
                $kecamatan->nama_kecamatan,
                $village
            );

            /*
            |--------------------------------------------------------------------------
            | MEMBUAT DESA OTOMATIS
            |--------------------------------------------------------------------------
            */
            if (!$desa) {
                $desa = $this->createMissingDesaFromGeoJson($kecamatan, $village);

                if (!$desa) {
                    $unmatchedDesa[$kecamatan->nama_kecamatan . ' / ' . $village] = true;
                    continue;
                }

                /*
                |--------------------------------------------------------------------------
                | MEMUAT ULANG DATA DESA
                |--------------------------------------------------------------------------
                */
                $desas = Desa::all()->groupBy('kecamatan_id');
                $createdMissingDesa[$kecamatan->nama_kecamatan . ' / ' . $desa->nama_desa] = true;
            }

            /*
            |--------------------------------------------------------------------------
            | MENYIAPKAN FILE DESA
            |--------------------------------------------------------------------------
            */
            $desaFileName = $this->slugCode($desa->kode_desa) . '.geojson';
            $desaPublicPath = 'data/desa/' . $desaFileName;

            if (!isset($desaFiles[$desa->id])) {
                $desaFiles[$desa->id] = [
                    'path' => $desaDir . '/' . $desaFileName,
                    'public_path' => $desaPublicPath,
                    'data' => [
                        'type' => 'FeatureCollection',
                        'features' => []
                    ],
                    'aliases' => [
                        $desaDir . '/' . $this->slugSimpleName($desa->nama_desa) . '.geojson',
                        $desaDir . '/' . $this->slugSimpleName($village) . '.geojson',
                    ]
                ];
            }

            /*
            |--------------------------------------------------------------------------
            | MENAMBAHKAN FEATURE KE DESA
            |--------------------------------------------------------------------------
            */
            $desaFiles[$desa->id]['data']['features'][] = $feature;
        }

        /*
        |--------------------------------------------------------------------------
        | MENYIMPAN FILE KABUPATEN
        |--------------------------------------------------------------------------
        */
        $this->info('💾 Menyimpan file kabupaten...');

        foreach ($kabupatenFiles as $kabupatenId => $file) {
            $this->saveGeoJsonFile($file['path'], $file['data']);

            foreach ($file['aliases'] as $aliasPath) {
                $this->saveGeoJsonFile($aliasPath, $file['data']);
            }

            Kabupaten::where('id', $kabupatenId)->update([
                'geojson_path' => $file['public_path']
            ]);
        }

        /*
        |--------------------------------------------------------------------------
        | MENYIMPAN FILE KECAMATAN
        |--------------------------------------------------------------------------
        */
        $this->info('💾 Menyimpan file kecamatan...');

        foreach ($kecamatanFiles as $kecamatanId => $file) {
            $this->saveGeoJsonFile($file['path'], $file['data']);

            foreach ($file['aliases'] as $aliasPath) {
                $this->saveGeoJsonFile($aliasPath, $file['data']);
            }

            Kecamatan::where('id', $kecamatanId)->update([
                'geojson_path' => $file['public_path']
            ]);
        }

        /*
        |--------------------------------------------------------------------------
        | MENYIMPAN FILE DESA
        |--------------------------------------------------------------------------
        */
        $this->info('💾 Menyimpan file desa...');

        foreach ($desaFiles as $desaId => $file) {
            $this->saveGeoJsonFile($file['path'], $file['data']);

            foreach ($file['aliases'] as $aliasPath) {
                $this->saveGeoJsonFile($aliasPath, $file['data']);
            }

            Desa::where('id', $desaId)->update([
                'geojson_path' => $file['public_path']
            ]);
        }

        /*
        |--------------------------------------------------------------------------
        | MENAMPILKAN HASIL PROSES
        |--------------------------------------------------------------------------
        */
        $this->newLine();

        $this->info('🎉 Split GeoJSON Jawa Tengah selesai!');
        $this->line('Kabupaten dibuat : ' . count($kabupatenFiles));
        $this->line('Kecamatan dibuat : ' . count($kecamatanFiles));
        $this->line('Desa dibuat      : ' . count($desaFiles));

        /*
        |--------------------------------------------------------------------------
        | MENAMPILKAN LAPORAN DESA OTOMATIS
        |--------------------------------------------------------------------------
        */
        if (count($createdMissingDesa) > 0) {
            $this->newLine();
            $this->warn('Desa baru dibuat otomatis dari GeoJSON: ' . count($createdMissingDesa));
            foreach (array_slice(array_keys($createdMissingDesa), 0, 50) as $name) {
                $this->line('- ' . $name);
            }
        }

        $this->newLine();

        /*
        |--------------------------------------------------------------------------
        | MENAMPILKAN DATA TIDAK MATCH
        |--------------------------------------------------------------------------
        */
        if (count($unmatchedKabupaten) > 0) {
            $this->warn('Kabupaten tidak match: ' . count($unmatchedKabupaten));
            foreach (array_slice(array_keys($unmatchedKabupaten), 0, 30) as $name) {
                $this->line('- ' . $name);
            }
        }

        if (count($unmatchedKecamatan) > 0) {
            $this->warn('Kecamatan tidak match: ' . count($unmatchedKecamatan));
            foreach (array_slice(array_keys($unmatchedKecamatan), 0, 30) as $name) {
                $this->line('- ' . $name);
            }
        }

        if (count($unmatchedDesa) > 0) {
            $this->warn('Desa tidak match: ' . count($unmatchedDesa));
            foreach (array_slice(array_keys($unmatchedDesa), 0, 80) as $name) {
                $this->line('- ' . $name);
            }
        }

        $this->newLine();
        $this->info('Selesai. Silakan test ulang map di browser.');
    }

    /*
    |--------------------------------------------------------------------------
    | MENCARI KECAMATAN YANG COCOK
    |--------------------------------------------------------------------------
    */
    private function findKecamatanMatch($candidateKecamatans, string $kabupatenName, string $geoKecamatan)
    {
        $aliasKey = $this->normalize($kabupatenName) . '|' . $this->normalize($geoKecamatan);

        if (isset($this->aliasKecamatan[$aliasKey])) {
            $targetName = $this->aliasKecamatan[$aliasKey];

            $matched = $candidateKecamatans->first(function ($item) use ($targetName) {
                return $this->sameSimpleName($item->nama_kecamatan, $targetName);
            });

            if ($matched) {
                return $matched;
            }
        }

        $exact = $candidateKecamatans->first(function ($item) use ($geoKecamatan) {
            return $this->sameSimpleName($item->nama_kecamatan, $geoKecamatan);
        });

        if ($exact) {
            return $exact;
        }

        return $this->findClosestByName($candidateKecamatans, 'nama_kecamatan', $geoKecamatan, 2, 0.88);
    }

    /*
    |--------------------------------------------------------------------------
    | MENCARI DESA YANG COCOK
    |--------------------------------------------------------------------------
    */
    private function findDesaMatch($candidateDesas, string $kecamatanName, string $geoDesa)
    {
        $aliasKey = $this->normalize($kecamatanName) . '|' . $this->normalize($geoDesa);

        if (isset($this->aliasDesa[$aliasKey])) {
            $targetName = $this->aliasDesa[$aliasKey];

            $matched = $candidateDesas->first(function ($item) use ($targetName) {
                return $this->sameSimpleName($item->nama_desa, $targetName);
            });

            if ($matched) {
                return $matched;
            }
        }

        $exact = $candidateDesas->first(function ($item) use ($geoDesa) {
            return $this->sameSimpleName($item->nama_desa, $geoDesa);
        });

        if ($exact) {
            return $exact;
        }

        return $this->findClosestByName($candidateDesas, 'nama_desa', $geoDesa, 2, 0.86);
    }

    /*
    |--------------------------------------------------------------------------
    | MEMBUAT DESA DARI GEOJSON
    |--------------------------------------------------------------------------
    */
    private function createMissingDesaFromGeoJson(Kecamatan $kecamatan, string $geoDesa): ?Desa
    {
        $cleanName = $this->removeRegionPrefix($geoDesa);

        if (!$cleanName) {
            return null;
        }

        /*
        |--------------------------------------------------------------------------
        | MEMBUAT KODE DESA OTOMATIS
        |--------------------------------------------------------------------------
        */
        $baseKode = $this->slugCode($kecamatan->kode_kecamatan)
            . 'GEO'
            . substr(md5($this->compactName($cleanName)), 0, 6);

        $kodeDesa = $baseKode;
        $counter = 1;

        /*
        |--------------------------------------------------------------------------
        | MENGECEK DUPLIKAT KODE
        |--------------------------------------------------------------------------
        */
        while (Desa::where('kode_desa', $kodeDesa)->exists()) {
            $kodeDesa = $baseKode . $counter;
            $counter++;
        }

        /*
        |--------------------------------------------------------------------------
        | MENYIMPAN DESA BARU
        |--------------------------------------------------------------------------
        */
        return Desa::create([
            'kecamatan_id' => $kecamatan->id,
            'kode_desa' => $kodeDesa,
            'nama_desa' => $cleanName,
            'geojson_path' => 'data/desa/' . $kodeDesa . '.geojson',
        ]);
    }

    /*
    |--------------------------------------------------------------------------
    | MENCARI NAMA PALING MIRIP
    |--------------------------------------------------------------------------
    */
    private function findClosestByName($collection, string $field, string $geoName, int $maxDistance, float $minSimilarity)
    {
        $geoCompact = $this->compactName($geoName);

        if (!$geoCompact) {
            return null;
        }

        $bestItem = null;
        $bestDistance = 999;
        $bestSimilarity = 0;

        /*
        |--------------------------------------------------------------------------
        | MENGHITUNG KEMIRIPAN NAMA
        |--------------------------------------------------------------------------
        */
        foreach ($collection as $item) {
            $dbCompact = $this->compactName($item->{$field});

            if (!$dbCompact) {
                continue;
            }

            $distance = levenshtein($dbCompact, $geoCompact);

            similar_text($dbCompact, $geoCompact, $similarityPercent);
            $similarity = $similarityPercent / 100;

            if (
                $distance < $bestDistance ||
                ($distance === $bestDistance && $similarity > $bestSimilarity)
            ) {
                $bestItem = $item;
                $bestDistance = $distance;
                $bestSimilarity = $similarity;
            }
        }

        /*
        |--------------------------------------------------------------------------
        | VALIDASI HASIL FUZZY MATCH
        |--------------------------------------------------------------------------
        */
        if (
            $bestItem &&
            (
                $bestDistance <= $maxDistance ||
                $bestSimilarity >= $minSimilarity
            )
        ) {
            return $bestItem;
        }

        return null;
    }

    /*
    |--------------------------------------------------------------------------
    | MEMBUAT DIREKTORI
    |--------------------------------------------------------------------------
    */
    private function makeDir(string $path): void
    {
        if (!is_dir($path)) {
            mkdir($path, 0777, true);
        }
    }

    /*
    |--------------------------------------------------------------------------
    | MENYIMPAN FILE GEOJSON
    |--------------------------------------------------------------------------
    */
    private function saveGeoJsonFile(string $path, array $data): void
    {
        file_put_contents(
            $path,
            json_encode($data, JSON_UNESCAPED_UNICODE)
        );
    }

    /*
    |--------------------------------------------------------------------------
    | MEMBUAT SLUG DARI KODE
    |--------------------------------------------------------------------------
    */
    private function slugCode(string $code): string
    {
        return strtolower(str_replace(['.', ' '], '', $code));
    }

    /*
    |--------------------------------------------------------------------------
    | MEMBUAT SLUG DARI NAMA LENGKAP
    |--------------------------------------------------------------------------
    */
    private function slugFullName(string $text): string
    {
        $text = strtolower($text);
        $text = str_replace(['.', ','], '', $text);
        $text = preg_replace('/\s+/', '-', $text);
        $text = preg_replace('/[^a-z0-9\-]/', '', $text);

        return trim($text, '-');
    }

    /*
    |--------------------------------------------------------------------------
    | MEMBUAT SLUG DARI NAMA SEDERHANA
    |--------------------------------------------------------------------------
    */
    private function slugSimpleName(string $text): string
    {
        $text = strtolower($text);
        $text = str_replace(['kabupaten ', 'kota ', 'kecamatan ', 'desa ', 'kelurahan '], '', $text);
        $text = str_replace(['.', ',', '-', '_', '/', '\\'], ' ', $text);
        $text = preg_replace('/\s+/', '-', $text);
        $text = preg_replace('/[^a-z0-9\-]/', '', $text);

        return trim($text, '-');
    }

    /*
    |--------------------------------------------------------------------------
    | MENORMALISASI TEKS
    |--------------------------------------------------------------------------
    */
    private function normalize(string $name): string
    {
        $name = strtoupper($name);
        $name = str_replace(['.', ',', '-', '_', '/', '\\'], ' ', $name);
        $name = preg_replace('/\s+/', ' ', $name);

        return trim($name);
    }

    /*
    |--------------------------------------------------------------------------
    | MENGHAPUS PREFIX WILAYAH
    |--------------------------------------------------------------------------
    */
    private function removeRegionPrefix(string $name): string
    {
        $name = $this->normalize($name);

        $name = preg_replace('/^KABUPATEN\s+/', '', $name);
        $name = preg_replace('/^KOTA\s+/', '', $name);
        $name = preg_replace('/^KECAMATAN\s+/', '', $name);
        $name = preg_replace('/^DESA\s+/', '', $name);
        $name = preg_replace('/^KELURAHAN\s+/', '', $name);

        return trim($name);
    }

    /*
    |--------------------------------------------------------------------------
    | MERINGKAS NAMA WILAYAH
    |--------------------------------------------------------------------------
    */
    private function compactName(string $name): string
    {
        $name = $this->removeRegionPrefix($name);
        $name = preg_replace('/[^A-Z0-9]/', '', $name);

        return trim($name);
    }

    /*
    |--------------------------------------------------------------------------
    | MENENTUKAN TIPE WILAYAH
    |--------------------------------------------------------------------------
    */
    private function regionType(string $name): string
    {
        $name = $this->normalize($name);

        if (str_starts_with($name, 'KOTA ')) {
            return 'kota';
        }

        return 'kabupaten';
    }

    /*
    |--------------------------------------------------------------------------
    | MEMBANDINGKAN NAMA KABUPATEN
    |--------------------------------------------------------------------------
    */
    private function sameKabupatenName(string $dbName, string $geoName): bool
    {
        $dbType = $this->regionType($dbName);
        $geoType = $this->regionType($geoName);

        $dbSimple = $this->removeRegionPrefix($dbName);
        $geoSimple = $this->removeRegionPrefix($geoName);

        $dbCompact = $this->compactName($dbName);
        $geoCompact = $this->compactName($geoName);

        if ($dbSimple !== $geoSimple && $dbCompact !== $geoCompact) {
            return false;
        }

        if (str_starts_with($this->normalize($geoName), 'KOTA ')) {
            return $dbType === 'kota';
        }

        if (str_starts_with($this->normalize($geoName), 'KABUPATEN ')) {
            return $dbType === 'kabupaten';
        }

        return $dbType === $geoType;
    }

    /*
    |--------------------------------------------------------------------------
    | MEMBANDINGKAN NAMA SEDERHANA
    |--------------------------------------------------------------------------
    */
    private function sameSimpleName(string $dbName, string $geoName): bool
    {
        $dbSimple = $this->removeRegionPrefix($dbName);
        $geoSimple = $this->removeRegionPrefix($geoName);

        if ($dbSimple === $geoSimple) {
            return true;
        }

        return $this->compactName($dbName) === $this->compactName($geoName);
    }

    /*
    |--------------------------------------------------------------------------
    | MEMBUAT ALIAS FILE KABUPATEN
    |--------------------------------------------------------------------------
    */
    private function kabupatenAliases(string $namaKabupaten, string $kabupatenDir): array
    {
        return [
            $kabupatenDir . '/' . $this->slugFullName($namaKabupaten) . '.geojson',
            $kabupatenDir . '/' . $this->slugSimpleName($namaKabupaten) . '.geojson',
        ];
    }
}