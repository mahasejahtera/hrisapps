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

    public function updateTugas(Request $request){
        $id = $request->id;
        $data = Tugas::find($id);
        if (!$data) {
            return abort(404);
        }
        $rules = [];
        $deleteOldImages = false;
        for ($i = 1; $i <= 5; $i++) {
            $inputName = 'lampiran' . $i;
            if ($request->hasFile($inputName)) {
                $rules[$inputName] = 'image|mimes:jpeg,jpg,png|max:2048';
                $deleteOldImages = true;
            }
        }
        $request->validate($rules);

        if ($deleteOldImages) {
            for ($i = 1; $i <= 5; $i++) {
                $inputName = 'lampiran' . $i;
                $oldAttachment = $data->{'progress' . $i};
                if ($request->hasFile($inputName) && $oldAttachment) {
                    if (file_exists(public_path('images/tugas/' . $oldAttachment))) {
                        unlink(public_path('images/tugas/' . $oldAttachment));
                    }
                    $data->setAttribute('progress' . $i, null);
                }
            }
        }

        for ($i = 1; $i <= 5; $i++) {
            $inputName = 'lampiran' . $i;
            if ($request->hasFile($inputName)) {
                $file = $request->file($inputName);
                $filename = $file->getClientOriginalName();
                $file_jadi = date('ymdhis') . $filename;
                $file->move(public_path('images/tugas'), $file_jadi);
                $data->setAttribute('progress' . $i, $file_jadi);
            }
        }
        $keterangan = $request->keterangan;
        $data->keterangan_progress = $keterangan;
        $data->save();
        return redirect()->route('detail-tugas-karyawan', ['id' => $data->id])->with('success', 'Proses Diupdate !');
    }

}




