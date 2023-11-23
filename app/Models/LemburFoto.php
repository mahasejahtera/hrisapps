<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LemburFoto extends Model
{
    use HasFactory;
    protected $connection = 'mysql';
    protected $table = 'lembur_foto';
    protected $fillable = [
        'lembur_id',
        'foto_lembur',
        'status'
    ];


    public function lembur() {
        return $this->belongsTo(Lembur::class, 'lembur_id');
    }
}
