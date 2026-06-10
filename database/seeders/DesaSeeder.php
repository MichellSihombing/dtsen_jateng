<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Desa;
use App\Models\Kecamatan;

class DesaSeeder extends Seeder
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
        | AMBIL DATA KECAMATAN
        |--------------------------------------------------------------------------
        */
        $tembalang = Kecamatan::where('kode_kecamatan', '337410')->first();

        /*
        |--------------------------------------------------------------------------
        | DATA SEEDER
        |--------------------------------------------------------------------------
        */
        $data = [

            [
                'kecamatan_id' => $tembalang->id,
                'kode_desa' => '3374101001',
                'nama_desa' => 'Meteseh',
                'geojson_path' => 'data/desa/meteseh.geojson'
            ],

            [
                'kecamatan_id' => $tembalang->id,
                'kode_desa' => '3374101002',
                'nama_desa' => 'Bulusan',
                'geojson_path' => 'data/desa/bulusan.geojson'
            ],

        ];

        /*
        |--------------------------------------------------------------------------
        | SIMPAN DATA KE DATABASE
        |--------------------------------------------------------------------------
        */
        foreach ($data as $item) {
            Desa::create($item);
        }
    }
}
