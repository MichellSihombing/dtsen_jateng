<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Panti extends Model
{
    /*
    |--------------------------------------------------------------------------
    | NAMA TABEL MODEL
    |--------------------------------------------------------------------------
    */
    protected $table = 'panti';

    /*
    |--------------------------------------------------------------------------
    | FIELD YANG DAPAT DIISI
    |--------------------------------------------------------------------------
    */
    protected $fillable = [
        'nama_panti',
        'kabupaten',
        'kuota',
        'laki_laki',
        'perempuan',
    ];
}
