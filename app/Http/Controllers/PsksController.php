<?php

namespace App\Http\Controllers;

use App\Models\Psks;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PsksController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | HALAMAN PSKS
    |--------------------------------------------------------------------------
    */

    public function index(Request $request)
    {
        $tahunList = Psks::select('tahun')
            ->distinct()
            ->orderBy('tahun')
            ->pluck('tahun');

        $tahunKolom = $tahunList->toArray();

        $chartData = Psks::select('tahun', DB::raw('SUM(jumlah) as total'))
            ->groupBy('tahun')
            ->orderBy('tahun')
            ->get();

        $searchJenis = $request->input('search', '');

        $jenisQuery = Psks::select(
                'jenis_psks',
                'tahun',
                DB::raw('SUM(jumlah) as total')
            )
            ->groupBy('jenis_psks', 'tahun');

        if ($searchJenis) {
            $jenisQuery->where('jenis_psks', 'like', "%{$searchJenis}%");
        }

        $rekapJenisRaw = $jenisQuery->get();

        $jenisMap = [];

        foreach ($rekapJenisRaw as $row) {
            $jenis = $row->jenis_psks;

            if (!isset($jenisMap[$jenis])) {
                $jenisMap[$jenis] = [
                    'nama' => $jenis,
                    'data' => [],
                ];
            }

            $jenisMap[$jenis]['data'][$row->tahun] = $row->total;
        }

        $perPage = (int) $request->input('per_page', 10);
        $page = (int) $request->input('page', 1);

        $jenisCollection = collect(array_values($jenisMap));
        $total = $jenisCollection->count();
        $rekapJenis = $jenisCollection->forPage($page, $perPage)->values();

        return view('psks.index', compact(
            'tahunKolom',
            'chartData',
            'rekapJenis',
            'total',
            'page',
            'perPage',
            'searchJenis'
        ));
    }
}