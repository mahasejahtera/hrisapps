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
            $table->timestamps();

            $table->foreign('id_karyawan')->references('id')->on('karyawans')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('rencanakerjas');
    }
};
