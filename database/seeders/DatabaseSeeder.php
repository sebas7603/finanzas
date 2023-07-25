<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            UserSeeder::class,
            CardTypeSeeder::class,
            BankSeeder::class,
            FinancialSeeder::class,
            AccountSeeder::class,
            CardSeeder::class,
            PaymentMethodSeeder::class,
            TagSeeder::class,
            CategorySeeder::class,
            ExternalSeeder::class,
            DebtSeeder::class,
            SubscriptionSeeder::class,
            PaymentSeeder::class,
            MovementTypeSeeder::class,
            MovementSeeder::class,
            MovementTagSeeder::class,
        ]);
    }
}
