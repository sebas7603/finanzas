<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ExternalSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('externals')->insert([
            ['id' => 1, 'name' => 'Netflix'],
            ['id' => 2, 'name' => 'Falabella'],
            ['id' => 3, 'name' => 'Rappi'],
            ['id' => 4, 'name' => 'Compuoptima'],
            ['id' => 5, 'name' => 'Exito'],
            ['id' => 6, 'name' => 'Avianca'],
            ['id' => 7, 'name' => 'Twitch'],
        ]);
    }
}
