<?php

namespace App\Http\Controllers\Permintaan;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Permintaan;
use App\Models\Karyawan;

class HrdPController extends Controller
{
    public function option()
    {
        return view('permintaan.hrd.option');
    }

    public function listmasuk(Request $request)
    {
        $idk = $request->session()->get('id_karyawan');
        $data = Permintaan::where('id_karyawan_penerima', $idk)
        ->where('manajer_approval', 1)
        ->where('pm_approval', 1)
        ->get();
        return view('permintaan.hrd.masuk', compact('data'));
    }

    public function detailMasuk(string $id)
    {
        $data = Permintaan::where('id', $id)->first();
        return view('permintaan.hrd.detail-masuk', compact('data'));
    }

    public function menolak(Request $request)
    {
        $id = $request->id;
        $data = [
            'keterangan_tolak' => $request->keterangan_tolak,
            'status' => 3,
        ];
        Permintaan::where('id', $id)->update($data);
        return redirect('/manajer/hrd/permintaan/masuk')->with('success', 'Permintaan Ditolak !');
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
            return redirect('/manajer/hrd/permintaan/masuk')->with('success', 'Permintaan Diterima !');
        }else {
            return redirect()->back()->with('error', 'File yang diunggah harus berformat PDF.');
        }
    }

    public function listkeluar(Request $request)
    {
        $idk = $request->session()->get('id_karyawan');
        $data = Permintaan::where('id_karyawan_pengirim', $idk)->get();
        return view('permintaan.hrd.keluar', compact('data'));
    }

    public function listpersetujuan(Request $request)
    {
    $idk = $request->session()->get('id_karyawan');
    $karyawan = Karyawan::where('id', $idk)->first();
    $data = Permintaan::where('hrd_approval', 0)
        ->where('manajer_approval', 1)
        ->where('pm_approval', 1)
        ->get();
    return view('permintaan.hrd.persetujuan', compact('data'));
    }

    public function detailPersetujuan(string $id)
    {
    $data = Permintaan::where('id', $id)->first();
    return view('permintaan.hrd.detail-persetujuan', compact('data'));
    }

    public function menolakPersetujuan(Request $request)
    {
        $id = $request->id;
        $data = [
            'keterangan_tolak' => $request->keterangan_tolak,
            'status' => 3,
        ];
        Permintaan::where('id', $id)->update($data);
        return redirect('/manajer/hrd/permintaan/persetujuan')->with('success', 'Permintaan Ditolak !');
    }

    public function terimaPersetujuan(Request $request)
    {
        $id = $request->id;
        $data = [
            'hrd_approval' => 1,
        ];
        Permintaan::where('id', $id)->update($data);
        return redirect('/manajer/hrd/permintaan/persetujuan')->with('success', 'Permintaan Disetujui !');
    }

    public function add(Request $request)
    {
        $idk = $request->session()->get('id_karyawan');
        $karyawan = Karyawan::where('id', $idk)->first();
        $Allkaryawan = Karyawan::whereIn('role_id', [2,3, 4, 5])->get();
        return view('permintaan.hrd.add', compact('Allkaryawan', 'idk'));
    }

    public function addproses(Request $request)
    {
        $idk = $request->session()->get('id_karyawan');
        $karyawan = Karyawan::where('id', $request->penerima)->first();
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
           if ($karyawan->role_id ==  2 || $karyawan->role_id ==  3 || $karyawan->role_id == 4) {
                $data['manajer_approval'] = 1;
                $data['hrd_approval'] = 1;
                $data['pm_approval'] = 1;
                $data['direktur_approval'] = 1;
                $data['komisaris_approval'] = 1;
                $data['status'] = 1;
            }else{
                $data['manajer_approval'] = 1;
                $data['hrd_approval'] = 1;
                $data['pm_approval'] = 1;
                $data['direktur_approval'] = 0;
                $data['komisaris_approval'] = 1;
                $data['status'] = 1;
            }
            Permintaan::create($data);
            return redirect('/manajer/hrd/permintaan/keluar')->with('success', 'Permintaan Ditambah !');
        } else {
            return redirect()->back()->with('error', 'File yang diunggah harus berformat PDF.');
        }
    }
    public function detailKeluar(string $id)
    {
        $data = Permintaan::where('id', $id)->first();
        return view('permintaan.manajer.detail-keluar', compact('data'));
    }
}
