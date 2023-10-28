<?php

namespace App\Http\Controllers\Tugas;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Karyawan;
use App\Models\Tugas;

class DirekturTController extends Controller
{
    public function option(Request $request)
    {
        return view('tugas.direktur.option');
    }

    public function listmasuk(Request $request)
    {
        $idk = $request->session()->get('id_karyawan');
        $data = Tugas::where('id_karyawan_penerima', $idk)->get();
        return view('tugas.direktur.masuk', compact('data'));
    }

    public function listkeluar(Request $request)
    {
        $idk = $request->session()->get('id_karyawan');
        $data = Tugas::where('id_karyawan_pengirim', $idk)->get();
        return view('tugas.direktur.keluar', compact('data'));
    }

    public function add(Request $request)
    {
        $idk = $request->session()->get('id_karyawan');
        $karyawan = Karyawan::where('id', $idk)->first();
        $kode_dept = $karyawan->kode_dept;
            $Allkaryawan = Karyawan::whereIn('role_id', [1,2,3])
            ->get();
        return view('tugas.direktur.add', compact('Allkaryawan', 'idk', 'kode_dept'));
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
            return redirect('/direktur/tugas/keluar')->with('success', 'Tugas Ditambah !');
        } else {
            return redirect()->back()->with('error', 'File yang diunggah harus berformat PDF.');
        }
    }

    public function detailKeluar(string $id)
    {
        $data = Tugas::where('id', $id)->first();
        return view('tugas.direktur.detail-keluar', compact('data'));
    }
    
    public function detailMasuk(string $id)
    {
        $data = Tugas::where('id', $id)->first();
        return view('tugas.direktur.detail-masuk', compact('data'));
    }
}
