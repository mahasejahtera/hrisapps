<?php

namespace App\Http\Controllers\Rencanakerja;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Karyawan;
use App\Models\Rencanakerja;

class DirekturController extends Controller
{
    public function option()
    {
        return view('rencanakerja.direktur.option');

    }

    public function optiondepartment()
    {
        $departments = ['TK', 'PR', 'GM', 'IT', 'SC', 'KU', 'PN', 'HR', 'DU']; // Daftar kode departemen yang ingin Anda saring

        $counts = [];
        foreach ($departments as $dept) {
            $query = Rencanakerja::whereHas('karyawan', function ($query) use ($dept) {
                $query->where('kode_dept', $dept)->whereIn('role_id', [1, 2, 3]);
            })
            ->where('manajer_approval', 1)
            ->where('pm_approval', 1)
            ->where('hrd_approval', 1)
            ->where('direktur_approval', 0)
            ->where('komisaris_approval', 0)
            ->count();
            $counts[$dept] = $query;
        }
        return view('rencanakerja.direktur.optiondepartment', compact('counts'));
    }

    public function listrkkdu(Request $request)
    {
        $data = Rencanakerja::whereHas('karyawan', function ($query) {
            $query->where('kode_dept', 'DU')->where('role_id', 1);
        })
        ->where('manajer_approval', 1)
        ->where('pm_approval', 1)
        ->where('hrd_approval', 1)
        ->where('direktur_approval', 0)
        ->where('komisaris_approval', 0)
        ->get();
        return view('rencanakerja.direktur.listrkk-du')->with(compact('data'));
    }

    public function listrkkeng(Request $request)
    {
        $data = Rencanakerja::whereHas('karyawan', function ($query) {
            $query->where('kode_dept', 'TK')->whereIn('role_id', [1, 2, 3]);
        })
        ->where('manajer_approval', 1)
        ->where('pm_approval', 1)
        ->where('hrd_approval', 1)
        ->where('direktur_approval', 0)
        ->where('komisaris_approval', 0)
        ->get();
        return view('rencanakerja.direktur.listrkk-eng')->with(compact('data'));
    }

    public function listrkkpro(Request $request)
    {
        $data = Rencanakerja::whereHas('karyawan', function ($query) {
            $query->where('kode_dept', 'PR')->whereIn('role_id', [1, 2, 3]);
        })
        ->where('manajer_approval', 1)
        ->where('pm_approval', 1)
        ->where('hrd_approval', 1)
        ->where('direktur_approval', 0)
        ->where('komisaris_approval', 0)
        ->get();
        return view('rencanakerja.direktur.listrkk-pro')->with(compact('data'));
    }

    public function listrkkscm(Request $request)
    {
        $data = Rencanakerja::whereHas('karyawan', function ($query) {
            $query->where('kode_dept', 'SC')->whereIn('role_id', [1, 2]);
        })
        ->where('manajer_approval', 1)
        ->where('pm_approval', 1)
        ->where('hrd_approval', 1)
        ->where('direktur_approval', 0)
        ->where('komisaris_approval', 0)
        ->get();
        return view('rencanakerja.direktur.listrkk-scm')->with(compact('data'));
    }

    public function listrkkit(Request $request)
    {
        $data = Rencanakerja::whereHas('karyawan', function ($query) {
            $query->where('kode_dept', 'IT')->whereIn('role_id', [1, 2]);
        })
        ->where('manajer_approval', 1)
        ->where('pm_approval', 1)
        ->where('hrd_approval', 1)
        ->where('direktur_approval', 0)
        ->where('komisaris_approval', 0)
        ->get();
        return view('rencanakerja.direktur.listrkk-it')->with(compact('data'));
    }

    public function listrkkhrd(Request $request)
    {
        $data = Rencanakerja::whereHas('karyawan', function ($query) {
            $query->where('kode_dept', 'HR')->whereIn('role_id', [1, 2]);
        })
        ->where('manajer_approval', 1)
        ->where('pm_approval', 1)
        ->where('hrd_approval', 1)
        ->where('direktur_approval', 0)
        ->where('komisaris_approval', 0)
        ->get();
        return view('rencanakerja.direktur.listrkk-hrd')->with(compact('data'));
    }

    public function listrkkfin(Request $request)
    {
        $data = Rencanakerja::whereHas('karyawan', function ($query) {
            $query->where('kode_dept', 'KU')->whereIn('role_id', [1,2]);
        })
        ->where('manajer_approval', 1)
        ->where('pm_approval', 1)
        ->where('hrd_approval', 1)
        ->where('direktur_approval', 0)
        ->where('komisaris_approval', 0)
        ->get();
        return view('rencanakerja.direktur.listrkk-fin')->with(compact('data'));
    }

    public function listrkkmr(Request $request)
    {
        $data = Rencanakerja::whereHas('karyawan', function ($query) {
            $query->where('kode_dept', 'PN')->whereIn('role_id', [1,2]);
        })
        ->where('manajer_approval', 1)
        ->where('pm_approval', 1)
        ->where('hrd_approval', 1)
        ->where('direktur_approval', 0)
        ->where('komisaris_approval', 0)
        ->get();
        return view('rencanakerja.direktur.listrkk-mr')->with(compact('data'));
    }

    public function detailrkkdu(string $id)
    {
        $data = Rencanakerja::where('id', $id)->first();
        $updatedata = Rencanakerja::where('id', $id)->first();
        if($data->status == 0){
            $updatedata->status = 1;
            $updatedata->save();
        }
        return view('rencanakerja.direktur.detail-rkk-du')->with(compact('data'));
    }

    public function detailrkkeng(string $id)
    {
        $data = Rencanakerja::where('id', $id)->first();
        $updatedata = Rencanakerja::where('id', $id)->first();
        if($data->status == 0){
            $updatedata->status = 1;
            $updatedata->save();
        }
        return view('rencanakerja.direktur.detail-rkk-eng')->with(compact('data'));
    }

    public function detailrkkpro(string $id)
    {
        $data = Rencanakerja::where('id', $id)->first();
        $updatedata = Rencanakerja::where('id', $id)->first();
        if($data->status == 0){
            $updatedata->status = 1;
            $updatedata->save();
        }
        return view('rencanakerja.direktur.detail-rkk-pro')->with(compact('data'));
    }

    public function detailrkkfin(string $id)
    {
        $data = Rencanakerja::where('id', $id)->first();
        $updatedata = Rencanakerja::where('id', $id)->first();
        if($data->status == 0){
            $updatedata->status = 1;
            $updatedata->save();
        }
        return view('rencanakerja.direktur.detail-rkk-fin')->with(compact('data'));
    }

    public function detailrkkit(string $id)
    {
        $data = Rencanakerja::where('id', $id)->first();
        $updatedata = Rencanakerja::where('id', $id)->first();
        if($data->status == 0){
            $updatedata->status = 1;
            $updatedata->save();
        }
        return view('rencanakerja.direktur.detail-rkk-it')->with(compact('data'));
    }

    public function detailrkkmr(string $id)
    {
        $data = Rencanakerja::where('id', $id)->first();
        $updatedata = Rencanakerja::where('id', $id)->first();
        if($data->status == 0){
            $updatedata->status = 1;
            $updatedata->save();
        }
        return view('rencanakerja.direktur.detail-rkk-mr')->with(compact('data'));
    }

    public function detailrkkscm(string $id)
    {
        $data = Rencanakerja::where('id', $id)->first();
        $updatedata = Rencanakerja::where('id', $id)->first();
        if($data->status == 0){
            $updatedata->status = 1;
            $updatedata->save();
        }
        return view('rencanakerja.direktur.detail-rkk-scm')->with(compact('data'));
    }

    public function detailrkkhrd(string $id)
    {
        $data = Rencanakerja::where('id', $id)->first();
        $updatedata = Rencanakerja::where('id', $id)->first();
        if($data->status == 0){
            $updatedata->status = 1;
            $updatedata->save();
        }
        return view('rencanakerja.direktur.detail-rkk-hrd')->with(compact('data'));
    }

    public function approvaldirektur(Request $request){
        $id = $request->id;
        $data = Rencanakerja::where('id', $id)->first();
        $karyawan = Karyawan::where('id', $data->id_karyawan)->first();
        $data->direktur_approval = 1;
        $data->status = 0;
        $data->save();
        if($karyawan->kode_dept == 'TK'){
            return redirect()->route('direktur-listrkk-eng')->with('success', 'Rencana Kerja Disetujui !');
        }elseif($karyawan->kode_dept == 'PR'){
            return redirect()->route('direktur-listrkk-pro')->with('success', 'Rencana Kerja Disetujui !');
        }elseif($karyawan->kode_dept == 'SC'){
            return redirect()->route('direktur-listrkk-scm')->with('success', 'Rencana Kerja Disetujui !');
        }elseif($karyawan->kode_dept == 'IT'){
            return redirect()->route('direktur-listrkk-it')->with('success', 'Rencana Kerja Disetujui !');
        }elseif($karyawan->kode_dept == 'KU'){
            return redirect()->route('direktur-listrkk-fin')->with('success', 'Rencana Kerja Disetujui !');
        }elseif($karyawan->kode_dept == 'PN'){
            return redirect()->route('direktur-listrkk-mr')->with('success', 'Rencana Kerja Disetujui !');
        }elseif($karyawan->kode_dept == 'HR'){
            return redirect()->route('direktur-listrkk-hrd')->with('success', 'Rencana Kerja Disetujui !');
        }elseif($karyawan->kode_dept == 'DU'){
            return redirect()->route('direktur-listrkk-du')->with('success', 'Rencana Kerja Disetujui !');
        }else{
            return redirect()->route('dpoption')->with('error', 'Departemen tidak ditemukan');
        }
    }

    public function revisirkk(Request $request) {
        $id = $request->id;
        $datakaryawan = Rencanakerja::where('id', $id)->first();
        $file = $request->file('lampiran');
        if ($file->getClientOriginalExtension() === 'pdf') {
            $filename = $file->getClientOriginalName();
            $file_jadi = date('ymdhis') . $filename;
            $file->move(public_path('images/rencanakerja/revisi'), $file_jadi);
            $data = [
                'status' => 3,
                'lampiran_revisi' => $file_jadi,
                'ket_revisi' => $request->keterangan,
            ];
            Rencanakerja::where('id', $id)->update($data);
            if($datakaryawan->karyawan->kode_dept === 'TK'){
                return redirect('/direktur/eng')->with('success', 'Revisi Dikirim!');
            }elseif($datakaryawan->karyawan->kode_dept === 'PR'){
                return redirect('/direktur/pro')->with('success', 'Revisi Dikirim!');
            }elseif($datakaryawan->karyawan->kode_dept === 'SC'){
                return redirect('/direktur/scm')->with('success', 'Revisi Dikirim!');
            }elseif($datakaryawan->karyawan->kode_dept === 'IT'){
                return redirect('/direktur/it')->with('success', 'Revisi Dikirim!');
            }elseif($datakaryawan->karyawan->kode_dept === 'KU'){
                return redirect('/direktur/fin')->with('success', 'Revisi Dikirim!');
            }elseif($datakaryawan->karyawan->kode_dept === 'PN'){
                return redirect('/direktur/mr')->with('success', 'Revisi Dikirim!');
            }elseif($datakaryawan->karyawan->kode_dept === 'HR'){
                return redirect('/direktur/hr')->with('success', 'Revisi Dikirim!');
            }elseif($datakaryawan->karyawan->kode_dept === 'GM'){
                return redirect('/direktur/pm')->with('success', 'Revisi Dikirim!');
            }elseif($datakaryawan->karyawan->kode_dept === 'DU'){
                return redirect('/direktur/du')->with('success', 'Revisi Dikirim!');
            }else {
            return redirect()->back()->with('error', 'File yang diunggah harus berformat PDF.');
            }
        }
    }
}