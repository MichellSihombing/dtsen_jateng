<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Wilayah extends Model
{
    /*
    |--------------------------------------------------------------------------
    | NAMA TABEL MODEL
    |--------------------------------------------------------------------------
    */
    protected $table = 'wilayah';

    /*
    |--------------------------------------------------------------------------
    | FIELD YANG DAPAT DIISI
    |--------------------------------------------------------------------------
    */
    protected $fillable = [
        'kode_wilayah',
        'nama',
        'tingkat',
        'parent_id',
        'geojson'
    ];

    /*
    |--------------------------------------------------------------------------
    | KONVERSI TIPE DATA
    |--------------------------------------------------------------------------
    */
    protected $casts = [
        'geojson' => 'array'
    ];

    /*
    |--------------------------------------------------------------------------
    | RELASI WILAYAH INDUK
    |--------------------------------------------------------------------------
    */
    public function parent(): BelongsTo
    {
        return $this->belongsTo(Wilayah::class, 'parent_id');
    }

    /*
    |--------------------------------------------------------------------------
    | RELASI WILAYAH TURUNAN
    |--------------------------------------------------------------------------
    */
    public function children(): HasMany
    {
        return $this->hasMany(Wilayah::class, 'parent_id');
    }

    /*
    |--------------------------------------------------------------------------
    | RELASI DATA PENDUDUK
    |--------------------------------------------------------------------------
    */
    public function penduduk(): HasMany
    {
        return $this->hasMany(Penduduk::class, 'desa_id');
    }
}
