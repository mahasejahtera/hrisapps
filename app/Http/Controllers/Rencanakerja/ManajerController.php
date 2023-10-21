<?php

namespace App\Http\Controllers\Rencanakerja;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Karyawan;
use App\Models\Rencanakerja;
use Illuminate\Support\Facades\Storage;

class ManajerController extends Controller
{

    public function option(Request $request)
    {
        $idk = $request->session()->get('id_karyawan');
        $data = Rencanakerja::where('id_karyawan', $idk)
                    ->where('komisaris_approval', 0)
                    ->get();
        $datak = Karyawan::where('id', $idk)->first();
        $datakaryawan = Rencanakerja::join('karyawans', 'rencanakerjas.id_karyawan', '=', 'karyawans.id')
        ->where('karyawans.role_id', 1)
        ->where('karyawans.kode_dept', $datak->kode_dept)
        ->where('rencanakerjas.manajer_approval', 0)
        ->select('rencanakerjas.*')
        ->get();
        $jmlpribadi = $data->count();
        $jmlkaryawan = $datakaryawan->count();
        return view('rencanakerja.manajer.option', compact('jmlpribadi', 'jmlkaryawan'));
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
                'manajer_approval' => 1,
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
        $updatedata = Rencanakerja::where('id', $id)->first();
        if($data->status == 0){
            $updatedata->status = 1;
            $updatedata->save();
        }
        return view('rencanakerja.manajer.detail-rkk-karyawan')->with(compact('data'));
    }

    public function listrkkkaryawan(Request $request)
    {
    $idk = $request->session()->get('id_karyawan');
    $datak = Karyawan::where('id', $idk)->first();
    $data = Rencanakerja::join('karyawans', 'rencanakerjas.id_karyawan', '=', 'karyawans.id')
        ->where('karyawans.role_id', 1)
        ->where('karyawans.kode_dept', $datak->kode_dept)
        ->where('rencanakerjas.manajer_approval', 0)
        ->select('rencanakerjas.*')
        ->get();
    return view('rencanakerja.manajer.listrkk-karyawan')->with(compact('data'));
    }

    public function approvalmanajer(Request $request){
        $id = $request->id;
        $data = Rencanakerja::where('id', $id)->first();
        $karyawan = Karyawan::where('id', $data->id_karyawan)->first();
        $data->manajer_approval = 1;
        $data->status = 0;
        if($karyawan->kode_dept == 'TK' || $karyawan->kode_dept == 'PR'){
            $data->pm_approval = 0;
        }else{
            $data->pm_approval = 1;
        }
        $data->save();
        return redirect()->route('manajer-listrkk-karyawan')->with('success', 'Rencana Kerja Disetujui !');
    }

    public function revisirkk(Request $request) {
        $id = $request->id;
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
            $rkk = Rencanakerja::where('id', $id)->first();
            if ($rkk->lampiran_revisi) {
                Storage::delete('public/images/rencanakerja/revisi/' . $rkk->lampiran_revisi);
            }
            Rencanakerja::where('id', $id)->update($data);
            return redirect('/manajer/listrkk/karyawan')->with('success', 'Revisi Dikirim!');
        } else {
            return redirect()->back()->with('error', 'File yang diunggah harus berformat PDF.');
        }
    }

    public function detailrevisi(string $id)
    {
        $data = Rencanakerja::where('id', $id)->first();
        return view('rencanakerja.manajer.detail-revisi')->with(compact('data'));
    }

    public function revisiadd(string $id)
    {
        $data = Rencanakerja::where('id', $id)->first();
        return view('rencanakerja.manajer.revisi')->with(compact('data'));
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
            'hrd_approval' => 0,
            'pm_approval' => 0,
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
        return redirect()->route('list-rkk-manajer')->with('success', 'Rencana Kerja Direvisi !');
        } else {
            return redirect()->back()->with('error', 'File yang diunggah harus berformat PDF.');
        }
    }

}
