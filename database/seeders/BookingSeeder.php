// database/seeders/BookingSeeder.php
<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Booking;
use App\Models\Property;
use App\Models\Guest;
use App\Models\Room;
use App\Models\RoomType;
use Carbon\Carbon;

class BookingSeeder extends Seeder
{
    public function run()
    {
        $properties = Property::all();
        $guests = Guest::all();
        
        $bookingSources = ['website', 'walk_in', 'phone', 'ota', 'travel_agent', 'corporate'];
        $bookingStatuses = ['pending', 'confirmed', 'checked_in', 'checked_out', 'cancelled'];
        
        // Create some bookings for each property
        foreach ($properties as $property) {
            $roomTypes = RoomType::where('property_id', $property->id)->get();
            $availableRooms = Room::where('property_id', $property->id)
                ->where('status', 'available')
                ->get();
            
            // Create 10 bookings for each property
            for ($i = 0; $i < 10; $i++) {
                $guest = $guests->random();
                $roomType = $roomTypes->random();
                
                // Random dates in the next 30 days
                $checkInDate = Carbon::now()->addDays(rand(1, 30));
                $checkOutDate = (clone $checkInDate)->addDays(rand(1, 7));
                
                $totalNights = $checkInDate->diffInDays($checkOutDate);
                
                // Calculate total price
                $totalPrice = $roomType->base_price * $totalNights;
                
                // Get a random room for this booking
                $room = $availableRooms->where('room_type_id', $roomType->id)->random();
                
                $booking = [
                    'property_id' => $property->id,
                    'guest_id' => $guest->id,
                    'room_id' => $room->id,
                    'room_type_id' => $roomType->id,
                    'check_in_date' => $checkInDate->format('Y-m-d'),
                    'check_out_date' => $checkOutDate->format('Y-m-d'),
                    'total_nights' => $totalNights,
                    'adults' => rand(1, 2),
                    'children' => rand(0, 2),
                    'infants' => rand(0, 1),
                    'special_requests' => $i % 3 == 0 ? 'Extra pillows requested' : null,
                    'status' => $bookingStatuses[array_rand($bookingStatuses)],
                    'booking_source' => $bookingSources[array_rand($bookingSources)],
                    'total_price' => $totalPrice,
                ];
                
                Booking::create($booking);
                
                // Update room status if booking is confirmed or checked in
                if (in_array($booking['status'], ['confirmed', 'checked_in'])) {
                    $room->status = 'occupied';
                    $room->save();
                }
            }
        }
    }
}