<?php

namespace Database\Seeders;

use App\Models\Ppks;
use App\Models\PpksKabupaten;
use App\Models\PpksJenis;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PpksRekapDataSeeder extends Seeder
{
    /**
     * Migrasi data PPKS lama ke struktur rekap baru:
     * - ppks_kabupatens untuk Rekap PPKS Per Kabupaten/Kota
     * - ppks_jenis untuk Rekap PPKS Per Jenis
     */
    public function run(): void
    {
        /*
        |--------------------------------------------------------------------------
        | REKAP PPKS PER KABUPATEN/KOTA
        |--------------------------------------------------------------------------
        */

        $rekapKabupaten = Ppks::query()
            ->select(
                'kabupaten_id',
                'tahun',
                DB::raw('SUM(jumlah) as total')
            )
            ->whereNotNull('kabupaten_id')
            ->groupBy('kabupaten_id', 'tahun')
            ->get();

        foreach ($rekapKabupaten as $row) {
            PpksKabupaten::updateOrCreate(
                [
                    'kabupaten_id' => $row->kabupaten_id,
                    'tahun' => $row->tahun,
                ],
                [
                    'jumlah' => (int) $row->total,
                ]
            );
        }

        /*
        |--------------------------------------------------------------------------
        | REKAP PPKS PER JENIS
        |--------------------------------------------------------------------------
        */

        $rekapJenis = Ppks::query()
            ->select(
                'jenis_ppks',
                'tahun',
                DB::raw('SUM(jumlah) as total')
            )
            ->whereNotNull('jenis_ppks')
            ->where('jenis_ppks', '!=', '')
            ->groupBy('jenis_ppks', 'tahun')
            ->get();

        foreach ($rekapJenis as $row) {
            PpksJenis::updateOrCreate(
                [
                    'jenis_ppks' => trim($row->jenis_ppks),
                    'tahun' => $row->tahun,
                ],
                [
                    'jumlah' => (int) $row->total,
                ]
            );
        }
    }
}