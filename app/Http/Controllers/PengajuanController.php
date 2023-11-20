<?php

namespace App\Http\Controllers;

use App\Models\NomorPengajuan;
use App\Models\SubmitPengajuan;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;

class PengajuanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index()
    {
        switch (Auth::guard('karyawan')->user()->role_id) {
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
            'kodeDept'  => Auth::guard('karyawan')->user()->kode_dept_init
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
        $pengajuan = SubmitPengajuan::where(['id_karyawan' => Auth::guard('karyawan')->user()->id])->get();
        $data = [
            'title'     => 'Dashboard Karyawan | PT. Maha Akbar Sejahtera',
            'pengajuan' => $pengajuan
        ];

        //
        return view('pengajuan.list', $data);
    }

    public function add($id)
    {
        //
        $pengajuan = SubmitPengajuan::where(['id_karyawan' => Auth::guard('karyawan')->user()->id])->get();
        // dd(Auth::guard('karyawan')->user()->id);
        $data = [
            'title'     => 'Dashboard Karyawan | PT. Maha Akbar Sejahtera',
            'id' => $id,
            'pengajuan' => $pengajuan

        ];

        //
        return view('pengajuan.add', $data);
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

    public function tracking($id)
    {
        $pengajuan = SubmitPengajuan::select('pengajuan.nama as nama_pengajuan', 'submit_pengajuan.current_tracking')->join('pengajuan', 'submit_pengajuan.id_pengajuan', '=', 'pengajuan.id')->findOrFail($id);
        // dd($pengajuan);
        $data = [
            'title'     => 'Dashboard Karyawan | PT. Maha Akbar Sejahtera',
            'pengajuan' => $pengajuan
        ];
        return view('pengajuan.tracking', $data);
    }

    public function archive()
    {
        $data = [
            'title'     => 'Dashboard Karyawan | PT. Maha Akbar Sejahtera'
        ];
        return view('pengajuan.archive', $data);
    }

    public function preview()
    {
        $nomor = NomorPengajuan::where(['id_pengajuan' => 15, 'tahun' => date('Y')])->value('nomor_terakhir');
        if (empty($nomor)) {
            $nomor = 1;
        } else {
            $nomor = $nomor + 1;
        }
        $data = [
            'title'     => 'Dashboard Karyawan | PT. Maha Akbar Sejahtera',
            'nomor'     => str_pad($nomor, 3, '0', STR_PAD_LEFT)
        ];
        return view('pengajuan.preview', $data);
    }

    public function approval()
    {
        $nomor = NomorPengajuan::where(['id_pengajuan' => 15, 'tahun' => date('Y')])->value('nomor_terakhir');
        if (empty($nomor)) {
            $nomor = 1;
        } else {
            $nomor = $nomor + 1;
        }
        $data = [
            'title'     => 'Dashboard Karyawan | PT. Maha Akbar Sejahtera',
            'nomor'     => str_pad($nomor, 3, '0', STR_PAD_LEFT)
        ];
        return view('pengajuan.approval', $data);
    }

    public function revisi()
    {
        $nomor = NomorPengajuan::where(['id_pengajuan' => 15, 'tahun' => date('Y')])->value('nomor_terakhir');
        if (empty($nomor)) {
            $nomor = 1;
        } else {
            $nomor = $nomor + 1;
        }
        $data = [
            'title'     => 'Dashboard Karyawan | PT. Maha Akbar Sejahtera',
            'nomor'     => str_pad($nomor, 3, '0', STR_PAD_LEFT)
        ];
        return view('pengajuan.approval', $data);
    }
}
