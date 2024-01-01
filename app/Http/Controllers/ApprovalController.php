<?php

namespace App\Http\Controllers;

use App\Models\ArsipPayroll;
use App\Models\Bonus;
use App\Models\Holiday;
use App\Models\Karyawan;
use App\Models\KaryawanBiodata;
use App\Models\KaryawanContract;
use App\Models\Lembur;
use App\Models\Loan;
use App\Models\PengajuanGaji;
use App\Models\Pengajuanizin;
use App\Models\Potongan;
use App\Models\Presensi;
use App\Models\TrackingGaji;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ApprovalController extends BaseController
{
    // private $roleId;
    // private $jabatanId;
    // private $departmentId;
    // private $user;

    public function __construct()
    {
        // $this->roleId = Auth::guard('karyawan')->user()->role_id;
        // $this->jabatanId = Auth::guard('karyawan')->user()->contract->jabatan_id;
        // $this->departmentId = Auth::guard('karyawan')->user()->contract->department_id;
    }

    public function index()
    {
        $roleId = Auth::guard('karyawan')->user()->role_id;
        $jabatanId = Auth::guard('karyawan')->user()->contract->jabatan_id;
        $departmentId = Auth::guard('karyawan')->user()->contract->department_id;

        // search employeeSalarySubmission Count
        $employeeSalaryCount = 0;

        if ($roleId == 2 && $departmentId == 9 || $jabatanId == 34) $employeeSalaryCount = PengajuanGaji::where('status_approved', 0)->count();
        if ($roleId == 4) $employeeSalaryCount = PengajuanGaji::where('status_approved', 1)->count();
        if ($roleId == 5) $employeeSalaryCount = PengajuanGaji::where('status_approved', 2)->count();

        $data = [
            'title'                 => 'Approval | PT. Maha Akbar Sejahtera',
            'employeeSalaryCount'   => $employeeSalaryCount
        ];

        return view('frontend.approval.index', $data);
    }


    /*===================================
            EMPLOYEE SALARY
    ================================== */
    // list
    public function employeeSalary()
    {
        $roleId = Auth::guard('karyawan')->user()->role_id;
        $jabatanId = Auth::guard('karyawan')->user()->contract->jabatan_id;
        $departmentId = Auth::guard('karyawan')->user()->contract->department_id;
        $kodeStatusApproved = 0;

        if ($roleId == 2 && $departmentId == 9 || $jabatanId == 34) {
            $submisionData = PengajuanGaji::all();
        }

        if ($roleId == 4) {
            $kodeStatusApproved = 1;
            $submisionData = PengajuanGaji::where('status_approved', '>', 0)
                ->whereNot('status_approved', 4)
                ->get();
        }

        if ($roleId == 5) {
            $kodeStatusApproved = 2;
            $submisionData = PengajuanGaji::where('status_approved', '>', 1)
                ->whereNotIn('status_approved', [4, 5])
                ->get();
        }

        $data = [
            'title'                 => 'Approval Gaji Karyawan | PT. Maha Akbar Sejahtera',
            'kodeStatusApproved'    => $kodeStatusApproved,
            'submission'            => $submisionData
        ];

        return view('frontend.approval.employee-salary', $data);
    }

    //detail
    public function detailEmployeeSalary(PengajuanGaji $pengajuanGaji)
    {
        // UPDATE READ APPROVED
        $roleId = Auth::guard('karyawan')->user()->role_id;
        $deptId = Auth::guard('karyawan')->user()->contract->department_id;
        $jabatanId = Auth::guard('karyawan')->user()->contract->jabatan_id;
        $kodeStatusApproved = 0;

        // hrd spv
        if ($roleId == 1 && $jabatanId == 34) {
            // get tracking manager hrd read
            $trackingGaji = TrackingGaji::with(['pengajuanGaji'])
                ->where('pengajuan_gaji_id', $pengajuanGaji->id)
                ->where('status', 1)
                ->get();

            if (count($trackingGaji) < 1) {
                // update tracking read
                $dataTracking = [
                    'pengajuan_gaji_id'         => $pengajuanGaji->id,
                    'keterangan'                => 'Dilihat HRD SPV',
                    'status'                    => 1,
                    'date'                      => date('Y-m-d'),
                ];

                TrackingGaji::create($dataTracking);
            }
        }

        // hrd manager
        if ($roleId == 2) {
            if ($deptId == 9) {
                // get tracking manager hrd read
                $trackingGaji = TrackingGaji::with(['pengajuanGaji'])
                    ->where('pengajuan_gaji_id', $pengajuanGaji->id)
                    ->where('status', 1)
                    ->get();

                if (count($trackingGaji) < 1) {
                    // update tracking read
                    $dataTracking = [
                        'pengajuan_gaji_id'         => $pengajuanGaji->id,
                        'keterangan'                => 'Dilihat Manager HRD',
                        'status'                    => 1,
                        'date'                      => date('Y-m-d'),
                    ];

                    TrackingGaji::create($dataTracking);
                }
            }
        }

        // direktur
        if ($roleId == 4) {
            $kodeStatusApproved = 1;

            // get tracking direktur read
            $trackingGaji = TrackingGaji::with(['pengajuanGaji'])
                ->where('pengajuan_gaji_id', $pengajuanGaji->id)
                ->where('status', 4)
                ->get();

            if (count($trackingGaji) < 1) {
                // update tracking read
                $dataTracking = [
                    'pengajuan_gaji_id'         => $pengajuanGaji->id,
                    'keterangan'                => 'Dilihat Direktur',
                    'status'                    => 4,
                    'date'                      => date('Y-m-d'),
                ];

                TrackingGaji::create($dataTracking);
            }
        }

        //komisaris
        if ($roleId == 5) {
            $kodeStatusApproved = 2;

            // get tracking komisaris read
            $trackingGaji = TrackingGaji::with(['pengajuanGaji'])
                ->where('pengajuan_gaji_id', $pengajuanGaji->id)
                ->where('status', 7)
                ->get();

            if (count($trackingGaji) < 1) {
                // update tracking read
                $dataTracking = [
                    'pengajuan_gaji_id'         => $pengajuanGaji->id,
                    'keterangan'                => 'Dilihat Komisaris',
                    'status'                    => 7,
                    'date'                      => date('Y-m-d'),
                ];

                TrackingGaji::create($dataTracking);
            }
        }

        if ($pengajuanGaji->status_approved == $kodeStatusApproved && $roleId != 1 || $jabatanId == 34) {
            // update read
            PengajuanGaji::where('id', $pengajuanGaji->id)->update(['is_read'   => 1]);
        }

        //==========================================

        $jenisKontrak = ['tetap', 'percobaan', 'pkwt'];
        $statusKaryawan = $pengajuanGaji->status_karyawan;
        $bulan = $pengajuanGaji->bulan;
        $tahun = $pengajuanGaji->tahun;

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

        if ($statusKaryawan == '0') {

            $result = [];
            $result = [];
            foreach ($allNiksTetap as $nik) {
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

            return view('frontend.approval.all-employee-salary-detail', compact('result', 'bulan', 'tahun', 'direktur', 'komisaris', 'hrdsvp', 'adminpayroll', 'pengajuanGaji', 'kodeStatusApproved'));
        } else {
            $result = [];

            foreach ($allNiksProject as $nik) {
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

            return view('frontend.approval.project-employee-salary-detail', compact('result', 'bulan', 'tahun', 'direktur', 'komisaris', 'hrdsvp', 'adminpayroll', 'pengajuanGaji', 'kodeStatusApproved'));
        }
    }

    //approve
    public function approveEmployeeSalary(PengajuanGaji $pengajuanGaji)
    {
        try {
            $roleId = Auth::guard('karyawan')->user()->role_id;
            $deptId = Auth::guard('karyawan')->user()->contract->department_id;
            $jabatanId = Auth::guard('karyawan')->user()->contract->jabatan_id;

            // get hrd manager
            $managerHrdData = Karyawan::with(['jabatan_kerja', 'department', 'cabang', 'contract', 'oldContract'])
                ->where('role_id', 2)
                ->where('status', 3)
                ->whereRelation('contract', 'department_id', 9)
                ->count();
            // get hrd manager
            $hrdSpvData = Karyawan::with(['jabatan_kerja', 'department', 'cabang', 'contract', 'oldContract'])
                ->where('role_id', 1)
                ->where('status', 3)
                ->whereRelation('contract', 'department_id', 9)
                ->whereRelation('contract', 'jabatan_id', 34)
                ->count();
            // get direktur
            $direkturData = Karyawan::with(['jabatan_kerja', 'department', 'cabang', 'contract', 'oldContract'])
                ->where('role_id', 4)
                ->where('status', 3)
                ->count();
            // get komisaris
            $komisarisData = Karyawan::with(['jabatan_kerja', 'department', 'cabang', 'contract', 'oldContract'])
                ->where('role_id', 5)
                ->where('status', 3)
                ->count();

            $newStatusApprove = 0;
            $dataUpdate = [];

            // HRD SPV
            if ($roleId == 1 && $jabatanId == 34) {
                $newStatusApprove = 1;

                // get tracking hrd approve
                $trackingGaji = TrackingGaji::with(['pengajuanGaji'])
                    ->where('pengajuan_gaji_id', $pengajuanGaji->id)
                    ->where('status', 2)
                    ->get();

                if (count($trackingGaji) < 1) {
                    // update tracking read
                    $dataTracking = [
                        'pengajuan_gaji_id'         => $pengajuanGaji->id,
                        'keterangan'                => 'Disetujui HRD SPV',
                        'status'                    => 2,
                        'date'                      => date('Y-m-d'),
                    ];

                    TrackingGaji::create($dataTracking);
                }

                $dataUpdate = [
                    'status_approved'       => $newStatusApprove,
                    'is_read'               => 0
                ];
            }

            // manager
            if ($roleId == 2) {
                if ($deptId == 9) {
                    $newStatusApprove = 1;

                    // get tracking hrd approve
                    $trackingGaji = TrackingGaji::with(['pengajuanGaji'])
                        ->where('pengajuan_gaji_id', $pengajuanGaji->id)
                        ->where('status', 2)
                        ->get();

                    if (count($trackingGaji) < 1) {
                        // update tracking read
                        $dataTracking = [
                            'pengajuan_gaji_id'         => $pengajuanGaji->id,
                            'keterangan'                => 'Disetujui Manager HRD',
                            'status'                    => 2,
                            'date'                      => date('Y-m-d'),
                        ];

                        TrackingGaji::create($dataTracking);
                    }

                    $dataUpdate = [
                        'status_approved'       => $newStatusApprove,
                        'is_read'               => 0
                    ];
                }
            }

            // direktur
            if ($roleId == 4) {
                $newStatusApprove = 2;

                // get tracking direktur approve
                $trackingGaji = TrackingGaji::with(['pengajuanGaji'])
                    ->where('pengajuan_gaji_id', $pengajuanGaji->id)
                    ->where('status', 5)
                    ->get();

                if (count($trackingGaji) < 1) {
                    // update tracking read
                    $dataTracking = [
                        'pengajuan_gaji_id'         => $pengajuanGaji->id,
                        'keterangan'                => 'Disetujui Direktur',
                        'status'                    => 5,
                        'date'                      => date('Y-m-d'),
                    ];

                    TrackingGaji::create($dataTracking);
                }

                $dataUpdate = [
                    'status_approved'       => $newStatusApprove,
                    'is_read'               => 0
                ];
            }

            // komisaris
            if ($roleId == 5) {
                $newStatusApprove = 3;

                // get tracking komisaris approve
                $trackingGaji = TrackingGaji::with(['pengajuanGaji'])
                    ->where('pengajuan_gaji_id', $pengajuanGaji->id)
                    ->where('status', 8)
                    ->get();

                if (count($trackingGaji) < 1) {
                    // update tracking read
                    $dataTracking = [
                        'pengajuan_gaji_id'         => $pengajuanGaji->id,
                        'keterangan'                => 'Disetujui Komisaris',
                        'status'                    => 8,
                        'date'                      => date('Y-m-d'),
                    ];

                    TrackingGaji::create($dataTracking);
                }

                $dataUpdate = [
                    'status_approved'       => $newStatusApprove,
                    'is_read'               => 0
                ];


                // update loan, deductions and bonus
                $this->updatePayrollItemAfterSubmissionApprove($pengajuanGaji);
                // create arsip
                $this->createSalarySubmissionArsip($pengajuanGaji);
            }


            //=============================
            // cek data karyawan ada atau tidak

            if ($newStatusApprove == 0) {
                if ($managerHrdData < 1) {
                    if ($hrdSpvData < 1) $newStatusApprove = 1;
                }
            }

            if ($newStatusApprove == 1) {
                if ($direkturData < 1) $newStatusApprove = 2;
            }

            if ($newStatusApprove == 2) {
                if ($komisarisData < 1) $newStatusApprove = 3;
            }
            //================================

            $dataUpdate['status_approved'] = $newStatusApprove;

            // update
            PengajuanGaji::where('id', $pengajuanGaji->id)->update($dataUpdate);
            return to_route('approval.salary')->with('success', 'Pengajuan Gaji berhasil diterima!');
        } catch (Exception $e) {
            return back()->with('error', 'Pengajuan Gaji gagal diterima, silahkan coba lagi!');
        }
    }

    // reject
    public function rejectEmployeeSalary(PengajuanGaji $pengajuanGaji, Request $request)
    {
        try {
            // validate keterangan ditolak
            $request->validate([
                'keterangan_tolak'  => 'required'
            ]);

            $roleId = Auth::guard('karyawan')->user()->role_id;
            $deptId = Auth::guard('karyawan')->user()->contract->department_id;
            $jabatanId = Auth::guard('karyawan')->user()->contract->jabatan_id;

            $newStatusApprove = 4;
            $dataUpdate = [];

            // hrd spv
            if ($roleId == 1 && $jabatanId == 34) {
                // get tracking reject
                $trackingIzin = TrackingGaji::with(['pengajuanGaji'])
                    ->where('pengajuan_gaji_id', $pengajuanGaji->id)
                    ->where('status', 3)
                    ->get();

                if (count($trackingIzin) < 1) {
                    // update tracking read
                    $dataTracking = [
                        'pengajuan_gaji_id'         => $pengajuanGaji->id,
                        'keterangan'                => 'Ditolak HRD SPV',
                        'keterangan_tolak'          => $request->keterangan_tolak,
                        'status'                    => 3,
                        'date'                      => date('Y-m-d'),
                    ];

                    TrackingGaji::create($dataTracking);
                }
            }

            // hrd manager
            if ($roleId == 2) {
                if ($deptId == 9) {

                    // get tracking manager approve
                    $trackingIzin = TrackingGaji::with(['pengajuanGaji', 'karyawan'])
                        ->where('pengajuan_gaji_id', $pengajuanGaji->id)
                        ->where('status', 3)
                        ->get();

                    if (count($trackingIzin) < 1) {
                        // update tracking read
                        $dataTracking = [
                            'pengajuan_gaji_id'         => $pengajuanGaji->id,
                            'keterangan'                => 'Ditolak Manager HRD',
                            'keterangan_tolak'          => $request->keterangan_tolak,
                            'status'                    => 3,
                            'date'                      => date('Y-m-d'),
                        ];

                        TrackingGaji::create($dataTracking);
                    }
                }
            }

            // direktur
            if ($roleId == 4) {
                $newStatusApprove = 5;

                // get tracking direktur approve
                $trackingIzin = TrackingGaji::with(['pengajuanGaji', 'karyawan'])
                    ->where('pengajuan_gaji_id', $pengajuanGaji->id)
                    ->where('status', 6)
                    ->get();

                if (count($trackingIzin) < 1) {
                    // update tracking read
                    $dataTracking = [
                        'pengajuan_gaji_id'         => $pengajuanGaji->id,
                        'keterangan'                => 'Ditolak Direktur',
                        'keterangan_tolak'          => $request->keterangan_tolak,
                        'status'                    => 6,
                        'date'                      => date('Y-m-d'),
                    ];

                    TrackingGaji::create($dataTracking);
                }
            }

            // komisaris
            if ($roleId == 5) {
                $newStatusApprove = 6;

                // get tracking komisaris approve
                $trackingIzin = TrackingGaji::with(['pengajuanGaji', 'karyawan'])
                    ->where('pengajuan_gaji_id', $pengajuanGaji->id)
                    ->where('status', 9)
                    ->get();

                if (count($trackingIzin) < 1) {
                    // update tracking read
                    $dataTracking = [
                        'pengajuan_gaji_id'         => $pengajuanGaji->id,
                        'keterangan'                => 'Ditolak Komisaris',
                        'keterangan_tolak'          => $request->keterangan_tolak,
                        'status'                    => 9,
                        'date'                      => date('Y-m-d'),
                    ];

                    TrackingGaji::create($dataTracking);
                }
            }

            $dataUpdate = [
                'status_approved'       => $newStatusApprove,
                'is_read'               => 0
            ];

            // update
            PengajuanGaji::where('id', $pengajuanGaji->id)->update($dataUpdate);
            return to_route('approval.salary')->with('success', 'Pengajuan gaji berhasil ditolak!');
        } catch (Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }


    // search
    public function searchEmployeeSalary(Request $request)
    {
        try {
            $request->validate([
                'tahun'     => 'required|numeric'
            ]);

            $roleId = Auth::guard('karyawan')->user()->role_id;
            $jabatanId = Auth::guard('karyawan')->user()->contract->jabatan_id;
            $departmentId = Auth::guard('karyawan')->user()->contract->department_id;

            $bulan = $request->bulan;
            $tahun = $request->tahun;

            if ($roleId == 2 && $departmentId == 9 || $jabatanId == 34) {
                if ($bulan) {
                    $submisionData = PengajuanGaji::where('bulan', $bulan)
                        ->where('tahun', $tahun)
                        ->get();
                } else {
                    $submisionData = PengajuanGaji::where('tahun', $tahun)
                        ->get();
                }
            }

            if ($roleId == 4) {
                if ($bulan) {
                    $submisionData = PengajuanGaji::where('bulan', $bulan)
                        ->where('tahun', $tahun)
                        ->where('status_approved', '>', 0)
                        ->whereNot('status_approved', 4)
                        ->get();
                } else {
                    $submisionData = PengajuanGaji::where('tahun', $tahun)
                        ->where('status_approved', '>', 0)
                        ->whereNot('status_approved', 4)
                        ->get();
                }
            }

            if ($roleId == 5) {
                if ($bulan) {
                    $submisionData = PengajuanGaji::where('bulan', $bulan)
                        ->where('tahun', $tahun)
                        ->where('status_approved', '>', 1)
                        ->whereNotIn('status_approved', [4, 5])
                        ->get();
                } else {
                    $submisionData = PengajuanGaji::where('status_approved', '>', 1)
                        ->whereNotIn('status_approved', [4, 5])
                        ->get();
                }
            }

            $data = [
                'title'         => 'Approval Gaji Karyawan | PT. Maha Akbar Sejahtera',
                'submission'    => $submisionData
            ];

            return view('frontend.approval.employee-salary', $data);
        } catch (Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }


    // update deductions, loan, bonus after commisioner approve salary submission
    public function updatePayrollItemAfterSubmissionApprove($pengajuanGaji)
    {
        // karyawan inti atau proyek
        if ($pengajuanGaji->status_karyawan == 0 || $pengajuanGaji->status_karyawan == 1) {

            // POTONGAN

            // update potongan
            Potongan::join("potongan_jenis as jp", 'jp.id', '=', 'jenis_potongan_id')
                ->join("$this->hrisDbName_.karyawan as kry", 'kry.id', '=', 'karyawan_id')
                ->where('kry.status', 3)
                ->where('kry.is_daily', 0)
                ->where('jp.tipe', 2)
                ->where('mulai_potongan', '<=', "$pengajuanGaji->tahun-$pengajuanGaji->bulan-01")
                ->where('lama_potongan', '>', 0)
                ->where('sisa_bulan_potongan', '>', 0)
                ->where('is_active', 1)
                ->decrement('sisa_bulan_potongan', 1);

            // update is active potongan
            Potongan::join("potongan_jenis as jp", 'jp.id', '=', 'jenis_potongan_id')
                ->join("$this->hrisDbName_.karyawan as kry", 'kry.id', '=', 'karyawan_id')
                ->where('kry.status', 3)
                ->where('kry.is_daily', 0)
                ->where('jp.tipe', 2)
                ->where('mulai_potongan', '<=', "$pengajuanGaji->tahun-$pengajuanGaji->bulan-01")
                ->where('lama_potongan', '>', 0)
                ->where('sisa_bulan_potongan', '=', 0)
                ->where('is_active', 1)
                ->update(['is_active' => 0]);


            // PINJAMAN
            // update pinjaman
            Loan::join("$this->hrisDbName_.karyawan as kry", 'kry.id', '=', 'karyawan_id')
                ->where('kry.status', 3)
                ->where('kry.is_daily', 0)
                ->where('mulai_pinjam', '<=', "$pengajuanGaji->tahun-$pengajuanGaji->bulan-01")
                ->where('lama_cicilan', '>', 0)
                ->where('total_dibayar', '<', DB::raw('jumlah_pinjam'))
                ->where('bulan_dibayar', '<', DB::raw('lama_cicilan'))
                ->where('is_lunas', 0)
                ->update([
                    'total_dibayar' => DB::raw('total_dibayar + jumlah_cicilan'),
                    'bulan_dibayar' => DB::raw('bulan_dibayar + 1'),
                ]);


            // update is lunas pinjaman
            Loan::join("$this->hrisDbName_.karyawan as kry", 'kry.id', '=', 'karyawan_id')
                ->where('kry.status', 3)
                ->where('kry.is_daily', 0)
                ->where('mulai_pinjam', '<=', "$pengajuanGaji->tahun-$pengajuanGaji->bulan-01")
                ->where('lama_cicilan', '>', 0)
                ->where('total_dibayar', '>=', DB::raw('jumlah_pinjam'))
                ->where('bulan_dibayar', '=', DB::raw('lama_cicilan'))
                ->where('is_lunas', 0)
                ->update(['is_lunas' => 1]);


            // BONUS
            Bonus::join('bonus_jenis as jb', 'jb.id', '=', 'jenis_bonus_id')
                ->join("$this->hrisDbName_.karyawan as kry", 'kry.id', '=', 'karyawan_id')
                ->where('kry.status', 3)
                ->where('kry.is_daily', 0)
                ->where('jb.tipe_bonus', 2)
                ->where('mulai_bonus', '<=', "$pengajuanGaji->tahun-$pengajuanGaji->bulan-01")
                ->where('is_active', 1)
                ->update(['is_active' => 0]);
        }
    }

    // create arsip salary submission
    public function createSalarySubmissionArsip($pengajuanGaji)
    {
        $jenisKontrak = ['tetap', 'percobaan', 'pkwt'];
        $statusKaryawan = $pengajuanGaji->status_karyawan;
        $bulan = $pengajuanGaji->bulan;
        $tahun = $pengajuanGaji->tahun;

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

        if ($statusKaryawan == '0') {

            $result = [];
            foreach ($allNiksTetap as $nik) {
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
                $JmlLibur = Holiday::whereBetween('holidays_date', [$startDate, $endDate])->count();
                $jmlMasuk += $JmlLibur;
                $jmlMasuk += $jumlahcuti;
                $jmlMasuk += $jumlahsakit;
                $jmlMasuk += $jumlahizin;


                // Hitung Potongan Absensi
                $mangkir = 26 - $jmlMasuk;
                if ($mangkir < 0) {
                    $mangkir = 0;
                }
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
                    $jmlMasuk = $jmlMasuk - 1;
                    $potonganTidakAbsenPulang = 1;
                } elseif ($jmlTidakAbsenPulang >= 6 && $jmlTidakAbsenPulang <= 8) {
                    $jmlMasuk = $jmlMasuk - 2;
                    $potonganTidakAbsenPulang = 2;
                } elseif ($jmlTidakAbsenPulang >= 9 && $jmlTidakAbsenPulang <= 11) {
                    $jmlMasuk = $jmlMasuk - 3;
                    $potonganTidakAbsenPulang = 3;
                } elseif ($jmlTidakAbsenPulang >= 12 && $jmlTidakAbsenPulang <= 14) {
                    $jmlMasuk = $jmlMasuk - 4;
                    $potonganTidakAbsenPulang = 4;
                } elseif ($jmlTidakAbsenPulang >= 15 && $jmlTidakAbsenPulang <= 17) {
                    $jmlMasuk = $jmlMasuk - 5;
                    $potonganTidakAbsenPulang = 5;
                } elseif ($jmlTidakAbsenPulang >= 18 && $jmlTidakAbsenPulang <= 20) {
                    $jmlMasuk = $jmlMasuk - 6;
                    $potonganTidakAbsenPulang = 6;
                } elseif ($jmlTidakAbsenPulang >= 21 && $jmlTidakAbsenPulang <= 23) {
                    $jmlMasuk = $jmlMasuk - 7;
                    $potonganTidakAbsenPulang = 7;
                } elseif ($jmlTidakAbsenPulang >= 24 && $jmlTidakAbsenPulang <= 26) {
                    $jmlMasuk = $jmlMasuk - 8;
                    $potonganTidakAbsenPulang = 8;
                } else {
                    $jmlMasuk = $jmlMasuk;
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
                    ->orWhere('bulan_mulai', '<=', $bulan)
                    ->orWhere('tahun_mulai', '<=', $tahun)
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
                    'karyawanPribadi'           => $karyawanPribadi->toArray(),
                    'karyawanGaji'              => $karyawanGaji->toArray(),
                    'jmlMasuk'                  => $jmlMasuk,
                    'gajiPokok'                 => $gajiPokok,
                    'gajiOperasional'           => $gajiOperasional,
                    'dataTerlambat'             => $dataTerlambat,
                    'jmlTidakAbsenPulang'       => $jmlTidakAbsenPulang,
                    'jumlahPotonganTerlambat'   => $jumlahPotonganTerlambat,
                    'totalGajiLembur'           => $totalGajiLembur,
                    'totalUMLK'                 => $totalumlk,
                    'karyawanBonusTetap'        => $karyawanBonusTetap->toArray(),
                    'karyawanBonusOther'        => $karyawanBonusOther->toArray(),
                    'karyawanBiodata'           => $karyawanBiodata->toArray(),
                    'totalPendapatan'           => $totalPendapatan,
                    'totalPinjaman'             => $totalPinjaman,
                    'nominalCicilan'            => $nominalCicilan,
                    'karyawanPotongan'          => $karyawanPotongan->toArray(),
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

                $result[$nik]['karyawanPribadi']['contract']['jabatan'] = $karyawanPribadi->contract->jabatan->toArray();
            }
        } else {
            $result = [];

            foreach ($allNiksProject as $nik) {
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
                $JmlLibur = Holiday::whereBetween('holidays_date', [$startDate, $endDate])->count();
                $jmlMasuk += $JmlLibur;
                $jmlMasuk += $jumlahcuti;
                $jmlMasuk += $jumlahsakit;
                $jmlMasuk += $jumlahizin;


                // Hitung Potongan Absensi
                $mangkir = 26 - $jmlMasuk;
                if ($mangkir < 0) {
                    $mangkir = 0;
                }
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
                    $jmlMasuk = $jmlMasuk - 1;
                    $potonganTidakAbsenPulang = 1;
                } elseif ($jmlTidakAbsenPulang >= 6 && $jmlTidakAbsenPulang <= 8) {
                    $jmlMasuk = $jmlMasuk - 2;
                    $potonganTidakAbsenPulang = 2;
                } elseif ($jmlTidakAbsenPulang >= 9 && $jmlTidakAbsenPulang <= 11) {
                    $jmlMasuk = $jmlMasuk - 3;
                    $potonganTidakAbsenPulang = 3;
                } elseif ($jmlTidakAbsenPulang >= 12 && $jmlTidakAbsenPulang <= 14) {
                    $jmlMasuk = $jmlMasuk - 4;
                    $potonganTidakAbsenPulang = 4;
                } elseif ($jmlTidakAbsenPulang >= 15 && $jmlTidakAbsenPulang <= 17) {
                    $jmlMasuk = $jmlMasuk - 5;
                    $potonganTidakAbsenPulang = 5;
                } elseif ($jmlTidakAbsenPulang >= 18 && $jmlTidakAbsenPulang <= 20) {
                    $jmlMasuk = $jmlMasuk - 6;
                    $potonganTidakAbsenPulang = 6;
                } elseif ($jmlTidakAbsenPulang >= 21 && $jmlTidakAbsenPulang <= 23) {
                    $jmlMasuk = $jmlMasuk - 7;
                    $potonganTidakAbsenPulang = 7;
                } elseif ($jmlTidakAbsenPulang >= 24 && $jmlTidakAbsenPulang <= 26) {
                    $jmlMasuk = $jmlMasuk - 8;
                    $potonganTidakAbsenPulang = 8;
                } else {
                    $jmlMasuk = $jmlMasuk;
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
                    'karyawanPribadi'           => $karyawanPribadi->toArray(),
                    'karyawanGaji'              => $karyawanGaji->toArray(),
                    'jmlMasuk'                  => $jmlMasuk,
                    'gajiPokok'                 => $gajiPokok,
                    'gajiOperasional'           => $gajiOperasional,
                    'dataTerlambat'             => $dataTerlambat,
                    'jmlTidakAbsenPulang'       => $jmlTidakAbsenPulang,
                    'jumlahPotonganTerlambat'   => $jumlahPotonganTerlambat,
                    'totalGajiLembur'           => $totalGajiLembur,
                    'totalUMLK'                 => $totalumlk,
                    'karyawanBonusTetap'        => $karyawanBonusTetap->toArray(),
                    'karyawanBonusOther'        => $karyawanBonusOther->toArray(),
                    'karyawanBiodata'           => $karyawanBiodata->toArray(),
                    'totalPendapatan'           => $totalPendapatan,
                    'totalPinjaman'             => $totalPinjaman,
                    'nominalCicilan'            => $nominalCicilan,
                    'karyawanPotongan'          => $karyawanPotongan->toArray(),
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

                $result[$nik]['karyawanPribadi']['contract']['jabatan'] = $karyawanPribadi->contract->jabatan->toArray();
            }
        }

        $encryptData = $this->encryptData_($result);

        // create arsip
        $archieveData = [
            'no_surat'          => $pengajuanGaji->no_surat,
            'tgl_mulai'         => $pengajuanGaji->tgl_mulai,
            'tgl_selesai'       => $pengajuanGaji->tgl_selesai,
            'bulan'             => $pengajuanGaji->bulan,
            'tahun'             => $pengajuanGaji->tahun,
            'status_karyawan'   => $pengajuanGaji->status_karyawan,
            'arsip'             => $encryptData,
            'arsip_content'     => json_encode($result)
        ];

        //get archive this month
        $archieveMonth = ArsipPayroll::where('bulan', $pengajuanGaji->bulan)
            ->where('tahun', $pengajuanGaji->tahun)
            ->where('status_karyawan', $pengajuanGaji->status_karyawan)
            ->count();

        $archieveDaily = ArsipPayroll::where('tgl_mulai', $pengajuanGaji->tgl_mulai)
            ->where('tgl_selesai', $pengajuanGaji->tgl_selesai)
            ->where('status_karyawan', $pengajuanGaji->status_karyawan)
            ->count();

        if ($archieveMonth < 1 || $archieveDaily < 1) ArsipPayroll::create($archieveData);
    }

    //========================================================
}
