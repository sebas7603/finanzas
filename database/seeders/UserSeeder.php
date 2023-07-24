<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            [
                'id' => '1',
                'names' => 'Sebastián',
                'lastnames' => 'Ayala Suárez',
                'email' => 'sebastianutpae@gmail.com',
                'password' => Hash::make('00000000'),
            ],
            [
                'id' => '2',
                'names' => 'Sebas',
                'lastnames' => 'Prueba',
                'email' => 'sebas2@google.com',
                'password' => Hash::make('00000000'),
            ]
        ]);
    }
}
