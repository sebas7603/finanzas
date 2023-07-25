<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use \App\Models\Bank;

class AccountSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $luloBank = Bank::where('name', 'Lulo Bank')->first();
        $coofinepBank = Bank::where('name', 'Coofinep')->first();
        $daleBank = Bank::where('name', 'Dale')->first();
        DB::table('accounts')->insert([
            [
                'id' => '1',
                'financial_id' => '1',
                'bank_id' => $luloBank->id,
                'number' => '01234561',
                'balance' => 2500000.00
            ],
            [
                'id' => '2',
                'financial_id' => '1',
                'bank_id' => $coofinepBank->id,
                'number' => '01234562',
                'balance' => 10000.00
            ],
            [
                'id' => '3',
                'financial_id' => '1',
                'bank_id' => $daleBank->id,
                'number' => '01234563',
                'balance' => 20000.00
            ],
        ]);
    }
}
