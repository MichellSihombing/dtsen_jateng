<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /*
    |--------------------------------------------------------------------------
    | TABLE PPKS
    |--------------------------------------------------------------------------
    */

    public function up(): void
    {
        Schema::create('ppks', function (Blueprint $table) {
            $table->id();

            $table->foreignId('kabupaten_id')
                ->nullable()
                ->constrained('kabupatens')
                ->nullOnDelete();

            $table->string('jenis_ppks');
            $table->year('tahun');
            $table->integer('jumlah')->default(0);
            $table->timestamps();

            $table->index(['kabupaten_id', 'tahun']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('ppks');
    }
};