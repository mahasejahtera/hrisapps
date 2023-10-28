<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up(): void
    {
        Schema::create('tugas', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_karyawan_penerima');
            $table->unsignedBigInteger('id_karyawan_pengirim');
            $table->string('perihal');
            $table->string('lokasi');
            $table->string('waktu');
            $table->string('jatuh_tempo');
            $table->string('keterangan_pengirim');
            $table->string('lampiran_pengirim');
            $table->string('prioritas');
            $table->string('progress1')->nullable();
            $table->string('progress2')->nullable();
            $table->string('progress3')->nullable();
            $table->string('progress4')->nullable();
            $table->string('progress5')->nullable();
            $table->string('keterangan_progress')->nullable();
            $table->integer('status')->default(0);
            $table->timestamps();
            $table->foreign('id_karyawan_penerima')->references('id')->on('karyawans');
            $table->foreign('id_karyawan_pengirim')->references('id')->on('karyawans');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tugas');
    }
};
