<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'name' => 'Adam Adifa',
            'email' => 'adam@gmail.com',
            'password' => Hash::make('12345678'), // Gantilah 'password' dengan kata sandi yang Anda inginkan
        ]);
    }
}
