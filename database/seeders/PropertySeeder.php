// database/seeders/PropertySeeder.php
<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Property;
use App\Models\Currency;

class PropertySeeder extends Seeder
{
    public function run()
    {
        $defaultCurrency = Currency::where('is_default', true)->first();
        
        $properties = [
            [
                'name' => 'Grand Plaza Hotel',
                'description' => 'A luxury hotel in the heart of the city with modern amenities and exceptional service.',
                'address' => '123 Main Street',
                'city' => 'Dhaka',
                'country' => 'Bangladesh',
                'phone' => '+880-2-12345678',
                'email' => 'info@grandplaza.com',
                'check_in_time' => '14:00:00',
                'check_out_time' => '12:00:00',
                'timezone' => 'Asia/Dhaka',
                'currency_id' => $defaultCurrency->id,
                'is_active' => true,
            ],
            [
                'name' => 'Seaside Resort',
                'description' => 'A beautiful beachfront resort with stunning ocean views and world-class facilities.',
                'address' => '456 Beach Road',
                'city' => 'Cox\'s Bazar',
                'country' => 'Bangladesh',
                'phone' => '+880-1234-567890',
                'email' => 'info@seasideresort.com',
                'check_in_time' => '15:00:00',
                'check_out_time' => '11:00:00',
                'timezone' => 'Asia/Dhaka',
                'currency_id' => $defaultCurrency->id,
                'is_active' => true,
            ],
            [
                'name' => 'Mountain View Lodge',
                'description' => 'A cozy lodge nestled in the mountains, perfect for nature lovers and adventure seekers.',
                'address' => '789 Hillside Avenue',
                'city' => 'Sylhet',
                'country' => 'Bangladesh',
                'phone' => '+880-2345-678901',
                'email' => 'info@mountainview.com',
                'check_in_time' => '14:00:00',
                'check_out_time' => '12:00:00',
                'timezone' => 'Asia/Dhaka',
                'currency_id' => $defaultCurrency->id,
                'is_active' => true,
            ],
        ];

        foreach ($properties as $property) {
            Property::create($property);
        }
    }
}