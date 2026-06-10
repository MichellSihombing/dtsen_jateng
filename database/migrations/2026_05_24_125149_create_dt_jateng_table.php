<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /*
    |--------------------------------------------------------------------------
    | TABLE DT JATENG
    |--------------------------------------------------------------------------
    */

    public function up(): void
    {
        Schema::create('dt_jateng', function (Blueprint $table) {
            $table->id();

            $table->foreignId('kabupaten_id')
                ->nullable()
                ->constrained('kabupatens')
                ->nullOnDelete();

            $table->integer('rtlh')->default(0);
            $table->integer('rtlh_p1')->default(0);
            $table->integer('rtlh_p2')->default(0);
            $table->integer('listrik')->default(0);
            $table->integer('air')->default(0);
            $table->integer('jamban')->default(0);
            $table->integer('ats')->default(0);
            $table->integer('tidak_bekerja')->default(0);

            /*
            |--------------------------------------------------------------------------
            | % ART
            |--------------------------------------------------------------------------
            | Contoh data:
            | 77.60
            | 14.75
            | 8.87
            |--------------------------------------------------------------------------
            */
            $table->decimal('pct_art', 6, 2)->default(0);

            $table->timestamps();

            $table->index('kabupaten_id');
            $table->unique('kabupaten_id', 'dt_jateng_kabupaten_unique');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('dt_jateng');
    }
};