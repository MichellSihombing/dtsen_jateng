<?php

namespace App\Http\Controllers;

use App\Models\Desa;
use App\Models\DummySosial;
use Illuminate\Http\Request;

class DummySosialController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | FILTER DATA DUMMY SOSIAL
    |--------------------------------------------------------------------------
    */

    public function filter(Request $request)
    {
        /*
        |--------------------------------------------------------------------------
        | AMBIL INPUT FILTER
        |--------------------------------------------------------------------------
        */
        $level = $request->input('level');
        $id = $request->input('id');

        $desil = $request->input('desil', []);
        $komponen = $request->input('komponen', []);
        $bansos = $request->input('bansos', []);

        if (!$level || !$id) {
            return response()->json([
                'message' => 'Wilayah belum dipilih.'
            ], 422);
        }

        if (empty($desil) && empty($komponen) && empty($bansos)) {
            return response()->json([
                'message' => 'Filter belum dipilih.'
            ], 422);
        }

        /*
        |--------------------------------------------------------------------------
        | AMBIL DESA SESUAI LEVEL
        |--------------------------------------------------------------------------
        */

        $desaQuery = Desa::query()
            ->with('kecamatan.kabupaten');

        if ($level === 'kabupaten') {
            $desaQuery->whereHas('kecamatan', function ($q) use ($id) {
                $q->where('kabupaten_id', $id);
            });
        }

        if ($level === 'kecamatan') {
            $desaQuery->where('kecamatan_id', $id);
        }

        if ($level === 'desa') {
            $desaQuery->where('id', $id);
        }

        $desaIds = $desaQuery->pluck('id')->toArray();

        if (empty($desaIds)) {
            return response()->json([
                'message' => 'Data desa tidak ditemukan.',
                'data' => []
            ]);
        }

        /*
        |--------------------------------------------------------------------------
        | QUERY DATA DUMMY
        |--------------------------------------------------------------------------
        */

        $query = DummySosial::query()
            ->with('desa.kecamatan.kabupaten')
            ->whereIn('desa_id', $desaIds)
            ->where(function ($q) use ($desil, $komponen, $bansos) {
                foreach ($desil as $item) {
                    $column = 'desil_' . $item;

                    if (in_array($column, $this->allowedDesilColumns())) {
                        $q->orWhere($column, '>', 0);
                    }
                }

                foreach ($komponen as $item) {
                    if (in_array($item, $this->allowedKomponenColumns())) {
                        $q->orWhere($item, '>', 0);
                    }
                }

                foreach ($bansos as $item) {
                    if (in_array($item, $this->allowedBansosColumns())) {
                        $q->orWhere($item, '>', 0);
                    }
                }
            });

        $results = $query->get();

        /*
        |--------------------------------------------------------------------------
        | FORMAT RESPONSE
        |--------------------------------------------------------------------------
        */

        $data = $results->map(function ($item) use ($desil, $komponen, $bansos) {
            $desa = $item->desa;
            $kecamatan = $desa?->kecamatan;
            $kabupaten = $kecamatan?->kabupaten;

            return [
                'desa_id' => $desa?->id,
                'nama_desa' => $desa?->nama_desa,
                'nama_kecamatan' => $kecamatan?->nama_kecamatan,
                'nama_kabupaten' => $kabupaten?->nama_kabupaten,
                'geojson_path' => $desa?->geojson_path,

                'selected' => [
                    'desil' => $desil,
                    'komponen' => $komponen,
                    'bansos' => $bansos,
                ],

                'dummy' => [
                    'desil' => [
                        '1' => $item->desil_1,
                        '2' => $item->desil_2,
                        '3' => $item->desil_3,
                        '4' => $item->desil_4,
                        '5' => $item->desil_5,
                        '6' => $item->desil_6,
                        '7' => $item->desil_7,
                        '8' => $item->desil_8,
                        '9' => $item->desil_9,
                        '10' => $item->desil_10,
                    ],
                    'komponen' => [
                        'rlth' => $item->rlth,
                        'air' => $item->air,
                        'jamban' => $item->jamban,
                        'listrik' => $item->listrik,
                        'ats' => $item->ats,
                        'disabilitas' => $item->disabilitas,
                        'tidak_bekerja' => $item->tidak_bekerja,
                    ],
                    'bansos' => [
                        'pkh' => $item->pkh,
                        'sembako' => $item->sembako,
                        'pbi' => $item->pbi,
                    ],
                ]
            ];
        });

        return response()->json([
            'message' => 'Data dummy berhasil dimuat.',
            'total' => $data->count(),
            'data' => $data,
        ]);
    }

    /*
    |--------------------------------------------------------------------------
    | KOLOM YANG DIIZINKAN
    |--------------------------------------------------------------------------
    */

    private function allowedDesilColumns(): array
    {
        return [
            'desil_1',
            'desil_2',
            'desil_3',
            'desil_4',
            'desil_5',
            'desil_6',
            'desil_7',
            'desil_8',
            'desil_9',
            'desil_10',
        ];
    }

    /*
    |--------------------------------------------------------------------------
    | KOLOM KOMPONEN YANG DIIZINKAN
    |--------------------------------------------------------------------------
    */

    private function allowedKomponenColumns(): array
    {
        return [
            'rlth',
            'air',
            'jamban',
            'listrik',
            'ats',
            'disabilitas',
            'tidak_bekerja',
        ];
    }

    /*
    |--------------------------------------------------------------------------
    | KOLOM BANSOS YANG DIIZINKAN
    |--------------------------------------------------------------------------
    */

    private function allowedBansosColumns(): array
    {
        return [
            'pkh',
            'sembako',
            'pbi',
        ];
    }
}