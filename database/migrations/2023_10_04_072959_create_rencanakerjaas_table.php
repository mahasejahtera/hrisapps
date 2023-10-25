<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up(): void
    {
        Schema::create('rencanakerjas', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_karyawan');
            $table->string('perihal');
            $table->string('lokasi');
            $table->string('waktu');
            $table->string('target_penyelesaian');
            $table->string('keterangan');
            $table->string('lampiran');
            $table->string('prioritas');
            $table->boolean('revisi')->default(false);
            $table->string('lampiran_revisi')->nullable();
            $table->string('ket_revisi')->nullable();
            $table->boolean('status')->default(false);
            $table->boolean('manajer_approval')->default(false);
            $table->boolean('pm_approval')->default(false);
            $table->boolean('hrd_approval')->default(false);
            $table->boolean('direktur_approval')->default(false);
            $table->boolean('komisaris_approval')->default(false);
            $table->timestamps();

            $table->foreign('id_karyawan')->references('id')->on('karyawans');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('rencanakerjas');
    }
};
