<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KaryawanContract extends Model
{
    use HasFactory;

    protected $connection = 'mysql';
    protected $table = 'karyawan_contract';
    protected $fillable = [
        'karyawan_id',
        'no_surat',
        'surat_id',
        'jabatan_id',
        'department_id',
        'kode_cabang',
        'contract_status',
        'salary',
        'project',
        'lama_kontrak_num',
        'lama_kontrak_waktu',
        'mulai_kontrak',
        'akhir_kontrak',
        'jobdesk_content',
        'kontrak_check',
        'kontrak_check_date',
        'id_atasan_approve',
        'jabatan_atasan_approve',
        'kontrak_confirm',
        'kontrak_confirm_date',
        'contract_file'
    ];


    // karyawan
    public function karyawan() {
        return $this->belongsTo(Karyawan::class, 'karyawan_id');
    }

    // jabatan
    public function jabatan() {
        return $this->belongsTo(Jabatan::class, 'jabatan_id');
    }

    // department
    public function department() {
        return $this->belongsTo(Departemen::class, 'department_id');
    }

    // cabang
    public function cabang() {
        return $this->belongsTo(Cabang::class, 'kode_cabang', 'kode_cabang');
    }

    // atasan approve
    public function atasanApprove()
    {
        return $this->belongsTo(Karyawan::class, 'id_atasan_approve');
    }

    // jabatan atasan approve
    public function jabatanAtasanApprove()
    {
        return $this->belongsTo(Jabatan::class, 'jabatan_atasan_approve');
    }
}
