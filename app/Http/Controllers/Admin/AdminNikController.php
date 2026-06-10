<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Kabupaten;
use App\Models\NikPenduduk;
use Illuminate\Http\Request;

class AdminNikController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | CEK LOGIN ADMIN
    |--------------------------------------------------------------------------
    */

    private function checkAdmin()
    {
        if (!session('admin_logged_in')) {
            return redirect()->route('admin.login');
        }

        return null;
    }

    /*
    |--------------------------------------------------------------------------
    | HALAMAN DATA NIK
    |--------------------------------------------------------------------------
    */

    public function index(Request $request)
    {
        if ($redirect = $this->checkAdmin()) {
            return $redirect;
        }

        /*
        |--------------------------------------------------------------------------
        | AMBIL KEYWORD PENCARIAN
        |--------------------------------------------------------------------------
        */

        $search = $request->input('search');

        /*
        |--------------------------------------------------------------------------
        | QUERY DATA NIK
        |--------------------------------------------------------------------------
        */

        $query = NikPenduduk::with(['kabupaten', 'kecamatan', 'desa'])
            ->latest();

        /*
        |--------------------------------------------------------------------------
        | FILTER PENCARIAN NIK
        |--------------------------------------------------------------------------
        */

        if ($request->filled('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('nik', 'like', "%{$search}%")
                    ->orWhere('nama_lengkap', 'like', "%{$search}%")
                    ->orWhere('status_dtsen', 'like', "%{$search}%")
                    ->orWhere('desil_nasional', 'like', "%{$search}%")
                    ->orWhereHas('kabupaten', function ($kabupatenQuery) use ($search) {
                        $kabupatenQuery->where('nama_kabupaten', 'like', "%{$search}%");
                    })
                    ->orWhereHas('kecamatan', function ($kecamatanQuery) use ($search) {
                        $kecamatanQuery->where('nama_kecamatan', 'like', "%{$search}%");
                    })
                    ->orWhereHas('desa', function ($desaQuery) use ($search) {
                        $desaQuery->where('nama_desa', 'like', "%{$search}%");
                    });
            });
        }

        /*
        |--------------------------------------------------------------------------
        | TAMPILKAN HALAMAN NIK
        |--------------------------------------------------------------------------
        */

        return view('admin.nik.index', [
            'items' => $query->paginate(10)->withQueryString(),
            'kabupatens' => Kabupaten::orderBy('nama_kabupaten')->get(),
            'search' => $search,
        ]);
    }

    /*
    |--------------------------------------------------------------------------
    | SIMPAN DATA NIK
    |--------------------------------------------------------------------------
    */

    public function store(Request $request)
    {
        if ($redirect = $this->checkAdmin()) {
            return $redirect;
        }

        /*
        |--------------------------------------------------------------------------
        | VALIDASI INPUT NIK
        |--------------------------------------------------------------------------
        */

        /*
        |--------------------------------------------------------------------------
        | VALIDASI UPDATE NIK
        |--------------------------------------------------------------------------
        */

        $validated = $request->validate([
            'nik' => ['required', 'digits:16', 'unique:nik_penduduks,nik'],
            'nama_lengkap' => ['required', 'string', 'max:150'],
            'status_dtsen' => ['required', 'in:Terdata,Tidak Terdata,Perlu Verifikasi'],
            'desil_nasional' => ['required', 'integer', 'min:1', 'max:10'],

            'kabupaten_id' => ['required', 'exists:kabupatens,id'],
            'kecamatan_id' => ['required', 'exists:kecamatans,id'],
            'desa_id' => ['required', 'exists:desas,id'],

            'jenis_kelamin' => ['nullable', 'in:Laki-laki,Perempuan'],
            'tanggal_lahir' => ['nullable', 'date'],
            'alamat' => ['nullable', 'string', 'max:255'],
            'keterangan' => ['nullable', 'string', 'max:255'],
        ]);

        /*
        |--------------------------------------------------------------------------
        | TAMBAH DATA NIK
        |--------------------------------------------------------------------------
        */

        NikPenduduk::create($validated);

        return redirect()
            ->route('admin.nik.index')
            ->with('success', 'Data NIK berhasil ditambahkan.');
    }

    /*
    |--------------------------------------------------------------------------
    | UPDATE DATA NIK
    |--------------------------------------------------------------------------
    */

    public function update(Request $request, int $id)
    {
        if ($redirect = $this->checkAdmin()) {
            return $redirect;
        }

        /*
        |--------------------------------------------------------------------------
        | AMBIL DATA NIK
        |--------------------------------------------------------------------------
        */

        $item = NikPenduduk::findOrFail($id);

        $validated = $request->validate([
            'nik' => ['required', 'digits:16', 'unique:nik_penduduks,nik,' . $item->id],
            'nama_lengkap' => ['required', 'string', 'max:150'],
            'status_dtsen' => ['required', 'in:Terdata,Tidak Terdata,Perlu Verifikasi'],
            'desil_nasional' => ['required', 'integer', 'min:1', 'max:10'],

            'kabupaten_id' => ['required', 'exists:kabupatens,id'],
            'kecamatan_id' => ['required', 'exists:kecamatans,id'],
            'desa_id' => ['required', 'exists:desas,id'],

            'jenis_kelamin' => ['nullable', 'in:Laki-laki,Perempuan'],
            'tanggal_lahir' => ['nullable', 'date'],
            'alamat' => ['nullable', 'string', 'max:255'],
            'keterangan' => ['nullable', 'string', 'max:255'],
        ]);

        /*
        |--------------------------------------------------------------------------
        | SIMPAN PERUBAHAN NIK
        |--------------------------------------------------------------------------
        */

        $item->update($validated);

        return redirect()
            ->route('admin.nik.index')
            ->with('success', 'Data NIK berhasil diperbarui.');
    }

    /*
    |--------------------------------------------------------------------------
    | HAPUS DATA NIK
    |--------------------------------------------------------------------------
    */

    public function destroy(int $id)
    {
        if ($redirect = $this->checkAdmin()) {
            return $redirect;
        }

        /*
        |--------------------------------------------------------------------------
        | HAPUS DATA DARI DATABASE
        |--------------------------------------------------------------------------
        */

        NikPenduduk::findOrFail($id)->delete();

        return redirect()
            ->route('admin.nik.index')
            ->with('success', 'Data NIK berhasil dihapus.');
    }

    /*
    |--------------------------------------------------------------------------
    | CEK NIK PUBLIK
    |--------------------------------------------------------------------------
    */

    public function publicCheck(string $nik)
    {
        /*
        |--------------------------------------------------------------------------
        | CARI DATA BERDASARKAN NIK
        |--------------------------------------------------------------------------
        */

        $item = NikPenduduk::with(['kabupaten', 'kecamatan', 'desa'])
            ->where('nik', $nik)
            ->first();

        /*
        |--------------------------------------------------------------------------
        | RESPON NIK TIDAK DITEMUKAN
        |--------------------------------------------------------------------------
        */

        if (!$item) {
            return response()->json([
                'found' => false,
                'message' => 'NIK tidak ditemukan.',
            ], 404);
        }

        /*
        |--------------------------------------------------------------------------
        | RESPON NIK DITEMUKAN
        |--------------------------------------------------------------------------
        */

        return response()->json([
            'found' => true,
            'message' => 'NIK ditemukan.',
            'data' => [
                'nik' => $item->nik,
                'nama_lengkap' => $item->nama_lengkap,
                'jenis_kelamin' => $item->jenis_kelamin,
                'tanggal_lahir' => $item->tanggal_lahir,
                'kabupaten' => $item->kabupaten?->nama_kabupaten,
                'kecamatan' => $item->kecamatan?->nama_kecamatan,
                'desa' => $item->desa?->nama_desa,
                'alamat' => $item->alamat,
                'status_dtsen' => $item->status_dtsen,
                'desil_nasional' => $item->desil_nasional,
                'status_afirmasi' => $this->getStatusAfirmasi((int) $item->desil_nasional),
                'keterangan' => $item->keterangan,
            ],
        ]);
    }

    /*
    |--------------------------------------------------------------------------
    | CEK STATUS AFIRMASI
    |--------------------------------------------------------------------------
    */

    private function getStatusAfirmasi(int $desilNasional): string
    {
        return $desilNasional >= 1 && $desilNasional <= 4
            ? 'Masuk Afirmasi'
            : 'Tidak Masuk Afirmasi';
    }
}