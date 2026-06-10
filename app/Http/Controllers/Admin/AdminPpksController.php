<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Kabupaten;
use App\Models\PpksKabupaten;
use App\Models\PpksJenis;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminPpksController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | DAFTAR TAHUN PPKS
    |--------------------------------------------------------------------------
    */

    private array $years = [
        2015, 2016, 2017, 2018, 2019, 2020,
        2021, 2022, 2023, 2024, 2025,
    ];

    /*
    |--------------------------------------------------------------------------
    | HALAMAN DATA PPKS
    |--------------------------------------------------------------------------
    */

    public function index(Request $request)
    {
        /*
        |--------------------------------------------------------------------------
        | AMBIL MODE DAN PENCARIAN
        |--------------------------------------------------------------------------
        */

        $mode = $request->query('mode', 'cards');
        $search = $request->query('search');

        /*
        |--------------------------------------------------------------------------
        | AMBIL DATA KABUPATEN
        |--------------------------------------------------------------------------
        */

        $kabupatens = Kabupaten::query()
            ->orderBy('nama_kabupaten')
            ->get();

        $kabupatenRows = collect();
        $jenisRows = collect();

        /*
        |--------------------------------------------------------------------------
        | TENTUKAN DATA BERDASARKAN MODE
        |--------------------------------------------------------------------------
        */

        if ($mode === 'kabupaten') {
            $kabupatenRows = $this->getKabupatenRows($search);
        }

        if ($mode === 'jenis') {
            $jenisRows = $this->getJenisRows($search);
        }

        /*
        |--------------------------------------------------------------------------
        | TAMPILKAN HALAMAN PPKS
        |--------------------------------------------------------------------------
        */

        return view('admin.data-master.ppks.index', [
            'mode' => $mode,
            'years' => $this->years,
            'search' => $search,
            'kabupatens' => $kabupatens,
            'kabupatenRows' => $kabupatenRows,
            'jenisRows' => $jenisRows,
        ]);
    }

    /*
    |--------------------------------------------------------------------------
    | DATA PPKS PER KABUPATEN
    |--------------------------------------------------------------------------
    */

    private function getKabupatenRows(?string $search)
    {
        /*
        |--------------------------------------------------------------------------
        | QUERY KABUPATEN
        |--------------------------------------------------------------------------
        */

        $query = Kabupaten::query()
            ->select('id', 'nama_kabupaten')
            ->orderBy('nama_kabupaten');

        /*
        |--------------------------------------------------------------------------
        | FILTER KABUPATEN
        |--------------------------------------------------------------------------
        */

        /*
        |--------------------------------------------------------------------------
        | FILTER JENIS PPKS
        |--------------------------------------------------------------------------
        */

        if (!empty($search)) {
            $query->where('nama_kabupaten', 'like', '%' . $search . '%');
        }

        /*
        |--------------------------------------------------------------------------
        | PAGINASI KABUPATEN
        |--------------------------------------------------------------------------
        */

        $kabupatens = $query->paginate(10)->withQueryString();

        $kabupatenIds = $kabupatens->getCollection()->pluck('id');

        /*
        |--------------------------------------------------------------------------
        | AMBIL NILAI PPKS KABUPATEN
        |--------------------------------------------------------------------------
        */

        $values = PpksKabupaten::query()
            ->whereIn('kabupaten_id', $kabupatenIds)
            ->get()
            ->groupBy('kabupaten_id');

        /*
        |--------------------------------------------------------------------------
        | SUSUN NILAI PER TAHUN
        |--------------------------------------------------------------------------
        */

        $kabupatens->getCollection()->transform(function ($kabupaten) use ($values) {
            $yearValues = [];

            foreach ($this->years as $year) {
                $data = $values
                    ->get($kabupaten->id, collect())
                    ->firstWhere('tahun', $year);

                $yearValues[$year] = $data?->jumlah ?? 0;
            }

            $kabupaten->year_values = $yearValues;

            return $kabupaten;
        });

        return $kabupatens;
    }

    /*
    |--------------------------------------------------------------------------
    | DATA PPKS PER JENIS
    |--------------------------------------------------------------------------
    */

    private function getJenisRows(?string $search)
    {
        /*
        |--------------------------------------------------------------------------
        | QUERY JENIS PPKS
        |--------------------------------------------------------------------------
        */

        $query = PpksJenis::query()
            ->select('jenis_ppks')
            ->groupBy('jenis_ppks')
            ->orderBy('jenis_ppks');

        if (!empty($search)) {
            $query->where('jenis_ppks', 'like', '%' . $search . '%');
        }

        /*
        |--------------------------------------------------------------------------
        | PAGINASI JENIS PPKS
        |--------------------------------------------------------------------------
        */

        $jenisList = $query->paginate(10)->withQueryString();

        $jenisNames = $jenisList->getCollection()->pluck('jenis_ppks');

        /*
        |--------------------------------------------------------------------------
        | AMBIL NILAI PPKS JENIS
        |--------------------------------------------------------------------------
        */

        $values = PpksJenis::query()
            ->whereIn('jenis_ppks', $jenisNames)
            ->get()
            ->groupBy('jenis_ppks');

        /*
        |--------------------------------------------------------------------------
        | SUSUN NILAI JENIS PER TAHUN
        |--------------------------------------------------------------------------
        */

        $jenisList->getCollection()->transform(function ($row) use ($values) {
            $yearValues = [];

            foreach ($this->years as $year) {
                $data = $values
                    ->get($row->jenis_ppks, collect())
                    ->firstWhere('tahun', $year);

                $yearValues[$year] = $data?->jumlah ?? 0;
            }

            $row->year_values = $yearValues;

            return $row;
        });

        return $jenisList;
    }

    /*
    |--------------------------------------------------------------------------
    | SIMPAN PPKS KABUPATEN
    |--------------------------------------------------------------------------
    */

    public function storeKabupaten(Request $request)
    {
        /*
        |--------------------------------------------------------------------------
        | VALIDASI INPUT
        |--------------------------------------------------------------------------
        */

        /*
        |--------------------------------------------------------------------------
        | VALIDASI UPDATE
        |--------------------------------------------------------------------------
        */

        /*
        |--------------------------------------------------------------------------
        | VALIDASI JENIS PPKS
        |--------------------------------------------------------------------------
        */

        /*
        |--------------------------------------------------------------------------
        | VALIDASI UPDATE JENIS
        |--------------------------------------------------------------------------
        */

        /*
        |--------------------------------------------------------------------------
        | VALIDASI HAPUS JENIS
        |--------------------------------------------------------------------------
        */

        $validated = $request->validate([
            'kabupaten_id' => ['required', 'exists:kabupatens,id'],
        ]);

        /*
        |--------------------------------------------------------------------------
        | BUAT DATA AWAL PER TAHUN
        |--------------------------------------------------------------------------
        */

        foreach ($this->years as $year) {
            PpksKabupaten::firstOrCreate(
                [
                    'kabupaten_id' => $validated['kabupaten_id'],
                    'tahun' => $year,
                ],
                [
                    'jumlah' => 0,
                ]
            );
        }

        return redirect()
            ->route('admin.ppks.index', ['mode' => 'kabupaten'])
            ->with('success', 'Data kabupaten/kota berhasil ditambahkan ke rekap PPKS.');
    }

    /*
    |--------------------------------------------------------------------------
    | UPDATE PPKS KABUPATEN
    |--------------------------------------------------------------------------
    */

    public function updateKabupaten(Request $request, int $kabupatenId)
    {
        $validated = $request->validate([
            'jumlah' => ['required', 'array'],
            'jumlah.*' => ['nullable', 'integer', 'min:0'],
        ]);

        /*
        |--------------------------------------------------------------------------
        | AMBIL DATA KABUPATEN
        |--------------------------------------------------------------------------
        */

        $kabupaten = Kabupaten::findOrFail($kabupatenId);

        /*
        |--------------------------------------------------------------------------
        | UPDATE JUMLAH PER TAHUN
        |--------------------------------------------------------------------------
        */

        foreach ($this->years as $year) {
            $jumlah = $validated['jumlah'][$year] ?? 0;

            PpksKabupaten::updateOrCreate(
                [
                    'kabupaten_id' => $kabupaten->id,
                    'tahun' => $year,
                ],
                [
                    'jumlah' => $jumlah,
                ]
            );
        }

        return redirect()
            ->route('admin.ppks.index', ['mode' => 'kabupaten'])
            ->with('success', 'Data rekap PPKS per kabupaten/kota berhasil diperbarui.');
    }

    /*
    |--------------------------------------------------------------------------
    | HAPUS PPKS KABUPATEN
    |--------------------------------------------------------------------------
    */

    public function destroyKabupaten(int $kabupatenId)
    {
        /*
        |--------------------------------------------------------------------------
        | AMBIL DATA KABUPATEN
        |--------------------------------------------------------------------------
        */

        $kabupaten = Kabupaten::findOrFail($kabupatenId);

        /*
        |--------------------------------------------------------------------------
        | HAPUS REKAP KABUPATEN
        |--------------------------------------------------------------------------
        */

        PpksKabupaten::where('kabupaten_id', $kabupaten->id)->delete();

        return redirect()
            ->route('admin.ppks.index', ['mode' => 'kabupaten'])
            ->with('success', 'Data rekap PPKS per kabupaten/kota berhasil dihapus.');
    }

    /*
    |--------------------------------------------------------------------------
    | SIMPAN JENIS PPKS
    |--------------------------------------------------------------------------
    */

    public function storeJenis(Request $request)
    {
        $validated = $request->validate([
            'jenis_ppks' => ['required', 'string', 'max:255'],
        ]);

        $jenisPpks = trim($validated['jenis_ppks']);

        /*
        |--------------------------------------------------------------------------
        | BUAT JENIS PER TAHUN
        |--------------------------------------------------------------------------
        */

        foreach ($this->years as $year) {
            PpksJenis::firstOrCreate(
                [
                    'jenis_ppks' => $jenisPpks,
                    'tahun' => $year,
                ],
                [
                    'jumlah' => 0,
                ]
            );
        }

        return redirect()
            ->route('admin.ppks.index', ['mode' => 'jenis'])
            ->with('success', 'Jenis PPKS berhasil ditambahkan.');
    }

    /*
    |--------------------------------------------------------------------------
    | UPDATE JENIS PPKS
    |--------------------------------------------------------------------------
    */

    public function updateJenis(Request $request)
    {
        $validated = $request->validate([
            'jenis_key' => ['required', 'string', 'max:255'],
            'jenis_ppks' => ['required', 'string', 'max:255'],
            'jumlah' => ['required', 'array'],
            'jumlah.*' => ['nullable', 'integer', 'min:0'],
        ]);

        $oldJenis = trim($validated['jenis_key']);
        $newJenis = trim($validated['jenis_ppks']);

        /*
        |--------------------------------------------------------------------------
        | TRANSAKSI UPDATE JENIS
        |--------------------------------------------------------------------------
        */

        DB::transaction(function () use ($validated, $oldJenis, $newJenis) {
            if ($oldJenis !== $newJenis) {
                PpksJenis::where('jenis_ppks', $oldJenis)
                    ->update([
                        'jenis_ppks' => $newJenis,
                    ]);
            }

            foreach ($this->years as $year) {
                $jumlah = $validated['jumlah'][$year] ?? 0;

                PpksJenis::updateOrCreate(
                    [
                        'jenis_ppks' => $newJenis,
                        'tahun' => $year,
                    ],
                    [
                        'jumlah' => $jumlah,
                    ]
                );
            }
        });

        return redirect()
            ->route('admin.ppks.index', ['mode' => 'jenis'])
            ->with('success', 'Data rekap PPKS per jenis berhasil diperbarui.');
    }

    /*
    |--------------------------------------------------------------------------
    | HAPUS JENIS PPKS
    |--------------------------------------------------------------------------
    */

    public function destroyJenis(Request $request)
    {
        $validated = $request->validate([
            'jenis_key' => ['required', 'string', 'max:255'],
        ]);

        /*
        |--------------------------------------------------------------------------
        | HAPUS DATA JENIS
        |--------------------------------------------------------------------------
        */

        PpksJenis::where('jenis_ppks', trim($validated['jenis_key']))->delete();

        return redirect()
            ->route('admin.ppks.index', ['mode' => 'jenis'])
            ->with('success', 'Data rekap PPKS per jenis berhasil dihapus.');
    }
}