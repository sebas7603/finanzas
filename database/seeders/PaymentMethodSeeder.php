<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PaymentMethodSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('payment_methods')->insert([
            [
                'id' => 1,
                'name' => 'Coofinep - Cuenta',
                'account_id' => 2,
                'card_id' => null,
                'credit' => false,
            ],
            [
                'id' => 2,
                'name' => 'Coofinep - Tarjeta Débito',
                'account_id' => null,
                'card_id' => 1,
                'credit' => false,
            ],
            [
                'id' => 3,
                'name' => 'Dale - Cuenta',
                'account_id' => 3,
                'card_id' => null,
                'credit' => false,
            ],
            [
                'id' => 4,
                'name' => 'Scotiabank - Tarjeta de Crédito',
                'account_id' => null,
                'card_id' => 2,
                'credit' => true,
            ],
        ]);
    }
}
