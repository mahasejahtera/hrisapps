<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CabangController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DepartemenController;
use App\Http\Controllers\KaryawanController;
use App\Http\Controllers\KonfigurasiController;
use App\Http\Controllers\Pengajuan\CSRController;
use App\Http\Controllers\Pengajuan\HutangOperasionalController;
use App\Http\Controllers\Pengajuan\OperasionalKantorController;
use App\Http\Controllers\Pengajuan\PelatihanKaryawanController;
use App\Http\Controllers\Pengajuan\ReimbursementController;
use App\Http\Controllers\PresensiController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Psy\VarDumper\Presenter;
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


// AUTH ROUTE
Route::middleware(['guest'])->group(function () {
    Route::get('/login', [AuthController::class, 'login'])->name('login');
    Route::get('/register', [AuthController::class, 'register'])->name('register');
    Route::post('/register', [AuthController::class, 'prosesRegister'])->name('register.proses');
    Route::post('/proseslogin', [AuthController::class, 'proseslogin'])->name('login.proses');

    // google
    // Route::get('/login-google', [AuthController::class, 'googleLogin'])->name('google.login');
    // Route::get('/auth/google/callback', [AuthController::class, 'googleCalback'])->name('google.callback');
});


// Route::middleware(['auth'])->group(function() {
Route::get('/suspend', function () {
    return "
            <script>
                alert('Akun anda suspend, silahkan hubungi HRD!');
                location.href = '/proseslogout';
            </script>
        ";
})->name('suspend');
// });

Route::get('/proseslogout', [AuthController::class, 'proseslogout'])->name('karyawan.logout');


Route::middleware(['guest:user'])->group(function () {
    Route::get('/panel', function () {
        return view('auth.loginadmin');
    })->name('loginadmin');

    Route::post('/prosesloginadmin', [AuthController::class, 'prosesloginadmin']);
});

Route::middleware('isNotSuspend')->group(function () {
    Route::middleware('auth:karyawan')->group(function () {

        // Dashboard
        Route::get('/', [DashboardController::class, 'index'])->name('karyawan');

        // Data Diri
        Route::get('/data-diri/{karyawan:email}', [DashboardController::class, 'dataDiri'])->name('karyawan.datadiri');
        Route::post('/data-diri/{karyawan}', [DashboardController::class, 'dataDiriStore'])->name('karyawan.datadiri.store');
        Route::get('/data-diri-next/{karyawan:email}', [DashboardController::class, 'dataDiriNext'])->name('karyawan.datadiri.next');
        Route::post('/data-diri-next/{karyawan}', [DashboardController::class, 'dataDiriStoreNext'])->name('karyawan.datadiri.store.next');
        Route::get('/data-document/{karyawan:email}', [DashboardController::class, 'dataDocument'])->name('karyawan.datadiri.document');
        Route::post('/data-document/{karyawan:email}', [DashboardController::class, 'dataDcumentStore'])->name('karyawan.datadiri.document.store');
        Route::get('/signature/{karyawan:email}', [DashboardController::class, 'signature'])->name('karyawan.signature');
        Route::post('/signature/{karyawan:email}', [DashboardController::class, 'signatureStore'])->name('karyawan.signature.store');
        Route::get('/pakta-integritas/{karyawan:email}', [DashboardController::class, 'paktaIntegritas'])->name('karyawan.paktaintegritas');
        Route::post('/pakta-integritas/{karyawan:email}', [DashboardController::class, 'paktaIntegritasStore'])->name('karyawan.paktaintegritas.store');
        Route::get('/kontrak-kerja/{karyawan:email}', [DashboardController::class, 'kontrakKerja'])->name('karyawan.kontrakkerja');
        Route::post('/kontrak-kerja/{karyawan:email}', [DashboardController::class, 'kontrakKerjaStore'])->name('karyawan.kontrakkerja.store');
        Route::get('/data-diri-confirm/{karyawan:email}', [DashboardController::Class, 'dataDiriConfirm'])->name('karyawan.datadiri.confirm');

        //Presensi
        Route::get('/presensi', [DashboardController::class, 'presensi'])->name('karyawan.presensi');
        Route::get('/presensi/create', [PresensiController::class, 'create']);
        Route::post('/presensi/store', [PresensiController::class, 'store']);

        //Edit Profile
        Route::get('/editprofile', [PresensiController::class, 'editprofile']);
        Route::post('/presensi/{nik}/updateprofile', [PresensiController::class, 'updateprofile']);

        //Histori
        Route::get('/presensi/histori', [PresensiController::class, 'histori']);
        Route::post('/gethistori', [PresensiController::class, 'gethistori']);

        //Izin
        Route::get('/presensi/izin', [PresensiController::class, 'izin']);
        Route::get('/presensi/buatizin', [PresensiController::class, 'buatizin']);
        Route::post('/presensi/storeizin', [PresensiController::class, 'storeizin']);
        Route::post('/presensi/cekpengajuanizin', [PresensiController::class, 'cekpengajuanizin']);

        // Pengajuan
        Route::resource('pengajuan', PengajuanController::class);
        Route::group(['prefix' => 'pengajuan'], function () {
            Route::resource('hutangoperasional', HutangOperasionalController::class);
            Route::resource('operasionalkantor', OperasionalKantorController::class);
            Route::resource('pelatihankaryawan', PelatihanKaryawanController::class);
            Route::resource('reimbursement', ReimbursementController::class);
            Route::resource('csr', CSRController::class);
        });
    });
});


Route::middleware(['auth:user'])->group(function () {
    Route::get('/proseslogoutadmin', [AuthController::class, 'proseslogoutadmin']);
    Route::get('/panel/dashboardadmin', [DashboardController::class, 'dashboardadmin']);

    //Karyawan
    Route::get('/karyawan', [KaryawanController::class, 'index']);
    Route::post('/karyawan/store', [KaryawanController::class, 'store']);
    Route::post('/karyawan/edit', [KaryawanController::class, 'edit']);
    Route::post('/karyawan/{nik}/update', [KaryawanController::class, 'update']);
    Route::post('/karyawan/{nik}/delete', [KaryawanController::class, 'delete']);

    Route::post('/karyawan/data', [KaryawanController::class, 'karyawanData'])->name('karyawan.data');
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
