<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Kecamatan;
use App\Models\Kabupaten;

class KecamatanSeeder extends Seeder
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
        | AMBIL DATA KABUPATEN
        |--------------------------------------------------------------------------
        */
        $semarang = Kabupaten::where('kode_kabupaten', '3374')->first();

        /*
        |--------------------------------------------------------------------------
        | DATA SEEDER
        |--------------------------------------------------------------------------
        */
        $data = [

            [
                'kabupaten_id' => $semarang->id,
                'kode_kecamatan' => '337410',
                'nama_kecamatan' => 'Tembalang',
                'geojson_path' => 'data/kecamatan/tembalang.geojson'
            ],

            [
                'kabupaten_id' => $semarang->id,
                'kode_kecamatan' => '337411',
                'nama_kecamatan' => 'Banyumanik',
                'geojson_path' => 'data/kecamatan/banyumanik.geojson'
            ],

        ];

        /*
        |--------------------------------------------------------------------------
        | SIMPAN DATA KE DATABASE
        |--------------------------------------------------------------------------
        */
        foreach ($data as $item) {
            Kecamatan::create($item);
        }
    }
}
