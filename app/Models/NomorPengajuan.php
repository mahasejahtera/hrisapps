<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasTimestamps;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NomorPengajuan extends Model
{
    use HasFactory, HasTimestamps;

    // protected $fillable = ['created_at'];
    protected $connection = 'db_pengajuan';
    protected $table = 'nomor_pengajuan';

    public $timestamps = true;
}
