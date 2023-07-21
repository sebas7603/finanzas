<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Bank;

class DebtSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $coofinepBank = Bank::where('name', 'Coofinep')->first();
        DB::table('debts')->insert([
            [
                'id' => 1,
                'description' => 'Préstamo Coofinep de prueba',
                'amount' => 5000000.00,
                'fee_value' => 272000.00,
                'fee_day' => 5,
                'fee_number' => 36,
                'fee_current' => 0,
                'status' => 1,
                'category_id' => 5,
                'external_id' => null,
                'bank_id' => $coofinepBank->id,
            ],
        ]);
    }
}
