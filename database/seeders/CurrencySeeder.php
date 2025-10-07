// database/seeders/CurrencySeeder.php
<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Currency;

class CurrencySeeder extends Seeder
{
    public function run()
    {
        $currencies = [
            [
                'code' => 'USD',
                'name' => 'US Dollar',
                'symbol' => '$',
                'is_active' => true,
                'is_default' => true,
            ],
            [
                'code' => 'EUR',
                'name' => 'Euro',
                'symbol' => '€',
                'is_active' => true,
                'is_default' => false,
            ],
            [
                'code' => 'GBP',
                'name' => 'British Pound',
                'symbol' => '£',
                'is_active' => true,
                'is_default' => false,
            ],
            [
                'code' => 'BDT',
                'name' => 'Bangladeshi Taka',
                'symbol' => '৳',
                'is_active' => true,
                'is_default' => false,
            ],
            [
                'code' => 'JPY',
                'name' => 'Japanese Yen',
                'symbol' => '¥',
                'is_active' => true,
                'is_default' => false,
            ],
            [
                'code' => 'CAD',
                'name' => 'Canadian Dollar',
                'symbol' => 'C$',
                'is_active' => true,
                'is_default' => false,
            ],
        ];

        foreach ($currencies as $currency) {
            Currency::create($currency);
        }
    }
}