<?php

namespace App\Http\Controllers;

use App\Models\Cabang;
use App\Models\Departemen;
use App\Models\Jabatan;
use App\Models\Karyawan;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redirect;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Str;

class AuthController extends Controller
{

    /*=========================
            LOGIN
    ========================= */
    public function login()
    {
        $data = [
            'title'     => 'Login | PT. Maha Akbar Sejahtera'
        ];

        return view('auth.login-v2', $data);
    }


    public function proseslogin(Request $request)
    {

        $credentials = $request->validate([
            'email'     => 'required',
            'password'  => 'required'
        ]);

        if (Auth::guard('karyawan')->attempt($credentials)) {
            $request->session()->regenerate();
            $karyawan = Auth::guard('karyawan')->user();
            $dept = Departemen::find($karyawan->id);
            $kode = $dept->kode_dept;
            $karyawan->kode_dept_init = $kode;
            $karyawan->save();
            return redirect()->intended('karyawan');
            // return to_route('karyawan');
        } else {
            return to_route('login')->with('error', 'Username / Password salah!');
        }
    }

    public function prosesloginadmin(Request $request)
    {
        if (Auth::guard('user')->attempt(['email' => $request->email, 'password' => $request->password])) {
            $request->session()->regenerate();
            return redirect()->intended('panel/dashboardadmin');
        } else {
            return redirect('/panel')->with(['warning' => 'Username atau Password Salah']);
        }
    }

    /*=========================
            REGISTER
    ========================= */
    public function register()
    {
        $data = [
            'title'         => 'Register | PT. Maha Akbar Sejahtera',
            'departments'   => Departemen::all(),
            'kantor_cabang' => Cabang::all(),
            'jabatans'       => Jabatan::all()
        ];

        return view('auth.register', $data);
    }


    public function prosesRegister(Request $request)
    {
        $validatedData = $request->validate([
            // 'username'      => 'required|min:3|unique:karyawan,username|alpha_dash',
            'nama_lengkap'  => 'required|min:3|max:100',
            'password'      => 'required|min:6',
            // 'email'         => 'required|email|unique:karyawan,email',
            'email'         => 'required|email|unique:karyawan,email|ends_with:@mahasejahtera.com',
            'jabatan'       => 'required',
            'kode_dept'     => 'required',
            'kode_cabang'   => 'required',
        ]);

        $validatedData['role_id'] = 1;
        $validatedData['nama_lengkap'] = Str::title($request->nama_lengkap);

        // role manager by jabatan
        $jbt = $request->jabatan;

        if($jbt == 7 || $jbt == 10 || $jbt == 15 || $jbt == 20 || $jbt == 26 || $jbt == 33 || $jbt == 40 || $jbt == 47) {
            $validatedData['role_id'] = 2;
        }

        if($jbt == 6) {
            $validatedData['role_id'] = 3;
        }

        if($jbt == 2) {
            $validatedData['role_id'] = 4;
        }

        if($jbt == 1) {
            $validatedData['role_id'] = 5;
        }

        $validatedData['status'] = 0;
        // $validatedData['jabatan'] = 5;
        $validatedData['password'] = Hash::make($request->password);

        try {
            Karyawan::create($validatedData);

            return to_route('login')->with('success', 'Register berhasil, silahkan login!');
        } catch (Exception $e) {
            return to_route('register')->with('error', 'Register Gagal, ' . $e->getMessage());
        }

    }


    /*=========================
            LOGOUT
    ========================= */
    public function proseslogout()
    {
        if (Auth::guard('karyawan')->check()) {
            Auth::guard('karyawan')->logout();
            return to_route('login');
        }
    }

    public function proseslogoutadmin()
    {
        if (Auth::guard('user')->check()) {
            Auth::guard('user')->logout();
            return redirect('/panel');
        }
    }


    /*=========================
            JABATAN
    ========================= */
    public function getJabatanByDept(Request $request)
    {
        // get jabatan
        $jabatan = Jabatan::where('departemen_id', $request->value)->get();

        // set html option select
        $jabatanOption = "<option value=''>--Pilih Jabatan--</option>";

        if($request->isSet) {
            foreach($jabatan as $jbt) {
                if($request->oldJabatan == $jbt->id) {
                    $jabatanOption .= "<option value='$jbt->id' selected>$jbt->nama_jabatan</option>";
                } else {
                    $jabatanOption .= "<option value='$jbt->id'>$jbt->nama_jabatan</option>";
                }
            }
        } else {
            foreach($jabatan as $jbt) {
                $jabatanOption .= "<option value='$jbt->id'>$jbt->nama_jabatan</option>";
            }
        }

        return [
            'jabatanOption' => $jabatanOption
        ];
    }


    /*=========================
            GOOGLE AUTH
    ========================= */
    // public function googleLogin()
    // {
    //     return Socialite::driver('google')->redirect();
    // }

    // public function googleCalback()
    // {
    //     $googleUser = Socialite::driver('google')->user();
    //     // echo '<pre>';
    //     // print_r($googleUser);
    //     // echo '</pre>';

    //     $data = [
    //         'nama_lengkap'      => $googleUser->name,
    //         'email'             => $googleUser->email,
    //         'kode_dept'         => 'IT',
    //         'kode_cabang'       => 'TSM',
    //         'role_id'           => 1,
    //         'status'            => 0
    //     ];

    //     $checkUser = Karyawan::where( 'email', $googleUser->email);
    //     dd($checkUser);

    //     $user = Karyawan::firstOrCreate($data);
    //     // var_dump($user);

    //     // return $user;

    //     Auth::guard('karyawan')->login($user);
    //     return to_route('login')->with('google_err', 'Akun berhasil di daftarkan, silahkan login kembali!');
    // }
}
