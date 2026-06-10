<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /*
    |--------------------------------------------------------------------------
    | TABLE DATA DUMMY SOSIAL
    |--------------------------------------------------------------------------
    */

    public function up(): void
    {
        Schema::create('dummy_sosials', function (Blueprint $table) {
            $table->id();

            $table->foreignId('desa_id')
                ->constrained('desas')
                ->cascadeOnDelete();

            /*
            |--------------------------------------------------------------------------
            | DESIL 1 - 10
            |--------------------------------------------------------------------------
            | Desil 1 = paling miskin
            | Desil 10 = paling mampu
            |--------------------------------------------------------------------------
            */

            $table->integer('desil_1')->default(0);
            $table->integer('desil_2')->default(0);
            $table->integer('desil_3')->default(0);
            $table->integer('desil_4')->default(0);
            $table->integer('desil_5')->default(0);
            $table->integer('desil_6')->default(0);
            $table->integer('desil_7')->default(0);
            $table->integer('desil_8')->default(0);
            $table->integer('desil_9')->default(0);
            $table->integer('desil_10')->default(0);

            /*
            |--------------------------------------------------------------------------
            | KOMPONEN KEBUTUHAN
            |--------------------------------------------------------------------------
            */

            $table->integer('rlth')->default(0);
            $table->integer('air')->default(0);
            $table->integer('jamban')->default(0);
            $table->integer('listrik')->default(0);
            $table->integer('ats')->default(0);
            $table->integer('disabilitas')->default(0);
            $table->integer('tidak_bekerja')->default(0);

            /*
            |--------------------------------------------------------------------------
            | BANSOS
            |--------------------------------------------------------------------------
            */

            $table->integer('pkh')->default(0);
            $table->integer('sembako')->default(0);
            $table->integer('pbi')->default(0);

            $table->timestamps();

            $table->index('desa_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('dummy_sosials');
    }
};