<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\ExLoginController;
use App\Http\Controllers\Rencanakerja\KaryawanController;
use App\Http\Controllers\Rencanakerja\ManajerController;
use App\Http\Controllers\Rencanakerja\PmController;
use App\Http\Controllers\Rencanakerja\HrdController;
use App\Http\Controllers\Rencanakerja\DirekturController;
use App\Http\Controllers\Rencanakerja\KomisarisController;
use App\Http\Controllers\Admin\RencanaKerjaController;
use App\Http\Controllers\Arsip\ArsipController;

Route::get('/dashboard', [ExLoginController::class, 'dashboard'])->name('dashboard');
//karyawan rkk
Route::prefix('karyawan')->group(function () {
    Route::get('/option', [KaryawanController::class, 'option']);
    Route::get('/listrkk', [KaryawanController::class, 'listrkk'])->name('list-rkk');
    Route::get('/task', [KaryawanController::class, 'task']);
    Route::get('/detail-task', [KaryawanController::class, 'detailtask']);
    Route::get('/add-rkk', [KaryawanController::class, 'addrkk']);
    Route::post('/addrkk/proses', [KaryawanController::class, 'addrkkstore']);
    Route::get('/detailrkk/{id}', [KaryawanController::class, 'detailrkk'])->name('detail-rkk');
    Route::get('/revisi/{id}', [KaryawanController::class, 'revisi'])->name('karyawan-revisi');
    Route::post('/revisi/proses', [KaryawanController::class, 'revisiproses']);
    Route::get('/track/{id}', [KaryawanController::class, 'track'])->name('karyawan-track');

});

//manajer umum rkk
Route::prefix('manajer')->group(function () {
    Route::get('/option', [ManajerController::class, 'option']);
    Route::get('/listrkk', [ManajerController::class, 'listrkk'])->name('list-rkk-manajer');
    Route::get('/detailrkkkaryawan/{id}', [ManajerController::class, 'detailrkkkaryawan'])->name('detail-rkk-karyawan-from-manajer');
    Route::get('/add-rkk', [ManajerController::class, 'addrkk']);
    Route::post('/addrkk/proses', [ManajerController::class, 'addrkkstore']);
    Route::get('/detailrkk/{id}', [ManajerController::class, 'detailrkk'])->name('detail-rkk-manajer');
    Route::get('/listrkk/karyawan', [ManajerController::class, 'listrkkkaryawan'])->name('manajer-listrkk-karyawan');
    Route::post('/approval', [ManajerController::class, 'approvalmanajer']);
    Route::post('/revisi', [ManajerController::class, 'revisirkk']);
    Route::get('/detail/revisi/{id}', [ManajerController::class, 'detailrevisi'])->name('detail-revisi');
    Route::get('/revisi/add/{id}', [ManajerController::class, 'revisiadd'])->name('manajer-revisi');
    Route::post('/revisi/proses', [ManajerController::class, 'revisiproses']);
    Route::get('/track/{id}', [ManajerController::class, 'track'])->name('manajer-track');

});

//manajer hrd rkk
Route::prefix('manajer/hrd')->group(function () {
    Route::get('/option', [HrdController::class, 'option']);
    Route::get('/optiondepartment', [HrdController::class, 'optiondepartment']);
    Route::get('/listrkk', [HrdController::class, 'listrkk'])->name('list-rkk-hrd');
    Route::get('/detailrkk/{id}', [HrdController::class, 'detailrkk'])->name('detail-rkk-hrd');
    Route::get('/add-rkk', [HrdController::class, 'addrkk']);
    Route::post('/addrkk/proses', [HrdController::class, 'addrkkstore']);
    Route::get('/eng', [HrdController::class, 'listrkkeng'])->name('hrd-listrkk-eng');
    Route::get('/pro', [HrdController::class, 'listrkkpro'])->name('hrd-listrkk-pro');
    Route::get('/scm', [HrdController::class, 'listrkkscm'])->name('hrd-listrkk-scm');
    Route::get('/fin', [HrdController::class, 'listrkkfin'])->name('hrd-listrkk-fin');
    Route::get('/it', [HrdController::class, 'listrkkit'])->name('hrd-listrkk-it');
    Route::get('/mr', [HrdController::class, 'listrkkmr'])->name('hrd-listrkk-mr');
    Route::get('/hrd', [HrdController::class, 'listrkkhrd'])->name('hrd-listrkk-hrd');
    Route::get('/pm', [HrdController::class, 'listrkkpm'])->name('hrd-listrkk-pm');
    Route::get('/detailrkk/eng/{id}', [HrdController::class, 'detailrkkeng'])->name('detail-rkk-eng-from-hrd');
    Route::get('/detailrkk/pro/{id}', [HrdController::class, 'detailrkkpro'])->name('detail-rkk-pro-from-hrd');
    Route::get('/detailrkk/scm/{id}', [HrdController::class, 'detailrkkscm'])->name('detail-rkk-scm-from-hrd');
    Route::get('/detailrkk/fin/{id}', [HrdController::class, 'detailrkkfin'])->name('detail-rkk-fin-from-hrd');
    Route::get('/detailrkk/it/{id}', [HrdController::class, 'detailrkkit'])->name('detail-rkk-it-from-hrd');
    Route::get('/detailrkk/mr/{id}', [HrdController::class, 'detailrkkmr'])->name('detail-rkk-mr-from-hrd');
    Route::get('/detailrkk/hrd/{id}', [HrdController::class, 'detailrkkhrd'])->name('detail-rkk-hrd-from-hrd');
    Route::get('/detailrkk/pm/{id}', [HrdController::class, 'detailrkkpm'])->name('detail-rkk-pm-from-hrd');
    Route::post('/approval', [HrdController::class, 'approvalhrd']);
    Route::post('/revisi', [HrdController::class, 'revisirkk']);
    Route::get('/revisi/add/{id}', [HrdController::class, 'revisiadd'])->name('hrd-revisi');
    Route::post('/revisi/proses', [HrdController::class, 'revisiproses']);
    Route::get('/track/{id}', [HrdController::class, 'track'])->name('hrd-track');

});

//project manager rkk
Route::prefix('pm')->group(function () {
    Route::get('/option', [PmController::class, 'option']);
    Route::get('/listrkk', [PmController::class, 'listrkk'])->name('list-rkk-pm');
    Route::get('/optiondepartment', [PmController::class, 'optiondepartment']);
    Route::get('/add-rkk', [PmController::class, 'addrkk']);
    Route::post('/addrkk/proses', [PmController::class, 'addrkkstore']);
    Route::get('/detailrkk/{id}', [PmController::class, 'detailrkk'])->name('detail-rkk-pm');
    Route::get('/listrkk/eng', [PmController::class, 'listrkkengineering'])->name('pm-listrkk-eng');
    Route::get('/listrkk/pro', [PmController::class, 'listrkkproduction'])->name('pm-listrkk-pro');
    Route::get('/detailrkk/eng/{id}', [PmController::class, 'detailrkkeng'])->name('detail-rkk-eng-from-pm');
    Route::get('/detailrkk/pro/{id}', [PmController::class, 'detailrkkpro'])->name('detail-rkk-pro-from-pm');
    Route::post('/approval', [PmController::class, 'approvalpm']);
    Route::post('/revisi', [PmController::class, 'revisirkk']);
    Route::get('/detail/revisi/karyawan/{id}', [PmController::class, 'detailrevisikaryawan'])->name('detail-revisi-karyawan-pm');
    Route::get('/revisi/add/{id}', [PmController::class, 'revisiadd'])->name('pm-revisi');
    Route::post('/revisi/proses', [PmController::class, 'revisiproses']);
    Route::get('/track/{id}', [PmController::class, 'track'])->name('pm-track');

});

//Direktur
Route::prefix('direktur')->group(function () {
    Route::get('/option', [DirekturController::class, 'option']);
    Route::get('/optiondepartment', [DirekturController::class, 'optiondepartment'])->name('dpoption');
    Route::get('/eng', [DirekturController::class, 'listrkkeng'])->name('direktur-listrkk-eng');
    Route::get('/pro', [DirekturController::class, 'listrkkpro'])->name('direktur-listrkk-pro');
    Route::get('/scm', [DirekturController::class, 'listrkkscm'])->name('direktur-listrkk-scm');
    Route::get('/fin', [DirekturController::class, 'listrkkfin'])->name('direktur-listrkk-fin');
    Route::get('/it', [DirekturController::class, 'listrkkit'])->name('direktur-listrkk-it');
    Route::get('/mr', [DirekturController::class, 'listrkkmr'])->name('direktur-listrkk-mr');
    Route::get('/hrd', [DirekturController::class, 'listrkkhrd'])->name('direktur-listrkk-hrd');
    Route::get('/du', [DirekturController::class, 'listrkkdu'])->name('direktur-listrkk-du');
    Route::get('/detailrkk/du/{id}', [DirekturController::class, 'detailrkkdu'])->name('detail-rkk-du-from-direktur');
    Route::get('/detailrkk/eng/{id}', [DirekturController::class, 'detailrkkeng'])->name('detail-rkk-eng-from-direktur');
    Route::get('/detailrkk/pro/{id}', [DirekturController::class, 'detailrkkpro'])->name('detail-rkk-pro-from-direktur');
    Route::get('/detailrkk/scm/{id}', [DirekturController::class, 'detailrkkscm'])->name('detail-rkk-scm-from-direktur');
    Route::get('/detailrkk/fin/{id}', [DirekturController::class, 'detailrkkfin'])->name('detail-rkk-fin-from-direktur');
    Route::get('/detailrkk/it/{id}', [DirekturController::class, 'detailrkkit'])->name('detail-rkk-it-from-direktur');
    Route::get('/detailrkk/mr/{id}', [DirekturController::class, 'detailrkkmr'])->name('detail-rkk-mr-from-direktur');
    Route::get('/detailrkk/hrd/{id}', [DirekturController::class, 'detailrkkhrd'])->name('detail-rkk-hrd-from-direktur');
    Route::post('/approval', [DirekturController::class, 'approvaldirektur']);
    Route::post('/revisi', [DirekturController::class, 'revisirkk']);

});

//komisaris rkk
Route::prefix('komisaris')->group(function () {
    Route::get('/option', [KomisarisController::class, 'option']);
    Route::get('/optiondepartment', [KomisarisController::class, 'optiondepartment']);
    Route::get('/eng', [KomisarisController::class, 'listrkkeng'])->name('komisaris-listrkk-eng');
    Route::get('/pro', [KomisarisController::class, 'listrkkpro'])->name('komisaris-listrkk-pro');
    Route::get('/scm', [KomisarisController::class, 'listrkkscm'])->name('komisaris-listrkk-scm');
    Route::get('/fin', [KomisarisController::class, 'listrkkfin'])->name('komisaris-listrkk-fin');
    Route::get('/it', [KomisarisController::class, 'listrkkit'])->name('komisaris-listrkk-it');
    Route::get('/mr', [KomisarisController::class, 'listrkkmr'])->name('komisaris-listrkk-mr');
    Route::get('/hrd', [KomisarisController::class, 'listrkkhrd'])->name('komisaris-listrkk-hrd');
    Route::get('/du', [KomisarisController::class, 'listrkkdu'])->name('komisaris-listrkk-du');
    Route::get('/detailrkk/du/{id}', [KomisarisController::class, 'detailrkkdu'])->name('detail-rkk-du-from-komisaris');
    Route::get('/detailrkk/eng/{id}', [KomisarisController::class, 'detailrkkeng'])->name('detail-rkk-eng-from-komisaris');
    Route::get('/detailrkk/pro/{id}', [KomisarisController::class, 'detailrkkpro'])->name('detail-rkk-pro-from-komisaris');
    Route::get('/detailrkk/scm/{id}', [KomisarisController::class, 'detailrkkscm'])->name('detail-rkk-scm-from-komisaris');
    Route::get('/detailrkk/fin/{id}', [KomisarisController::class, 'detailrkkfin'])->name('detail-rkk-fin-from-komisaris');
    Route::get('/detailrkk/it/{id}', [KomisarisController::class, 'detailrkkit'])->name('detail-rkk-it-from-komisaris');
    Route::get('/detailrkk/mr/{id}', [KomisarisController::class, 'detailrkkmr'])->name('detail-rkk-mr-from-komisaris');
    Route::get('/detailrkk/hrd/{id}', [KomisarisController::class, 'detailrkkhrd'])->name('detail-rkk-hrd-from-komisaris');
    Route::post('/approval', [KomisarisController::class, 'approvalkomisaris']);
    Route::post('/revisi', [KomisarisController::class, 'revisirkk']);
});


Route::prefix('arsip')->group(function () {
    Route::get('/option', [ArsipController::class, 'option']);
    Route::get('/rkk', [ArsipController::class, 'listarsiprkk']);
    Route::get('/detailrkk/{id}', [ArsipController::class, 'detailrkk'])->name('arsip-detail-rkk');
});



//example login rkk
Route::get('/', [ExLoginController::class, 'index'])->name('login');
Route::post('/exlogin', [ExLoginController::class, 'exlogin']);
