<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Kabupaten extends Model
{
    /*
    |--------------------------------------------------------------------------
    | NAMA TABEL MODEL
    |--------------------------------------------------------------------------
    */
    protected $table = 'kabupatens';

    /*
    |--------------------------------------------------------------------------
    | FIELD YANG DAPAT DIISI
    |--------------------------------------------------------------------------
    */
    protected $fillable = [
        'kode_kabupaten',
        'nama_kabupaten',
        'geojson_path',
    ];

    /*
    |--------------------------------------------------------------------------
    | RELASI DATA KECAMATAN
    |--------------------------------------------------------------------------
    */
    public function kecamatans(): HasMany
    {
        return $this->hasMany(Kecamatan::class, 'kabupaten_id', 'id');
    }

    /*
    |--------------------------------------------------------------------------
    | ALIAS RELASI KECAMATAN
    |--------------------------------------------------------------------------
    */
    public function kecamatan(): HasMany
    {
        return $this->hasMany(Kecamatan::class, 'kabupaten_id', 'id');
    }

    /*
    |--------------------------------------------------------------------------
    | RELASI DATA NIK
    |--------------------------------------------------------------------------
    */
    public function nikPenduduks(): HasMany
    {
        return $this->hasMany(NikPenduduk::class, 'kabupaten_id', 'id');
    }

    /*
    |--------------------------------------------------------------------------
    | RELASI DATA PPKS
    |--------------------------------------------------------------------------
    */
    public function ppks(): HasMany
    {
        return $this->hasMany(Ppks::class, 'kabupaten_id', 'id');
    }

    /*
    |--------------------------------------------------------------------------
    | RELASI PPKS KABUPATEN
    |--------------------------------------------------------------------------
    */
    public function ppksKabupatens(): HasMany
    {
        return $this->hasMany(PpksKabupaten::class, 'kabupaten_id', 'id');
    }

    /*
    |--------------------------------------------------------------------------
    | RELASI DATA PSKS
    |--------------------------------------------------------------------------
    */
    public function psks(): HasMany
    {
        return $this->hasMany(Psks::class, 'kabupaten_id', 'id');
    }

    /*
    |--------------------------------------------------------------------------
    | RELASI DATA DT JATENG
    |--------------------------------------------------------------------------
    */
    public function dtJateng(): HasMany
    {
        return $this->hasMany(DtJateng::class, 'kabupaten_id', 'id');
    }

    /*
    |--------------------------------------------------------------------------
    | ALIAS NAMA KABUPATEN
    |--------------------------------------------------------------------------
    */
    public function getNamaAttribute(): ?string
    {
        return $this->nama_kabupaten;
    }

    /*
    |--------------------------------------------------------------------------
    | ALIAS KODE KABUPATEN
    |--------------------------------------------------------------------------
    */
    public function getKodeAttribute(): ?string
    {
        return $this->kode_kabupaten;
    }
}
