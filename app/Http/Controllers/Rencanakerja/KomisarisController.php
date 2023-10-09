<?php

namespace App\Http\Controllers\Rencanakerja;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Karyawan;
use App\Models\Rencanakerja;

class KomisarisController extends Controller
{
    public function option()
    {
        return view('rencanakerja.komisaris.option');

    }

    public function optiondepartment()
    {
        return view('rencanakerja.komisaris.optiondepartment');
    }

    public function listrkkdu(Request $request)
    {
        $data = Rencanakerja::whereHas('karyawan', function ($query) {
            $query->where('kode_dept', 'DU')->where('role_id', 1);
        })->get();
        return view('rencanakerja.komisaris.listrkk-du')->with(compact('data'));
    }

    public function listrkkeng(Request $request)
    {
        $data = Rencanakerja::whereHas('karyawan', function ($query) {
            $query->where('kode_dept', 'TK')->whereIn('role_id', [1, 2, 3]);
        })->get();
        return view('rencanakerja.komisaris.listrkk-eng')->with(compact('data'));
    }

    public function listrkkpro(Request $request)
    {
        $data = Rencanakerja::whereHas('karyawan', function ($query) {
            $query->where('kode_dept', 'PR')->whereIn('role_id', [1, 2, 3]);
        })->get();
        return view('rencanakerja.komisaris.listrkk-pro')->with(compact('data'));
    }

    public function listrkkscm(Request $request)
    {
        $data = Rencanakerja::whereHas('karyawan', function ($query) {
            $query->where('kode_dept', 'SC')->whereIn('role_id', [1, 2]);
        })->get();
        return view('rencanakerja.komisaris.listrkk-scm')->with(compact('data'));
    }

    public function listrkkit(Request $request)
    {
        $data = Rencanakerja::whereHas('karyawan', function ($query) {
            $query->where('kode_dept', 'IT')->whereIn('role_id', [1, 2]);
        })->get();
        return view('rencanakerja.komisaris.listrkk-it')->with(compact('data'));
    }

    public function listrkkhrd(Request $request)
    {
        $data = Rencanakerja::whereHas('karyawan', function ($query) {
            $query->where('kode_dept', 'HR')->whereIn('role_id', [1, 2]);
        })->get();
        return view('rencanakerja.komisaris.listrkk-hrd')->with(compact('data'));
    }

    public function listrkkfin(Request $request)
    {
        $data = Rencanakerja::whereHas('karyawan', function ($query) {
            $query->where('kode_dept', 'KU')->whereIn('role_id', [1,2]);
        })->get();
        return view('rencanakerja.komisaris.listrkk-fin')->with(compact('data'));
    }

    public function listrkkmr(Request $request)
    {
        $data = Rencanakerja::whereHas('karyawan', function ($query) {
            $query->where('kode_dept', 'PN')->whereIn('role_id', [1,2]);
        })->get();
        return view('rencanakerja.komisaris.listrkk-mr')->with(compact('data'));
    }

    public function detailrkkdu(string $id)
    {
        $data = Rencanakerja::where('id', $id)->first();
        return view('rencanakerja.komisaris.detail-rkk-du')->with(compact('data'));
    }

    public function detailrkkeng(string $id)
    {
        $data = Rencanakerja::where('id', $id)->first();
        return view('rencanakerja.komisaris.detail-rkk-eng')->with(compact('data'));
    }

    public function detailrkkpro(string $id)
    {
        $data = Rencanakerja::where('id', $id)->first();
        return view('rencanakerja.komisaris.detail-rkk-pro')->with(compact('data'));
    }

    public function detailrkkfin(string $id)
    {
        $data = Rencanakerja::where('id', $id)->first();
        return view('rencanakerja.komisaris.detail-rkk-fin')->with(compact('data'));
    }

    public function detailrkkit(string $id)
    {
        $data = Rencanakerja::where('id', $id)->first();
        return view('rencanakerja.komisaris.detail-rkk-it')->with(compact('data'));
    }

    public function detailrkkmr(string $id)
    {
        $data = Rencanakerja::where('id', $id)->first();
        return view('rencanakerja.komisaris.detail-rkk-mr')->with(compact('data'));
    }

    public function detailrkkscm(string $id)
    {
        $data = Rencanakerja::where('id', $id)->first();
        return view('rencanakerja.komisaris.detail-rkk-scm')->with(compact('data'));
    }

    public function detailrkkhrd(string $id)
    {
        $data = Rencanakerja::where('id', $id)->first();
        return view('rencanakerja.komisaris.detail-rkk-hrd')->with(compact('data'));
    }
}
