// app/Http/Controllers/BookingController.php
<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Property;
use App\Models\Guest;
use App\Models\Room;
use App\Models\RoomType;
use Illuminate\Http\Request;

class BookingController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('role:super_admin,property_manager,receptionist');
    }

    public function index()
    {
        $bookings = Booking::with('property', 'guest', 'room', 'roomType')->get();
        return view('bookings.index', compact('bookings'));
    }

    public function create()
    {
        $properties = Property::where('is_active', true)->get();
        $guests = Guest::all();
        $roomTypes = RoomType::where('is_active', true)->get();
        return view('bookings.create', compact('properties', 'guests', 'roomTypes'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'property_id' => 'required|exists:properties,id',
            'guest_id' => 'required|exists:guests,id',
            'room_id' => 'nullable|exists:rooms,id',
            'room_type_id' => 'required|exists:room_types,id',
            'check_in_date' => 'required|date|after_or_equal:today',
            'check_out_date' => 'required|date|after:check_in_date',
            'adults' => 'required|integer|min:1',
            'children' => 'required|integer|min:0',
            'infants' => 'required|integer|min:0',
            'special_requests' => 'nullable|string',
            'status' => 'required|in:pending,confirmed,checked_in,checked_out,cancelled,no_show,modified',
            'booking_source' => 'required|in:website,walk_in,phone,ota,travel_agent,corporate',
            'total_price' => 'required|numeric|min:0',
        ]);

        Booking::create($validated);

        return redirect()->route('bookings.index')
            ->with('success', 'Booking created successfully.');
    }

    public function show(Booking $booking)
    {
        $booking->load('property', 'guest', 'room', 'roomType', 'payments', 'addons', 'services');
        return view('bookings.show', compact('booking'));
    }

    public function edit(Booking $booking)
    {
        $properties = Property::where('is_active', true)->get();
        $guests = Guest::all();
        $roomTypes = RoomType::where('is_active', true)->get();
        return view('bookings.edit', compact('booking', 'properties', 'guests', 'roomTypes'));
    }

    public function update(Request $request, Booking $booking)
    {
        $validated = $request->validate([
            'property_id' => 'required|exists:properties,id',
            'guest_id' => 'required|exists:guests,id',
            'room_id' => 'nullable|exists:rooms,id',
            'room_type_id' => 'required|exists:room_types,id',
            'check_in_date' => 'required|date',
            'check_out_date' => 'required|date|after:check_in_date',
            'adults' => 'required|integer|min:1',
            'children' => 'required|integer|min:0',
            'infants' => 'required|integer|min:0',
            'special_requests' => 'nullable|string',
            'status' => 'required|in:pending,confirmed,checked_in,checked_out,cancelled,no_show,modified',
            'booking_source' => 'required|in:website,walk_in,phone,ota,travel_agent,corporate',
            'total_price' => 'required|numeric|min:0',
        ]);

        $booking->update($validated);

        return redirect()->route('bookings.index')
            ->with('success', 'Booking updated successfully.');
    }

    public function destroy(Booking $booking)
    {
        $booking->delete();
        return redirect()->route('bookings.index')
            ->with('success', 'Booking deleted successfully.');
    }

    public function checkAvailability(Request $request)
    {
        $request->validate([
            'property_id' => 'required|exists:properties,id',
            'room_type_id' => 'required|exists:room_types,id',
            'check_in_date' => 'required|date',
            'check_out_date' => 'required|date|after:check_in_date',
        ]);

        $propertyId = $request->property_id;
        $roomTypeId = $request->room_type_id;
        $checkInDate = $request->check_in_date;
        $checkOutDate = $request->check_out_date;

        $availableRooms = Room::where('property_id', $propertyId)
            ->where('room_type_id', $roomTypeId)
            ->where('status', 'available')
            ->whereNotIn('id', function ($query) use ($checkInDate, $checkOutDate) {
                $query->select('room_id')
                    ->from('bookings')
                    ->where('status', '!=', 'cancelled')
                    ->where(function ($q) use ($checkInDate, $checkOutDate) {
                        $q->whereBetween('check_in_date', [$checkInDate, $checkOutDate])
                            ->orWhereBetween('check_out_date', [$checkInDate, $checkOutDate])
                            ->orWhere(function ($q) use ($checkInDate, $checkOutDate) {
                                $q->where('check_in_date', '<=', $checkInDate)
                                    ->where('check_out_date', '>=', $checkOutDate);
                            });
                    });
            })
            ->get();

        return response()->json([
            'available' => $availableRooms->count(),
            'rooms' => $availableRooms
        ]);
    }

    public function calendar()
    {
        return view('bookings.calendar');
    }

    public function calendarData(Request $request)
    {
        $start = $request->start;
        $end = $request->end;
        
        $bookings = Booking::whereBetween('check_in_date', [$start, $end])
            ->orWhereBetween('check_out_date', [$start, $end])
            ->with('guest', 'room')
            ->get();

        $events = [];
        
        foreach ($bookings as $booking) {
            $events[] = [
                'id' => $booking->id,
                'title' => $booking->guest->full_name . ' - ' . ($booking->room ? $booking->room->room_number : 'No Room'),
                'start' => $booking->check_in_date,
                'end' => $booking->check_out_date,
                'color' => $this->getBookingColor($booking->status),
                'url' => route('bookings.show', $booking->id)
            ];
        }

        return response()->json($events);
    }

    private function getBookingColor($status)
    {
        $colors = [
            'pending' => '#ffc107',
            'confirmed' => '#28a745',
            'checked_in' => '#17a2b8',
            'checked_out' => '#6c757d',
            'cancelled' => '#dc3545',
            'no_show' => '#343a40',
            'modified' => '#6610f2'
        ];

        return $colors[$status] ?? '#007bff';
    }
}