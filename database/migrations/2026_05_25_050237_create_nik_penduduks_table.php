<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /*
    |--------------------------------------------------------------------------
    | TABLE DATA NIK PENDUDUK
    |--------------------------------------------------------------------------
    */

    public function up(): void
    {
        Schema::create('nik_penduduks', function (Blueprint $table) {
            $table->id();

            $table->string('nik', 20)->unique();
            $table->string('nama_lengkap')->nullable();
            $table->string('jenis_kelamin')->nullable();
            $table->date('tanggal_lahir')->nullable();

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

            $table->text('alamat')->nullable();

            $table->string('status_dtsen')->default('Terdata');
            $table->string('keterangan')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('nik_penduduks');
    }
};