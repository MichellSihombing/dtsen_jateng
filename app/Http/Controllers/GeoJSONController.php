<?php

namespace App\Http\Controllers;

use App\Models\Desa;
use App\Models\Kabupaten;
use App\Models\Kecamatan;

class GeoJSONController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | GET GEOJSON
    |--------------------------------------------------------------------------
    */

    public function getGeoJSON($level, $id)
    {
        $data = match ($level) {
            'kabupaten' => Kabupaten::find($id),
            'kecamatan' => Kecamatan::find($id),
            'desa' => Desa::find($id),
            default => null,
        };

        if (!$data) {
            return response()->json([
                'success' => false,
                'message' => 'Data wilayah tidak ditemukan.',
                'geojson_path' => null,
            ], 404);
        }

        /*
        |--------------------------------------------------------------------------
        | AMBIL PATH GEOJSON
        |--------------------------------------------------------------------------
        */

        $geojsonPath = $this->resolveGeoJSONPath($data);

        if (!$geojsonPath) {
            return response()->json([
                'success' => false,
                'message' => 'Path GeoJSON belum tersedia untuk wilayah ini.',
                'geojson_path' => null,
                'data' => [
                    'level' => $level,
                    'id' => $data->id,
                    'nama' => $this->getNamaWilayah($data),
                ],
            ], 404);
        }

        return response()->json([
            'success' => true,
            'message' => 'GeoJSON berhasil ditemukan.',
            'level' => $level,
            'id' => $data->id,
            'nama' => $this->getNamaWilayah($data),
            'geojson_path' => asset($geojsonPath),
        ]);
    }

    /*
    |--------------------------------------------------------------------------
    | RESOLVE GEOJSON PATH
    |--------------------------------------------------------------------------
    */

    private function resolveGeoJSONPath($data): ?string
    {
        if (!empty($data->geojson_path)) {
            return $this->cleanGeoJSONPath($data->geojson_path);
        }

        if (!empty($data->path_geojson)) {
            return $this->cleanGeoJSONPath($data->path_geojson);
        }

        if (!empty($data->geojson) && is_string($data->geojson)) {
            return $this->cleanGeoJSONPath($data->geojson);
        }

        return null;
    }

    /*
    |--------------------------------------------------------------------------
    | CLEAN GEOJSON PATH
    |--------------------------------------------------------------------------
    */

    private function cleanGeoJSONPath(string $path): string
    {
        $path = trim($path);

        if (str_starts_with($path, 'http://') || str_starts_with($path, 'https://')) {
            return $path;
        }

        return ltrim($path, '/');
    }

    /*
    |--------------------------------------------------------------------------
    | GET NAMA WILAYAH
    |--------------------------------------------------------------------------
    */

    private function getNamaWilayah($data): ?string
    {
        return $data->nama_kabupaten
            ?? $data->nama_kecamatan
            ?? $data->nama_desa
            ?? $data->nama
            ?? $data->nama_wilayah
            ?? null;
    }
}