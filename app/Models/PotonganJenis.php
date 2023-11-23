<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PotonganJenis extends Model
{
    use HasFactory;

    protected $connection = 'db_payroll';
    protected $table = 'potongan_jenis';

    protected $fillable = [
        'nama_potongan',
        'tipe'
    ];
}
