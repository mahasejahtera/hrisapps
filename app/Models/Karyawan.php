<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Karyawan extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $connection = 'mysql';
    protected $table = "karyawan";
    // protected $primaryKey = "nik";
    // public $incrementing = false;
    protected $fillable = [
        'nik',
        'username',
        'nama_lengkap',
        'email',
        'jabatan',
        'no_hp',
        'foto',
        'kode_dept',
        'kode_cabang',
        'password',
        'signature',
        'no_surat_pakta_integritas',
        'pakta_integritas_check',
        'pakta_integritas_check_date',
        'surat_pernyataan_check',
        'surat_pernyataan_check_date',
        'contract_id',
        'old_contract_id',
        'status_karyawan',
        'project',
        'salary',
        'lama_kontrak_num',
        'lama_kontrak_waktu',
        'mulai_kontrak',
        'akhir_kontrak',
        'kontrak_tampil',
        'jobdesk_content',
        'kontrak_check',
        'kontrak_check_date',
        'kode_surat_karyawan',
        'biodata_confirm',
        'biodata_confirm_date',
        'role_id',
        'status'
    ];


    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    // jabatan
    public function jabatan_kerja() {
        return $this->belongsTo(Jabatan::class, 'jabatan');
    }

    // department
    public function department() {
        return $this->belongsTo(Departemen::class, 'kode_dept');
    }

    // cabang
    public function cabang() {
        return $this->belongsTo(Cabang::class, 'kode_cabang', 'kode_cabang');
    }

    // contract
    public function contract() {
        return $this->belongsTo(KaryawanContract::class, 'contract_id');
    }

    // contract
    public function oldContract() {
        return $this->belongsTo(KaryawanContract::class, 'old_contract_id');
    }
}
