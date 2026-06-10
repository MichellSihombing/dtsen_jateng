<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class NikPenduduk extends Model
{
    /*
    |--------------------------------------------------------------------------
    | NAMA TABEL MODEL
    |--------------------------------------------------------------------------
    */
    protected $table = 'nik_penduduks';

    /*
    |--------------------------------------------------------------------------
    | FIELD YANG DAPAT DIISI
    |--------------------------------------------------------------------------
    */
    protected $fillable = [
        'nik',
        'nama_lengkap',
        'jenis_kelamin',
        'tanggal_lahir',
        'kabupaten_id',
        'kecamatan_id',
        'desa_id',
        'alamat',
        'status_dtsen',
        'desil_nasional',
        'keterangan',
    ];

    /*
    |--------------------------------------------------------------------------
    | KONVERSI TIPE DATA
    |--------------------------------------------------------------------------
    */
    protected $casts = [
        'tanggal_lahir' => 'date',
        'desil_nasional' => 'integer',
    ];

    /*
    |--------------------------------------------------------------------------
    | RELASI KABUPATEN
    |--------------------------------------------------------------------------
    */
    public function kabupaten(): BelongsTo
    {
        return $this->belongsTo(Kabupaten::class, 'kabupaten_id');
    }

    /*
    |--------------------------------------------------------------------------
    | RELASI KECAMATAN
    |--------------------------------------------------------------------------
    */
    public function kecamatan(): BelongsTo
    {
        return $this->belongsTo(Kecamatan::class, 'kecamatan_id');
    }

    /*
    |--------------------------------------------------------------------------
    | RELASI DESA
    |--------------------------------------------------------------------------
    */
    public function desa(): BelongsTo
    {
        return $this->belongsTo(Desa::class, 'desa_id');
    }
}
