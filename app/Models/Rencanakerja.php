<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rencanakerja extends Model
{
    use HasFactory;
    protected $table = 'rencanakerjas';
    protected $fillable = [
        'id_karyawan',
        'perihal',
        'lokasi',
        'waktu',
        'target_penyelesaian',
        'keterangan',
        'lampiran',
        'prioritas',
        'revisi',
        'lampiran_revisi',
        'ket_revisi',
        'status',
        'manajer_approval',
        'pm_approval',
        'hrd_approval',
        'direktur_approval',
        'komisaris_approval',
    ];

    public function karyawan()
    {
        return $this->belongsTo(Karyawan::class, 'id_karyawan');
    }
}
