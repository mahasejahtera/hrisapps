<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('permintaan', function (Blueprint $table) {
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
            $table->string('lampiran_penerima')->nullable();
            $table->string('keterangan_penerima')->nullable();
            $table->boolean('tolak')->default(false);
            $table->string('keterangan_tolak')->nullable();
            $table->integer('status')->default(0);
            $table->boolean('manajer_approval')->default(false);
            $table->boolean('pm_approval')->default(false);
            $table->boolean('hrd_approval')->default(false);
            $table->boolean('direktur_approval')->default(false);
            $table->boolean('komisaris_approval')->default(false);
            $table->timestamps();
            $table->foreign('id_karyawan_penerima')->references('id')->on('karyawans');
            $table->foreign('id_karyawan_pengirim')->references('id')->on('karyawans');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('permintaan');
    }
};
