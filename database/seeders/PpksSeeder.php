<?php

namespace Database\Seeders;

use App\Models\Kabupaten;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PpksSeeder extends Seeder
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
        | RESET DATA PPKS
        |--------------------------------------------------------------------------
        */
        DB::table('ppks')->truncate();

        /*
        |--------------------------------------------------------------------------
        | DATA JENIS PPKS
        |--------------------------------------------------------------------------
        */
        $jenisList = [
            'Anak Balita Terlantar (ABT)',
            'Anak Terlantar (AT)',
            'Anak yang Mengalami Masalah Hukum (AMH)',
            'Anak Jalanan (AJ)',
            'Anak Dengan Kedisabilitasan',
            'Anak yang menjadi korban Tindak kekerasan',
            'Anak yang Memerlukan Perlindungan Khusus',
            'Lanjut Usia Terlantar',
            'Penyandang Disabilitas',
            'Tuna Susila (TS)',
        ];

        /*
        |--------------------------------------------------------------------------
        | DATA TAHUN PPKS
        |--------------------------------------------------------------------------
        */
        $tahunList = [
            2015, 2016, 2017, 2018, 2019, 2020,
            2021, 2022, 2023, 2024, 2025
        ];

        /*
        |--------------------------------------------------------------------------
        | AMBIL DATA KABUPATEN
        |--------------------------------------------------------------------------
        */
        $kabupatenIds = Kabupaten::query()
            ->pluck('id')
            ->toArray();

        /*
        |--------------------------------------------------------------------------
        | VALIDASI DATA KABUPATEN
        |--------------------------------------------------------------------------
        */
        if (empty($kabupatenIds)) {
            $this->command->warn('⚠️ Tabel kabupatens masih kosong. Jalankan php artisan import:jateng dulu.');
            return;
        }

        /*
        |--------------------------------------------------------------------------
        | SIAPKAN DATA INSERT
        |--------------------------------------------------------------------------
        */
        $rows = [];

        /*
        |--------------------------------------------------------------------------
        | GENERATE DATA PPKS
        |--------------------------------------------------------------------------
        */
        foreach ($jenisList as $jenis) {
            foreach ($tahunList as $tahun) {
                foreach ($kabupatenIds as $kabupatenId) {
                    $rows[] = [
                        'kabupaten_id' => $kabupatenId,
                        'jenis_ppks'   => $jenis,
                        'tahun'        => $tahun,
                        'jumlah'       => rand(100, 200000),
                        'created_at'   => now(),
                        'updated_at'   => now(),
                    ];
                }
            }
        }

        /*
        |--------------------------------------------------------------------------
        | SIMPAN DATA BATCH
        |--------------------------------------------------------------------------
        */
        foreach (array_chunk($rows, 500) as $chunk) {
            DB::table('ppks')->insert($chunk);
        }

        /*
        |--------------------------------------------------------------------------
        | INFO HASIL SEEDER
        |--------------------------------------------------------------------------
        */
        $this->command->info('✅ Data PPKS berhasil di-seed! (' . count($rows) . ' data)');
    }
}
