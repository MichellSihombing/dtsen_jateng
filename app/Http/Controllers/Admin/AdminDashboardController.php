<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Kabupaten;
use App\Models\Kecamatan;
use App\Models\Desa;
use App\Models\NikPenduduk;

class AdminDashboardController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | DASHBOARD ADMIN
    |--------------------------------------------------------------------------
    */

    public function index()
    {
        if (!session('admin_logged_in')) {
            return redirect()->route('admin.login');
        }

        return view('admin.dashboard', [
            'totalKabupaten' => Kabupaten::count(),
            'totalKecamatan' => Kecamatan::count(),
            'totalDesa' => Desa::count(),
            'totalNik' => NikPenduduk::count(),
        ]);
    }
}