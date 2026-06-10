<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /*
    |--------------------------------------------------------------------------
    | TABLE PANTI
    |--------------------------------------------------------------------------
    */

    public function up(): void
    {
        Schema::create('panti', function (Blueprint $table) {
            $table->id();
            $table->string('nama_panti');
            $table->string('kabupaten')->nullable();
            $table->integer('kuota')->default(0);
            $table->integer('laki_laki')->default(0);
            $table->integer('perempuan')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('panti');
    }
};