<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Jalankan migration.
     */
    public function up(): void
    {
        Schema::create('ppks_jenis', function (Blueprint $table) {
            $table->id();

            $table->string('jenis_ppks');
            $table->year('tahun');
            $table->bigInteger('jumlah')->default(0);

            $table->timestamps();

            $table->unique(['jenis_ppks', 'tahun'], 'ppks_jenis_tahun_unique');
        });
    }

    /**
     * Rollback migration.
     */
    public function down(): void
    {
        Schema::dropIfExists('ppks_jenis');
    }
};