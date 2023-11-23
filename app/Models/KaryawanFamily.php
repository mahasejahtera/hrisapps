<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KaryawanFamily extends Model
{
    use HasFactory;

    protected $connection = 'mysql';
    protected $table = 'karyawan_family';
    protected $fillable = [
        'karyawan_id',
        'father_name',
        'father_status',
        'father_age',
        'father_last_education',
        'father_last_job_position',
        'father_last_job_company',
        'mother_name',
        'mother_status',
        'mother_age',
        'mother_last_education',
        'mother_last_job_position',
        'mother_last_job_company',
        'siblings_num',
        'couple_name',
        'couple_age',
        'couple_last_education',
        'couple_last_job_position',
        'couple_last_job_company',
        'child_to',
    ];

    // karyawan relationship
    public function karyawan()
    {
        return $this->belongsTo(Karyawan::class, 'karyawan_id');
    }
}
