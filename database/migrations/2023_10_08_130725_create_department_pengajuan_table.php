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
        Schema::create('department_pengajuan', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_dept'); // Field id_departem
            $table->unsignedBigInteger('id_pengajuan'); // Field id_pengajuan
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
        Schema::dropIfExists('department_pengajuan');
    }
};
