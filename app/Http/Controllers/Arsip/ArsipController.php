<?php

namespace App\Http\Controllers\Arsip;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Karyawan;
use App\Models\Rencanakerja;

class ArsipController extends Controller
{

    public function option()
    {
        return view('arsip.option');
    }

    public function listarsiprkk(Request $request)
    {
        $idk = $request->session()->get('id_karyawan');
        $data = Rencanakerja::where('id_karyawan', $idk)
        ->where('komisaris_approval', 1)
        ->get();
        return view('arsip.rkk', compact('data'));
    }

    public function detailrkk(string $id)
    {
        $data = Rencanakerja::where('id', $id)->first();
        return view('arsip.detailrkk', compact('data'));
    }

}
