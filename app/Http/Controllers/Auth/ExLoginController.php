<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Karyawan;


class ExLoginController extends Controller
{

    public function exlogin(Request $request )
    {
        $kary = $request->input('id_karyawan');
        $request->session()->put('id_karyawan', $kary);
        return redirect()->route('dashboard');
    }
    public function index()
    {
        $kary = Karyawan::all();
        return view('rencanakerja.ex-login')->with('kary', $kary);
    }

}