<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class SubmitPengajuan extends Model
{
    use HasFactory;
    protected $connection = 'db_pengajuan';
    protected $table = 'submit_pengajuan';

    public function getSubmitPengajuanByKodeDept($kodeDept)
    {
        return DB::connection($this->connection)->table('submit_pengajuan')
            ->join('mahasej3_hrisapps.karyawan', 'submit_pengajuan.id_karyawan', '=', 'mahasej3_hrisapps.karyawan.id')
            ->join('mahasej3_hrisapps.departemen', 'karyawan.kode_dept', '=', 'mahasej3_hrisapps.departemen.id')
            ->select('submit_pengajuan.*')
            ->where('departemen.kode_dept', $kodeDept)
            ->get();
    }


}
