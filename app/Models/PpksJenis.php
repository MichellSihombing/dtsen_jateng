<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PpksJenis extends Model
{
    /*
    |--------------------------------------------------------------------------
    | TRAIT MODEL
    |--------------------------------------------------------------------------
    */
    use HasFactory;

    /*
    |--------------------------------------------------------------------------
    | NAMA TABEL MODEL
    |--------------------------------------------------------------------------
    */
    protected $table = 'ppks_jenis';

    /*
    |--------------------------------------------------------------------------
    | FIELD YANG DAPAT DIISI
    |--------------------------------------------------------------------------
    */
    protected $fillable = [
        'jenis_ppks',
        'tahun',
        'jumlah',
    ];

    /*
    |--------------------------------------------------------------------------
    | KONVERSI TIPE DATA
    |--------------------------------------------------------------------------
    */
    protected $casts = [
        'tahun' => 'integer',
        'jumlah' => 'integer',
    ];
}
