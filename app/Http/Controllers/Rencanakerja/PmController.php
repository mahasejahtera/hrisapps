<?php

namespace App\Http\Controllers\Rencanakerja;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Karyawan;
use App\Models\Rencanakerja;

class PmController extends Controller
{

    public function option()
    {
        return view('rencanakerja.pm.option');

    }
    public function optiondepartment()
    {
        return view('rencanakerja.pm.option-department');
    }

    public function listrkk(Request $request)
    {
        $idk = $request->session()->get('id_karyawan');
        $data = Rencanakerja::where('id_karyawan', $idk)->get();
        return view('rencanakerja.pm.listrkk')->with(compact('data'));
    }
    public function listrkkengineering(Request $request)
    {
        $data = Rencanakerja::whereHas('karyawan', function ($query) {
            $query->where('kode_dept', 'TK')->whereIn('role_id', [1, 2]);
        })
        ->where('manajer_approval', 1)
        ->where('pm_approval', 0)
        ->where('hrd_approval', 0)
        ->where('direktur_approval', 0)
        ->where('komisaris_approval', 0)
        ->get();
        return view('rencanakerja.pm.listrkk-engineering')->with(compact('data'));
    }

    public function listrkkproduction(Request $request)
    {
        $data = Rencanakerja::whereHas('karyawan', function ($query) {
            $query->where('kode_dept', 'PR')->whereIn('role_id', [1, 2]);
        })
        ->where('manajer_approval', 1)
        ->where('pm_approval', 0)
        ->where('hrd_approval', 0)
        ->where('direktur_approval', 0)
        ->where('komisaris_approval', 0)
        ->get();
        return view('rencanakerja.pm.listrkk-production')->with(compact('data'));
    }

    public function addrkk(Request $request){
        return view('rencanakerja.pm.add-rkk');
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
            return redirect('/pm/listrkk/')->with('success', 'Rencana Kerja Ditambah !');
        } else {
            return redirect()->back()->with('error', 'File yang diunggah harus berformat PDF.');
        }
    }
    public function detailrkk(string $id)
    {
        $data = Rencanakerja::where('id', $id)->first();
        return view('rencanakerja.pm.detail-rkk')->with(compact('data'));
    }
    public function detailrkkeng(string $id)
    {
        $data = Rencanakerja::where('id', $id)->first();
        $updatedata = Rencanakerja::where('id', $id)->first();
        $updatedata->status = 1;
        $updatedata->save();
        return view('rencanakerja.pm.detail-rkk-eng')->with(compact('data'));
    }
    public function detailrkkpro(string $id)
    {
        $data = Rencanakerja::where('id', $id)->first();
        $updatedata = Rencanakerja::where('id', $id)->first();
        $updatedata->status = 1;
        $updatedata->save();
        return view('rencanakerja.pm.detail-rkk-pro')->with(compact('data'));
    }

    public function approvalpm(Request $request){
        $id = $request->id;
        $data = Rencanakerja::where('id', $id)->first();
        $karyawan = Karyawan::where('id', $data->id_karyawan)->first();
        $data->status = 0;
        $data->pm_approval = 1;
        $data->save();
        if($karyawan->kode_dept == 'TK'){
        return redirect()->route('pm-listrkk-eng')->with('success', 'Rencana Kerja Disetujui !');
        }else{
        return redirect()->route('pm-listrkk-pro')->with('success', 'Rencana Kerja Disetujui !');
        }
    }
}
