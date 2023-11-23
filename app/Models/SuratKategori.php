<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SuratKategori extends Model
{
    use HasFactory;
    protected $connection = 'db_surat';
    protected $table = 'kategori';

    protected $filable = [
        'kode',
        'nama',
        'type'
    ];
}
