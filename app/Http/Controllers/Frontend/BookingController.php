<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Property;
use App\Models\RoomType;
use App\Models\Booking;
use App\Models\Guest;
use Carbon\Carbon;

class BookingController extends Controller
{
    public function create(Request $request)
    {
        $checkInDate = $request->query('check_in');
        $checkOutDate = $request->query('check_out');
        $adults = $request->query('adults', 1);
        $children = $request->query('children', 0);
        $roomTypeId = $request->query('room_type_id');
        
        $properties = Property::where('is_active', true)->get();
        $roomTypes = RoomType::where('is_active', true)->get();
        
        return view('frontend.booking.create', compact(
            'properties', 
            'roomTypes', 
            'checkInDate', 
            'checkOutDate', 
            'adults', 
            'children',
            'roomTypeId'
        ));
    }
    
    public function store(Request $request)
    {
        $validated = $request->validate([
            'property_id' => 'required|exists:properties,id',
            'room_type_id' => 'required|exists:room_types,id',
            'check_in_date' => 'required|date|after:today',
            'check_out_date' => 'required|date|after:check_in_date',
            'adults' => 'required|integer|min:1',
            'children' => 'nullable|integer|min:0',
            'infants' => 'nullable|integer|min:0',
            'special_requests' => 'nullable|string',
            'guest_first_name' => 'required|string|max:255',
            'guest_last_name' => 'required|string|max:255',
            'guest_email' => 'required|email|max:255',
            'guest_phone' => 'required|string|max:20',
        ]);

        $guest = Guest::firstOrCreate([
            'email' => $validated['guest_email']
        ], [
            'first_name' => $validated['guest_first_name'],
            'last_name' => $validated['guest_last_name'],
            'phone' => $validated['guest_phone'],
        ]);


        $booking = new Booking();
        $booking->property_id = $validated['property_id'];
        $booking->guest_id = $guest->id;
        $booking->room_type_id = $validated['room_type_id'];
        $booking->check_in_date = $validated['check_in_date'];
        $booking->check_out_date = $validated['check_out_date'];
        $booking->total_nights = Carbon::parse($validated['check_in_date'])->diffInDays(Carbon::parse($validated['check_out_date']));
        $booking->adults = $validated['adults'];
        $booking->children = $validated['children'] ?? 0;
        $booking->infants = $validated['infants'] ?? 0;
        $booking->special_requests = $validated['special_requests'];
        $booking->status = 'pending';
        $booking->booking_source = 'website';
        $booking->booking_reference = 'BK-' . strtoupper(Str::random(8));
        

        $roomType = RoomType::find($validated['room_type_id']);
        $totalPrice = $roomType->base_price * $booking->total_nights;
        $booking->total_price = $totalPrice;
        
        $booking->save();

        return redirect()->route('frontend.payment.create', $booking->id);
    }
    
    public function confirmation($id)
    {
        $booking = Booking::with(['guest', 'property', 'roomType'])
            ->findOrFail($id);
            
        return view('frontend.booking.confirmation', compact('booking'));
    }
}