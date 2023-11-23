<?php

namespace App\Http\Controllers;

use App\Models\SuratList;
use Exception;
use Illuminate\Http\Request;

class SuratController extends Controller
{

    // no kontrak karyawan baru
    public function getNoSuratBaruPerusahaan($kodeSurat)
    {
        //get no surat terakhir
        $suratTerakhir = SuratList::with(['karyawan_penerima', 'karyawan_pembuat', 'kategori_surat'])
                        ->where('kategori_kode', $kodeSurat)
                        ->where('no_surat','LIKE', '%/MAHA/%')
                        ->where('no_surat','LIKE', '%' . date('Y'))
                        ->orderBy('id', 'desc')
                        ->limit(1)
                        ->get();

        // cek data surat terakhir
        if(count($suratTerakhir) > 0) {
            $noSuratTerakhir = $suratTerakhir[0]->no_surat;
            $noSuratExplode = explode('/', $noSuratTerakhir);
            $LastNum = $noSuratExplode[0];
            $nextNum = $LastNum + 1;
            $newNum = sprintf('%03s', $nextNum);

            $newNoSurat = "$newNum/$kodeSurat/MAHA/" . bulanRomawi(date('m')) . '/' . date('Y');
        } else {
            $newNoSurat = "001/$kodeSurat/MAHA/" . bulanRomawi(date('m')) . '/' . date('Y');
        }

        return $newNoSurat;
    }


    // create surat
    public function storeSurat($data)
    {
        $newSurat = SuratList::create($data);
        return $newSurat;
    }
}
