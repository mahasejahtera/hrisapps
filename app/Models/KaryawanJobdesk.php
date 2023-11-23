<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KaryawanJobdesk extends Model
{
    use HasFactory;

    protected $connection = 'mysql';
    protected $table = 'karyawan_jobdesk';
    protected $fillable = [
        'karyawan_id',
        'jobdesk'
    ];


    public function karyawan()
    {
        return $this->belongsTo(Karyawan::class, 'karyawan_id');
    }
}
