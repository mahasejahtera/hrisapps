<?php

namespace App\Http\Controllers\Tugas;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Karyawan;
use App\Models\Tugas;
class KomisarisTController extends Controller
{

    public function list(Request $request)
    {
        $idk = $request->session()->get('id_karyawan');
        $data = Tugas::where('id_karyawan_pengirim', $idk)->get();
        return view('tugas.komisaris.list', compact('data'));
    }

    public function add(Request $request)
    {
        $idk = $request->session()->get('id_karyawan');
        $karyawan = Karyawan::where('id', $idk)->first();
        $kode_dept = $karyawan->kode_dept;
            $Allkaryawan = Karyawan::whereIn('role_id', [1,2,3,4])
            ->get();
        return view('tugas.komisaris.add', compact('Allkaryawan', 'idk', 'kode_dept'));
    }

    public function addproses(Request $request)
    {
        $idk = $request->session()->get('id_karyawan');
        $file = $request->file('lampiran_pengirim');
        if ($file->getClientOriginalExtension() === 'pdf') {
            $filename = $file->getClientOriginalName();
            $file_jadi = date('ymdhis') . $filename;
            $file->move(public_path('images/tugas'), $file_jadi);
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
                'status' => 1,
            ];
            Tugas::create($data);
            return redirect('/komisaris/tugas/list')->with('success', 'Tugas Ditambah !');
        } else {
            return redirect()->back()->with('error', 'File yang diunggah harus berformat PDF.');
        }
    }

    public function detail(string $id)
    {
        $data = Tugas::where('id', $id)->first();
        return view('tugas.komisaris.detail', compact('data'));
    }
}