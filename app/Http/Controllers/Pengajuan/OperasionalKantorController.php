<?php

namespace App\Http\Controllers\Pengajuan;

use App\Http\Controllers\Controller;
use App\Models\NomorPengajuan;
use App\Models\SubmitPengajuan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OperasionalKantorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $pengajuan = SubmitPengajuan::join('pengajuan', 'submit_pengajuan.id_pengajuan','=', 'pengajuan.id')->where(['id_karyawan'=>Auth::guard('karyawan')->user()->id])->get();
        $data = [
            'title'     => 'Dashboard Karyawan | PT. Maha Akbar Sejahtera',
            'pengajuan' => $pengajuan
        ];
        //
        return view('pengajuan.operasionalkantor.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $nomor = NomorPengajuan::where(['id_pengajuan' => 31, 'tahun' => date('Y')])->value('nomor_terakhir');
        if (empty($nomor)) {
            $nomor = 1;
        } else {
            $nomor = $nomor + 1;
        }
        $data = [
            'title'     => 'Dashboard Karyawan | PT. Maha Akbar Sejahtera',
            'nomor'     => str_pad($nomor, 3, '0', STR_PAD_LEFT)
        ];
        //
        return view('pengajuan.operasionalkantor.create', $data);
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
        // Validasi input
        $request->validate([
            'nomor' => 'required',
            'tanggal' => 'required|date',
            'due_date' => 'required|date',
            'perihal_pekerjaan' => 'required',
            'total_biaya' => 'required|numeric',
        ]);

        // Simpan data ke database
        $post = new SubmitPengajuan();
        $post->nomor = $request->input('nomor');
        $post->tanggal = $request->input('tanggal');
        $post->due_date = $request->input('due_date');
        $post->id_karyawan = Auth::guard('karyawan')->user()->id;
        $post->perihal_pekerjaan = $request->input('perihal_pekerjaan');
        $post->total_biaya = $request->input('total_biaya');
        $post->id_pengajuan = $request->input('id_pengajuan');
        $post->save();
        return redirect()->route('operasionalkantor.index');
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
}
