<?php

namespace App\Http\Controllers\Rencanakerja;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Karyawan;
use App\Models\Rencanakerja;

use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;

class KaryawanController extends Controller
{

    public function index()
    {

    }

    public function option()
    {
        return view('rencanakerja.karyawan.option');
    }

    public function listrkk(Request $request)
    {
        $idk = $request->session()->get('id_karyawan');
        $data = Rencanakerja::where('id_karyawan', $idk)->get();
        return view('rencanakerja.karyawan.listrkk')->with(compact('data'));
    }


    public function addrkk()
    {
        return view('rencanakerja.karyawan.add-rkk');
    }

    public function addrkkstore(Request $request)
    {
        $idk = $request->session()->get('id_karyawan');
        $file = $request->file('lampiran');
        $filename = $file->getClientOriginalName();
        $file_jadi = date('ymdhis') . $filename;
        $file->move(public_path('images/rencanakerja'), $file_jadi);
        $data = [
            'id_karyawan' => $idk,
            'perihal' => $request->perihal,
            'lokasi' => $request->lokasi,
            'waktu' => $request->waktu,
            'target_penyelesaian' => $request->target,
            'keterangan' => $request->keterangan,
            'lampiran' => $file_jadi,
            'prioritas' => $request->prioritas,
        ];
        Rencanakerja::create($data);
        return redirect('/karyawan/listrkk/')->with('success', 'Rencana Kerja Ditambah !');

    }

    public function detailrkk(string $id)
    {
        $data = Rencanakerja::where('id', $id)->first();
        return view('rencanakerja.karyawan.detail-rkk')->with(compact('data'));
    }

}
