<?php

namespace App\Http\Controllers;

use App\Models\Cabang;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Yajra\DataTables\Facades\DataTables;

class CabangController extends BaseController
{
    /*=================================================
                    DATATABLES
    =================================================*/
    public function cabangDatatables(Request $request)
    {
        if ($request->ajax()) {
            $cabang = Cabang::query();

            return DataTables::of($cabang)
                ->addIndexColumn()
                ->editColumn('radius_cabang', function (Cabang $cabang) {
                    return "$cabang->radius_cabang Meter";
                })
                ->addColumn('locationshow', function (Cabang $cabang) {
                    $location = '<a href="/cabang/map/' . $cabang->id . '" class="btn btn-info btn-sm">
                                        Lihat Lokasi
                                    </a>';
                    return $location;
                })
                ->addColumn('action', function (Cabang $d) {
                    $action = '<div class="btn-group">
                                        <a href="#" class="edit btn btn-warning btn-sm" kode_cabang="' . $d->kode_cabang . '">
                                             <svg xmlns="http://www.w3.org/2000/svg" width="24"
                                                                    height="24" fill="#ffffff" viewBox="0 0 256 256">
                                                                    <path
                                                                        d="M224,120v88a16,16,0,0,1-16,16H48a16,16,0,0,1-16-16V48A16,16,0,0,1,48,32h88a8,8,0,0,1,0,16H48V208H208V120a8,8,0,0,1,16,0Zm5.66-50.34-96,96A8,8,0,0,1,128,168H96a8,8,0,0,1-8-8V128a8,8,0,0,1,2.34-5.66l96-96a8,8,0,0,1,11.32,0l32,32A8,8,0,0,1,229.66,69.66Zm-17-5.66L192,43.31,179.31,56,200,76.69Z">
                                                                    </path>
                                                                </svg>
                                        </a>
                                        <form action="/cabang/' . $d->kode_cabang . '/delete" method="POST" style="margin-left:5px">
                                            <input type="hidden" name="_token" value="' . csrf_token() . '">
                                            <a class="btn btn-danger btn-sm delete-confirm">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="24"
                                                height="24" fill="#ffffff" viewBox="0 0 256 256">
                                                                        <path
                                                                            d="M224,56a8,8,0,0,1-8,8h-8V208a16,16,0,0,1-16,16H64a16,16,0,0,1-16-16V64H40a8,8,0,0,1,0-16H216A8,8,0,0,1,224,56ZM88,32h80a8,8,0,0,0,0-16H88a8,8,0,0,0,0,16Z">
                                                                        </path>
                                                                    </svg>
                                            </a>
                                        </form>
                                    </div>';

                    return $action;
                })
                ->rawColumns(['locationshow', 'action'])
                ->make(true);
        }
    }

    public function index()
    {
        $cabang = DB::table('cabang')->orderBy('kode_cabang')->get();
        return view('cabang.index', compact('cabang'));
    }


    public function store(Request $request)
    {
        $kode_cabang = $request->kode_cabang;
        $nama_cabang = $request->nama_cabang;
        $lokasi_cabang = $request->lokasi_cabang;
        $radius_cabang = $request->radius_cabang;

        try {
            $data = [
                'kode_cabang' => $kode_cabang,
                'nama_cabang' => $nama_cabang,
                'lokasi_cabang' => $lokasi_cabang,
                'radius_cabang' => $radius_cabang
            ];
            DB::table('cabang')->insert($data);
            return Redirect::back()->with(['success' => 'Data Berhasil Disimpan']);
        } catch (\Exception $e) {
            return Redirect::back()->with(['warning' => 'Data Gagal Disimpan']);
        }
    }

    public function edit(Request $request)
    {
        $kode_cabang = $request->kode_cabang;
        $cabang = DB::table('cabang')->where('kode_cabang', $kode_cabang)->first();
        return view('cabang.edit', compact('cabang'));
    }

    public function update(Request $request)
    {
        $kode_cabang = $request->kode_cabang;
        $nama_cabang = $request->nama_cabang;
        $lokasi_cabang = $request->lokasi_cabang;
        $radius_cabang = $request->radius_cabang;

        try {
            $data = [
                'nama_cabang' => $nama_cabang,
                'lokasi_cabang' => $lokasi_cabang,
                'radius_cabang' => $radius_cabang
            ];
            DB::table('cabang')
                ->where('kode_cabang', $kode_cabang)
                ->update($data);
            return Redirect::back()->with(['success' => 'Data Berhasil Diupdate']);
        } catch (\Exception $e) {
            return Redirect::back()->with(['warning' => 'Data Gagal Diupdate']);
        }
    }

    public function delete($kode_cabang)
    {
        $hapus = DB::table('cabang')->where('kode_cabang', $kode_cabang)->delete();
        if ($hapus) {
            return Redirect::back()->with(['success' => 'Data Berhasil Di Hapus']);
        } else {
            return Redirect::back()->with(['warning' => 'Data Gagal Di Hapus']);
        }
    }

    public function mapCabang(string $id)
    {
        $data = Cabang::find($id);
        return view('cabang.map', compact('data'));
    }
}
