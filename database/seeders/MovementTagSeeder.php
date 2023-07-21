<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MovementTagSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('movement_tag')->insert([
            ['movement_id' => 1, 'tag_id' => 3],
            ['movement_id' => 3, 'tag_id' => 9],
            ['movement_id' => 4, 'tag_id' => 10],
            ['movement_id' => 5, 'tag_id' => 10],
            ['movement_id' => 6, 'tag_id' => 7],
            ['movement_id' => 6, 'tag_id' => 8],
            ['movement_id' => 7, 'tag_id' => 2],
            ['movement_id' => 7, 'tag_id' => 1],
        ]);
    }
}
