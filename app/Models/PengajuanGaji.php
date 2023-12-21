<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PengajuanGaji extends Model
{
    use HasFactory;
    protected $connection = 'db_payroll';
    protected $table = 'pengajuan_gaji';
    protected $fillable = [
        'bulan',
        'tahun',
        'status_karyawan',
        'status_approved',
        'is_read'
    ];
}
