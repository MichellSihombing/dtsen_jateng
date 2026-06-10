<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Penduduk extends Model
{
    /*
    |--------------------------------------------------------------------------
    | NAMA TABEL MODEL
    |--------------------------------------------------------------------------
    */
    protected $table = 'penduduks';

    /*
    |--------------------------------------------------------------------------
    | FIELD YANG DAPAT DIISI
    |--------------------------------------------------------------------------
    */
    protected $fillable = [
        'desa_id',
        'nama',
        'nik',
        'alamat',
        'desil'
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
