<?php

namespace App\Http\Controllers\Permintaan;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Permintaan;
use App\Models\Karyawan;

class KaryawanPController extends Controller
{

    public function option()
    {
        return view('permintaan.karyawan.option');
    }

    public function listmasuk(Request $request)
    {
        $idk = $request->session()->get('id_karyawan');
        $data = Permintaan::where('id_karyawan_penerima', $idk)->get();
        return view('permintaan.karyawan.masuk', compact('data'));
    }
    public function listkeluar(Request $request)
    {
        $idk = $request->session()->get('id_karyawan');
        $data = Permintaan::where('id_karyawan_pengirim', $idk)->get();
        return view('permintaan.karyawan.keluar', compact('data'));
    }

    public function add(Request $request)
    {
        $idk = $request->session()->get('id_karyawan');
        $karyawan = Karyawan::where('id', $idk)->first();
        $dept_karyawan = $karyawan->kode_dept;
        $kode_dept = $karyawan->kode_dept;
        if($dept_karyawan == 'PR' || $dept_karyawan == 'TK'){
            $Allkaryawan = Karyawan::whereIn('role_id', [1, 3, 4, 5])
            ->orWhere(function($query) use ($kode_dept) {
                $query->where('role_id', 2)->whereIn('kode_dept', [$kode_dept, 'HR']);
            })->get();
        }elseif($kode_dept == 'DU'){
            $Allkaryawan = Karyawan::whereIn('role_id', [4,5])->get();
        }else{
            $Allkaryawan = Karyawan::whereIn('role_id', [1, 4, 5])
            ->orWhere(function($query) use ($kode_dept) {
                $query->where('role_id', 2)->whereIn('kode_dept', [$kode_dept, 'HR']);
            })->get();
        }
        return view('permintaan.karyawan.add', compact('Allkaryawan', 'idk', 'kode_dept'));
    }

    public function detail(string $id)
    {
        $data = Permintaan::where('id', $id)->first();
        return view('permintaan.karyawan.detail', compact('data'));
    }

    public function detailMasuk(string $id)
    {
        $data = Permintaan::where('id', $id)->first();
        return view('permintaan.karyawan.detail-masuk', compact('data'));
    }

    public function addproses(Request $request)
    {
        $idk = $request->session()->get('id_karyawan');
        $karyawan = Karyawan::where('id', $request->penerima)->first();
        $karyawanPengirim = Karyawan::where('id', $idk)->first();
        $file = $request->file('lampiran_pengirim');
        if ($file->getClientOriginalExtension() === 'pdf') {
            $filename = $file->getClientOriginalName();
            $file_jadi = date('ymdhis') . $filename;
            $file->move(public_path('images/permintaan'), $file_jadi);
            $data = [
                'id_karyawan_pengirim' => $idk,
                'perihal' => $request->perihal,
                'lokasi' => $request->lokasi,
                'waktu' => $request->waktu,
                'jatuh_tempo' => $request->jatuh_tempo,
                'keterangan_pengirim' => $request->keterangan_pengirim,
                'lampiran_pengirim' => $file_jadi,
                'prioritas' => $request->prioritas,
                'id_karyawan_penerima' => $request->penerima,
            ];
            if($karyawanPengirim->role_id == 1 && $karyawanPengirim->kode_dept == 'HR' ){
                if($karyawan->role_id == 4 && $karyawan->kode_dept == 'DU'){
                    $data['manajer_approval'] = 1;
                    $data['pm_approval'] = 1;
                    $data['hrd_approval'] = 0;
                    $data['direktur_approval'] = 1;
                    $data['komisaris_approval'] = 1;
                    $data['status'] = 1;
                }elseif($karyawan->role_id == 5 && $karyawan->kode_dept == 'KM'){
                    $data['manajer_approval'] = 1;
                    $data['pm_approval'] = 1;
                    $data['hrd_approval'] = 0;
                    $data['direktur_approval'] = 0;
                    $data['komisaris_approval'] = 1;
                    $data['status'] = 1;
                }else{
                    $data['manajer_approval'] = 1;
                    $data['pm_approval'] = 1;
                    $data['hrd_approval'] = 1;
                    $data['direktur_approval'] = 1;
                    $data['komisaris_approval'] = 1;
                    $data['status'] = 1;
                }
            }elseif($karyawanPengirim->role_id == 1 && ($karyawanPengirim->kode_dept == 'TK' || $karyawanPengirim->kode_dept == 'PR')){
                if($karyawan->role_id == 2 &&  $karyawan->kode_dept != 'HR'){
                    $data['manajer_approval'] = 1;
                    $data['pm_approval'] = 1;
                    $data['hrd_approval'] = 1;
                    $data['direktur_approval'] = 1;
                    $data['komisaris_approval'] = 1;
                    $data['status'] = 1;
                }elseif($karyawan->role_id == 2 && $karyawan->kode_dept == 'HR'){
                    $data['manajer_approval'] = 0;
                    $data['pm_approval'] = 0;
                    $data['hrd_approval'] = 1;
                    $data['direktur_approval'] = 1;
                    $data['komisaris_approval'] = 1;
                    $data['status'] = 1;
                }elseif($karyawan->role_id == 3){
                    $data['manajer_approval'] = 0;
                    $data['pm_approval'] = 1;
                    $data['hrd_approval'] = 1;
                    $data['direktur_approval'] = 1;
                    $data['komisaris_approval'] = 1;
                    $data['status'] = 1;
                }elseif($karyawan->role_id == 4){
                    $data['manajer_approval'] = 0;
                    $data['pm_approval'] = 0;
                    $data['hrd_approval'] = 0;
                    $data['direktur_approval'] = 1;
                    $data['komisaris_approval'] = 1;
                    $data['status'] = 1;
                }elseif($karyawan->role_id ==5){
                    $data['manajer_approval'] = 0;
                    $data['pm_approval'] = 0;
                    $data['hrd_approval'] = 0;
                    $data['direktur_approval'] = 0;
                    $data['komisaris_approval'] = 1;
                    $data['status'] = 1;
                }else{
                    $data['manajer_approval'] = 1;
                    $data['pm_approval'] = 1;
                    $data['hrd_approval'] = 1;
                    $data['direktur_approval'] = 1;
                    $data['komisaris_approval'] = 1;
                    $data['status'] = 1;
                }
            }elseif($karyawanPengirim->kode_dept == 'DU'){
                if($karyawan->role_id == 5){
                    $data['manajer_approval'] = 1;
                    $data['pm_approval'] = 1;
                    $data['hrd_approval'] = 1;
                    $data['direktur_approval'] = 0;
                    $data['komisaris_approval'] = 1;
                    $data['status'] = 1;
                }else{
                    $data['manajer_approval'] = 1;
                    $data['pm_approval'] = 1;
                    $data['hrd_approval'] = 1;
                    $data['direktur_approval'] = 1;
                    $data['komisaris_approval'] = 1;
                    $data['status'] = 1;
                }
            }elseif($karyawan->role_id == 1){
                $data['manajer_approval'] = 1;
                $data['pm_approval'] = 1;
                $data['hrd_approval'] = 1;
                $data['direktur_approval'] = 1;
                $data['komisaris_approval'] = 1;
                $data['status'] = 1;
            }elseif($karyawan->role_id == 2 && $karyawan->kode_dept != 'HR'){
                $data['manajer_approval'] = 1;
                $data['pm_approval'] = 1;
                $data['hrd_approval'] = 1;
                $data['direktur_approval'] = 1;
                $data['komisaris_approval'] = 1;
                $data['status'] = 1;
            }elseif($karyawan->role_id == 2 && $karyawan->kode_dept == 'HR'){
                $data['manajer_approval'] = 0;
                $data['pm_approval'] = 1;
                $data['hrd_approval'] = 1;
                $data['direktur_approval'] = 1;
                $data['komisaris_approval'] = 1;
                $data['status'] = 1;
            }elseif($karyawan->role_id == 4){
                $data['manajer_approval'] = 0;
                $data['pm_approval'] = 1;
                $data['hrd_approval'] = 0;
                $data['direktur_approval'] = 1;
                $data['komisaris_approval'] = 1;
                $data['status'] = 1;

            }elseif($karyawan->role_id == 5){
                $data['manajer_approval'] = 0;
                $data['pm_approval'] = 1;
                $data['hrd_approval'] = 0;
                $data['direktur_approval'] = 0;
                $data['komisaris_approval'] = 1;
                $data['status'] = 1;
            }else{
                $data['manajer_approval'] = 1;
                $data['pm_approval'] = 1;
                $data['hrd_approval'] = 1;
                $data['direktur_approval'] = 1;
                $data['komisaris_approval'] = 1;
                $data['status'] = 1;
            }
            Permintaan::create($data);
            return redirect('/karyawan/permintaan/keluar')->with('success', 'Permintaan Ditambah !');
        } else {
            return redirect()->back()->with('error', 'File yang diunggah harus berformat PDF.');
        }
    }

    public function menolak(Request $request)
    {
        $id = $request->id;
        $data = [
            'keterangan_tolak' => $request->keterangan_tolak,
            'status' => 3,
        ];
        Permintaan::where('id', $id)->update($data);
        return redirect('/karyawan/permintaan/masuk')->with('success', 'Permintaan Ditolak !');
    }

    public function terima(Request $request)
    {
        $id = $request->id;
        $file = $request->file('lampiran_penerima');
        if ($file->getClientOriginalExtension() === 'pdf') {
            $filename = $file->getClientOriginalName();
            $file_jadi = date('ymdhis') . $filename;
            $file->move(public_path('images/permintaan'), $file_jadi);
            $data = [
                'keterangan_penerima' => $request->keterangan_penerima,
                'lampiran_penerima' => $file_jadi,
                'status' => 4,
            ];
            Permintaan::where('id', $id)->update($data);
            return redirect('/karyawan/permintaan/masuk')->with('success', 'Permintaan Diterima !');
        }else {
            return redirect()->back()->with('error', 'File yang diunggah harus berformat PDF.');
        }
    }

    public function revisi(Request $request)
    {
        $idk = $request->session()->get('id_karyawan');
        $karyawan = Karyawan::where('id', $idk)->first();
        $kode_dept = $karyawan->kode_dept;
        $Allkaryawan = Karyawan::whereIn('role_id', [1, 3, 4, 5])
        ->orWhere(function($query) use ($kode_dept) {
        $query->where('role_id', 2)->where('kode_dept', $kode_dept);
        })->get();
        return view('permintaan.karyawan.revisi', compact('Allkaryawan', 'idk'));
    }

    public function track(Request $request, string $id)
    {
        $idk = $request->session()->get('id_karyawan');
        $karyawan = Karyawan::where('id', $idk)->first();
        $data = Permintaan::where('id', $id)->first();
        $penerima = Karyawan::where('id', $data->karyawanPenerima->id)->first();

        return view('permintaan.karyawan.track')->with(compact('data', 'karyawan','penerima'));
    }


}
