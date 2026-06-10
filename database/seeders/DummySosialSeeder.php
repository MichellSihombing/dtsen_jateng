<?php

namespace Database\Seeders;

use App\Models\Desa;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DummySosialSeeder extends Seeder
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
        | RESET DATA DUMMY SOSIAL
        |--------------------------------------------------------------------------
        */
        DB::table('dummy_sosials')->truncate();

        /*
        |--------------------------------------------------------------------------
        | AMBIL DATA DESA
        |--------------------------------------------------------------------------
        */
        $desas = Desa::query()
            ->select('id', 'nama_desa')
            ->get();

        /*
        |--------------------------------------------------------------------------
        | CEK DATA DESA
        |--------------------------------------------------------------------------
        */
        if ($desas->isEmpty()) {
            $this->command->warn('Tabel desas masih kosong. Jalankan import:jateng dan geojson:split-jateng dulu.');
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
        | PROSES SETIAP DESA
        |--------------------------------------------------------------------------
        */
        foreach ($desas as $desa) {
            $seed = abs(crc32($desa->id . '-' . $desa->nama_desa));

            /*
            |--------------------------------------------------------------------------
            | GENERATE DATA DESIL
            |--------------------------------------------------------------------------
            */
            $desil = [];

            for ($i = 1; $i <= 10; $i++) {
                $score = ($seed + ($i * 37)) % 100;

                if ($i <= 3) {
                    $desil[$i] = $score < 45 ? (($seed + $i * 11) % 180) + 20 : 0;
                } elseif ($i <= 5) {
                    $desil[$i] = $score < 35 ? (($seed + $i * 13) % 140) + 15 : 0;
                } else {
                    $desil[$i] = $score < 25 ? (($seed + $i * 17) % 110) + 10 : 0;
                }
            }

            /*
            |--------------------------------------------------------------------------
            | GENERATE KOMPONEN KEBUTUHAN
            |--------------------------------------------------------------------------
            */
            $rlth = (($seed + 5) % 100) < 38 ? (($seed % 80) + 5) : 0;
            $air = (($seed + 11) % 100) < 34 ? (($seed % 70) + 3) : 0;
            $jamban = (($seed + 17) % 100) < 36 ? (($seed % 75) + 4) : 0;
            $listrik = (($seed + 23) % 100) < 22 ? (($seed % 45) + 2) : 0;
            $ats = (($seed + 29) % 100) < 28 ? (($seed % 60) + 3) : 0;
            $disabilitas = (($seed + 31) % 100) < 30 ? (($seed % 55) + 2) : 0;
            $tidakBekerja = (($seed + 41) % 100) < 42 ? (($seed % 140) + 12) : 0;

            /*
            |--------------------------------------------------------------------------
            | GENERATE DATA BANSOS
            |--------------------------------------------------------------------------
            */
            $pkh = (($seed + 43) % 100) < 40 ? (($seed % 160) + 20) : 0;
            $sembako = (($seed + 47) % 100) < 45 ? (($seed % 180) + 25) : 0;
            $pbi = (($seed + 53) % 100) < 48 ? (($seed % 200) + 30) : 0;

            $rows[] = [
                'desa_id' => $desa->id,

                'desil_1' => $desil[1],
                'desil_2' => $desil[2],
                'desil_3' => $desil[3],
                'desil_4' => $desil[4],
                'desil_5' => $desil[5],
                'desil_6' => $desil[6],
                'desil_7' => $desil[7],
                'desil_8' => $desil[8],
                'desil_9' => $desil[9],
                'desil_10' => $desil[10],

                'rlth' => $rlth,
                'air' => $air,
                'jamban' => $jamban,
                'listrik' => $listrik,
                'ats' => $ats,
                'disabilitas' => $disabilitas,
                'tidak_bekerja' => $tidakBekerja,

                'pkh' => $pkh,
                'sembako' => $sembako,
                'pbi' => $pbi,

                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        /*
        |--------------------------------------------------------------------------
        | SIMPAN DATA BATCH
        |--------------------------------------------------------------------------
        */
        foreach (array_chunk($rows, 500) as $chunk) {
            DB::table('dummy_sosials')->insert($chunk);
        }

        /*
        |--------------------------------------------------------------------------
        | INFO HASIL SEEDER
        |--------------------------------------------------------------------------
        */
        $this->command->info('Data dummy sosial berhasil dibuat: ' . count($rows) . ' desa.');
    }
}
