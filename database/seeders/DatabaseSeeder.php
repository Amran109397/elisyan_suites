// database/seeders/DatabaseSeeder.php
<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        $this->call([
            CurrencySeeder::class,
            PropertySeeder::class,
            FloorSeeder::class,
            RoomTypeSeeder::class,
            RoomSeeder::class,
            GuestSeeder::class,
            BookingSeeder::class,
            PaymentSeeder::class,
        ]);
    }
}
