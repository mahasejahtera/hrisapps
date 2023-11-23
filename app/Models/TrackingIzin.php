<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TrackingIzin extends Model
{
    use HasFactory;

    protected $connection = 'mysql';
    protected $table = 'tracking_izin';
    protected $fillable = [
        'pengajuan_izin_id',
        'karyawan_id',
        'keterangan',
        'keterangan_tolak',
        'status',
        'date'
    ];


    public function pengajuanizin() {
        return $this->belongsTo(Pengajuanizin::class, 'pengajuan_izin_id');
    }

    public function karyawan() {
        return $this->belongsTo(Karyawan::class, 'karyawan_id');
    }
}
