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
            [
                'id' => 1,
                'name' => 'Esencial',
                'slug' => 'esencial',
                'user_id' => '1'
            ],
            [
                'id' => 2,
                'name' => 'Personal',
                'slug' => 'personal',
                'user_id' => '1'
            ],
            [
                'id' => 3,
                'name' => 'Trabajo',
                'slug' => 'trabajo',
                'user_id' => '1'
            ],
            [
                'id' => 4,
                'name' => 'Regalo',
                'slug' => 'regalo',
                'user_id' => '1'
            ],
            [
                'id' => 5,
                'name' => 'Donación',
                'slug' => 'donacion',
                'user_id' => '1'
            ],
            [
                'id' => 6,
                'name' => 'Ocasión Especial',
                'slug' => 'ocasion-especial',
                'user_id' => '1'
            ],
            [
                'id' => 7,
                'name' => 'Hobbie',
                'slug' => 'hobbie',
                'user_id' => '1'
            ],
            [
                'id' => 8,
                'name' => 'Lujo',
                'slug' => 'lujo',
                'user_id' => '1'
            ],
            [
                'id' => 9,
                'name' => 'Ahorro',
                'slug' => 'ahorro',
                'user_id' => '1'
            ],
            [
                'id' => 10,
                'name' => 'Préstamo',
                'slug' => 'prestamo',
                'user_id' => '1'
            ],
        ]);
    }
}
