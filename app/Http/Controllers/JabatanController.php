<?php

namespace App\Http\Controllers;

use App\Models\Departemen;
use App\Models\Jabatan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Yajra\DataTables\Facades\DataTables;

class JabatanController extends BaseController
{
    /*=================================================
                    DATATABLES
    =================================================*/

    public function jabatanTetapDatatables(Request $request)
    {
        if($request->ajax()) {
            $jabatan = Jabatan::with('department')->where('is_daily', 0);
            return DataTables::of($jabatan)
                    ->addIndexColumn()
                    ->addColumn('action', function(Jabatan $d) {
                        $action = '<a href="#" class="edit-tetap btn btn-warning" data-bs-toggle="modal"
                                        data-bs-target="#edittetap" data-id = "'. $d->id .'"
                                        data-jabatan ="'. $d->nama_jabatan .'"
                                        data-departemen ="'. $d->departemen_id .'"
                                        >
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="#ffffff" viewBox="0 0 256 256"><path d="M224,120v88a16,16,0,0,1-16,16H48a16,16,0,0,1-16-16V48A16,16,0,0,1,48,32h88a8,8,0,0,1,0,16H48V208H208V120a8,8,0,0,1,16,0Zm5.66-50.34-96,96A8,8,0,0,1,128,168H96a8,8,0,0,1-8-8V128a8,8,0,0,1,2.34-5.66l96-96a8,8,0,0,1,11.32,0l32,32A8,8,0,0,1,229.66,69.66Zm-17-5.66L192,43.31,179.31,56,200,76.69Z"></path></svg>
                                    </a>';
                        return $action;
                    })
                    ->rawColumns(['action'])
                    ->make(true);
        }
    }

    public function jabatanHarianDatatables(Request $request)
    {
        if($request->ajax()) {
            $jabatan = Jabatan::where('is_daily', 1);
            return DataTables::of($jabatan)
                    ->addIndexColumn()
                    ->addColumn('action', function(Jabatan $d) {
                        $action = '<a href="#" class="edit-harian btn btn-warning" data-bs-toggle="modal"
                                        data-bs-target="#editharian" data-id = "'. $d->id .'"
                                        data-jabatan ="'. $d->nama_jabatan .'"
                                        >
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="#ffffff" viewBox="0 0 256 256"><path d="M224,120v88a16,16,0,0,1-16,16H48a16,16,0,0,1-16-16V48A16,16,0,0,1,48,32h88a8,8,0,0,1,0,16H48V208H208V120a8,8,0,0,1,16,0Zm5.66-50.34-96,96A8,8,0,0,1,128,168H96a8,8,0,0,1-8-8V128a8,8,0,0,1,2.34-5.66l96-96a8,8,0,0,1,11.32,0l32,32A8,8,0,0,1,229.66,69.66Zm-17-5.66L192,43.31,179.31,56,200,76.69Z"></path></svg>
                                    </a>';
                        return $action;
                    })
                    ->rawColumns(['action'])
                    ->make(true);
        }
    }

    public function indexJabatan(){
        $departemen = Departemen::all();
        return view('jabatan.index', compact('departemen'));
    }

    public function addJabatan(Request $request){
        $request->validate([
            'nama_jabatan' => 'required',
        ]);
        $data = [];
        if($request->status == 1){
            $data['nama_jabatan'] = $request->nama_jabatan;
            $data['is_daily'] = 0;
            $data['departemen_id'] = $request->departemen;
        }else{
            $data['nama_jabatan'] = $request->nama_jabatan;
            $data['is_daily'] = 1;
        }
        try {
            Jabatan::create($data);
            return back()->with('message', 'Jabatan berhasil ditambahkan');
        } catch (\Exception $e) {
            return back()->with('message', 'Gagal menambahkan jabatan. Hubungi tim IT.');
        }
    }

    public function editJabatan(Request $request, string $id){
        $request->validate([
            'nama_jabatan' => 'required',
        ]);
        $data = [];
        if($request->status == 1){
            $data['nama_jabatan'] = $request->nama_jabatan;
            $data['is_daily'] = 0;
            $data['departemen_id'] = $request->departemen;
        }else{
            $data['nama_jabatan'] = $request->nama_jabatan;
            $data['is_daily'] = 1;
        }
        try {
            Jabatan::where('id', $request->id)->update($data);
            return back()->with('message', 'Jabatan berhasil diubah');
        } catch (\Exception $e) {
            return back()->with('message', 'Gagal mengubah jabatan. Hubungi tim IT.');
        }
    }

}
