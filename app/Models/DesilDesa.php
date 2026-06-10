<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DesilDesa extends Model
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
    protected $table = 'desil_desas';

    /*
    |--------------------------------------------------------------------------
    | FIELD YANG DAPAT DIISI
    |--------------------------------------------------------------------------
    */
    protected $fillable = [
        'kabupaten_id',
        'kecamatan_id',
        'desa_id',
        'kode_kabupaten',
        'kode_kecamatan',
        'kode_desa',
        'nama_kabupaten',
        'nama_kecamatan',
        'nama_desa',
        'desil_1',
        'desil_2',
        'desil_3',
        'desil_4',
        'total_d1_d4',
        'desil_5',
        'desil_6',
        'desil_7_10',
        'desil_null',
        'total',
        'mapping_status',
        'mapping_note',
    ];

    /*
    |--------------------------------------------------------------------------
    | KONVERSI TIPE DATA
    |--------------------------------------------------------------------------
    */
    protected $casts = [
        'kabupaten_id' => 'integer',
        'kecamatan_id' => 'integer',
        'desa_id' => 'integer',
        'desil_1' => 'integer',
        'desil_2' => 'integer',
        'desil_3' => 'integer',
        'desil_4' => 'integer',
        'total_d1_d4' => 'integer',
        'desil_5' => 'integer',
        'desil_6' => 'integer',
        'desil_7_10' => 'integer',
        'desil_null' => 'integer',
        'total' => 'integer',
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

    /*
    |--------------------------------------------------------------------------
    | RELASI KECAMATAN
    |--------------------------------------------------------------------------
    */
    public function kecamatan()
    {
        return $this->belongsTo(Kecamatan::class, 'kecamatan_id');
    }

    /*
    |--------------------------------------------------------------------------
    | RELASI DESA
    |--------------------------------------------------------------------------
    */
    public function desa()
    {
        return $this->belongsTo(Desa::class, 'desa_id');
    }

    /*
    |--------------------------------------------------------------------------
    | AMBIL JUMLAH BERDASARKAN DESIL
    |--------------------------------------------------------------------------
    */
    public function getJumlahByDesil(string|int|null $desil): int
    {
        return match ((string) $desil) {
            '1' => $this->desil_1,
            '2' => $this->desil_2,
            '3' => $this->desil_3,
            '4' => $this->desil_4,
            '5' => $this->desil_5,
            '6' => $this->desil_6,
            '7', '8', '9', '10', '7-10' => $this->desil_7_10,
            'null', 'NULL' => $this->desil_null,
            default => 0,
        };
    }

    /*
    |--------------------------------------------------------------------------
    | AMBIL TOTAL DESIL 1 SAMPAI 4
    |--------------------------------------------------------------------------
    */
    public function getTotalD1D4(): int
    {
        if ($this->total_d1_d4 > 0) {
            return $this->total_d1_d4;
        }

        return $this->desil_1
            + $this->desil_2
            + $this->desil_3
            + $this->desil_4;
    }
}
