<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Setjamkerja extends Model
{
    use HasFactory;
    protected $connection = 'mysql';
    protected $table = "konfigurasi_jamkerja";

    public function jam_kerja() {
        return $this->belongsTo(JamKerja::class, 'kode_jam_kerja', 'kode_jam_kerja');
    }
}
