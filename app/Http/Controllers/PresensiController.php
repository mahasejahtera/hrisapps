<?php

namespace App\Http\Controllers;

use App\Models\Bonus;
use App\Models\Holiday;
use App\Models\JenisIzin;
use App\Models\Karyawan;
use App\Models\KaryawanBiodata;
use App\Models\KaryawanContract;
use App\Models\Lembur;
use App\Models\LemburFoto;
use App\Models\Pengajuanizin;
use App\Models\Potongan;
use App\Models\Presensi;
use App\Models\Setjamkerja;
use App\Models\TrackingIzin;
use App\Models\TrackingLembur;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\Facades\DataTables;

class PresensiController extends BaseController
{

    public function gethari()
    {
        $hari = date("D");

        switch ($hari) {
            case 'Sun':
                $hari_ini = "Minggu";
                break;

            case 'Mon':
                $hari_ini = "Senin";
                break;

            case 'Tue':
                $hari_ini = "Selasa";
                break;

            case 'Wed':
                $hari_ini = "Rabu";
                break;

            case 'Thu':
                $hari_ini = "Kamis";
                break;

            case 'Fri':
                $hari_ini = "Jumat";
                break;

            case 'Sat':
                $hari_ini = "Sabtu";
                break;

            default:
                $hari_ini = "Tidak di ketahui";
                break;
        }

        return $hari_ini;
    }

    /*=================================================
                    DATATABLES
    =================================================*/
    public function hariLiburDatatables(Request $request)
    {
        if($request->ajax()) {
            $holiday = Holiday::orderBy('holidays_date', 'ASC');

            return DataTables::of($holiday)
                    ->addIndexColumn()
                    ->editColumn('holidays_date', function(Holiday $holiday) {
                        [$year, $month, $day] = explode('-', $holiday->holidays_date);
                        $bulanIndo = bulanIndo($month);
                        return "$day $bulanIndo $year";
                    })
                    ->addColumn('action', function(Holiday $d) {
                        $action = '<div class="btn-group">
                                        <a href="#" class="edit btn btn-info btn-sm"
                                            data-bs-toggle="modal" data-bs-target="#editharilibur"
                                            data-id = "'. $d->id .'"
                                            data-nama="'. $d->holidays_name .'"
                                            data-tanggal="'. $d->holidays_date .'">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="#ffffff" viewBox="0 0 256 256"><path d="M224,120v88a16,16,0,0,1-16,16H48a16,16,0,0,1-16-16V48A16,16,0,0,1,48,32h88a8,8,0,0,1,0,16H48V208H208V120a8,8,0,0,1,16,0Zm5.66-50.34-96,96A8,8,0,0,1,128,168H96a8,8,0,0,1-8-8V128a8,8,0,0,1,2.34-5.66l96-96a8,8,0,0,1,11.32,0l32,32A8,8,0,0,1,229.66,69.66Zm-17-5.66L192,43.31,179.31,56,200,76.69Z"></path></svg>
                                        </a>
                                        <form action="/presensi/hari/libur/delete/'. $d->id .'"
                                            method="POST" style="margin-left:5px">
                                            <input type="hidden" name="_token" value="'.csrf_token().'">
                                            <a class="btn btn-danger btn-sm delete-confirm ms-2">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="#ffffff" viewBox="0 0 256 256"><path d="M224,56a8,8,0,0,1-8,8h-8V208a16,16,0,0,1-16,16H64a16,16,0,0,1-16-16V64H40a8,8,0,0,1,0-16H216A8,8,0,0,1,224,56ZM88,32h80a8,8,0,0,0,0-16H88a8,8,0,0,0,0,16Z"></path></svg>
                                            </a>
                                        </form>
                                    </div>';

                        return $action;
                    })
                    ->rawColumns(['action'])
                    ->make(true);
        }
    }


    public function create()
    {
        $hariini = date("Y-m-d");
        $namahari = $this->gethari();
        $nik = Auth::guard('karyawan')->user()->nik;
        $cek = DB::table('presensi')->where('tgl_presensi', $hariini)->where('nik', $nik)->count();
        $kode_cabang = Auth::guard('karyawan')->user()->kode_cabang;
        $lok_kantor = DB::table('cabang')->where('kode_cabang', $kode_cabang)->first();
        $jamkerja = DB::table('konfigurasi_jamkerja')
            ->join('jam_kerja', 'konfigurasi_jamkerja.kode_jam_kerja', '=', 'jam_kerja.kode_jam_kerja')
            ->where('nik', $nik)->where('hari', $namahari)->first();

        if ($jamkerja == null) {
            return view('presensi.notifjadwal');
        } else {
            return view('presensi.create', compact('cek', 'lok_kantor', 'jamkerja'));
        }
    }

    public function store(Request $request)
    {
        $nik = Auth::guard('karyawan')->user()->nik;
        $kode_cabang = Auth::guard('karyawan')->user()->contract->kode_cabang;
        $cabangStatus = Auth::guard('karyawan')->user()->contract->cabang->is_project;
        $contractStatus = Auth::guard('karyawan')->user()->contract->contract_status;
        $tgl_presensi = date("Y-m-d");
        $jam = date("H:i:s");
        $lok_kantor = DB::table('cabang')->where('kode_cabang', $kode_cabang)->first();
        $lok = explode(",", $lok_kantor->lokasi_cabang);
        $latitudekantor = $lok[0];
        $longitudekantor = $lok[1];
        $lokasi = $request->lokasi;
        $lokasiuser = explode(",", $lokasi);
        $latitudeuser = $lokasiuser[0];
        $longitudeuser = $lokasiuser[1];
        $inZone = ($request->inZone == 'true') ? 1 : 0;

        $jarak = $this->distance($latitudekantor, $longitudekantor, $latitudeuser, $longitudeuser);
        $radius = round($jarak["meters"]);

        //Cek Jam Kerja Karyawan
        $namahari = $this->gethari();
        $jamkerja = DB::table('konfigurasi_jamkerja')
            ->join('jam_kerja', 'konfigurasi_jamkerja.kode_jam_kerja', '=', 'jam_kerja.kode_jam_kerja')
            ->where('nik', $nik)->where('hari', $namahari)->first();

        $jamMasuk = $jamkerja->jam_masuk;
        $jamPulang = $jamkerja->jam_pulang;


        $cek = DB::table('presensi')->where('tgl_presensi', $tgl_presensi)->where('nik', $nik)->count();

        if ($cek > 0) {
            $ket = "out";
        } else {
            $ket = "in";
        }
        $image = $request->image;
        $folderPath = "public/uploads/absensi/";
        $formatName = $nik . "-" . $tgl_presensi . "-" . $ket;
        $image_parts = explode(";base64", $image);
        $image_base64 = base64_decode($image_parts[1]);
        $fileName = $formatName . ".png";
        $file = $folderPath . $fileName;


        if ($radius > $lok_kantor->radius_cabang) {
            // echo "error|Maaf Anda Berada Diluar Radius, Jarak Anda " . $radius . " meter dari Kantor|radius";

            if($cek < 1) {
                if ($jam < $jamkerja->awal_jam_masuk) {
                    echo "error|Maaf Belum Waktunya Melakuan Presensi|in";
                } else if ($jam > $jamkerja->akhir_jam_masuk) {
                    echo "error|Maaf Waktu Untuk Presensi Sudah Habis |in";
                } else {
                    $data = [
                        'nik' => $nik,
                        'tgl_presensi' => $tgl_presensi,
                        'jadwal_masuk'  => $jamMasuk,
                        'jadwal_pulang' => $jamPulang,
                        'jam_in' => $jam,
                        'foto_in' => $fileName,
                        'lokasi_in' => $lokasi,
                        'kode_jam_kerja' => $jamkerja->kode_jam_kerja,
                        'status_absen'  => 1,
                        'absen_masuk_type' => 1,
                        'status'        => 0,
                        'absen_in_status' => 0,
                        'absen_in_zone' => $inZone,
                        'cabang_absen'  => $kode_cabang
                    ];

                    if($jam > $jamMasuk) {
                        $data['is_late'] = 1;
                    } else {
                        $data['is_late'] = 0;
                    }

                    $simpan = DB::table('presensi')->insert($data);
                    if ($simpan) {
                        echo "warning|Anda absen diluar radius dan memerlukan persetujuan admin...!!!|in";
                        Storage::put($file, $image_base64);
                    } else {
                        echo "error|Maaf Gagal absen, Hubungi HRD|in";
                    }
                }
            } else {
                if ($jam < $jamkerja->jam_pulang) {
                    echo "error|Maaf Belum Waktunya Pulang |out";
                } else {
                    $data_pulang = [
                        'jam_out' => $jam,
                        'foto_out' => $fileName,
                        'lokasi_out' => $lokasi,
                        'absen_pulang_type' => 1,
                        'status'        => 5,
                        'absen_out_status'  => 0,
                        'absen_out_zone' => $inZone,
                    ];

                    $update = DB::table('presensi')->where('tgl_presensi', $tgl_presensi)->where('nik', $nik)->update($data_pulang);
                    if ($update) {
                        echo "warning|Absen pulang diluar radius dan memerlukan persetujuan admin...!!!|out";
                        Storage::put($file, $image_base64);
                    } else {
                        echo "error|Maaf Gagal absen pulang, Hubungi HRD|out";
                    }
                }
            }

        } else {
            if ($cek > 0) {
                if ($jam < $jamkerja->jam_pulang) {
                    echo "error|Maaf Belum Waktunya Pulang |out";
                } else {
                    $data_pulang = [
                        'jam_out' => $jam,
                        'foto_out' => $fileName,
                        'lokasi_out' => $lokasi,
                        'absen_pulang_type' => 1,
                        'absen_out_zone' => $inZone,
                    ];

                    $update = DB::table('presensi')->where('tgl_presensi', $tgl_presensi)->where('nik', $nik)->update($data_pulang);
                    if ($update) {
                        echo "success|Terimkasih, Hati Hati Di Jalan|out";
                        Storage::put($file, $image_base64);
                    } else {
                        echo "error|Maaf Gagal absen, Hubungi Tim It|out";
                    }
                }
            } else {
                if ($jam < $jamkerja->awal_jam_masuk) {
                    echo "error|Maaf Belum Waktunya Melakuan Presensi|in";
                } else if ($jam > $jamkerja->akhir_jam_masuk) {
                    echo "error|Maaf Waktu Untuk Presensi Sudah Habis |in";
                } else {
                    $data = [
                        'nik' => $nik,
                        'tgl_presensi' => $tgl_presensi,
                        'jadwal_masuk'  => $jamMasuk,
                        'jadwal_pulang' => $jamPulang,
                        'jam_in' => $jam,
                        'foto_in' => $fileName,
                        'lokasi_in' => $lokasi,
                        'kode_jam_kerja' => $jamkerja->kode_jam_kerja,
                        'status_absen'  => 1,
                        'absen_masuk_type' => 1,
                        'absen_in_zone' => $inZone,
                        'cabang_absen'  => $kode_cabang
                    ];

                    if($jam > $jamMasuk) {
                        $data['is_late'] = 1;
                    } else {
                        $data['is_late'] = 0;
                    }

                    // cek karyawan inti di proyek, kalau iya uang makan include 3
                    if($contractStatus != 'harian' && $contractStatus != 'project' && $cabangStatus == 1) $data['meal_num'] = 3;

                    $simpan = DB::table('presensi')->insert($data);
                    if ($simpan) {
                        echo "success|Terimkasih, Selamat Bekerja|in";
                        Storage::put($file, $image_base64);
                    } else {
                        echo "error|Maaf Gagal absen, Hubungi Tim It|in";
                    }
                }
            }
        }
    }

    //Menghitung Jarak
    function distance($lat1, $lon1, $lat2, $lon2)
    {
        $theta = $lon1 - $lon2;
        $miles = (sin(deg2rad($lat1)) * sin(deg2rad($lat2))) + (cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * cos(deg2rad($theta)));
        $miles = acos($miles);
        $miles = rad2deg($miles);
        $miles = $miles * 60 * 1.1515;
        $feet = $miles * 5280;
        $yards = $feet / 3;
        $kilometers = $miles * 1.609344;
        $meters = $kilometers * 1000;
        return compact('meters');
    }

    public function editprofile()
    {
        $nik = Auth::guard('karyawan')->user()->nik;
        $karyawan = DB::table('karyawan')->where('nik', $nik)->first();
        return view('presensi.editprofile', compact('karyawan'));
    }

    public function updateprofile(Request $request)
    {
        $nik = Auth::guard('karyawan')->user()->nik;
        $nama_lengkap = $request->nama_lengkap;
        $no_hp = $request->no_hp;
        $password = Hash::make($request->password);
        $karyawan = DB::table('karyawan')->where('nik', $nik)->first();
        $request->validate([
            'foto' => 'required|image|mimes:png,jpg|max:500'
        ]);
        if ($request->hasFile('foto')) {
            $foto = $nik . "." . $request->file('foto')->getClientOriginalExtension();
        } else {
            $foto = $karyawan->foto;
        }
        if (empty($request->password)) {
            $data = [
                'nama_lengkap' => $nama_lengkap,
                'no_hp' => $no_hp,
                'foto' => $foto
            ];
        } else {
            $data = [
                'nama_lengkap' => $nama_lengkap,
                'no_hp' => $no_hp,
                'password' => $password,
                'foto' => $foto
            ];
        }

        $update = DB::table('karyawan')->where('nik', $nik)->update($data);
        if ($update) {
            if ($request->hasFile('foto')) {
                $folderPath = "public/uploads/karyawan/";
                $request->file('foto')->storeAs($folderPath, $foto);
            }
            return Redirect::back()->with(['success' => 'Data Berhasil Di Update']);
        } else {
            return Redirect::back()->with(['error' => 'Data gagal Di Update']);
        }
    }


    public function histori()
    {
        $namabulan = ["", "Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember"];
        return view('presensi.histori', compact('namabulan'));
    }

    public function gethistori(Request $request)
    {
        $bulan = $request->bulan;
        $tahun = $request->tahun;
        $nik = Auth::guard('karyawan')->user()->nik;

        $histori = DB::table('presensi')
            ->whereRaw('MONTH(tgl_presensi)="' . $bulan . '"')
            ->whereRaw('YEAR(tgl_presensi)="' . $tahun . '"')
            ->where('nik', $nik)
            ->orderBy('tgl_presensi')
            ->get();

        return view('presensi.gethistori', compact('histori'));
    }


    public function getJumlahLibur(Request $request)
    {
        try {
            $startDate = $request->startDate;
            $endDate = $request->endDate;

            $jumlahLibur = 0;
            $jumlahLibur += Holiday::whereBetween('holidays_date', [$startDate, $endDate])->count();
            $jumlahLibur += jumlahHariMinggu($startDate, $endDate);

            $tglAkhirWrap = date('Y-m-d', strtotime("+$jumlahLibur days", strtotime($endDate)));

            //hitung jml hari minggu dan hari libur
            $jmlHariMinggu = jumlahHariMinggu($startDate, $tglAkhirWrap);
            $jmlHariLibur = Holiday::whereBetween('holidays_date', [$startDate, $tglAkhirWrap])->count();
            $totalLibur = $jmlHariMinggu + $jmlHariLibur;

            // dd($totalLibur);

            return [
                'error'     => false,
                'amount'    => $totalLibur
            ];

        } catch (Exception $e) {
            return [
                'error'     => true,
                'message'   => $e->getMessage()
            ];
        }
    }


    /*=====================================
            PENGAJUAN IZIN
    ==================================== */

    public function izin()
    {
        $nik = Auth::guard('karyawan')->user()->nik;
        $jabatan = Auth::guard('karyawan')->user()->contract->jabatan_id;
        $dataizin = Pengajuanizin::with(['karyawan', 'jenisizin'])->where('nik', $nik)->get();

        $roleId = Auth::guard('karyawan')->user()->role_id;

        if($roleId > 1 || $jabatan == 34) {
            return view('presensi.frontend.izin.izin-optionmenu');
        } else {
            return view('presensi.frontend.izin.izin', compact('dataizin'));
        }
    }

    public function izinPribadi()
    {
        $nik = Auth::guard('karyawan')->user()->nik;
        $dataizin = Pengajuanizin::with(['karyawan', 'jenisizin'])->where('nik', $nik)->get();
        return view('presensi.frontend.izin.izin', compact('dataizin'));
    }


    public function izinKaryawan()
    {
        $roleId = Auth::guard('karyawan')->user()->role_id;
        $deptId = Auth::guard('karyawan')->user()->contract->department_id;
        $jabatanId = Auth::guard('karyawan')->user()->contract->jabatan_id;

        if($roleId == 1 && $jabatanId == 34) {
            $dataIzinKaryawan = Pengajuanizin::with(['karyawan', 'jenisizin'])
                                ->select('karyawan.*', 'pengajuan_izin.id as id_pi', 'pengajuan_izin.tgl_mulai_izin', 'pengajuan_izin.tgl_akhir_izin', 'pengajuan_izin.status', 'pengajuan_izin.keterangan', 'pengajuan_izin.lampiran', 'pengajuan_izin.status_approved', 'pengajuan_izin.is_read')
                                ->join('karyawan', 'pengajuan_izin.nik', '=', 'karyawan.nik')
                                ->where('pengajuan_izin.status_approved', '>=', 2)
                                ->where('pengajuan_izin.status_approved', '!=', 6)
                                ->where('pengajuan_izin.status_approved', '!=', 7)
                                ->get();
        }

        if($roleId == 2) {
            if($deptId == 9) {
                $dataIzinKaryawan = Pengajuanizin::with(['karyawan', 'jenisizin'])
                                                ->select('karyawan.*', 'pengajuan_izin.id as id_pi', 'pengajuan_izin.tgl_mulai_izin', 'pengajuan_izin.tgl_akhir_izin', 'pengajuan_izin.status', 'pengajuan_izin.keterangan', 'pengajuan_izin.lampiran', 'pengajuan_izin.status_approved', 'pengajuan_izin.is_read')
                                                ->join('karyawan', 'pengajuan_izin.nik', '=', 'karyawan.nik')
                                                ->where('pengajuan_izin.status_approved', '>=', 2)
                                                ->where('pengajuan_izin.status_approved', '!=', 6)
                                                ->where('pengajuan_izin.status_approved', '!=', 7)
                                                ->get();
            } else {
                $dataIzinKaryawan = Pengajuanizin::with(['karyawan', 'jenisizin'])
                                                ->select('karyawan.*', 'pengajuan_izin.id as id_pi', 'pengajuan_izin.tgl_mulai_izin', 'pengajuan_izin.tgl_akhir_izin', 'pengajuan_izin.status', 'pengajuan_izin.keterangan', 'pengajuan_izin.lampiran', 'pengajuan_izin.status_approved', 'pengajuan_izin.is_read')
                                                ->join('karyawan', 'pengajuan_izin.nik', '=', 'karyawan.nik')
                                                ->where('karyawan.kode_dept', $deptId)
                                                ->where('karyawan.role_id', 1)
                                                ->get();
            }
        }

        if($roleId == 3) {
            $dataIzinKaryawan = Pengajuanizin::with(['karyawan', 'jenisizin'])
                                                ->select('karyawan.*', 'pengajuan_izin.id as id_pi', 'pengajuan_izin.tgl_mulai_izin', 'pengajuan_izin.tgl_akhir_izin', 'pengajuan_izin.status', 'pengajuan_izin.keterangan', 'pengajuan_izin.lampiran', 'pengajuan_izin.status_approved', 'pengajuan_izin.is_read')
                                                ->join('karyawan', 'pengajuan_izin.nik', '=', 'karyawan.nik')
                                                ->where('karyawan.kode_dept', 6)
                                                ->orWhere('karyawan.kode_dept', 8)
                                                ->where('pengajuan_izin.status_approved', '!=', 6)
                                                ->get();
        }

        if($roleId == 4) {
            $dataIzinKaryawan = Pengajuanizin::with(['karyawan', 'jenisizin'])
                                                ->select('karyawan.*', 'pengajuan_izin.id as id_pi', 'pengajuan_izin.tgl_mulai_izin', 'pengajuan_izin.tgl_akhir_izin', 'pengajuan_izin.status', 'pengajuan_izin.keterangan', 'pengajuan_izin.lampiran', 'pengajuan_izin.status_approved', 'pengajuan_izin.is_read')
                                                ->join('karyawan', 'pengajuan_izin.nik', '=', 'karyawan.nik')
                                                ->where('pengajuan_izin.status_approved', '>=', 3)
                                                ->where('pengajuan_izin.status_approved', '!=', 6)
                                                ->where('pengajuan_izin.status_approved', '!=', 7)
                                                ->where('pengajuan_izin.status_approved', '!=', 8)
                                                ->get();
        }

        if($roleId == 5) {
            $dataIzinKaryawan = Pengajuanizin::with(['karyawan', 'jenisizin'])
                                                ->select('karyawan.*', 'pengajuan_izin.id as id_pi', 'pengajuan_izin.tgl_mulai_izin', 'pengajuan_izin.tgl_akhir_izin', 'pengajuan_izin.status', 'pengajuan_izin.keterangan', 'pengajuan_izin.lampiran', 'pengajuan_izin.status_approved', 'pengajuan_izin.is_read')
                                                ->join('karyawan', 'pengajuan_izin.nik', '=', 'karyawan.nik')
                                                ->where('pengajuan_izin.status_approved', '>=', 4)
                                                ->where('pengajuan_izin.status_approved', '!=', 6)
                                                ->where('pengajuan_izin.status_approved', '!=', 7)
                                                ->where('pengajuan_izin.status_approved', '!=', 8)
                                                ->where('pengajuan_izin.status_approved', '!=', 9)
                                                ->get();
        }

        // STATUS APPROVED
        $kodeStatusApproved = 0;

        if($roleId == 1 && $jabatanId == 34) $kodeStatusApproved = 2;

        if($roleId == 2)  {
            if($deptId == 9) {
                $kodeStatusApproved = 2;
            } else {
                $kodeStatusApproved = 0;
            }
        }

        if($roleId == 3) $kodeStatusApproved = 1;
        if($roleId == 4) $kodeStatusApproved = 3;
        if($roleId == 5) $kodeStatusApproved = 4;

        $data = [
            'dataIzinKaryawan'      => $dataIzinKaryawan,
            'kodeStatusApproved'    => $kodeStatusApproved
        ];

        return view('presensi.frontend.izin.izin-karyawan', $data);
    }

    public function buatizin()
    {
        return view('presensi.frontend.izin.buatizin');
    }

    //search jenis izin
    public function getJenisIzin(Request $request)
    {
        // get data jenis cuti
        $jenis = JenisIzin::where('jenis', $request->jenis)->get();

        $optJenis = '<option value="">-- Pilih jenis --</option>';

        foreach($jenis as $jns) {
            $optJenis .= "<option value='$jns->id'>$jns->nama</option>";
        }

        return [
            'error'     => false,
            'optJenis'  => $optJenis
        ];
    }

    public function storeizin(Request $request)
    {
        $tglMulai = null;
        $tglAkhir = null;
        $bulanPertama = 0;
        $bulanKedua = 0;

        $validatedData = $request->validate([
            'status'            => 'required',
            'keterangan'        => 'required',
            'lampiran'          => 'file|max:2048|mimes:pdf,jpg,jpeg,png'
        ]);

        if($request->status == 's') {
            $request->validate([
                'tgl_mulai_izin'     => 'required|date',
                'tgl_akhir_izin'     => 'required|date',
                'lampiran'           => 'required|file|max:5120|mimes:pdf,jpg,jpeg,png'
            ]);
        }

        if($request->status == 'i') {
            if($request->jenis_izin_id == 10) {
                $request->validate([
                    'jam_mulai'    => 'required',
                    'jam_akhir'    => 'required'
                ]);

                $tglMulai = date('Y-m-d');
                $tglAkhir = date('Y-m-d');
                $validatedData['jumlah_hari'] = 1;
            }

            if($request->jenis_izin_id == 11) {
                $request->validate([
                    'tgl_mulai_izin'    => 'required'
                ]);

                $tglAkhir = $request->tgl_mulai_izin;
                $validatedData['jumlah_hari'] = 1;
            }
        }

        if($request->status == 'c') {
            if($request->jenis_izin_id == 1) {
                $request->validate([
                    'tgl_mulai_izin'    => 'required|date',
                    'tgl_akhir_izin'    => 'required|date'
                ]);
            } else {
                // get jenis izin by id
                $jenisIzin = JenisIzin::find($request->jenis_izin_id);
                $jmlHariCuti = $jenisIzin->jml_hari - 1;

                $tglAkhirWrap = date('Y-m-d', strtotime("+$jmlHariCuti days", strtotime($request->tgl_mulai_izin)));

                //hitung jml hari minggu dan hari libur
                $jmlHariMinggu = jumlahHariMinggu($request->tgl_mulai_izin, $tglAkhirWrap);
                $jmlHariLibur = Holiday::whereBetween('holidays_date', [$request->tgl_mulai_izin, $tglAkhirWrap])->count();
                $totalLibur = $jmlHariMinggu + $jmlHariLibur;

                $tglAkhir = $tglAkhirWrap;

                for($i=$totalLibur; $i > 0; $i--) {
                    $tglAkhir = date('Y-m-d', strtotime("+1 days", strtotime($tglAkhir)));

                    $libur = Holiday::where('holidays_date', $tglAkhir)->count();
                    $minggu = date('N', strtotime($tglAkhir));

                    if($libur > 0 || $minggu == 7) {
                        $i++;
                    }
                }
            }
        }

        $nik = Auth::guard('karyawan')->user()->nik;

        // upload lampiran
        $path = '';
        if($request->file('lampiran')) {
            $path = $request->file('lampiran')->store("izin/$nik", 'public');
        }

        $validatedData['nik'] = $nik;
        $validatedData['lampiran'] = $path;
        $validatedData['jenis_izin_id'] = $request->jenis_izin_id;
        $validatedData['tgl_mulai_izin'] = (!empty($request->tgl_mulai_izin)) ? $request->tgl_mulai_izin : $tglMulai;
        $validatedData['tgl_akhir_izin'] = (!empty($request->tgl_akhir_izin)) ? $request->tgl_akhir_izin : $tglAkhir;
        $validatedData['jam_mulai'] = $request->jam_mulai;
        $validatedData['jam_akhir'] = $request->jam_akhir;

        // status approved
        $roleId = Auth::guard('karyawan')->user()->role_id;
        $deptId = Auth::guard('karyawan')->user()->contract->department_id;
        $newStatusApprove = 0;


        // get manager
        $managerData = Karyawan::with(['jabatan_kerja', 'department', 'cabang', 'contract', 'oldContract'])
                        ->where('role_id', 2)
                        ->where('status', 3)
                        ->whereRelation('contract', 'department_id', $deptId)
                        ->count();
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
        // get gm
        $gmData = Karyawan::with(['jabatan_kerja', 'department', 'cabang', 'contract', 'oldContract'])
                        ->where('role_id', 3)
                        ->where('status', 3)
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

        // manager
        if($roleId == 2) {
            if($deptId == 9) {
                $newStatusApprove = 3;
            } else {
                if($deptId == 6 || $deptId == 8) {
                    $newStatusApprove = 1;
                } else {
                    $newStatusApprove = 2;
                }
            }
        }

        // staff
        if($roleId == 1) {
            //staff direktur
            if($deptId == 2) {
                $newStatusApprove = 3;
            } else {
                //staff department
                $newStatusApprove = 0;

                // cek department teknik dan produksi
                if($deptId == 6 || $deptId == 8) {
                    if($managerData < 1) $newStatusApprove = 1;
                } else {
                    if($managerData < 1) $newStatusApprove = 2;
                }
            }
        }

        // gm
        if($roleId == 3) $newStatusApprove = 2;

        // direktur
        if($roleId == 4) $newStatusApprove = 4;

        //komisaris
        if($roleId == 5) $newStatusApprove = 5;



        //=============================
        // cek data karyawan ada atau tidak
        if($newStatusApprove == 1) {
            if($gmData < 1) $newStatusApprove = 2;
        }

        if($newStatusApprove == 2) {
            if($managerHrdData < 1) {
                if($hrdSpvData < 1) $newStatusApprove = 3;
            }
        }

        if($newStatusApprove == 3) {
            if($direkturData < 1) $newStatusApprove = 4;
        }

        if($newStatusApprove == 4) {
            if($komisarisData < 1) $newStatusApprove = 5;
        }
        //================================

        $validatedData['status_approved'] = $newStatusApprove;
        $validatedData['jumlah_hari'] = jumlahHari($validatedData['tgl_mulai_izin'], $validatedData['tgl_akhir_izin']);

        $bagiHariBulan = jmlPembagianHariIzin($validatedData['tgl_mulai_izin'], $validatedData['tgl_akhir_izin']);
        $validatedData['bulan_pertama'] = $bagiHariBulan['bulanPertama'];
        $validatedData['bulan_kedua'] = $bagiHariBulan['bulanKedua'];


        try {
            Pengajuanizin::create($validatedData);
            return to_route('presensi.izinpribadi')->with(['success' => 'Data Berhasil Disimpan']);

        } catch (Exception $e) {
            // return to_route('presensi.izinpribadi')->with(['error' => 'Data Gagal Disimpan']);
            return to_route('presensi.izinpribadi')->with(['error' => $e->getMessage()]);
        }
    }


    public function detailIzinApprove(Pengajuanizin $pengajuanIzin)
    {
        try {

            // STATUS APPROVED
            $roleId = Auth::guard('karyawan')->user()->role_id;
            $deptId = Auth::guard('karyawan')->user()->contract->department_id;
            $jabatanId = Auth::guard('karyawan')->user()->contract->jabatan_id;
            $kodeStatusApproved = 0;

            if($roleId == 1 && $jabatanId == 34) {
                $kodeStatusApproved = 2;

                // get tracking manager hrd read
                $trackingIzin = TrackingIzin::with(['pengajuanizin', 'karyawan'])
                                ->where('pengajuan_izin_id', $pengajuanIzin->id)
                                ->where('status', 7)
                                ->get();

                if(count($trackingIzin) < 1) {
                    // update tracking read
                    $dataTracking = [
                        'pengajuan_izin_id'         => $pengajuanIzin->id,
                        'keterangan'                => 'Dilihat HRD SPV',
                        'status'                    => 7,
                        'date'                      => date('Y-m-d'),
                    ];

                    TrackingIzin::create($dataTracking);
                }
            }

            if($roleId == 2)  {
                if($deptId == 9) {
                    $kodeStatusApproved = 2;

                    // get tracking manager hrd read
                    $trackingIzin = TrackingIzin::with(['pengajuanizin', 'karyawan'])
                                    ->where('pengajuan_izin_id', $pengajuanIzin->id)
                                    ->where('status', 7)
                                    ->get();

                    if(count($trackingIzin) < 1) {
                        // update tracking read
                        $dataTracking = [
                            'pengajuan_izin_id'         => $pengajuanIzin->id,
                            'keterangan'                => 'Dilihat Manager HRD',
                            'status'                    => 7,
                            'date'                      => date('Y-m-d'),
                        ];

                        TrackingIzin::create($dataTracking);
                    }
                } else {
                    $kodeStatusApproved = 0;

                    // get tracking manager read
                    $trackingIzin = TrackingIzin::with(['pengajuanizin', 'karyawan'])
                                    ->where('pengajuan_izin_id', $pengajuanIzin->id)
                                    ->where('status', 1)
                                    ->get();

                    if(count($trackingIzin) < 1) {
                        // update tracking read
                        $dataTracking = [
                            'pengajuan_izin_id'         => $pengajuanIzin->id,
                            'keterangan'                => 'Dilihat Manager',
                            'status'                    => 1,
                            'date'                      => date('Y-m-d'),
                        ];

                        TrackingIzin::create($dataTracking);
                    }
                }
            }

            if($roleId == 3) {
                $kodeStatusApproved = 1;

                // get tracking gm read
                $trackingIzin = TrackingIzin::with(['pengajuanizin', 'karyawan'])
                                ->where('pengajuan_izin_id', $pengajuanIzin->id)
                                ->where('status', 4)
                                ->get();

                if(count($trackingIzin) < 1) {
                    // update tracking read
                    $dataTracking = [
                        'pengajuan_izin_id'         => $pengajuanIzin->id,
                        'keterangan'                => 'Dilihat GM',
                        'status'                    => 4,
                        'date'                      => date('Y-m-d'),
                    ];

                    TrackingIzin::create($dataTracking);
                }
            }

            if($roleId == 4) {
                $kodeStatusApproved = 3;

                // get tracking direktur read
                $trackingIzin = TrackingIzin::with(['pengajuanizin', 'karyawan'])
                                ->where('pengajuan_izin_id', $pengajuanIzin->id)
                                ->where('status', 10)
                                ->get();

                if(count($trackingIzin) < 1) {
                    // update tracking read
                    $dataTracking = [
                        'pengajuan_izin_id'         => $pengajuanIzin->id,
                        'keterangan'                => 'Dilihat Direktur',
                        'status'                    => 10,
                        'date'                      => date('Y-m-d'),
                    ];

                    TrackingIzin::create($dataTracking);
                }
            }

            if($roleId == 5) {
                $kodeStatusApproved = 4;

                // get tracking komisaris read
                $trackingIzin = TrackingIzin::with(['pengajuanizin', 'karyawan'])
                                ->where('pengajuan_izin_id', $pengajuanIzin->id)
                                ->where('status', 13)
                                ->get();

                if(count($trackingIzin) < 1) {
                    // update tracking read
                    $dataTracking = [
                        'pengajuan_izin_id'         => $pengajuanIzin->id,
                        'keterangan'                => 'Dilihat Komisaris',
                        'status'                    => 13,
                        'date'                      => date('Y-m-d'),
                    ];

                    TrackingIzin::create($dataTracking);
                }
            }

            if($pengajuanIzin->status_approved == $kodeStatusApproved && $roleId != 1 || $jabatanId == 34) {
                // update read
                Pengajuanizin::where('id', $pengajuanIzin->id)->update(['is_read'   => 1]);
            }

            $data = [
                'title'                 => 'Detail Izin Karyawan | PT. Maha Akbar Sejahtera',
                'dataIzin'              => $pengajuanIzin,
                'kodeStatusApproved'    => $kodeStatusApproved,
                'karyawan'              => Karyawan::with(['jabatan_kerja', 'department', 'cabang', 'contract', 'oldContract'])
                                            ->where('nik', $pengajuanIzin->nik)
                                            ->get(),
                'trackingIzin'          => TrackingIzin::with(['pengajuanizin', 'karyawan'])
                                            ->where('pengajuan_izin_id', $pengajuanIzin->id)
                                            ->get()
            ];

            return view('presensi.frontend.izin.izin-detail-approve', $data);

        } catch (Exception $e) {
            return back()->with('error', 'Terjadi kesalahan!');
        }
    }


    public function terimaIzin(Pengajuanizin $pengajuanIzin)
    {
        try {
            $roleId = Auth::guard('karyawan')->user()->role_id;
            $deptId = Auth::guard('karyawan')->user()->contract->department_id;
            $jabatanId = Auth::guard('karyawan')->user()->contract->jabatan_id;

            // get manager
            $managerData = Karyawan::with(['jabatan_kerja', 'department', 'cabang', 'contract', 'oldContract'])
                        ->where('role_id', 2)
                        ->where('status', 3)
                        ->whereRelation('contract', 'department_id', $deptId)
                        ->count();
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
            // get gm
            $gmData = Karyawan::with(['jabatan_kerja', 'department', 'cabang', 'contract', 'oldContract'])
                    ->where('role_id', 3)
                    ->where('status', 3)
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

            // hrd spv
            if($roleId == 1 && $jabatanId == 34) {
                $newStatusApprove = 3;
                if($pengajuanIzin->status == 'i') $newStatusApprove = 5;

                // get tracking manager approve
                $trackingIzin = TrackingIzin::with(['pengajuanizin', 'karyawan'])
                                ->where('pengajuan_izin_id', $pengajuanIzin->id)
                                ->where('status', 8)
                                ->get();

                if(count($trackingIzin) < 1) {
                    // update tracking read
                    $dataTracking = [
                        'pengajuan_izin_id'         => $pengajuanIzin->id,
                        'keterangan'                => 'Disetujui HRD SPV',
                        'status'                    => 8,
                        'date'                      => date('Y-m-d'),
                    ];

                    TrackingIzin::create($dataTracking);
                }

                $dataUpdate = [
                    'status_approved'       => $newStatusApprove,
                    'hrd_approve_date'  => date('Y-m-d'),
                    'is_read'               => 0
                ];
            }

            // manager
            if($roleId == 2) {
                if($deptId == 9) {
                    $newStatusApprove = 3;
                    if($pengajuanIzin->status == 'i') $newStatusApprove = 5;

                    // get tracking manager approve
                    $trackingIzin = TrackingIzin::with(['pengajuanizin', 'karyawan'])
                                    ->where('pengajuan_izin_id', $pengajuanIzin->id)
                                    ->where('status', 8)
                                    ->get();

                    if(count($trackingIzin) < 1) {
                        // update tracking read
                        $dataTracking = [
                            'pengajuan_izin_id'         => $pengajuanIzin->id,
                            'keterangan'                => 'Disetujui Manager HRD',
                            'status'                    => 8,
                            'date'                      => date('Y-m-d'),
                        ];

                        TrackingIzin::create($dataTracking);
                    }

                    $dataUpdate = [
                        'status_approved'       => $newStatusApprove,
                        'hrd_approve_date'  => date('Y-m-d'),
                        'is_read'               => 0
                    ];

                } else {
                    if($deptId == 6 || $deptId == 8) {
                        $newStatusApprove = 1;
                    } else {
                        $newStatusApprove = 2;

                        // get tracking manager approve
                        $trackingIzin = TrackingIzin::with(['pengajuanizin', 'karyawan'])
                                        ->where('pengajuan_izin_id', $pengajuanIzin->id)
                                        ->where('status', 2)
                                        ->get();

                        if(count($trackingIzin) < 1) {
                            // update tracking read
                            $dataTracking = [
                                'pengajuan_izin_id'         => $pengajuanIzin->id,
                                'keterangan'                => 'Disetujui Manager',
                                'status'                    => 2,
                                'date'                      => date('Y-m-d'),
                            ];

                            TrackingIzin::create($dataTracking);
                        }

                    }

                    $dataUpdate = [
                        'status_approved'       => $newStatusApprove,
                        'manager_approve_date'  => date('Y-m-d'),
                        'is_read'               => 0
                    ];
                }
            }

            // gm
            if($roleId == 3) {
                $newStatusApprove = 2;

                // get tracking direktur approve
                $trackingIzin = TrackingIzin::with(['pengajuanizin', 'karyawan'])
                                ->where('pengajuan_izin_id', $pengajuanIzin->id)
                                ->where('status', 5)
                                ->get();

                if(count($trackingIzin) < 1) {
                    // update tracking read
                    $dataTracking = [
                        'pengajuan_izin_id'         => $pengajuanIzin->id,
                        'keterangan'                => 'Disetujui GM',
                        'status'                    => 5,
                        'date'                      => date('Y-m-d'),
                    ];

                    TrackingIzin::create($dataTracking);
                }

                $dataUpdate = [
                    'status_approved'       => $newStatusApprove,
                    'gm_approve_date'  => date('Y-m-d'),
                    'is_read'               => 0
                ];

            }

            // direktur
            if($roleId == 4) {
                $newStatusApprove = 4;

                // get tracking direktur approve
                $trackingIzin = TrackingIzin::with(['pengajuanizin', 'karyawan'])
                                ->where('pengajuan_izin_id', $pengajuanIzin->id)
                                ->where('status', 11)
                                ->get();

                if(count($trackingIzin) < 1) {
                    // update tracking read
                    $dataTracking = [
                        'pengajuan_izin_id'         => $pengajuanIzin->id,
                        'keterangan'                => 'Disetujui Direktur',
                        'status'                    => 11,
                        'date'                      => date('Y-m-d'),
                    ];

                    TrackingIzin::create($dataTracking);
                }

                $dataUpdate = [
                    'status_approved'       => $newStatusApprove,
                    'direktur_approve_date'  => date('Y-m-d'),
                    'is_read'               => 0
                ];

            }

            // komisaris
            if($roleId == 5) {
                $newStatusApprove = 5;

                // get tracking komisaris approve
                $trackingIzin = TrackingIzin::with(['pengajuanizin', 'karyawan'])
                                ->where('pengajuan_izin_id', $pengajuanIzin->id)
                                ->where('status', 14)
                                ->get();

                if(count($trackingIzin) < 1) {
                    // update tracking read
                    $dataTracking = [
                        'pengajuan_izin_id'         => $pengajuanIzin->id,
                        'keterangan'                => 'Disetujui Komisaris',
                        'status'                    => 14,
                        'date'                      => date('Y-m-d'),
                    ];

                    TrackingIzin::create($dataTracking);
                }

                $dataUpdate = [
                    'status_approved'       => $newStatusApprove,
                    'komisaris_approve_date'  => date('Y-m-d'),
                    'is_read'               => 0
                ];

            }


            //=============================
            // cek data karyawan ada atau tidak
            if($newStatusApprove == 1) {
                if($gmData < 1) $newStatusApprove = 2;
            }

            if($newStatusApprove == 2) {
                if($managerHrdData < 1) {
                    if($hrdSpvData < 1) $newStatusApprove = 3;
                }
            }

            if($newStatusApprove == 3) {
                if($direkturData < 1) $newStatusApprove = 4;
            }

            if($newStatusApprove == 4) {
                if($komisarisData < 1) $newStatusApprove = 5;
            }
            //================================

            $dataUpdate['status_approved'] = $newStatusApprove;

            // update
            Pengajuanizin::where('id', $pengajuanIzin->id)->update($dataUpdate);
            return to_route('presensi.izinkaryawan')->with('success', 'Izin berhasil diterima!');

        } catch (Exception $e) {
            return to_route('presensi.izinkaryawan')->with('error', 'Izin gagal diterima, silahkan coba lagi!');
        }
    }

    public function tolakIzin(Pengajuanizin $pengajuanIzin, Request $request)
    {
        try {
            // validate keterangan ditolak
            $request->validate([
                'keterangan_tolak'  => 'required'
            ]);

            $roleId = Auth::guard('karyawan')->user()->role_id;
            $deptId = Auth::guard('karyawan')->user()->contract->department_id;
            $jabatanId = Auth::guard('karyawan')->user()->contract->jabatan_id;

            $newStatusApprove = 6;
            $dataUpdate = [];

            // hrd spv
            if($roleId == 1 && $jabatanId == 34) {
                $newStatusApprove = 8;

                // get tracking manager approve
                $trackingIzin = TrackingIzin::with(['pengajuanizin', 'karyawan'])
                                ->where('pengajuan_izin_id', $pengajuanIzin->id)
                                ->where('status', 9)
                                ->get();

                if(count($trackingIzin) < 1) {
                    // update tracking read
                    $dataTracking = [
                        'pengajuan_izin_id'         => $pengajuanIzin->id,
                        'keterangan'                => 'Ditolak HRD SPV',
                        'keterangan_tolak'          => $request->keterangan_tolak,
                        'status'                    => 9,
                        'date'                      => date('Y-m-d'),
                    ];

                    TrackingIzin::create($dataTracking);
                }
            }

            // manager
            if($roleId == 2) {
                if($deptId == 9) {
                    $newStatusApprove = 8;

                    // get tracking manager approve
                    $trackingIzin = TrackingIzin::with(['pengajuanizin', 'karyawan'])
                                    ->where('pengajuan_izin_id', $pengajuanIzin->id)
                                    ->where('status', 9)
                                    ->get();

                    if(count($trackingIzin) < 1) {
                        // update tracking read
                        $dataTracking = [
                            'pengajuan_izin_id'         => $pengajuanIzin->id,
                            'keterangan'                => 'Ditolak Manager HRD',
                            'keterangan_tolak'          => $request->keterangan_tolak,
                            'status'                    => 9,
                            'date'                      => date('Y-m-d'),
                        ];

                        TrackingIzin::create($dataTracking);
                    }

                } else {
                    $newStatusApprove = 6;

                    // get tracking manager approve
                    $trackingIzin = TrackingIzin::with(['pengajuanizin', 'karyawan'])
                                    ->where('pengajuan_izin_id', $pengajuanIzin->id)
                                    ->where('status', 3)
                                    ->get();

                    if(count($trackingIzin) < 1) {
                        // update tracking read
                        $dataTracking = [
                            'pengajuan_izin_id'         => $pengajuanIzin->id,
                            'keterangan'                => 'Ditolak Manager',
                            'keterangan_tolak'          => $request->keterangan_tolak,
                            'status'                    => 3,
                            'date'                      => date('Y-m-d'),
                        ];

                        TrackingIzin::create($dataTracking);
                    }
                }
            }

            // gm
            if($roleId == 3) {
                $newStatusApprove = 7;

                // get tracking direktur approve
                $trackingIzin = TrackingIzin::with(['pengajuanizin', 'karyawan'])
                                ->where('pengajuan_izin_id', $pengajuanIzin->id)
                                ->where('status', 6)
                                ->get();

                if(count($trackingIzin) < 1) {
                    // update tracking read
                    $dataTracking = [
                        'pengajuan_izin_id'         => $pengajuanIzin->id,
                        'keterangan'                => 'Ditolak GM',
                        'keterangan_tolak'          => $request->keterangan_tolak,
                        'status'                    => 6,
                        'date'                      => date('Y-m-d'),
                    ];

                    TrackingIzin::create($dataTracking);
                }

            }

            // direktur
            if($roleId == 4) {
                $newStatusApprove = 9;

                // get tracking direktur approve
                $trackingIzin = TrackingIzin::with(['pengajuanizin', 'karyawan'])
                                ->where('pengajuan_izin_id', $pengajuanIzin->id)
                                ->where('status', 12)
                                ->get();

                if(count($trackingIzin) < 1) {
                    // update tracking read
                    $dataTracking = [
                        'pengajuan_izin_id'         => $pengajuanIzin->id,
                        'keterangan'                => 'Ditolak Direktur',
                        'keterangan_tolak'          => $request->keterangan_tolak,
                        'status'                    => 12,
                        'date'                      => date('Y-m-d'),
                    ];

                    TrackingIzin::create($dataTracking);
                }

            }

            // komisaris
            if($roleId == 5) {
                $newStatusApprove = 10;

                // get tracking komisaris approve
                $trackingIzin = TrackingIzin::with(['pengajuanizin', 'karyawan'])
                                ->where('pengajuan_izin_id', $pengajuanIzin->id)
                                ->where('status', 15)
                                ->get();

                if(count($trackingIzin) < 1) {
                    // update tracking read
                    $dataTracking = [
                        'pengajuan_izin_id'         => $pengajuanIzin->id,
                        'keterangan'                => 'Ditolak Komisaris',
                        'keterangan_tolak'          => $request->keterangan_tolak,
                        'status'                    => 15,
                        'date'                      => date('Y-m-d'),
                    ];

                    TrackingIzin::create($dataTracking);
                }

            }

            $dataUpdate = [
                'status_approved'       => $newStatusApprove,
                'is_read'               => 0
            ];

            // update
            Pengajuanizin::where('id', $pengajuanIzin->id)->update($dataUpdate);
            return to_route('presensi.izinkaryawan')->with('success', 'Izin berhasil ditolak!');

        } catch (Exception $e) {
            return to_route('presensi.izinkaryawan')->with('error', $e->getMessage());
        }
    }

    public function destroyIzin(Pengajuanizin $pengajuanIzin)
    {
        try {
            // cek lampiran kalau ada hapus
            if(!empty($pengajuanIzin->lampiran)) {
                Storage::disk('public')->delete($pengajuanIzin->lampiran);
            }

            Pengajuanizin::where('id', $pengajuanIzin->id)->delete();
            return back()->with('success', 'Pengajuan Izin berhasil dihapus!');
        } catch (Exception $e) {
            return back()->with('error', 'Pengajuan Izin gagal dihapus!');
        }
    }


    /*===========================================================================================*/


    /*===============================================
                PENGAJUAN LEMBUR
    ===============================================*/

    public function lembur()
    {
        $idKaryawan = Auth::guard('karyawan')->user()->id;
        $roleId = Auth::guard('karyawan')->user()->role_id;
        $jabatan = Auth::guard('karyawan')->user()->contract->jabatan_id;

        $data = [
            'title'         => 'Lembur | PT. Maha Akbar Sejahtera',
            'dataLembur'    => Lembur::with(['karyawan'])->where('karyawan_id', $idKaryawan)->get()
        ];

        if($roleId > 1 || $jabatan == 34) {
            return view('presensi.frontend.lembur.lembur-optionmenu', compact('jabatan'));
        } else {
            return view('presensi.frontend.lembur.index', $data);
        }
    }

    public function lemburPribadi()
    {
        $id = Auth::guard('karyawan')->user()->id;
        $dataLembur = Lembur::with(['karyawan'])->where('karyawan_id', $id)->get();
        return view('presensi.frontend.lembur.index', compact('dataLembur'));
    }

    public function perintahLembur()
    {
        $id = Auth::guard('karyawan')->user()->id;
        $dataLembur = Lembur::with(['karyawan'])
        ->where('atasan_id', $id)
        ->get();
        return view('presensi.frontend.lembur.perintah-lembur', compact('dataLembur'));
    }

    public function addPerintahLembur()
    {
        $id = Auth::guard('karyawan')->user()->id;
        $karyawan = Karyawan::find($id);
        if($karyawan->role_id == 2) {
            $bawahan = Karyawan::where('role_id', 1)
            ->where('kode_dept', $karyawan->kode_dept)
            ->get();
        } elseif ($karyawan->role_id == 3) {
            $bawahan = Karyawan::where('role_id', 1)
            ->whereIn('kode_dept', [6,8])
            ->get();
        }elseif ($karyawan->role_id == 4 || $karyawan->role_id == 5 ) {
            $bawahan = Karyawan::where('role_id', 1)
            ->get();
        }else{
            $bawahan = Karyawan::where('role_id', 1)
            ->where('kode_dept', $karyawan->kode_dept)
            ->get();
        }
        return view('presensi.frontend.lembur.add-perintah-lembur', compact('karyawan', 'bawahan'));
    }

    public function storePerintahLembur(Request $request){

        $validatedData = $request->validate([
            'penerima'         => 'required',
            'tgl_lembur'        => 'required',
            'jam_mulai'         => 'required',
            'jam_selesai'       => 'required',
            'perihal'           => 'required',
            'keterangan'        => 'required'
        ]);


        try {
            $atasan = Auth::guard('karyawan')->user()->id;
            $atasanrole =  Auth::guard('karyawan')->user()->role_id;
            $atasankodedept =  Auth::guard('karyawan')->user()->contract->department_id;
            $atasanJabatan = Auth::guard('karyawan')->user()->contract->jabatan_id;

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
            // get gm
            $gmData = Karyawan::with(['jabatan_kerja', 'department', 'cabang', 'contract', 'oldContract'])
                    ->where('role_id', 3)
                    ->where('status', 3)
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


            $lemburCek = Lembur::with(['karyawan'])
                                ->where('tgl_lembur', $request->tgl_lembur)
                                ->where('atasan_id', $atasan)
                                ->where('karyawan_id', $request->penerima)
                                ->count();
            if($lemburCek > 0) {
                return back()->with('error', 'Anda sudah mengajukan lembur pada tanggal '. $request->tgl_lembur);
            }
            $data = [
                'atasan_id'        => $atasan,
                'karyawan_id'      => $request->penerima,
                'tgl_lembur'       => $request->tgl_lembur,
                'jam_mulai'        => $request->jam_mulai,
                'jam_selesai'      => $request->jam_selesai,
                'perihal'          => $request->perihal,
                'keterangan'       => $request->keterangan,
            ];

            $statusApproved = 11;

            //spv manager
            if($atasanrole == 1 && $atasankodedept == 9 && $atasanJabatan == 34) $statusApproved = 3;

            // role manager
            if($atasanrole == 2) {
                if($atasankodedept == 9) {
                    $statusApproved = 3;
                } else {
                    //cek departemen teknik atau tidak
                    if($atasankodedept == 6 || $atasankodedept == 8) {
                        $statusApproved = 1;
                    } else {
                        $statusApproved = 2;
                    }
                }
            }

            //GM
            if ($atasanrole == 3) $statusApproved = 2;
            // direktur
            if ($atasanrole == 4) $statusApproved = 4;
            // komisaris
            if ($atasanrole == 5) $statusApproved = 11;

            //=============================
            // cek data karyawan ada atau tidak
            if($statusApproved == 1) {
                if($gmData < 1) $statusApproved = 2;
            }

            if($statusApproved == 2) {
                if($managerHrdData < 1) {
                    if($hrdSpvData < 1) $statusApproved = 3;
                }
            }

            if($statusApproved == 3) {
                if($direkturData < 1) $statusApproved = 4;
            }

            if($statusApproved == 4) {
                if($komisarisData < 1) $statusApproved = 11;
            }
            //================================

            $data['status_approved'] = $statusApproved;

            Lembur::create($data);
            return to_route('presensi.perintahlembur')->with('success', 'Perintah Lembur Ditambah !');
        } catch (Exception $e) {
            return back()->with('error', 'Terjadi Kesalahan, Hubungi TIM IT !');
        }

    }

    public function lemburKaryawan()
    {
        $roleId = Auth::guard('karyawan')->user()->role_id;
        $deptId = Auth::guard('karyawan')->user()->contract->department_id;
        $jabatanId = Auth::guard('karyawan')->user()->contract->jabatan_id;

        if($roleId == 1 && $jabatanId == 34) {
            $dataLemburKaryawan = Lembur::with(['karyawan'])
                                ->select('karyawan.*', 'lembur.id as id_lb', 'lembur.tgl_lembur', 'lembur.perihal', 'lembur.keterangan', 'lembur.status_approved', 'lembur.is_read')
                                ->join('karyawan', 'lembur.karyawan_id', '=', 'karyawan.id')
                                // ->whereNull('lembur.atasan_id') // Menggunakan whereNull untuk memeriksa kolom yang bernilai NULL
                                ->where('lembur.status_approved', '>=', 2)
                                ->where('lembur.status_approved', '!=', 6)
                                ->where('lembur.status_approved', '!=', 7)
                                ->where('lembur.status_approved', '!=', 11)
                                ->get();
        }

        if($roleId == 2) {
            if($deptId == 9) {
                $dataLemburKaryawan = Lembur::with(['karyawan'])
                                                ->select('karyawan.*', 'lembur.id as id_lb', 'lembur.tgl_lembur', 'lembur.perihal', 'lembur.keterangan', 'lembur.status_approved', 'lembur.is_read')
                                                ->join('karyawan', 'lembur.karyawan_id', '=', 'karyawan.id')
                                                // ->whereNull('lembur.atasan_id') // Menggunakan whereNull untuk memeriksa kolom yang bernilai NULL
                                                ->where('lembur.status_approved', '>=', 2)
                                                ->where('lembur.status_approved', '!=', 6)
                                                ->where('lembur.status_approved', '!=', 7)
                                                ->where('lembur.status_approved', '!=', 11)
                                                ->get();
            } else {
                $dataLemburKaryawan = Lembur::with(['karyawan'])
                                    ->select('karyawan.*', 'lembur.id as id_lb', 'lembur.tgl_lembur', 'lembur.perihal', 'lembur.keterangan', 'lembur.status_approved', 'lembur.is_read')
                                    ->join('karyawan', 'lembur.karyawan_id', '=', 'karyawan.id')
                                    ->where('karyawan.kode_dept', $deptId)
                                    ->where('karyawan.role_id', 1)
                                    ->where('lembur.status_approved', '!=', 11)
                                    ->get();
            }
        }

        if($roleId == 3) {
            $dataLemburKaryawan = Lembur::with(['karyawan'])
                                                ->select('karyawan.*', 'lembur.id as id_lb', 'lembur.tgl_lembur', 'lembur.perihal', 'lembur.keterangan', 'lembur.status_approved', 'lembur.is_read')
                                                ->join('karyawan', 'lembur.karyawan_id', '=', 'karyawan.id')
                                                ->where('karyawan.kode_dept', 6)
                                                ->orWhere('karyawan.kode_dept', 8)
                                                ->where('lembur.status_approved', '!=', 6)
                                                ->where('lembur.status_approved', '!=', 11)
                                                ->get();
        }

        if($roleId == 4) {
            $dataLemburKaryawan = Lembur::with(['karyawan'])
                                                ->select('karyawan.*', 'lembur.id as id_lb', 'lembur.tgl_lembur', 'lembur.perihal', 'lembur.keterangan', 'lembur.status_approved', 'lembur.is_read')
                                                ->join('karyawan', 'lembur.karyawan_id', '=', 'karyawan.id')
                                                ->where('lembur.status_approved', '>=', 3)
                                                ->where('lembur.status_approved', '!=', 6)
                                                ->where('lembur.status_approved', '!=', 7)
                                                ->where('lembur.status_approved', '!=', 8)
                                                ->where('lembur.status_approved', '!=', 11)
                                                ->get();
        }

        if($roleId == 5) {
            $dataLemburKaryawan = Lembur::with(['karyawan'])
                                                ->select('karyawan.*', 'lembur.id as id_lb', 'lembur.tgl_lembur', 'lembur.perihal', 'lembur.keterangan', 'lembur.status_approved', 'lembur.is_read')
                                                ->join('karyawan', 'lembur.karyawan_id', '=', 'karyawan.id')
                                                ->where('lembur.status_approved', '>=', 4)
                                                ->where('lembur.status_approved', '!=', 6)
                                                ->where('lembur.status_approved', '!=', 7)
                                                ->where('lembur.status_approved', '!=', 8)
                                                ->where('lembur.status_approved', '!=', 9)
                                                ->where('lembur.status_approved', '!=', 11)
                                                ->get();
        }

        // STATUS APPROVED
        $kodeStatusApproved = 0;

        if($roleId == 1 && $jabatanId == 34) {
            $kodeStatusApproved = 2;
        }

        if($roleId == 2)  {
            if($deptId == 9) {
                $kodeStatusApproved = 2;
            } else {
                $kodeStatusApproved = 0;
            }
        }

        if($roleId == 3) $kodeStatusApproved = 1;
        if($roleId == 4) $kodeStatusApproved = 3;
        if($roleId == 5) $kodeStatusApproved = 4;

        $data = [
            'dataLemburKaryawan'    => $dataLemburKaryawan,
            'kodeStatusApproved'    => $kodeStatusApproved
        ];

        return view('presensi.frontend.lembur.lembur-karyawan', $data);
    }


    public function createLembur()
    {
        $data = [
            'title'         => 'Form Lembur | PT. Maha Akbar Sejahtera'
        ];

        return view('presensi.frontend.lembur.buat-lembur', $data);
    }


    public function storeLembur(Request $request)
    {
        $validatedData = $request->validate([
            'tgl_lembur'        => 'required',
            'jam_mulai'         => 'required',
            'jam_selesai'       => 'required',
            'perihal'           => 'required',
            'keterangan'        => 'required'
        ]);

        $validatedData['karyawan_id'] = Auth::guard('karyawan')->user()->id;

        try {
            // cek lembur berdasarkan tanggal yg di input
            $lemburCek = Lembur::with(['karyawan'])
                        ->where('karyawan_id', $validatedData['karyawan_id'])
                        ->where('tgl_lembur', $request->tgl_lembur)
                        ->get();

            if(count($lemburCek) > 0) {
                // kalau sudah ada balikin pesan kesalahan
                return back()->with('error', 'Lembur pada tanggal ' . tanggalBulanIndo($request->tgl_lembur) . ' sudah di input sebelumnya!');
            } else {
                // kalau tidak input
                $newLembur = Lembur::create($validatedData);
                return to_route('presensi.lembur.foto', [1, $newLembur->id]);
            }
        } catch (Exception $e) {
            return back()->with('error', $e->getMessage());
        }

    }


    public function fotoLembur($status = 1, Lembur $lembur)
    {
        $hariini = date("Y-m-d");
        $namahari = $this->gethari();
        $nik = Auth::guard('karyawan')->user()->nik;
        $cek = DB::table('presensi')->where('tgl_presensi', $hariini)->where('nik', $nik)->count();
        $kode_cabang = Auth::guard('karyawan')->user()->kode_cabang;
        $lok_kantor = DB::table('cabang')->where('kode_cabang', $kode_cabang)->first();

        $labelStatusLembur = '';

        if($status == 1) $labelStatusLembur = 'Lembur Mulai';
        if($status == 2) $labelStatusLembur = 'Lembur Berlangsung';
        if($status == 3) $labelStatusLembur = 'Lembur Selesai';

        return view('presensi.frontend.lembur.create-start-lembur', compact('cek', 'lok_kantor', 'status', 'lembur', 'labelStatusLembur'));
    }


    public function storeFotoLembur(Request $request)
    {
        $nik = Auth::guard('karyawan')->user()->nik;
        $tglLembur = date('Y-m-d');
        $statusLembur = $request->status;
        $statusLemburLabel = '';

        if($statusLembur == 1) $statusLemburLabel = 'mulai';
        if($statusLembur == 2) $statusLemburLabel = 'berlangsung';
        if($statusLembur == 3) $statusLemburLabel = 'selesai';

        // cek foto mulai
        $fotoReadyCheck = LemburFoto::with(['lembur'])
                    ->where('lembur_id', $request->lembur)
                    ->where('status', $statusLembur)
                    ->get();

        $image = $request->image;
        $folderPath = "public/uploads/lembur/";
        $formatName = $nik . "-" . $tglLembur . "-" . $statusLemburLabel;
        $image_parts = explode(";base64", $image);
        $image_base64 = base64_decode($image_parts[1]);
        $fileName = $formatName . '-' . count($fotoReadyCheck) + 1 . ".png";
        $file = $folderPath . $fileName;

        // create lembur foto

        if($statusLembur == 1 || $statusLembur == 3) {

            if(count($fotoReadyCheck) > 0) {
                echo "error|Foto mulai sudah dilakukan sebelumnya!";
            } else {
                Storage::put($file, $image_base64);

                $data = [
                    'lembur_id'         => $request->lembur,
                    'foto_lembur'       => 'uploads/lembur/' . $fileName,
                    'status'            => $statusLembur
                ];

                // create
                $newLemburFoto = LemburFoto::create($data);

                if($newLemburFoto) {
                    if($statusLembur == 3) {
                        echo "success_pulang|Foto berhasil di tambahkan!";
                    } else {
                        echo "success|Foto berhasil di tambahkan!";
                    }
                } else {
                    echo "error|Foto gagal di tambahkan!";
                }

            }
        } else {

            Storage::put($file, $image_base64);

            $data = [
                'lembur_id'         => $request->lembur,
                'foto_lembur'       => 'uploads/lembur/' . $fileName,
                'status'            => $statusLembur
            ];

            // create
            $newLemburFoto = LemburFoto::create($data);

            if($newLemburFoto) {
                echo "success|Foto berhasil di tambahkan!";
            } else {
                echo "error|Foto gagal di tambahkan!";
            }
        }
    }


    public function detailLembur(Lembur $lembur)
    {
        try {

            // STATUS APPROVED
            $roleId = Auth::guard('karyawan')->user()->role_id;
            $deptId = Auth::guard('karyawan')->user()->contract->department_id;
            $jabatanId = Auth::guard('karyawan')->user()->contract->jabatan_id;
            $kodeStatusApproved = 0;

            if($roleId == 1 && $jabatanId == 34) {
                $kodeStatusApproved = 2;

                // get tracking manager hrd read
                $trackingLembur = TrackingLembur::with(['lembur'])
                                ->where('lembur_id', $lembur->id)
                                ->where('status', 7)
                                ->get();

                if(count($trackingLembur) < 1) {
                    // update tracking read
                    $dataTracking = [
                        'lembur_id'                 => $lembur->id,
                        'keterangan'                => 'Dilihat HRD SPV',
                        'status'                    => 7,
                        'date'                      => date('Y-m-d'),
                    ];

                    TrackingLembur::create($dataTracking);
                }
            }

            if($roleId == 2)  {
                if($deptId == 9) {
                    $kodeStatusApproved = 2;

                    // get tracking manager hrd read
                    $trackingLembur = TrackingLembur::with(['lembur'])
                                    ->where('lembur_id', $lembur->id)
                                    ->where('status', 7)
                                    ->get();

                    if(count($trackingLembur) < 1) {
                        // update tracking read
                        $dataTracking = [
                            'lembur_id'                 => $lembur->id,
                            'keterangan'                => 'Dilihat Manager HRD',
                            'status'                    => 7,
                            'date'                      => date('Y-m-d'),
                        ];

                        TrackingLembur::create($dataTracking);
                    }
                } else {
                    $kodeStatusApproved = 0;

                    // get tracking manager read
                    $trackingLembur = TrackingLembur::with(['lembur'])
                                    ->where('lembur_id', $lembur->id)
                                    ->where('status', 1)
                                    ->get();

                    if(count($trackingLembur) < 1) {
                        // update tracking read
                        $dataTracking = [
                            'lembur_id'                 => $lembur->id,
                            'keterangan'                => 'Dilihat Manager',
                            'status'                    => 1,
                            'date'                      => date('Y-m-d'),
                        ];

                        TrackingLembur::create($dataTracking);
                    }
                }
            }

            if($roleId == 3) {
                $kodeStatusApproved = 1;

                // get tracking gm read
                $trackingLembur = TrackingLembur::with(['lembur'])
                                ->where('lembur_id', $lembur->id)
                                ->where('status', 4)
                                ->get();

                if(count($trackingLembur) < 1) {
                    // update tracking read
                    $dataTracking = [
                        'lembur_id'                 => $lembur->id,
                        'keterangan'                => 'Dilihat GM',
                        'status'                    => 4,
                        'date'                      => date('Y-m-d'),
                    ];

                    TrackingLembur::create($dataTracking);
                }
            }

            if($roleId == 4) {
                $kodeStatusApproved = 3;

                // get tracking direktur read
                $trackingLembur = TrackingLembur::with(['lembur'])
                                ->where('lembur_id', $lembur->id)
                                ->where('status', 10)
                                ->get();

                if(count($trackingLembur) < 1) {
                    // update tracking read
                    $dataTracking = [
                        'lembur_id'                 => $lembur->id,
                        'keterangan'                => 'Dilihat Direktur',
                        'status'                    => 10,
                        'date'                      => date('Y-m-d'),
                    ];

                    TrackingLembur::create($dataTracking);
                }
            }

            if($roleId == 5) {
                $kodeStatusApproved = 4;

                // get tracking komisaris read
                $trackingLembur = TrackingLembur::with(['lembur'])
                                ->where('lembur_id', $lembur->id)
                                ->where('status', 13)
                                ->get();

                if(count($trackingLembur) < 1) {
                    // update tracking read
                    $dataTracking = [
                        'lembur_id'                 => $lembur->id,
                        'keterangan'                => 'Dilihat Komisaris',
                        'status'                    => 13,
                        'date'                      => date('Y-m-d'),
                    ];

                    TrackingLembur::create($dataTracking);
                }
            }

            if($lembur->status_approved == $kodeStatusApproved && $roleId != 1 || $jabatanId == 34) {
                // update read
                Lembur::where('id', $lembur->id)->update(['is_read'   => 1]);
            }

            $data = [
                'title'                 => 'Detail Lembur Karyawan | PT. Maha Akbar Sejahtera',
                'dataLembur'            => $lembur,
                'trackingLembur'        => TrackingLembur::with(['lembur'])
                                            ->where('lembur_id', $lembur->id)->get(),
                'fotoMulai'             => LemburFoto::with(['lembur'])->where('lembur_id', $lembur->id)
                                            ->where('status', 1)->get(),
                'fotoBerlangsung'       => LemburFoto::with(['lembur'])->where('lembur_id', $lembur->id)
                                            ->where('status', 2)->get(),
                'fotoSelesai'           => LemburFoto::with(['lembur'])->where('lembur_id', $lembur->id)
                                            ->where('status', 3)->get(),
                'kodeStatusApproved'    => $kodeStatusApproved,
                'karyawan'              => Karyawan::with(['jabatan_kerja', 'department', 'cabang', 'contract', 'oldContract'])
                                            ->where('id', $lembur->karyawan_id)
                                            ->get(),
            ];

            return view('presensi.frontend.lembur.detail-lembur', $data);

        } catch (Exception $e) {
            return back()->with('error', 'Terjadi kesalahan!');
        }
    }

    public function ajukanLembur(Lembur $lembur)
    {
        try {
            $statusApproved = 0;
            $ketTracking = 'Lembur diajukan';
            $msgSuccess = 'Lembur berhasil diajukan';

            // direktur staff
            $roleId = Auth::guard('karyawan')->user()->role_id;
            $deptId = Auth::guard('karyawan')->user()->contract->department_id;

            // get manager
            $managerData = Karyawan::with(['jabatan_kerja', 'department', 'cabang', 'contract', 'oldContract'])
                    ->where('role_id', 2)
                    ->where('status', 3)
                    ->whereRelation('contract', 'department_id', $deptId)
                    ->count();
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
            // get gm
            $gmData = Karyawan::with(['jabatan_kerja', 'department', 'cabang', 'contract', 'oldContract'])
                    ->where('role_id', 3)
                    ->where('status', 3)
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


            //staff direktur
            if($deptId == 2) {
                $statusApproved = 3;
            } else {
                //staff department
                $statusApproved = 0;

                // cek department teknik dan produksi
                if($deptId == 6 || $deptId == 8) {
                    if($managerData < 1) $statusApproved = 1;
                } else {
                    if($managerData < 1) $statusApproved = 2;
                }
            }


            //=============================
            // cek data karyawan ada atau tidak
            if($statusApproved == 1) {
                if($gmData < 1) $statusApproved = 2;
            }

            if($statusApproved == 2) {
                if($managerHrdData < 1) {
                    if($hrdSpvData < 1) $statusApproved = 3;
                }
            }

            if($statusApproved == 3) {
                if($direkturData < 1) $statusApproved = 4;
            }

            if($statusApproved == 4) {
                if($komisarisData < 1) $statusApproved = 5;
            }
            //================================

            // cek lembur perintah atau bukan
            if(!empty($lembur->atasan_id)) {
                $statusApproved = 5;
                $ketTracking = 'Lembur selesai dilaksanakan';
                $msgSuccess = 'Lembur telah selesai';
            }

            // update lembur status
            Lembur::where('id', $lembur->id)->update(['status_approved' => $statusApproved]);

            // create tracking
            $data = [
                'lembur_id'         => $lembur->id,
                'keterangan'        => $ketTracking,
                'keterangan_tolak'  => null,
                'status'            => null,
                'date'              => date('Y-m-d')
            ];

            TrackingLembur::create($data);
            return to_route('presensi.lembur')->with('success', $msgSuccess);
        } catch(Exception $e) {
            return back()->with('error', 'Lembur gagal diajukan, silahkan coba lagi!');
        }
    }

    public function tolakLembur(Lembur $lembur, Request $request)
    {
        try {
            // validate keterangan ditolak
            $request->validate([
                'keterangan_tolak'  => 'required'
            ]);

            $roleId = Auth::guard('karyawan')->user()->role_id;
            $deptId = Auth::guard('karyawan')->user()->contract->department_id;
            $jabatanId = Auth::guard('karyawan')->user()->contract->jabatan_id;

            $newStatusApprove = 6;
            $dataUpdate = [];

            // hrd spv
            if($roleId == 1 && $jabatanId == 34) {
                $newStatusApprove = 8;

                // get tracking manager approve
                $trackingLembur = TrackingLembur::with(['lembur'])
                                ->where('lembur_id', $lembur->id)
                                ->where('status', 9)
                                ->get();

                if(count($trackingLembur) < 1) {
                    // update tracking read
                    $dataTracking = [
                        'lembur_id'                 => $lembur->id,
                        'keterangan'                => 'Ditolak HRD SPV',
                        'keterangan_tolak'          => $request->keterangan_tolak,
                        'status'                    => 9,
                        'date'                      => date('Y-m-d'),
                    ];

                    TrackingLembur::create($dataTracking);
                }
            }

            // manager
            if($roleId == 2) {
                if($deptId == 9) {
                    $newStatusApprove = 8;

                    // get tracking manager approve
                    $trackingLembur = TrackingLembur::with(['lembur'])
                                    ->where('lembur_id', $lembur->id)
                                    ->where('status', 9)
                                    ->get();

                    if(count($trackingLembur) < 1) {
                        // update tracking read
                        $dataTracking = [
                            'lembur_id'                 => $lembur->id,
                            'keterangan'                => 'Ditolak Manager HRD',
                            'keterangan_tolak'          => $request->keterangan_tolak,
                            'status'                    => 9,
                            'date'                      => date('Y-m-d'),
                        ];

                        TrackingLembur::create($dataTracking);
                    }

                } else {
                    $newStatusApprove = 6;

                    // get tracking manager approve
                    $trackingLembur = TrackingLembur::with(['lembur'])
                                    ->where('lembur_id', $lembur->id)
                                    ->where('status', 3)
                                    ->get();

                    if(count($trackingLembur) < 1) {
                        // update tracking read
                        $dataTracking = [
                            'lembur_id'                 => $lembur->id,
                            'keterangan'                => 'Ditolak Manager',
                            'keterangan_tolak'          => $request->keterangan_tolak,
                            'status'                    => 3,
                            'date'                      => date('Y-m-d'),
                        ];

                        TrackingLembur::create($dataTracking);
                    }
                }
            }

            // gm
            if($roleId == 3) {
                $newStatusApprove = 7;

                // get tracking direktur approve
                $trackingLembur = TrackingLembur::with(['lembur'])
                                ->where('lembur_id', $lembur->id)
                                ->where('status', 6)
                                ->get();

                if(count($trackingLembur) < 1) {
                    // update tracking read
                    $dataTracking = [
                        'lembur_id'                 => $lembur->id,
                        'keterangan'                => 'Ditolak GM',
                        'keterangan_tolak'          => $request->keterangan_tolak,
                        'status'                    => 6,
                        'date'                      => date('Y-m-d'),
                    ];

                    TrackingLembur::create($dataTracking);
                }

            }

            // direktur
            if($roleId == 4) {
                $newStatusApprove = 9;

                // get tracking direktur approve
                $trackingLembur = TrackingLembur::with(['lembur'])
                                ->where('lembur_id', $lembur->id)
                                ->where('status', 12)
                                ->get();

                if(count($trackingLembur) < 1) {
                    // update tracking read
                    $dataTracking = [
                        'lembur_id'                 => $lembur->id,
                        'keterangan'                => 'Ditolak Direktur',
                        'keterangan_tolak'          => $request->keterangan_tolak,
                        'status'                    => 12,
                        'date'                      => date('Y-m-d'),
                    ];

                    TrackingLembur::create($dataTracking);
                }

            }

            // komisaris
            if($roleId == 5) {
                $newStatusApprove = 10;

                // get tracking komisaris approve
                $trackingLembur = TrackingLembur::with(['lembur'])
                                ->where('lembur_id', $lembur->id)
                                ->where('status', 15)
                                ->get();

                if(count($trackingLembur) < 1) {
                    // update tracking read
                    $dataTracking = [
                        'lembur_id'                 => $lembur->id,
                        'keterangan'                => 'Ditolak Komisaris',
                        'keterangan_tolak'          => $request->keterangan_tolak,
                        'status'                    => 15,
                        'date'                      => date('Y-m-d'),
                    ];

                    TrackingLembur::create($dataTracking);
                }

            }

            $dataUpdate = [
                'status_approved'       => $newStatusApprove,
                'is_read'               => 0
            ];

            // update
            Lembur::where('id', $lembur->id)->update($dataUpdate);
            return to_route('presensi.lembur.karyawan')->with('success', 'Lembur berhasil ditolak!');

        } catch (Exception $e) {
            return to_route('presensi.lembur.karyawan')->with('error', $e->getMessage());
        }
    }

    public function terimaLembur(Lembur $lembur)
    {
        try {
            $roleId = Auth::guard('karyawan')->user()->role_id;
            $deptId = Auth::guard('karyawan')->user()->contract->department_id;
            $jabatanId = Auth::guard('karyawan')->user()->contract->jabatan_id;

            // get manager
            $managerData = Karyawan::with(['jabatan_kerja', 'department', 'cabang', 'contract', 'oldContract'])
                        ->where('role_id', 2)
                        ->where('status', 3)
                        ->whereRelation('contract', 'department_id', $deptId)
                        ->count();
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
            // get gm
            $gmData = Karyawan::with(['jabatan_kerja', 'department', 'cabang', 'contract', 'oldContract'])
                    ->where('role_id', 3)
                    ->where('status', 3)
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
            if($roleId == 1 && $jabatanId == 34) {
                $newStatusApprove = 3;

                // get tracking manager approve
                $trackingLembur = TrackingLembur::with(['lembur'])
                                ->where('lembur_id', $lembur->id)
                                ->where('status', 8)
                                ->get();

                if(count($trackingLembur) < 1) {
                    // update tracking read
                    $dataTracking = [
                        'lembur_id'                 => $lembur->id,
                        'keterangan'                => 'Disetujui HRD SPV',
                        'status'                    => 8,
                        'date'                      => date('Y-m-d'),
                    ];

                    TrackingLembur::create($dataTracking);
                }

                $dataUpdate = [
                    'status_approved'       => $newStatusApprove,
                    'hrd_approve_date'  => date('Y-m-d'),
                    'is_read'               => 0
                ];
            }

            // manager
            if($roleId == 2) {
                if($deptId == 9) {
                    $newStatusApprove = 3;

                    // get tracking manager approve
                    $trackingLembur = TrackingLembur::with(['lembur'])
                                    ->where('lembur_id', $lembur->id)
                                    ->where('status', 8)
                                    ->get();

                    if(count($trackingLembur) < 1) {
                        // update tracking read
                        $dataTracking = [
                            'lembur_id'                 => $lembur->id,
                            'keterangan'                => 'Disetujui Manager HRD',
                            'status'                    => 8,
                            'date'                      => date('Y-m-d'),
                        ];

                        TrackingLembur::create($dataTracking);
                    }

                    $dataUpdate = [
                        'status_approved'       => $newStatusApprove,
                        'hrd_approve_date'  => date('Y-m-d'),
                        'is_read'               => 0
                    ];

                } else {
                    if($deptId == 6 || $deptId == 8) {
                        $newStatusApprove = 1;
                    } else {
                        $newStatusApprove = 2;

                        // get tracking manager approve
                        $trackingLembur = TrackingLembur::with(['lembur'])
                                        ->where('lembur_id', $lembur->id)
                                        ->where('status', 2)
                                        ->get();

                        if(count($trackingLembur) < 1) {
                            // update tracking read
                            $dataTracking = [
                                'lembur_id'                 => $lembur->id,
                                'keterangan'                => 'Disetujui Manager',
                                'status'                    => 2,
                                'date'                      => date('Y-m-d'),
                            ];

                            TrackingLembur::create($dataTracking);
                        }

                    }

                    $dataUpdate = [
                        'status_approved'       => $newStatusApprove,
                        'manager_approve_date'  => date('Y-m-d'),
                        'is_read'               => 0
                    ];
                }
            }

            // direktur
            if($roleId == 3) {
                $newStatusApprove = 2;

                // get tracking direktur approve
                $trackingLembur = TrackingLembur::with(['lembur'])
                                ->where('lembur_id', $lembur->id)
                                ->where('status', 5)
                                ->get();

                if(count($trackingLembur) < 1) {
                    // update tracking read
                    $dataTracking = [
                        'lembur_id'                 => $lembur->id,
                        'keterangan'                => 'Disetujui GM',
                        'status'                    => 5,
                        'date'                      => date('Y-m-d'),
                    ];

                    TrackingLembur::create($dataTracking);
                }

                $dataUpdate = [
                    'status_approved'       => $newStatusApprove,
                    'gm_approve_date'  => date('Y-m-d'),
                    'is_read'               => 0
                ];

            }

            // direktur
            if($roleId == 4) {
                $newStatusApprove = 4;

                // get tracking direktur approve
                $trackingLembur = TrackingLembur::with(['lembur'])
                                ->where('lembur_id', $lembur->id)
                                ->where('status', 11)
                                ->get();

                if(count($trackingLembur) < 1) {
                    // update tracking read
                    $dataTracking = [
                        'lembur_id'                 => $lembur->id,
                        'keterangan'                => 'Disetujui Direktur',
                        'status'                    => 11,
                        'date'                      => date('Y-m-d'),
                    ];

                    TrackingLembur::create($dataTracking);
                }

                $dataUpdate = [
                    'status_approved'       => $newStatusApprove,
                    'direktur_approve_date'  => date('Y-m-d'),
                    'is_read'               => 0
                ];

            }

            // komisaris
            if($roleId == 5) {
                $newStatusApprove = 5;

                // get tracking komisaris approve
                $trackingLembur = TrackingLembur::with(['lembur'])
                                ->where('lembur_id', $lembur->id)
                                ->where('status', 14)
                                ->get();

                if(count($trackingLembur) < 1) {
                    // update tracking read
                    $dataTracking = [
                        'lembur_id'                 => $lembur->id,
                        'keterangan'                => 'Disetujui Komisaris',
                        'status'                    => 14,
                        'date'                      => date('Y-m-d'),
                    ];

                    TrackingLembur::create($dataTracking);
                }

                $dataUpdate = [
                    'status_approved'       => $newStatusApprove,
                    'komisaris_approve_date'  => date('Y-m-d'),
                    'is_read'               => 0
                ];

            }


            //=============================
            // cek data karyawan ada atau tidak
            if($newStatusApprove == 1) {
                if($gmData < 1) $newStatusApprove = 2;
            }

            if($newStatusApprove == 2) {
                if($managerHrdData < 1) {
                    if($hrdSpvData < 1) $newStatusApprove = 3;
                }
            }

            if($newStatusApprove == 3) {
                if($direkturData < 1) $newStatusApprove = 4;
            }

            if($newStatusApprove == 4) {
                if($komisarisData < 1) $newStatusApprove = 5;
            }
            //================================

            $dataUpdate['status_approved'] = $newStatusApprove;

            // update
            Lembur::where('id', $lembur->id)->update($dataUpdate);
            return to_route('presensi.lembur.karyawan')->with('success', 'Lembur berhasil diterima!');

        } catch (Exception $e) {
            return to_route('presensi.lembur.karyawan')->with('error', 'Lembur gagal diterima, silahkan coba lagi!');
        }
    }


    public function destroyLembur(Lembur $lembur)
    {
        try {
            $lemburFoto = LemburFoto::with(['lembur'])->where('lembur_id', $lembur->id)->get();

            //cek data foto
            if(count($lemburFoto)) {
                //kalau ada hapus foto nya
                foreach($lemburFoto as $item) {
                    Storage::disk('public')->delete($item->foto_lembur);
                }
            }

            //hapus lembur
            LemburFoto::where('lembur_id', $lembur->id)->delete();
            Lembur::where('id', $lembur->id)->delete();

            return back()->with('success', 'Data lembur ' . tanggalBulanIndo($lembur->tgl_lembur) . ' berhasil dihapus!');
        } catch (Exception $e) {
            return back()->with('error', 'Data lembur ' . tanggalBulanIndo($lembur->tgl_lembur) . ' gagal dihapus!');
        }
    }


    //===========================================================================================

    public function tampilkanpeta(Request $request)
    {
        $id = $request->id;
        $presensi = DB::table('presensi')->where('id', $id)
            ->join('karyawan', 'presensi.nik', '=', 'karyawan.nik')
            ->first();
        return view('presensi.showmap', compact('presensi'));
    }


    public function laporan()
    {
        $namabulan = ["", "Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember"];
        $karyawan = DB::table('karyawan')->orderBy('nama_lengkap')->get();
        return view('presensi.laporan', compact('namabulan', 'karyawan'));
    }

    public function cetaklaporan(Request $request)
    {
        $nik = $request->nik;
        $bulan = $request->bulan;
        $tahun = $request->tahun;
        $namabulan = ["", "Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember"];
        $karyawan = DB::table('karyawan')->where('nik', $nik)
            ->join('departemen', 'karyawan.kode_dept', '=', 'departemen.kode_dept')
            ->first();

        $presensi = DB::table('presensi')
            ->leftJoin('jam_kerja', 'presensi.kode_jam_kerja', '=', 'jam_kerja.kode_jam_kerja')
            ->where('nik', $nik)
            ->whereRaw('MONTH(tgl_presensi)="' . $bulan . '"')
            ->whereRaw('YEAR(tgl_presensi)="' . $tahun . '"')
            ->orderBy('tgl_presensi')
            ->get();

        if (isset($_POST['exportexcel'])) {
            $time = date("d-M-Y H:i:s");
            // Fungsi header dengan mengirimkan raw data excel
            header("Content-type: application/vnd-ms-excel");
            // Mendefinisikan nama file ekspor "hasil-export.xls"
            header("Content-Disposition: attachment; filename=Laporan Presensi Karyawan $time.xls");
            return view('presensi.cetaklaporanexcel', compact('bulan', 'tahun', 'namabulan', 'karyawan', 'presensi'));
        }
        return view('presensi.cetaklaporan', compact('bulan', 'tahun', 'namabulan', 'karyawan', 'presensi'));
    }

    public function rekap()
    {
        $namabulan = ["", "Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember"];
        return view('presensi.rekap', compact('namabulan'));
    }

    public function cetakrekap(Request $request)
    {
        $bulan = $request->bulan;
        $tahun = $request->tahun;
        $namabulan = ["", "Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember"];
        $rekap = DB::table('presensi')
            ->selectRaw('presensi.nik,nama_lengkap,jam_masuk,jam_pulang,
                MAX(IF(DAY(tgl_presensi) = 1,CONCAT(jam_in,"-",IFNULL(jam_out,"00:00:00")),"")) as tgl_1,
                MAX(IF(DAY(tgl_presensi) = 2,CONCAT(jam_in,"-",IFNULL(jam_out,"00:00:00")),"")) as tgl_2,
                MAX(IF(DAY(tgl_presensi) = 3,CONCAT(jam_in,"-",IFNULL(jam_out,"00:00:00")),"")) as tgl_3,
                MAX(IF(DAY(tgl_presensi) = 4,CONCAT(jam_in,"-",IFNULL(jam_out,"00:00:00")),"")) as tgl_4,
                MAX(IF(DAY(tgl_presensi) = 5,CONCAT(jam_in,"-",IFNULL(jam_out,"00:00:00")),"")) as tgl_5,
                MAX(IF(DAY(tgl_presensi) = 6,CONCAT(jam_in,"-",IFNULL(jam_out,"00:00:00")),"")) as tgl_6,
                MAX(IF(DAY(tgl_presensi) = 7,CONCAT(jam_in,"-",IFNULL(jam_out,"00:00:00")),"")) as tgl_7,
                MAX(IF(DAY(tgl_presensi) = 8,CONCAT(jam_in,"-",IFNULL(jam_out,"00:00:00")),"")) as tgl_8,
                MAX(IF(DAY(tgl_presensi) = 9,CONCAT(jam_in,"-",IFNULL(jam_out,"00:00:00")),"")) as tgl_9,
                MAX(IF(DAY(tgl_presensi) = 10,CONCAT(jam_in,"-",IFNULL(jam_out,"00:00:00")),"")) as tgl_10,
                MAX(IF(DAY(tgl_presensi) = 11,CONCAT(jam_in,"-",IFNULL(jam_out,"00:00:00")),"")) as tgl_11,
                MAX(IF(DAY(tgl_presensi) = 12,CONCAT(jam_in,"-",IFNULL(jam_out,"00:00:00")),"")) as tgl_12,
                MAX(IF(DAY(tgl_presensi) = 13,CONCAT(jam_in,"-",IFNULL(jam_out,"00:00:00")),"")) as tgl_13,
                MAX(IF(DAY(tgl_presensi) = 14,CONCAT(jam_in,"-",IFNULL(jam_out,"00:00:00")),"")) as tgl_14,
                MAX(IF(DAY(tgl_presensi) = 15,CONCAT(jam_in,"-",IFNULL(jam_out,"00:00:00")),"")) as tgl_15,
                MAX(IF(DAY(tgl_presensi) = 16,CONCAT(jam_in,"-",IFNULL(jam_out,"00:00:00")),"")) as tgl_16,
                MAX(IF(DAY(tgl_presensi) = 17,CONCAT(jam_in,"-",IFNULL(jam_out,"00:00:00")),"")) as tgl_17,
                MAX(IF(DAY(tgl_presensi) = 18,CONCAT(jam_in,"-",IFNULL(jam_out,"00:00:00")),"")) as tgl_18,
                MAX(IF(DAY(tgl_presensi) = 19,CONCAT(jam_in,"-",IFNULL(jam_out,"00:00:00")),"")) as tgl_19,
                MAX(IF(DAY(tgl_presensi) = 20,CONCAT(jam_in,"-",IFNULL(jam_out,"00:00:00")),"")) as tgl_20,
                MAX(IF(DAY(tgl_presensi) = 21,CONCAT(jam_in,"-",IFNULL(jam_out,"00:00:00")),"")) as tgl_21,
                MAX(IF(DAY(tgl_presensi) = 22,CONCAT(jam_in,"-",IFNULL(jam_out,"00:00:00")),"")) as tgl_22,
                MAX(IF(DAY(tgl_presensi) = 23,CONCAT(jam_in,"-",IFNULL(jam_out,"00:00:00")),"")) as tgl_23,
                MAX(IF(DAY(tgl_presensi) = 24,CONCAT(jam_in,"-",IFNULL(jam_out,"00:00:00")),"")) as tgl_24,
                MAX(IF(DAY(tgl_presensi) = 25,CONCAT(jam_in,"-",IFNULL(jam_out,"00:00:00")),"")) as tgl_25,
                MAX(IF(DAY(tgl_presensi) = 26,CONCAT(jam_in,"-",IFNULL(jam_out,"00:00:00")),"")) as tgl_26,
                MAX(IF(DAY(tgl_presensi) = 27,CONCAT(jam_in,"-",IFNULL(jam_out,"00:00:00")),"")) as tgl_27,
                MAX(IF(DAY(tgl_presensi) = 28,CONCAT(jam_in,"-",IFNULL(jam_out,"00:00:00")),"")) as tgl_28,
                MAX(IF(DAY(tgl_presensi) = 29,CONCAT(jam_in,"-",IFNULL(jam_out,"00:00:00")),"")) as tgl_29,
                MAX(IF(DAY(tgl_presensi) = 30,CONCAT(jam_in,"-",IFNULL(jam_out,"00:00:00")),"")) as tgl_30,
                MAX(IF(DAY(tgl_presensi) = 31,CONCAT(jam_in,"-",IFNULL(jam_out,"00:00:00")),"")) as tgl_31')
            ->join('karyawan', 'presensi.nik', '=', 'karyawan.nik')
            ->leftJoin('jam_kerja', 'presensi.kode_jam_kerja', '=', 'jam_kerja.kode_jam_kerja')
            ->whereRaw('MONTH(tgl_presensi)="' . $bulan . '"')
            ->whereRaw('YEAR(tgl_presensi)="' . $tahun . '"')
            ->groupByRaw('presensi.nik,nama_lengkap,jam_masuk,jam_pulang')
            ->get();

        if (isset($_POST['exportexcel'])) {
            $time = date("d-M-Y H:i:s");
            // Fungsi header dengan mengirimkan raw data excel
            header("Content-type: application/vnd-ms-excel");
            // Mendefinisikan nama file ekspor "hasil-export.xls"
            header("Content-Disposition: attachment; filename=Rekap Presensi Karyawan $time.xls");
        }
        return view('presensi.cetakrekap', compact('bulan', 'tahun', 'namabulan', 'rekap'));
    }

    public function izinsakit(Request $request)
    {

        $query = Pengajuanizin::query();
        $query->select('id', 'tgl_izin', 'pengajuan_izin.nik', 'nama_lengkap', 'jabatan', 'status', 'status_approved', 'keterangan');
        $query->join('karyawan', 'pengajuan_izin.nik', '=', 'karyawan.nik');
        if (!empty($request->dari) && !empty($request->sampai)) {
            $query->whereBetween('tgl_izin', [$request->dari, $request->sampai]);
        }

        if (!empty($request->nik)) {
            $query->where('pengajuan_izin.nik', $request->nik);
        }

        if (!empty($request->nama_lengkap)) {
            $query->where('nama_lengkap', 'like', '%' . $request->nama_lengkap . '%');
        }

        if ($request->status_approved === '0' || $request->status_approved === '1' || $request->status_approved === '2') {
            $query->where('status_approved', $request->status_approved);
        }
        $query->orderBy('tgl_izin', 'desc');
        $izinsakit = $query->paginate(2);
        $izinsakit->appends($request->all());
        return view('presensi.izinsakit', compact('izinsakit'));
    }

    public function approveizinsakit(Request $request)
    {
        $status_approved = $request->status_approved;
        $id_izinsakit_form = $request->id_izinsakit_form;
        $update = DB::table('pengajuan_izin')->where('id', $id_izinsakit_form)->update([
            'status_approved' => $status_approved
        ]);
        if ($update) {
            return Redirect::back()->with(['success' => 'Data Berhasil Di Update']);
        } else {
            return Redirect::back()->with(['warning' => 'Data Gagal Di Update']);
        }
    }

    public function batalkanizinsakit($id)
    {
        $update = DB::table('pengajuan_izin')->where('id', $id)->update([
            'status_approved' => 0
        ]);
        if ($update) {
            return Redirect::back()->with(['success' => 'Data Berhasil Di Update']);
        } else {
            return Redirect::back()->with(['warning' => 'Data Gagal Di Update']);
        }
    }

    public function cekpengajuanizin(Request $request)
    {
        $tgl_izin = $request->tgl_izin;
        $nik = Auth::guard('karyawan')->user()->nik;

        $cek = DB::table('pengajuan_izin')->where('nik', $nik)->where('tgl_izin', $tgl_izin)->count();
        return $cek;
    }


    public function storefrommachine()
    {
        $original_data  = file_get_contents('php://input');
        $decoded_data   = json_decode($original_data, true);
        $encoded_data   = json_encode($decoded_data);

        $data           = $decoded_data['data'];
        $pin            = $data['pin'];

        DB::table('presensi')->insert([
            'nik' => $pin,
            'tgl_presensi' => '2023-05-03'
        ]);
    }



    /*=================================================== */
    /*=================================================== */

    public function presensiHistory()
    {
        $karyawan = Auth::guard('karyawan')->user();
        dd($karyawan);
    }


    /*=====================================
                ADMIN
    =================================== */

    //====== IZIN ============
    public function createIzinAdmin(Request $request)
    {
        // $tglMulai = $request->tgl_mulai_izin;
        // $tglAkhir = $request->tgl_akhir_izin;

        // $jmlBulanPertama = 0;
        // $jmlBulanKedua = 0;

        // [$yearMulai, $monthMulai, $dayMulai] = explode('-', $tglMulai);
        // [$yearAkhir, $monthAkhir, $dayAkhir] = explode('-', $tglAkhir);

        // cek bulan awal dan akhir sama atau tidak
        // if($monthMulai == $monthAkhir) {
        //     //kalau sama cek tgl akhir < 28 atau tidak
        //     if($dayAkhir < $dayMulai) return back()->with('error', 'Tanggal Akhir tidak boleh lebih rendah dari tanggal mulai');

        //     if($dayAkhir <= 28) {
        //         $jmlBulanPertama = jumlahHari($tglMulai, $tglAkhir);
        //     } else {
        //         $jmlBulanPertama = jumlahHari($tglMulai, "$yearAkhir-$monthAkhir-28");
        //         $jmlBulanKedua = jumlahHari("$yearAkhir-$monthAkhir-29", $tglAkhir);
        //         dd([
        //             'bulanPertama'  => $jmlBulanPertama,
        //             'bulanKedua'    => $jmlBulanKedua
        //         ]);
        //     }
        // } else {
        //     if($monthAkhir > $monthMulai) {
        //         $jmlBulanPertama = jumlahHari($tglMulai, "$yearMulai-$monthMulai-28");
        //         $jmlBulanKedua = jumlahHari("$yearMulai-$monthMulai-29", $tglAkhir);

        //         dd([
        //             'bulanPertama'  => $jmlBulanPertama,
        //             'bulanKedua'    => $jmlBulanKedua
        //         ]);
        //     } else {
        //         if($yearAkhir > $yearMulai) {

        //         } else {
        //             return back()->with('error', 'Tanggal Akhir tidak boleh lebih rendah dari tanggal mulai');
        //         }
        //     }
        // }

        try {
            $validatedData = $request->validate([
                'nik'               => 'required',
                'tgl_mulai_izin'    => 'required|date',
                'tgl_akhir_izin'    => 'required|date',
                'keterangan'        => 'required',
                'lampiran'          => 'required|file|max:2048|mimes:pdf,jpg,jpeg,png',
                'bulan_pertama'     => 'required|numeric|min:0',
                'bulan_kedua'       => 'required|numeric|min:0',
            ]);

            // cek tgl akhir tidak boleh < tgl mulai
            if(strtotime($request->tgl_akhir_izin) < strtotime($request->tgl_mulai_izin)) return back()->with('error', 'Tanggal akhir tidak boleh sebelum tanggal mulai!');

            $validatedData['status'] = $request->status;
            $validatedData['status_approved'] = 5;
            $validatedData['create_status'] = 2;

            // hitung jumlah hari
            $tglAwal = $request->tgl_mulai_izin;
            $tglAkhir = (!empty($request->tgl_akhir_izin)) ? $request->tgl_akhir_izin : $tglAwal;

            $validatedData['jumlah_hari'] = jumlahHari($tglAwal, $tglAkhir);

            $path = $request->file('lampiran')->store("izin/$request->nik", 'public');
            $validatedData['lampiran'] = $path;

            Pengajuanizin::create($validatedData);

            return back()->with('success', 'Data berhasil ditambah!');
        } catch (Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    public function deleteIzinAdmin(Request $request)
    {
        try {
            Pengajuanizin::where('id', $request->izin_id)->delete();
            return back()->with('success', 'Data berhasil dihapus!');
        } catch (Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    public function getDataIzinEdit(Request $request)
    {
        try {
            $dataIzin = Pengajuanizin::with(['karyawan', 'jenisizin'])
                    ->where('id', $request->izinId)
                    ->first();

            return [
                'error'     => false,
                'dataIzin'  => $dataIzin
            ];

        } catch (Exception $e) {
            return [
                'error'     => true,
                'message'   => 'Data gagal dipilih!'
            ];
        }

    }

    public function updateIzinAdmin(Request $request)
    {
        $dataIzin = Pengajuanizin::with(['karyawan', 'jenisizin'])
                    ->where('id', $request->izin_id)
                    ->first();

        try {
            $validatedData = $request->validate([
                'tgl_mulai_izin'    => 'required|date',
                'tgl_akhir_izin'    => 'required|date',
                'keterangan'        => 'required',
                'bulan_pertama'     => 'required|numeric|min:0',
                'bulan_kedua'       => 'required|numeric|min:0',
            ]);

            // cek tgl akhir tidak boleh < tgl mulai
            if(strtotime($request->tgl_akhir_izin) < strtotime($request->tgl_mulai_izin)) return back()->with('error', 'Tanggal akhir tidak boleh sebelum tanggal mulai!');

            if($request->file('lampiran')) {
                $request->validate([
                    'lampiran'          => 'file|max:2048|mimes:pdf,jpg,jpeg,png'
                ]);

                Storage::disk('public')->delete($dataIzin->lampiran);

                $path = $request->file('lampiran')->store("izin/$request->nik", 'public');
                $validatedData['lampiran'] = $path;
            }

            // hitung jumlah hari
            $tglAwal = $request->tgl_mulai_izin;
            $tglAkhir = (!empty($request->tgl_akhir_izin)) ? $request->tgl_akhir_izin : $tglAwal;

            $validatedData['jumlah_hari'] = jumlahHari($tglAwal, $tglAkhir);

            Pengajuanizin::where('id', $request->izin_id)->update($validatedData);
            return back()->with('success', 'Data berhasil diubah!');
        } catch (Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    public function izinAjax(Request $request){
        try{
            //Get Data Izin
            $dataIzin = Pengajuanizin::with(['karyawan', 'jenisizin'])
            ->where('id', $request->izinId)
            ->first();

            //Get Izin Tracking
            $izinTracking = TrackingIzin::with(['pengajuanizin'])
                ->where('pengajuan_izin_id', $request->izinId)
                ->get();

            return [
                'error'         => false,
                'dataIzin'      => $dataIzin,
                'izinTracking'  => $izinTracking,
            ];

        }catch(Exception $e){
            return [
                'error'     => true,
                'message'   => $e->getMessage(),
            ];
        }

    }

    /*=====================================
            ARDI
    =================================== */
    public function monitoring()
    {
        $data = Presensi::with(['karyawan'])
        ->whereIn('absen_in_status', [1,2,5])
        ->get();
        return view('presensi.monitoring', compact ('data'));
    }

    public function getpresensi(Request $request)
    {
        $tanggal = $request->input('tanggal');
        $data = Presensi::whereDate('tgl_presensi', $tanggal)
            ->where(function ($query) {
                $query->where('absen_in_status', 1)
                    ->orWhere('absen_in_status', 2)
                    ->orWhere('absen_in_status', 5);
            })
            ->get();
        $request->session()->put('selectedDate', $tanggal);
        return view('presensi.monitoring', compact('data'));
    }

    public function persetujuanAbsen(Request $request)
    {
        $datamasuk = Presensi::with(['karyawan'])->where('absen_in_status', '0')->paginate(5);
        $datakeluar = Presensi::with(['karyawan'])
        ->where('absen_out_status', '0')
        ->whereIn('absen_in_status', [1,2,3])
        ->paginate(5);

        $dataumlk = Presensi::with(['karyawan'])
        ->where('absen_in_status', '3')
        ->orWhere('absen_out_status', '3')
        ->paginate(5);

        $tanggalMulai = "";
        $tanggalSelesai = "";
        return view('presensi.persetujuanabsen', compact('datamasuk', 'datakeluar', 'dataumlk', 'tanggalMulai', 'tanggalSelesai'));
    }

    public function persetujuanSearch(Request $request)
    {
        $tanggalMulai = $request->input('tanggalmulai');
        $tanggalSelesai = $request->input('tanggalselesai');
        $data = Presensi::whereDate('tgl_presensi', '>=', $tanggalMulai)
                        ->whereDate('tgl_presensi', '<=', $tanggalSelesai)
                        ->where('status', '0')
                        ->get();
        return view('presensi.persetujuanabsen', compact('data', 'tanggalMulai', 'tanggalSelesai'));
    }

    public function absensiDitolak(Request $request){
        $datamasuk = Presensi::with(['karyawan'])->where('absen_in_status', '4')->paginate(5);
        $datakeluar = Presensi::with(['karyawan'])->where('absen_out_status', '4')->paginate(5);
        $tanggalMulai = "";
        $tanggalSelesai = "";
        return view('presensi.presensiditolak', compact('datamasuk', 'datakeluar', 'tanggalMulai', 'tanggalSelesai'));
    }

    public function absensiDitolakSearch(Request $request){
        $tanggalMulai = $request->input('tanggalmulai');
        $tanggalSelesai = $request->input('tanggalselesai');
        $data = Presensi::whereDate('tgl_presensi', '>=', $tanggalMulai)
                        ->whereDate('tgl_presensi', '<=', $tanggalSelesai)
                        ->where('status', '4')
                        ->get();
        return view('presensi.presensiditolak', compact('data', 'tanggalMulai', 'tanggalSelesai'));
    }

    public function izinKaryawanAdmin(){
        $namabulan = ["", "Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember"];

        return view('presensi.izin-karyawan', compact('namabulan'));
    }

    public function izinKaryawanAdminSearch(Request $request){
        $jenisizin = $request->jenisizin;
        $bulan = $request->bulan;
        $tahun = $request->tahun;
        $data = Pengajuanizin::with(['karyawan', 'jenisizin'])
            ->where('status', $jenisizin)
            // ->where('status_approved', 5)
            ->whereMonth('tgl_mulai_izin', $bulan)
            ->whereYear('tgl_mulai_izin', $tahun)
            ->get();
        return redirect('/presensi/izin/karyawan/laporan')
        ->with('data', $data)
        ->with('jenisizin', $jenisizin);
    }

    public function izinKaryawanAdminHasil(){
        $namabulan = ["", "Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember"];
        $data = session('data');
        $jenisizin = session('jenisizin');
        $karyawan = Karyawan::with(['jabatan_kerja', 'department', 'cabang', 'contract', 'oldContract'])
                    ->whereNotIn('role_id', [4,5])
                    ->where('status', 3)
                    ->get();

        return view('presensi.laporan-izin-karyawan', compact('namabulan', 'data', 'jenisizin', 'karyawan'));
    }

    /*===================================
                HARI LIBUR
    ===================================*/

    public function getHolidays(Request $request)
    {
        $year = $request->tahun;
        $response = Http::get("https://api-harilibur.vercel.app/api?year={$year}");
        $holidays = $response->json();
        foreach ($holidays as $holiday) {
            if ($holiday['is_national_holiday'] == true) {
                Holiday::updateOrCreate(
                    ['holidays_date' => $holiday['holiday_date']],
                    ['holidays_name' => $holiday['holiday_name']]
                );
            }
        }
        return back()->with('message', 'Hari libur berhasil diambil atau diupdate !');
    }

    public function hariLibur(){
        $data = Holiday::Paginate(10);
        return view('presensi.libur', compact('data'));
    }

    public function addHariLibur(Request $request){
        $data = [
            'holidays_date' => $request->tanggal,
            'holidays_name' => $request->nama,
        ];
        Holiday::create($data);
        return redirect('/presensi/hari/libur')->with('message', 'Hari libur Berhasil Ditambahkan');
    }

    public function editHariLibur(Request $request){
        $data = [
            'holidays_date' => $request->tanggal,
            'holidays_name' => $request->nama,
        ];
        Holiday::where('id', $request->id)->update($data);
        return redirect('/presensi/hari/libur')->with('message', 'Hari libur Berhasil Diubah');
    }

    public function hapusHariLibur(string $id){
        $data = Holiday::find($id);
        $data->delete();
        return redirect('/presensi/hari/libur')->with('message', 'Hari libur Berhasil Dihapus');
    }

    //===================================================================

    //=====================Persetujuan Absensi Masuk dan Pulang=====================//

    public function persetujuanMasukTolak(string $id, Request $request){
        $data = Presensi::find($id);
        $data->ket_in_tolak = $request->keterangan;
        $data->absen_in_status = 4;
        $data->save();
        return redirect('/presensi/persetujuan')->with('message', 'Absen Ditolak !');
    }

    public function persetujuanMasukTerima(string $id, Request $request){
        $data = Presensi::find($id);
        $data->is_late = $request->terlambat;
        if($data->absen_in_zone == 1){
            $data->absen_in_status = 2;
        }else{
            $data->absen_in_status = 3;
        }
        $data->save();
        return redirect('/presensi/persetujuan')->with('message', 'Absen Diterima !');
    }

    public function persetujuanPulangTolak(string $id, Request $request){
        $data = Presensi::find($id);
        $data->ket_out_tolak = $request->keterangan;
        $data->absen_out_status = 4;
        $data->save();
        return redirect('/presensi/persetujuan')->with('message', 'Absen Ditolak !');
    }

    public function persetujuanPulangTerima(string $id, Request $request){
        $data = Presensi::find($id);
        $data->early_out = $request->pulangcepat;
        if($data->absen_out_zone == 1){
            $data->absen_out_status = 2;
        }else{
            $data->absen_out_status = 3;
        }
        $data->save();
        return redirect('/presensi/persetujuan')->with('message', 'Absen Diterima !');
    }

    //======= Pemberian UMLK =======//

    public function addEmployeeUMLK(string $id, Request $request){
        $data = Presensi::find($id);
        $data->meal_num = $request->jumlah;
        $data->absen_in_status = 5;
        $data->absen_out_status = 5;
        $data->save();
        return redirect('/presensi/persetujuan')->with('message', 'UMLK Berhasil Ditambahkan !');
    }


    public function absensiMasukDitolakTerima(string $id, Request $request){
        $data = Presensi::find($id);
        $data->is_late = $request->terlambat;
        if($data->absen_in_zone == 1){
            $data->absen_in_status = 2;
        }else{
            $data->absen_in_status = 3;
        }
        $data->save();
        return redirect('/presensi/penolakan')->with('message', 'Absen Masuk Diterima !');
    }

    public function absensiPulangDitolakTerima(string $id, Request $request){
        $data = Presensi::find($id);
        $data->early_out = $request->pulangcepat;
        if($data->absen_out_zone == 1){
            $data->absen_out_status = 2;
        }else{
            $data->absen_out_status = 3;
        }
        $data->save();
        return redirect('/presensi/penolakan')->with('message', 'Absen Pulang Diterima !');
    }

    public function absensiDitolakHapus(string $id){
        $data = Presensi::find($id);
        $data->delete();
        return redirect('/presensi/penolakan')->with('message', 'Absensi Berhasil Dihapus');
    }

    public function absensiMapKaryawan(string $id){
        $data = Presensi::find($id);
        return view('presensi.mapkaryawan', compact('data'));
    }

    public function absensiMapKaryawanPulang(string $id){
        $data = Presensi::find($id);
        return view('presensi.mapkaryawanpulang', compact('data'));
    }
}
