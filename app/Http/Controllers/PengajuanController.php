<?php

namespace App\Http\Controllers;

use App\Models\SubmitPengajuan;
use Illuminate\Http\Request;

class PengajuanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {
        session()->flush();
        session([
            'id' => 9,
            'role_id' => 1,
            'kode_dept' => 'IT',
            'inisial' => 'NF'
        ]);
        // dd(session('role_id'));
    }

    public function index()
    {

        // dd(session('role_id'));
        switch (session('role_id')) {
            case 1:
                return $this->pribadi();
                break;
            case 2:
                return $this->opsi();
                break;
            case 3:
                return $this->departemen();
                break;
            case 4:
                return $this->opsi();
                break;
            case 5:
                return $this->opsi();
                break;
            default:
                return $this->pribadi();
        }
    }

    private function opsi()
    {
        $data = [
            'title'     => 'Dashboard Karyawan | PT. Maha Akbar Sejahtera',
            'kodeDept'  => session('kode_dept')
        ];

        return view('pengajuan.opsi', $data);
    }

    public function pribadi()
    {
        $data = [
            'title'     => 'Dashboard Karyawan | PT. Maha Akbar Sejahtera'
        ];

        return view('pengajuan.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function list()
    {
        //
        $pengajuan = SubmitPengajuan::where(['id_karyawan' => session('id')])->get();
        $data = [
            'title'     => 'Dashboard Karyawan | PT. Maha Akbar Sejahtera',
            'pengajuan' => $pengajuan
        ];

        //
        return view('pengajuan.list', $data);
    }

    public function departemen()
    {
        $data = [
            'title'     => 'Dashboard Karyawan | PT. Maha Akbar Sejahtera'
        ];

        return view('pengajuan.departemen', $data);
    }

    public function departemen_list($kodeDept)
    {
        // dd($kodeDept);
        $pengajuan = (new SubmitPengajuan)->getSubmitPengajuanByKodeDept($kodeDept);
        $data = [
            'title'     => 'Dashboard Karyawan | PT. Maha Akbar Sejahtera',
            'pengajuan' => $pengajuan
        ];

        return view('pengajuan.departemenlist', $data);
    }

    public function tracking()
    {
        $data = [
            'title'     => 'Dashboard Karyawan | PT. Maha Akbar Sejahtera'
        ];
        return view('pengajuan.tracking', $data);
    }

    public function archive(){
        $data = [
            'title'     => 'Dashboard Karyawan | PT. Maha Akbar Sejahtera'
        ];
        return view('pengajuan.archive', $data);
    }
}
