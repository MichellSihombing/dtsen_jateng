<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\BerandaController;
use App\Http\Controllers\DayaTampungPantiController;
use App\Http\Controllers\PpksController;
use App\Http\Controllers\PsksController;
use App\Http\Controllers\DtJatengController;

use App\Http\Controllers\PetaController;
use App\Http\Controllers\WilayahController;
use App\Http\Controllers\GeoJSONController;
use App\Http\Controllers\DummySosialController;
use App\Http\Controllers\FilterController;

use App\Http\Controllers\Admin\AdminAuthController;
use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\AdminWilayahController;
use App\Http\Controllers\Admin\AdminNikController;
use App\Http\Controllers\Admin\AdminDataMasterController;
use App\Http\Controllers\Admin\AdminPpksController;

/*
|--------------------------------------------------------------------------
| HALAMAN PUBLIK
|--------------------------------------------------------------------------
*/

Route::get('/', [BerandaController::class, 'index'])
    ->name('beranda');

Route::get('/peta', [PetaController::class, 'index'])
    ->name('peta');

Route::get('/daya-tampung-panti', [DayaTampungPantiController::class, 'index'])
    ->name('daya-tampung-panti');

Route::get('/ppks', [PpksController::class, 'index'])
    ->name('ppks.index');

Route::get('/psks', [PsksController::class, 'index'])
    ->name('psks.index');

Route::get('/dt-jateng', [DtJatengController::class, 'index'])
    ->name('dt-jateng.index');

/*
|--------------------------------------------------------------------------
| FORM PUBLIK BERANDA
|--------------------------------------------------------------------------
*/

Route::post('/cek-kepesertaan', [BerandaController::class, 'cekKepesertaan'])
    ->name('cek.kepesertaan');

Route::post('/cek-spmb', [BerandaController::class, 'cekSpmb'])
    ->name('cek.spmb');

/*
|--------------------------------------------------------------------------
| LOGIN DAN LOGOUT ADMIN
|--------------------------------------------------------------------------
*/

Route::get('/panel-manage', [AdminAuthController::class, 'loginPage'])
    ->name('admin.login');

Route::post('/panel-login', [AdminAuthController::class, 'login'])
    ->name('admin.login.process');

Route::post('/panel-logout', [AdminAuthController::class, 'logout'])
    ->name('admin.logout');

/*
|--------------------------------------------------------------------------
| DASHBOARD ADMIN
|--------------------------------------------------------------------------
*/

Route::get('/home', [AdminDashboardController::class, 'index'])
    ->name('admin.dashboard');

/*
|--------------------------------------------------------------------------
| KELOLA DATA WILAYAH
|--------------------------------------------------------------------------
*/

Route::prefix('admin/wilayah')
    ->name('admin.wilayah.')
    ->group(function () {
        Route::get('/', [AdminWilayahController::class, 'index'])
            ->name('index');

        Route::post('/store', [AdminWilayahController::class, 'store'])
            ->name('store');

        Route::put('/{type}/{id}', [AdminWilayahController::class, 'update'])
            ->name('update');

        Route::delete('/{type}/{id}', [AdminWilayahController::class, 'destroy'])
            ->name('destroy');
    });

/*
|--------------------------------------------------------------------------
| KELOLA DATA NIK
|--------------------------------------------------------------------------
*/

Route::prefix('admin/nik')
    ->name('admin.nik.')
    ->group(function () {
        Route::get('/', [AdminNikController::class, 'index'])
            ->name('index');

        Route::post('/store', [AdminNikController::class, 'store'])
            ->name('store');

        Route::put('/{id}', [AdminNikController::class, 'update'])
            ->name('update');

        Route::delete('/{id}', [AdminNikController::class, 'destroy'])
            ->name('destroy');
    });

/*
|--------------------------------------------------------------------------
| KELOLA DATA PPKS ADMIN
|--------------------------------------------------------------------------
*/

Route::prefix('admin/data/ppks')
    ->name('admin.ppks.')
    ->group(function () {
        Route::get('/', [AdminPpksController::class, 'index'])
            ->name('index');

        Route::post('/kabupaten', [AdminPpksController::class, 'storeKabupaten'])
            ->name('kabupaten.store');

        Route::put('/kabupaten/{kabupatenId}', [AdminPpksController::class, 'updateKabupaten'])
            ->name('kabupaten.update');

        Route::delete('/kabupaten/{kabupatenId}', [AdminPpksController::class, 'destroyKabupaten'])
            ->name('kabupaten.destroy');

        Route::post('/jenis', [AdminPpksController::class, 'storeJenis'])
            ->name('jenis.store');

        Route::put('/jenis', [AdminPpksController::class, 'updateJenis'])
            ->name('jenis.update');

        Route::delete('/jenis', [AdminPpksController::class, 'destroyJenis'])
            ->name('jenis.destroy');
    });

/*
|--------------------------------------------------------------------------
| KELOLA DATA MASTER
|--------------------------------------------------------------------------
*/

Route::prefix('admin/data')
    ->name('admin.data.')
    ->group(function () {

        /*
        |--------------------------------------------------------------------------
        | KELOLA JENIS PSKS
        |--------------------------------------------------------------------------
        */

        Route::post('/psks/jenis/store', [AdminDataMasterController::class, 'storePsksJenis'])
            ->name('psks.jenis.store');

        Route::post('/psks/jenis/update', [AdminDataMasterController::class, 'updatePsksJenis'])
            ->name('psks.jenis.update');

        Route::post('/psks/jenis/delete', [AdminDataMasterController::class, 'deletePsksJenis'])
            ->name('psks.jenis.delete');

        /*
        |--------------------------------------------------------------------------
        | ROUTE GENERIC DATA MASTER
        |--------------------------------------------------------------------------
        */

        Route::get('/{module}', [AdminDataMasterController::class, 'index'])
            ->whereIn('module', ['panti', 'dt-jateng', 'psks', 'pks'])
            ->name('index');

        Route::post('/{module}', [AdminDataMasterController::class, 'store'])
            ->whereIn('module', ['panti', 'dt-jateng', 'psks', 'pks'])
            ->name('store');

        Route::put('/{module}/{id}', [AdminDataMasterController::class, 'update'])
            ->whereIn('module', ['panti', 'dt-jateng', 'psks', 'pks'])
            ->name('update');

        Route::delete('/{module}/{id}', [AdminDataMasterController::class, 'destroy'])
            ->whereIn('module', ['panti', 'dt-jateng', 'psks', 'pks'])
            ->name('destroy');
    });

/*
|--------------------------------------------------------------------------
| API WILAYAH DAN PETA
|--------------------------------------------------------------------------
*/

Route::prefix('api')->group(function () {

    /*
    |--------------------------------------------------------------------------
    | API DROPDOWN WILAYAH
    |--------------------------------------------------------------------------
    */

    Route::get('/kabupaten', [WilayahController::class, 'getKabupaten'])
        ->name('api.kabupaten');

    Route::get('/kecamatan/{kabupatenId}', [WilayahController::class, 'getKecamatan'])
        ->name('api.kecamatan');

    Route::get('/desa/{kecamatanId}', [WilayahController::class, 'getDesa'])
        ->name('api.desa');

    /*
    |--------------------------------------------------------------------------
    | API GEOJSON WILAYAH
    |--------------------------------------------------------------------------
    */

    Route::get('/geojson/{level}/{id}', [GeoJSONController::class, 'getGeoJSON'])
        ->name('api.geojson');

    /*
    |--------------------------------------------------------------------------
    | API FILTER DESIL
    |--------------------------------------------------------------------------
    */

    Route::post('/filter', [FilterController::class, 'filter'])
        ->name('api.filter');

    Route::post('/filter/reset', [FilterController::class, 'reset'])
        ->name('api.filter.reset');

    /*
    |--------------------------------------------------------------------------
    | API DUMMY SOSIAL
    |--------------------------------------------------------------------------
    */

    Route::post('/dummy-sosial/filter', [DummySosialController::class, 'filter'])
        ->name('api.dummy-sosial.filter');

    /*
    |--------------------------------------------------------------------------
    | API CEK NIK
    |--------------------------------------------------------------------------
    */

    Route::get('/cek-nik/{nik}', [AdminNikController::class, 'publicCheck'])
        ->name('api.cek-nik');
});