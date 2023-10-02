<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Karyawan extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

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
        return $this->belongsTo(Cabang::class, 'kode_cabang');
    }
}
