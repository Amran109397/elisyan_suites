// database/seeders/RoomTypeSeeder.php
<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\RoomType;
use App\Models\Property;

class RoomTypeSeeder extends Seeder
{
    public function run()
    {
        $properties = Property::all();
        
        foreach ($properties as $property) {
            $roomTypes = [
                [
                    'property_id' => $property->id,
                    'name' => 'Standard Room',
                    'description' => 'Comfortable room with all essential amenities',
                    'base_price' => 100.00,
                    'max_occupancy' => 2,
                    'size_sqm' => 25.00,
                    'bed_type' => 'Double',
                    'is_active' => true,
                ],
                [
                    'property_id' => $property->id,
                    'name' => 'Deluxe Room',
                    'description' => 'Spacious room with premium amenities',
                    'base_price' => 150.00,
                    'max_occupancy' => 3,
                    'size_sqm' => 35.00,
                    'bed_type' => 'Queen',
                    'is_active' => true,
                ],
                [
                    'property_id' => $property->id,
                    'name' => 'Suite',
                    'description' => 'Luxurious suite with separate living area',
                    'base_price' => 250.00,
                    'max_occupancy' => 4,
                    'size_sqm' => 50.00,
                    'bed_type' => 'King',
                    'is_active' => true,
                ],
                [
                    'property_id' => $property->id,
                    'name' => 'Family Room',
                    'description' => 'Large room perfect for families',
                    'base_price' => 180.00,
                    'max_occupancy' => 5,
                    'size_sqm' => 40.00,
                    'bed_type' => 'Twin',
                    'is_active' => true,
                ],
            ];

            foreach ($roomTypes as $roomType) {
                RoomType::create($roomType);
            }
        }
    }
}