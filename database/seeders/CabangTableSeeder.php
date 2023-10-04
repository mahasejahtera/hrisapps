<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CabangTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('cabang')->insert([
            [
                'kode_cabang' => 'BDG',
                'nama_cabang' => 'BANDUNG',
                'lokasi_cabang' => '-7.3017453427514525,108.2401495272123',
                'radius_cabang' => 20,
            ],
            [
                'kode_cabang' => 'TSM',
                'nama_cabang' => 'Tasikmalaya',
                'lokasi_cabang' => '-7.291292253654425,108.23155080427959',
                'radius_cabang' => 30,
            ],
        ]);
    }
}
