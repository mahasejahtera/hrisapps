<?php

use App\Http\Controllers\ApprovalController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CabangController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DepartemenController;
use App\Http\Controllers\JabatanController;
use App\Http\Controllers\KaryawanController;
use App\Http\Controllers\KonfigurasiController;
use App\Http\Controllers\Panel\PanelPengajuanController;
use App\Http\Controllers\PayrollController;
use App\Http\Controllers\Pengajuan\CSRController;
use App\Http\Controllers\Pengajuan\HutangOperasionalController;
use App\Http\Controllers\Pengajuan\OperasionalKantorController;
use App\Http\Controllers\Pengajuan\PelatihanKaryawanController;
use App\Http\Controllers\Pengajuan\ReimbursementController;
use App\Http\Controllers\Panel\PanelRencanaKerjaController;
use App\Http\Controllers\PengajuanController;
use App\Http\Controllers\PresensiController;
use App\Http\Controllers\WebhookIclockController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Route;
use Psy\VarDumper\Presenter;

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
                alert('Akun anda menunggu persetujuan admin, silahkan hubungi HRD!');
                location.href = '/proseslogout';
            </script>
        ";
})->name('suspend');
// });

Route::get('/proseslogout', [AuthController::class, 'proseslogout'])->name('karyawan.logout');
Route::post('/get-jabatan-by-dept', [AuthController::class, 'getJabatanByDept'])->name('register.jabatan');
Route::get('/spt-ttd-digital/{karyawan:email}', [KaryawanController::class, 'showPaktaIntegritas'])->name('spt.ttddigital');

Route::get('/panel', function () {
    return view('auth.loginadmin');
})->name('loginadmin');

Route::middleware(['guest:user'])->group(function () {
    Route::post('/prosesloginadmin', [AuthController::class, 'prosesloginadmin']);
});

Route::middleware('isNotSuspend')->group(function () {
    Route::middleware('auth:karyawan')->group(function () {

        // jumlah hari minggu + libur
        Route::post('/jumlah-libur-minggu', [PresensiController::class, 'getJumlahLibur'])->name('hitungjumlahliburminggu');

        // Dashboard
        Route::get('/', [DashboardController::class, 'index'])->name('karyawan');

        // Data Diri
        Route::get('/data-diri/{karyawan:email}', [DashboardController::class, 'dataDiri'])->name('karyawan.datadiri');
        Route::post('/get-indo-data', [DashboardController::class, 'getIndoData'])->name('indonesiadata');
        Route::post('/set-indo-data/{karyawan:email}', [DashboardController::class, 'setIndoDataAfterLoad'])->name('indonesiadata.set');
        Route::post('/data-diri/{karyawan}', [DashboardController::class, 'dataDiriStore'])->name('karyawan.datadiri.store');
        Route::get('/data-diri-next/{karyawan:email}', [DashboardController::class, 'dataDiriNext'])->name('karyawan.datadiri.next');
        Route::post('/data-diri-next/{karyawan}', [DashboardController::class, 'dataDiriStoreNext'])->name('karyawan.datadiri.store.next');
        Route::get('/data-document/{karyawan:email}', [DashboardController::class, 'dataDocument'])->name('karyawan.datadiri.document');
        Route::post('/data-document/{karyawan:email}', [DashboardController::class, 'dataDcumentStore'])->name('karyawan.datadiri.document.store');
        Route::get('/signature/{karyawan:email}', [DashboardController::class, 'signature'])->name('karyawan.signature');
        Route::post('/signature/{karyawan:email}', [DashboardController::class, 'signatureStore'])->name('karyawan.signature.store');
        Route::get('/pakta-integritas/{karyawan:email}', [DashboardController::class, 'paktaIntegritas'])->name('karyawan.paktaintegritas');
        Route::post('/pakta-integritas/{karyawan:email}', [DashboardController::class, 'paktaIntegritasStore'])->name('karyawan.paktaintegritas.store');
        Route::get('/surat-pernyataan/{karyawan:email}', [DashboardController::class, 'suratPernyataan'])->name('karyawan.suratpernyataan');
        Route::post('/surat-pernyataan/{karyawan:email}', [DashboardController::class, 'suratPernyataanStore'])->name('karyawan.suratpernyataan.store');
        Route::get('/kontrak-kerja/{karyawan:email}', [DashboardController::class, 'kontrakKerja'])->name('karyawan.kontrakkerja');
        Route::post('/kontrak-kerja/{karyawan:email}', [DashboardController::class, 'kontrakKerjaStore'])->name('karyawan.kontrakkerja.store');
        Route::get('/data-diri-confirm/{karyawan:email}', [DashboardController::class, 'dataDiriConfirm'])->name('karyawan.datadiri.confirm');
        Route::get('/konfirmasi-data-diri/{karyawan:email}', [DashboardController::class, 'dataDiriConfirmStore'])->name('karyawan.datadiri.storeconfirm');
        Route::get('/data-saudara/{karyawan:email}', [DashboardController::class, 'karyawanSaudara'])->name('karyawan.datadiri.saudara');
        Route::post('/data-saudara/{karyawan:email}', [DashboardController::class, 'karyawanSaudaraStore'])->name('karyawan.datadiri.saudarastore');
        Route::delete('/data-sibling-delete/', [DashboardController::class, 'karyawanSaudaraDestroy'])->name('karyawan.saudara.destroy');
        Route::get('/data-anak/{karyawan:email}', [DashboardController::class, 'karyawanAnak'])->name('karyawan.datadiri.anak');
        Route::post('/data-anak/{karyawan:email}', [DashboardController::class, 'karyawanAnakStore'])->name('karyawan.datadiri.anakstore');
        Route::delete('/data-anak-delete/', [DashboardController::class, 'karyawanAnakDestroy'])->name('karyawan.anak.destroy');
        Route::get('/data-pendidikan/{karyawan:email}', [DashboardController::class, 'karyawanEducation'])->name('karyawan.education');
        Route::post('/data-pendidikan/{karyawan:email}', [DashboardController::class, 'karyawanEducationStore'])->name('karyawan.education.store');

        //Presensi
        Route::get('/presensi', [DashboardController::class, 'presensi'])->name('karyawan.presensi');
        Route::get('/presensi/create', [PresensiController::class, 'create'])->name('presensi.create');
        Route::post('/presensi/store', [PresensiController::class, 'store']);

        //Edit Profile
        Route::get('/editprofile', [PresensiController::class, 'editprofile']);
        Route::post('/presensi/{nik}/updateprofile', [PresensiController::class, 'updateprofile']);

        //Histori
        Route::get('/presensi/histori', [PresensiController::class, 'histori'])->name('presensi.histori');
        Route::post('/gethistori', [PresensiController::class, 'gethistori']);

        //Izin
        Route::get('/presensi/izin', [PresensiController::class, 'izin'])->name('presensi.izin');
        Route::get('/presensi/izin-pribadi', [PresensiController::class, 'izinPribadi'])->name('presensi.izinpribadi');
        Route::get('/presensi/izin/pribadi/{pengajuan_izin:id}/destroy', [PresensiController::class, 'destroyIzin'])->name('presensi.izin.pribadi.destroy');
        Route::get('/presensi/izin-karyawan', [PresensiController::class, 'izinKaryawan'])->name('presensi.izinkaryawan');
        Route::get('/presensi/buatizin', [PresensiController::class, 'buatizin']);
        Route::post('/presensi/izin/get-jenis', [PresensiController::class, 'getJenisIzin'])->name('presensi.izin.getjenis');
        Route::post('/presensi/storeizin', [PresensiController::class, 'storeizin']);
        Route::get('/presensi/{pengajuan_izin:id}/detail-izin', [PresensiController::class, 'detailIzinApprove'])->name('presensi.izin.detail');
        Route::get('/presensi/{pengajuan_izin:id}/terima-izin', [PresensiController::class, 'terimaIzin'])->name('presensi.izin.terima');
        Route::post('/presensi/{pengajuan_izin:id}/tolak-izin', [PresensiController::class, 'tolakIzin'])->name('presensi.izin.tolak');
        Route::post('/presensi/cekpengajuanizin', [PresensiController::class, 'cekpengajuanizin']);

        // lembur
        Route::get('/presensi/lembur', [PresensiController::class, 'lembur'])->name('presensi.lembur');
        Route::get('/presensi/lembur/pribadi', [PresensiController::class, 'lemburPribadi'])->name('presensi.lembur.pribadi');
        Route::get('/presensi/lembur/pribadi/{lembur:id}/destroy', [PresensiController::class, 'destroyLembur'])->name('presensi.lembur.pribadi.destroy');
        Route::get('/presensi/lembur/karyawan', [PresensiController::class, 'lemburKaryawan'])->name('presensi.lembur.karyawan');
        Route::get('/presensi/lembur/detail/{lembur:id}', [PresensiController::class, 'detailLembur'])->name('presensi.lembur.detail');
        Route::get('/presensi/buat-lembur', [PresensiController::class, 'createLembur'])->name('presensi.lembur.create');
        Route::post('/presensi/buat-lembur', [PresensiController::class, 'storeLembur'])->name('presensi.lembur.store');
        Route::get('/presensi/foto-lembur/{status}/{lembur:id}', [PresensiController::class, 'fotoLembur'])->name('presensi.lembur.foto');
        Route::post('/presensi/foto-lembur', [PresensiController::class, 'storeFotoLembur'])->name('presensi.lembur.foto.store');
        Route::get('/presensi/lembur/ajukan/{lembur:id}', [PresensiController::class, 'ajukanLembur'])->name('presensi.lembur.ajukan');
        Route::post('/presensi/{lembur:id}/tolak-lembur', [PresensiController::class, 'tolakLembur'])->name('presensi.lembur.tolak');
        Route::get('/presensi/{lembur:id}/terima-lembur', [PresensiController::class, 'terimaLembur'])->name('presensi.lembur.terima');

        //perintah lembur
        Route::get('/presensi/perintah-lembur', [PresensiController::class, 'perintahLembur'])->name('presensi.perintahlembur');
        Route::get('/presensi/perintah-lembur/add', [PresensiController::class, 'addPerintahLembur'])->name('presensi.perintahlembur.add');
        Route::post('/presensi/perintah-lembur/add/proses', [PresensiController::class, 'storePerintahLembur'])->name('presensi.perintahlembur.store');

        // PROFILE
        Route::get('/profil/change-password', [KaryawanController::class, 'changePassword'])->name('profil.changepassword');
        Route::post('/profil/change-password', [KaryawanController::class, 'storeChangePassword'])->name('profil.changepassword.store');
        Route::get('/profil/{karyawan:email}', [KaryawanController::class, 'profile'])->name('profil');
        Route::get('/profil/kontrak-kerja/{karyawan:email}', [KaryawanController::class, 'kontrakKerja'])->name('profil.kontrakkerja');

        Route::group(['prefix' => 'pengajuan'], function () {
            Route::resource('hutangoperasional', HutangOperasionalController::class);
            Route::resource('operasionalkantor', OperasionalKantorController::class);
            Route::resource('pelatihankaryawan', PelatihanKaryawanController::class);
            Route::resource('reimbursement', ReimbursementController::class);
            Route::resource('csr', CSRController::class);
        });
        Route::get('pengajuan/pribadi', [PengajuanController::class, 'pribadi'])->name('pengajuan.pribadi');
        Route::get('pengajuan/list', [PengajuanController::class, 'list'])->name('pengajuan.list');
        Route::get('pengajuan/departemen', [PengajuanController::class, 'departemen'])->name('pengajuan.departemen');
        Route::get('pengajuan/departemen/list/{kode_dept}', [PengajuanController::class, 'departemen_list'])->name('pengajuan.departemen_list');
        Route::get('pengajuan/tracking/{id}', [PengajuanController::class, 'tracking'])->name('pengajuan.tracking');
        Route::get('pengajuan/archive', [PengajuanController::class, 'archive'])->name('pengajuan.archive');
        Route::get('pengajuan/preview', [PengajuanController::class, 'preview'])->name('pengajuan.preview');
        Route::get('pengajuan/approval', [PengajuanController::class, 'approval'])->name('pengajuan.approval');
        Route::get('pengajuan/revisi', [PengajuanController::class, 'revisi'])->name('pengajuan.revisi');
        Route::get('pengajuan/add/{id}', [PengajuanController::class, 'add'])->name('pengajuan.add');
        Route::resource('pengajuan', PengajuanController::class);

        /*================================
                     APPROVAL
        =============================== */
        Route::prefix('/approval')->group(function () {
            Route::name('approval')->group(function () {

                Route::get('/', [ApprovalController::class, 'index']);
                Route::get('/salary', [ApprovalController::class, 'employeeSalary'])->name('.salary');
                Route::get('/salary/detail/{pengajuan_gaji}', [ApprovalController::class, 'detailEmployeeSalary'])->name('.salary.detail');
                Route::get('/salary/{pengajuan_gaji}/approve', [ApprovalController::class, 'approveEmployeeSalary'])->name('.salary.approve');
                Route::post('/salary/{pengajuan_gaji}/reject', [ApprovalController::class, 'rejectEmployeeSalary'])->name('.salary.reject');
            });
        });
    });
});


Route::middleware(['auth:user'])->group(function () {
    Route::get('/proseslogoutadmin', [AuthController::class, 'proseslogoutadmin']);
    Route::get('/panel/dashboardadmin', [DashboardController::class, 'dashboardadmin'])->name('admin.dashboard');

    //Karyawan
    Route::get('/karyawan/datatables', [KaryawanController::class, 'karyawanDatatable'])->name('admin.karyawan.datatables');
    Route::get('/karyawan', [KaryawanController::class, 'index'])->name('karyawan.index');
    Route::post('/karyawan/store', [KaryawanController::class, 'store']);
    Route::post('/karyawan/edit', [KaryawanController::class, 'edit']);
    Route::post('/karyawan/{nik}/update', [KaryawanController::class, 'update']);
    Route::post('/karyawan/{nik}/delete', [KaryawanController::class, 'delete']);

    Route::get('/karyawan/detail/{karyawan:email}', [KaryawanController::class, 'karyawanDetail'])->name('admin.karyawan.detail');
    Route::get('/karyawan/kontrak-kerja/{karyawan:email}', [KaryawanController::class, 'kontrakKerjaKaryawan'])->name('admin.karyawan.kontrakkerja');
    Route::post('/karyawan/kontrak-kerja/{karyawan:email}', [KaryawanController::class, 'storeKontrakKerja'])->name('admin.karyawan.kontrakkerja.store');

    Route::post('/karyawan/data-register', [KaryawanController::class, 'karyawanDataRegister'])->name('karyawan.data.register');
    Route::post('/karyawan/data', [KaryawanController::class, 'karyawanData'])->name('karyawan.data');
    Route::post('/karyawan/verification-register', [KaryawanController::class, 'verificationRegister'])->name('karyawan.verification.register');
    Route::post('/karyawan/verifikasi-data', [KaryawanController::class, 'verificationData'])->name('karyawan.verification.data');
    Route::post('/karyawan/nonaktifkan-karyawan', [KaryawanController::class, 'nonaktifkanKaryawan'])->name('karyawan.nonaktifkan');
    Route::post('/karyawan/change-password', [KaryawanController::class, 'changePasswordKaryawanPanel'])->name('karyawan.changepassword');

    // karyawan harian
    Route::get('/karyawan/harian/datatables', [KaryawanController::class, 'karyawanHarianDatatable'])->name('admin.karyawan.harian.datatables');
    Route::post('/karyawan/harian', [KaryawanController::class, 'storeKaryawanHarian'])->name('admin.karyawan.harian.store');
    Route::get('/karyawan/harian/{karyawan:id}/setjamkerja', [KonfigurasiController::class, 'setjamkerja'])->name('karyawan.harian.jamkerja');
    Route::get('/karyawan/harian/detail/{id}', [KaryawanController::class, 'karyawanHarianDetail'])->name('admin.karyawan.harian.detail');
    Route::post('/karyawan/harian/detail/update/{id}', [KaryawanController::class, 'updateKaryawanHarian'])->name('admin.karyawan.harian.update');
    Route::post('/karyawan/harian/detail/add/sp/{id}', [KaryawanController::class, 'addSuratPernyataan'])->name('admin.karyawan.harian.add.sp');
    Route::post('/karyawan/harian/detail/edit/sp/{id} ', [KaryawanController::class, 'editSuratPernyataan'])->name('admin.karyawan.harian.edit.sp');
    Route::get('/karyawan/harian/detail/delete/sp/{id} ', [KaryawanController::class, 'deleteSuratPernyataan'])->name('admin.karyawan.harian.sp.delete');

    // jobdesk
    Route::get('/karyawan/jobdesk/{karyawan:email}', [KaryawanController::class, 'karyawanJobdesk'])->name('admin.karyawan.jobdesk');
    Route::post('/karyawan/jobdesk/', [KaryawanController::class, 'karyawanJobdeskStore'])->name('admin.karyawan.jobdeskstore');
    Route::put('/karyawan/jobdesk', [KaryawanController::class, 'karyawanJobdeskUpdate'])->name('admin.karyawan.jobdeskupdate');
    Route::delete('/karyawan/jobdesk', [KaryawanController::class, 'karyawanJobdeskDestroy'])->name('admin.karyawan.jobdeskdestroy');
    Route::post('/karyawan/get-jobdesk', [KaryawanController::class, 'getKaryawanJobdeskById'])->name('admin.karyawan.jobdeskget');


    // transfer
    Route::post('/karyawan/transfer', [KaryawanController::class, 'karyawanTransferStore'])->name('karyawan.transfer.store');


    //Departemen
    Route::get('/departemen/datatables', [DepartemenController::class, 'departmentDatatables'])->name('department.datatables');
    Route::get('/departemen', [DepartemenController::class, 'index']);
    Route::post('/departemen/store', [DepartemenController::class, 'store']);
    Route::post('/departemen/edit', [DepartemenController::class, 'edit']);
    Route::post('/departemen/{kode_dept}/update', [DepartemenController::class, 'update']);
    Route::post('/departemen/{kode_dept}/delete', [DepartemenController::class, 'delete']);

    //Jabatan
    Route::get('/jabatan', [JabatanController::class, 'indexJabatan']);
    Route::get('/jabatan/tetap/datatables', [JabatanController::class, 'jabatanTetapDatatables'])->name('jabatan.datatables');
    Route::get('/jabatan/harian/datatables', [JabatanController::class, 'jabatanHarianDatatables'])->name('jabatan.harian.datatables');
    Route::post('/jabatan/add', [JabatanController::class, 'addJabatan']);
    Route::post('/jabatan/edit/{id}', [JabatanController::class, 'editJabatan']);

    //Presensi
    Route::get('/presensi/monitoring', [PresensiController::class, 'monitoring']);
    Route::post('/getpresensi', [PresensiController::class, 'getpresensi']);
    Route::post('/tampilkanpeta', [PresensiController::class, 'tampilkanpeta']);
    Route::post('/presensi/cetaklaporan', [PresensiController::class, 'cetaklaporan']);
    Route::get('/presensi/rekap', [PresensiController::class, 'rekap']);
    Route::post('/presensi/cetakrekap', [PresensiController::class, 'cetakrekap']);
    Route::get('/presensi/izinsakit', [PresensiController::class, 'izinsakit']);
    Route::post('/presensi/approveizinsakit', [PresensiController::class, 'approveizinsakit']);
    Route::get('/presensi/{id}/batalkanizinsakit', [PresensiController::class, 'batalkanizinsakit']);

    Route::get('/panel/pengajuan', [PanelPengajuanController::class, 'index'])->name('panelpengajuan.index');
    Route::delete('/panel/pengajuan/delete/{id}', [PanelPengajuanController::class, 'destroy'])->name('panelpengajuan.destroy');
    Route::get('/panel/pengajuan/{id}/edit', [PanelPengajuanController::class, 'edit'])->name('panelpengajuan.edit');
    Route::post('/panel/pengajuan/{id}', [PanelPengajuanController::class, 'update'])->name('panelpengajuan.update');
    Route::get('/panel/rencanakerja', [PanelRencanaKerjaController::class, 'index']);
    Route::get('/panel/pengajuan/{id}', [PanelPengajuanController::class, 'list'])->name('panelpengajuan.list');

    //persetujuan absen masuk
    Route::get('/presensi/persetujuan', [PresensiController::class, 'persetujuanAbsen']);

    Route::post('/presensi/persetujuan/masuk/tolak/{id}', [PresensiController::class, 'persetujuanMasukTolak']);
    Route::post('/presensi/persetujuan/masuk/terima/{id}', [PresensiController::class, 'persetujuanMasukTerima']);
    Route::post('/presensi/persetujuan/search', [PresensiController::class, 'persetujuanSearch']);

    //persetujuam absen keluar
    Route::post('/presensi/persetujuan/pulang/tolak/{id}', [PresensiController::class, 'persetujuanPulangTolak']);
    Route::post('/presensi/persetujuan/pulang/terima/{id}', [PresensiController::class, 'persetujuanPulangTerima']);

    //umlkadd
    Route::post('/presensi/persetujuan/umlk/{id}', [PresensiController::class, 'addEmployeeUMLK']);

    //list penolakan absen
    Route::get('/presensi/penolakan', [PresensiController::class, 'absensiDitolak']);
    Route::post('/presensi/penolakan/search', [PresensiController::class, 'absensiDitolakSearch']);
    Route::post('/presensi/penolakan/masuk/terima/{id}', [PresensiController::class, 'absensiMasukDitolakTerima']);
    Route::post('/presensi/penolakan/pulang/terima/{id}', [PresensiController::class, 'absensiPulangDitolakTerima']);
    Route::post('/presensi/penolakan/hapus/{id}', [PresensiController::class, 'absensiDitolakHapus']);

    //persetujuan absen
    Route::get('/presensi/persetujuan', [PresensiController::class, 'persetujuanAbsen']);
    Route::post('/presensi/persetujuan/tolak/{id}', [PresensiController::class, 'persetujuanTolak']);
    Route::post('/presensi/persetujuan/terima/{id}', [PresensiController::class, 'persetujuanTerima']);
    Route::post('/presensi/persetujuan/search', [PresensiController::class, 'persetujuanSearch']);

    //list penolakan absen
    Route::get('/presensi/penolakan', [PresensiController::class, 'absensiDitolak']);
    Route::post('/presensi/penolakan/search', [PresensiController::class, 'absensiDitolakSearch']);
    Route::post('/presensi/penolakan/terima/{id}', [PresensiController::class, 'absensiDitolakTerima']);
    Route::post('/presensi/penolakan/hapus/{id}', [PresensiController::class, 'absensiDitolakHapus']);

    //potongan
    Route::post('/presensi/karyawan/potongan', [PresensiController::class, 'addPotonganKaryawan']);

    //get api tanggal merah
    Route::post('/presensi/get-holidays', [PresensiController::class, 'getHolidays']);

    //set tanggal merah
    Route::get('presensi/hari-libur/datatables', [PresensiController::class, 'hariLiburDatatables'])->name('harilibur.datatables');
    Route::get('/presensi/hari/libur', [PresensiController::class, 'hariLibur']);
    Route::post('/presensi/hari/libur/proses', [PresensiController::class, 'addHariLibur']);
    Route::post('/presensi/hari/libur/delete/{id} ', [PresensiController::class, 'hapusHariLibur'])->name('hari-libur-hapus');
    Route::post('/presensi/hari/libur/update/{id} ', [PresensiController::class, 'editHariLibur']);

    //map karyawan detail
    Route::get('/presensi/karyawan/map/detail/{id}', [PresensiController::class, 'absensiMapKaryawan']);
    Route::get('/presensi/karyawan/map/detail/keluar/{id}', [PresensiController::class, 'absensiMapKaryawanPulang']);

    // izin admin panel
    Route::post('/admin/izin/create', [PresensiController::class, 'createIzinAdmin'])->name('admin.izin.create');
    Route::put('/admin/izin/update', [PresensiController::class, 'updateIzinAdmin'])->name('admin.izin.update');
    Route::delete('/admin/izin/delete', [PresensiController::class, 'deleteIzinAdmin'])->name('admin.izin.delete');
    Route::post('/admin/izin/get-edit', [PresensiController::class, 'getDataIzinEdit'])->name('admin.izin.get-edit');

    // ARDI
    Route::post('/presensi/detailabsenpresensisemua', [PresensiController::class, 'detailabsenpresensisemua']);
    Route::get('/presensi/izin/karyawan', [PresensiController::class, 'izinKaryawanAdmin']);
    Route::post('/presensi/izin/karyawan/search', [PresensiController::class, 'izinKaryawanAdminSearch']);
    Route::get('/presensi/izin/karyawan/laporan', [PresensiController::class, 'izinKaryawanAdminHasil']);
    Route::post('/presensi/izin/karyawan/track', [PresensiController::class, 'izinAjax'])->name('izin.ajax');


    //Cabang
    Route::get('/cabang/datatables', [CabangController::class, 'cabangDatatables'])->name('cabang.datatables');
    Route::get('/cabang', [CabangController::class, 'index']);
    Route::post('/cabang/store', [CabangController::class, 'store']);
    Route::post('/cabang/edit', [CabangController::class, 'edit']);
    Route::post('/cabang/update', [CabangController::class, 'update']);
    Route::post('/cabang/{kode_cabang}/delete', [CabangController::class, 'delete']);
    Route::get('/cabang/map/{id}', [CabangController::class, 'mapCabang']);

    //Konfigurasi

    Route::get('/konfigurasi/lokasikantor', [KonfigurasiController::class, 'lokasikantor']);
    Route::post('/konfigurasi/updatelokasikantor', [KonfigurasiController::class, 'updatelokasikantor']);

    Route::get('/konfigurasi/jamkerja', [KonfigurasiController::class, 'jamkerja']);
    Route::post('/konfigurasi/storejamkerja', [KonfigurasiController::class, 'storejamkerja']);
    Route::post('/konfigurasi/editjamkerja', [KonfigurasiController::class, 'editjamkerja']);
    Route::post('/konfigurasi/updatejamkerja', [KonfigurasiController::class, 'updatejamkerja']);
    Route::get('/konfigurasi/{karyawan:email}/setjamkerja', [KonfigurasiController::class, 'setjamkerja'])->name('karyawan.jamkerja');
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

    /*===========================================
                     PAYROLL
    ========================================== */
    Route::prefix('/payroll')->group(function () {
        Route::name('payroll.')->group(function () {
            Route::get('/', [PayrollController::class, 'payrollReport']);
            Route::post('/employee', [PayrollController::class, 'employeeReportPayroll'])->name('employee');
            Route::post('/all-employee', [PayrollController::class, 'allEmployeePayrollReport'])->name('all-employee');
            Route::post('/daily-employee', [PayrollController::class, 'dailyEmployeePayrollReport'])->name('daily-employee');

            /*=== BONUS ===*/
            Route::post('/bonus', [PayrollController::class, 'addEmployeeBonus'])->name('bonus.add');

            /*===POTONGAN===*/
            Route::get('/deductions', [PayrollController::class, 'deductions'])->name('deductions');
            // jenis potongan
            Route::get('/deductions/datatables-type', [PayrollController::class, 'deductionsTypeDatatable'])->name('deductions.datatables-type');
            Route::get('/deductions/datatables', [PayrollController::class, 'deductionsDatatable'])->name('deductions.datatables');

            Route::post('/deductions/type-search', [PayrollController::class, 'deductionsSearch'])->name('deductions.type.search');
            Route::post('/deductions/getbyid', [PayrollController::class, 'getDeductionsTypeById'])->name('deductions.type.getbyid');
            Route::post('/deductions/type', [PayrollController::class, 'deductionsTypeCreate'])->name('deductions.type.create');
            Route::put('/deductions/type', [PayrollController::class, 'deductionsTypeUpdate'])->name('deductions.type.update');
            Route::delete('/deductions/type', [PayrollController::class, 'deductionsTypeDelete'])->name('deductions.type.delete');
            // potongan karyawan
            Route::post('/deductions/get-by-id', [PayrollController::class, 'getDeductionsByIdJSON'])->name('deductions.getbyid');
            Route::post('/deductions/detail-json', [PayrollController::class, 'detailEmployeeDeductionJSON'])->name('deductions.detail-json');
            Route::post('/deductions', [PayrollController::class, 'createEmployeeDeductions'])->name('deductions.create');
            Route::put('/deductions', [PayrollController::class, 'updateEmployeeDeductions'])->name('deductions.update');
            Route::delete('/deductions', [PayrollController::class, 'deleteEmployeeDeductions'])->name('deductions.delete');
            // Loan or pinjaman
            Route::get('/loan', [PayrollController::class, 'indexLoan'])->name('loan.index');
            Route::post('/loan/add', [PayrollController::class, 'addEmployeeLoan'])->name('loan.add');
            Route::post('/loan/edit/{id} ', [PayrollController::class, 'editEmployeeLoan'])->name('loan.edit');
            Route::post('/loan/delete/{id} ', [PayrollController::class, 'deleteEmployeeLoan'])->name('loan.delete');
            Route::post('/loan/search', [PayrollController::class, 'searchEmployeeLoan'])->name('loan.search');

            //index bonus
            Route::get('/bonus/datatables', [PayrollController::class, 'bonusTypeDatatable'])->name('bonus.datatables-type');
            Route::get('/bonus', [PayrollController::class, 'indexBonus'])->name('bonus.index');
            // Jenis Bonus
            Route::post('/bonus/add', [PayrollController::class, 'addEmployeeBonusJenis'])->name('bonus.add');
            Route::post('/bonus/edit/{id} ', [PayrollController::class, 'editEmployeeBonusJenis'])->name('bonus.edit');
            Route::post('/bonus/delete/{id} ', [PayrollController::class, 'deleteEmployeeBonusJenis'])->name('bonus.delete');
            //bonus
            Route::post('/bonus/karyawan/add', [PayrollController::class, 'addEmployeeBonus'])->name('bonus.karyawan.add');
            Route::post('/bonus/karyawan/edit/{id} ', [PayrollController::class, 'editEmployeeBonus'])->name('bonus.karyawan.edit');
            Route::post('/bonus/karyawan/delete/{id} ', [PayrollController::class, 'deleteEmployeeBonus'])->name('bonus.karyawan.delete');
            Route::post('/bonus/karyawan/search', [PayrollController::class, 'searchEmployeeBonus'])->name('bonus.karyawan.search');

            //pengajuan gaji
            Route::post('/pengajuan/add', [PayrollController::class, 'createSalarySubmission'])->name('pengajuan.add');
            Route::post('/pengajuan/track', [PayrollController::class, 'salaryAjax'])->name('gaji.ajax');
        });
    });


    //======================================================================================================

    /*===========================================
                GABUNG ARDI
    ========================================== */
    Route::get('/karyawan/detail/{karyawan:email}', [KaryawanController::class, 'karyawanDetail'])->name('admin.karyawan.detail');
    Route::get('/karyawan/edit/{karyawan:email}', [KaryawanController::class, 'karyawanEdit'])->name('admin.karyawan.edit');
    Route::post('/karyawan/update/{karyawan:email}', [KaryawanController::class, 'karyawanUpdate'])->name('admin.karyawan.update');
    Route::get('/karyawan/edit/biodata/{karyawan:email}', [KaryawanController::class, 'karyawanEditBiodata'])->name('admin.karyawan.edit.biodata');
    Route::post('/karyawan/updatebiodata/{karyawan:email}', [KaryawanController::class, 'karyawanUpdateBiodata'])->name('admin.karyawan.update.biodata');
    Route::get('/karyawan/edit/susunankeluarga/{karyawan:email}', [KaryawanController::class, 'karyawanEditSusunanKeluarga'])->name('admin.karyawan.edit.susunan');
    Route::post('/karyawan/updatesusunan/{karyawan:email}', [KaryawanController::class, 'karyawanUpdateSusunanKeluarga'])->name('admin.karyawan.update.susunan');
    Route::get('/karyawan/edit/riwayatpendidikan/{karyawan:email}', [KaryawanController::class, 'karyawanEditRiwayatPendidikan'])->name('admin.karyawan.edit.pendidikan');
    Route::post('/karyawan/updatependidikan/{karyawan:email}', [KaryawanController::class, 'karyawanUpdateRiwayatPendidikan'])->name('admin.karyawan.update.pendidikan');
    Route::get('/karyawan/edit/dokumen/{karyawan:email}', [KaryawanController::class, 'karyawanEditDokumen'])->name('admin.karyawan.edit.dokumen');
    Route::post('/karyawan/updatedokumen/{karyawan:email}', [KaryawanController::class, 'karyawanUpdateDokumen'])->name('admin.karyawan.update.dokumen');
    Route::get('/karyawan/edit/saudara/{id}/{email}', [KaryawanController::class, 'karyawanEditSaudara'])->name('admin.karyawan.edit.saudara');
    Route::post('/karyawan/updatesaudara', [KaryawanController::class, 'karyawanUpdateSaudara'])->name('admin.karyawan.update.saudara');
    Route::get('/karyawan/edit/anak/{id}/{email}', [KaryawanController::class, 'karyawanEditAnak'])->name('admin.karyawan.edit.anak');
    Route::post('/karyawan/updateanak', [KaryawanController::class, 'karyawanUpdateAnak'])->name('admin.karyawan.update.anak');
    Route::get('/karyawan/delete/{karyawan:id}', [KaryawanController::class, 'delete'])->name('karyawan.delete');

    Route::post('/karyawan/aktifkan-karyawan', [KaryawanController::class, 'aktifkanKaryawan'])->name('karyawan.aktifkan');
});

Route::group(['prefix' => 'iclock'], function () {
    Route::post('webhook', [WebhookIclockController::class, 'index']);
});
