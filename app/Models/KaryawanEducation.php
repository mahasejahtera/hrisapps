<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KaryawanEducation extends Model
{
    use HasFactory;

    protected $connection = 'mysql';
    protected $table = 'karyawan_education';
    protected $fillable = [
        'karyawan_id',
        'primary_school',
        'junior_hight_school',
        'senior_hight_School',
        'university',
        'major',
    ];

    // karyawan relationship
    public function karyawan()
    {
        return $this->belongsTo(Karyawan::class, 'karyawan_id');
    }
}
