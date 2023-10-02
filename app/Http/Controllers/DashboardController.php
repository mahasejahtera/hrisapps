<?php

namespace App\Http\Controllers;

use App\Models\Karyawan;
use App\Models\KaryawanBiodata;
use App\Models\KaryawanDocument;
use App\Models\KaryawanEducation;
use App\Models\KaryawanFamily;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class DashboardController extends Controller
{

    // Dashboard
    public function index()
    {

        $data = [
            'title'     => 'Dashboard Karyawan | PT. Maha Akbar Sejahtera'
        ];


        return view('dashboard', $data);
    }

    /*========================
            DATA DIRI
    ========================*/

    public function dataDiri(Karyawan $karyawan)
    {
        $data = [
            'title'             => 'Data Diri ! PT. Maha Akbar Sejahtera',
            'karyawan'          => $karyawan,
            'karyawanBiodata'   => KaryawanBiodata::with(['karyawan'])->where('karyawan_id', $karyawan->id)->get()
        ];

        return view('dashboard.biodata', $data);
    }

    public function dataDiriNext(Karyawan $karyawan)
    {
        $data = [
            'title'             => 'Data Diri ! PT. Maha Akbar Sejahtera',
            'karyawan'          => $karyawan,
            'karyawanBiodata'   => KaryawanBiodata::with(['karyawan'])->where('karyawan_id', $karyawan->id)->get(),
            'karyawanFamily'    => KaryawanFamily::with(['karyawan'])->where('karyawan_id', $karyawan->id)->get(),
            'karyawanEducation' => KaryawanEducation::with(['karyawan'])->where('karyawan_id', $karyawan->id)->get()
        ];

        return view('dashboard.biodata-2', $data);
    }

    public function dataDiriStore(Karyawan $karyawan, Request $request)
    {
        $response = [
            'error'     => true,
            'message'   => ''
        ];

        $getKaryawan = KaryawanBiodata::where('karyawan_id', $karyawan->id)->get();

        // check apakah ada request name
        if($request->name) {
            $data = [
                $request->name => $request->value
            ];
    
            if(!empty($getKaryawan[0]->id)) {
                KaryawanBiodata::where('karyawan_id', $karyawan->id)->update($data);
                $response['error'] = false;
                $response['message'] = 'Biodata karyawan berhasil di ubah!';
            } else {
                $data['karyawan_id'] = $karyawan->id;
                KaryawanBiodata::create($data);
    
                $response['error'] = false;
                $response['message'] = 'Biodata karyawan berhasil di tambah!';
            }

        } else {
            // validate data
            $validatedData = $request->validate([
                'fullname'          => 'required',
                'nickname'          => 'required',
                'nik'               => 'required|numeric',
                'address_identity' => 'required',
                'current_address'   => 'required',
                'address_status'    => 'required',
                'phone'             => 'required|min:5',
                'urgent_phone'      => 'required|min:5',
                'start_work'        => 'required|date',
                'current_position'  => 'required',
                'email'             => 'required|email',
                'gender'            => 'required',
                'birthplace'        => 'required',
                'birthdate'         => 'required|date',
                'religion'          => 'required',
                'weight'            => 'required|numeric',
                'height'            => 'required|numeric',
                'blood_type'        => 'required',
                'marital_status'    => 'required',
                'dependents_num'    => 'required|numeric'
            ]);

            
            if(!empty($getKaryawan[0]->id)) {
                KaryawanBiodata::where('karyawan_id', $karyawan->id)->update($validatedData);
                return to_route('karyawan.datadiri.next', $karyawan->email)->with('success', 'Biodata berhasil disimpan!');
            } else {
                $validatedData['karyawan_id'] = $karyawan->id;
                KaryawanBiodata::create($validatedData);
                return to_route('karyawan.datadiri.next', $karyawan->email)->with('success', 'Biodata berhasil disimpan!');
            }
        }

        return json_encode($response);
    }


    public function dataDiriStoreNext(Karyawan $karyawan, Request $request)
    {
        $response = [
            'error'     => true,
            'message'   => ''
        ];

        $getKaryawanFamily = KaryawanFamily::where('karyawan_id', $karyawan->id)->get();
        $getKaryawanEducation = KaryawanEducation::where('karyawan_id', $karyawan->id)->get();

        // check apakah ada request name
        if($request->name) {
            $data = [
                $request->name => $request->value
            ];

            // cek jenis form
            if($request->formType == 'family') {
                if(!empty($getKaryawanFamily[0]->id)) {
                    KaryawanFamily::where('karyawan_id', $karyawan->id)->update($data);
                    $response['error'] = false;
                    $response['message'] = 'Susunan keluarga karyawan berhasil di ubah!';
                } else {
                    $data['karyawan_id'] = $karyawan->id;
                    KaryawanFamily::create($data);
        
                    $response['error'] = false;
                    $response['message'] = 'Susunan keluarga karyawan berhasil di tambah!';
                }
            }

            if($request->formType == 'education') {
                if(!empty($getKaryawanEducation[0]->id)) {
                    KaryawanEducation::where('karyawan_id', $karyawan->id)->update($data);
                    $response['error'] = false;
                    $response['message'] = 'Pendidikan karyawan berhasil di ubah!';
                } else {
                    $data['karyawan_id'] = $karyawan->id;
                    KaryawanEducation::create($data);
        
                    $response['error'] = false;
                    $response['message'] = 'Pendidikan karyawan berhasil di tambah!';
                }
            }

        } else {
            // validate data
            $dataFamily = $request->validate([
                'father_name'       => 'required',
                'mother_name'       => 'required',
                'siblings_num'      => 'required|numeric',
                'child_to'          => 'required|numeric'   
            ]);

            $dataEducation = $request->validate([
                'last_education'        => 'required',
                'primary_school'        => 'required',
                'junior_hight_school'   => 'required',
                'senior_hight_school'   => 'required',
                'university'            => 'required',
                'major'                 => 'required'
            ]);

            
            // karyawan family
            if(!empty($getKaryawanEducation[0]->id)) {
                KaryawanFamily::where('karyawan_id', $karyawan->id)->update($dataFamily);
            } else {
                $dataFamily['karyawan_id'] = $karyawan->id;
                KaryawanFamily::create($dataFamily);
            }


            // karyawan education
            if(!empty($getKaryawanEducation[0]->id)) {
                KaryawanEducation::where('karyawan_id', $karyawan->id)->update($dataEducation);
                return to_route('karyawan.datadiri.document', $karyawan->email)->with('success', 'Biodata karyawan berhasil diubah!');
            } else {
                $dataEducation['karyawan_id'] = $karyawan->id;
                KaryawanEducation::create($dataEducation);
                return to_route('karyawan.datadiri.document', $karyawan->email)->with('success', 'Biodata karyawan berhasil ditambah!');
            }
        }

        return json_encode($response);
    }


    // document view
    public function dataDocument(Karyawan $karyawan)
    {
        $data = [
            'title'             => 'Data Document ! PT. Maha Akbar Sejahtera',
            'karyawan'          => $karyawan,
            'karyawanDocument'   => KaryawanDocument::with(['karyawan'])->where('karyawan_id', $karyawan->id)->get()
        ];

        return view('dashboard.document', $data);
    }


    // upload document
    public function dataDcumentStore(Karyawan $karyawan, Request $request)
    {
        $karyawan_id = $karyawan->id;
        $path = '';
        $karyawanDocument = KaryawanDocument::where('karyawan_id', $karyawan_id)->get();


        // cek form upload
        if($request->pas_photo) {

            $path = $request->file('pas_photo')->store("document/karyawan/$karyawan_id/pas_photo", 'public');

            // validate
            $validatedData = $request->validate([
                'pas_photo'     => 'required|image|file|max:2048'
            ]);

            $data = [
                'karyawan_id'   => $karyawan_id,
                'pas_photo'     => $path
            ];

            if(count($karyawanDocument) < 1) {
                // create data
                KaryawanDocument::create($data);
            } else {
                $oldPhoto = $karyawanDocument[0]->pas_photo;
                // update data
                KaryawanDocument::where('karyawan_id', $karyawan_id)->update($data);
                // delete old file
                if($oldPhoto) Storage::disk('public')->delete($oldPhoto);
            }

            return back()->with('success', 'Pas photo berhasil di upload');

        } else if($request->ktp)  {
            $path = $request->file('ktp')->store("document/karyawan/$karyawan_id/ktp", 'public');

            // validate
            $validatedData = $request->validate([
                'ktp'     => 'required|mimes:pdf|file|max:2048'
            ]);

            $data = [
                'karyawan_id'   => $karyawan_id,
                'ktp'           => $path
            ];

            if(count($karyawanDocument) < 1) {
                // create data
                KaryawanDocument::create($data);
            } else {
                $oldKTP = $karyawanDocument[0]->ktp;
                // update data
                KaryawanDocument::where('karyawan_id', $karyawan_id)->update($data);
                // delete old file
                if($oldKTP) Storage::disk('public')->delete($oldKTP);
            }

            return back()->with('success', 'KTP berhasil di upload');

        }else if($request->kk) {
            $path = $request->file('kk')->store("document/karyawan/$karyawan_id/kk", 'public');
            
            // validate
            $validatedData = $request->validate([
                'kk'     => 'required|mimes:pdf|file|max:2048'
            ]);

            $data = [
                'karyawan_id'   => $karyawan_id,
                'kk'     => $path
            ];

            if(count($karyawanDocument) < 1) {
                // create data
                KaryawanDocument::create($data);
            } else {
                $oldKK = $karyawanDocument[0]->kk;
                // update data
                KaryawanDocument::where('karyawan_id', $karyawan_id)->update($data);
                // delete old file
                if($oldKK) Storage::disk('public')->delete($oldKK);
            }

            return back()->with('success', 'Pas photo berhasil di upload');

        } else if($request->ijazah) {
            $path = $request->file('ijazah')->store("document/karyawan/$karyawan_id/ijazah", 'public');

            // validate
            $validatedData = $request->validate([
                'ijazah'     => 'required|mimes:pdf|file|max:2048'
            ]);

            $data = [
                'karyawan_id'   => $karyawan_id,
                'ijazah'     => $path
            ];

            if(count($karyawanDocument) < 1) {
                // create data
                KaryawanDocument::create($data);
            } else {
                $oldIjazah = $karyawanDocument[0]->ijazah;
                // update data
                KaryawanDocument::where('karyawan_id', $karyawan_id)->update($data);
                // delete old file
                if($oldIjazah) Storage::disk('public')->delete($oldIjazah);
            }

            return back()->with('success', 'Ijazah berhasil di upload');

        } else if($request->buku_rekening) {
            $path = $request->file('buku_rekening')->store("document/karyawan/$karyawan_id/ijazah", 'public');

            // validate
            $validatedData = $request->validate([
                'buku_rekening'     => 'required|mimes:pdf|file|max:2048'
            ]);

            $data = [
                'karyawan_id'   => $karyawan_id,
                'buku_rekening' => $path
            ];

            if(count($karyawanDocument) < 1) {
                // create data
                KaryawanDocument::create($data);
            } else {
                $oldBukuRekening = $karyawanDocument[0]->buku_rekening;
                // update data
                KaryawanDocument::where('karyawan_id', $karyawan_id)->update($data);
                // delete old file
                if($oldBukuRekening) Storage::disk('public')->delete($oldBukuRekening);
            }

            return back()->with('success', 'Buku Rekening berhasil di upload');

        } else if($request->npwp) {
            $path = $request->file('npwp')->store("document/karyawan/$karyawan_id/npwp", 'public');

            // validate
            $validatedData = $request->validate([
                'npwp'     => 'required|mimes:pdf|file|max:2048'
            ]);

            $data = [
                'karyawan_id'   => $karyawan_id,
                'npwp'     => $path
            ];

            if(count($karyawanDocument) < 1) {
                // create data
                KaryawanDocument::create($data);
            } else {
                $oldNPWP = $karyawanDocument[0]->npwp;
                // update data
                KaryawanDocument::where('karyawan_id', $karyawan_id)->update($data);
                // delete old file
                if($oldNPWP) Storage::disk('public')->delete($oldNPWP);
            }

            return back()->with('success', 'NPWP berhasil di upload');

        } else if($request->bpjs) {
            $path = $request->file('bpjs')->store("document/karyawan/$karyawan_id/bpjs", 'public');

            // validate
            $validatedData = $request->validate([
                'bpjs'     => 'required|mimes:pdf|file|max:2048'
            ]);

            $data = [
                'karyawan_id'   => $karyawan_id,
                'bpjs'     => $path
            ];

            if(count($karyawanDocument) < 1) {
                // create data
                KaryawanDocument::create($data);
            } else {
                $oldBPJS = $karyawanDocument[0]->bpjs;
                // update data
                KaryawanDocument::where('karyawan_id', $karyawan_id)->update($data);
                // delete old file
                if($oldBPJS) Storage::disk('public')->delete($oldBPJS);
            }

            return back()->with('success', 'BPJS berhasil di upload');

        } else {
            return back()->with('error', 'File belum dipilih...!!!');
        }
       
    }


    // signature
    public function signature(Karyawan $karyawan)
    {
        $data = [
            'title'     => 'Signature | PT. Maha Akbar Sejahtera',
            'karyawan'  => $karyawan,
        ];

        return view('dashboard.signature', $data);
    }

    // upload signature
    public function signatureStore(Karyawan $karyawan, Request $request)
    {
        // upload signature
        $folderPath = public_path("signature/");
        
        $image_parts = explode(";base64,", $request->foto);
                    
        $image_type_aux = explode("image/", $image_parts[0]);
                
        $image_type = $image_type_aux[1];
                
        $image_base64 = base64_decode($image_parts[1]);
                
        $fileName = $karyawan->id . '_' . uniqid() . '.' . $image_type;
        $file = $folderPath . $fileName;
        file_put_contents($file, $image_base64);

        // update signature to database
        $oldSignature = $karyawan->signature;
        $data = [
            'signature' => $fileName
        ];
        Karyawan::where('id', $karyawan->id)->update($data);

        // delete old signature
        if($oldSignature) {
            if(File::exists(public_path("signature/$oldSignature"))) File::delete(public_path("signature/$oldSignature"));
            return [
                'error'     => false
            ];
        }

        return [
            'error'     => false
        ];
    }


    // pakta integritas
    public function paktaIntegritas(Karyawan $karyawan)
    {
        $data = [
            'title'             => 'Pakta Integritas | PT. Maha Akbar Sejahtera',
            'karyawanBiodata'   => KaryawanBiodata::with(['karyawan'])->where('karyawan_id', $karyawan->id)->get()
        ];

        return view('dashboard.pakta_integritas', $data);
    }


    public function paktaIntegritasStore(Karyawan $karyawan)
    {

        $data = [
            'pakta_integritas_check' => 1,
            'pakta_integritas_check_date' => date('Y-m-d')
        ];

        // update pakta integritas check
        Karyawan::where('id', $karyawan->id)->update($data);

        return [
            'error'     => false,
            'message'   => 'Pakta integritas berhasil disetujui!'
        ];
    }


    // kontrak kerja
    public function kontrakKerja(Karyawan $karyawan)
    {
        $data = [
            'title'             => 'Kontrak Kerja | PT. Maha Akbar Sejahtera',
            'karyawanBiodata'   => KaryawanBiodata::with(['karyawan'])->where('karyawan_id', $karyawan->id)->get(),
            'karyawanEducation' => KaryawanEducation::with(['karyawan'])->where('karyawan_id', $karyawan->id)->get()
        ];

        return view('dashboard.kontrak_kerja', $data);
    }

    public function kontrakKerjaStore(Karyawan $karyawan)
    {

        $data = [
            'kontrak_check' => 1,
            'kontrak_check_date' => date('Y-m-d')
        ];

        // update pakta integritas check
        Karyawan::where('id', $karyawan->id)->update($data);

        return [
            'error'     => false,
            'message'   => 'Kontrak kerja berhasil disetujui!'
        ];
    }


    // konfir data diri
    public function dataDiriConfirm(Karyawan $karyawan)
    {
        $data = [
            'title'             => 'Konfirmasi Data Diri | PT. Maha Akbar Sejahtera',
            'karyawanBiodata'   => KaryawanBiodata::with(['karyawan'])->where('karyawan_id', $karyawan->id)->get(),
            'karyawanEducation' => KaryawanEducation::with(['karyawan'])->where('karyawan_id', $karyawan->id)->get(),
            'karyawanFamily'    => KaryawanFamily::with(['karyawan'])->where('karyawan_id', $karyawan->id)->get(),
            'karyawanDocument'  => KaryawanDocument::with(['karyawan'])->where('karyawan_id', $karyawan->id)->get()
        ];

        return view('dashboard.datadiri_confirm', $data);
    }

    // Presensi
    public function presensi()
    {
        $hariini = date("Y-m-d");
        $bulanini = date("m") * 1; //1 atau Januari
        $tahunini = date("Y"); // 2023
        $nik = Auth::guard('karyawan')->user()->nik;
        $presensihariini = DB::table('presensi')->where('nik', $nik)->where('tgl_presensi', $hariini)->first();
        $historibulanini = DB::table('presensi')
            ->leftJoin('jam_kerja', 'presensi.kode_jam_kerja', '=', 'jam_kerja.kode_jam_kerja')
            ->where('nik', $nik)
            ->whereRaw('MONTH(tgl_presensi)="' . $bulanini . '"')
            ->whereRaw('YEAR(tgl_presensi)="' . $tahunini . '"')
            ->orderBy('tgl_presensi')
            ->get();

        $rekappresensi = DB::table('presensi')
            ->selectRaw('COUNT(nik) as jmlhadir, SUM(IF(jam_in > jam_masuk ,1,0)) as jmlterlambat')
            ->leftJoin('jam_kerja', 'presensi.kode_jam_kerja', '=', 'jam_kerja.kode_jam_kerja')
            ->where('nik', $nik)
            ->whereRaw('MONTH(tgl_presensi)="' . $bulanini . '"')
            ->whereRaw('YEAR(tgl_presensi)="' . $tahunini . '"')
            ->first();


        $leaderboard = DB::table('presensi')
            ->join('karyawan', 'presensi.nik', '=', 'karyawan.nik')
            ->where('tgl_presensi', $hariini)
            ->orderBy('jam_in')
            ->get();
        $namabulan = ["", "Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Desember"];

        $rekapizin = DB::table('pengajuan_izin')
            ->selectRaw('SUM(IF(status="i",1,0)) as jmlizin,SUM(IF(status="s",1,0)) as jmlsakit')
            ->where('nik', $nik)
            ->whereRaw('MONTH(tgl_izin)="' . $bulanini . '"')
            ->whereRaw('YEAR(tgl_izin)="' . $tahunini . '"')
            ->where('status_approved', 1)
            ->first();


        return view('dashboard.dashboard', compact('presensihariini', 'historibulanini', 'namabulan', 'bulanini', 'tahunini', 'rekappresensi', 'leaderboard', 'rekapizin'));
    }

    public function dashboardadmin()
    {

        $bulanini = date("m");
        $tahunini = date("Y");
        $hariini = date("Y-m-d");
        $rekappresensi = DB::table('presensi')
            ->selectRaw('COUNT(nik) as jmlhadir, SUM(IF(jam_in > "07:00",1,0)) as jmlterlambat')
            ->where('tgl_presensi', $hariini)
            ->first();

        $rekapizin = DB::table('pengajuan_izin')
            ->selectRaw('SUM(IF(status="i",1,0)) as jmlizin,SUM(IF(status="s",1,0)) as jmlsakit')
            ->where('tgl_izin', $hariini)
            ->where('status_approved', 1)
            ->first();

        $datagrafik = DB::table('presensi')
            ->selectRaw('
            SUM(IF(DAY(tgl_presensi)=1 AND jam_in IS NOT NULL,1,0)) as tgl_1,
            SUM(IF(DAY(tgl_presensi)=2 AND jam_in IS NOT NULL,1,0)) as tgl_2,
            SUM(IF(DAY(tgl_presensi)=3 AND jam_in IS NOT NULL,1,0)) as tgl_3,
            SUM(IF(DAY(tgl_presensi)=4 AND jam_in IS NOT NULL,1,0)) as tgl_4,
            SUM(IF(DAY(tgl_presensi)=5 AND jam_in IS NOT NULL,1,0)) as tgl_5,
            SUM(IF(DAY(tgl_presensi)=6 AND jam_in IS NOT NULL,1,0)) as tgl_6,
            SUM(IF(DAY(tgl_presensi)=7 AND jam_in IS NOT NULL,1,0)) as tgl_7,
            SUM(IF(DAY(tgl_presensi)=8 AND jam_in IS NOT NULL,1,0)) as tgl_8,
            SUM(IF(DAY(tgl_presensi)=9 AND jam_in IS NOT NULL,1,0)) as tgl_9,
            SUM(IF(DAY(tgl_presensi)=10 AND jam_in IS NOT NULL,1,0)) as tgl_10,
            SUM(IF(DAY(tgl_presensi)=11 AND jam_in IS NOT NULL,1,0)) as tgl_11,
            SUM(IF(DAY(tgl_presensi)=12 AND jam_in IS NOT NULL,1,0)) as tgl_12,
            SUM(IF(DAY(tgl_presensi)=13 AND jam_in IS NOT NULL,1,0)) as tgl_13,
            SUM(IF(DAY(tgl_presensi)=14 AND jam_in IS NOT NULL,1,0)) as tgl_14,
            SUM(IF(DAY(tgl_presensi)=15 AND jam_in IS NOT NULL,1,0)) as tgl_15,
            SUM(IF(DAY(tgl_presensi)=16 AND jam_in IS NOT NULL,1,0)) as tgl_16,
            SUM(IF(DAY(tgl_presensi)=17 AND jam_in IS NOT NULL,1,0)) as tgl_17,
            SUM(IF(DAY(tgl_presensi)=18 AND jam_in IS NOT NULL,1,0)) as tgl_18,
            SUM(IF(DAY(tgl_presensi)=19 AND jam_in IS NOT NULL,1,0)) as tgl_19,
            SUM(IF(DAY(tgl_presensi)=20 AND jam_in IS NOT NULL,1,0)) as tgl_20,
            SUM(IF(DAY(tgl_presensi)=21 AND jam_in IS NOT NULL,1,0)) as tgl_21,
            SUM(IF(DAY(tgl_presensi)=22 AND jam_in IS NOT NULL,1,0)) as tgl_22,
            SUM(IF(DAY(tgl_presensi)=23 AND jam_in IS NOT NULL,1,0)) as tgl_23,
            SUM(IF(DAY(tgl_presensi)=24 AND jam_in IS NOT NULL,1,0)) as tgl_24,
            SUM(IF(DAY(tgl_presensi)=25 AND jam_in IS NOT NULL,1,0)) as tgl_25,
            SUM(IF(DAY(tgl_presensi)=26 AND jam_in IS NOT NULL,1,0)) as tgl_26,
            SUM(IF(DAY(tgl_presensi)=27 AND jam_in IS NOT NULL,1,0)) as tgl_27,
            SUM(IF(DAY(tgl_presensi)=28 AND jam_in IS NOT NULL,1,0)) as tgl_28,
            SUM(IF(DAY(tgl_presensi)=29 AND jam_in IS NOT NULL,1,0)) as tgl_29,
            SUM(IF(DAY(tgl_presensi)=30 AND jam_in IS NOT NULL,1,0)) as tgl_30
        ')
            ->whereRaw('MONTH(tgl_presensi)="' . $bulanini . '"')
            ->whereRaw('YEAR(tgl_presensi)="' . $tahunini . '"')
            ->first();


        return view('dashboard.dashboardadmin', compact('rekappresensi', 'rekapizin', 'datagrafik'));
    }
}
