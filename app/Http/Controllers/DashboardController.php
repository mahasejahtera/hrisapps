<?php

namespace App\Http\Controllers;

use App\Models\IndonesiaDistrict;
use App\Models\IndonesiaProvince;
use App\Models\IndonesiaRegency;
use App\Models\IndonesiaVillage;
use App\Models\Karyawan;
use App\Models\KaryawanBiodata;
use App\Models\KaryawanChildren;
use App\Models\KaryawanContract;
use App\Models\KaryawanDocument;
use App\Models\KaryawanEducation;
use App\Models\KaryawanFamily;
use App\Models\KaryawanJobdesk;
use App\Models\KaryawanSibling;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Illuminate\Support\Str;

class DashboardController extends Controller
{
    private $suratController;

    public function __construct()
    {
        $this->suratController = new SuratController();
    }

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
            'karyawanBiodata'   => KaryawanBiodata::with(['karyawan'])->where('karyawan_id', $karyawan->id)->get(),
            'provinces'         => IndonesiaProvince::all()
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


    // INDONESIA DATA
    public function getIndoData(Request $request)
    {
        $response = [
            'error'     => true,
            'message'   => ''
        ];

        if($request->type == 'province') {
            $regencies = IndonesiaRegency::with(['province'])->where('province_id', $request->value)->get();

            $regencyOptions = "<option value=''>--Pilih Kab/Kota--</option>";

            foreach($regencies as $regency) {
                $regencyOptions .= "<option value='$regency->id'>$regency->name</option>";
            }

            return [
                'error'             => false,
                'type'              => 'regency',
                'regencyOptions'    => $regencyOptions
            ];
        }

        if($request->type == 'regency') {
            $districts = IndonesiaDistrict::with(['regency'])->where('regency_id', $request->value)->get();

            $districtOptions = "<option value=''>--Pilih Kecamatan--</option>";

            foreach($districts as $district) {
                $districtOptions .= "<option value='$district->id'>$district->name</option>";
            }

            return [
                'error'             => false,
                'type'              => 'district',
                'districtOptions'    => $districtOptions
            ];
        }

        if($request->type == 'district') {
            $villages = IndonesiaVillage::with(['district'])->where('district_id', $request->value)->get();

            $villageOptions = "<option value=''>--Pilih Kel/Desa--</option>";

            foreach($villages as $village) {
                $villageOptions .= "<option value='$village->id'>$village->name</option>";
            }

            return [
                'error'             => false,
                'type'              => 'village',
                'villageOptions'    => $villageOptions
            ];
        }
    }


    public function setIndoDataAfterLoad(Karyawan $karyawan, Request $request)
    {
        $response = [
            'error'     => true,
            'message'   => ""
        ];

        try {
            // get biodata karyawan
            $karyawanBiodata = KaryawanBiodata::with(['karyawan'])->where('karyawan_id', $karyawan->id)->get();

            /*==========================
                    IDENTITY
            ==========================*/

            $identityRegencyOptions = '';
            $identityDistrictOptions = '';
            $identityVillageOptions = '';

            $identityregencies = IndonesiaRegency::with(['province'])->where('province_id', $karyawanBiodata[0]->identity_province)->get();
            $identitydistricts = IndonesiaDistrict::with(['regency'])->where('regency_id', $karyawanBiodata[0]->identity_regency)->get();
            $identityvillage = IndonesiaVillage::with(['district'])->where('district_id', $karyawanBiodata[0]->identity_district)->get();

            if(count($identityregencies) > 0) {
                $identityRegencyOptions .= "<option value=''>--Pilih Kab/Kota--</option>";
            }
            if(count($identitydistricts) > 0) {
                $identityDistrictOptions .= "<option value=''>--Pilih Kecamatan--</option>";
            }
            if(count($identityvillage) > 0) {
                $identityVillageOptions .= "<option value=''>--Pilih Kel/Desa--</option>";
            }

            // identity regencies
            foreach($identityregencies as $ir) {
                if($karyawanBiodata[0]->identity_regency == $ir->id) {
                    $identityRegencyOptions .= "<option value='$ir->id' selected>$ir->name</option>";
                } else {
                    $identityRegencyOptions .= "<option value='$ir->id'>$ir->name</option>";
                }
            }

            // identity district
            foreach($identitydistricts as $idenDist) {
                if($karyawanBiodata[0]->identity_district == $idenDist->id) {
                    $identityDistrictOptions .= "<option value='$idenDist->id' selected>$idenDist->name</option>";
                } else {
                    $identityDistrictOptions .= "<option value='$idenDist->id'>$idenDist->name</option>";
                }
            }

            // identity village
            foreach($identityvillage as $iv) {
                if($karyawanBiodata[0]->identity_village == $iv->id) {
                    $identityVillageOptions .= "<option value='$iv->id' selected>$iv->name</option>";
                } else {
                    $identityVillageOptions .= "<option value='$iv->id'>$iv->name</option>";
                }
            }



            /*==========================
                    CURRENT
            ==========================*/

            $currentRegencyOptions = '';
            $currentDistrictOptions = '';
            $currentVillageOptions = '';

            $currentregencies = IndonesiaRegency::with(['province'])->where('province_id', $karyawanBiodata[0]->current_province)->get();
            $currentdistricts = IndonesiaDistrict::with(['regency'])->where('regency_id', $karyawanBiodata[0]->current_regency)->get();
            $currentvillage = IndonesiaVillage::with(['district'])->where('district_id', $karyawanBiodata[0]->current_district)->get();

            if(count($currentregencies) > 0) {
                $currentRegencyOptions .= "<option value=''>--Pilih Kab/Kota--</option>";
            }
            if(count($currentdistricts) > 0) {
                $currentDistrictOptions .= "<option value=''>--Pilih Kecamatan--</option>";
            }
            if(count($currentvillage) > 0) {
                $currentVillageOptions .= "<option value=''>--Pilih Desa--</option>";
            }

            // current regencies
            foreach($currentregencies as $ir) {
                if($karyawanBiodata[0]->current_regency == $ir->id) {
                    $currentRegencyOptions .= "<option value='$ir->id' selected>$ir->name</option>";
                } else {
                    $currentRegencyOptions .= "<option value='$ir->id'>$ir->name</option>";
                }
            }

            // current district
            foreach($currentdistricts as $idenDist) {
                if($karyawanBiodata[0]->current_district == $idenDist->id) {
                    $currentDistrictOptions .= "<option value='$idenDist->id' selected>$idenDist->name</option>";
                } else {
                    $currentDistrictOptions .= "<option value='$idenDist->id'>$idenDist->name</option>";
                }
            }

            // current village
            foreach($currentvillage as $iv) {
                if($karyawanBiodata[0]->current_village == $iv->id) {
                    $currentVillageOptions .= "<option value='$iv->id' selected>$iv->name</option>";
                } else {
                    $currentVillageOptions .= "<option value='$iv->id'>$iv->name</option>";
                }
            }


            return [
                'error'             => false,
                'identityRegency'   => $identityRegencyOptions,
                'identityDistrict'  => $identityDistrictOptions,
                'identityVillage'   => $identityVillageOptions,
                'currentRegency'    => $currentRegencyOptions,
                'currentDistrict'   => $currentDistrictOptions,
                'currentVillage'    => $currentVillageOptions
            ];

        } catch (Exception $e) {
            $response = [
                'error'     => true,
                'message'   => $e->getMessage()
            ];
        }
    }

    public function dataDiriStore(Karyawan $karyawan, Request $request)
    {
        $response = [
            'error'     => true,
            'message'   => ''
        ];

        $getKaryawan = KaryawanBiodata::with(['karyawan'])->where('karyawan_id', $karyawan->id)->get();

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
                'fullname'              => 'required',
                'nickname'              => 'required',
                'nik'                   => 'required|numeric|digits:16',
                'identity_province'     => 'required',
                'identity_regency'      => 'required',
                'identity_district'     => 'required',
                'identity_village'      => 'required',
                'identity_postal_code'  => 'required',
                'address_identity'      => 'required',
                'current_province'      => 'required',
                'current_regency'       => 'required',
                'current_district'      => 'required',
                'current_village'       => 'required',
                'current_postal_code'   => 'required',
                'current_address'       => 'required',
                'address_status'        => 'required',
                'phone'                 => 'required|min:5',
                'urgent_phone'          => 'required|min:5',
                'start_work'            => 'required|date',
                'email'                 => 'required|email',
                'gender'                => 'required',
                'birthplace'            => 'required',
                'birthdate'             => 'required|date',
                'religion'              => 'required',
                'weight'                => 'required|numeric',
                'height'                => 'required|numeric',
                'blood_type'            => 'required',
                'marital_status'        => 'required',
            ]);

            if($request->marital_status != 'belum_kawin') {

                if($request->marital_status == 'kawin') {
                    $validatedData = $request->validate([
                        'years_married'  => 'required|numeric'
                    ]);
                }
            }

            // capitalize
            $validatedData['fullname'] = Str::title($request->fullname);
            $validatedData['nickname'] = Str::title($request->nickname);
            $validatedData['address_identity'] = Str::title($request->address_identity);
            $validatedData['current_address'] = Str::title($request->current_address);
            $validatedData['birthplace'] = Str::title($request->birthplace);

            if(!empty($getKaryawan[0]->id)) {
                KaryawanBiodata::where('karyawan_id', $karyawan->id)->update($validatedData);
            } else {
                $validatedData['karyawan_id'] = $karyawan->id;
                KaryawanBiodata::create($validatedData);
            }

            return to_route('karyawan.education', $karyawan->email)->with('success', 'Biodata berhasil disimpan!');
            // return to_route('karyawan.datadiri.next', $karyawan->email)->with('success', 'Biodata berhasil disimpan!');
        }

        return json_encode($response);
    }

    public function dataDiriStoreNext(Karyawan $karyawan, Request $request)
    {
        $response = [
            'error'     => true,
            'message'   => ''
        ];

        $getKaryawanFamily = KaryawanFamily::with(['karyawan'])->where('karyawan_id', $karyawan->id)->get();

        // check apakah ada request name
        if($request->name) {
            $data = [
                $request->name => $request->value
            ];

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

        } else {
            // validate data
            $dataFamily = $request->validate([
                'father_name'               => 'required',
                'father_status'             => 'required',
                'father_last_education'     => 'required',
                'mother_name'               => 'required',
                'mother_status'             => 'required',
                'mother_last_education'     => 'required',
            ]);

            if($request->father_status == 1) {
                $request->validate([
                    'father_age'  => 'required|numeric',
                ]);
            }

            if($request->mother_status == 1) {
                $request->validate([
                    'mother_age'  => 'required|numeric',
                ]);
            }

            $dataFamily['father_name'] = Str::title($request->father_name);
            $dataFamily['mother_name'] = Str::title($request->mother_name);


            // karyawan family
            if(!empty($getKaryawanFamily[0]->id)) {
                KaryawanFamily::where('karyawan_id', $karyawan->id)->update($dataFamily);
                return to_route('karyawan.datadiri.saudara', $karyawan->email)->with('success', 'Biodata karyawan berhasil ditambah!');

            } else {
                $dataFamily['karyawan_id'] = $karyawan->id;
                KaryawanFamily::create($dataFamily);
                return to_route('karyawan.datadiri.saudara', $karyawan->email)->with('success', 'Biodata karyawan berhasil ditambah!');
            }
        }

        return json_encode($response);
    }


    // Saudara
    public function karyawanSaudara(Karyawan $karyawan)
    {
        $data = [
            'title'             => 'Data Saudara ! PT. Maha Akbar Sejahtera',
            'karyawan'          => $karyawan,
            'karyawanFamily'    => KaryawanFamily::with(['karyawan'])->where('karyawan_id', $karyawan->id)->get(),
            'karyawanSibling'   => KaryawanSibling::with(['karyawan'])->where('karyawan_id', $karyawan->id)->get()
        ];

        return view('dashboard.saudara', $data);
    }

    public function karyawanSaudaraStore(Karyawan $karyawan, Request $request)
    {
        try {
            if($request->siblings_name) {
                for($i=0; $i < count($request->siblings_name); $i++) {
                    $data = [
                        'karyawan_id'                     => $karyawan->id,
                        'siblings_name'                   => $request->siblings_name[$i],
                        'siblings_gender'                 => $request->siblings_gender[$i],
                        'siblings_age'                    => $request->siblings_age[$i],
                        'siblings_last_education'         => $request->siblings_last_education[$i],
                        'siblings_last_job_position'      => $request->siblings_last_job_position[$i],
                        'siblings_last_job_company'       => $request->siblings_last_job_company[$i],
                    ];

                    // capitalize
                    $data['siblings_name'] = Str::title($request->siblings_name[$i]);

                    if(!empty($request->siblings_id[$i])) {
                        KaryawanSibling::where('id', $request->siblings_id)->update($data);
                    } else {
                        KaryawanSibling::create($data);
                    }
                }

                return to_route('karyawan.datadiri.anak', $karyawan->email)->with('success', "Kakak/adik kandung berhasil ditambah sebanyak " . $i . " orang");
            } else {
                return to_route('karyawan.datadiri.anak', $karyawan->email)->with('success', "Tidak ada kakak/adik kandung yang ditambah!");
            }

        } catch (Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }


    public function karyawanSaudaraDestroy(Request $request)
    {
        try {
            KaryawanSibling::where('id', $request->siblings)->delete();
            return back()->with('success', "Saudara berhasil dihapus");

        } catch(Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }


    // Children
    public function karyawanAnak(Karyawan $karyawan)
    {
        $data = [
            'title'             => 'Data Anak ! PT. Maha Akbar Sejahtera',
            'karyawan'          => $karyawan,
            'karyawanBiodata'   => KaryawanBiodata::with(['karyawan'])->where('karyawan_id', $karyawan->id)->get(),
            'karyawanChildren'  => KaryawanChildren::with(['karyawan'])->where('karyawan_id', $karyawan->id)->get()
        ];

        return view('dashboard.anak', $data);
    }

    public function karyawanAnakStore(Karyawan $karyawan, Request $request)
    {
        try {
            //get karyawan document
            $karyawanDocument = KaryawanDocument::with(['karyawan'])
            ->where('karyawan_id', $karyawan->id)->get();

            if($request->children_name) {
                for($i=0; $i < count($request->children_name); $i++) {
                    $data = [
                        'karyawan_id'                     => $karyawan->id,
                        'children_name'                   => $request->children_name[$i],
                        'children_gender'                 => $request->children_gender[$i],
                        'children_age'                    => $request->children_age[$i],
                        'children_last_education'         => $request->children_last_education[$i],
                        'children_last_job_position'      => $request->children_last_job_position[$i],
                        'children_last_job_company'       => $request->children_last_job_company[$i],
                    ];

                    // capitalize
                    $data['children_name'] = Str::title($request->children_name[$i]);

                    if(!empty($request->children_id[$i])) {
                        KaryawanChildren::where('id', $request->children_id)->update($data);
                    } else {
                        KaryawanChildren::create($data);
                    }
                }

                //create document
                if(count($karyawanDocument) < 1) {
                    KaryawanDocument::create([
                    'karyawan_id'       => $karyawan->id
                    ]);
                }

                return to_route('karyawan.signature', $karyawan->email)->with('success', "Anak berhasil ditambah sebanyak " . $i . " orang");
            } else {
                //create document
                if(count($karyawanDocument) < 1) {
                    KaryawanDocument::create([
                    'karyawan_id'       => $karyawan->id
                    ]);
                }

                return to_route('karyawan.signature', $karyawan->email)->with('success', "Tidak ada anak yang ditambah!");
            }

        } catch (Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    public function karyawanAnakDestroy(Request $request)
    {
        try {
            KaryawanChildren::where('id', $request->children)->delete();
            return back()->with('success', "Anak berhasil dihapus");

        } catch(Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }


    public function karyawanEducation(Karyawan $karyawan)
    {
        $data = [
            'title'             => 'Data Pendidikan | PT. Maha Akbar Sejahtera',
            'karyawan'          => $karyawan,
            'karyawanEducation' => KaryawanEducation::with(['karyawan'])->where('karyawan_id', $karyawan->id)->get()
        ];

        return view('dashboard.education', $data);
    }

    public function karyawanEducationStore(Karyawan $karyawan, Request $request)
    {
        $response = [
            'error'     => true,
            'message'   => ''
        ];
        $getKaryawanEducation = KaryawanEducation::where('karyawan_id', $karyawan->id)->get();

        // check apakah ada request name
        if($request->name) {
            $data = [
                $request->name => $request->value
            ];

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

        } else {

            // validate
            $dataEducation = $request->validate([
                'last_education'        => 'required',
            ]);

            if($request->last_education == 'sd') {
                $dataEducation = $request->validate([
                    'last_education'        => 'required',
                    'primary_school'        => 'required',
                    'sd_start_year'         => 'required|numeric|digits:4',
                    'sd_end_year'           => 'required|numeric|digits:4',
                    'sd_ijazah'             => 'required',
                ]);
            } else if($request->last_education == 'smp') {
                $dataEducation = $request->validate([
                    'last_education'        => 'required',
                    'primary_school'        => 'required',
                    'sd_start_year'         => 'required|numeric|digits:4',
                    'sd_end_year'           => 'required|numeric|digits:4',
                    'sd_ijazah'             => 'required',
                    'junior_hight_school'   => 'required',
                    'smp_start_year'        => 'required|numeric|digits:4',
                    'smp_end_year'          => 'required|numeric|digits:4',
                    'smp_ijazah'            => 'required',
                ]);
            } else if($request->last_education == 'sma') {
                $dataEducation = $request->validate([
                    'last_education'        => 'required',
                    'primary_school'        => 'required',
                    'sd_start_year'         => 'required|numeric|digits:4',
                    'sd_end_year'           => 'required|numeric|digits:4',
                    'sd_ijazah'             => 'required',
                    'junior_hight_school'   => 'required',
                    'smp_start_year'        => 'required|numeric|digits:4',
                    'smp_end_year'          => 'required|numeric|digits:4',
                    'smp_ijazah'            => 'required',
                    'senior_hight_school'   => 'required',
                    'sma_start_year'        => 'required|numeric|digits:4',
                    'sma_end_year'          => 'required|numeric|digits:4',
                    'sma_ijazah'            => 'required',
                ]);
            } else if($request->last_education == 'd i' || $request->last_education == 'd ii' || $request->last_education == 'd iii' || $request->last_education == 's1') {
                $dataEducation = $request->validate([
                    'last_education'        => 'required',
                    'primary_school'        => 'required',
                    'sd_start_year'         => 'required|numeric|digits:4',
                    'sd_end_year'           => 'required|numeric|digits:4',
                    'sd_ijazah'             => 'required',
                    'junior_hight_school'   => 'required',
                    'smp_start_year'        => 'required|numeric|digits:4',
                    'smp_end_year'          => 'required|numeric|digits:4',
                    'smp_ijazah'            => 'required',
                    'senior_hight_school'   => 'required',
                    'sma_start_year'        => 'required|numeric|digits:4',
                    'sma_end_year'          => 'required|numeric|digits:4',
                    'sma_ijazah'            => 'required',
                    'bachelor_university'   => 'required',
                    'bachelor_major'        => 'required',
                    'bachelor_start_year'   => 'required|numeric|digits:4',
                    'bachelor_end_year'     => 'required|numeric|digits:4',
                    'bachelor_ijazah'       => 'required',
                    'bachelor_gpa'          => 'required',
                    'bachelor_degree'       => 'required'
                ]);
            } else if($request->last_education == 's2') {
                $dataEducation = $request->validate([
                    'last_education'        => 'required',
                    'primary_school'        => 'required',
                    'sd_start_year'         => 'required|numeric|digits:4',
                    'sd_end_year'           => 'required|numeric|digits:4',
                    'sd_ijazah'             => 'required',
                    'junior_hight_school'   => 'required',
                    'smp_start_year'        => 'required|numeric|digits:4',
                    'smp_end_year'          => 'required|numeric|digits:4',
                    'smp_ijazah'            => 'required',
                    'senior_hight_school'   => 'required',
                    'sma_start_year'        => 'required|numeric|digits:4',
                    'sma_end_year'          => 'required|numeric|digits:4',
                    'sma_ijazah'            => 'required',
                    'bachelor_university'   => 'required',
                    'bachelor_major'        => 'required',
                    'bachelor_start_year'   => 'required|numeric|digits:4',
                    'bachelor_end_year'     => 'required|numeric|digits:4',
                    'bachelor_ijazah'       => 'required',
                    'bachelor_gpa'          => 'required',
                    'bachelor_degree'       => 'required',
                    'master_university'     => 'required',
                    'master_major'          => 'required',
                    'master_start_year'     => 'required|numeric|digits:4',
                    'master_end_year'       => 'required|numeric|digits:4',
                    'master_ijazah'         => 'required',
                    'master_gpa'            => 'required',
                    'master_degree'         => 'required'
                ]);
            } else if($request->last_education == 's3') {
                $dataEducation = $request->validate([
                    'last_education'        => 'required',
                    'primary_school'        => 'required',
                    'sd_start_year'         => 'required|numeric|digits:4',
                    'sd_end_year'           => 'required|numeric|digits:4',
                    'sd_ijazah'             => 'required',
                    'junior_hight_school'   => 'required',
                    'smp_start_year'        => 'required|numeric|digits:4',
                    'smp_end_year'          => 'required|numeric|digits:4',
                    'smp_ijazah'            => 'required',
                    'senior_hight_school'   => 'required',
                    'sma_start_year'        => 'required|numeric|digits:4',
                    'sma_end_year'          => 'required|numeric|digits:4',
                    'sma_ijazah'            => 'required',
                    'bachelor_university'   => 'required',
                    'bachelor_major'        => 'required',
                    'bachelor_start_year'   => 'required|numeric|digits:4',
                    'bachelor_end_year'     => 'required|numeric|digits:4',
                    'bachelor_ijazah'       => 'required',
                    'bachelor_gpa'          => 'required',
                    'bachelor_degree'       => 'required',
                    'master_university'     => 'required',
                    'master_major'          => 'required',
                    'master_start_year'     => 'required|numeric|digits:4',
                    'master_end_year'       => 'required|numeric|digits:4',
                    'master_ijazah'         => 'required',
                    'master_gpa'            => 'required',
                    'master_degree'         => 'required',
                    'doctor_university'     => 'required',
                    'doctor_major'          => 'required',
                    'doctor_start_year'     => 'required|numeric|digits:4',
                    'doctor_end_year'       => 'required|numeric|digits:4',
                    'doctor_ijazah'         => 'required',
                    'doctor_gpa'            => 'required',
                    'doctor_degree'         => 'required',
                ]);
            }


            // karyawan education
            if(!empty($getKaryawanEducation[0]->id)) {
                KaryawanEducation::where('karyawan_id', $karyawan->id)->update($dataEducation);
                // return to_route('karyawan.datadiri.document', $karyawan->email)->with('success', 'Pendidikan berhasil diubah!');
                return to_route('karyawan.datadiri.next', $karyawan->email)->with('success', 'Pendidikan berhasil diubah!');
            } else {
                $dataEducation['karyawan_id'] = $karyawan->id;
                KaryawanEducation::create($dataEducation);
                // return to_route('karyawan.datadiri.document', $karyawan->email)->with('success', 'Pendidikan berhasil ditambah!');
                return to_route('karyawan.datadiri.next', $karyawan->email)->with('success', 'Pendidikan berhasil ditambah!');
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


            // validate
            $validatedData = $request->validate([
                'pas_photo'     => 'required|image|file|max:2048'
            ]);

            $path = $request->file('pas_photo')->store("document/karyawan/$karyawan_id/pas_photo", 'public');

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

            // validate
            $validatedData = $request->validate([
                'ktp'     => 'required|mimes:pdf|file|max:2048'
            ]);

            $path = $request->file('ktp')->store("document/karyawan/$karyawan_id/ktp", 'public');

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

            // validate
            $validatedData = $request->validate([
                'kk'     => 'required|mimes:pdf|file|max:2048'
            ]);

            $path = $request->file('kk')->store("document/karyawan/$karyawan_id/kk", 'public');

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

            return back()->with('success', 'KK berhasil di upload');

        } else if($request->ijazah) {

            // validate
            $validatedData = $request->validate([
                'ijazah'     => 'required|mimes:pdf|file|max:2048'
            ]);

            $path = $request->file('ijazah')->store("document/karyawan/$karyawan_id/ijazah", 'public');

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

            // validate
            $validatedData = $request->validate([
                'buku_rekening'     => 'required|mimes:pdf|file|max:2048'
            ]);

            $path = $request->file('buku_rekening')->store("document/karyawan/$karyawan_id/ijazah", 'public');

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

            // validate
            $validatedData = $request->validate([
                'npwp'     => 'required|mimes:pdf|file|max:2048'
            ]);

            $path = $request->file('npwp')->store("document/karyawan/$karyawan_id/npwp", 'public');

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

        } else if($request->bpjs_ktn) {

            // validate
            $validatedData = $request->validate([
                'bpjs_ktn'     => 'required|mimes:pdf|file|max:2048'
            ]);

            $path = $request->file('bpjs_ktn')->store("document/karyawan/$karyawan_id/bpjs_ktn", 'public');

            $data = [
                'karyawan_id'   => $karyawan_id,
                'bpjs_ktn'     => $path
            ];

            if(count($karyawanDocument) < 1) {
                // create data
                KaryawanDocument::create($data);
            } else {
                $oldBPJSKtn = $karyawanDocument[0]->bpjs_ktn;
                // update data
                KaryawanDocument::where('karyawan_id', $karyawan_id)->update($data);
                // delete old file
                if($oldBPJSKtn) Storage::disk('public')->delete($oldBPJSKtn);
            }

            return back()->with('success', 'BPJS Ketenagakerjaan berhasil di upload');

        } else if($request->bpjs_kes) {

            // validate
            $validatedData = $request->validate([
                'bpjs_kes'     => 'required|mimes:pdf|file|max:2048'
            ]);

            $path = $request->file('bpjs_kes')->store("document/karyawan/$karyawan_id/bpjs_kes", 'public');

            $data = [
                'karyawan_id'   => $karyawan_id,
                'bpjs_kes'     => $path
            ];

            if(count($karyawanDocument) < 1) {
                // create data
                KaryawanDocument::create($data);
            } else {
                $oldBPJSKes = $karyawanDocument[0]->bpjs_kes;
                // update data
                KaryawanDocument::where('karyawan_id', $karyawan_id)->update($data);
                // delete old file
                if($oldBPJSKes) Storage::disk('public')->delete($oldBPJSKes);
            }

            return back()->with('success', 'BPJS Kesehatan berhasil di upload');

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
                'error'     => false,
                'signature' => $oldSignature
            ];
        }

        return [
            'error'     => false,
            'signature' => $fileName
        ];
    }


    // pakta integritas
    public function paktaIntegritas(Karyawan $karyawan)
    {
        $data = [
            'title'             => 'Surat Pernyataan | PT. Maha Akbar Sejahtera',
            'karyawan'          => $karyawan,
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


    // pakta integritas
    public function suratPernyataan(Karyawan $karyawan)
    {
        $data = [
            'title'             => 'Surat Pernyataan | PT. Maha Akbar Sejahtera',
            'karyawan'          => $karyawan,
            'karyawanBiodata'   => KaryawanBiodata::with(['karyawan'])->where('karyawan_id', $karyawan->id)->get()
        ];

        return view('dashboard.surat_pernyataan', $data);
    }


    public function suratPernyataanStore(Karyawan $karyawan)
    {

        $data = [
            'surat_pernyataan_check' => 1,
            'surat_pernyataan_check_date' => date('Y-m-d')
        ];

        // update pakta integritas check
        Karyawan::where('id', $karyawan->id)->update($data);

        return [
            'error'     => false,
            'message'   => 'Surat Pernyataan berhasil disetujui!'
        ];
    }


    // kontrak kerja
    public function kontrakKerja(Karyawan $karyawan)
    {

        $pihakPertama = Karyawan::with(['jabatan_kerja', 'department', 'cabang', 'contract', 'oldContract'])
                                ->join('karyawan_contract', 'karyawan.contract_id', '=', 'karyawan_contract.id')
                                ->join('jabatan', 'karyawan_contract.jabatan_id', '=', 'jabatan.id')
                                ->where('karyawan.role_id', 4)
                                ->where('karyawan.status', 3)
                                ->orderBy('karyawan.id', 'desc')
                                ->limit(1)
                                ->get();

        // if($karyawan->role_id == 2) {
        //     if($karyawan->contract->department->id == 9) {
        //         $pihakPertama = Karyawan::with(['jabatan_kerja', 'department', 'cabang', 'contract', 'oldContract'])
        //                         ->join('karyawan_contract', 'karyawan.contract_id', '=', 'karyawan_contract.id')
        //                         ->join('jabatan', 'karyawan_contract.jabatan_id', '=', 'jabatan.id')
        //                         ->where('karyawan.role_id', 4)
        //                         ->where('karyawan.status', 3)
        //                         ->orderBy('karyawan.id', 'desc')
        //                         ->limit(1)
        //                         ->get();
        //     } else {
        //         $pihakPertama = Karyawan::with(['jabatan_kerja', 'department', 'cabang', 'contract', 'oldContract'])
        //                         ->join('karyawan_contract', 'karyawan.contract_id', '=', 'karyawan_contract.id')
        //                         ->join('jabatan', 'karyawan_contract.jabatan_id', '=', 'jabatan.id')
        //                         ->where('karyawan.role_id', 2)
        //                         ->where('karyawan_contract.department_id', 9)
        //                         ->where('karyawan.status', 3)
        //                         ->orderBy('karyawan.id', 'desc')
        //                         ->limit(1)
        //                         ->get();
        //     }
        // } else {
        //     $pihakPertama = Karyawan::with(['jabatan_kerja', 'department', 'cabang', 'contract', 'oldContract'])
        //                     ->join('karyawan_contract', 'karyawan.contract_id', '=', 'karyawan_contract.id')
        //                     ->join('jabatan', 'karyawan_contract.jabatan_id', '=', 'jabatan.id')
        //                     ->where('karyawan.role_id', 2)
        //                     ->where('karyawan_contract.department_id', 9)
        //                     ->where('karyawan.status', 3)
        //                     ->orderBy('karyawan.id', 'desc')
        //                     ->limit(1)
        //                     ->get();
        // }

        $data = [
            'title'             => 'Kontrak Kerja | PT. Maha Akbar Sejahtera',
            'karyawan'          => $karyawan,
            'pihakPertama'      => $pihakPertama,
            'karyawanKontrak'   => KaryawanContract::with(['karyawan', 'jabatan', 'department', 'cabang'])->where('id', $karyawan->contract_id)->get(),
            'karyawanBiodata'   => KaryawanBiodata::with(['karyawan'])->where('karyawan_id', $karyawan->id)->get(),
            'karyawanEducation' => KaryawanEducation::with(['karyawan'])->where('karyawan_id', $karyawan->id)->get(),
            'karyawanJobdesk'   => KaryawanJobdesk::with(['karyawan'])->where('karyawan_id', $karyawan->id)->get(),
        ];

        return view('dashboard.kontrak_kerja', $data);
    }

    public function kontrakKerjaStore(Karyawan $karyawan)
    {

        $data = [
            'kontrak_check' => 1,
            'kontrak_check_date' => date('Y-m-d')
        ];

        // update contract check
        KaryawanContract::where('id', $karyawan->contract_id)->update($data);

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
            'karyawanDocument'  => KaryawanDocument::with(['karyawan'])->where('karyawan_id', $karyawan->id)->get(),
            'karyawanSibling'   => KaryawanSibling::with(['karyawan'])->where('karyawan_id', $karyawan->id)->get(),
            'karyawanChildren'  => KaryawanChildren::with(['karyawan'])->where('karyawan_id', $karyawan->id)->get(),
        ];

        return view('dashboard.datadiri_confirm', $data);
    }


    public function dataDiriConfirmStore(Karyawan $karyawan)
    {
        $data = [
            'biodata_confirm'       => 1,
            'biodata_confirm_date'  => date('Y-m-d'),
            'status'                => 2
        ];

        Karyawan::where('email', $karyawan->email)->update($data);

        return to_route('karyawan');
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
            ->whereRaw('MONTH(tgl_mulai_izin)="' . $bulanini . '"')
            ->whereRaw('YEAR(tgl_mulai_izin)="' . $tahunini . '"')
            ->where('status_approved', 1)
            ->first();


        return view('presensi.index', compact('presensihariini', 'historibulanini', 'namabulan', 'bulanini', 'tahunini', 'rekappresensi', 'leaderboard', 'rekapizin'));
    }

    // public function dashboardadmin()
    // {

    //     $bulanini = date("m");
    //     $tahunini = date("Y");
    //     $hariini = date("Y-m-d");
    //     $rekappresensi = DB::table('presensi')
    //         ->selectRaw('COUNT(nik) as jmlhadir, SUM(IF(jam_in > "07:00",1,0)) as jmlterlambat')
    //         ->where('tgl_presensi', $hariini)
    //         ->first();

    //     $rekapizin = DB::table('pengajuan_izin')
    //         ->selectRaw('SUM(IF(status="i",1,0)) as jmlizin,SUM(IF(status="s",1,0)) as jmlsakit')
    //         ->where('tgl_mulai_izin', $hariini)
    //         ->where('status_approved', 1)
    //         ->first();

    //     $datagrafik = DB::table('presensi')
    //         ->selectRaw('
    //         SUM(IF(DAY(tgl_presensi)=1 AND jam_in IS NOT NULL,1,0)) as tgl_1,
    //         SUM(IF(DAY(tgl_presensi)=2 AND jam_in IS NOT NULL,1,0)) as tgl_2,
    //         SUM(IF(DAY(tgl_presensi)=3 AND jam_in IS NOT NULL,1,0)) as tgl_3,
    //         SUM(IF(DAY(tgl_presensi)=4 AND jam_in IS NOT NULL,1,0)) as tgl_4,
    //         SUM(IF(DAY(tgl_presensi)=5 AND jam_in IS NOT NULL,1,0)) as tgl_5,
    //         SUM(IF(DAY(tgl_presensi)=6 AND jam_in IS NOT NULL,1,0)) as tgl_6,
    //         SUM(IF(DAY(tgl_presensi)=7 AND jam_in IS NOT NULL,1,0)) as tgl_7,
    //         SUM(IF(DAY(tgl_presensi)=8 AND jam_in IS NOT NULL,1,0)) as tgl_8,
    //         SUM(IF(DAY(tgl_presensi)=9 AND jam_in IS NOT NULL,1,0)) as tgl_9,
    //         SUM(IF(DAY(tgl_presensi)=10 AND jam_in IS NOT NULL,1,0)) as tgl_10,
    //         SUM(IF(DAY(tgl_presensi)=11 AND jam_in IS NOT NULL,1,0)) as tgl_11,
    //         SUM(IF(DAY(tgl_presensi)=12 AND jam_in IS NOT NULL,1,0)) as tgl_12,
    //         SUM(IF(DAY(tgl_presensi)=13 AND jam_in IS NOT NULL,1,0)) as tgl_13,
    //         SUM(IF(DAY(tgl_presensi)=14 AND jam_in IS NOT NULL,1,0)) as tgl_14,
    //         SUM(IF(DAY(tgl_presensi)=15 AND jam_in IS NOT NULL,1,0)) as tgl_15,
    //         SUM(IF(DAY(tgl_presensi)=16 AND jam_in IS NOT NULL,1,0)) as tgl_16,
    //         SUM(IF(DAY(tgl_presensi)=17 AND jam_in IS NOT NULL,1,0)) as tgl_17,
    //         SUM(IF(DAY(tgl_presensi)=18 AND jam_in IS NOT NULL,1,0)) as tgl_18,
    //         SUM(IF(DAY(tgl_presensi)=19 AND jam_in IS NOT NULL,1,0)) as tgl_19,
    //         SUM(IF(DAY(tgl_presensi)=20 AND jam_in IS NOT NULL,1,0)) as tgl_20,
    //         SUM(IF(DAY(tgl_presensi)=21 AND jam_in IS NOT NULL,1,0)) as tgl_21,
    //         SUM(IF(DAY(tgl_presensi)=22 AND jam_in IS NOT NULL,1,0)) as tgl_22,
    //         SUM(IF(DAY(tgl_presensi)=23 AND jam_in IS NOT NULL,1,0)) as tgl_23,
    //         SUM(IF(DAY(tgl_presensi)=24 AND jam_in IS NOT NULL,1,0)) as tgl_24,
    //         SUM(IF(DAY(tgl_presensi)=25 AND jam_in IS NOT NULL,1,0)) as tgl_25,
    //         SUM(IF(DAY(tgl_presensi)=26 AND jam_in IS NOT NULL,1,0)) as tgl_26,
    //         SUM(IF(DAY(tgl_presensi)=27 AND jam_in IS NOT NULL,1,0)) as tgl_27,
    //         SUM(IF(DAY(tgl_presensi)=28 AND jam_in IS NOT NULL,1,0)) as tgl_28,
    //         SUM(IF(DAY(tgl_presensi)=29 AND jam_in IS NOT NULL,1,0)) as tgl_29,
    //         SUM(IF(DAY(tgl_presensi)=30 AND jam_in IS NOT NULL,1,0)) as tgl_30
    //     ')
    //         ->whereRaw('MONTH(tgl_presensi)="' . $bulanini . '"')
    //         ->whereRaw('YEAR(tgl_presensi)="' . $tahunini . '"')
    //         ->first();


    //     return view('dashboard.dashboardadmin', compact('rekappresensi', 'rekapizin', 'datagrafik'));
    // }

    public function dashboardadmin()
    {
        $karyawan = Karyawan::all()->count();
        return view('dashboard.dashboardadmin', compact('karyawan'));
    }
}
