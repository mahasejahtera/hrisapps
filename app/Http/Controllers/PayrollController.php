<?php

namespace App\Http\Controllers;

use App\Models\Bonus;
use App\Models\BonusJenis;
use App\Models\Holiday;
use App\Models\Karyawan;
use App\Models\KaryawanBiodata;
use App\Models\KaryawanContract;
use App\Models\Lembur;
use App\Models\Loan;
use App\Models\PengajuanGaji;
use App\Models\Pengajuanizin;
use App\Models\Potongan;
use App\Models\PotonganJenis;
use App\Models\Presensi;
use App\Models\TrackingGaji;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class PayrollController extends BaseController
{
    private $suratController;

    public function __construct()
    {
        $this->suratController = new SuratController();
    }

    /*===========================================
                    DATATABLE
    ===========================================*/

    // deductions
    public function deductionsTypeDatatable(Request $request)
    {
        if ($request->ajax()) {
            $deductions = PotonganJenis::query();

            if ($request->tipe) {
                $deductions = $deductions->where('tipe', $request->tipe);
            }

            return DataTables::of($deductions)
                ->addIndexColumn()
                ->editColumn('tipe', function (PotonganJenis $potonganJenis) {
                    if ($potonganJenis->tipe == 1) {
                        $tipe = 'Tetap';
                    } else {
                        $tipe = 'Lain-Lain';
                    }

                    return $tipe;
                })
                ->addColumn('action', function (PotonganJenis $item) {
                    $action = '<button type="button" class="btn btn-warning" data-action-jenis="edit" data-jenis="' . $item->id . '" data-bs-target="#jenisPotonganModal">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="#ffffff" viewBox="0 0 256 256"><path d="M227.31,73.37,182.63,28.68a16,16,0,0,0-22.63,0L36.69,152A15.86,15.86,0,0,0,32,163.31V208a16,16,0,0,0,16,16H92.69A15.86,15.86,0,0,0,104,219.31L227.31,96a16,16,0,0,0,0-22.63ZM51.31,160,136,75.31,152.69,92,68,176.68ZM48,179.31,76.69,208H48Zm48,25.38L79.31,188,164,103.31,180.69,120Zm96-96L147.31,64l24-24L216,84.68Z"></path></svg>
                                </button>
                                <button type="button" class="btn btn-danger ms-0 ms-md-3 mt-2 mt-md-0" data-action-jenis="delete" data-bs-target="#hapusJenisPotonganModal" data-jenis="' . $item->id . '">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="#ffffff" viewBox="0 0 256 256"><path d="M216,48H176V40a24,24,0,0,0-24-24H104A24,24,0,0,0,80,40v8H40a8,8,0,0,0,0,16h8V208a16,16,0,0,0,16,16H192a16,16,0,0,0,16-16V64h8a8,8,0,0,0,0-16ZM96,40a8,8,0,0,1,8-8h48a8,8,0,0,1,8,8v8H96Zm96,168H64V64H192ZM112,104v64a8,8,0,0,1-16,0V104a8,8,0,0,1,16,0Zm48,0v64a8,8,0,0,1-16,0V104a8,8,0,0,1,16,0Z"></path></svg>
                                </button>';

                    return $action;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
    }

    public function deductionsDatatable(Request $request)
    {
        if ($request->ajax()) {
            $deductions = Potongan::with(['karyawan', 'jenis_potongan']);

            return DataTables::of($deductions)
                ->addIndexColumn()
                ->editColumn('jml_potongan', function (Potongan $potongan) {
                    return 'Rp. ' . number_format($potongan->jml_potongan, 0, ',', '.');
                })
                ->editColumn('jenis_potongan.tipe', function (Potongan $potongan) {
                    if ($potongan->jenis_potongan->tipe == 1) {
                        $tipe = 'Tetap';
                    } else {
                        $tipe = 'Lain-Lain';
                    }

                    return $tipe;
                })
                ->addColumn('action', function (Potongan $deduction) {
                    $action = '<button type="button" class="btn btn-success detail-potongan" data-potongan="' . $deduction->id . '" data-bs-target="#detailPotonganModal">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="#ffffff" viewBox="0 0 256 256"><path d="M247.31,124.76c-.35-.79-8.82-19.58-27.65-38.41C194.57,61.26,162.88,48,128,48S61.43,61.26,36.34,86.35C17.51,105.18,9,124,8.69,124.76a8,8,0,0,0,0,6.5c.35.79,8.82,19.57,27.65,38.4C61.43,194.74,93.12,208,128,208s66.57-13.26,91.66-38.34c18.83-18.83,27.3-37.61,27.65-38.4A8,8,0,0,0,247.31,124.76ZM128,192c-30.78,0-57.67-11.19-79.93-33.25A133.47,133.47,0,0,1,25,128,133.33,133.33,0,0,1,48.07,97.25C70.33,75.19,97.22,64,128,64s57.67,11.19,79.93,33.25A133.46,133.46,0,0,1,231.05,128C223.84,141.46,192.43,192,128,192Zm0-112a48,48,0,1,0,48,48A48.05,48.05,0,0,0,128,80Zm0,80a32,32,0,1,1,32-32A32,32,0,0,1,128,160Z"></path></svg>
                                </button>
                                <button type="button" class="btn btn-warning edit-potongan ms-0 ms-md-3 mt-2 mt-md-0" data-potongan="' . $deduction->id . '" data-bs-target="#editPotonganModal">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="#ffffff" viewBox="0 0 256 256"><path d="M227.31,73.37,182.63,28.68a16,16,0,0,0-22.63,0L36.69,152A15.86,15.86,0,0,0,32,163.31V208a16,16,0,0,0,16,16H92.69A15.86,15.86,0,0,0,104,219.31L227.31,96a16,16,0,0,0,0-22.63ZM51.31,160,136,75.31,152.69,92,68,176.68ZM48,179.31,76.69,208H48Zm48,25.38L79.31,188,164,103.31,180.69,120Zm96-96L147.31,64l24-24L216,84.68Z"></path></svg>
                                </button>
                                <button type="button" class="btn btn-danger delete-potongan ms-0 ms-md-3 mt-2 mt-md-0" data-bs-target="#hapusPotonganModal" data-potongan="' . $deduction->id . '">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="#ffffff" viewBox="0 0 256 256"><path d="M216,48H176V40a24,24,0,0,0-24-24H104A24,24,0,0,0,80,40v8H40a8,8,0,0,0,0,16h8V208a16,16,0,0,0,16,16H192a16,16,0,0,0,16-16V64h8a8,8,0,0,0,0-16ZM96,40a8,8,0,0,1,8-8h48a8,8,0,0,1,8,8v8H96Zm96,168H64V64H192ZM112,104v64a8,8,0,0,1-16,0V104a8,8,0,0,1,16,0Zm48,0v64a8,8,0,0,1-16,0V104a8,8,0,0,1,16,0Z"></path></svg>
                                </button>';

                    return $action;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
    }


    // bonus
    public function bonusTypeDatatable(Request $request)
    {
        if ($request->ajax()) {
            $bonus = BonusJenis::query();

            if ($request->tipe) {
                $bonus = $bonus->where('tipe_bonus', $request->tipe);
            }

            return DataTables::of($bonus)
                ->addIndexColumn()
                ->editColumn('tipe_bonus', function (BonusJenis $bonusJenis) {
                    if ($bonusJenis->tipe_bonus == 1) {
                        $tipe = 'Tetap';
                    } else {
                        $tipe = 'Lain-Lain';
                    }

                    return $tipe;
                })
                ->addColumn('action', function (BonusJenis $d) {
                    $action = '<a href="#" class="edit btn btn-warning" data-bs-toggle="modal"
                                        data-bs-target="#editjenisbonus" data-id = "' . $d->id . '"
                                        data-namabonus ="' . $d->nama_bonus . '"
                                        data-jenisbonus ="' . $d->tipe_bonus . '">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="#ffffff" viewBox="0 0 256 256"><path d="M224,120v88a16,16,0,0,1-16,16H48a16,16,0,0,1-16-16V48A16,16,0,0,1,48,32h88a8,8,0,0,1,0,16H48V208H208V120a8,8,0,0,1,16,0Zm5.66-50.34-96,96A8,8,0,0,1,128,168H96a8,8,0,0,1-8-8V128a8,8,0,0,1,2.34-5.66l96-96a8,8,0,0,1,11.32,0l32,32A8,8,0,0,1,229.66,69.66Zm-17-5.66L192,43.31,179.31,56,200,76.69Z"></path></svg>
                                    </a>';

                    return $action;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
    }


    /*===========================================
                    REPORT
    ===========================================*/
    public function payrollReport()
    {
        $namabulan = ["", "Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember"];
        $karyawan = Karyawan::with(['jabatan_kerja', 'department', 'cabang', 'contract', 'oldContract'])->where('is_daily', 0)->orderBy('nama_lengkap', 'ASC')->get();
        return view('payroll.report.payroll-report', compact('namabulan', 'karyawan'));
    }

    public function employeeReportPayroll(Request $request)
    {
        $nik = $request->nik;
        $bulan = $request->bulan;
        $tahun = $request->tahun;
        $status = $request->status;
        $karyawan = Karyawan::where('is_daily', 0)->get();
        $karyawanPribadi = Karyawan::with(['jabatan_kerja', 'department', 'contract', 'oldContract'])->where('nik', $nik)
            ->first();
        $karyawanGaji = $karyawanPribadi->contract;
        $namabulan = ["", "Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember"];

        //Pengambilan data bulan sebelumnya dan tahun selanjutnya
        $bulan_sebelumnya = $bulan - 1;
        $tahun_sebelumnya = $tahun;
        if ($bulan_sebelumnya == 0) {
            $bulan_sebelumnya = 12;
            $tahun_sebelumnya = $tahun - 1;
        }

        $today = Carbon::now();
        $todayFormatted = $today->format('Y-m-d');
        $startDate = Carbon::create($tahun_sebelumnya, $bulan_sebelumnya, 29);
        $endDate = Carbon::create($tahun, $bulan, 28);

        //Penghitungan jumlah cuti
        $cutibulanpertama = Pengajuanizin::where('nik', $nik)
            ->whereMonth('tgl_mulai_izin', $bulan)
            ->whereYear('tgl_mulai_izin', $tahun)
            ->where('status_approved', 5)
            ->where('status', 'c')
            ->whereDate('tgl_mulai_izin', '<=', $tahun . '-' . $bulan . '-28')
            ->sum('bulan_pertama');

        $cutibulanselanjutnya = Pengajuanizin::where('nik', $nik)
            ->whereDate('tgl_akhir_izin', '>', $startDate)
            ->whereDate('tgl_akhir_izin', '<=', $endDate)
            ->where('status_approved', 5)
            ->where('status', 'c')
            ->sum('bulan_kedua');

        $jumlahcuti = $cutibulanpertama + $cutibulanselanjutnya; //penghitungan total cuti

        // Penghitungan jumlah sakit
        $sakitbulanpertama = Pengajuanizin::where('nik', $nik)
            ->whereMonth('tgl_mulai_izin', $bulan)
            ->whereYear('tgl_mulai_izin', $tahun)
            ->where('status_approved', 5)
            ->where('status', 's')
            ->whereDate('tgl_mulai_izin', '<=', $tahun . '-' . $bulan . '-28')
            ->sum('bulan_pertama');

        $sakitbulanselanjutnya = Pengajuanizin::where('nik', $nik)
            ->whereDate('tgl_akhir_izin', '>', $startDate)
            ->whereDate('tgl_akhir_izin', '<=', $endDate)
            ->where('status_approved', 5)
            ->where('status', 's')
            ->sum('bulan_kedua');

        $jumlahsakit = $sakitbulanpertama + $sakitbulanselanjutnya; //penghitungan total sakit

        //penghitungan jumlah izin
        $izinbulanpertama = Pengajuanizin::where('nik', $nik)
            ->whereMonth('tgl_mulai_izin', $bulan)
            ->whereYear('tgl_mulai_izin', $tahun)
            ->whereNot('jenis_izin_id', '=', 10)
            ->where('status_approved', 5)
            ->where('status', 'i')
            ->whereDate('tgl_mulai_izin', '<=', $tahun . '-' . $bulan . '-28')
            ->sum('bulan_pertama');

        $izinbulanselanjutnya = Pengajuanizin::where('nik', $nik)
            ->whereDate('tgl_akhir_izin', '>', $startDate)
            ->whereDate('tgl_akhir_izin', '<=', $endDate)
            ->whereNot('jenis_izin_id', '=', 10)
            ->where('status_approved', 5)
            ->where('status', 'i')
            ->sum('bulan_kedua');

        $jumlahizin = $izinbulanpertama + $izinbulanselanjutnya; //penghitungan total izin

        //hitung jumlah masuk
        $jmlMasuk = Presensi::where('nik', $nik)
            ->whereBetween('tgl_presensi', [$startDate, $endDate])
            ->whereIn('absen_in_status', [1, 2, 5])
            ->count();

        // Total Jumlah Masuk
        $getLibur = Holiday::whereDate('holidays_date', '<=', $endDate)
            ->whereBetween('holidays_date', [$startDate, date('Y-m-d')])
            ->get();

        $JmlLibur = $getLibur->count();

        //hitung total tanggal merah hari minggu bulanan
        $totalLiburMinggu = 0;
        foreach ($getLibur as $holiday) {
            $tanggalLibur = Carbon::parse($holiday->holidays_date);
            if ($tanggalLibur->dayOfWeek == Carbon::SUNDAY) {
                $totalLiburMinggu++;
            }
        }

        //total jumlah masuk
        $jmlMasuk += $JmlLibur;
        $jmlMasuk -= $totalLiburMinggu;
        $jmlMasuk += $jumlahcuti;
        $jmlMasuk += $jumlahsakit;
        $jmlMasuk += $jumlahizin;

        //hitung jumlah hari kerja
        $jumlahHariKerja = 0;
        $periode = CarbonPeriod::create($startDate, $today);
        foreach ($periode as $date) {
            if ($date->dayOfWeek != Carbon::SUNDAY) {
                $jumlahHariKerja++;
            }
        }

        if ($jumlahHariKerja > 26) $jumlahHariKerja = 26;

        //hitung mangkir
        $jumlahHariKerja += $JmlLibur;
        $jumlahHariKerja -= $totalLiburMinggu;
        $mangkir = $jumlahHariKerja - $jmlMasuk;
        // dd([$jumlahHariKerja, $jmlMasuk, $mangkir]);

        if ($mangkir < 0) $mangkir = 0;
        //potongan mangkir
        $potonganmangkir = ($karyawanGaji->salary / 26) * $mangkir;

        // hitung gaji pokok dan operasional
        $gajiPokok = $karyawanGaji->salary * 0.75;
        $gajiOperasional = $karyawanGaji->salary * 0.25;

        // hitung tidak absen pulang
        $jmlTidakAbsenPulang = Presensi::where('nik', $nik)
            ->whereBetween('tgl_presensi', [$startDate, $endDate])
            ->where('jam_out', null)
            ->whereIn('absen_in_status', [1, 2, 5])
            ->count();

        $potonganTidakAbsenPulang = 0;
        //cek tidak absen pulang
        if ($jmlTidakAbsenPulang >= 3 && $jmlTidakAbsenPulang <= 5) {
            // $jmlMasuk = $jmlMasuk - 1;
            $potonganTidakAbsenPulang = 1;
        } elseif ($jmlTidakAbsenPulang >= 6 && $jmlTidakAbsenPulang <= 8) {
            // $jmlMasuk = $jmlMasuk - 2;
            $potonganTidakAbsenPulang = 2;
        } elseif ($jmlTidakAbsenPulang >= 9 && $jmlTidakAbsenPulang <= 11) {
            // $jmlMasuk = $jmlMasuk - 3;
            $potonganTidakAbsenPulang = 3;
        } elseif ($jmlTidakAbsenPulang >= 12 && $jmlTidakAbsenPulang <= 14) {
            // $jmlMasuk = $jmlMasuk - 4;
            $potonganTidakAbsenPulang = 4;
        } elseif ($jmlTidakAbsenPulang >= 15 && $jmlTidakAbsenPulang <= 17) {
            // $jmlMasuk = $jmlMasuk - 5;
            $potonganTidakAbsenPulang = 5;
        } elseif ($jmlTidakAbsenPulang >= 18 && $jmlTidakAbsenPulang <= 20) {
            // $jmlMasuk = $jmlMasuk - 6;
            $potonganTidakAbsenPulang = 6;
        } elseif ($jmlTidakAbsenPulang >= 21 && $jmlTidakAbsenPulang <= 23) {
            // $jmlMasuk = $jmlMasuk - 7;
            $potonganTidakAbsenPulang = 7;
        } elseif ($jmlTidakAbsenPulang >= 24 && $jmlTidakAbsenPulang <= 26) {
            // $jmlMasuk = $jmlMasuk - 8;
            $potonganTidakAbsenPulang = 8;
        } else {
            // $jmlMasuk = $jmlMasuk;
        }

        //hitung pro-rata absen pulang
        $jmlProRataAbsenPulang = ($karyawanGaji->salary / 26) * $potonganTidakAbsenPulang;

        // jumlah terlambat
        $dataTerlambat = Presensi::where('nik', $nik)
            ->whereBetween('tgl_presensi', [$startDate, $endDate])
            ->whereIn('absen_in_status', [1, 2, 5])
            ->where('is_late', 1)
            ->count();

        $jumlahPotonganTerlambat = $dataTerlambat * 50000;

        // hitung gaji lembur
        $dataLembur = Lembur::where('karyawan_id', $karyawanPribadi->id)
            ->whereBetween('tgl_lembur', [$startDate, $endDate])
            ->where('status_approved', 5)
            ->get();

        $selisihjambiasa = 0;
        $selisihjamminggu = 0;
        foreach ($dataLembur as $lembur) {
            $tgl_lembur = Carbon::parse($lembur->tgl_lembur);
            $jam_mulai = Carbon::parse($lembur->jam_mulai);
            $jam_selesai = Carbon::parse($lembur->jam_selesai);
            // cari hari libur
            $hariLiburLembur = Holiday::where('holidays_date', $lembur->tgl_lembur)->count();

            if ($tgl_lembur->isSunday() || $hariLiburLembur > 0) {
                $selisihjamminggu += $jam_mulai->diffInHours($jam_selesai);
            } else {
                $selisihjambiasa += $jam_mulai->diffInHours($jam_selesai);
            }
        }

        $hitungLemburJambiasa = 0;
        if ($selisihjambiasa == 1) {
            $hitungLemburJambiasa = 1.5;
        } else if ($selisihjambiasa == 2) {
            $hitungLemburJambiasa = 3.5;
        } else if ($selisihjambiasa == 3) {
            $hitungLemburJambiasa = 5.5;
        } else if ($selisihjambiasa == 4) {
            $hitungLemburJambiasa = 7.5;
        } else if ($selisihjambiasa == 5) {
            $hitungLemburJambiasa = 9.5;
        } else if ($selisihjambiasa == 6) {
            $hitungLemburJambiasa = 11.5;
        } else {
            $hitungLemburJambiasa =  0;
        }

        $gajilemburperjam = $gajiPokok / 173;
        $totalGajiLembur = ($hitungLemburJambiasa * $gajilemburperjam) + ($selisihjamminggu * $gajilemburperjam * 2);

        //UMLK
        $umlk = Presensi::where('nik', $nik)
            ->whereBetween('tgl_presensi', [$startDate, $endDate])
            ->sum('meal_num');

        //penghitungan UMLK
        $jabatanKaryawan = $karyawanPribadi->contract->jabatan_id;
        //staff
        if ($karyawanPribadi->role_id == 1) {
            if ($jabatanKaryawan == 8 || $jabatanKaryawan == 11 || $jabatanKaryawan == 16 || $jabatanKaryawan == 21 || $jabatanKaryawan == 27 || $jabatanKaryawan == 34 || $jabatanKaryawan == 41 || $jabatanKaryawan == 48) {
                //spv
                $totalumlk = $umlk * 23300;
            } else {
                // staff
                $totalumlk = $umlk * 20000;
            }
        }

        // manager
        if ($karyawanPribadi->role_id == 2) {
            $totalumlk = $umlk * 25000;
        }

        // gm
        if ($karyawanPribadi->role_id == 3) {
            $totalumlk = $umlk * 28000;
        }

        // direksi
        if ($karyawanPribadi->role_id == 4 || $karyawanPribadi->role_id == 5) {
            $totalumlk = $umlk * 30000;
        }

        // BONUS
        //tetap
        $karyawanBonusTetap = Bonus::with(['karyawan', 'jenis_bonus'])
            ->where('karyawan_id', $karyawanPribadi->id)
            ->whereRelation('jenis_bonus', 'tipe_bonus', '=', 1)
            ->where('mulai_bonus', '<=', "$tahun-$bulan->01")
            ->get();

        $karyawanBonusOther = Bonus::with(['karyawan', 'jenis_bonus'])
            ->where('karyawan_id', $karyawanPribadi->id)
            ->whereRelation('jenis_bonus', 'tipe_bonus', '=', 2)
            ->where('bulan_bonus', $bulan)
            ->where('tahun_bonus', $tahun)
            ->get();


        $totalBonusTetap = Bonus::with(['karyawan', 'jenis_bonus'])
            ->where('karyawan_id', $karyawanPribadi->id)
            ->whereRelation('jenis_bonus', 'tipe_bonus', '=', 1)
            ->where('mulai_bonus', '<=', "$tahun-$bulan->01")
            ->sum('jumlah_bonus');

        $totalBonusOther = Bonus::with(['karyawan', 'jenis_bonus'])
            ->where('karyawan_id', $karyawanPribadi->id)
            ->whereRelation('jenis_bonus', 'tipe_bonus', '=', 2)
            ->where('bulan_bonus', $bulan)
            ->where('tahun_bonus', $tahun)
            ->sum('jumlah_bonus');

        $totalBonus = $totalBonusTetap + $totalBonusOther;

        // hitung total pendapatan
        $totalPendapatan = 0;
        $totalPendapatan += $karyawanGaji->salary;
        $totalPendapatan += $totalumlk;
        $totalPendapatan += $totalGajiLembur;
        $totalPendapatan += $totalBonus;

        // cashbon
        $pinjaman = Loan::where('karyawan_id', $karyawanPribadi->id)
            ->where('is_lunas', 0)
            ->where('tahun_pinjam', '<=', $tahun)
            ->get();

        $totalPinjaman = 0;
        $nominalCicilan = 0;
        $totalDibayar = 0;

        foreach ($pinjaman as $pnj) {
            $totalPinjaman += $pnj->jumlah_pinjam;
            $nominalCicilan += $pnj->jumlah_cicilan;
            $totalDibayar += $pnj->total_dibayar;
        }

        $sisaPinjaman = $totalPinjaman - $totalDibayar;

        $karyawanPotongan = Potongan::with(['karyawan', 'jenis_potongan'])
            ->where('karyawan_id', $karyawanPribadi->id)
            ->where('tahun_mulai', '<=', $tahun)
            ->where('is_active', 1)
            ->get();

        $jmlPotongan = 0;
        foreach ($karyawanPotongan as $ptg) {
            if ($ptg->tahun_mulai == $tahun && $ptg->bulan_mulai <= $bulan) {
                $jmlPotongan += $ptg->jml_potongan;
            } else {
                if ($ptg->tahun_mulai < $tahun) $jmlPotongan += $ptg->jml_potongan;
            }
        }

        //total potongan
        $totalPotongan = 0;
        $totalPotongan += $nominalCicilan;
        $totalPotongan += $jmlPotongan;
        $totalPotongan += $jumlahPotonganTerlambat;
        $totalPotongan += $potonganmangkir;
        $totalPotongan += $jmlProRataAbsenPulang;

        // pendapatan gaji
        $totalGaji = $totalPendapatan - $totalPotongan;

        $data = [
            'namabulan'                 => $namabulan,
            'bulan'                     => $bulan,
            'tahun'                     => $tahun,
            'karyawan'                  => $karyawan,
            'karyawanPribadi'           => $karyawanPribadi,
            'karyawanGaji'              => $karyawanGaji,
            'jmlMasuk'                  => $jmlMasuk,
            'gajiPokok'                 => $gajiPokok,
            'gajiOperasional'           => $gajiOperasional,
            'dataTerlambat'             => $dataTerlambat,
            'jmlTidakAbsenPulang'       => $jmlTidakAbsenPulang,
            'jumlahPotonganTerlambat'   => $jumlahPotonganTerlambat,
            'totalGajiLembur'           => $totalGajiLembur,
            'totalUMLK'                 => $totalumlk,
            'karyawanBonusTetap'        => $karyawanBonusTetap,
            'karyawanBonusOther'        => $karyawanBonusOther,
            'totalPendapatan'           => $totalPendapatan,
            'totalPinjaman'             => $totalPinjaman,
            'nominalCicilan'            => $nominalCicilan,
            'karyawanPotongan'          => $karyawanPotongan,
            'totalPotongan'             => $totalPotongan,
            'sisaPinjaman'              => $sisaPinjaman,
            'jamLemburHariBiasa'        => $selisihjambiasa,
            'jamLemburHariLibur'        => $selisihjamminggu,
            'mangkir'                   => $mangkir,
            'potonganmangkir'           => $potonganmangkir,
            'totalGaji'                 => $totalGaji,
            'jumlahCuti'                => $jumlahcuti,
            'jumlahSakit'               => $jumlahsakit,
            'jumlahIzin'                => $jumlahizin,
            'jmlProRataAbsenPulang'     => $jmlProRataAbsenPulang,

        ];
        return view('payroll.report.employee-payroll-report', $data);
    }


    public function allEmployeePayrollReport(Request $request)
    {
        $jenisKontrak = ['tetap', 'percobaan', 'pkwt'];
        $employeeTetapList = Karyawan::with(['jabatan_kerja', 'department', 'cabang', 'contract', 'oldContract'])
            ->select('karyawan.nik as nik')
            ->join('karyawan_contract', 'karyawan.contract_id', '=', 'karyawan_contract.id')
            ->where('status', 3)
            ->whereIn('karyawan_contract.contract_status', $jenisKontrak)
            ->orderBy('karyawan_contract.department_id', 'DESC')
            ->orderBy('karyawan.role_id', 'DESC')
            ->get();
        $allNiksTetap = [];
        foreach ($employeeTetapList as $item) {
            $allNiksTetap[] = $item->nik;
        }
        $employeeProjectList = Karyawan::with(['jabatan_kerja', 'department', 'cabang', 'contract', 'oldContract'])
            ->select('karyawan.nik as nik')
            ->join('karyawan_contract', 'karyawan.contract_id', '=', 'karyawan_contract.id')
            ->where('karyawan_contract.contract_status', 'project')
            ->where('status', 3)
            ->orderBy('karyawan_contract.department_id', 'DESC')
            ->orderBy('karyawan.role_id', 'DESC')
            ->get();
        $allNiksProject = [];
        foreach ($employeeProjectList as $item) {
            $allNiksProject[] = $item->nik;
        }
        $bulan = $request->bulan;
        $tahun = $request->tahun;

        $statusNum = 0;
        if ($request->status == 'project') $statusNum = 1;

        $pengajuanGajiData = PengajuanGaji::where('bulan', $bulan)
            ->where('tahun', $tahun)
            ->where('status_karyawan', $statusNum)
            ->first();

        $statusPayroll = PengajuanGaji::where('bulan', $bulan)
            ->where('tahun', $tahun)
            ->where('status_karyawan', 0)
            ->first();
        $statusKaryawan = $request->status;

        $hrPayrollEmployee = KaryawanContract::with(['karyawan', 'jabatan', 'department', 'cabang', 'atasanApprove', 'jabatanAtasanApprove'])
            ->where('jabatan_id', 36)
            ->where('department_id', 9)
            ->orderBy('id', 'DESC')
            ->first();

        if ($statusKaryawan == 'tetap') {
            $result = [];
            foreach ($allNiksTetap as $nik) {
                $bulan = $request->bulan;
                $tahun = $request->tahun;
                $status = $request->status;
                $karyawanPribadi = Karyawan::with(['jabatan_kerja', 'department', 'contract', 'oldContract'])->where('nik', $nik)->first();
                $karyawanGaji = $karyawanPribadi->contract;
                $karyawanBiodata = KaryawanBiodata::where('karyawan_id', $karyawanPribadi->id)->first();
                $namabulan = ["", "Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember"];

                //Pengambilan data bulan sebelumnya dan tahun selanjutnya
                $bulan_sebelumnya = $bulan - 1;
                $tahun_sebelumnya = $tahun;
                if ($bulan_sebelumnya == 0) {
                    $bulan_sebelumnya = 12;
                    $tahun_sebelumnya = $tahun - 1;
                }

                $startDate = Carbon::create($tahun_sebelumnya, $bulan_sebelumnya, 29);
                $endDate = Carbon::create($tahun, $bulan, 28);
                $today = Carbon::now();
                //Penghitungan jumlah cuti
                $cutibulanpertama = Pengajuanizin::where('nik', $nik)
                    ->whereMonth('tgl_mulai_izin', $bulan)
                    ->whereYear('tgl_mulai_izin', $tahun)
                    ->where('status_approved', 5)
                    ->where('status', 'c')
                    ->whereDate('tgl_mulai_izin', '<=', $tahun . '-' . $bulan . '-28')
                    ->sum('bulan_pertama');

                $cutibulanselanjutnya = Pengajuanizin::where('nik', $nik)
                    ->whereDate('tgl_akhir_izin', '>', $startDate)
                    ->whereDate('tgl_akhir_izin', '<=', $endDate)
                    ->where('status_approved', 5)
                    ->where('status', 'c')
                    ->sum('bulan_kedua');

                $jumlahcuti = $cutibulanpertama + $cutibulanselanjutnya; //penghitungan total cuti

                // Penghitungan jumlah sakit
                $sakitbulanpertama = Pengajuanizin::where('nik', $nik)
                    ->whereMonth('tgl_mulai_izin', $bulan)
                    ->whereYear('tgl_mulai_izin', $tahun)
                    ->where('status_approved', 5)
                    ->where('status', 's')
                    ->whereDate('tgl_mulai_izin', '<=', $tahun . '-' . $bulan . '-28')
                    ->sum('bulan_pertama');

                $sakitbulanselanjutnya = Pengajuanizin::where('nik', $nik)
                    ->whereDate('tgl_akhir_izin', '>', $startDate)
                    ->whereDate('tgl_akhir_izin', '<=', $endDate)
                    ->where('status_approved', 5)
                    ->where('status', 's')
                    ->sum('bulan_kedua');

                $jumlahsakit = $sakitbulanpertama + $sakitbulanselanjutnya; //penghitungan total sakit

                //penghitungan jumlah izin
                $izinbulanpertama = Pengajuanizin::where('nik', $nik)
                    ->whereMonth('tgl_mulai_izin', $bulan)
                    ->whereYear('tgl_mulai_izin', $tahun)
                    ->whereNot('jenis_izin_id', '=', 10)
                    ->where('status_approved', 5)
                    ->where('status', 'i')
                    ->whereDate('tgl_mulai_izin', '<=', $tahun . '-' . $bulan . '-28')
                    ->sum('bulan_pertama');

                $izinbulanselanjutnya = Pengajuanizin::where('nik', $nik)
                    ->whereDate('tgl_akhir_izin', '>', $startDate)
                    ->whereDate('tgl_akhir_izin', '<=', $endDate)
                    ->whereNot('jenis_izin_id', '=', 10)
                    ->where('status_approved', 5)
                    ->where('status', 'i')
                    ->sum('bulan_kedua');

                $jumlahizin = $izinbulanpertama + $izinbulanselanjutnya; //penghitungan total izin

                //hitung jumlah masuk
                $jmlMasuk = Presensi::where('nik', $nik)
                    ->whereBetween('tgl_presensi', [$startDate, $endDate])
                    ->whereIn('absen_in_status', [1, 2, 5])
                    ->count();

                // Total Jumlah Masuk
                $getLibur = Holiday::whereDate('holidays_date', '<=', $endDate)
                    ->whereBetween('holidays_date', [$startDate, date('Y-m-d')])
                    ->get();

                $JmlLibur = $getLibur->count();

                //hitung total tanggal merah hari minggu bulanan
                $totalLiburMinggu = 0;
                foreach ($getLibur as $holiday) {
                    $tanggalLibur = Carbon::parse($holiday->holidays_date);
                    if ($tanggalLibur->dayOfWeek == Carbon::SUNDAY) {
                        $totalLiburMinggu++;
                    }
                }

                //total jumlah masuk
                $jmlMasuk += $JmlLibur;
                $jmlMasuk -= $totalLiburMinggu;
                $jmlMasuk += $jumlahcuti;
                $jmlMasuk += $jumlahsakit;
                $jmlMasuk += $jumlahizin;

                //hitung jumlah hari kerja
                $jumlahHariKerja = 0;
                $periode = CarbonPeriod::create($startDate, $today);
                foreach ($periode as $date) {
                    if ($date->dayOfWeek != Carbon::SUNDAY) {
                        $jumlahHariKerja++;
                    }
                }

                if ($jumlahHariKerja > 26) $jumlahHariKerja = 26;

                //hitung mangkir
                $jumlahHariKerja += $JmlLibur;
                $jumlahHariKerja -= $totalLiburMinggu;
                $mangkir = $jumlahHariKerja - $jmlMasuk;
                if ($mangkir < 0) $mangkir = 0;

                //potongan mangkir
                $potonganmangkir = ($karyawanGaji->salary / 26) * $mangkir;

                // hitung gaji pokok dan operasional
                $gajiPokok = $karyawanGaji->salary * 0.75;
                $gajiOperasional = $karyawanGaji->salary * 0.25;

                // hitung tidak absen pulang
                $jmlTidakAbsenPulang = Presensi::where('nik', $nik)
                    ->whereBetween('tgl_presensi', [$startDate, $endDate])
                    ->where('jam_out', null)
                    ->whereIn('absen_in_status', [1, 2, 5])
                    ->count();

                $potonganTidakAbsenPulang = 0;
                //cek tidak absen pulang
                if ($jmlTidakAbsenPulang >= 3 && $jmlTidakAbsenPulang <= 5) {
                    // $jmlMasuk = $jmlMasuk - 1;
                    $potonganTidakAbsenPulang = 1;
                } elseif ($jmlTidakAbsenPulang >= 6 && $jmlTidakAbsenPulang <= 8) {
                    // // $jmlMasuk = $jmlMasuk - 2;
                    $potonganTidakAbsenPulang = 2;
                } elseif ($jmlTidakAbsenPulang >= 9 && $jmlTidakAbsenPulang <= 11) {
                    // // $jmlMasuk = $jmlMasuk - 3;
                    $potonganTidakAbsenPulang = 3;
                } elseif ($jmlTidakAbsenPulang >= 12 && $jmlTidakAbsenPulang <= 14) {
                    // // $jmlMasuk = $jmlMasuk - 4;
                    $potonganTidakAbsenPulang = 4;
                } elseif ($jmlTidakAbsenPulang >= 15 && $jmlTidakAbsenPulang <= 17) {
                    // // $jmlMasuk = $jmlMasuk - 5;
                    $potonganTidakAbsenPulang = 5;
                } elseif ($jmlTidakAbsenPulang >= 18 && $jmlTidakAbsenPulang <= 20) {
                    // // $jmlMasuk = $jmlMasuk - 6;
                    $potonganTidakAbsenPulang = 6;
                } elseif ($jmlTidakAbsenPulang >= 21 && $jmlTidakAbsenPulang <= 23) {
                    // // $jmlMasuk = $jmlMasuk - 7;
                    $potonganTidakAbsenPulang = 7;
                } elseif ($jmlTidakAbsenPulang >= 24 && $jmlTidakAbsenPulang <= 26) {
                    // // $jmlMasuk = $jmlMasuk - 8;
                    $potonganTidakAbsenPulang = 8;
                } else {
                    // // $jmlMasuk = $jmlMasuk;
                }

                //hitung pro-rata absen pulang
                $jmlProRataAbsenPulang = ($karyawanGaji->salary / 26) * $potonganTidakAbsenPulang;

                // jumlah terlambat
                $dataTerlambat = Presensi::where('nik', $nik)
                    ->whereBetween('tgl_presensi', [$startDate, $endDate])
                    ->whereIn('absen_in_status', [1, 2, 5])
                    ->where('is_late', 1)
                    ->count();

                $jumlahPotonganTerlambat = $dataTerlambat * 50000;

                // hitung gaji lembur
                $dataLembur = Lembur::where('karyawan_id', $karyawanPribadi->id)
                    ->whereBetween('tgl_lembur', [$startDate, $endDate])
                    ->where('status_approved', 5)
                    ->get();

                $selisihjambiasa = 0;
                $selisihjamminggu = 0;
                foreach ($dataLembur as $lembur) {
                    $tgl_lembur = Carbon::parse($lembur->tgl_lembur);
                    $jam_mulai = Carbon::parse($lembur->jam_mulai);
                    $jam_selesai = Carbon::parse($lembur->jam_selesai);

                    // cari hari libur
                    $hariLiburLembur = Holiday::where('holidays_date', $lembur->tgl_lembur)->count();

                    if ($tgl_lembur->isSunday() || $hariLiburLembur > 0) {
                        $selisihjamminggu += $jam_mulai->diffInHours($jam_selesai);
                    } else {
                        $selisihjambiasa += $jam_mulai->diffInHours($jam_selesai);
                    }
                }

                $hitungLemburJambiasa = 0;
                if ($selisihjambiasa == 1) {
                    $hitungLemburJambiasa = 1.5;
                } else if ($selisihjambiasa == 2) {
                    $hitungLemburJambiasa = 3.5;
                } else if ($selisihjambiasa == 3) {
                    $hitungLemburJambiasa = 5.5;
                } else if ($selisihjambiasa == 4) {
                    $hitungLemburJambiasa = 7.5;
                } else if ($selisihjambiasa == 5) {
                    $hitungLemburJambiasa = 9.5;
                } else if ($selisihjambiasa == 6) {
                    $hitungLemburJambiasa = 11.5;
                } else {
                    $hitungLemburJambiasa =  0;
                }

                $gajilemburperjam = $gajiPokok / 173;
                $totalGajiLembur = ($hitungLemburJambiasa * $gajilemburperjam) + ($selisihjamminggu * $gajilemburperjam * 2);

                //UMLK
                $umlk = Presensi::where('nik', $nik)
                    ->whereBetween('tgl_presensi', [$startDate, $endDate])
                    ->sum('meal_num');

                //penghitungan UMLK
                $jabatanKaryawan = $karyawanPribadi->contract->jabatan_id;
                //staff
                if ($karyawanPribadi->role_id == 1) {
                    if ($jabatanKaryawan == 8 || $jabatanKaryawan == 11 || $jabatanKaryawan == 16 || $jabatanKaryawan == 21 || $jabatanKaryawan == 27 || $jabatanKaryawan == 34 || $jabatanKaryawan == 41 || $jabatanKaryawan == 48) {
                        //spv
                        $totalumlk = $umlk * 23300;
                    } else {
                        // staff
                        $totalumlk = $umlk * 20000;
                    }
                }

                // manager
                if ($karyawanPribadi->role_id == 2) {
                    $totalumlk = $umlk * 25000;
                }

                // gm
                if ($karyawanPribadi->role_id == 3) {
                    $totalumlk = $umlk * 28000;
                }

                // direksi
                if ($karyawanPribadi->role_id == 4 || $karyawanPribadi->role_id == 5) {
                    $totalumlk = $umlk * 30000;
                }

                // BONUS
                //tetap
                $karyawanBonusTetap = Bonus::with(['karyawan', 'jenis_bonus'])
                    ->where('karyawan_id', $karyawanPribadi->id)
                    ->whereRelation('jenis_bonus', 'tipe_bonus', '=', 1)
                    ->where('mulai_bonus', '<=', "$tahun-$bulan->01")
                    ->get();

                $karyawanBonusOther = Bonus::with(['karyawan', 'jenis_bonus'])
                    ->where('karyawan_id', $karyawanPribadi->id)
                    ->whereRelation('jenis_bonus', 'tipe_bonus', '=', 2)
                    ->where('bulan_bonus', $bulan)
                    ->where('tahun_bonus', $tahun)
                    ->get();


                $totalBonusTetap = Bonus::with(['karyawan', 'jenis_bonus'])
                    ->where('karyawan_id', $karyawanPribadi->id)
                    ->whereRelation('jenis_bonus', 'tipe_bonus', '=', 1)
                    ->where('mulai_bonus', '<=', "$tahun-$bulan->01")
                    ->sum('jumlah_bonus');

                $totalBonusOther = Bonus::with(['karyawan', 'jenis_bonus'])
                    ->where('karyawan_id', $karyawanPribadi->id)
                    ->whereRelation('jenis_bonus', 'tipe_bonus', '=', 2)
                    ->where('bulan_bonus', $bulan)
                    ->where('tahun_bonus', $tahun)
                    ->sum('jumlah_bonus');

                $totalBonus = $totalBonusTetap + $totalBonusOther;

                // hitung total pendapatan
                $totalPendapatan = 0;
                $totalPendapatan += $karyawanGaji->salary;
                $totalPendapatan += $totalumlk;
                $totalPendapatan += $totalGajiLembur;
                $totalPendapatan += $totalBonus;

                // cashbon
                $pinjaman = Loan::where('karyawan_id', $karyawanPribadi->id)
                    ->where('is_lunas', 0)
                    ->where('tahun_pinjam', '<=', $tahun)
                    ->get();

                $totalPinjaman = 0;
                $nominalCicilan = 0;
                $totalDibayar = 0;

                foreach ($pinjaman as $pnj) {
                    $totalPinjaman += $pnj->jumlah_pinjam;
                    $nominalCicilan += $pnj->jumlah_cicilan;
                    $totalDibayar += $pnj->total_dibayar;
                }

                $sisaPinjaman = $totalPinjaman - $totalDibayar;

                $karyawanPotongan = Potongan::with(['karyawan', 'jenis_potongan'])
                    ->where('karyawan_id', $karyawanPribadi->id)
                    ->where('tahun_mulai', '<=', $tahun)
                    ->where('is_active', 1)
                    ->get();

                $jmlPotongan = 0;
                foreach ($karyawanPotongan as $ptg) {
                    if ($ptg->tahun_mulai == $tahun && $ptg->bulan_mulai <= $bulan) {
                        $jmlPotongan += $ptg->jml_potongan;
                    } else {
                        if ($ptg->tahun_mulai < $tahun) $jmlPotongan += $ptg->jml_potongan;
                    }
                }

                //total potongan
                $totalPotongan = 0;
                $totalPotongan += $nominalCicilan;
                $totalPotongan += $jmlPotongan;
                $totalPotongan += $jumlahPotonganTerlambat;
                $totalPotongan += $potonganmangkir;
                $totalPotongan += $jmlProRataAbsenPulang;

                // pendapatan gaji
                $totalGaji = $totalPendapatan - $totalPotongan;

                $result[$nik] = [
                    'namabulan'                 => $namabulan,
                    'bulan'                     => $bulan,
                    'tahun'                     => $tahun,
                    'karyawanPribadi'           => $karyawanPribadi,
                    'karyawanGaji'              => $karyawanGaji,
                    'jmlMasuk'                  => $jmlMasuk,
                    'gajiPokok'                 => $gajiPokok,
                    'gajiOperasional'           => $gajiOperasional,
                    'dataTerlambat'             => $dataTerlambat,
                    'jmlTidakAbsenPulang'       => $jmlTidakAbsenPulang,
                    'jumlahPotonganTerlambat'   => $jumlahPotonganTerlambat,
                    'totalGajiLembur'           => $totalGajiLembur,
                    'totalUMLK'                 => $totalumlk,
                    'karyawanBonusTetap'        => $karyawanBonusTetap,
                    'karyawanBonusOther'        => $karyawanBonusOther,
                    'karyawanBiodata'           => $karyawanBiodata,
                    'totalPendapatan'           => $totalPendapatan,
                    'totalPinjaman'             => $totalPinjaman,
                    'nominalCicilan'            => $nominalCicilan,
                    'karyawanPotongan'          => $karyawanPotongan,
                    'totalPotongan'             => $totalPotongan,
                    'sisaPinjaman'              => $sisaPinjaman,
                    'jamLemburHariBiasa'        => $selisihjambiasa,
                    'jamLemburHariLibur'        => $selisihjamminggu,
                    'mangkir'                   => $mangkir,
                    'potonganmangkir'           => $potonganmangkir,
                    'totalGaji'                 => $totalGaji,
                    'jumlahCuti'                => $jumlahcuti,
                    'jumlahSakit'               => $jumlahsakit,
                    'jumlahIzin'                => $jumlahizin,
                    'jmlProRataAbsenPulang'     => $jmlProRataAbsenPulang,
                ];
            }

            $direktur = Karyawan::where('role_id', 4)
                ->where('status', 3)
                ->orderBy('id', 'desc')
                ->first();
            $komisaris = Karyawan::where('role_id', 5)
                ->where('status', 3)
                ->orderBy('id', 'desc')
                ->first();
            $hrdsvp = Karyawan::where('jabatan', 34)
                ->where('status', 3)
                ->orderBy('id', 'desc')
                ->first();
            $adminpayroll = Karyawan::where('jabatan', 36)
                ->where('status', 3)
                ->orderBy('id', 'desc')
                ->first();

            return view('payroll.report.all-employee-payroll-report', compact('result', 'bulan', 'tahun', 'direktur', 'komisaris', 'hrdsvp', 'adminpayroll', 'statusPayroll', 'hrPayrollEmployee', 'pengajuanGajiData'));
        } else {
            $result = [];
            $bulan = $request->bulan;
            $tahun = $request->tahun;
            $statusPayroll = PengajuanGaji::where('bulan', $bulan)
                ->where('tahun', $tahun)
                ->where('status_karyawan', 1)
                ->first();
            foreach ($allNiksProject as $nik) {
                $bulan = $request->bulan;
                $tahun = $request->tahun;
                $status = $request->status;
                $karyawanPribadi = Karyawan::with(['jabatan_kerja', 'department', 'contract', 'oldContract'])->where('nik', $nik)->first();
                $karyawanGaji = $karyawanPribadi->contract;
                $karyawanBiodata = KaryawanBiodata::where('karyawan_id', $karyawanPribadi->id)->first();
                $namabulan = ["", "Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember"];

                //Pengambilan data bulan sebelumnya dan tahun selanjutnya
                $bulan_sebelumnya = $bulan - 1;
                $tahun_sebelumnya = $tahun;
                if ($bulan_sebelumnya == 0) {
                    $bulan_sebelumnya = 12;
                    $tahun_sebelumnya = $tahun - 1;
                }

                $startDate = Carbon::create($tahun_sebelumnya, $bulan_sebelumnya, 29);
                $endDate = Carbon::create($tahun, $bulan, 28);
                $today = Carbon::now();
                //Penghitungan jumlah cuti
                $cutibulanpertama = Pengajuanizin::where('nik', $nik)
                    ->whereMonth('tgl_mulai_izin', $bulan)
                    ->whereYear('tgl_mulai_izin', $tahun)
                    ->where('status_approved', 5)
                    ->where('status', 'c')
                    ->whereDate('tgl_mulai_izin', '<=', $tahun . '-' . $bulan . '-28')
                    ->sum('bulan_pertama');

                $cutibulanselanjutnya = Pengajuanizin::where('nik', $nik)
                    ->whereDate('tgl_akhir_izin', '>', $startDate)
                    ->whereDate('tgl_akhir_izin', '<=', $endDate)
                    ->where('status_approved', 5)
                    ->where('status', 'c')
                    ->sum('bulan_kedua');

                $jumlahcuti = $cutibulanpertama + $cutibulanselanjutnya; //penghitungan total cuti

                // Penghitungan jumlah sakit
                $sakitbulanpertama = Pengajuanizin::where('nik', $nik)
                    ->whereMonth('tgl_mulai_izin', $bulan)
                    ->whereYear('tgl_mulai_izin', $tahun)
                    ->where('status_approved', 5)
                    ->where('status', 's')
                    ->whereDate('tgl_mulai_izin', '<=', $tahun . '-' . $bulan . '-28')
                    ->sum('bulan_pertama');

                $sakitbulanselanjutnya = Pengajuanizin::where('nik', $nik)
                    ->whereDate('tgl_akhir_izin', '>', $startDate)
                    ->whereDate('tgl_akhir_izin', '<=', $endDate)
                    ->where('status_approved', 5)
                    ->where('status', 's')
                    ->sum('bulan_kedua');

                $jumlahsakit = $sakitbulanpertama + $sakitbulanselanjutnya; //penghitungan total sakit

                //penghitungan jumlah izin
                $izinbulanpertama = Pengajuanizin::where('nik', $nik)
                    ->whereMonth('tgl_mulai_izin', $bulan)
                    ->whereYear('tgl_mulai_izin', $tahun)
                    ->whereNot('jenis_izin_id', '=', 10)
                    ->where('status_approved', 5)
                    ->where('status', 'i')
                    ->whereDate('tgl_mulai_izin', '<=', $tahun . '-' . $bulan . '-28')
                    ->sum('bulan_pertama');

                $izinbulanselanjutnya = Pengajuanizin::where('nik', $nik)
                    ->whereDate('tgl_akhir_izin', '>', $startDate)
                    ->whereDate('tgl_akhir_izin', '<=', $endDate)
                    ->whereNot('jenis_izin_id', '=', 10)
                    ->where('status_approved', 5)
                    ->where('status', 'i')
                    ->sum('bulan_kedua');

                $jumlahizin = $izinbulanpertama + $izinbulanselanjutnya; //penghitungan total izin

                //hitung jumlah masuk
                $jmlMasuk = Presensi::where('nik', $nik)
                    ->whereBetween('tgl_presensi', [$startDate, $endDate])
                    ->whereIn('absen_in_status', [1, 2, 5])
                    ->count();

                // Total Jumlah Masuk
                $getLibur = Holiday::whereDate('holidays_date', '<=', $endDate)
                    ->whereBetween('holidays_date', [$startDate, date('Y-m-d')])
                    ->get();

                $JmlLibur = $getLibur->count();

                //hitung total tanggal merah hari minggu bulanan
                $totalLiburMinggu = 0;
                foreach ($getLibur as $holiday) {
                    $tanggalLibur = Carbon::parse($holiday->holidays_date);
                    if ($tanggalLibur->dayOfWeek == Carbon::SUNDAY) {
                        $totalLiburMinggu++;
                    }
                }

                //total jumlah masuk
                $jmlMasuk += $JmlLibur;
                $jmlMasuk -= $totalLiburMinggu;
                $jmlMasuk += $jumlahcuti;
                $jmlMasuk += $jumlahsakit;
                $jmlMasuk += $jumlahizin;

                //hitung jumlah hari kerja
                $jumlahHariKerja = 0;
                $periode = CarbonPeriod::create($startDate, $today);
                foreach ($periode as $date) {
                    if ($date->dayOfWeek != Carbon::SUNDAY) {
                        $jumlahHariKerja++;
                    }
                }

                if ($jumlahHariKerja > 26) $jumlahHariKerja = 26;

                //hitung mangkir
                $jumlahHariKerja += $JmlLibur;
                $jumlahHariKerja -= $totalLiburMinggu;
                $mangkir = $jumlahHariKerja - $jmlMasuk;
                if ($mangkir < 0) $mangkir = 0;
                //potongan mangkir
                $potonganmangkir = ($karyawanGaji->salary / 26) * $mangkir;

                // hitung gaji pokok dan operasional
                $gajiPokok = $karyawanGaji->salary * 0.75;
                $gajiOperasional = $karyawanGaji->salary * 0.25;

                // hitung tidak absen pulang
                $jmlTidakAbsenPulang = Presensi::where('nik', $nik)
                    ->whereBetween('tgl_presensi', [$startDate, $endDate])
                    ->where('jam_out', null)
                    ->whereIn('absen_in_status', [1, 2, 5])
                    ->count();

                $potonganTidakAbsenPulang = 0;
                //cek tidak absen pulang
                if ($jmlTidakAbsenPulang >= 3 && $jmlTidakAbsenPulang <= 5) {
                    // $jmlMasuk = $jmlMasuk - 1;
                    $potonganTidakAbsenPulang = 1;
                } elseif ($jmlTidakAbsenPulang >= 6 && $jmlTidakAbsenPulang <= 8) {
                    // $jmlMasuk = $jmlMasuk - 2;
                    $potonganTidakAbsenPulang = 2;
                } elseif ($jmlTidakAbsenPulang >= 9 && $jmlTidakAbsenPulang <= 11) {
                    // $jmlMasuk = $jmlMasuk - 3;
                    $potonganTidakAbsenPulang = 3;
                } elseif ($jmlTidakAbsenPulang >= 12 && $jmlTidakAbsenPulang <= 14) {
                    // $jmlMasuk = $jmlMasuk - 4;
                    $potonganTidakAbsenPulang = 4;
                } elseif ($jmlTidakAbsenPulang >= 15 && $jmlTidakAbsenPulang <= 17) {
                    // $jmlMasuk = $jmlMasuk - 5;
                    $potonganTidakAbsenPulang = 5;
                } elseif ($jmlTidakAbsenPulang >= 18 && $jmlTidakAbsenPulang <= 20) {
                    // $jmlMasuk = $jmlMasuk - 6;
                    $potonganTidakAbsenPulang = 6;
                } elseif ($jmlTidakAbsenPulang >= 21 && $jmlTidakAbsenPulang <= 23) {
                    // $jmlMasuk = $jmlMasuk - 7;
                    $potonganTidakAbsenPulang = 7;
                } elseif ($jmlTidakAbsenPulang >= 24 && $jmlTidakAbsenPulang <= 26) {
                    // $jmlMasuk = $jmlMasuk - 8;
                    $potonganTidakAbsenPulang = 8;
                } else {
                    // $jmlMasuk = $jmlMasuk;
                }

                //hitung pro-rata absen pulang
                $jmlProRataAbsenPulang = ($karyawanGaji->salary / 26) * $potonganTidakAbsenPulang;

                // jumlah terlambat
                $dataTerlambat = Presensi::where('nik', $nik)
                    ->whereBetween('tgl_presensi', [$startDate, $endDate])
                    ->whereIn('absen_in_status', [1, 2, 5])
                    ->where('is_late', 1)
                    ->count();

                $jumlahPotonganTerlambat = $dataTerlambat * 50000;

                // hitung gaji lembur
                $dataLembur = Lembur::where('karyawan_id', $karyawanPribadi->id)
                    ->whereBetween('tgl_lembur', [$startDate, $endDate])
                    ->where('status_approved', 5)
                    ->get();

                $selisihjambiasa = 0;
                $selisihjamminggu = 0;
                foreach ($dataLembur as $lembur) {
                    $tgl_lembur = Carbon::parse($lembur->tgl_lembur);
                    $jam_mulai = Carbon::parse($lembur->jam_mulai);
                    $jam_selesai = Carbon::parse($lembur->jam_selesai);

                    // cari hari libur
                    $hariLiburLembur = Holiday::where('holidays_date', $lembur->tgl_lembur)->count();

                    if ($tgl_lembur->isSunday() || $hariLiburLembur > 0) {
                        $selisihjamminggu += $jam_mulai->diffInHours($jam_selesai);
                    } else {
                        $selisihjambiasa += $jam_mulai->diffInHours($jam_selesai);
                    }
                }

                $hitungLemburJambiasa = 0;

                if ($selisihjambiasa == 1) {
                    $hitungLemburJambiasa = 1.5;
                } else if ($selisihjambiasa == 2) {
                    $hitungLemburJambiasa = 3.5;
                } else if ($selisihjambiasa == 3) {
                    $hitungLemburJambiasa = 5.5;
                } else if ($selisihjambiasa == 4) {
                    $hitungLemburJambiasa = 7.5;
                } else if ($selisihjambiasa == 5) {
                    $hitungLemburJambiasa = 9.5;
                } else if ($selisihjambiasa == 6) {
                    $hitungLemburJambiasa = 11.5;
                } else {
                    $hitungLemburJambiasa =  0;
                }

                $gajilemburperjam = $gajiPokok / 173;
                $totalGajiLembur = ($hitungLemburJambiasa * $gajilemburperjam) + ($selisihjamminggu * $gajilemburperjam * 2);

                //UMLK
                $umlk = Presensi::where('nik', $nik)
                    ->whereBetween('tgl_presensi', [$startDate, $endDate])
                    ->sum('meal_num');

                //penghitungan UMLK
                $jabatanKaryawan = $karyawanPribadi->contract->jabatan_id;
                //staff
                if ($karyawanPribadi->role_id == 1) {
                    if ($jabatanKaryawan == 8 || $jabatanKaryawan == 11 || $jabatanKaryawan == 16 || $jabatanKaryawan == 21 || $jabatanKaryawan == 27 || $jabatanKaryawan == 34 || $jabatanKaryawan == 41 || $jabatanKaryawan == 48) {
                        //spv
                        $totalumlk = $umlk * 23300;
                    } else {
                        // staff
                        $totalumlk = $umlk * 20000;
                    }
                }

                // manager
                if ($karyawanPribadi->role_id == 2) {
                    $totalumlk = $umlk * 25000;
                }

                // gm
                if ($karyawanPribadi->role_id == 3) {
                    $totalumlk = $umlk * 28000;
                }

                // direksi
                if ($karyawanPribadi->role_id == 4 || $karyawanPribadi->role_id == 5) {
                    $totalumlk = $umlk * 30000;
                }

                // BONUS
                //tetap
                $karyawanBonusTetap = Bonus::with(['karyawan', 'jenis_bonus'])
                    ->where('karyawan_id', $karyawanPribadi->id)
                    ->whereRelation('jenis_bonus', 'tipe_bonus', '=', 1)
                    ->where('mulai_bonus', '<=', "$tahun-$bulan->01")
                    ->get();

                $karyawanBonusOther = Bonus::with(['karyawan', 'jenis_bonus'])
                    ->where('karyawan_id', $karyawanPribadi->id)
                    ->whereRelation('jenis_bonus', 'tipe_bonus', '=', 2)
                    ->where('bulan_bonus', $bulan)
                    ->where('tahun_bonus', $tahun)
                    ->get();


                $totalBonusTetap = Bonus::with(['karyawan', 'jenis_bonus'])
                    ->where('karyawan_id', $karyawanPribadi->id)
                    ->whereRelation('jenis_bonus', 'tipe_bonus', '=', 1)
                    ->where('mulai_bonus', '<=', "$tahun-$bulan->01")
                    ->sum('jumlah_bonus');

                $totalBonusOther = Bonus::with(['karyawan', 'jenis_bonus'])
                    ->where('karyawan_id', $karyawanPribadi->id)
                    ->whereRelation('jenis_bonus', 'tipe_bonus', '=', 2)
                    ->where('bulan_bonus', $bulan)
                    ->where('tahun_bonus', $tahun)
                    ->sum('jumlah_bonus');

                $totalBonus = $totalBonusTetap + $totalBonusOther;

                // hitung total pendapatan
                $totalPendapatan = 0;
                $totalPendapatan += $karyawanGaji->salary;
                $totalPendapatan += $totalumlk;
                $totalPendapatan += $totalGajiLembur;
                $totalPendapatan += $totalBonus;

                // cashbon
                $pinjaman = Loan::where('karyawan_id', $karyawanPribadi->id)
                    ->where('is_lunas', 0)
                    ->where('tahun_pinjam', '<=', $tahun)
                    ->get();

                $totalPinjaman = 0;
                $nominalCicilan = 0;
                $totalDibayar = 0;

                foreach ($pinjaman as $pnj) {
                    $totalPinjaman += $pnj->jumlah_pinjam;
                    $nominalCicilan += $pnj->jumlah_cicilan;
                    $totalDibayar += $pnj->total_dibayar;
                }

                $sisaPinjaman = $totalPinjaman - $totalDibayar;

                $karyawanPotongan = Potongan::with(['karyawan', 'jenis_potongan'])
                    ->where('karyawan_id', $karyawanPribadi->id)
                    ->where('tahun_mulai', '<=', $tahun)
                    ->where('is_active', 1)
                    ->get();

                $jmlPotongan = 0;
                foreach ($karyawanPotongan as $ptg) {
                    if ($ptg->tahun_mulai == $tahun && $ptg->bulan_mulai <= $bulan) {
                        $jmlPotongan += $ptg->jml_potongan;
                    } else {
                        if ($ptg->tahun_mulai < $tahun) $jmlPotongan += $ptg->jml_potongan;
                    }
                }

                //total potongan
                $totalPotongan = 0;
                $totalPotongan += $nominalCicilan;
                $totalPotongan += $jmlPotongan;
                $totalPotongan += $jumlahPotonganTerlambat;
                $totalPotongan += $potonganmangkir;
                $totalPotongan += $jmlProRataAbsenPulang;

                // pendapatan gaji
                $totalGaji = $totalPendapatan - $totalPotongan;

                $result[$nik] = [
                    'namabulan'                 => $namabulan,
                    'bulan'                     => $bulan,
                    'tahun'                     => $tahun,
                    'karyawanPribadi'           => $karyawanPribadi,
                    'karyawanGaji'              => $karyawanGaji,
                    'jmlMasuk'                  => $jmlMasuk,
                    'gajiPokok'                 => $gajiPokok,
                    'gajiOperasional'           => $gajiOperasional,
                    'dataTerlambat'             => $dataTerlambat,
                    'jmlTidakAbsenPulang'       => $jmlTidakAbsenPulang,
                    'jumlahPotonganTerlambat'   => $jumlahPotonganTerlambat,
                    'totalGajiLembur'           => $totalGajiLembur,
                    'totalUMLK'                 => $totalumlk,
                    'karyawanBonusTetap'        => $karyawanBonusTetap,
                    'karyawanBonusOther'        => $karyawanBonusOther,
                    'karyawanBiodata'           => $karyawanBiodata,
                    'totalPendapatan'           => $totalPendapatan,
                    'totalPinjaman'             => $totalPinjaman,
                    'nominalCicilan'            => $nominalCicilan,
                    'karyawanPotongan'          => $karyawanPotongan,
                    'totalPotongan'             => $totalPotongan,
                    'sisaPinjaman'              => $sisaPinjaman,
                    'jamLemburHariBiasa'        => $selisihjambiasa,
                    'jamLemburHariLibur'        => $selisihjamminggu,
                    'mangkir'                   => $mangkir,
                    'potonganmangkir'           => $potonganmangkir,
                    'totalGaji'                 => $totalGaji,
                    'jumlahCuti'                => $jumlahcuti,
                    'jumlahSakit'               => $jumlahsakit,
                    'jumlahIzin'                => $jumlahizin,
                    'jmlProRataAbsenPulang'     => $jmlProRataAbsenPulang,
                ];
            }

            $direktur = Karyawan::where('role_id', 4)
                ->where('status', 3)
                ->orderBy('id', 'desc')
                ->first();
            $komisaris = Karyawan::where('role_id', 5)
                ->where('status', 3)
                ->orderBy('id', 'desc')
                ->first();
            $hrdsvp = Karyawan::where('jabatan', 34)
                ->where('status', 3)
                ->orderBy('id', 'desc')
                ->first();
            $adminpayroll = Karyawan::where('jabatan', 36)
                ->where('status', 3)
                ->orderBy('id', 'desc')
                ->first();

            return view('payroll.report.project-employee-payroll-report', compact('result', 'bulan', 'tahun', 'direktur', 'komisaris', 'hrdsvp', 'adminpayroll', 'statusPayroll', 'hrPayrollEmployee', 'pengajuanGajiData'));
        }
    }


    public function dailyEmployeePayrollReport(Request $request)
    {
        $direktur = Karyawan::where('role_id', 4)
            ->where('status', 3)
            ->orderBy('id', 'desc')
            ->first();
        $komisaris = Karyawan::where('role_id', 5)
            ->where('status', 3)
            ->orderBy('id', 'desc')
            ->first();
        $hrdsvp = Karyawan::where('jabatan', 34)
            ->where('status', 3)
            ->orderBy('id', 'desc')
            ->first();
        $adminpayroll = Karyawan::where('jabatan', 36)
            ->where('status', 3)
            ->orderBy('id', 'desc')
            ->first();

        $dari = $request->dari;
        $sampai = $request->sampai;

        $employeeDailyList = Karyawan::with(['jabatan_kerja', 'department', 'cabang', 'contract', 'oldContract'])
            ->where('is_daily', 1)
            ->get();

        $hrPayrollEmployee = KaryawanContract::with(['karyawan', 'jabatan', 'department', 'cabang', 'atasanApprove', 'jabatanAtasanApprove'])
            ->where('jabatan_id', 36)
            ->where('department_id', 9)
            ->orderBy('id', 'DESC')
            ->first();

        $allNiksHarian = [];

        foreach ($employeeDailyList as $item) {
            $allNiksHarian[] = $item->nik;
        }
        $result = [];
        foreach ($allNiksHarian as $nik) {
            $karyawanPribadi = Karyawan::where('nik', $nik)
                ->first();

            $karyawanGaji = KaryawanContract::with(['karyawan'])
                ->where('karyawan_id', $karyawanPribadi->id)
                ->first();

            $karyawanBiodata = KaryawanBiodata::with(['karyawan'])
                ->where('karyawan_id', $karyawanPribadi->id)
                ->first();

            //hadir
            $daftarhadir = Presensi::where('nik', $nik)
                ->whereDate('tgl_presensi', '>=', $dari)
                ->whereDate('tgl_presensi', '<=', $sampai)
                ->count();

            //terlambat
            $dataterlambat = Presensi::where('nik', $nik)
                ->whereDate('tgl_presensi', '>=', $dari)
                ->whereDate('tgl_presensi', '<=', $sampai)
                ->where('is_late', 1)
                ->get()
                ->count();

            $jmlTidakAbsenPulang = Presensi::where('nik', $nik)
                ->whereBetween('tgl_presensi', [$dari, $sampai])
                ->where('jam_out', null)
                ->whereIn('absen_in_status', [1, 2, 5])
                ->count();

            $potonganTidakAbsenPulang = 0;

            //cek tidak absen pulang
            if ($jmlTidakAbsenPulang >= 3 && $jmlTidakAbsenPulang <= 5) {
                $daftarhadir = $daftarhadir - 1;
                $potonganTidakAbsenPulang = 1;
            } elseif ($jmlTidakAbsenPulang >= 6 && $jmlTidakAbsenPulang <= 8) {
                $daftarhadir = $daftarhadir - 2;
                $potonganTidakAbsenPulang = 2;
            } elseif ($jmlTidakAbsenPulang >= 9 && $jmlTidakAbsenPulang <= 11) {
                $daftarhadir = $daftarhadir - 3;
                $potonganTidakAbsenPulang = 3;
            } elseif ($jmlTidakAbsenPulang >= 12 && $jmlTidakAbsenPulang <= 14) {
                $daftarhadir = $daftarhadir - 4;
                $potonganTidakAbsenPulang = 4;
            } elseif ($jmlTidakAbsenPulang >= 15 && $jmlTidakAbsenPulang <= 17) {
                $daftarhadir = $daftarhadir - 5;
                $potonganTidakAbsenPulang = 5;
            } elseif ($jmlTidakAbsenPulang >= 18 && $jmlTidakAbsenPulang <= 20) {
                $daftarhadir = $daftarhadir - 6;
                $potonganTidakAbsenPulang = 6;
            } elseif ($jmlTidakAbsenPulang >= 21 && $jmlTidakAbsenPulang <= 23) {
                $daftarhadir = $daftarhadir - 7;
                $potonganTidakAbsenPulang = 7;
            } elseif ($jmlTidakAbsenPulang >= 24 && $jmlTidakAbsenPulang <= 26) {
                $daftarhadir = $daftarhadir - 8;
                $potonganTidakAbsenPulang = 8;
            } else {
                $daftarhadir = $daftarhadir;
            }

            //hitung pro-rata absen pulang
            $jmlProRataAbsenPulang = $karyawanGaji->salary * $potonganTidakAbsenPulang;

            //potongan
            $potonganterlambat = $dataterlambat * 10000;

            $dataLembur = Lembur::where('karyawan_id', $karyawanPribadi->id)
                ->whereBetween('tgl_lembur', [$dari, $sampai])
                ->where('status_approved', 5)
                ->get();
            $selisihjambiasa = 0;
            $selisihjamminggu = 0;

            foreach ($dataLembur as $lembur) {
                $tgl_lembur = Carbon::parse($lembur->tgl_lembur);
                $jam_mulai = Carbon::parse($lembur->jam_mulai);
                $jam_selesai = Carbon::parse($lembur->jam_selesai);
                // cari hari libur
                $hariLiburLembur = Holiday::where('holidays_date', $lembur->tgl_lembur)->count();
                if ($tgl_lembur->isSunday() || $hariLiburLembur > 0) {
                    $selisihjamminggu += $jam_mulai->diffInHours($jam_selesai);
                } else {
                    $selisihjambiasa += $jam_mulai->diffInHours($jam_selesai);
                }
            }

            $hitungLemburJambiasa = 0;

            if ($selisihjambiasa == 1) {
                $hitungLemburJambiasa = 1.5;
            } else if ($selisihjambiasa == 2) {
                $hitungLemburJambiasa = 3.5;
            } else if ($selisihjambiasa == 3) {
                $hitungLemburJambiasa = 5.5;
            } else if ($selisihjambiasa >= 4) {
                $hitungLemburJambiasa = 7.5;
            } else {
                $hitungLemburJambiasa =  0;
            }

            $gajilemburperjam = ($karyawanGaji->salary * 26) / 173;
            if ($selisihjambiasa >= 4) {
                $totalGajiLembur = ($karyawanGaji->salary) + ($selisihjamminggu * $gajilemburperjam * 2);
            } else {
                $totalGajiLembur = ($hitungLemburJambiasa * $gajilemburperjam) + ($selisihjamminggu * $gajilemburperjam * 2);
            }
            $totalGaji = ($karyawanGaji->salary * $daftarhadir) + $totalGajiLembur;

            $result[$nik] = [
                'karyawanPribadi'           => $karyawanPribadi,
                'daftarhadir'               => $daftarhadir,
                'dataTerlambat'             => $dataterlambat,
                'jmlTidakAbsenPulang'       => $jmlTidakAbsenPulang,
                'karyawanGaji'              => $karyawanGaji,
                'karyawanBiodata'           => $karyawanBiodata,
                'potonganterlambat'         => $potonganterlambat,
                'jamLemburHariBiasa'        => $selisihjambiasa,
                'jamLemburHariLibur'        => $selisihjamminggu,
                'totalGajiLembur'           => $totalGajiLembur,
                'totalGaji'                 => $totalGaji,
                'jmlProRataAbsenPulang'     => $jmlProRataAbsenPulang,
            ];
        }

        $statusPayroll = PengajuanGaji::where('tgl_mulai', $dari)
            ->where('status_karyawan', 2)
            ->first();

        return view('payroll.report.daily-employee-payroll-report', compact('result', 'direktur', 'komisaris', 'hrdsvp', 'adminpayroll', 'dari', 'sampai', 'statusPayroll', 'hrPayrollEmployee'));
    }


    /* ===========================================*/

    /*===========================================
                    BONUS
    ===========================================*/

    //==== BONUS JENIS ======
    public function indexBonus()
    {
        $namabulan = ["", "Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember"];
        $karyawan = Karyawan::all();
        $bonus = Bonus::with(['karyawan', 'jenis_bonus'])->paginate(10);
        $bonusJenis = BonusJenis::paginate(10);

        return view('payroll.bonus.index', compact('karyawan', 'bonus', 'bonusJenis', 'namabulan'));
    }

    public function addEmployeeBonusJenis(Request $request)
    {
        $data = [
            'nama_bonus' => $request->nama_bonus,
            'tipe_bonus' => $request->jenis_bonus,
        ];
        BonusJenis::create($data);
        return to_route('payroll.bonus.index')->with('message', 'Jenis Bonus Berhasil Ditambahkan');
    }

    public function editEmployeeBonusJenis(Request $request, string $id)
    {
        $data = [
            'nama_bonus' => $request->nama_bonus,
            'tipe_bonus' => $request->jenis_bonus,
        ];
        $bonus = BonusJenis::find($request->id);
        $bonus->update($data);
        return to_route('payroll.bonus.index')->with('message', 'Jenis Bonus Berhasil Diubah');
    }

    public function deleteEmployeeBonusJenis(string $id)
    {
        $data = BonusJenis::find($id);
        $data->delete();
        return to_route('payroll.bonus.index')->with('message', 'Jenis Bonus Berhasil Dihapus');
    }

    //==== KARYAWAN BONUS ======
    public function addEmployeeBonus(Request $request)
    {
        $data = [
            'karyawan_id' => $request->karyawann,
            'jenis_bonus_id' => $request->jenis_bonus_id,
            'jumlah_bonus' => $request->jumlah_bonus,
            'bulan_bonus' => $request->bulan_bonus,
            'tahun_bonus' => $request->tahun_bonus,
        ];

        $data['mulai_bonus'] = "$request->tahun_bonus-$request->bulan_bonus-01";

        Bonus::create($data);
        return to_route('payroll.bonus.index')->with('message', 'Bonus Berhasil Ditambahkan');
    }

    public function editEmployeeBonus(Request $request, string $id)
    {
        $data = [
            'jenis_bonus_id' => $request->jenis_bonus_id,
            'jumlah_bonus' => $request->jumlah_bonus,
            'bulan_bonus' => $request->bulan_bonus,
            'tahun_bonus' => $request->tahun_bonus,
        ];
        $bonus = Bonus::find($request->id);
        $bonus->update($data);
        return to_route('payroll.bonus.index')->with('message', 'Bonus Berhasil Diubah');
    }

    public function deleteEmployeeBonus(string $id)
    {
        $data = Bonus::find($id);
        $data->delete();
        return to_route('payroll.bonus.index')->with('message', 'Bonus Berhasil Dihapus');
    }

    public function searchEmployeeBonus(Request $request)
    {
        $namabulan = ["", "Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember"];
        $bonusJenis = BonusJenis::paginate(10);
        $idkaryawan = $request->nama_karyawan;
        $bonus = Bonus::with(['karyawan'])->where('karyawan_id', $idkaryawan)->paginate(1000);
        $karyawan   = Karyawan::all();
        return view('payroll.bonus.index', compact('karyawan', 'bonus', 'bonusJenis', 'namabulan'));
    }


    /*===========================================
                    DEDUCTIONS
    ===========================================*/

    // TYPE ==================================
    public function deductions()
    {
        $data = [
            'title'                 => 'Admin - Potongan | PT. Maha Akbar Sejahtera',
            'deductionsType'        => PotonganJenis::paginate(5),
            'employees'             => Karyawan::with(['jabatan_kerja', 'department', 'cabang', 'contract', 'oldContract'])
                ->where('status', 3)
                ->get(),
            'deductionsTypeList'    => PotonganJenis::all(),
            'deductions'            => Potongan::with(['karyawan', 'jenis_potongan'])
                ->where('is_active', 1)
                ->orderBy('karyawan_id', 'DESC')
                ->get()
        ];

        return view('payroll.deductions.deductions', $data);
    }

    public function deductionsSearch(Request $request)
    {
        $keyword = $request->keyword;
        $tipe = $request->tipe;

        if (empty($tipe)) {
            $deductions = PotonganJenis::where('nama_potongan', 'LIKE', '%' . $request->keyword . '%')
                ->paginate(5);
        } else {
            $deductions = PotonganJenis::where('nama_potongan', 'LIKE', '%' . $request->keyword . '%')
                ->where('tipe', $tipe)
                ->paginate(5);
        }


        $data = [
            'title'             => 'Admin - Potongan | PT. Maha Akbar Sejahtera',
            'deductionsType'    => $deductions,
            'employees'             => Karyawan::with(['jabatan_kerja', 'department', 'cabang', 'contract', 'oldContract'])
                ->where('status', 3)
                ->get(),
            'deductionsTypeList'    => PotonganJenis::all(),
            'deductions'            => Potongan::with(['karyawan', 'jenis_potongan'])
                ->where('is_active', 1)
                ->orderBy('karyawan_id', 'DESC')
                ->get()
        ];

        return view('payroll.deductions.deductions', $data);
    }

    // get data
    public function getDeductionsTypeById(Request $request)
    {
        try {
            //get deductions type
            $deductionsType = PotonganJenis::where('id', $request->typeId)->first();

            return [
                'error'             => false,
                'deductionsType'    => $deductionsType
            ];
        } catch (Exception $e) {
            return [
                'error'             => true,
                'message'           => $e->getMessage()
            ];
        }
    }

    // create data
    public function deductionsTypeCreate(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'nama_potongan'     => 'required|max:10',
                'tipe'              => 'required'
            ]);

            PotonganJenis::create($validatedData);
            return back()->with('success', 'Jenis potongan berhasil ditambah!');
        } catch (Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    // update data
    public function deductionsTypeUpdate(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'nama_potongan'     => 'required|max:10',
                'tipe'              => 'required'
            ]);

            PotonganJenis::where('id', $request->type_id)->update($validatedData);
            return back()->with('success', 'Jenis potongan berhasil diubah!');
        } catch (Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    //delete data
    public function deductionsTypeDelete(Request $request)
    {
        try {
            PotonganJenis::where('id', $request->type_id)->delete();
            return back()->with('success', 'Jenis potongan berhasil dihapus!');
        } catch (Exception $e) {
            return back()->with('error', 'Jenis potongan gagal dihapus!');
        }
    }


    // EMPLOYE DEDUCTIONS ==========================
    // get data
    public function getDeductionsByIdJSON(Request $request)
    {
        try {
            //get deductions type
            $deductions = Potongan::with(['karyawan', 'jenis_potongan'])->where('id', $request->potonganId)->first();

            $deductionsType = PotonganJenis::all();

            $deductionsTypeOption = '<option value="">-- Pilih Jenis --</option>';
            foreach ($deductionsType as $dt) {
                if ($deductions->jenis_potongan_id == $dt->id) {
                    $deductionsTypeOption .= "<option value='$dt->id' selected>$dt->nama_potongan</option>";
                } else {
                    $deductionsTypeOption .= "<option value='$dt->id'>$dt->nama_potongan</option>";
                }
            }

            $month = '<option value="">-- Pilih Bulan --</option>';
            for ($i = 1; $i <= 12; $i++) {
                if ($deductions->bulan_mulai == $i) {
                    $month .= "<option value='$i' selected>" . bulanIndo("0$i") . '</option>';
                } else {
                    $month .= "<option value='$i'>" . bulanIndo("0$i") . '</option>';
                }
            }

            $yearOption = '<option value="">-- Pilih Tahun --';
            for ($i = 0; $i <= 1; $i++) {
                $year = date('Y', strtotime("+$i" . 'year', strtotime(date('Y'))));
                if ($deductions->tahun_mulai == $year) {
                    $yearOption .= "<option value='$year' selected>$year</option>";
                } else {
                    $yearOption .= "<option value='$year'>$year</option>";
                }
            }

            return [
                'error'                 => false,
                'deductionsTypeOption'  => $deductionsTypeOption,
                'month'                 => $month,
                'year'                  => $yearOption,
                'deductions'            => $deductions
            ];
        } catch (Exception $e) {
            return [
                'error'             => true,
                'message'           => $e->getMessage()
            ];
        }
    }

    // detail json
    public function detailEmployeeDeductionJSON(Request $request)
    {
        try {
            $deductions = Potongan::with(['karyawan', 'jenis_potongan'])
                ->where('id', $request->potonganId)
                ->first();

            $data = [
                'employeeName'          => $deductions->karyawan->nama_lengkap,
                'deductionsType'        => $deductions->jenis_potongan->nama_potongan,
                'deductionsTypeCtg'     => ($deductions->jenis_potongan->tipe == 1) ? 'Tetap' : 'Lain-Lain',
                'deductionsAmount'      => 'Rp. ' . number_format($deductions->jml_potongan, 0, ',', '.'),
                'deductionsTotal'       => (!empty($deductions->total_potongan)) ? 'Rp. ' . number_format($deductions->total_potongan, 0, ',', '.') : '-',
                'deductionsLength'      => (!empty($deductions->lama_potongan)) ? $deductions->lama_potongan . ' Bulan' : '-',
                'deductionsRemaining'   => (!empty($deductions->sisa_bulan_potongan)) ? $deductions->sisa_bulan_potongan . ' Bulan' : '-',
                'deductionsStart'       => bulanIndo("0$deductions->bulan_mulai") . ' ' . $deductions->tahun_mulai,
            ];

            return [
                'error'         => false,
                'deductions'    => $data
            ];
        } catch (Exception $e) {
            return [
                'error'     => true,
                'message'   => $e->getMessage()
            ];
        }
    }

    // create
    public function createEmployeeDeductions(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'karyawan_id'           => 'required',
                'jenis_potongan_id'     => 'required',
                'total_potongan'        => 'required|numeric',
                'lama_potongan'         => 'required|numeric',
                'bulan_mulai'           => 'required|numeric',
                'tahun_mulai'           => 'required|numeric'
            ]);

            $validatedData['mulai_potongan'] = "$request->tahun_mulai-$request->bulan_mulai-01";
            $validatedData['sisa_bulan_potongan'] = $request->lama_potongan;
            $validatedData['jml_potongan'] = ($request->lama_potongan > 0) ? $request->total_potongan / $request->lama_potongan : $request->total_potongan;

            $employee = Karyawan::find($request->karyawan_id);

            Potongan::create($validatedData);
            return back()->with('success', "Potongan $employee->nama_lengkap berhasil ditambah!");
        } catch (Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    // update
    public function updateEmployeeDeductions(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'jenis_potongan_id'     => 'required',
                'total_potongan'        => 'required|numeric',
                'lama_potongan'         => 'required|numeric',
                'bulan_mulai'           => 'required|numeric',
                'tahun_mulai'           => 'required|numeric'
            ]);

            Potongan::where('id', $request->potongan_id)->update($validatedData);
            return back()->with('success', "Potongan berhasil diubah!");
        } catch (Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    // delete
    public function deleteEmployeeDeductions(Request $request)
    {
        try {
            Potongan::where('id', $request->potongan_id)->delete();
            return back()->with('success', 'Potongan berhasil dihapus!');
        } catch (Exception $e) {
            return back()->with('error', 'Potongan gagal dihapus!');
        }
    }

    /* ===========================================*/

    /*===========================================
                    LOAN
    ===========================================*/

    //Loan atau Pinjaman
    public function indexLoan()
    {
        $karyawan = Karyawan::all();
        $loan = Loan::with('karyawan')->paginate(10);
        $karyawan   = Karyawan::all();
        return view('payroll.loan.index', compact('karyawan', 'loan'));
    }

    public function addEmployeeLoan(Request $request)
    {
        $bulan = $request->bulan;
        $convertbulan = date('m', strtotime($bulan));
        $data = [
            'karyawan_id' => $request->karyawan,
            'jumlah_pinjam' => $request->jumlah_pinjaman,
            'jumlah_cicilan' => $request->jumlah_cicilan,
            'lama_cicilan' => $request->bulan_cicilan,
            'bulan_pinjam' => $convertbulan,
            'tahun_pinjam' => $request->tahun,
        ];

        $data['mulai_pinjam'] = "$request->tahun-$convertbulan-01";

        Loan::create($data);
        return to_route('payroll.loan.index')->with('message', 'Pinjaman Berhasil Ditambahkan');
    }

    public function editEmployeeLoan(Request $request, string $id)
    {
        try {
            $data = [
                'jumlah_pinjam' => $request->jumlah_pinjaman,
                'jumlah_cicilan' => $request->jumlah_cicilan,
                'lama_cicilan' => $request->bulan_cicilan,
            ];
            $loan = Loan::find($request->id);
            $loan->update($data);
            return to_route('payroll.loan.index')->with('message', 'Pinjaman Berhasil Diubah');
        } catch (Exception $e) {
            return back()->with('message', $e->getMessage());
        }
    }

    public function detailEmployeeloan(string $id)
    {
        $loan = Loan::find($id);
        return view('payroll.loan.detail', compact('loan'));
    }

    public function deleteEmployeeLoan(string $id)
    {
        $data = Loan::find($id);
        $data->delete();
        return to_route('payroll.loan.index')->with('message', 'Pinjaman Berhasil Dihapus');
    }

    public function searchEmployeeLoan(Request $request)
    {
        $idkaryawan = $request->nama_karyawan;
        $loan = Loan::with('karyawan')->where('karyawan_id', $idkaryawan)->paginate(1000);
        $karyawan   = Karyawan::all();
        return view('payroll.loan.index', compact('karyawan', 'loan'));
    }


    /* ===========================================*/
    /* ============== Pengajuan Gaji =============*/
    /* ===========================================*/

    public function createSalarySubmission(Request $request)
    {
        try {

            // status karyawan
            $statusLabel = '';
            $status = $request->status;
            if ($status == 0) $statusLabel = 'Tetap/Percobaan/PKWT';
            if ($status == 1) $statusLabel = 'Proyek';
            if ($status == 2) $statusLabel = 'Harian';

            // get HR Payroll data
            $hrPayrollEmployee = KaryawanContract::with(['karyawan', 'jabatan', 'department', 'cabang', 'atasanApprove', 'jabatanAtasanApprove'])
                ->where('jabatan_id', 36)
                ->where('department_id', 9)
                ->orderBy('id', 'DESC')
                ->first();

            // get letter number
            $noSurat = null;
            $kodeSurat = 'SPG';

            $noSurat = $this->suratController->getNoSuratBaruKaryawan($kodeSurat, $hrPayrollEmployee->karyawan_id);

            //create surat kontrak
            $dataSurat = [
                'karyawan_pembuat_id'       => $hrPayrollEmployee->id,
                'kategori_kode'             => $kodeSurat,
                'no_surat'                  => $noSurat,
                'perihal'                   => "Pengajuan Gaji Karyawan $statusLabel"
            ];

            $this->suratController->storeSurat($dataSurat);

            $data = [];

            if ($request->status == 2) {
                $data = [
                    'tgl_mulai' => $request->dari,
                    'tgl_selesai' => $request->sampai,
                ];
            } else {
                $data = [
                    'bulan' => $request->bulan,
                    'tahun' => $request->tahun,
                ];
            }

            $data['no_surat'] = $noSurat;
            $data['status_karyawan'] = $request->status;

            PengajuanGaji::create($data);
            return to_route('payroll.')->with('success', "Payroll Karyawan $statusLabel Berhasil Diajukan !");
        } catch (exception $e) {
            return to_route('payroll.')->with('error', $e->getMessage());
        }
    }

    public function salaryAjax(Request $request)
    {
        try {
            //Get Data Gaji
            $dataGaji = PengajuanGaji::where('id', $request->gajiId)
                ->first();
            //Get Gaji Tracking
            $gajiTracking = TrackingGaji::with(['pengajuangaji'])
                ->where('pengajuan_gaji_id', $request->gajiId)
                ->get();
            return [
                'error'         => false,
                'dataGaji'      => $dataGaji,
                'gajiTracking'  => $gajiTracking,
            ];
        } catch (Exception $e) {
            return [
                'error'     => true,
                'message'   => $e->getMessage(),
            ];
        }
    }
}
