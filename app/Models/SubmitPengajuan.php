<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class SubmitPengajuan extends Model
{
    use HasFactory;

    protected $table = 'submit_pengajuan';

    public function getSubmitPengajuanByKodeDept($kodeDept)
    {
        return DB::table('submit_pengajuan')
            ->join('karyawan', 'submit_pengajuan.id_karyawan', '=', 'karyawan.id')
            ->join('departemen', 'karyawan.kode_dept', '=', 'departemen.id')
            ->select('submit_pengajuan.*')
            ->where('departemen.kode_dept', $kodeDept)
            ->get();
    }
}
