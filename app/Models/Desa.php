<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Desa extends Model
{
    /*
    |--------------------------------------------------------------------------
    | NAMA TABEL MODEL
    |--------------------------------------------------------------------------
    */
    protected $table = 'desas';

    /*
    |--------------------------------------------------------------------------
    | FIELD YANG DAPAT DIISI
    |--------------------------------------------------------------------------
    */
    protected $fillable = [
        'kecamatan_id',
        'kode_desa',
        'nama_desa',
        'geojson_path',
    ];

    /*
    |--------------------------------------------------------------------------
    | RELASI KECAMATAN
    |--------------------------------------------------------------------------
    */
    public function kecamatan(): BelongsTo
    {
        return $this->belongsTo(Kecamatan::class, 'kecamatan_id', 'id');
    }

    /*
    |--------------------------------------------------------------------------
    | RELASI PENDUDUK LAMA
    |--------------------------------------------------------------------------
    */
    public function penduduks(): HasMany
    {
        return $this->hasMany(Penduduk::class, 'desa_id', 'id');
    }

    /*
    |--------------------------------------------------------------------------
    | RELASI DATA NIK
    |--------------------------------------------------------------------------
    */
    public function nikPenduduks(): HasMany
    {
        return $this->hasMany(NikPenduduk::class, 'desa_id', 'id');
    }

    /*
    |--------------------------------------------------------------------------
    | RELASI DATA SOSIAL DUMMY
    |--------------------------------------------------------------------------
    */
    public function dummySosial(): HasOne
    {
        return $this->hasOne(DummySosial::class, 'desa_id', 'id');
    }

    /*
    |--------------------------------------------------------------------------
    | ALIAS NAMA DESA
    |--------------------------------------------------------------------------
    */
    public function getNamaAttribute(): ?string
    {
        return $this->nama_desa;
    }

    /*
    |--------------------------------------------------------------------------
    | ALIAS KODE DESA
    |--------------------------------------------------------------------------
    */
    public function getKodeAttribute(): ?string
    {
        return $this->kode_desa;
    }

    /*
    |--------------------------------------------------------------------------
    | ALIAS KABUPATEN
    |--------------------------------------------------------------------------
    */
    public function getKabupatenAttribute()
    {
        return $this->kecamatan?->kabupaten;
    }
}
