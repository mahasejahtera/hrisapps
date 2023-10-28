<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tugas extends Model
{
    use HasFactory;
    protected $table = 'tugas';
    protected $fillable = [
        'id_karyawan_penerima',
        'id_karyawan_pengirim',
        'perihal',
        'lokasi',
        'waktu',
        'jatuh_tempo',
        'keterangan_pengirim',
        'lampiran_pengirim',
        'prioritas',
        'keterangan_penerima',
        'lampiran_penerima',
        'progress1',
        'progress2',
        'progress3',
        'progress4',
        'progress5',
        'keterangan_progress',
        'status',
    ];

    public function karyawanPenerima()
    {
        return $this->belongsTo(Karyawan::class, 'id_karyawan_penerima');
    }
    public function karyawanPengirim()
    {
        return $this->belongsTo(Karyawan::class, 'id_karyawan_pengirim');
    }
}
