<?php

use Illuminate\Support\Facades\Route;


Route::get('/', function () {
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
Route::get('/karyawan/add-rkk', function () {
    return view('rencanakerja.karyawan.add-rkk');
});
Route::get('/karyawan/detail-rkk', function () {
    return view('rencanakerja.karyawan.detail-rkk');
});
