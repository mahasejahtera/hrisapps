<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('rencanakerja.all');
});
Route::get('/dashboard', function () {
    return view('rencanakerja.dashboard');
});

//karyawan
Route::get('/karyawan/option', function () {
    return view('rencanakerja.karyawan.option');
});
Route::get('/karyawan/listrkk', function () {
    return view('rencanakerja.karyawan.listrkk');
});
Route::get('/karyawan/task', function () {
    return view('rencanakerja.karyawan.task');
});
Route::get('/karyawan/detail-task', function () {
    return view('rencanakerja.karyawan.detail-task');
});
