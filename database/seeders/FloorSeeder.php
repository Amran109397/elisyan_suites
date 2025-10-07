// database/seeders/FloorSeeder.php
<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Floor;
use App\Models\Property;

class FloorSeeder extends Seeder
{
    public function run()
    {
        $properties = Property::all();
        
        foreach ($properties as $property) {
            $floors = [
                [
                    'property_id' => $property->id,
                    'floor_number' => 1,
                    'name' => 'Ground Floor',
                ],
                [
                    'property_id' => $property->id,
                    'floor_number' => 2,
                    'name' => 'First Floor',
                ],
                [
                    'property_id' => $property->id,
                    'floor_number' => 3,
                    'name' => 'Second Floor',
                ],
            ];

            foreach ($floors as $floor) {
                Floor::create($floor);
            }
        }
    }
}