<?php

namespace App\Http\Controllers;

use App\Models\Kabupaten;
use App\Models\Kecamatan;
use App\Models\Desa;

class WilayahController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | API KABUPATEN
    |--------------------------------------------------------------------------
    */

    public function getKabupaten()
    {
        return Kabupaten::orderBy('nama_kabupaten')
            ->get([
                'id',
                'kode_kabupaten',
                'nama_kabupaten',
                'geojson_path',
            ]);
    }

    /*

    |--------------------------------------------------------------------------

    | API KECAMATAN

    |--------------------------------------------------------------------------

    */

    public function getKecamatan($kabupatenId)
    {
        return Kecamatan::where('kabupaten_id', $kabupatenId)
            ->orderBy('nama_kecamatan')
            ->get([
                'id',
                'kabupaten_id',
                'kode_kecamatan',
                'nama_kecamatan',
                'nama_kecamatan as nama',
                'geojson_path',
            ]);
    }

    /*
    |--------------------------------------------------------------------------
    | API DESA
    |--------------------------------------------------------------------------
    */

    public function getDesa($kecamatanId)
    {
        return Desa::where('kecamatan_id', $kecamatanId)
            ->orderBy('nama_desa')
            ->get([
                'id',
                'kecamatan_id',
                'kode_desa',
                'nama_desa',
                'nama_desa as nama',
                'geojson_path',
            ]);
    }
}