<?php

namespace App\Http\Controllers\Pengajuan;

use App\Http\Controllers\Controller;
use App\Models\SubmitPengajuan;
use Illuminate\Http\Request;

class HutangOperasionalController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {
        session([
            'id' => 9,
            'kode_dept' => 2
        ]);
    }

    public function index()
    {
        //
        $pengajuan = SubmitPengajuan::where(['id_karyawan'=>session('id')])->get();
        // dd($pengajuan);
        $data = [
            'title'     => 'Dashboard Karyawan | PT. Maha Akbar Sejahtera',
            'pengajuan' => $pengajuan
        ];

        //
        return view('pengajuan.hutangoperasional.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data = [
            'title'     => 'Dashboard Karyawan | PT. Maha Akbar Sejahtera'
        ];
        //
        return view('pengajuan.hutangoperasional.create', $data);
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
        $post->id_karyawan = session('id');
        $post->id_karyawan = session('id');
        $post->perihal_pekerjaan = $request->input('perihal_pekerjaan');
        $post->total_biaya = $request->input('total_biaya');
        $post->save();
        return redirect()->route('hutangoperasional.index');
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
