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
        Schema::create('ppks_kabupatens', function (Blueprint $table) {
            $table->id();

            $table->foreignId('kabupaten_id')
                ->constrained('kabupatens')
                ->cascadeOnDelete();

            $table->year('tahun');
            $table->bigInteger('jumlah')->default(0);

            $table->timestamps();

            $table->unique(['kabupaten_id', 'tahun'], 'ppks_kabupaten_tahun_unique');
        });
    }

    /**
     * Rollback migration.
     */
    public function down(): void
    {
        Schema::dropIfExists('ppks_kabupatens');
    }
};