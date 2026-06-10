<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class SplitSemarangGeoJSON extends Command
{
    /*
    |--------------------------------------------------------------------------
    | NAMA COMMAND ARTISAN
    |--------------------------------------------------------------------------
    */
    protected $signature = 'geojson:split-semarang';

    /*
    |--------------------------------------------------------------------------
    | DESKRIPSI COMMAND
    |--------------------------------------------------------------------------
    */
    protected $description = 'Memecah GeoJSON Kota Semarang menjadi file kecamatan dan desa';

    /*
    |--------------------------------------------------------------------------
    | PROSES UTAMA COMMAND
    |--------------------------------------------------------------------------
    */
    public function handle(): void
    {
        /*
        |--------------------------------------------------------------------------
        | MENENTUKAN FILE SUMBER GEOJSON
        |--------------------------------------------------------------------------
        */
        $sourcePath = public_path('data/kabupaten/kota-semarang.geojson');

        /*
        |--------------------------------------------------------------------------
        | VALIDASI FILE SUMBER
        |--------------------------------------------------------------------------
        */
        if (!file_exists($sourcePath)) {
            $this->error('File kota-semarang.geojson tidak ditemukan!');
            $this->line('Pastikan file ada di: public/data/kabupaten/kota-semarang.geojson');
            return;
        }

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
        if (!$json || !isset($json['features'])) {
            $this->error('Format GeoJSON tidak valid!');
            return;
        }

        /*
        |--------------------------------------------------------------------------
        | MENENTUKAN DIREKTORI OUTPUT
        |--------------------------------------------------------------------------
        */
        $kecamatanDir = public_path('data/kecamatan');
        $desaDir = public_path('data/desa');

        /*
        |--------------------------------------------------------------------------
        | MEMBUAT FOLDER KECAMATAN
        |--------------------------------------------------------------------------
        */
        if (!is_dir($kecamatanDir)) {
            mkdir($kecamatanDir, 0777, true);
        }

        /*
        |--------------------------------------------------------------------------
        | MEMBUAT FOLDER DESA
        |--------------------------------------------------------------------------
        */
        if (!is_dir($desaDir)) {
            mkdir($desaDir, 0777, true);
        }

        /*
        |--------------------------------------------------------------------------
        | MENYIAPKAN PENAMPUNG DATA
        |--------------------------------------------------------------------------
        */
        $kecamatanData = [];
        $desaData = [];

        /*
        |--------------------------------------------------------------------------
        | MEMPROSES SETIAP FEATURE GEOJSON
        |--------------------------------------------------------------------------
        */
        foreach ($json['features'] as $feature) {
            $properties = $feature['properties'] ?? [];

            /*
            |--------------------------------------------------------------------------
            | MENGAMBIL NAMA KECAMATAN DAN DESA
            |--------------------------------------------------------------------------
            */
            $subDistrict = $properties['sub_district'] ?? null;
            $village = $properties['village'] ?? null;

            /*
            |--------------------------------------------------------------------------
            | MELEWATI DATA TIDAK LENGKAP
            |--------------------------------------------------------------------------
            */
            if (!$subDistrict || !$village) {
                continue;
            }

            /*
            |--------------------------------------------------------------------------
            | MEMBUAT KEY NAMA FILE
            |--------------------------------------------------------------------------
            */
            $kecamatanKey = $this->slug($subDistrict);
            $desaKey = $this->slug($village);

            /*
            |--------------------------------------------------------------------------
            | MENYIAPKAN DATA KECAMATAN
            |--------------------------------------------------------------------------
            */
            if (!isset($kecamatanData[$kecamatanKey])) {
                $kecamatanData[$kecamatanKey] = [
                    'type' => 'FeatureCollection',
                    'features' => []
                ];
            }

            /*
            |--------------------------------------------------------------------------
            | MENYIAPKAN DATA DESA
            |--------------------------------------------------------------------------
            */
            if (!isset($desaData[$desaKey])) {
                $desaData[$desaKey] = [
                    'type' => 'FeatureCollection',
                    'features' => []
                ];
            }

            /*
            |--------------------------------------------------------------------------
            | MENAMBAHKAN FEATURE KE DATA WILAYAH
            |--------------------------------------------------------------------------
            */
            $kecamatanData[$kecamatanKey]['features'][] = $feature;
            $desaData[$desaKey]['features'][] = $feature;
        }

        /*
        |--------------------------------------------------------------------------
        | MENYIMPAN FILE KECAMATAN
        |--------------------------------------------------------------------------
        */
        foreach ($kecamatanData as $filename => $data) {
            file_put_contents(
                $kecamatanDir . '/' . $filename . '.geojson',
                json_encode($data, JSON_UNESCAPED_UNICODE)
            );
        }

        /*
        |--------------------------------------------------------------------------
        | MENYIMPAN FILE DESA
        |--------------------------------------------------------------------------
        */
        foreach ($desaData as $filename => $data) {
            file_put_contents(
                $desaDir . '/' . $filename . '.geojson',
                json_encode($data, JSON_UNESCAPED_UNICODE)
            );
        }

        /*
        |--------------------------------------------------------------------------
        | MENAMPILKAN HASIL PROSES
        |--------------------------------------------------------------------------
        */
        $this->info('✅ Split GeoJSON Semarang berhasil!');
        $this->line('Total kecamatan dibuat: ' . count($kecamatanData));
        $this->line('Total desa dibuat: ' . count($desaData));
    }

    /*
    |--------------------------------------------------------------------------
    | MEMBUAT SLUG NAMA FILE
    |--------------------------------------------------------------------------
    */
    private function slug(string $text): string
    {
        $text = strtolower($text);
        $text = str_replace(' ', '-', $text);
        $text = preg_replace('/[^a-z0-9\-]/', '', $text);

        return $text;
    }
}
