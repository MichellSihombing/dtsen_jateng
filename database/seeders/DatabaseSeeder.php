<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /*
    |--------------------------------------------------------------------------
    | JALANKAN SEEDER DATA MASTER
    |--------------------------------------------------------------------------
    */
    public function run(): void
    {
        $this->call([
            DtJatengSeeder::class,
            DummySosialSeeder::class,
            PantiSeeder::class,
            PpksSeeder::class,
            PpksRekapDataSeeder::class,
            PsksSeeder::class,
        ]);
    }
}