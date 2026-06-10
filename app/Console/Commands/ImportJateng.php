<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Kabupaten;
use App\Models\Kecamatan;
use App\Models\Desa;

class ImportJateng extends Command
{
    /*
    |--------------------------------------------------------------------------
    | NAMA COMMAND ARTISAN
    |--------------------------------------------------------------------------
    */
    protected $signature = 'import:jateng';

    /*
    |--------------------------------------------------------------------------
    | DESKRIPSI COMMAND
    |--------------------------------------------------------------------------
    */
    protected $description = 'Import wilayah Jawa Tengah';

    /*
    |--------------------------------------------------------------------------
    | PROSES UTAMA COMMAND
    |--------------------------------------------------------------------------
    */
    public function handle()
    {
        /*
        |--------------------------------------------------------------------------
        | MENAMPILKAN INFO AWAL IMPORT
        |--------------------------------------------------------------------------
        */
        $this->info('🚀 Import Jawa Tengah dimulai...');

        /*
        |--------------------------------------------------------------------------
        | MENENTUKAN LOKASI FILE JSON
        |--------------------------------------------------------------------------
        */
        $regenciesPath = storage_path('app/import/regencies.json');

        $districtsPath = storage_path('app/import/districts.json');

        $villagesPath = storage_path('app/import/villages.json');

        /*
        |--------------------------------------------------------------------------
        | MEMBACA FILE JSON
        |--------------------------------------------------------------------------
        */
        $regencies = json_decode(file_get_contents($regenciesPath), true);

        $districts = json_decode(file_get_contents($districtsPath), true);

        $villages = json_decode(file_get_contents($villagesPath), true);

        /*
        |--------------------------------------------------------------------------
        | MENGIMPORT KABUPATEN JAWA TENGAH
        |--------------------------------------------------------------------------
        */
        foreach ($regencies as $kab) {

            /*
            |--------------------------------------------------------------------------
            | MEMFILTER PROVINSI JAWA TENGAH
            |--------------------------------------------------------------------------
            */
            if ($kab['province_id'] != '33') {
                continue;
            }

            /*
            |--------------------------------------------------------------------------
            | MENYIMPAN ATAU MEMPERBARUI KABUPATEN
            |--------------------------------------------------------------------------
            */
            Kabupaten::updateOrCreate(

                [
                    'kode_kabupaten' => $kab['id']
                ],

                [
                    'nama_kabupaten' => $kab['name'],

                    /*
                    |--------------------------------------------------------------------------
                    | MENENTUKAN PATH GEOJSON KABUPATEN
                    |--------------------------------------------------------------------------
                    */
                    'geojson_path' =>
                        'data/kabupaten/' .
                        strtolower(str_replace(' ', '-', $kab['name'])) .
                        '.geojson'
                ]
            );
        }

        /*
        |--------------------------------------------------------------------------
        | MENAMPILKAN INFO IMPORT KABUPATEN
        |--------------------------------------------------------------------------
        */
        $this->info('✅ Kabupaten berhasil diimport');

        /*
        |--------------------------------------------------------------------------
        | MENGIMPORT DATA KECAMATAN
        |--------------------------------------------------------------------------
        */
        foreach ($districts as $kec) {

            /*
            |--------------------------------------------------------------------------
            | MENCARI KABUPATEN INDUK
            |--------------------------------------------------------------------------
            */
            $kabupaten =
                Kabupaten::where(
                    'kode_kabupaten',
                    $kec['regency_id']
                )->first();

            /*
            |--------------------------------------------------------------------------
            | MELEWATI DATA TANPA KABUPATEN
            |--------------------------------------------------------------------------
            */
            if (!$kabupaten) {
                continue;
            }

            /*
            |--------------------------------------------------------------------------
            | MENYIMPAN ATAU MEMPERBARUI KECAMATAN
            |--------------------------------------------------------------------------
            */
            Kecamatan::updateOrCreate(

                [
                    'kode_kecamatan' => $kec['id']
                ],

                [
                    'kabupaten_id' => $kabupaten->id,

                    'nama_kecamatan' => $kec['name'],

                    /*
                    |--------------------------------------------------------------------------
                    | MENENTUKAN PATH GEOJSON KECAMATAN
                    |--------------------------------------------------------------------------
                    */
                    'geojson_path' =>
                        'data/kecamatan/' .
                        strtolower(str_replace(' ', '-', $kec['name'])) .
                        '.geojson'
                ]
            );
        }

        /*
        |--------------------------------------------------------------------------
        | MENAMPILKAN INFO IMPORT KECAMATAN
        |--------------------------------------------------------------------------
        */
        $this->info('✅ Kecamatan berhasil diimport');

        /*
        |--------------------------------------------------------------------------
        | MENGIMPORT DATA DESA
        |--------------------------------------------------------------------------
        */
        foreach ($villages as $desa) {

            /*
            |--------------------------------------------------------------------------
            | MENCARI KECAMATAN INDUK
            |--------------------------------------------------------------------------
            */
            $kecamatan =
                Kecamatan::where(
                    'kode_kecamatan',
                    $desa['district_id']
                )->first();

            /*
            |--------------------------------------------------------------------------
            | MELEWATI DATA TANPA KECAMATAN
            |--------------------------------------------------------------------------
            */
            if (!$kecamatan) {
                continue;
            }

            /*
            |--------------------------------------------------------------------------
            | MENYIMPAN ATAU MEMPERBARUI DESA
            |--------------------------------------------------------------------------
            */
            Desa::updateOrCreate(

                [
                    'kode_desa' => $desa['id']
                ],

                [
                    'kecamatan_id' => $kecamatan->id,

                    'nama_desa' => $desa['name'],

                    /*
                    |--------------------------------------------------------------------------
                    | MENENTUKAN PATH GEOJSON DESA
                    |--------------------------------------------------------------------------
                    */
                    'geojson_path' =>
                        'data/desa/' .
                        strtolower(str_replace(' ', '-', $desa['name'])) .
                        '.geojson'
                ]
            );
        }

        /*
        |--------------------------------------------------------------------------
        | MENAMPILKAN INFO IMPORT DESA
        |--------------------------------------------------------------------------
        */
        $this->info('✅ Desa berhasil diimport');

        /*
        |--------------------------------------------------------------------------
        | MENAMPILKAN INFO SELESAI
        |--------------------------------------------------------------------------
        */
        $this->info('🎉 IMPORT JAWA TENGAH SELESAI!');
    }
}