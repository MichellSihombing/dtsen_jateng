<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /*
    |--------------------------------------------------------------------------
    | TABLE PSKS
    |--------------------------------------------------------------------------
    */

    public function up(): void
    {
        Schema::create('psks', function (Blueprint $table) {
            $table->id();
            $table->string('jenis_psks');
            $table->year('tahun');
            $table->integer('jumlah')->default(0);
            $table->timestamps();

            $table->index(['jenis_psks', 'tahun']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('psks');
    }
};