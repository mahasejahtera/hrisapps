<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KaryawanDocument extends Model
{
    use HasFactory;

    protected $table = 'karyawan_document';

    protected $fillable = [
        'karyawan_id',
        'pas_photo',
        'ktp',
        'kk',
        'ijazah',
        'buku_rekening',
        'npwp',
        'bpjs'
    ];


    // karyawan relationship
    public function karyawan()
    {
        return $this->belongsTo(Karyawan::class, 'karyawan_id');
    }
}
