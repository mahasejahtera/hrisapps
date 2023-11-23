<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class Presensi extends Model
{
    use HasFactory, LogsActivity;
    protected $connection = 'mysql';
    protected $table = "presensi";

    protected $fillable = [
        'nik',
        'tgl_presensi',
        'jam_in',
        'jam_out',
        'finger_in',
        'finger_out',
        'break_start',
        'break_finish',
        'foto_in',
        'foto_out',
        'lokasi_in',
        'lokasi_out',
        'kode_jam_kerja',
        'status_absen',
        'finger_status',
        'is_late',
        'status',
        'meal_num'
    ];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults();
    }

    public function karyawan()
    {
        return $this->belongsTo(Karyawan::class, 'nik', 'nik');
    }

    public function jam_kerja()
    {
        return $this->belongsTo(JamKerja::class, 'kode_jam_kerja', 'kode_jam_kerja');
    }
}
