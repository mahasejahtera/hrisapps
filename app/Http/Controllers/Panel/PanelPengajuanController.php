<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Karyawan;
use App\Models\Pengajuan;
use App\Models\SubmitPengajuan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;

class PanelPengajuanController extends Controller
{
    public function index(Request $request)
    {

        $query = SubmitPengajuan::select('submit_pengajuan.id', 'submit_pengajuan.nomor', 'mysql.karyawan.nama_lengkap', 'departemen.nama_dept', 'submit_pengajuan.tanggal', 'submit_pengajuan.due_date')->join('mysql.karyawan', 'mysql.karyawan.id', '=', 'submit_pengajuan.id_karyawan')->join('departemen', 'departemen.id', '=', 'mysql.karyawan.kode_dept');

        if (!empty($request->nama_karyawan)) {
            $query->where('nama_lengkap', 'like', '%' . $request->nama_karyawan . '%');
        }

        if (!empty($request->kode_pengajuan)) {
            $query->where('submit_pengajuan.id_pengajuan', $request->kode_pengajuan);
        }

        if (!empty($request->kode_dept)) {
            $query->where('karyawan.kode_dept', $request->kode_dept);
        }

        $submit_pengajuan = $query->paginate(10);
        // dd($submit_pengajuan);

        $departemen = DB::table('departemen')->get();
        $pengajuan = Pengajuan::get();
        $cabang = DB::table('cabang')->orderBy('kode_cabang')->get();
        return view('panel.pengajuan.index', compact('submit_pengajuan', 'departemen', 'cabang', 'pengajuan'));
    }

    public function list($id, Request $request)
    {

        $query = SubmitPengajuan::select('submit_pengajuan.id', 'submit_pengajuan.nomor', 'karyawan.nama_lengkap', 'departemen.nama_dept', 'submit_pengajuan.tanggal', 'submit_pengajuan.due_date')->join('mahasej3_hrisapps.karyawan', 'karyawan.id', '=', 'submit_pengajuan.id_karyawan')->join('mahasej3_hrisapps.departemen', 'departemen.id', '=', 'mahasej3_hrisapps.karyawan.kode_dept')->where('karyawan.kode_dept', $id);

        if (!empty($request->nama_karyawan)) {
            $query->where('nama_lengkap', 'like', '%' . $request->nama_karyawan . '%');
        }

        if (!empty($request->kode_pengajuan)) {
            $query->where('submit_pengajuan.id_pengajuan', $request->kode_pengajuan);
        }

        if (!empty($request->kode_dept)) {
            $query->where('karyawan.kode_dept', $request->kode_dept);
        }

        $submit_pengajuan = $query->paginate(10);
        // dd($submit_pengajuan);

        $departemen = DB::table('departemen')->get();
        $pengajuan = Pengajuan::get();
        $cabang = DB::table('cabang')->orderBy('kode_cabang')->get();
        return view('panel.pengajuan.index', compact('submit_pengajuan', 'departemen', 'cabang', 'pengajuan'));
    }

    public function karyawanData(Request $request)
    {
        $karyawanData = Karyawan::with(['jabatan_kerja', 'department', 'cabang'])->where('id', $request->id)->get();

        $data = [
            'id'  => $karyawanData[0]->id,
            'nama'  => $karyawanData[0]->nama_lengkap,
            'email'  => $karyawanData[0]->email,
            'jabatan'  => $karyawanData[0]->jabatan_kerja->nama_jabatan,
            'departemen'  => $karyawanData[0]->department->nama_dept,
        ];

        return $data;
    }

    public function verificationRegister(Request $request)
    {
        $validatedData = $request->validate([
            'nik'               => 'required|unique:karyawan,nik',
            'status_karyawan'   => 'required',
            'salary'            => 'required|numeric|max:999999999'
        ]);

        if ($request->status_karyawan == 'pkwt') {
            $request->validate([
                'lama_kontrak_num'      => 'required',
                'lama_kontrak_waktu'    => 'required',
                'mulai_kontrak'         => 'required',
                'akhir_kontrak'          => 'required'
            ]);
        }

        if ($request->status_karyawan == 'project') {
            $request->validate([
                'project'           => 'required',
                'mulai_kontrak'     => 'required',
            ]);
        }

        $validatedData['status'] = 1;
        $validatedData['project'] = $request->project;
        $validatedData['lama_kontrak_num'] = $request->lama_kontrak_num;
        $validatedData['lama_kontrak_waktu'] = $request->lama_kontrak_waktu;
        $validatedData['mulai_kontrak'] = $request->mulai_kontrak;
        $validatedData['akhir_kontrak'] = $request->akhir_kontrak;

        Karyawan::where('id', $request->karyawan_id)->update($validatedData);
        return back()->with('success', 'Register karyawan berhasil di verifikasi');
    }

    public function store(Request $request)
    {
        $nik = $request->nik;
        $nama_lengkap = $request->nama_lengkap;
        $jabatan = $request->jabatan;
        $no_hp = $request->no_hp;
        $kode_dept = $request->kode_dept;
        $password = Hash::make('12345');
        $kode_cabang = $request->kode_cabang;
        if ($request->hasFile('foto')) {
            $foto = $nik . "." . $request->file('foto')->getClientOriginalExtension();
        } else {
            $foto = null;
        }

        try {
            $data =  [
                'nik' => $nik,
                'nama_lengkap' => $nama_lengkap,
                'jabatan' => $jabatan,
                'no_hp' => $no_hp,
                'kode_dept' => $kode_dept,
                'foto' => $foto,
                'password' => $password,
                'kode_cabang' => $kode_cabang
            ];
            $simpan = DB::table('karyawan')->insert($data);
            if ($simpan) {
                if ($request->hasFile('foto')) {
                    $folderPath = "public/uploads/karyawan/";
                    $request->file('foto')->storeAs($folderPath, $foto);
                }
                return Redirect::back()->with(['success' => 'Data Berhasil Disimpan']);
            }
        } catch (\Exception $e) {

            if ($e->getCode() == 23000) {
                $message = "Data dengan Nik " . $nik . " Sudah Ada";
            } else {
                $message = "Hubungi IT";
            }
            return Redirect::back()->with(['warning' => 'Data Gagal Disimpan ' . $message]);
        }
    }

    public function edit($id)
    {
        $departemen = DB::table('departemen')->get();
        $cabang = DB::table('cabang')->orderBy('kode_cabang')->get();
        $karyawan = DB::table('karyawan')->where('nik', $id)->first();
        $pengajuan = SubmitPengajuan::where('id', $id)->first();
        return view('panel.pengajuan.edit', compact('departemen', 'karyawan', 'cabang', 'pengajuan'));
    }

    public function update($id, Request $request)
    {
        $nomor = $request->nomor;
        $tanggal = $request->tanggal;
        $due_date = $request->due_date;
        
        try {
            $data =  [
                'nomor' => $nomor,
                'tanggal' => $tanggal,
                'due_date' => $due_date
            ];
            $update = SubmitPengajuan::where('id', $id)->update($data);
            if ($update) {
                
                return Redirect::back()->with(['success' => 'Data Berhasil Update']);
            }
        } catch (\Exception $e) {
            dd($e->getMessage());
            return Redirect::back()->with(['warning' => 'Data Gagal Diupdate']);
        }
    }

    public function delete($nik)
    {
        $delete = DB::table('karyawan')->where('nik', $nik)->delete();
        if ($delete) {
            return Redirect::back()->with(['success' => 'Data Berhasil Dihapus']);
        } else {
            return Redirect::back()->with(['warning' => 'Data Gagal Dihapus']);
        }
    }

    public function destroy($id)
    {
        // Temukan data yang akan dihapus berdasarkan ID
        $data = SubmitPengajuan::find($id);

        if (!$data) {
            return redirect()->route('panelpengajuan.index')
                ->with('error', 'Data tidak ditemukan.');
        }

        // Hapus data dari database
        $data->delete();

        return redirect()->route('panelpengajuan.index')
            ->with('success', 'Data berhasil dihapus.');
    }
}
