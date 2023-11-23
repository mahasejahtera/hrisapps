<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bonus extends Model
{
    use HasFactory;

    protected $connection = 'db_payroll';
    protected $table = 'bonus_karyawan';
    protected $fillable = [
        'karyawan_id',
        'jenis_bonus_id',
        'jumlah_bonus',
        'bulan_bonus',
        'tahun_bonus',
    ];

    public function karyawan()
    {
        return $this->belongsTo(Karyawan::class, 'karyawan_id');
    }

    public function jenis_bonus()
    {
        return $this->belongsTo(BonusJenis::class, 'jenis_bonus_id');
    }
}
