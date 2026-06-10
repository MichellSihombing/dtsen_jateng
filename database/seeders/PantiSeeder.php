<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PantiSeeder extends Seeder
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
        | RESET DATA PANTI
        |--------------------------------------------------------------------------
        */
        DB::table('panti')->truncate();

        /*
        |--------------------------------------------------------------------------
        | DATA PANTI
        |--------------------------------------------------------------------------
        */
        $data = [
            ['nama_panti' => 'Panti Pelayanan Sosial Disabilitas Mental Ngudi Rahayu Kendal',    'kabupaten' => 'Kendal',      'kuota' => 190, 'laki_laki' => 186, 'perempuan' => 190],
            ['nama_panti' => 'Panti Pelayanan Sosial Disabilitas Mental Pangrukti Mulyo Rembang', 'kabupaten' => 'Rembang',     'kuota' => 140, 'laki_laki' => 156, 'perempuan' => 159],
            ['nama_panti' => 'Panti Pelayanan Sosial Anak Dharma Putera Purworejo',               'kabupaten' => 'Purworejo',   'kuota' => 80,  'laki_laki' => 6,   'perempuan' => 74],
            ['nama_panti' => 'Panti Pelayanan Sosial Anak Kasih Mesra Demak',                     'kabupaten' => 'Demak',       'kuota' => 80,  'laki_laki' => 0,   'perempuan' => 80],
            ['nama_panti' => 'Panti Pelayanan Sosial Anak Mardi Yuwono Wonosobo',                 'kabupaten' => 'Wonosobo',    'kuota' => 70,  'laki_laki' => 0,   'perempuan' => 70],
            ['nama_panti' => 'Panti Pelayanan Sosial Anak Suko Mulyo Tegal',                      'kabupaten' => 'Tegal',       'kuota' => 95,  'laki_laki' => 1,   'perempuan' => 94],
            ['nama_panti' => 'Panti Pelayanan Sosial Anak Taruna Yodha Sukoharjo',                'kabupaten' => 'Sukoharjo',   'kuota' => 130, 'laki_laki' => 20,  'perempuan' => 110],
            ['nama_panti' => 'Panti Pelayanan Sosial Anak Woro Wiloso Salatiga',                  'kabupaten' => 'Salatiga',    'kuota' => 136, 'laki_laki' => 16,  'perempuan' => 120],
            ['nama_panti' => 'Panti Pelayanan Sosial Lanjut Usia Wiloso Asri Ungaran',            'kabupaten' => 'Semarang',    'kuota' => 100, 'laki_laki' => 5,   'perempuan' => 95],
            ['nama_panti' => 'Panti Pelayanan Sosial Lanjut Usia Abiyoso Semarang',               'kabupaten' => 'Semarang',    'kuota' => 110, 'laki_laki' => 10,  'perempuan' => 100],
            ['nama_panti' => 'Panti Pelayanan Sosial Wanita Wanodyatama Surakarta',               'kabupaten' => 'Surakarta',   'kuota' => 75,  'laki_laki' => 0,   'perempuan' => 75],
            ['nama_panti' => 'Panti Pelayanan Sosial Anak Pamardi Siwi Sragen',                   'kabupaten' => 'Sragen',      'kuota' => 90,  'laki_laki' => 45,  'perempuan' => 45],
            ['nama_panti' => 'Panti Pelayanan Sosial Disabilitas Sensorik Rungu Wicara Semarang', 'kabupaten' => 'Semarang',    'kuota' => 60,  'laki_laki' => 30,  'perempuan' => 30],
            ['nama_panti' => 'Panti Pelayanan Sosial Eks Psikotik Ngudi Rahayu Kendal',           'kabupaten' => 'Kendal',      'kuota' => 120, 'laki_laki' => 70,  'perempuan' => 50],
            ['nama_panti' => 'Panti Pelayanan Sosial Anak Suko Mulyo Pemalang',                   'kabupaten' => 'Pemalang',    'kuota' => 85,  'laki_laki' => 40,  'perempuan' => 45],
            ['nama_panti' => 'Panti Pelayanan Sosial Lanjut Usia Dewanata Cilacap',               'kabupaten' => 'Cilacap',     'kuota' => 100, 'laki_laki' => 55,  'perempuan' => 45],
            ['nama_panti' => 'Panti Pelayanan Sosial Anak Budhi Sakti Banyumas',                  'kabupaten' => 'Banyumas',    'kuota' => 80,  'laki_laki' => 38,  'perempuan' => 42],
            ['nama_panti' => 'Panti Pelayanan Sosial Disabilitas Netra Bhakti Candrasa Surakarta','kabupaten' => 'Surakarta',   'kuota' => 55,  'laki_laki' => 28,  'perempuan' => 27],
            ['nama_panti' => 'Panti Pelayanan Sosial Lanjut Usia Pucang Gading Semarang',         'kabupaten' => 'Semarang',    'kuota' => 150, 'laki_laki' => 72,  'perempuan' => 78],
            ['nama_panti' => 'Panti Pelayanan Sosial Remaja Antasena Magelang',                   'kabupaten' => 'Magelang',    'kuota' => 65,  'laki_laki' => 65,  'perempuan' => 0],
        ];

        /*
        |--------------------------------------------------------------------------
        | SIMPAN DATA PANTI
        |--------------------------------------------------------------------------
        */
        DB::table('panti')->insert($data);

        /*
        |--------------------------------------------------------------------------
        | INFO HASIL SEEDER
        |--------------------------------------------------------------------------
        */
        $this->command->info('✅ Data dummy panti berhasil di-seed! (' . count($data) . ' data)');
    }
}
