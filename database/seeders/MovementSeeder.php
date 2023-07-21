<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;

class MovementSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('movements')->insert([
            [
                'id' => 1,
                'financial_id' => 1,
                'amount' => 3000000.00,
                'description' => 'Salario Julio 2023',
                'income' => true,
                'date' => Carbon::parse('2023-07-01'),
                'category_id' => null,
                'movement_type_id' => 1,
                'payment_method_id' => null,
                'external_id' => null,
                'payment_id' => null,
                'account_id' => 2,
            ],
            [
                'id' => 2,
                'financial_id' => 1,
                'amount' => 300000.00,
                'description' => 'Ahorro Julio 2023',
                'income' => false,
                'date' => Carbon::parse('2023-07-02'),
                'category_id' => null,
                'movement_type_id' => 2,
                'payment_method_id' => 1,
                'external_id' => null,
                'payment_id' => null,
                'account_id' => 2,
            ],
            [
                'id' => 3,
                'financial_id' => 1,
                'amount' => 300000.00,
                'description' => 'Ahorro Julio 2023',
                'income' => true,
                'date' => Carbon::parse('2023-07-02'),
                'category_id' => null,
                'movement_type_id' => 1,
                'payment_method_id' => null,
                'external_id' => null,
                'payment_id' => null,
                'account_id' => 1,
            ],
            [
                'id' => 4,
                'financial_id' => 1,
                'amount' => 272000.00,
                'description' => 'Pago préstamo Coofinep',
                'income' => false,
                'date' => Carbon::parse('2023-07-05'),
                'category_id' => 5,
                'movement_type_id' => 2,
                'payment_method_id' => 1,
                'external_id' => null,
                'payment_id' => 1,
                'account_id' => 2,
            ],
            [
                'id' => 5,
                'financial_id' => 1,
                'amount' => 560000.00,
                'description' => 'Pago tarjeta de crédito Scotiabank',
                'income' => false,
                'date' => Carbon::parse('2023-07-05'),
                'category_id' => null,
                'movement_type_id' => 2,
                'payment_method_id' => 1,
                'external_id' => null,
                'payment_id' => 1,
                'account_id' => 2,
            ],
            [
                'id' => 6,
                'financial_id' => 1,
                'amount' => 35000.00,
                'description' => 'Pago suscripción Netflix',
                'income' => false,
                'date' => Carbon::parse('2023-07-17'),
                'category_id' => 4,
                'movement_type_id' => 3,
                'payment_method_id' => 4,
                'external_id' => 1,
                'payment_id' => 2,
                'account_id' => null,
            ],
            [
                'id' => 7,
                'financial_id' => 1,
                'amount' => 60000.00,
                'description' => 'Compra en Falabella',
                'income' => false,
                'date' => Carbon::now(),
                'category_id' => 6,
                'movement_type_id' => 3,
                'payment_method_id' => 4,
                'external_id' => 2,
                'payment_id' => null,
                'account_id' => null,
            ],
        ]);
    }
}
