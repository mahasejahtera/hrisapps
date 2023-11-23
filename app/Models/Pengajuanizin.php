<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pengajuanizin extends Model
{
    use HasFactory;
    protected $connection = 'mysql';
    protected $table = 'pengajuan_izin';
    protected $fillable = [
        'nik',
        'jenis_izin_id',
        'tgl_mulai_izin',
        'tgl_akhir_izin',
        'jam_mulai',
        'jam_akhir',
        'status',
        'keterangan',
        'lampiran',
        'jumlah_hari',
        'bulan_pertama',
        'bulan_kedua',
        'status_approved',
        'manager_approve_date',
        'gm_approve_date',
        'hrd_approve_date',
        'direktur_approve_date',
        'komisaris_approve_date',
        'is_read'
    ];

    public function karyawan()
    {
        return $this->belongsTo(Karyawan::class, 'nik', 'nik');
    }

    public function jenisizin() {
        return $this->belongsTo(JenisIzin::class, 'jenis_izin_id');
    }
}
