<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('kecamatans', function (Blueprint $table) {

            $table->id();

            $table->foreignId('kabupaten_id')
                ->constrained('kabupatens')
                ->cascadeOnDelete();

            $table->string('kode_kecamatan')->unique();

            $table->string('nama_kecamatan');

            $table->string('geojson_path');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('kecamatans');
    }
};