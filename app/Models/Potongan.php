<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Potongan extends Model
{
    use HasFactory;
    protected $connection = 'db_payroll';
    protected $table = 'potongan_karyawan';
    protected $fillable = [
        'karyawan_id',
        'jenis_potongan_id',
        'total_potongan',
        'jml_potongan',
        'bulan_mulai',
        'tahun_mulai',
        'lama_potongan',
        'sisa_bulan_potongan',
        'is_active'
    ];

    public function karyawan()
    {
        return $this->belongsTo(Karyawan::class, 'karyawan_id');
    }

    public function jenis_potongan() {
        return $this->belongsTo(PotonganJenis::class, 'jenis_potongan_id');
    }
}
