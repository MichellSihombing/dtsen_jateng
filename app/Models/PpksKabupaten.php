<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PpksKabupaten extends Model
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
    protected $table = 'ppks_kabupatens';

    /*
    |--------------------------------------------------------------------------
    | FIELD YANG DAPAT DIISI
    |--------------------------------------------------------------------------
    */
    protected $fillable = [
        'kabupaten_id',
        'tahun',
        'jumlah',
    ];

    /*
    |--------------------------------------------------------------------------
    | KONVERSI TIPE DATA
    |--------------------------------------------------------------------------
    */
    protected $casts = [
        'kabupaten_id' => 'integer',
        'tahun' => 'integer',
        'jumlah' => 'integer',
    ];

    /*
    |--------------------------------------------------------------------------
    | RELASI KABUPATEN
    |--------------------------------------------------------------------------
    */
    public function kabupaten()
    {
        return $this->belongsTo(Kabupaten::class, 'kabupaten_id');
    }
}
