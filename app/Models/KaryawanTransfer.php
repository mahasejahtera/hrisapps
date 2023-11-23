<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KaryawanTransfer extends Model
{
    use HasFactory;

    protected $connection = 'mysql';
    protected $table = 'karyawan_transfer';
    protected $fillable = [
        'karyawan_id',
        'status',
        'old_branch_mutation',
        'new_branch_mutation',
        'old_contract_id',
        'contract_id',
    ];

    public function karyawan() {
        return $this->belongsTo(Karyawan::class, 'karyawan_id');
    }

    public function oldContract() {
        return $this->belongsTo(KaryawanContract::class, 'old_contract_id');
    }

    public function contract() {
        return $this->belongsTo(KaryawanContract::class, 'contract_id');
    }

    public function oldBranch() {
        return $this->belongsTo(Cabang::class, 'old_branch_mutation', 'kode_cabang');
    }

    public function newBranch() {
        return $this->belongsTo(Cabang::class, 'new_branch_mutation', 'kode_cabang');
    }
}
