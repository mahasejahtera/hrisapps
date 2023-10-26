<?php

namespace App\Http\Controllers\Arsip;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Karyawan;
use App\Models\Rencanakerja;
use App\Models\Permintaan;

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
        return view('arsip.rkk.rkk', compact('data'));
    }

    public function detailrkk(string $id)
    {
        $data = Rencanakerja::where('id', $id)->first();
        return view('arsip.rkk.detailrkk', compact('data'));
    }
    public function searchRkk(Request $request){
        $idk = $request->session()->get('id_karyawan');
        $dari = $request->dari;
        $sampai = $request->sampai;
        $data = Rencanakerja::where('id_karyawan', $idk)
            ->where('komisaris_approval', 1)
            ->where('waktu', '>=', $dari)
            ->where('waktu', '<=', $sampai)
            ->get();
        return view('arsip.rkk.search', compact('data', 'dari', 'sampai'));
    }

    public function listarsippermintaan(Request $request)
    {
        $idk = $request->session()->get('id_karyawan');
        $data = Permintaan::where('id_karyawan_pengirim', $idk)
        ->where('status', 4)
        ->get();
        return view('arsip.permintaan.list', compact('data'));
    }

    public function searchPermintaan(Request $request){
        $idk = $request->session()->get('id_karyawan');
        $dari = $request->dari;
        $sampai = $request->sampai;
        $data = Permintaan::where('id_karyawan_pengirim', $idk)
            ->where('status', 4)
            ->where('waktu', '>=', $dari)
            ->where('waktu', '<=', $sampai)
            ->get();
        return view('arsip.permintaan.search', compact('data', 'dari', 'sampai'));
    }

    public function detailpermintaan(string $id)
    {
        $data = Permintaan::where('id', $id)->first();
        return view('arsip.permintaan.detail', compact('data'));
    }

}
