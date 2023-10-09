<?php

namespace App\Http\Controllers\Rencanakerja;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Karyawan;
use App\Models\Rencanakerja;

class ManajerController extends Controller
{

    public function option()
    {
        return view('rencanakerja.manajer.option');
    }

    public function listrkk(Request $request)
    {
        $idk = $request->session()->get('id_karyawan');
        $data = Rencanakerja::where('id_karyawan', $idk)->get();
        return view('rencanakerja.manajer.listrkk')->with(compact('data'));
    }

    public function addrkk(Request $request){
        return view('rencanakerja.manajer.add-rkk');
    }

    public function addrkkstore(Request $request){
        $idk = $request->session()->get('id_karyawan');
        $file = $request->file('lampiran');
        if ($file->getClientOriginalExtension() === 'pdf') {
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
            return redirect('/manajer/listrkk/')->with('success', 'Rencana Kerja Ditambah !');
        } else {
            return redirect()->back()->with('error', 'File yang diunggah harus berformat PDF.');
        }
    }

    public function detailrkk(string $id)
    {
        $data = Rencanakerja::where('id', $id)->first();
        return view('rencanakerja.manajer.detail-rkk')->with(compact('data'));
    }

    public function detailrkkkaryawan(string $id)
    {
        $data = Rencanakerja::where('id', $id)->first();
        return view('rencanakerja.manajer.detail-rkk-karyawan')->with(compact('data'));
    }

    public function listrkkkaryawan(Request $request)
    {
    $idk = $request->session()->get('id_karyawan');
    $datak = Karyawan::where('id', $idk)->first();
    $data = Rencanakerja::join('karyawans', 'rencanakerjas.id_karyawan', '=', 'karyawans.id')
        ->where('karyawans.role_id', 1)
        ->where('karyawans.kode_dept', $datak->kode_dept)
        ->select('rencanakerjas.*')
        ->get();
    return view('rencanakerja.manajer.listrkk-karyawan')->with(compact('data'));
    }


}
