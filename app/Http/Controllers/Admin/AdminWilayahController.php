<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Kabupaten;
use App\Models\Kecamatan;
use App\Models\Desa;
use Illuminate\Http\Request;

class AdminWilayahController extends Controller
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
    | HALAMAN KELOLA WILAYAH
    |--------------------------------------------------------------------------
    */

    public function index(Request $request)
    {
        if ($redirect = $this->checkAdmin()) {
            return $redirect;
        }

        $type = $request->get('type', 'kabupaten');

        $kabupatens = Kabupaten::orderBy('id', 'asc')->get();
        $kecamatans = Kecamatan::with('kabupaten')->orderBy('id', 'asc')->get();

        if ($type === 'kabupaten') {
            $items = Kabupaten::orderBy('id', 'asc')->paginate(20)->withQueryString();
        } elseif ($type === 'kecamatan') {
            $items = Kecamatan::with('kabupaten')->orderBy('id', 'asc')->paginate(20)->withQueryString();
        } else {
            $items = Desa::with('kecamatan.kabupaten')->orderBy('id', 'asc')->paginate(20)->withQueryString();
        }

        return view('admin.wilayah.index', compact(
            'type',
            'items',
            'kabupatens',
            'kecamatans'
        ));
    }

    /*
    |--------------------------------------------------------------------------
    | SIMPAN DATA WILAYAH
    |--------------------------------------------------------------------------
    */

    public function store(Request $request)
    {
        if ($redirect = $this->checkAdmin()) {
            return $redirect;
        }

        $type = $request->input('type');

        if ($type === 'kabupaten') {
            $request->validate([
                'kode_kabupaten' => ['required'],
                'nama_kabupaten' => ['required'],
                'geojson_path' => ['nullable'],
            ]);

            Kabupaten::create([
                'kode_kabupaten' => $request->kode_kabupaten,
                'nama_kabupaten' => $request->nama_kabupaten,
                'geojson_path' => $request->geojson_path,
            ]);
        }

        if ($type === 'kecamatan') {
            $request->validate([
                'kabupaten_id' => ['required', 'exists:kabupatens,id'],
                'kode_kecamatan' => ['required'],
                'nama_kecamatan' => ['required'],
                'geojson_path' => ['nullable'],
            ]);

            Kecamatan::create([
                'kabupaten_id' => $request->kabupaten_id,
                'kode_kecamatan' => $request->kode_kecamatan,
                'nama_kecamatan' => $request->nama_kecamatan,
                'geojson_path' => $request->geojson_path,
            ]);
        }

        if ($type === 'desa') {
            $request->validate([
                'kecamatan_id' => ['required', 'exists:kecamatans,id'],
                'kode_desa' => ['required'],
                'nama_desa' => ['required'],
                'geojson_path' => ['nullable'],
            ]);

            Desa::create([
                'kecamatan_id' => $request->kecamatan_id,
                'kode_desa' => $request->kode_desa,
                'nama_desa' => $request->nama_desa,
                'geojson_path' => $request->geojson_path,
            ]);
        }

        return back()->with('success', 'Data wilayah berhasil ditambahkan.');
    }

    /*
    |--------------------------------------------------------------------------
    | UPDATE DATA WILAYAH
    |--------------------------------------------------------------------------
    */

    public function update(Request $request, string $type, int $id)
    {
        if ($redirect = $this->checkAdmin()) {
            return $redirect;
        }

        if ($type === 'kabupaten') {
            $item = Kabupaten::findOrFail($id);

            $request->validate([
                'kode_kabupaten' => ['required'],
                'nama_kabupaten' => ['required'],
                'geojson_path' => ['nullable'],
            ]);

            $item->update([
                'kode_kabupaten' => $request->kode_kabupaten,
                'nama_kabupaten' => $request->nama_kabupaten,
                'geojson_path' => $request->geojson_path,
            ]);
        }

        if ($type === 'kecamatan') {
            $item = Kecamatan::findOrFail($id);

            $request->validate([
                'kabupaten_id' => ['required', 'exists:kabupatens,id'],
                'kode_kecamatan' => ['required'],
                'nama_kecamatan' => ['required'],
                'geojson_path' => ['nullable'],
            ]);

            $item->update([
                'kabupaten_id' => $request->kabupaten_id,
                'kode_kecamatan' => $request->kode_kecamatan,
                'nama_kecamatan' => $request->nama_kecamatan,
                'geojson_path' => $request->geojson_path,
            ]);
        }

        if ($type === 'desa') {
            $item = Desa::findOrFail($id);

            $request->validate([
                'kecamatan_id' => ['required', 'exists:kecamatans,id'],
                'kode_desa' => ['required'],
                'nama_desa' => ['required'],
                'geojson_path' => ['nullable'],
            ]);

            $item->update([
                'kecamatan_id' => $request->kecamatan_id,
                'kode_desa' => $request->kode_desa,
                'nama_desa' => $request->nama_desa,
                'geojson_path' => $request->geojson_path,
            ]);
        }

        return back()->with('success', 'Data wilayah berhasil diperbarui.');
    }

    /*
    |--------------------------------------------------------------------------
    | HAPUS DATA WILAYAH
    |--------------------------------------------------------------------------
    */

    public function destroy(string $type, int $id)
    {
        if ($redirect = $this->checkAdmin()) {
            return $redirect;
        }

        if ($type === 'kabupaten') {
            Kabupaten::findOrFail($id)->delete();
        }

        if ($type === 'kecamatan') {
            Kecamatan::findOrFail($id)->delete();
        }

        if ($type === 'desa') {
            Desa::findOrFail($id)->delete();
        }

        return back()->with('success', 'Data wilayah berhasil dihapus.');
    }
}