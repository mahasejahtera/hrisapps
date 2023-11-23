<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TrackingLembur extends Model
{
    use HasFactory;

    protected $connection = 'mysql';
    protected $table = 'tracking_lembur';
    protected $fillable = [
        'lembur_id',
        'keterangan',
        'keterangan_tolak',
        'status',
        'date'
    ];


    public function lembur() {
        return $this->belongsTo(Lembur::class, 'lembur_id');
    }
}
