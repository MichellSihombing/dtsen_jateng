<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('desas', function (Blueprint $table) {

            $table->id();

            $table->foreignId('kecamatan_id')
                ->constrained('kecamatans')
                ->cascadeOnDelete();

            $table->string('kode_desa')->unique();

            $table->string('nama_desa');

            $table->string('geojson_path');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('desas');
    }
};