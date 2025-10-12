<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        $this->call([
            RoleSeeder::class, // This must be first
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