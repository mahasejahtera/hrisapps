<?php

use App\Http\Controllers\Pengajuan\CSRController;
use App\Http\Controllers\Pengajuan\HutangOperasionalController;
use App\Http\Controllers\Pengajuan\OperasionalKantorController;
use App\Http\Controllers\Pengajuan\PelatihanKaryawanController;
use App\Http\Controllers\Pengajuan\ReimbursementController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PengajuanController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Route::get('/', function () {
    return redirect()->route('pengajuan.index');
});

// Pengajuan
Route::group(['prefix' => 'pengajuan'], function () {
    Route::resource('hutangoperasional', HutangOperasionalController::class);
    Route::resource('operasionalkantor', OperasionalKantorController::class);
    Route::resource('pelatihankaryawan', PelatihanKaryawanController::class);
    Route::resource('reimbursement', ReimbursementController::class);
    Route::resource('csr', CSRController::class);
});
Route::resource('pengajuan', PengajuanController::class);
