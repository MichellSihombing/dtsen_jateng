<?php

namespace App\Http\Controllers;

use App\Models\DesilDesa;
use Illuminate\Http\Request;

class FilterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | FILTER DATA DESIL PETA
    |--------------------------------------------------------------------------
    */

    public function filter(Request $request)
    {
        /*
        |--------------------------------------------------------------------------
        | VALIDASI INPUT
        |--------------------------------------------------------------------------
        */

        $validated = $request->validate([
            'kabupaten_id' => ['nullable', 'integer', 'exists:kabupatens,id'],
            'kecamatan_id' => ['nullable', 'integer', 'exists:kecamatans,id'],
            'desa_id' => ['nullable', 'integer', 'exists:desas,id'],
            'desil' => ['required', 'string'],
        ], [
            'desil.required' => 'Silakan pilih desil terlebih dahulu.',
            'kabupaten_id.exists' => 'Kabupaten/Kota tidak ditemukan.',
            'kecamatan_id.exists' => 'Kecamatan tidak ditemukan.',
            'desa_id.exists' => 'Desa/Kelurahan tidak ditemukan.',
        ]);

        /*
        |--------------------------------------------------------------------------
        | NORMALISASI DESIL
        |--------------------------------------------------------------------------
        */

        $selectedDesil = $this->normalizeDesil($validated['desil']);

        if (!$this->isValidDesil($selectedDesil)) {
            return response()->json([
                'success' => false,
                'source' => 'excel_desil',
                'message' => 'Pilihan desil tidak valid.',
                'desil' => $selectedDesil,
                'total' => 0,
                'total_record' => 0,
                'summary' => [
                    'jumlah_kpm' => 0,
                    'total_wilayah' => 0,
                ],
                'selected_area' => [
                    'kabupaten' => null,
                    'kecamatan' => null,
                    'desa' => null,
                ],
                'data' => [],
                'grouped_by_desa' => [],
            ], 422);
        }

        /*
        |--------------------------------------------------------------------------
        | QUERY DATA DESIL
        |--------------------------------------------------------------------------
        */

        $query = DesilDesa::query()
            ->with(['kabupaten', 'kecamatan', 'desa'])
            ->where('mapping_status', 'success');

        /*
        |--------------------------------------------------------------------------
        | FILTER WILAYAH
        |--------------------------------------------------------------------------
        */

        if ($request->filled('desa_id')) {
            $query->where('desa_id', $request->desa_id);
        } elseif ($request->filled('kecamatan_id')) {
            $query->where('kecamatan_id', $request->kecamatan_id);
        } elseif ($request->filled('kabupaten_id')) {
            $query->where('kabupaten_id', $request->kabupaten_id);
        }

        $records = $query->get();

        /*
        |--------------------------------------------------------------------------
        | FORMAT DATA
        |--------------------------------------------------------------------------
        */

        $data = $records->map(function (DesilDesa $item) use ($selectedDesil) {
            $jumlahKpm = $this->getJumlahByDesil($item, $selectedDesil);

            return [
                'id' => $item->id,

                'kabupaten_id' => $item->kabupaten_id,
                'kecamatan_id' => $item->kecamatan_id,
                'desa_id' => $item->desa_id,

                'kode_kabupaten' => $item->kode_kabupaten,
                'kode_kecamatan' => $item->kode_kecamatan,
                'kode_desa' => $item->kode_desa,

                'nama_kabupaten' => $item->nama_kabupaten
                    ?? $item->kabupaten?->nama_kabupaten
                    ?? '-',

                'nama_kecamatan' => $item->nama_kecamatan
                    ?? $item->kecamatan?->nama_kecamatan
                    ?? '-',

                'nama_desa' => $item->nama_desa
                    ?? $item->desa?->nama_desa
                    ?? '-',

                'desil' => $selectedDesil,
                'desil_label' => $this->getDesilLabel($selectedDesil),
                'jumlah_kpm' => $jumlahKpm,

                'desil_1' => (int) ($item->desil_1 ?? 0),
                'desil_2' => (int) ($item->desil_2 ?? 0),
                'desil_3' => (int) ($item->desil_3 ?? 0),
                'desil_4' => (int) ($item->desil_4 ?? 0),
                'total_d1_d4' => (int) ($item->total_d1_d4 ?? 0),
                'desil_5' => (int) ($item->desil_5 ?? 0),
                'desil_6' => (int) ($item->desil_6 ?? 0),
                'desil_7_10' => (int) ($item->desil_7_10 ?? 0),

                /*
                |--------------------------------------------------------------------------
                | TOTAL DESIL 6-10
                |--------------------------------------------------------------------------
                */

                'total_d6_d10' => (int) (($item->desil_6 ?? 0) + ($item->desil_7_10 ?? 0)),

                'desil_null' => (int) ($item->desil_null ?? 0),
                'total' => (int) ($item->total ?? 0),

                'mapping_status' => $item->mapping_status,
                'mapping_note' => $item->mapping_note,
            ];
        });

        /*
        |--------------------------------------------------------------------------
        | TOTAL UTAMA
        |--------------------------------------------------------------------------
        */

        $totalKpm = (int) $data->sum('jumlah_kpm');

        /*
        |--------------------------------------------------------------------------
        | GROUP DATA PER DESA
        |--------------------------------------------------------------------------
        */

        $groupedByDesa = $data->groupBy('desa_id');

        /*
        |--------------------------------------------------------------------------
        | AREA TERPILIH
        |--------------------------------------------------------------------------
        */

        $firstData = $data->first();

        return response()->json([
            'success' => true,
            'source' => 'excel_desil',
            'message' => 'Data desil berhasil diambil dari hasil import Excel.',

            'desil' => $selectedDesil,
            'desil_label' => $this->getDesilLabel($selectedDesil),

            'total' => $totalKpm,
            'total_record' => $data->count(),

            'summary' => [
                'kabupaten_id' => $request->kabupaten_id,
                'kecamatan_id' => $request->kecamatan_id,
                'desa_id' => $request->desa_id,

                'desil' => $selectedDesil,
                'desil_label' => $this->getDesilLabel($selectedDesil),

                'jumlah_kpm' => $totalKpm,
                'total_wilayah' => $data->count(),

                /*
                |--------------------------------------------------------------------------
                | SUMBER DATA
                |--------------------------------------------------------------------------
                */

                'sumber_data' => 'Data Excel Desil',
            ],

            'selected_area' => [
                'kabupaten' => $firstData['nama_kabupaten'] ?? null,
                'kecamatan' => $firstData['nama_kecamatan'] ?? null,
                'desa' => $firstData['nama_desa'] ?? null,
            ],

            'data' => $data->values(),
            'grouped_by_desa' => $groupedByDesa,
        ]);
    }

    /*
    |--------------------------------------------------------------------------
    | NORMALISASI DESIL
    |--------------------------------------------------------------------------
    */

    private function normalizeDesil(string|int|null $desil): string
    {
        $desil = trim((string) $desil);
        $desil = strtolower($desil);

        $desil = str_replace([' ', '_', 'sampai', 'sd', 's/d'], ['-', '-', '-', '-', '-'], $desil);
        $desil = preg_replace('/-+/', '-', $desil);

        return match ($desil) {
            '1' => '1',
            '2' => '2',
            '3' => '3',
            '4' => '4',
            '5' => '5',
            '6' => '6',
            '7' => '7',
            '8' => '8',
            '9' => '9',
            '10' => '10',

            '1-4', 'd1-d4' => '1-4',
            '6-10', 'd6-d10' => '6-10',
            '7-10', 'd7-d10' => '7-10',

            'null', 'kosong' => 'null',
            'total' => 'total',

            default => $desil,
        };
    }

    /*
    |--------------------------------------------------------------------------
    | VALIDASI DESIL
    |--------------------------------------------------------------------------
    */

    private function isValidDesil(string $desil): bool
    {
        return in_array($desil, [
            '1',
            '2',
            '3',
            '4',
            '5',
            '6',
            '7',
            '8',
            '9',
            '10',
            '1-4',
            '6-10',
            '7-10',
            'null',
            'total',
        ], true);
    }

    /*
    |--------------------------------------------------------------------------
    | LABEL DESIL
    |--------------------------------------------------------------------------
    */

    private function getDesilLabel(string $desil): string
    {
        return match ($desil) {
            '1' => 'Desil 1',
            '2' => 'Desil 2',
            '3' => 'Desil 3',
            '4' => 'Desil 4',
            '5' => 'Desil 5',
            '6' => 'Desil 6',
            '7' => 'Desil 7',
            '8' => 'Desil 8',
            '9' => 'Desil 9',
            '10' => 'Desil 10',
            '1-4' => 'Desil 1 - 4',
            '6-10' => 'Desil 6 - 10',
            '7-10' => 'Desil 7 - 10',
            'null' => 'Desil Kosong',
            'total' => 'Total Keseluruhan',
            default => 'Desil Tidak Diketahui',
        };
    }

    /*
    |--------------------------------------------------------------------------
    | GET JUMLAH BY DESIL
    |--------------------------------------------------------------------------
    */

    private function getJumlahByDesil(DesilDesa $item, string $desil): int
    {
        $desil1 = (int) ($item->desil_1 ?? 0);
        $desil2 = (int) ($item->desil_2 ?? 0);
        $desil3 = (int) ($item->desil_3 ?? 0);
        $desil4 = (int) ($item->desil_4 ?? 0);
        $desil5 = (int) ($item->desil_5 ?? 0);
        $desil6 = (int) ($item->desil_6 ?? 0);
        $desil7_10 = (int) ($item->desil_7_10 ?? 0);
        $desilNull = (int) ($item->desil_null ?? 0);
        $total = (int) ($item->total ?? 0);
        $totalD1D4 = (int) ($item->total_d1_d4 ?? 0);

        return match ($desil) {
            '1' => $desil1,
            '2' => $desil2,
            '3' => $desil3,
            '4' => $desil4,

            /*
            |--------------------------------------------------------------------------
            | DESIL 1-4
            |--------------------------------------------------------------------------
            */

            '1-4' => $totalD1D4 > 0
                ? $totalD1D4
                : ($desil1 + $desil2 + $desil3 + $desil4),

            '5' => $desil5,
            '6' => $desil6,

            /*
            |--------------------------------------------------------------------------
            | DESIL 7-10
            |--------------------------------------------------------------------------
            */

            '7', '8', '9', '10', '7-10' => $desil7_10,

            /*
            |--------------------------------------------------------------------------
            | DESIL 6-10
            |--------------------------------------------------------------------------
            */

            '6-10' => $desil6 + $desil7_10,

            'null' => $desilNull,

            'total' => $total,

            default => 0,
        };
    }

    /*
    |--------------------------------------------------------------------------
    | RESET FILTER
    |--------------------------------------------------------------------------
    */

    public function reset()
    {
        return response()->json([
            'success' => true,
            'source' => 'excel_desil',
            'message' => 'Filter berhasil direset.',
            'desil' => null,
            'desil_label' => null,
            'total' => 0,
            'total_record' => 0,
            'summary' => [
                'jumlah_kpm' => 0,
                'total_wilayah' => 0,
            ],
            'selected_area' => [
                'kabupaten' => null,
                'kecamatan' => null,
                'desa' => null,
            ],
            'data' => [],
            'grouped_by_desa' => [],
        ]);
    }
}