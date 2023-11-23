<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KaryawanChildren extends Model
{
    use HasFactory;
    protected $connection = 'mysql';
    protected $table = "karyawan_children";
    protected $fillable = [
        'karyawan_id',
        'children_name',
        'children_gender',
        'children_age',
        'children_last_education',
        'children_last_job_position',
        'children_last_job_company',
    ];

    // karyawan relationship
    public function karyawan()
    {
        return $this->belongsTo(Karyawan::class, 'karyawan_id');
    }
}
