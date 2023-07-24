<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('categories')->insert([
            [
                'id' => 1,
                'slug' => 'mercado',
                'name' => 'Mercado',
                'user_id' => '1',
            ],
            [
                'id' => 2,
                'slug' => 'restaurante',
                'name' => 'Restaurantes',
                'user_id' => '1',
            ],
            [
                'id' => 3,
                'slug' => 'transporte',
                'name' => 'Transporte',
                'user_id' => '1',
            ],
            [
                'id' => 4,
                'slug' => 'entretenimiento',
                'name' => 'Entretenimiento',
                'user_id' => '1',
            ],
            [
                'id' => 5,
                'slug' => 'viajes',
                'name' => 'Viajes',
                'user_id' => '1',
            ],
            [
                'id' => 6,
                'slug' => 'shoppnig',
                'name' => 'Shopping',
                'user_id' => '1',
            ],
            [
                'id' => 7,
                'slug' => 'educacion',
                'name' => 'Educación',
                'user_id' => '1',
            ],
            [
                'id' => 8,
                'slug' => 'impuestos',
                'name' => 'Impuestos',
                'user_id' => '1',
            ],
        ]);
    }
}
