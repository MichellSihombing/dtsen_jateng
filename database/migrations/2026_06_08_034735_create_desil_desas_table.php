<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /*
    |--------------------------------------------------------------------------
    | TABLE DESIL DESA
    |--------------------------------------------------------------------------
    | Menyimpan data desil dari file Excel berdasarkan wilayah kabupaten,
    | kecamatan, dan desa/kelurahan.
    |
    | Catatan:
    | Migration ini dibuat aman. Jika tabel desil_desas sudah ada, migration
    | tidak akan membuat ulang tabel agar data import Excel tidak hilang.
    |--------------------------------------------------------------------------
    */

    public function up(): void
    {
        /*
        |--------------------------------------------------------------------------
        | CEGAH ERROR TABLE ALREADY EXISTS
        |--------------------------------------------------------------------------
        | Jika tabel desil_desas sudah ada di database, langsung hentikan proses
        | migration ini dan biarkan Laravel menandainya sebagai sudah dijalankan.
        |--------------------------------------------------------------------------
        */

        if (Schema::hasTable('desil_desas')) {
            return;
        }

        Schema::create('desil_desas', function (Blueprint $table) {
            $table->id();

            /*
            |--------------------------------------------------------------------------
            | RELASI WILAYAH
            |--------------------------------------------------------------------------
            */

            $table->foreignId('kabupaten_id')
                ->nullable()
                ->constrained('kabupatens')
                ->nullOnDelete();

            $table->foreignId('kecamatan_id')
                ->nullable()
                ->constrained('kecamatans')
                ->nullOnDelete();

            $table->foreignId('desa_id')
                ->nullable()
                ->constrained('desas')
                ->nullOnDelete();

            /*
            |--------------------------------------------------------------------------
            | KODE WILAYAH EXCEL
            |--------------------------------------------------------------------------
            */

            $table->string('kode_kabupaten')->nullable();
            $table->string('kode_kecamatan')->nullable();
            $table->string('kode_desa')->nullable();

            /*
            |--------------------------------------------------------------------------
            | NAMA WILAYAH EXCEL
            |--------------------------------------------------------------------------
            */

            $table->string('nama_kabupaten')->nullable();
            $table->string('nama_kecamatan')->nullable();
            $table->string('nama_desa')->nullable();

            /*
            |--------------------------------------------------------------------------
            | DATA DESIL
            |--------------------------------------------------------------------------
            */

            $table->bigInteger('desil_1')->default(0);
            $table->bigInteger('desil_2')->default(0);
            $table->bigInteger('desil_3')->default(0);
            $table->bigInteger('desil_4')->default(0);
            $table->bigInteger('total_d1_d4')->default(0);
            $table->bigInteger('desil_5')->default(0);
            $table->bigInteger('desil_6')->default(0);
            $table->bigInteger('desil_7_10')->default(0);
            $table->bigInteger('desil_null')->default(0);
            $table->bigInteger('total')->default(0);

            /*
            |--------------------------------------------------------------------------
            | STATUS MAPPING
            |--------------------------------------------------------------------------
            */

            $table->string('mapping_status')->default('pending');
            $table->text('mapping_note')->nullable();

            $table->timestamps();

            /*
            |--------------------------------------------------------------------------
            | INDEX DATA
            |--------------------------------------------------------------------------
            */

            $table->index('kabupaten_id');
            $table->index('kecamatan_id');
            $table->index('desa_id');
            $table->index('kode_kabupaten');
            $table->index('kode_kecamatan');
            $table->index('kode_desa');
            $table->index('mapping_status');

            $table->unique(
                ['kode_kabupaten', 'kode_kecamatan', 'kode_desa'],
                'desil_desas_kode_wilayah_unique'
            );
        });
    }

    public function down(): void
    {
        /*
        |--------------------------------------------------------------------------
        | ROLLBACK
        |--------------------------------------------------------------------------
        | Hati-hati: rollback migration ini akan menghapus tabel desil_desas.
        |--------------------------------------------------------------------------
        */

        Schema::dropIfExists('desil_desas');
    }
};