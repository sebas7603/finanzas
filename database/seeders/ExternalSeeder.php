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
            [
                'id' => 1,
                'name' => 'Netflix',
                'slug' => 'netflix',
                'user_id' => '1',
            ],
            [
                'id' => 2,
                'name' => 'Falabella',
                'slug' => 'falabella',
                'user_id' => '1',
            ],
            [
                'id' => 3,
                'name' => 'Rappi',
                'slug' => 'rappi',
                'user_id' => '1',
            ],
            [
                'id' => 4,
                'name' => 'Compuoptima',
                'slug' => 'compuoptima',
                'user_id' => '1',
            ],
            [
                'id' => 5,
                'name' => 'Exito',
                'slug' => 'exito',
                'user_id' => '1',
            ],
            [
                'id' => 6,
                'name' => 'Avianca',
                'slug' => 'avianca',
                'user_id' => '1',
            ],
            [
                'id' => 7,
                'name' => 'Twitch',
                'slug' => 'twitch',
                'user_id' => '1',
            ],
            [
                'id' => 8,
                'name' => 'AWS',
                'slug' => 'aws',
                'user_id' => '1',
            ],
        ]);
    }
}
