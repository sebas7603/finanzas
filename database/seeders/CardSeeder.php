<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Bank;

class CardSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $coofinepBank = Bank::where('name', 'Coofinep')->first();
        $colpatriaBank = Bank::where('name', 'Scotiabank Colpatria')->first();
        DB::table('cards')->insert([
            [
                'bank_id' => $coofinepBank->id,
                'account_id' => $coofinepBank->accounts()->first()->id,
                'card_type_id' => 1,
                'last_numbers' => '4252',
                'quota' => null,
                'amount' => null,
                'fee' => 0.0,
                'balance_day' => null,
                'payment_day' => null,
            ],
            [
                'bank_id' => $colpatriaBank->id,
                'account_id' => null,
                'card_type_id' => 2,
                'last_numbers' => '0185',
                'quota' => 0.0,
                'amount' => 3000000.00,
                'fee' => 15000.00,
                'balance_day' => 25,
                'payment_day' => 7,
            ],
        ]);
    }
}
