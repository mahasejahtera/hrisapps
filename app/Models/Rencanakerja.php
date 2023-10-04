<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rencanakerja extends Model
{
    use HasFactory;
    protected $fillable = [
        'id_karyawan',
        'perihal',
        'lokasi',
        'waktu',
        'target_penyelesaian',
        'keterangan',
        'lampiran',
        'prioritas',
    ];
    protected $table = 'rencanakerjas';

    public function karyawan()
    {
        return $this->belongsTo(Karyawan::class, 'id_karyawan');
    }
}
