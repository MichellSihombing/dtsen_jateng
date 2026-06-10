<?php

namespace App\Http\Controllers;

use App\Models\DtJateng;
use Illuminate\Http\Request;

class DtJatengController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | HALAMAN DT JATENG
    |--------------------------------------------------------------------------
    */

    public function index(Request $request)
    {
        /*
        |--------------------------------------------------------------------------
        | AMBIL KEYWORD PENCARIAN
        |--------------------------------------------------------------------------
        */
        $search = $request->input('search', '');

        /*
        |--------------------------------------------------------------------------
        | QUERY DATA DT JATENG
        |--------------------------------------------------------------------------
        */
        $query = DtJateng::with('kabupaten');

        if ($search) {
            $query->whereHas('kabupaten', function ($q) use ($search) {
                $q->where('nama_kabupaten', 'like', "%{$search}%");
            });
        }

        $perPage = (int) $request->input('per_page', 10);

        $dtJateng = $query->paginate($perPage)->appends($request->query());

        return view('dt-jateng.index', compact('dtJateng', 'search'));
    }
}