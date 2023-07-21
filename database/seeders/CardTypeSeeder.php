<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CardTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('card_types')->insert([
            ['id' => 1, 'name' => 'Tarjeta Débito'],
            ['id' => 2, 'name' => 'Tarjeta de Crédito'],
        ]);
    }
}
