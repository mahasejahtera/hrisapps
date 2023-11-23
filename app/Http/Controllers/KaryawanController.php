<?php

namespace App\Http\Controllers;

use App\Models\Cabang;
use App\Models\Departemen;
use App\Models\Jabatan;
use App\Models\Karyawan;
use App\Models\KaryawanBiodata;
use App\Models\KaryawanChildren;
use App\Models\KaryawanContract;
use App\Models\KaryawanDocument;
use App\Models\KaryawanEducation;
use App\Models\KaryawanFamily;
use App\Models\KaryawanJobdesk;
use App\Models\KaryawanSibling;
use App\Models\KaryawanTransfer;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Yajra\DataTables\Facades\DataTables;

class KaryawanController extends Controller
{
    private $suratController;

    public function __construct()
    {
        $this->suratController = new SuratController();
    }

    /*===========================================
                    DATATABLE
    ===========================================*/
    public function karyawanDatatable(Request $request)
    {
        if($request->ajax()) {
            $karyawan = Karyawan::with(['jabatan_kerja', 'department', 'cabang', 'contract', 'oldContract']);

            if($request->jenisKontrak) {
                $karyawan = $karyawan->join('karyawan_contract as kc', 'kc.id', '=', 'karyawan.contract_id')
                            ->where('kc.contract_status', $request->jenisKontrak);
            }

            if($request->department) {
                $karyawan = $karyawan->join('karyawan_contract as kc', 'kc.id', '=', 'karyawan.contract_id')
                            ->where('kc.department_id', $request->department);
            }

            if(!is_null($request->status)) {
                $karyawan = $karyawan->where('status', $request->status);
            }

            return DataTables::of($karyawan)
                    ->addIndexColumn()
                    ->addColumn('statuslabel', function(Karyawan $d) {
                        $status = '';

                        if($d->status == 0) $status = '<p class="text-danger">Verifikasi Register</p>';
                        if($d->status == 1) $status = '<p class="text-secondary">Pengisian Data</p>';
                        if($d->status == 2) $status = '<p class="text-primary">Verifikasi Data</p>';
                        if($d->status == 3) $status = '<p class="text-success">Aktif</p>';
                        if($d->status == 4) $status = '<p class="text-danger">Nonaktif</p>';

                        return $status;
                    })
                    ->addColumn('contract.jabatan', function(Karyawan $karyawan) {
                        $kry = $karyawan->select('jbt.nama_jabatan')->join('karyawan_contract as kc', 'kc.id', '=', 'karyawan.contract_id')
                                        ->join('jabatan as jbt', 'jbt.id', '=', 'kc.jabatan_id')
                                        ->where('kc.karyawan_id', $karyawan->id)
                                        ->first();

                        return $kry;
                    })
                    ->addColumn('action', function(Karyawan $d) {
                        $action = '<span class="dropdown">
                                        <button class="btn dropdown-toggle align-text-top" data-bs-boundary="viewport" data-bs-toggle="dropdown">Actions</button>
                                        <div class="dropdown-menu dropdown-menu-end">';

                                        $statusAction = '';

                                        if($d->status == 0) $statusAction =  "<a class='dropdown-item btn-verification' data-status='register' data-karyawan='$d->id' data-email='$d->email' href='#'>
                                                                                Verifikasi Register
                                                                            </a>";
                                        if($d->status == 2) $statusAction =  "<a class='dropdown-item btn-verification' data-status='data' data-karyawan='$d->id' data-email='$d->email' href='#'>
                                                                                Verifikasi Data
                                                                            </a>";
                                        if($d->status == 3) $statusAction =  "<a class='dropdown-item btn-verification' data-status='aktif' data-karyawan='$d->id' data-email='$d->email' href='#'>
                                                                                Nonaktifkan
                                                                            </a>";
                                        if ($d->status == 4) $statusAction = "<a class='dropdown-item btn-verification' data-status='nonaktif' data-karyawan='$d->id' data-email='$d->email' href='#'>
                                                                                Aktif
                                                                            </a>";

                        $action .= $statusAction;

                        $action .= '<a class="dropdown-item" href="' .route("admin.karyawan.detail", $d->email) .'">
                                        Detail
                                    </a>
                                    <a class="dropdown-item" href="'. route("karyawan.jamkerja", $d->email) .'">
                                        Set Jam Kerja
                                    </a>';

                        if ($d->status == 3) {
                            $action .= '<a class="dropdown-item transfer-action" data-karyawan="'. $d->id .'" href="#">
                                            Transfer
                                        </a>';
                        }

                        $action .= '<a class="dropdown-item" href="'. route("karyawan.delete", $d->id) .'">
                                        Hapus
                                    </a>
                                    <a class="dropdown-item btn-change-password" data-karyawan="'. $d->id .'" href="#">
                                        Ubah Password
                                    </a>
                                </div>
                            </span>';

                        return $action;
                    })
                    ->rawColumns(['statuslabel', 'action'])
                    ->make(true);
        }
    }

    // ==================================================

    public function index(Request $request)
    {

        $query = Karyawan::query();
        $query->select('karyawan.*', 'nama_dept', 'nama_jabatan');
        $query->join('departemen', 'karyawan.kode_dept', '=', 'departemen.id');
        $query->join('jabatan', 'karyawan.jabatan', '=', 'jabatan.id');
        $query->orderBy('nama_lengkap');
        if (!empty($request->nama_karyawan)) {
            $query->where('nama_lengkap', 'like', '%' . $request->nama_karyawan . '%');
        }

        if (!empty($request->kode_dept)) {
            $query->where('karyawan.kode_dept', $request->kode_dept);
        }
        $karyawan = $query->paginate(10);

        $departemen = DB::table('departemen')->get();
        $cabang = DB::table('cabang')->orderBy('kode_cabang')->get();
        return view('karyawan.index', compact('karyawan', 'departemen', 'cabang'));
    }

    public function karyawanDataRegister(Request $request)
    {
        $karyawanData = Karyawan::with(['jabatan_kerja', 'department', 'cabang', 'contract'])->where('id', $request->id)->get();

        $data = [
            'id'            => $karyawanData[0]->id,
            'nama'          => $karyawanData[0]->nama_lengkap,
            'nik'           => $karyawanData[0]->nik,
            'email'         => $karyawanData[0]->email,
            'jabatan'       => $karyawanData[0]->jabatan_kerja->nama_jabatan,
            'departemen'    => $karyawanData[0]->department->nama_dept,
        ];

        return $data;
    }

    public function karyawanData(Request $request)
    {
        $karyawanData = Karyawan::with(['jabatan_kerja', 'department', 'cabang', 'contract'])->where('id', $request->id)->get();

        $data = [
            'id'            => $karyawanData[0]->id,
            'nama'          => $karyawanData[0]->nama_lengkap,
            'nik'           => $karyawanData[0]->nik,
            'email'         => $karyawanData[0]->email,
            'jabatan'       => $karyawanData[0]->contract->jabatan->nama_jabatan,
            'departemen'    => $karyawanData[0]->contract->department->nama_dept,
            'cabang'        => $karyawanData[0]->cabang->nama_cabang,
            'status'        => Str::title($karyawanData[0]->contract->contract_status),
            'salary'        => 'Rp. ' . number_format($karyawanData[0]->contract->salary, 0, ',', '.'),
        ];

        return $data;
    }


    public function karyawanDetail(Karyawan $karyawan)
    {
        $data = [
            'title'                 => 'Admin - Detail Karyawan | PT. Maha Akbar Sejahtera',
            'karyawan'              => $karyawan,
            'karyawanBiodata'       => KaryawanBiodata::with(['karyawan'])->where('karyawan_id', $karyawan->id)->get(),
            'karyawanChildren'      => KaryawanChildren::with(['karyawan'])->where('karyawan_id', $karyawan->id)->get(),
            'karyawanDocument'      => KaryawanDocument::with(['karyawan'])->where('karyawan_id', $karyawan->id)->get(),
            'karyawanEducation'     => KaryawanEducation::with(['karyawan'])->where('karyawan_id', $karyawan->id)->get(),
            'karyawanFamily'        => KaryawanFamily::with(['karyawan'])->where('karyawan_id', $karyawan->id)->get(),
            'karyawanSibling'       => KaryawanSibling::with(['karyawan'])->where('karyawan_id', $karyawan->id)->get(),
        ];

        return view('karyawan.detail', $data);
    }


    public function kontrakKerjaKaryawan(Karyawan $karyawan)
    {
        $data = [
            'title'             => 'Kontrak Kerja Karyawan | PT. Maha Akbar Sejahtera',
            'karyawan'          => $karyawan,
            'karyawanBiodata'   => KaryawanBiodata::with(['karyawan'])->where('karyawan_id', $karyawan->id)->get(),
            'karyawanEducation' => KaryawanEducation::with(['karyawan'])->where('karyawan_id', $karyawan->id)->get(),
            'karyawanJobdesk'   => KaryawanJobdesk::with(['karyawan'])->where('karyawan_id', $karyawan->id)->get(),
        ];

        return view('karyawan.show-contract', $data);
    }


    public function storeKontrakKerja(Karyawan $karyawan, Request $request)
    {
        try {
            $request->validate([
                'kontrak_kerja'     => 'required|mimes:pdf|file|max:5120'
            ]);

            // upload file
            $path = $request->file('kontrak_kerja')->store("kontrak/karyawan/$karyawan->id", 'public');

            // update
            $data = [
                'contract_file' => $path
            ];
            KaryawanContract::where('id', $karyawan->contract->id)->update($data);
            return back()->with('success', "Kontrak $karyawan->nama_lengkap berhasil di upload!");
        } catch (Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }




    /*=========================================
                Verifikasi
    ======================================= */

    public function verificationRegister(Request $request)
    {

        try {
            $validatedData = $request->validate([
                'nik'               => 'required|unique:karyawan,nik',
                'status_karyawan'   => 'required',
                'salary'            => 'required|numeric|max:999999999',
                'kontrak_tampil'    => 'required',
            ]);

            // if($request->status_karyawan == 'tetap') {
            //     $request->validate([
            //         'kontrak_tampil'     => 'required',
            //     ]);
            //     $validatedData['kontrak_tampil'] = $request->kontrak_tampil;
            // }

            if($request->status_karyawan == 'pkwt' || $request->status_karyawan == 'percobaan') {
                $request->validate([
                    'lama_kontrak_num'      => 'required',
                    'lama_kontrak_waktu'    => 'required',
                    'mulai_kontrak'         => 'required',
                    'akhir_kontrak'          => 'required'
                ]);
            }

            if($request->status_karyawan == 'project') {
                $request->validate([
                    'project'           => 'required',
                    'mulai_kontrak'     => 'required',
                ]);
            }

            if($request->status_karyawan == 'harian') {
                $request->validate([
                    'mulai_kontrak'     => 'required',
                ]);
            }

            $validatedData['status'] = 1;
            $validatedData['project'] = $request->project;
            $validatedData['lama_kontrak_num'] = $request->lama_kontrak_num;
            $validatedData['lama_kontrak_waktu'] = $request->lama_kontrak_waktu;
            $validatedData['mulai_kontrak'] = $request->mulai_kontrak;
            $validatedData['akhir_kontrak'] = $request->akhir_kontrak;
            $validatedData['jobdesk_content'] = $request->jobdesk_content;
            $validatedData['karyawan_id'] = $request->karyawan_id;

            $karyawan = Karyawan::with(['jabatan_kerja', 'department', 'cabang'])->where('id', $request->karyawan_id)->get();
            $karyawan = $karyawan[0];


            //========================
                /* NO SURAT */
            //========================

            $noSuratKontrak = null;
            $kodeSuratKontrak = 'SPK.K';
            $kodeSuratPernyataan = 'SPT';

            // SURAT KONTRAK
            if($request->kontrak_tampil == 1) {
                $noSuratKontrak = $this->suratController->getNoSuratBaruPerusahaan($kodeSuratKontrak);

                //create surat kontrak
                $dataSuratKontrak = [
                    'karyawan_penerima_id'      => $request->karyawan_id,
                    'kategori_kode'             => $kodeSuratKontrak,
                    'no_surat'                  => $noSuratKontrak,
                    'perihal'                   => "Kontrak Kerja $karyawan->nama_lengkap"
                ];

                $this->suratController->storeSurat($dataSuratKontrak);
            }

            // SURAT PERNYATAAN
            $noSuratPernyataan = $this->suratController->getNoSuratBaruPerusahaan($kodeSuratPernyataan);

            $dataSuratPernyataan = [
                'karyawan_penerima_id'      => $request->karyawan_id,
                'kategori_kode'             => $kodeSuratPernyataan,
                'no_surat'                  => $noSuratPernyataan,
                'perihal'                   => "Surat Pernyataan $karyawan->nama_lengkap",
                'keterangan'                => 'Pernyataan saat awal register pada aplikasi HRIS PT. Maha Akbar Sejahtera'
            ];

            $this->suratController->storeSurat($dataSuratPernyataan);

            // ===========================


            // contract data
            $dataKontrak = [
                'karyawan_id'               => $request->karyawan_id,
                'no_surat'                  => $noSuratKontrak,
                'jabatan_id'                => $karyawan->jabatan,
                'department_id'             => $karyawan->kode_dept,
                'kode_cabang'               => $karyawan->kode_cabang,
                'contract_status'           => $request->status_karyawan,
                'salary'                    => $request->salary,
                'project'                   => $request->project,
                'lama_kontrak_num'          => $request->lama_kontrak_num,
                'lama_kontrak_waktu'        => $request->lama_kontrak_waktu,
                'mulai_kontrak'             => $request->mulai_kontrak,
                'akhir_kontrak'             => $request->akhir_kontrak,
                'jobdesk_content'           => $request->jobdesk_content,
            ];

            // get contract
            $karyawanContract = KaryawanContract::with(['karyawan', 'jabatan', 'department', 'cabang'])->where('id', $karyawan->contract_id)->get();

            if(count($karyawanContract) > 0) {
                $newContract = KaryawanContract::where('id', $karyawanContract[0]->id)->update($dataKontrak);
                $contractId = $karyawanContract[0]->id;
            } else {
                $newContract = KaryawanContract::create($dataKontrak);
                $contractId = $newContract->id;
            }

            $karyawanData = [
                'nik'                           => $request->nik,
                'no_surat_pakta_integritas'     => $noSuratPernyataan,
                'contract_id'                   => $contractId,
                'kontrak_tampil'                => $request->kontrak_tampil,
                'status'                        => 1
            ];

            Karyawan::where('id', $request->karyawan_id)->update($karyawanData);
            return back()->with('success', 'Data berhasil diupdate!');
        } catch (Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }


    public function verificationData(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'kode_surat_karyawan'   => 'required|min:2|max:2|unique:karyawan,kode_surat_karyawan'
            ]);

            $validatedData['kode_surat_karyawan'] = Str::upper($request->kode_surat_karyawan);
            $validatedData['status'] = 3;

            // get karyawan data
            $karyawan = Karyawan::with(['jabatan_kerja', 'department', 'cabang', 'contract', 'oldContract'])
                        ->where('id', $request->karyawan_id)
                        ->first();
            // get karyawan contract
            $karyawanContract = KaryawanContract::with(['karyawan', 'jabatan', 'department', 'cabang'])
                                ->where('id', $karyawan->contract_id)->first();


            if($karyawan->kontrak_tampil == 1) {

                $atasanApprove = Karyawan::with(['jabatan_kerja', 'department', 'cabang', 'contract', 'oldContract'])
                                        ->where('role_id', 4)
                                        ->where('status', 3)
                                        ->orderBy('id', 'desc')
                                        ->first();

                // set atasan approve di karyawan contract database
                $karyawanContract->id_atasan_approve = $atasanApprove->id;
                $karyawanContract->jabatan_atasan_approve = $atasanApprove->contract->jabatan_id;
                $karyawanContract->save();

                // get atasan approve contract
                // cek bukan direktur dan komisaris
                // if($karyawan->role_id != 4 && $karyawan->role_id != 5) {
                //     // kalau bukan direktur dan komisaris cek apakah dia manager hrd
                //     if($karyawan->role_id == 2 && $karyawanContract->department_id == 9) {
                //         //get atasan approve nya direktur
                //         $atasanApprove = Karyawan::with(['jabatan_kerja', 'department', 'cabang', 'contract', 'oldContract'])
                //                         ->where('role_id', 4)
                //                         ->where('status', 3)
                //                         ->orderBy('id', 'desc')
                //                         ->first();

                //         // set atasan approve di karyawan contract database
                //         $karyawanContract->id_atasan_approve = $atasanApprove->id;
                //         $karyawanContract->jabatan_atasan_approve = $atasanApprove->contract->jabatan_id;
                //         $karyawanContract->save();

                //     } else {
                //         $atasanApprove = Karyawan::with(['jabatan_kerja', 'department', 'cabang', 'contract', 'oldContract'])
                //                 ->select('karyawan.*', 'jabatan.id as id_jbt')
                //                 ->join('karyawan_contract', 'karyawan.contract_id', '=', 'karyawan_contract.id')
                //                 ->join('jabatan', 'karyawan_contract.jabatan_id', '=', 'jabatan.id')
                //                 ->where('karyawan.role_id', 2)
                //                 ->where('karyawan_contract.department_id', 9)
                //                 ->where('karyawan.status', 3)
                //                 ->orderBy('karyawan.id', 'desc')
                //                 ->first();

                //         // set atasan approve di karyawan contract database
                //         $karyawanContract->id_atasan_approve = $atasanApprove->id;
                //         $karyawanContract->jabatan_atasan_approve = $atasanApprove->id_jbt;
                //         $karyawanContract->save();
                //     }

                // }
            }

            Karyawan::where('id', $request->karyawan_id)->update($validatedData);

            return back()->with('success', 'Data karyawan berhasil di verifikasi');
        } catch (Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    // public function nonaktifkanKaryawan(Request $request)
    // {
    //     try{
    //         Karyawan::where('id', $request->karyawan_id)->update(['status' => 4]);
    //         return back()->with('success', 'Karyawan berhasil dinonaktifkan!');
    //     } catch (Exception $e) {
    //         return back()->with('error', 'Karyawan gagal dinonaktifkan!');
    //     }
    // }



    /* ===================================
                    JOBDESK
     ===================================== */

     public function karyawanJobdesk(Karyawan $karyawan)
     {
        $data = [
            'title'     => 'Admin - Jobdesk | PT. Maha Akbar Sejahtera',
            'karyawan'  => $karyawan,
            'jobdesk'   => KaryawanJobdesk::with(['karyawan'])->where('karyawan_id', $karyawan->id)->get()
        ];

        return view('karyawan.jobdesk', $data);
     }


     public function karyawanJobdeskStore(Request $request)
     {
        $jobdesk = $request->jobdesk;

        try {
            for($i=0; $i < count($jobdesk); $i++) {
                if(!empty($jobdesk[$i])) {
                    $data = [
                        'karyawan_id'   => $request->karyawan_id,
                        'jobdesk'       => $jobdesk[$i]
                    ];

                    KaryawanJobdesk::create($data);
                }
            }

            return back()->with('success', "Jobdesk berhasil ditambah!");
        } catch (Exception $e) {
            return back()->with('error', "Hanya berhasil menambah $i jobdesk dari " . count($jobdesk) . " total inputan!");
        }
     }

     public function karyawanJobdeskDestroy(Request $request)
     {
        try{
            KaryawanJobdesk::where('id', $request->jobdesk_id)->delete();
            return back()->with('success', 'Jobdesk berhasil dihapus!');
        } catch (Exception $e) {
            return back()->with('error', 'Jobdesk gagal dihapus!');
        }

     }


     public function getKaryawanJobdeskById(Request $request)
     {
        try {
            $karyawanJobdesk = KaryawanJobdesk::with(['karyawan'])->where('id', $request->value)->get();

            return [
                'error'     => false,
                'jobdesk'   => [
                    'id'        => $karyawanJobdesk[0]->id,
                    'jobdesk'   => $karyawanJobdesk[0]->jobdesk
                ]
            ];
            ;
        } catch (Exception $e) {
            return [
                'error'     => true,
                'message'   => $e->getMessage()
            ];
        }
     }


     public function karyawanJobdeskUpdate(Request $request)
     {
        try {
            KaryawanJobdesk::where('id', $request->jobdesk_id)->update(['jobdesk'   => $request->jobdesk]);
            return back()->with('success', 'Jobdesk berhasil diubah!');
        } catch (Exception $e) {
            return back()->with('error', 'Jobdesk gagal diubah!');
        }
     }


    //  ========================================================

    public function store(Request $request)
    {
        $nik = $request->nik;
        $nama_lengkap = $request->nama_lengkap;
        $jabatan = $request->jabatan;
        $no_hp = $request->no_hp;
        $kode_dept = $request->kode_dept;
        $password = Hash::make('12345');
        $kode_cabang = $request->kode_cabang;
        if ($request->hasFile('foto')) {
            $foto = $nik . "." . $request->file('foto')->getClientOriginalExtension();
        } else {
            $foto = null;
        }

        try {
            $data =  [
                'nik' => $nik,
                'nama_lengkap' => $nama_lengkap,
                'jabatan' => $jabatan,
                'no_hp' => $no_hp,
                'kode_dept' => $kode_dept,
                'foto' => $foto,
                'password' => $password,
                'kode_cabang' => $kode_cabang
            ];
            $simpan = DB::table('karyawan')->insert($data);
            if ($simpan) {
                if ($request->hasFile('foto')) {
                    $folderPath = "public/uploads/karyawan/";
                    $request->file('foto')->storeAs($folderPath, $foto);
                }
                return Redirect::back()->with(['success' => 'Data Berhasil Disimpan']);
            }
        } catch (Exception $e) {

            if ($e->getCode() == 23000) {
                $message = "Data dengan Nik " . $nik . " Sudah Ada";
            } else {
                $message = "Hubungi IT";
            }
            return Redirect::back()->with(['warning' => 'Data Gagal Disimpan ' . $message]);
        }
    }

    public function edit(Request $request)
    {
        $nik = $request->nik;
        $departemen = DB::table('departemen')->get();
        $cabang = DB::table('cabang')->orderBy('kode_cabang')->get();
        $karyawan = DB::table('karyawan')->where('nik', $nik)->first();
        return view('karyawan.edit', compact('departemen', 'karyawan', 'cabang'));
    }

    public function update($nik, Request $request)
    {
        $nik = $request->nik;
        $nama_lengkap = $request->nama_lengkap;
        $jabatan = $request->jabatan;
        $no_hp = $request->no_hp;
        $kode_dept = $request->kode_dept;
        $kode_cabang = $request->kode_cabang;
        $password = Hash::make('12345');
        $old_foto = $request->old_foto;
        if ($request->hasFile('foto')) {
            $foto = $nik . "." . $request->file('foto')->getClientOriginalExtension();
        } else {
            $foto = $old_foto;
        }

        try {
            $data =  [
                'nama_lengkap' => $nama_lengkap,
                'jabatan' => $jabatan,
                'no_hp' => $no_hp,
                'kode_dept' => $kode_dept,
                'foto' => $foto,
                'password' => $password,
                'kode_cabang' => $kode_cabang
            ];
            $update = DB::table('karyawan')->where('nik', $nik)->update($data);
            if ($update) {
                if ($request->hasFile('foto')) {
                    $folderPath = "public/uploads/karyawan/";
                    $folderPathOld = "public/uploads/karyawan/" . $old_foto;
                    Storage::delete($folderPathOld);
                    $request->file('foto')->storeAs($folderPath, $foto);
                }
                return Redirect::back()->with(['success' => 'Data Berhasil Update']);
            }
        } catch (Exception $e) {
            //dd($e->message);
            return Redirect::back()->with(['warning' => 'Data Gagal Diupdate']);
        }
    }

    // public function delete($nik)
    // {
    //     $delete = DB::table('karyawan')->where('nik', $nik)->delete();
    //     if ($delete) {
    //         return Redirect::back()->with(['success' => 'Data Berhasil Dihapus']);
    //     } else {
    //         return Redirect::back()->with(['warning' => 'Data Gagal Dihapus']);
    //     }
    // }





    /*============================================================
                        KARYAWAN TRANSFER
    ============================================================*/

    public function karyawanTrnaferStore(Request $request)
    {
        $request->validate([
            'status_transfer'       => 'required'
        ]);


        $statusTransfer = $request->status_transfer;
        $karyawanId = $request->karyawan_id;

        // get karyawan
        $karyawan = Karyawan::with(['jabatan_kerja', 'department', 'cabang', 'contract'])->where('id', $karyawanId)->get();

        // mutasi
        if($statusTransfer == 1) {
            $request->validate([
                'cabang'       => 'required'
            ]);


            $newCabang = $request->cabang;
            $oldCabang = $karyawan[0]->contract->kode_cabang;
            $contractId = $karyawan[0]->contract_id;

            try {

                $data = [
                    'karyawan_id'           => $karyawanId,
                    'status'                => 1,
                    'old_branch_mutation'   => $oldCabang,
                    'new_branch_mutation'   => $newCabang,
                    'contract_id'           => $contractId
                ];
                // create mutasi transfer
                KaryawanTransfer::create($data);
                // update cabang karyawab
                Karyawan::where('id', $karyawanId)->update(['kode_cabang' => $newCabang]);

                return back()->with('success', $karyawan[0]->nama_lengkap . ' berhasil dimutasi!');
            } catch (Exception $e) {
                return back()->with('error', $karyawan[0]->nama_lengkap . ' gagal dimutasi...!!!');
            }
        }

        // promosi / demosi
        if($statusTransfer == 2 || $statusTransfer == 3) {
            // validate input
            $request->validate([
                'department_id'             => 'required',
                'jabatan_id'                => 'required',
                'cabang'                    => 'required',
                'status_karyawan'           => 'required',
                'salary'                    => 'required',
                'jobdesk_content'           => 'required'
            ]);

            $statusKaryawan = $request->status_karyawan;


            if($statusKaryawan == 'pkwt' || $statusKaryawan == 'percobaan') {
                $request->validate([
                    'lama_kontrak_num'      => 'required',
                    'lama_kontrak_waktu'    => 'required',
                    'mulai_kontrak'         => 'required',
                    'akhir_kontrak'         => 'required'
                ]);
            }

            if($statusKaryawan == 'project') {
                $request->validate([
                    'project'           => 'required',
                    'mulai_kontrak'     => 'required',
                ]);
            }

            if($statusKaryawan == 'harian') {
                $request->validate([
                    'mulai_kontrak'     => 'required',
                ]);
            }


            // data kontrak
            $dataKontrak = [
                'karyawan_id'           => $karyawanId,
                'jabatan_id'            => $request->jabatan_id,
                'department_id'         => $request->department_id,
                'kode_cabang'           => $request->cabang,
                'contract_status'       => $statusKaryawan,
                'salary'                => $request->salary,
                'project'               => $request->project,
                'lama_kontrak_num'      => $request->lama_kontrak_num,
                'lama_kontrak_waktu'    => $request->lama_kontrak_waktu,
                'mulai_kontrak'         => $request->mulai_kontrak,
                'akhir_kontrak'         => $request->akhir_kontrak,
                'jobdesk_content'       => $request->jobdesk_content
            ];

            //status transfer ;abel
            $statusTransferLabel = '';

            if($statusTransfer == 2) $statusTransferLabel = 'promosi';
            if($statusTransfer == 3) $statusTransferLabel = 'demosi';

            try {
                // create new contract
                $newContract = KaryawanContract::create($dataKontrak);
                $newContractId = $newContract->id;

                $oldContractId = $karyawan[0]->contract_id;

                // update karyawan
                $dataKaryawanUpdate = [
                    'contract_id'       => $newContractId,
                    'old_contract_id'   => $oldContractId
                ];

                Karyawan::where('id', $karyawanId)->update($dataKaryawanUpdate);

                // create transfer
                $dataTransfer = [
                    'karyawan_id'           => $karyawanId,
                    'status'                => $statusTransfer,
                    'old_contract_id'       => $oldContractId,
                    'contract_id'           => $newContractId
                ];

                KaryawanTransfer::create($dataTransfer);
                return back()->with('success', $karyawan[0]->nama_lengkap . " berhasil di$statusTransferLabel...!!!");

            } catch (Exception $e) {
                return back()->with('error', $karyawan[0]->nama_lengkap . " gagal di$statusTransferLabel...!!!");
            }
        }
    }

    //change password
    public function changePasswordKaryawanPanel(Request $request)
    {
        try {
            //get karyawan
            $karyawan = Karyawan::with(['jabatan_kerja', 'department', 'cabang', 'contract', 'oldContract'])
                        ->where('id', $request->karyawan_id)
                        ->first();

            $karyawan->password = password_hash($request->new_password, PASSWORD_DEFAULT);
            $karyawan->save();
            return back()->with('success', "Password $karyawan->nama_lengkap berhasil diubah!");

        } catch (Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }


    /*============================================================
                        ADMIN PANEL
    ============================================================*/
    public function createKaryawanAdmin()
    {
        $data = [
            'title'             => 'Tambah Karyawan Harian | PT. Maha Akbar Sejahtera'
        ];
    }


    /*============================================================
                        FRONT END USER
    ============================================================*/

    public function profile(Karyawan $karyawan)
    {
        $data = [
            'title'             => 'Profil Karyawan | PT. Maha Akbar Sejahtera',
            'karyawan'          => $karyawan,
            'karyawanBiodata'   => KaryawanBiodata::with(['karyawan'])->where('karyawan_id', $karyawan->id)->get(),
            'karyawanChildren'  => KaryawanChildren::with(['karyawan'])->where('karyawan_id', $karyawan->id)->get(),
            'karyawanDocument'  => KaryawanDocument::with(['karyawan'])->where('karyawan_id', $karyawan->id)->get(),
            'karyawanEducation' => KaryawanEducation::with(['karyawan'])->where('karyawan_id', $karyawan->id)->get(),
            'karyawanFamily'    => KaryawanFamily::with(['karyawan'])->where('karyawan_id', $karyawan->id)->get(),
            'karyawanSibling'   => KaryawanSibling::with(['karyawan'])->where('karyawan_id', $karyawan->id)->get(),
        ];


        return view('frontend.karyawan.profiledata', $data);
    }


    public function kontrakKerja(Karyawan $karyawan)
    {

        $data = [
            'title'             => 'Kontrak Kerja | PT. Maha Akbar Sejahtera',
            'karyawan'          => $karyawan,
            'karyawanBiodata'   => KaryawanBiodata::with(['karyawan'])->where('karyawan_id', $karyawan->id)->get(),
            'karyawanEducation' => KaryawanEducation::with(['karyawan'])->where('karyawan_id', $karyawan->id)->get(),
            'karyawanJobdesk'   => KaryawanJobdesk::with(['karyawan'])->where('karyawan_id', $karyawan->id)->get(),
        ];

        return view('frontend.karyawan.show-contract', $data);
    }


    public function changePassword()
    {
        $data = [
            'title'     => 'Ubah Password | PT. Maha Akbar Sejahtera'
        ];

        return view('frontend.karyawan.change-password', $data);
    }

    public function storeChangePassword(Request $request)
    {
        // try {
            //validate
            $request->validate([
                'old_password'      => 'required',
                'password'          => 'required|min:6|confirmed'
            ]);

            // cek password lama sama atau tidak
            if(!Hash::check($request->old_password, Auth::guard('karyawan')->user()->password)) {
                return back()->with('error', 'Password lama anda salah!');
            }

            // kalau password baru sama dengan yang lama
            if(strcmp($request->old_password, $request->password) == 0) {
                return back()->with('error', 'Password baru anda tidak boleh sama dengan yang lama!');
            }

            $data = [
                'password'  => Hash::make($request->password)
            ];

            Karyawan::where('email', Auth::guard('karyawan')->user()->email)->update($data);
            return back()->with('success', 'Password berhasil diubah!');

        // } catch (Exception $e) {
        //     return back()->with('error', $e->getMessage());
        // }
    }


    public function showPaktaIntegritas(Karyawan $karyawan)
    {
        $data = [
            'title'             => 'SPT TTD Digital | PT. Maha Akbar Sejahtera',
            'karyawan'          => $karyawan,
            'karyawanBiodata'   => KaryawanBiodata::with(['karyawan'])->where('karyawan_id', $karyawan->id)->get(),
        ];

        if($karyawan->pakta_integritas_check == 1) {
            return view('frontend.karyawan.pakta_integirtas', $data);
        } else {
            echo "<script>
                    alert('Tidak ada surat pernyataan tanda tangan digital $karyawan->nama_lengkap');
                </script>";
            abort(404);
        }

    }


    /*============================================
                GABUNG ARDI
    ========================================== */

    public function karyawanEdit(Karyawan $karyawan)
    {
        $data = [
            'title'                 => 'Admin - Edit Karyawan | PT. Maha Akbar Sejahtera',
            'karyawan'              => $karyawan,
            'jabatan'               => Jabatan::all(),
            'departemen'            => Departemen::all(),
            'cabang'                => Cabang::all(),
        ];
        return view('karyawan.edit-karyawan', $data);
    }

    public function karyawanEditBiodata(Karyawan $karyawan)
    {
        $data = [
            'title'                 => 'Admin - Edit Karyawan | PT. Maha Akbar Sejahtera',
            'karyawan'              => $karyawan,
            'karyawanBiodata'       => KaryawanBiodata::with(['karyawan'])->where('karyawan_id', $karyawan->id)->get(),
        ];
        return view('karyawan.edit-biodata', $data);
    }

    public function karyawanEditSusunanKeluarga(Karyawan $karyawan)
    {
        $data = [
            'title'                 => 'Admin - Edit Karyawan | PT. Maha Akbar Sejahtera',
            'karyawan'              => $karyawan,
            'karyawanFamily'        => KaryawanFamily::with(['karyawan'])->where('karyawan_id', $karyawan->id)->get(),
            'karyawanBiodata'       => KaryawanBiodata::with(['karyawan'])->where('karyawan_id', $karyawan->id)->get(),
        ];
        return view('karyawan.edit-susunankeluarga', $data);
    }

    public function karyawanEditSaudara(Karyawan $karyawan, String $id)
    {
        $data = [
            'title'                 => 'Admin - Edit Karyawan | PT. Maha Akbar Sejahtera',
            'karyawan'              => $karyawan,
            'karyawanSibling'       => KaryawanSibling::with(['karyawan'])->where('id', $id)->first(),
        ];
        return view('karyawan.edit-saudara', $data);
    }

    public function karyawanEditRiwayatPendidikan(Karyawan $karyawan)
    {
        $data = [
            'title'                 => 'Admin - Edit Karyawan | PT. Maha Akbar Sejahtera',
            'karyawan'              => $karyawan,
            'karyawanEducation'     => KaryawanEducation::with(['karyawan'])->where('karyawan_id', $karyawan->id)->get(),

        ];
        return view('karyawan.edit-riwayatpendidikan', $data);
    }

    public function karyawanEditDokumen(Karyawan $karyawan)
    {
        $data = [
            'title'                 => 'Admin - Edit Karyawan | PT. Maha Akbar Sejahtera',
            'karyawan'              => $karyawan,
            'karyawanDocument'      => KaryawanDocument::with(['karyawan'])->where('karyawan_id', $karyawan->id)->get(),

        ];
        return view('karyawan.edit-dokumen', $data);
    }

    public function karyawanEditAnak(Karyawan $karyawan, String $id)
    {
        $data = [
            'title'                 => 'Admin - Edit Karyawan | PT. Maha Akbar Sejahtera',
            'karyawan'              => $karyawan,
            'karyawanChildren'      => KaryawanChildren::with(['karyawan'])->where('id', $id)->first(),
        ];
        return view('karyawan.edit-anak', $data);
    }

    public function karyawanUpdate(Request $request, Karyawan $karyawan)
    {

        $message = [
            'foto_karyawan.image' => 'File harus berupa gambar.',
            'foto_karyawan.mimes' => 'Format file tidak valid. Hanya diperbolehkan: jpeg, png, jpg, gif.',
            'foto_karyawan.max' => 'Ukuran file foto tidak boleh lebih dari 2 MB.',
        ];

        $request->validate([
            'nama' => 'required',
            'jabatan' => 'required',
            'departemen' => 'required',
            'cabang' => 'required',
            'foto_karyawan' => 'image|mimes:jpeg,png,jpg,gif|max:2048', // Sesuaikan dengan kebutuhan
        ], $message);

        $data = [
            'nama_lengkap' => $request->nama,
            'email' => $request->email,
            'jabatan' => $request->jabatan,
            'kode_dept' => $request->departemen,
            'kode_cabang' => $request->cabang,
        ];
        if ($request->hasFile('foto_karyawan')) {
            if ($karyawan->foto) {
                Storage::delete('public/' . $karyawan->foto);
            }
            $fotoPath = $request->file('foto_karyawan')->store('uploads/foto', 'public');
            $data['foto'] = $fotoPath;
        }
        $id = $request->id;
        Karyawan::where('id', $id)->update($data);
        return to_route('karyawan.index')->with('success', 'Data karyawan berhasil diupdate.');
    }

    public function karyawanUpdateBiodata(Request $request, Karyawan $karyawan)
    {
        $data = [
            'fullname' => $request->nama,
            'nickname' => $request->panggilan,
            'nik' => $request->nik,
            'address_identity' => $request->nama_jalan,
            'address_status' => $request->status_tinggal,
            'phone' => $request->no_hp,
            'urgent_phone' => $request->no_hp_darurat,
            'start_work' => $request->mulai_bekerja,
            'gender' => $request->jenis_kelamin,
            'birthplace' => $request->tempat_lahir,
            'birthdate' => $request->tanggal_lahir,
            'religion' => $request->agama,
            'weight' => $request->berat,
            'height' => $request->tinggi,
            'blood_type' => $request->gol_darah,
            'marital_status' => $request->status_pernikahan,
            'years_married' => $request->tahun_nikah,
        ];
        $id = $request->id;
        KaryawanBiodata::where('id', $id)->update($data);
        return to_route('karyawan.index')->with('success', 'Data karyawan berhasil diupdate.');
    }

    public function karyawanUpdateSusunanKeluarga(Request $request, Karyawan $karyawan)
    {
        $data = [
            'child_to' => $request->anakke,
            'father_name' => $request->nama_ayah,
            'father_age' => $request->usia_ayah,
            'father_last_education' => $request->ayah_last_education,
            'father_last_job_position' => $request->jabatan_terakhir_ayah,
            'father_last_job_company' => $request->perusahaan_terakhir_ayah,
            'mother_name' => $request->nama_ibu,
            'mother_age' => $request->usia_ibu,
            'mother_last_education' => $request->ibu_last_education,
            'mother_last_job_position' => $request->jabatan_terakhir_ibu,
            'mother_last_job_company' => $request->perusahaan_terakhir_ibu,
            'couple_name' => $request->nama_pasangan,
            'couple_age' => $request->usia_pasangan,
            'couple_last_education' => $request->pasangan_last_education,
            'couple_last_job_position' => $request->jabatan_terakhir_pasangan,
            'couple_last_job_company' => $request->perusahaan_terakhir_pasangan,
        ];
        $id = $request->id;
        KaryawanFamily::where('id', $id)->update($data);
        return to_route('karyawan.index')->with('success', 'Data karyawan berhasil diupdate.');
    }

    public function karyawanUpdateSaudara(Request $request)
    {
        $data = [
            'siblings_name' => $request->nama,
            'siblings_gender' => $request->jenis_kelamin,
            'siblings_age' => $request->usia,
            'siblings_last_education' => $request->pendidikan_terakhir,
            'siblings_last_job_position' => $request->jabatan_terakhir,
            'siblings_last_job_company' => $request->perusahaan_terakhir,
        ];
        $id = $request->id;
        KaryawanSibling::where('id', $id)->update($data);
        return to_route('karyawan.index')->with('success', 'Data karyawan berhasil diupdate.');
    }

    public function karyawanUpdateAnak(Request $request)
    {
        $data = [
            'children_name' => $request->nama,
            'children_gender' => $request->jenis_kelamin,
            'children_age' => $request->usia,
            'children_last_education' => $request->pendidikan_terakhir,
            'children_last_job_position' => $request->jabatan_terakhir,
            'children_last_job_company' => $request->perusahaan_terakhir,
        ];
        $id = $request->id;
        KaryawanChildren::where('id', $id)->update($data);
        return to_route('karyawan.index')->with('success', 'Data karyawan berhasil diupdate.');
    }

    public function karyawanUpdateRiwayatPendidikan(Request $request, Karyawan $karyawan)
    {
        $data = [
            'primary_school' => $request->nama_sd,
            'sd_start_year' => $request->masuk_sd,
            'sd_end_year' => $request->selesai_sd,
            'sd_ijazah' => $request->sd_ijazah,
            'junior_hight_school' => $request->nama_smp,
            'smp_start_year' => $request->masuk_smp,
            'smp_end_year' => $request->selesai_smp,
            'smp_ijazah' => $request->smp_ijazah,
            'senior_hight_school' => $request->nama_sma,
            'sma_start_year' => $request->masuk_sma,
            'sma_end_year' => $request->selesai_sma,
            'sma_ijazah' => $request->sma_ijazah,
            'bachelor_university' => $request->nama_univ,
            'bachelor_start_year' => $request->masuk_univ,
            'bachelor_end_year' => $request->selesai_univ,
            'bachelor_major' => $request->jurusan_univ,
            'bachelor_ijazah' => $request->univ_ijazah,
            'bachelor_gpa' => $request->ipk_univ,
            'bachelor_degree' => $request->gelar_univ,
            'master_university' => $request->nama_master,
            'master_major' => $request->jurusan_master,
            'master_start_year' => $request->masuk_master,
            'master_end_year' => $request->selesai_master,
            'master_ijazah' => $request->master_ijazah,
            'master_gpa' => $request->ipk_master,
            'master_degree' => $request->gelar_master,
            'doctor_university' => $request->nama_doctor,
            'doctor_major' => $request->jurusan_doctor,
            'doctor_start_year' => $request->masuk_doctor,
            'doctor_end_year' => $request->selesai_doctor,
            'doctor_ijazah' => $request->doctor_ijazah,
            'doctor_gpa' => $request->ipk_doctor,
            'doctor_degree' => $request->gelar_doctor,
        ];
        $id = $request->id;
        KaryawanEducation::where('id', $id)->update($data);
        return to_route('karyawan.index')->with('success', 'Data karyawan berhasil diupdate.');
    }

    public function karyawanUpdateDokumen(Request $request, Karyawan $karyawan)
    {
       try {
            $id = $request->id;
            $karyawanDocument = KaryawanDocument::where('id', $id)->first();
            $documentTypes = ['pas_photo', 'ktp', 'kk', 'ijazah', 'buku_rekening', 'npwp', 'bpjs_ktn', 'bpjs_kes'];
            $successMessage = '';

            foreach ($documentTypes as $type) {
                $tp = $request->has($type);

                if ($tp) {

                    // if($tp != 'pas_photo') {
                    //     $rules = [
                    //         $type => 'required|mimes:pdf|file|max:2048',
                    //     ];
                    // } else {
                    //     $rules = [
                    //         $type => 'required|image|file|max:2048',
                    //     ];
                    // }

                    // $rules = null;

                    // if($tp == 'pas_photo') $rules = [$type => 'required|image|file|max:2048'];
                    // if($tp == 'ktp') $rules = [$type => 'required|mimes:pdf|file|max:2048'];
                    // if($tp == 'kk') $rules = [$type => 'required|mimes:pdf|file|max:2048'];
                    // if($tp == 'ijazah') $rules = [$type => 'required|mimes:pdf|file|max:2048'];
                    // if($tp == 'buku_rekening') $rules = [$type => 'required|mimes:pdf|file|max:2048'];
                    // if($tp == 'npwp' || $tp == 'bpjs_ktn' || $tp == 'bpjs_kes') $rules = [$type => 'mimes:pdf|file|max:2048'];

                    // $validatedData = $request->validate($rules);
                    $validatedData = $request->validate([
                        'pas_photo'         => 'image|file|max:2048',
                        'ktp'               => 'mimes:pdf|file|max:2048',
                        'kk'                => 'mimes:pdf|file|max:2048',
                        'ijazah'            => 'mimes:pdf|file|max:2048',
                        'buku_rekening'     => 'mimes:pdf|file|max:2048',
                        'npwp'              => 'mimes:pdf|file|max:2048',
                        'bpjs_ktn'          => 'mimes:pdf|file|max:2048',
                        'bpjs_kes'          => 'mimes:pdf|file|max:2048',
                    ]);
                    $path = $request->file($type)->store("document/karyawan/$request->karyawan_id/$type", 'public');
                    $data = [$type => $path];

                    if ($karyawanDocument) {
                        $oldDocument = $karyawanDocument->$type;
                        $karyawanDocument->update($data);
                        if ($oldDocument) {
                            Storage::disk('public')->delete($oldDocument);
                        }
                    }
                    $successMessage .= ucfirst($type) . ' berhasil diupload. ';
                }
            }
            if (!empty($successMessage)) {
                return back()->with('success', $successMessage);
            }
            return back()->with('error', 'File belum dipilih...!!!');
       } catch (Exception $e){
            return back()->with('error', $e->getMessage());
       }
    }

    public function nonaktifkanKaryawan(Request $request)
    {
        try{
            Karyawan::where('id', $request->karyawan_id)->update(['status' => 4]);
            return back()->with('success', 'Karyawan berhasil dinonaktifkan!');
        } catch (Exception $e) {
            return back()->with('error', 'Karyawan gagal dinonaktifkan!');
        }
    }

    public function aktifkanKaryawan(Request $request)
    {
        try{
            Karyawan::where('id', $request->karyawan_id)->update(['status' => 3]);
            return back()->with('success', 'Karyawan berhasil diaktifkan!');
        } catch (Exception $e) {
            return back()->with('error', 'Karyawan gagal diaktifkan!');
        }
    }

    public function delete(Karyawan $karyawan)
    {

        try {
            $path = "public/signature/";
            $sign = $karyawan->signature;
            if(!empty($karyawan->signature)) Storage::delete($path . $sign);
            $karyawan->delete();

            KaryawanBiodata::where('karyawan_id', $karyawan->id)->delete();
            KaryawanChildren::where('karyawan_id', $karyawan->id)->delete();
            KaryawanEducation::where('karyawan_id', $karyawan->id)->delete();
            KaryawanFamily::where('karyawan_id', $karyawan->id)->delete();
            KaryawanJobdesk::where('karyawan_id', $karyawan->id)->delete();
            KaryawanSibling::where('karyawan_id', $karyawan->id)->delete();

            $doc = KaryawanDocument::where('karyawan_id', $karyawan->id)->first();

            if(!empty($doc)) {
                if(!empty($doc->pas_photo)) Storage::disk('public')->delete( $doc->pas_photo);
                if(!empty($doc->ktp)) Storage::disk('public')->delete( $doc->ktp);
                if(!empty($doc->kk)) Storage::disk('public')->delete( $doc->kk);
                if(!empty($doc->ijazah)) Storage::disk('public')->delete( $doc->ijazah);
                if(!empty($doc->buku_rekening)) Storage::disk('public')->delete( $doc->buku_rekening);
                if(!empty($doc->buku_npwp)) Storage::disk('public')->delete( $doc->buku_npwp);
                if(!empty($doc->bpjs_ktn)) Storage::disk('public')->delete( $doc->bpjs_ktn);
                if(!empty($doc->bpjs_kes)) Storage::disk('public')->delete( $doc->bpjs_kes);

                $doc->delete();
            }

            return to_route('karyawan.index')->with(['success' => 'Data Berhasil Dihapus!']);
        } catch (\Exception $e) {
            return to_route('karyawan.index')->with(['error' => $e->getMessage()]);
        }
    }


}
