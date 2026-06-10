<?php

namespace App\Http\Controllers;

use App\Models\Kabupaten;
use Illuminate\Http\Request;

class PetaController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | HALAMAN PETA
    |--------------------------------------------------------------------------
    */

    public function index(Request $request)
    {
        /*
        |--------------------------------------------------------------------------
        | DATA AWAL KABUPATEN
        |--------------------------------------------------------------------------
        */

        $kabupatens = Kabupaten::query()
            ->orderBy('nama_kabupaten')
            ->get();

        return view('peta.index', [
            'kabupatens' => $kabupatens,
        ]);
    }
}