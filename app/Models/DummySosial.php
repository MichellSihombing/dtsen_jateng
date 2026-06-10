<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DummySosial extends Model
{
    /*
    |--------------------------------------------------------------------------
    | NAMA TABEL MODEL
    |--------------------------------------------------------------------------
    */
    protected $table = 'dummy_sosials';

    /*
    |--------------------------------------------------------------------------
    | FIELD YANG DAPAT DIISI
    |--------------------------------------------------------------------------
    */
    protected $fillable = [
        'desa_id',

        'desil_1',
        'desil_2',
        'desil_3',
        'desil_4',
        'desil_5',
        'desil_6',
        'desil_7',
        'desil_8',
        'desil_9',
        'desil_10',

        'rlth',
        'air',
        'jamban',
        'listrik',
        'ats',
        'disabilitas',
        'tidak_bekerja',

        'pkh',
        'sembako',
        'pbi',
    ];

    /*
    |--------------------------------------------------------------------------
    | RELASI DESA
    |--------------------------------------------------------------------------
    */
    public function desa(): BelongsTo
    {
        return $this->belongsTo(Desa::class);
    }
}
