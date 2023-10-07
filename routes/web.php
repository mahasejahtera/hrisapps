<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\ExLoginController;
use App\Http\Controllers\Rencanakerja\KaryawanController;
use App\Http\Controllers\Rencanakerja\ManajerController;

Route::get('/dashboard', function () {
    return view('rencanakerja.dashboard');
})->name('dashboard');

//karyawan Rencana Kerja
Route::prefix('karyawan')->group(function () {
    Route::get('/option', [KaryawanController::class, 'option']);
    Route::get('/listrkk', [KaryawanController::class, 'listrkk'])->name('list-rkk');
    Route::get('/task', [KaryawanController::class, 'task']);
    Route::get('/detail-task', [KaryawanController::class, 'detailtask']);
    Route::get('/add-rkk', [KaryawanController::class, 'addrkk']);
    Route::post('/addrkk/proses', [KaryawanController::class, 'addrkkstore']);
    Route::get('/detailrkk/{id}', [KaryawanController::class, 'detailrkk'])->name('detail-rkk');
});

//manajer Rencana Kerja
Route::prefix('manajer')->group(function () {
    Route::get('/option', [ManajerController::class, 'option']);
    Route::get('/listrkk', [ManajerController::class, 'listrkk']);
    Route::get('/detailrkkkaryawan', [ManajerController::class, 'detailrkkkaryawan']);
});


//example login
Route::get('/', [ExLoginController::class, 'index'])->name('login');
Route::post('/exlogin', [ExLoginController::class, 'exlogin']);
