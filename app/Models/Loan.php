<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Loan extends Model
{
    use HasFactory;
    protected $connection = 'db_payroll';
    protected $table = 'pinjaman';
    protected $fillable = [
        'karyawan_id',
        'jumlah_pinjam',
        'bulan_pinjam',
        'tahun_pinjam',
        'jumlah_cicilan',
        'lama_cicilan',
        'total_dibayar',
        'bulan_dibayar',
        'is_lunas',
    ];
    
    public function karyawan() {
        return $this->belongsTo(Karyawan::class, 'karyawan_id');
    }
}
