<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PaymentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('payments')->insert([
            [
                'id' => 1,
                'amount' => 272000.00,
                'day' => 5,
                'payment_method_id' => 1,
                'debt_id' => 1,
                'subscription_id' => null,
                'card_id' => null,
            ],
            [
                'id' => 2,
                'amount' => 35000.00,
                'day' => 17,
                'payment_method_id' => 4,
                'debt_id' => null,
                'subscription_id' => 1,
                'card_id' => null,
            ],
            [
                'id' => 3,
                'amount' => 150000.00,
                'day' => 18,
                'payment_method_id' => 4,
                'debt_id' => null,
                'subscription_id' => 2,
                'card_id' => null,
            ],
            [
                'id' => 4,
                'amount' => 560000.00,
                'day' => 5,
                'payment_method_id' => 1,
                'debt_id' => null,
                'subscription_id' => null,
                'card_id' => 2,
            ],
        ]);
    }
}
