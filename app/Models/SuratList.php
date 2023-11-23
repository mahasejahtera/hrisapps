<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SuratList extends Model
{
    use HasFactory;
    protected $connection = 'db_surat';
    protected $table = 'surat_list';

    protected $fillable = [
        'karyawan_penerima_id',
        'karyawan_pembuat_id',
        'kategori_id',
        'kategori_kode',
        'no_surat',
        'perihal',
        'keterangan'
    ];


    public function karyawan_penerima() {
        return $this->belongsTo(Karyawan::class, 'karyawan_penerima_id');
    }

    public function karyawan_pembuat() {
        return $this->belongsTo(Karyawan::class, 'karyawan_pembuat_id');
    }

    public function kategori_surat() {
        return $this->belongsTo(SuratKategori::class, 'kategori_kode', 'kode');
    }
}
