<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up(): void
    {
        Schema::table('rencanakerjas', function (Blueprint $table) {
            $table->boolean('revisi')->default(false)->after('prioritas');
            $table->string('lampiran_revisi')->after('revisi')->nullable();
            $table->string('ket_revisi')->after('lampiran_revisi')->nullable();
            $table->boolean('status')->default(false)->after('ket_revisi');
            $table->boolean('manajer_approval')->default(false)->after('status');
            $table->boolean('pm_approval')->default(false)->after('manajer_approval');
            $table->boolean('hrd_approval')->default(false)->after('pm_approval');
            $table->boolean('direktur_approval')->default(false)->after('hrd_approval');
            $table->boolean('komisaris_approval')->default(false)->after('direktur_approval');
        });
    }


    public function down(): void
    {
        Schema::table('rencanakerjas', function (Blueprint $table) {

        });
    }
};
