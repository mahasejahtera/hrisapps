<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\ExLoginController;
use App\Http\Controllers\Rencanakerja\KaryawanController;

Route::get('/dashboard', function () {
    return view('rencanakerja.dashboard');
})->name('dashboard');

//karyawan
Route::prefix('karyawan')->group(function () {
    Route::get('/option', [KaryawanController::class, 'option']);
    Route::get('/listrkk', [KaryawanController::class, 'listrkk'])->name('list-rkk');
    Route::get('/task', [KaryawanController::class, 'task']);
    Route::get('/detail-task', [KaryawanController::class, 'detailtask']);
    Route::get('/add-rkk', [KaryawanController::class, 'addrkk']);
    Route::post('/addrkk/proses', [KaryawanController::class, 'addrkkstore']);
    Route::get('/detailrkk/{id}', [KaryawanController::class, 'detailrkk'])->name('detail-rkk');
});

//example login
Route::get('/', [ExLoginController::class, 'index'])->name('login');
Route::post('/exlogin', [ExLoginController::class, 'exlogin']);
