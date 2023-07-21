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
            ],
            [
                'id' => 2,
                'slug' => 'restaurante',
                'name' => 'Restaurantes',
            ],
            [
                'id' => 3,
                'slug' => 'transporte',
                'name' => 'Transporte',
            ],
            [
                'id' => 4,
                'slug' => 'entretenimiento',
                'name' => 'Entretenimiento',
            ],
            [
                'id' => 5,
                'slug' => 'viajes',
                'name' => 'Viajes',
            ],
            [
                'id' => 6,
                'slug' => 'shoppnig',
                'name' => 'Shopping',
            ],
            [
                'id' => 7,
                'slug' => 'educacion',
                'name' => 'Educación',
            ],
            [
                'id' => 8,
                'slug' => 'impuestos',
                'name' => 'Impuestos',
            ],
        ]);
    }
}
