<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DtJateng extends Model
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
    protected $table = 'dt_jateng';

    /*
    |--------------------------------------------------------------------------
    | FIELD YANG DAPAT DIISI
    |--------------------------------------------------------------------------
    */
    protected $fillable = [
        'kabupaten_id',
        'rtlh',
        'rtlh_p1',
        'rtlh_p2',
        'listrik',
        'air',
        'jamban',
        'ats',
        'tidak_bekerja',
        'pct_art',
    ];

    /*
    |--------------------------------------------------------------------------
    | KONVERSI TIPE DATA
    |--------------------------------------------------------------------------
    */
    protected $casts = [
        'kabupaten_id' => 'integer',
        'rtlh' => 'integer',
        'rtlh_p1' => 'integer',
        'rtlh_p2' => 'integer',
        'listrik' => 'integer',
        'air' => 'integer',
        'jamban' => 'integer',
        'ats' => 'integer',
        'tidak_bekerja' => 'integer',
        'pct_art' => 'float',
    ];

    /*
    |--------------------------------------------------------------------------
    | RELASI KABUPATEN
    |--------------------------------------------------------------------------
    */
    public function kabupaten(): BelongsTo
    {
        return $this->belongsTo(Kabupaten::class, 'kabupaten_id', 'id');
    }

    /*
    |--------------------------------------------------------------------------
    | ALIAS NAMA KABUPATEN
    |--------------------------------------------------------------------------
    */
    public function getNamaKabupatenAttribute(): string
    {
        return $this->kabupaten?->nama_kabupaten ?? 'Tidak Diketahui';
    }
}
