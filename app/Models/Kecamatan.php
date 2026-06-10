<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Kecamatan extends Model
{
    /*
    |--------------------------------------------------------------------------
    | NAMA TABEL MODEL
    |--------------------------------------------------------------------------
    */
    protected $table = 'kecamatans';

    /*
    |--------------------------------------------------------------------------
    | FIELD YANG DAPAT DIISI
    |--------------------------------------------------------------------------
    */
    protected $fillable = [
        'kabupaten_id',
        'kode_kecamatan',
        'nama_kecamatan',
        'geojson_path',
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
    | RELASI DATA DESA
    |--------------------------------------------------------------------------
    */
    public function desas(): HasMany
    {
        return $this->hasMany(Desa::class, 'kecamatan_id', 'id');
    }

    /*
    |--------------------------------------------------------------------------
    | ALIAS RELASI DESA
    |--------------------------------------------------------------------------
    */
    public function desa(): HasMany
    {
        return $this->hasMany(Desa::class, 'kecamatan_id', 'id');
    }

    /*
    |--------------------------------------------------------------------------
    | RELASI DATA NIK
    |--------------------------------------------------------------------------
    */
    public function nikPenduduks(): HasMany
    {
        return $this->hasMany(NikPenduduk::class, 'kecamatan_id', 'id');
    }

    /*
    |--------------------------------------------------------------------------
    | ALIAS NAMA KECAMATAN
    |--------------------------------------------------------------------------
    */
    public function getNamaAttribute(): ?string
    {
        return $this->nama_kecamatan;
    }

    /*
    |--------------------------------------------------------------------------
    | ALIAS KODE KECAMATAN
    |--------------------------------------------------------------------------
    */
    public function getKodeAttribute(): ?string
    {
        return $this->kode_kecamatan;
    }
}
