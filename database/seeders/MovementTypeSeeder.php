<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MovementTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('movement_types')->insert([
            ['id' => 1, 'name' => 'Ingreso'],
            ['id' => 2, 'name' => 'Egreso'],
            ['id' => 3, 'name' => 'Crédito'],
        ]);
    }
}
