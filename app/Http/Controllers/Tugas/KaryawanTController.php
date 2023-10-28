<?php

namespace App\Http\Controllers\Tugas;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Karyawan;
use App\Models\Tugas;

class KaryawanTController extends Controller
{
    public function listtugas(Request $request)
    {
        $idk = $request->session()->get('id_karyawan');
        $data = Tugas::where('id_karyawan_penerima', $idk)->get();
        return view('tugas.karyawan.list')->with(compact('data'));
    }

    public function detailTugas(string $id)
    {
        $data = Tugas::where('id', $id)->first();
        return view('tugas.karyawan.detail', compact('data'));
    }

}
