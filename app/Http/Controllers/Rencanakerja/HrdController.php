<?php

namespace App\Http\Controllers\Rencanakerja;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Karyawan;
use App\Models\Rencanakerja;

class HrdController extends Controller
{

    public function option(Request $request)
    {
        $idk = $request->session()->get('id_karyawan');
        $data = Rencanakerja::where('id_karyawan', $idk)
                    ->where('komisaris_approval', 0)
                    ->get();
        $jml = $data->count();
        return view('rencanakerja.hrd.option', compact('jml'));
    }

    public function optiondepartment(Request $request)
    {
        $departments = ['TK', 'PR', 'GM', 'IT', 'SC', 'KU', 'PN', 'HR']; 
        $counts = [];
        foreach ($departments as $dept) {
            $query = Rencanakerja::whereHas('karyawan', function ($query) use ($dept) {
                $query->where('kode_dept', $dept)->whereIn('role_id', [1, 2, 3]);
            })
            ->where('manajer_approval', 1)
            ->where('pm_approval', 1)
            ->where('hrd_approval', 0)
            ->where('direktur_approval', 0)
            ->where('komisaris_approval', 0)
            ->count();

            if ($dept === 'HR') {
                $hrQuery = Rencanakerja::whereHas('karyawan', function ($query) {
                    $query->where('kode_dept', 'HR')->where('role_id', 1);
                })
                ->where('manajer_approval', 1)
                ->where('pm_approval', 1)
                ->where('hrd_approval', 0)
                ->where('direktur_approval', 0)
                ->where('komisaris_approval', 0)
                ->count();

                $counts[$dept] = $hrQuery;
            } else {
                $counts[$dept] = $query;
            }
        }

        return view('rencanakerja.hrd.optiondepartment', compact('counts'));
    }

    public function listrkk(Request $request)
    {
        $idk = $request->session()->get('id_karyawan');
        $data = Rencanakerja::where('id_karyawan', $idk)->get();
        return view('rencanakerja.hrd.listrkk')->with(compact('data'));
    }

    public function addrkk()
    {
        return view('rencanakerja.hrd.add-rkk');
    }

    public function addrkkstore(Request $request)
    {
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
                'manajer_approval' => 1,
                'pm_approval' => 1,
                'hrd_approval' => 1,
            ];
            Rencanakerja::create($data);
            return redirect('/manajer/hrd/listrkk/')->with('success', 'Rencana Kerja Ditambah !');
        } else {
            return redirect()->back()->with('error', 'File yang diunggah harus berformat PDF.');
        }
    }

    public function detailrkk(string $id)
    {
        $data = Rencanakerja::where('id', $id)->first();
        return view('rencanakerja.hrd.detail-rkk')->with(compact('data'));
    }

    public function listrkkeng(Request $request)
    {
        $data = Rencanakerja::whereHas('karyawan', function ($query) {
            $query->where('kode_dept', 'TK')->whereIn('role_id', [1, 2, 3]);
        })
        ->where('manajer_approval', 1)
        ->where('pm_approval', 1)
        ->where('hrd_approval', 0)
        ->where('direktur_approval', 0)
        ->where('komisaris_approval', 0)
        ->get();
        return view('rencanakerja.hrd.listrkk-eng')->with(compact('data'));
    }

    public function listrkkpro(Request $request)
    {
        $data = Rencanakerja::whereHas('karyawan', function ($query) {
            $query->where('kode_dept', 'PR')->whereIn('role_id', [1, 2, 3]);
        })
        ->where('manajer_approval', 1)
        ->where('pm_approval', 1)
        ->where('hrd_approval', 0)
        ->where('direktur_approval', 0)
        ->where('komisaris_approval', 0)
        ->get();
        return view('rencanakerja.hrd.listrkk-pro')->with(compact('data'));
    }

    public function listrkkpm(Request $request)
    {
        $data = Rencanakerja::whereHas('karyawan', function ($query) {
            $query->where('kode_dept', 'GM')->where('role_id', 3);
        })
        ->where('manajer_approval', 1)
        ->where('pm_approval', 1)
        ->where('hrd_approval', 0)
        ->where('direktur_approval', 0)
        ->where('komisaris_approval', 0)
        ->get();
        return view('rencanakerja.hrd.listrkk-pm')->with(compact('data'));
    }

    public function listrkkscm(Request $request)
    {
        $data = Rencanakerja::whereHas('karyawan', function ($query) {
            $query->where('kode_dept', 'SC')->whereIn('role_id', [1, 2]);
        })
        ->where('manajer_approval', 1)
        ->where('pm_approval', 1)
        ->where('hrd_approval', 0)
        ->where('direktur_approval', 0)
        ->where('komisaris_approval', 0)
        ->get();
        return view('rencanakerja.hrd.listrkk-scm')->with(compact('data'));
    }

    public function listrkkit(Request $request)
    {
        $data = Rencanakerja::whereHas('karyawan', function ($query) {
            $query->where('kode_dept', 'IT')->whereIn('role_id', [1, 2]);
        })
        ->where('manajer_approval', 1)
        ->where('pm_approval', 1)
        ->where('hrd_approval', 0)
        ->where('direktur_approval', 0)
        ->where('komisaris_approval', 0)
        ->get();
        return view('rencanakerja.hrd.listrkk-it')->with(compact('data'));
    }

    public function listrkkhrd(Request $request)
    {
        $data = Rencanakerja::whereHas('karyawan', function ($query) {
            $query->where('kode_dept', 'HR')->where('role_id', 1);
        })
        ->where('manajer_approval', 1)
        ->where('pm_approval', 1)
        ->where('hrd_approval', 0)
        ->where('direktur_approval', 0)
        ->where('komisaris_approval', 0)
        ->get();
        return view('rencanakerja.hrd.listrkk-hrd')->with(compact('data'));
    }

    public function listrkkfin(Request $request)
    {
        $data = Rencanakerja::whereHas('karyawan', function ($query) {
            $query->where('kode_dept', 'KU')->whereIn('role_id', [1,2]);
        })
        ->where('manajer_approval', 1)
        ->where('pm_approval', 1)
        ->where('hrd_approval', 0)
        ->where('direktur_approval', 0)
        ->where('komisaris_approval', 0)
        ->get();
        return view('rencanakerja.hrd.listrkk-fin')->with(compact('data'));
    }

    public function listrkkmr(Request $request)
    {
        $data = Rencanakerja::whereHas('karyawan', function ($query) {
            $query->where('kode_dept', 'PN')->whereIn('role_id', [1,2]);
        })
        ->where('manajer_approval', 1)
        ->where('pm_approval', 1)
        ->where('hrd_approval', 0)
        ->where('direktur_approval', 0)
        ->where('komisaris_approval', 0)
        ->get();
        return view('rencanakerja.hrd.listrkk-mr')->with(compact('data'));
    }

    public function detailrkkeng(string $id)
    {
        $data = Rencanakerja::where('id', $id)->first();
        $updatedata = Rencanakerja::where('id', $id)->first();
        if($data->status == 0){
            $updatedata->status = 1;
            $updatedata->save();
        }
        return view('rencanakerja.hrd.detail-rkk-eng')->with(compact('data'));
    }

    public function detailrkkpro(string $id)
    {
        $data = Rencanakerja::where('id', $id)->first();
        $updatedata = Rencanakerja::where('id', $id)->first();
        if($data->status == 0){
            $updatedata->status = 1;
            $updatedata->save();
        }
        return view('rencanakerja.hrd.detail-rkk-pro')->with(compact('data'));
    }

    public function detailrkkfin(string $id)
    {
        $data = Rencanakerja::where('id', $id)->first();
        $updatedata = Rencanakerja::where('id', $id)->first();
        if($data->status == 0){
            $updatedata->status = 1;
            $updatedata->save();
        }
        return view('rencanakerja.hrd.detail-rkk-fin')->with(compact('data'));
    }

    public function detailrkkit(string $id)
    {
        $data = Rencanakerja::where('id', $id)->first();
        $updatedata = Rencanakerja::where('id', $id)->first();
        if($data->status == 0){
            $updatedata->status = 1;
            $updatedata->save();
        }
        return view('rencanakerja.hrd.detail-rkk-it')->with(compact('data'));
    }

    public function detailrkkmr(string $id)
    {
        $data = Rencanakerja::where('id', $id)->first();
        $updatedata = Rencanakerja::where('id', $id)->first();
        if($data->status == 0){
            $updatedata->status = 1;
            $updatedata->save();
        }
        return view('rencanakerja.hrd.detail-rkk-mr')->with(compact('data'));
    }

    public function detailrkkscm(string $id)
    {
        $data = Rencanakerja::where('id', $id)->first();
        $updatedata = Rencanakerja::where('id', $id)->first();
        if($data->status == 0){
            $updatedata->status = 1;
            $updatedata->save();
        }
        return view('rencanakerja.hrd.detail-rkk-scm')->with(compact('data'));
    }

    public function detailrkkhrd(string $id)
    {
        $data = Rencanakerja::where('id', $id)->first();
        $updatedata = Rencanakerja::where('id', $id)->first();
        if($data->status == 0){
            $updatedata->status = 1;
            $updatedata->save();
        }
        return view('rencanakerja.hrd.detail-rkk-hrd')->with(compact('data'));
    }
    public function detailrkkpm(string $id)
    {
        $data = Rencanakerja::where('id', $id)->first();
        $updatedata = Rencanakerja::where('id', $id)->first();
        if($data->status == 0){
            $updatedata->status = 1;
            $updatedata->save();
        }
        return view('rencanakerja.hrd.detail-rkk-pm')->with(compact('data'));
    }

    public function approvalhrd(Request $request){
        $id = $request->id;
        $data = Rencanakerja::where('id', $id)->first();
        $karyawan = Karyawan::where('id', $data->id_karyawan)->first();
        $data->hrd_approval = 1;
        $data->status = 0;
        $data->save();
        if($karyawan->kode_dept == 'TK'){
            return redirect()->route('hrd-listrkk-eng')->with('success', 'Rencana Kerja Disetujui !');
        }elseif($karyawan->kode_dept == 'PR'){
            return redirect()->route('hrd-listrkk-pro')->with('success', 'Rencana Kerja Disetujui !');
        }elseif($karyawan->kode_dept == 'SC'){
            return redirect()->route('hrd-listrkk-scm')->with('success', 'Rencana Kerja Disetujui !');
        }elseif($karyawan->kode_dept == 'IT'){
            return redirect()->route('hrd-listrkk-it')->with('success', 'Rencana Kerja Disetujui !');
        }elseif($karyawan->kode_dept == 'KU'){
            return redirect()->route('hrd-listrkk-fin')->with('success', 'Rencana Kerja Disetujui !');
        }elseif($karyawan->kode_dept == 'PN'){
            return redirect()->route('hrd-listrkk-mr')->with('success', 'Rencana Kerja Disetujui !');
        }elseif($karyawan->kode_dept == 'HR'){
            return redirect()->route('hrd-listrkk-hrd')->with('success', 'Rencana Kerja Disetujui !');
        }elseif($karyawan->kode_dept == 'GM'){
            return redirect()->route('hrd-listrkk-pm')->with('success', 'Rencana Kerja Disetujui !');
        }else{
            return redirect()->route('listrkk-hrd')->with('error', 'Departemen tidak ditemukan');
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
                return redirect('/manajer/hrd/eng')->with('success', 'Revisi Dikirim!');
            }elseif($datakaryawan->karyawan->kode_dept === 'PR'){
                return redirect('/manajer/hrd/pro')->with('success', 'Revisi Dikirim!');
            }elseif($datakaryawan->karyawan->kode_dept === 'SC'){
                return redirect('/manajer/hrd/scm')->with('success', 'Revisi Dikirim!');
            }elseif($datakaryawan->karyawan->kode_dept === 'IT'){
                return redirect('/manajer/hrd/it')->with('success', 'Revisi Dikirim!');
            }elseif($datakaryawan->karyawan->kode_dept === 'KU'){
                return redirect('/manajer/hrd/fin')->with('success', 'Revisi Dikirim!');
            }elseif($datakaryawan->karyawan->kode_dept === 'PN'){
                return redirect('/manajer/hrd/mr')->with('success', 'Revisi Dikirim!');
            }elseif($datakaryawan->karyawan->kode_dept === 'HR'){
                return redirect('/manajer/hrd/hr')->with('success', 'Revisi Dikirim!');
            }elseif($datakaryawan->karyawan->kode_dept === 'GM'){
                return redirect('/manajer/hrd/pm')->with('success', 'Revisi Dikirim!');
            }else {
            return redirect()->back()->with('error', 'File yang diunggah harus berformat PDF.');
            }
        }
    }

    public function revisiadd(string $id)
    {
        $data = Rencanakerja::where('id', $id)->first();
        return view('rencanakerja.hrd.revisi')->with(compact('data'));
    }

    public function revisiproses(Request $request)
    {
        $id = $request->id;
        $file = $request->file('lampiran');
        if ($file->getClientOriginalExtension() === 'pdf') {
            $filename = $file->getClientOriginalName();
            $file_jadi = date('ymdhis') . $filename;
            $file->move(public_path('images/rencanakerja'), $file_jadi);
        $data = [
            'status' => 0,
            'manajer_approval' => 1,
            'hrd_approval' => 1,
            'pm_approval' => 1,
            'direktur_approval' => 0,
            'komisaris_approval' => 0,
            'perihal' => $request->perihal,
            'lokasi' => $request->lokasi,
            'waktu' => $request->waktu,
            'target_penyelesaian' => $request->target,
            'keterangan' => $request->keterangan,
            'lampiran' => $file_jadi,
            'prioritas' => $request->prioritas,
        ];
        Rencanakerja::where('id', $id)->update($data);
        return redirect()->route('list-rkk-hrd')->with('success', 'Rencana Kerja Direvisi !');
        } else {
            return redirect()->back()->with('error', 'File yang diunggah harus berformat PDF.');
        }
    }
}
