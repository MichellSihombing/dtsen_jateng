<?php

namespace App\Http\Controllers;

use App\Models\Kabupaten;
use App\Models\Kecamatan;
use App\Models\Desa;
use App\Models\NikPenduduk;
use Illuminate\Http\Request;

class BerandaController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | HALAMAN BERANDA
    |--------------------------------------------------------------------------
    */
    public function index()
    {
        /*
        |--------------------------------------------------------------------------
        | AMBIL DATA KABUPATEN
        |--------------------------------------------------------------------------
        */
        $kabupaten = Kabupaten::query()
            ->orderBy('nama_kabupaten')
            ->get();

        return view('beranda', [
            'kabupaten' => $kabupaten,
            'hasilCek' => session('hasilCek'),
            'hasilSpmb' => session('hasilSpmb'),
            'activeResultTab' => session('activeResultTab'),
        ]);
    }

    /*
    |--------------------------------------------------------------------------
    | CEK KEPESERTAAN DTSEN
    |--------------------------------------------------------------------------
    */

    public function cekKepesertaan(Request $request)
    {
        /*
        |--------------------------------------------------------------------------
        | VALIDASI FORM NIK
        |--------------------------------------------------------------------------
        */
        $request->validate([
            'kabupaten' => ['required', 'exists:kabupatens,id'],
            'kecamatan' => ['required', 'exists:kecamatans,id'],
            'desa' => ['required', 'exists:desas,id'],
            'nik' => ['required', 'digits:16'],
        ], [
            'kabupaten.required' => 'Kabupaten/Kota wajib dipilih.',
            'kabupaten.exists' => 'Kabupaten/Kota tidak valid.',
            'kecamatan.required' => 'Kecamatan wajib dipilih.',
            'kecamatan.exists' => 'Kecamatan tidak valid.',
            'desa.required' => 'Desa/Kelurahan wajib dipilih.',
            'desa.exists' => 'Desa/Kelurahan tidak valid.',
            'nik.required' => 'NIK wajib diisi.',
            'nik.digits' => 'NIK harus berisi 16 digit angka.',
        ]);

        $kabupatenDipilih = Kabupaten::find($request->kabupaten);
        $kecamatanDipilih = Kecamatan::find($request->kecamatan);
        $desaDipilih = Desa::find($request->desa);

        /*
        |--------------------------------------------------------------------------
        | CARI DATA PENDUDUK
        |--------------------------------------------------------------------------
        */
        $penduduk = NikPenduduk::query()
            ->where('nik', $request->nik)
            ->where('kabupaten_id', $request->kabupaten)
            ->where('kecamatan_id', $request->kecamatan)
            ->where('desa_id', $request->desa)
            ->first();

        if ($penduduk) {
            $hasilCek = [
                'terdaftar' => true,
                'kabupaten' => $kabupatenDipilih?->nama_kabupaten ?? '-',
                'kecamatan' => $kecamatanDipilih?->nama_kecamatan ?? '-',
                'desa' => $desaDipilih?->nama_desa ?? '-',
                'nama' => $penduduk->nama_lengkap
                    ?? $penduduk->nama
                    ?? '-',
                'status' => $penduduk->status_dtsen
                    ?? $penduduk->status
                    ?? 'Terdaftar',
            ];
        } else {
            $hasilCek = [
                'terdaftar' => false,
                'kabupaten' => $kabupatenDipilih?->nama_kabupaten ?? '-',
                'kecamatan' => $kecamatanDipilih?->nama_kecamatan ?? '-',
                'desa' => $desaDipilih?->nama_desa ?? '-',
                'nama' => '-',
                'status' => 'Belum Terdaftar',
            ];
        }

        return redirect()
            ->route('beranda')
            ->with('hasilCek', $hasilCek)
            ->with('hasilSpmb', null)
            ->with('activeResultTab', 'nik');
    }

    /*
    |--------------------------------------------------------------------------
    | CEK AFIRMASI SPMB
    |--------------------------------------------------------------------------
    */

    public function cekSpmb(Request $request)
    {
        /*
        |--------------------------------------------------------------------------
        | VALIDASI FORM SPMB
        |--------------------------------------------------------------------------
        */
        $request->validate([
            'nik_spmb' => ['required', 'digits:16'],
        ], [
            'nik_spmb.required' => 'NIK wajib diisi.',
            'nik_spmb.digits' => 'NIK harus berisi 16 digit angka.',
        ]);

        $penduduk = NikPenduduk::with(['kabupaten', 'kecamatan', 'desa'])
            ->where('nik', $request->nik_spmb)
            ->first();

        if ($penduduk) {
            $desilNasional = (int) ($penduduk->desil_nasional ?? 1);

            $hasilSpmb = [
                'terdaftar' => true,
                'nik' => $penduduk->nik,
                'nama' => $penduduk->nama_lengkap
                    ?? $penduduk->nama
                    ?? '-',
                'kabupaten' => $penduduk->kabupaten?->nama_kabupaten ?? '-',
                'kecamatan' => $penduduk->kecamatan?->nama_kecamatan ?? '-',
                'desa' => $penduduk->desa?->nama_desa ?? '-',
                'desil_nasional' => $desilNasional,
                'status_kelayakan' => $this->getStatusKelayakanSpmb($desilNasional),
            ];
        } else {
            $hasilSpmb = [
                'terdaftar' => false,
                'nik' => $request->nik_spmb,
                'nama' => '-',
                'kabupaten' => '-',
                'kecamatan' => '-',
                'desa' => '-',
                'desil_nasional' => '-',
                'status_kelayakan' => 'Tidak Masuk Afirmasi',
            ];
        }

        return redirect()
            ->route('beranda')
            ->with('hasilCek', null)
            ->with('hasilSpmb', $hasilSpmb)
            ->with('activeResultTab', 'spmb');
    }

    /*
    |--------------------------------------------------------------------------
    | STATUS KELAYAKAN SPMB
    |--------------------------------------------------------------------------
    */

    private function getStatusKelayakanSpmb(int $desilNasional): string
    {
        return $desilNasional >= 1 && $desilNasional <= 4
            ? 'Masuk Afirmasi'
            : 'Tidak Masuk Afirmasi';
    }
}