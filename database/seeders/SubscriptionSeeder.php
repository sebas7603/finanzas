<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SubscriptionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('subscriptions')->insert([
            [
                'id' => 1,
                'description' => 'Suscripción de Netflix',
                'amount' => 35000.00,
                'day' => 17,
                'month' => null,
                'category_id' => 4,
                'external_id' => 1,
            ],
            [
                'id' => 2,
                'description' => 'Intancia de EC2 y S3 de AWS',
                'amount' => 150000.00,
                'day' => 18,
                'month' => 3,
                'category_id' => 7,
                'external_id' => 8,
            ],
        ]);
    }
}
