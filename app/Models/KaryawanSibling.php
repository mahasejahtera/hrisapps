<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KaryawanSibling extends Model
{
    use HasFactory;

    protected $connection = 'mysql';
    protected $table = "karyawan_siblings";
    protected $fillable = [
        'karyawan_id',
        'siblings_name',
        'siblings_gender',
        'siblings_age',
        'siblings_last_education',
        'siblings_last_job_position',
        'siblings_last_job_company',
    ];

    // karyawan relationship
    public function karyawan()
    {
        return $this->belongsTo(Karyawan::class, 'karyawan_id');
    }
}
