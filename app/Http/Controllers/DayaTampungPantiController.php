<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Panti;

class DayaTampungPantiController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | HALAMAN DAYA TAMPUNG PANTI
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
        | QUERY DATA PANTI
        |--------------------------------------------------------------------------
        */
        $panti = Panti::when($search, function ($q) use ($search) {
                $q->where('nama_panti', 'like', "%{$search}%")
                  ->orWhere('kabupaten', 'like', "%{$search}%");
            })
            ->orderBy('id')
            ->paginate(10)
            ->withQueryString();

        return view('daya-tampung-panti', compact('panti', 'search'));
    }
}