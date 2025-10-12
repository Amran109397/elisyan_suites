<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Room;
use App\Models\Property;
use App\Models\RoomType;
use App\Models\Floor;

class RoomSeeder extends Seeder
{
    public function run()
    {
        $properties = Property::all();
        
        foreach ($properties as $property) {
            $roomTypes = RoomType::where('property_id', $property->id)->get();
            $floors = Floor::where('property_id', $property->id)->get();
            
            $roomNumber = 100;
            
            foreach ($floors as $floor) {
                foreach ($roomTypes as $roomType) {
                    // Create 3 rooms of each type on each floor
                    for ($i = 1; $i <= 3; $i++) {
                        $room = [
                            'property_id' => $property->id,
                            'room_type_id' => $roomType->id,
                            'floor_id' => $floor->id,
                            'room_number' => $floor->floor_number . sprintf('%02d', $i),
                            'status' => 'available',
                            'is_smoking' => ($i % 3 == 0), // Every 3rd room is smoking
                        ];
                        
                        Room::create($room);
                    }
                }
            }
        }
    }
}