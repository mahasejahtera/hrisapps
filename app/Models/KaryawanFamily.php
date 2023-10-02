<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KaryawanFamily extends Model
{
    use HasFactory;

    protected $table = 'karyawan_family';
    protected $fillable = [
        'karyawan_id',
        'father_name',
        'mother_name',
        'siblings_num',
        'couple_name',
        'child_to',
    ];

    // karyawan relationship
    public function karyawan()
    {
        return $this->belongsTo(Karyawan::class, 'karyawan_id');
    }
}
