<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Permintaan extends Model
{
    use HasFactory;
    protected $table = 'permintaan';
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
        'tolak',
        'keterangan_tolak',
        'status',
        'manajer_approval',
        'pm_approval',
        'hrd_approval',
        'direktur_approval',
        'komisaris_approval',

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
