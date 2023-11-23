<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KaryawanBiodata extends Model
{
    use HasFactory;

    protected $connection = 'mysql';
    protected $table = 'karyawan_biodata';
    protected $fillable = [
        'karyawan_id',
        'fullname',
        'nickname',
        'identity_province',
        'identity_regency',
        'identity_district',
        'identity_village',
        'identity_postal_code',
        'address_identity',
        'current_province',
        'current_regency',
        'current_district',
        'current_village',
        'current_postal_code',
        'current_address',
        'address_status',
        'phone',
        'urgent_phone',
        'start_work',
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


    // indonesia
    public function identityProvince()
    {
        return $this->belongsTo(IndonesiaProvince::class, 'identity_province');
    }

    public function identityRegency()
    {
        return $this->belongsTo(IndonesiaRegency::class, 'identity_regency');
    }

    public function identityDistrict()
    {
        return $this->belongsTo(IndonesiaDistrict::class, 'identity_district');
    }

    public function identityVillage()
    {
        return $this->belongsTo(IndonesiaVillage::class, 'identity_village');
    }
    public function currentProvince()
    {
        return $this->belongsTo(IndonesiaProvince::class, 'current_province');
    }

    public function currentRegency()
    {
        return $this->belongsTo(IndonesiaRegency::class, 'current_regency');
    }

    public function currentDistrict()
    {
        return $this->belongsTo(IndonesiaDistrict::class, 'current_district');
    }

    public function currentVillage()
    {
        return $this->belongsTo(IndonesiaVillage::class, 'current_village');
    }
}
