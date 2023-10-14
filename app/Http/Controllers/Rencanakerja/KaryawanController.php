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
        $karyawan = Karyawan::where('id', $idk)->first();
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
            if($karyawan->kode_dept == 'HR'){
                $data['manajer_approval'] = 1;
                $data['pm_approval'] = 1;
            }elseif ($karyawan->kode_dept == 'DU') {
                $data['manajer_approval'] = 1;
                $data['hrd_approval'] = 1;
                $data['pm_approval'] = 1;
            }else{
                $data['manajer_approval'] = 0;
                $data['hrd_approval'] = 0;
                $data['pm_approval'] = 0;
                $data['direktur_approval'] = 0;
                $data['komisaris_approval'] = 0;
            }
            Rencanakerja::create($data);
            return redirect('/karyawan/listrkk/')->with('success', 'Rencana Kerja Ditambah !');
        } else {
            return redirect()->back()->with('error', 'File yang diunggah harus berformat PDF.');
        }
    }

    public function detailrkk(string $id)
    {
        $data = Rencanakerja::where('id', $id)->first();
        return view('rencanakerja.karyawan.detail-rkk')->with(compact('data'));
    }

    public function revisi(string $id)
    {
        $data = Rencanakerja::where('id', $id)->first();
        return view('rencanakerja.karyawan.revisi')->with(compact('data'));
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
            if($karyawan->kode_dept == 'HR'){
                $data['manajer_approval'] = 1;
                $data['pm_approval'] = 1;
            }elseif ($karyawan->kode_dept == 'DU') {
                $data['manajer_approval'] = 1;
                $data['hrd_approval'] = 1;
                $data['pm_approval'] = 1;
            }else{
                $data['manajer_approval'] = 0;
                $data['hrd_approval'] = 0;
                $data['pm_approval'] = 0;
                $data['direktur_approval'] = 0;
                $data['komisaris_approval'] = 0;
            }
            $rkk = Rencanakerja::where('id', $id)->first();
            Storage::delete('public/images/rencanakerja/' . $rkk->lampiran);
            Rencanakerja::where('id', $id)->update($data);
            return redirect()->route('list-rkk')->with('success', 'Rencana Kerja Direvisi !');
        } else {
            return redirect()->back()->with('error', 'File yang diunggah harus berformat PDF.');
        }
    }

}
