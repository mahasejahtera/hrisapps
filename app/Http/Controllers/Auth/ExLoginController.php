<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ExLoginController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function exlogin(Request $request )
    {
        $departemen = $request->input('kode_dept');
        $role = $request->input('role_id');
        $request->session()->put('kode_dept', $departemen);
        $request->session()->put('role_id', $role);
        return redirect()->route('dashboard');
    }
    public function index()
    {
        return view('rencanakerja.ex-login');
    }

}
