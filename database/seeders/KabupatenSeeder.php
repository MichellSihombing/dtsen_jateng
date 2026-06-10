<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Kabupaten;

class KabupatenSeeder extends Seeder
{
   /*
   |--------------------------------------------------------------------------
   | MENJALANKAN SEEDER
   |--------------------------------------------------------------------------
   */
    public function run(): void
    {
        /*
        |--------------------------------------------------------------------------
        | DATA SEEDER
        |--------------------------------------------------------------------------
        */
        $data = [

            [
                'kode_kabupaten' => '3374',
                'nama_kabupaten' => 'Kota Semarang',
                'geojson_path' => 'data/kabupaten/semarang.geojson'
            ],

            [
                'kode_kabupaten' => '3321',
                'nama_kabupaten' => 'Kabupaten Demak',
                'geojson_path' => 'data/kabupaten/demak.geojson'
            ],

        ];

        /*
        |--------------------------------------------------------------------------
        | SIMPAN DATA KE DATABASE
        |--------------------------------------------------------------------------
        */
        foreach ($data as $item) {
            Kabupaten::create($item);
        }
    }
}
