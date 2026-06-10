<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /*
    |--------------------------------------------------------------------------
    | TAMBAH KOLOM DESIL NASIONAL
    |--------------------------------------------------------------------------
    | Kolom ini digunakan untuk menentukan status afirmasi SPMB berdasarkan NIK.
    | Nilainya berada pada rentang 1 sampai 10.
    |--------------------------------------------------------------------------
    */

    public function up(): void
    {
        Schema::table('nik_penduduks', function (Blueprint $table) {
            if (!Schema::hasColumn('nik_penduduks', 'desil_nasional')) {
                $table->unsignedTinyInteger('desil_nasional')
                    ->default(1)
                    ->after('status_dtsen');
            }
        });
    }

    public function down(): void
    {
        Schema::table('nik_penduduks', function (Blueprint $table) {
            if (Schema::hasColumn('nik_penduduks', 'desil_nasional')) {
                $table->dropColumn('desil_nasional');
            }
        });
    }
};