<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pengajuan_hutang_operasional', function (Blueprint $table) {
            $table->id();
            $table->string('nomor');
            $table->date('tanggal');
            $table->date('due_date');
            $table->string('perihal_pekerjaan');
            $table->string('item');
            $table->integer('qty');
            $table->string('satuan');
            $table->decimal('harga', 10, 2);
            $table->decimal('jumlah_harga', 10, 2);
            $table->text('keterangan')->nullable();
            $table->decimal('total_biaya', 10, 2);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pengajuan_hutang_operasional');
    }
};
