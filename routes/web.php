<?php

use App\Http\Controllers\Pengajuan\CSRController;
use App\Http\Controllers\Pengajuan\HutangOperasionalController;
use App\Http\Controllers\Pengajuan\OperasionalKantorController;
use App\Http\Controllers\Pengajuan\PelatihanKaryawanController;
use App\Http\Controllers\Pengajuan\ReimbursementController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PengajuanController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\KaryawanController;
use App\Http\Controllers\Panel\PanelPengajuanController;
use App\Http\Controllers\Panel\PanelRencanaKerjaController;

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
Route::get('pengajuan/pribadi',[PengajuanController::class,'pribadi'])->name('pengajuan.pribadi');
Route::get('pengajuan/list',[PengajuanController::class,'list'])->name('pengajuan.list');
Route::get('pengajuan/departemen',[PengajuanController::class,'departemen'])->name('pengajuan.departemen');
Route::get('pengajuan/departemen/list/{kode_dept}',[PengajuanController::class,'departemen_list'])->name('pengajuan.departemen_list');
Route::get('pengajuan/tracking',[PengajuanController::class,'tracking'])->name('pengajuan.tracking');
Route::get('pengajuan/archive',[PengajuanController::class,'archive'])->name('pengajuan.archive');
Route::resource('pengajuan', PengajuanController::class);


Route::middleware(['auth:user'])->group(function () {
    Route::get('/proseslogoutadmin', [AuthController::class, 'proseslogoutadmin']);
    Route::get('/panel/dashboardadmin', [DashboardController::class, 'dashboardadmin']);

    //Karyawan
    Route::get('/karyawan', [KaryawanController::class, 'index']);
    Route::post('/karyawan/store', [KaryawanController::class, 'store']);
    Route::post('/karyawan/edit', [KaryawanController::class, 'edit']);
    Route::post('/karyawan/{nik}/update', [KaryawanController::class, 'update']);
    Route::post('/karyawan/{nik}/delete', [KaryawanController::class, 'delete']);

    Route::post('/karyawan/data',[KaryawanController::class, 'karyawanData'])->name('karyawan.data');
    Route::post('/karyawan/verification-register', [KaryawanController::class, 'verificationRegister'])->name('karyawan.verification.register');

    //Departemen
    Route::get('/departemen', [DepartemenController::class, 'index']);
    Route::post('/departemen/store', [DepartemenController::class, 'store']);
    Route::post('/departemen/edit', [DepartemenController::class, 'edit']);
    Route::post('/departemen/{kode_dept}/update', [DepartemenController::class, 'update']);
    Route::post('/departemen/{kode_dept}/delete', [DepartemenController::class, 'delete']);

    //Presensi
    Route::get('/presensi/monitoring', [PresensiController::class, 'monitoring']);
    Route::post('/getpresensi', [PresensiController::class, 'getpresensi']);
    Route::post('/tampilkanpeta', [PresensiController::class, 'tampilkanpeta']);
    Route::get('/presensi/laporan', [PresensiController::class, 'laporan']);
    Route::post('/presensi/cetaklaporan', [PresensiController::class, 'cetaklaporan']);
    Route::get('/presensi/rekap', [PresensiController::class, 'rekap']);
    Route::post('/presensi/cetakrekap', [PresensiController::class, 'cetakrekap']);
    Route::get('/presensi/izinsakit', [PresensiController::class, 'izinsakit']);
    Route::post('/presensi/approveizinsakit', [PresensiController::class, 'approveizinsakit']);
    Route::get('/presensi/{id}/batalkanizinsakit', [PresensiController::class, 'batalkanizinsakit']);

    //
    Route::get('/panel/pengajuan', [PanelPengajuanController::class, 'index']);
    Route::get('/panel/rencanakerja', [PanelRencanaKerjaController::class, 'index']);


    //Cabang
    Route::get('/cabang', [CabangController::class, 'index']);
    Route::post('/cabang/store', [CabangController::class, 'store']);
    Route::post('/cabang/edit', [CabangController::class, 'edit']);
    Route::post('/cabang/update', [CabangController::class, 'update']);
    Route::post('/cabang/{kode_cabang}/delete', [CabangController::class, 'delete']);

    //Konfigurasi

    Route::get('/konfigurasi/lokasikantor', [KonfigurasiController::class, 'lokasikantor']);
    Route::post('/konfigurasi/updatelokasikantor', [KonfigurasiController::class, 'updatelokasikantor']);

    Route::get('/konfigurasi/jamkerja', [KonfigurasiController::class, 'jamkerja']);
    Route::post('/konfigurasi/storejamkerja', [KonfigurasiController::class, 'storejamkerja']);
    Route::post('/konfigurasi/editjamkerja', [KonfigurasiController::class, 'editjamkerja']);
    Route::post('/konfigurasi/updatejamkerja', [KonfigurasiController::class, 'updatejamkerja']);
    Route::get('/konfigurasi/{nik}/setjamkerja', [KonfigurasiController::class, 'setjamkerja']);
    Route::post('/konfigurasi/storesetjamkerja', [KonfigurasiController::class, 'storesetjamkerja']);
    Route::post('/konfigurasi/updatesetjamkerja', [KonfigurasiController::class, 'updatesetjamkerja']);
    Route::post('/konfigurasi/jamkerja/{kode_jam_kerja}/delete', [KonfigurasiController::class, 'deletejamkerja']);


    Route::get('/konfigurasi/jamkerjadept', [KonfigurasiController::class, 'jamkerjadept']);
    Route::get('/konfigurasi/jamkerjadept/create', [KonfigurasiController::class, 'createjamkerjadept']);
    Route::post('/konfigurasi/jamkerjadept/store', [KonfigurasiController::class, 'storejamkerjadept']);
    Route::get('/konfigurasi/jamkerjadept/{kode_jk_dept}/edit', [KonfigurasiController::class, 'editjamkerjadept']);
    Route::post('/konfigurasi/jamkerjadept/{kode_jk_dept}/update', [KonfigurasiController::class, 'updatejamkerjadept']);
    Route::get('/konfigurasi/jamkerjadept/{kode_jk_dept}/show', [KonfigurasiController::class, 'showjamkerjadept']);
    Route::get('/konfigurasi/jamkerjadept/{kode_jk_dept}/delete', [KonfigurasiController::class, 'deletejamkerjadept']);
});

Route::middleware(['guest:user'])->group(function () {
    Route::get('/panel', function () {
        return view('auth.loginadmin');
    })->name('loginadmin');

    Route::post('/prosesloginadmin', [AuthController::class, 'prosesloginadmin']);
});
