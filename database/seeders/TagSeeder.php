<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use \Illuminate\Support\Facades\DB;

class TagSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('tags')->insert([
            ['id' => 1, 'name' => 'Esencial'],
            ['id' => 2, 'name' => 'Personal'],
            ['id' => 3, 'name' => 'Trabajo'],
            ['id' => 4, 'name' => 'Regalo'],
            ['id' => 5, 'name' => 'Donación'],
            ['id' => 6, 'name' => 'Ocasión Especial'],
            ['id' => 7, 'name' => 'Hobbie'],
            ['id' => 8, 'name' => 'Lujo'],
            ['id' => 9, 'name' => 'Ahorro'],
            ['id' => 10, 'name' => 'Préstamo'],
        ]);
    }
}
