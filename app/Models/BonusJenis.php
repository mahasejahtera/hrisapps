<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BonusJenis extends Model
{
    use HasFactory;

    protected $connection = 'db_payroll';
    protected $table = 'bonus_jenis';
    protected $fillable = [
        'nama_bonus',
        'tipe_bonus',
    ];
}
