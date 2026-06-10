<?php

namespace App\Http\Controllers;

use App\Models\Kabupaten;
use App\Models\PpksKabupaten;
use App\Models\PpksJenis;
use Illuminate\Http\Request;

class PpksController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | DAFTAR TAHUN DATA
    |--------------------------------------------------------------------------
    */
    private array $years = [
        2015, 2016, 2017, 2018, 2019, 2020,
        2021, 2022, 2023, 2024, 2025,
    ];

    /*
    |--------------------------------------------------------------------------
    | HALAMAN PPKS
    |--------------------------------------------------------------------------
    */

    public function index(Request $request)
    {
        $searchKabupaten = $request->query('search_kabupaten');
        $searchJenis = $request->query('search_jenis');

        $rekapKabupaten = $this->getRekapKabupaten($searchKabupaten);
        $rekapJenis = $this->getRekapJenis($searchJenis);

        /*
        |--------------------------------------------------------------------------
        | DATA GRAFIK PPKS
        |--------------------------------------------------------------------------
        */
        $chartData = PpksKabupaten::query()
            ->selectRaw('tahun, SUM(jumlah) as total')
            ->groupBy('tahun')
            ->orderBy('tahun')
            ->get();

        return view('ppks.index', [
            'years' => $this->years,
            'tahunKolom' => $this->years,
            'tahunList' => collect($this->years),
            'chartData' => $chartData,

            'rekapKabupaten' => $rekapKabupaten,
            'rekapJenis' => $rekapJenis,

            'searchKabupaten' => $searchKabupaten,
            'searchJenis' => $searchJenis,

            // Variabel lama agar view public lama tidak langsung error
            'rekapKab' => $rekapKabupaten,
            'rekapJenisOld' => $rekapJenis,
            'searchKab' => $searchKabupaten,
            'totalKab' => method_exists($rekapKabupaten, 'total') ? $rekapKabupaten->total() : 0,
            'pageKab' => method_exists($rekapKabupaten, 'currentPage') ? $rekapKabupaten->currentPage() : 1,
            'perPage' => method_exists($rekapKabupaten, 'perPage') ? $rekapKabupaten->perPage() : 10,
            'totalJenis' => method_exists($rekapJenis, 'total') ? $rekapJenis->total() : 0,
            'pageJenis' => method_exists($rekapJenis, 'currentPage') ? $rekapJenis->currentPage() : 1,
            'perPageJenis' => method_exists($rekapJenis, 'perPage') ? $rekapJenis->perPage() : 10,
        ]);
    }

    /*
    |--------------------------------------------------------------------------
    | REKAP PPKS PER KABUPATEN
    |--------------------------------------------------------------------------
    */

    private function getRekapKabupaten(?string $search)
    {
        $query = Kabupaten::query()
            ->select('id', 'nama_kabupaten')
            ->whereHas('ppksKabupatens')
            ->orderBy('nama_kabupaten');

        if (!empty($search)) {
            $query->where('nama_kabupaten', 'like', '%' . $search . '%');
        }

        $kabupatens = $query
            ->paginate(10, ['*'], 'kabupaten_page')
            ->withQueryString();

        $kabupatenIds = $kabupatens->getCollection()->pluck('id');

        $values = PpksKabupaten::query()
            ->whereIn('kabupaten_id', $kabupatenIds)
            ->get()
            ->groupBy('kabupaten_id');

        $kabupatens->getCollection()->transform(function ($kabupaten) use ($values) {
            $yearValues = [];

            foreach ($this->years as $year) {
                $data = $values
                    ->get($kabupaten->id, collect())
                    ->firstWhere('tahun', $year);

                $yearValues[$year] = $data?->jumlah ?? 0;
            }

            $kabupaten->nama = $kabupaten->nama_kabupaten;
            $kabupaten->data = $yearValues;
            $kabupaten->year_values = $yearValues;

            return $kabupaten;
        });

        return $kabupatens;
    }

    /*
    |--------------------------------------------------------------------------
    | REKAP PPKS PER JENIS
    |--------------------------------------------------------------------------
    */

    private function getRekapJenis(?string $search)
    {
        $query = PpksJenis::query()
            ->select('jenis_ppks')
            ->groupBy('jenis_ppks')
            ->orderBy('jenis_ppks');

        if (!empty($search)) {
            $query->where('jenis_ppks', 'like', '%' . $search . '%');
        }

        $jenisList = $query
            ->paginate(10, ['*'], 'jenis_page')
            ->withQueryString();

        $jenisNames = $jenisList->getCollection()->pluck('jenis_ppks');

        $values = PpksJenis::query()
            ->whereIn('jenis_ppks', $jenisNames)
            ->get()
            ->groupBy('jenis_ppks');

        $jenisList->getCollection()->transform(function ($row) use ($values) {
            $yearValues = [];

            foreach ($this->years as $year) {
                $data = $values
                    ->get($row->jenis_ppks, collect())
                    ->firstWhere('tahun', $year);

                $yearValues[$year] = $data?->jumlah ?? 0;
            }

            $row->nama = $row->jenis_ppks;
            $row->data = $yearValues;
            $row->year_values = $yearValues;

            return $row;
        });

        return $jenisList;
    }
}