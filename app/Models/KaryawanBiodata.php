<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KaryawanBiodata extends Model
{
    use HasFactory;

    protected $table = 'karyawan_biodata';
    protected $fillable = [
        'karyawan_id',
        'fullname',
        'nickname',
        'current_address',
        'address_status',
        'phone',
        'urgent_phone',
        'start_work',
        'current_position',
        'email',
        'gender',
        'birthplace',
        'birthdate',
        'religion',
        'weight',
        'height',
        'blood_type',
        'marital_status',
        'years_married',
        'dependents_num'
    ];



    // karyawan relationship
    public function karyawan()
    {
        return $this->belongsTo(Karyawan::class, 'karyawan_id');
    }
}
