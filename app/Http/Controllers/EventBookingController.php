<?php

namespace App\Http\Controllers;

use App\Models\EventBooking;
use App\Models\Event; // Event মডেল import করুন
use Illuminate\Http\Request;

class EventBookingController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('role:super_admin,property_manager,receptionist');
    }

    public function index()
    {
        $eventBookings = EventBooking::with(['event', 'guest'])->paginate(10);
        $events = Event::all(); // Events variable যোগ করুন
        return view('backend.event-bookings.index', compact('eventBookings', 'events'));
    }

    public function create()
    {
        $events = Event::where('status', 'published')->get(); // শুধু published events
        $guests = \App\Models\Guest::all(); // Guests list
        return view('backend.event-bookings.create', compact('events', 'guests'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'event_id' => 'required|exists:events,id',
            'guest_id' => 'required|exists:guests,id',
            'number_of_attendees' => 'required|integer|min:1',
            'total_price' => 'required|numeric|min:0',
            'status' => 'required|in:pending,confirmed,cancelled',
            'special_requests' => 'nullable|string',
        ]);

        EventBooking::create($validated);

        return redirect()->route('event-bookings.index')
            ->with('success', 'Event booking created successfully.');
    }

    public function show(EventBooking $eventBooking)
    {
        $eventBooking->load(['event', 'guest']);
        return view('backend.event-bookings.show', compact('eventBooking'));
    }

    public function edit(EventBooking $eventBooking)
    {
        $events = Event::where('status', 'published')->get();
        $guests = \App\Models\Guest::all();
        return view('backend.event-bookings.edit', compact('eventBooking', 'events', 'guests'));
    }

    public function update(Request $request, EventBooking $eventBooking)
    {
        $validated = $request->validate([
            'event_id' => 'required|exists:events,id',
            'guest_id' => 'required|exists:guests,id',
            'number_of_attendees' => 'required|integer|min:1',
            'total_price' => 'required|numeric|min:0',
            'status' => 'required|in:pending,confirmed,cancelled',
            'special_requests' => 'nullable|string',
        ]);

        $eventBooking->update($validated);

        return redirect()->route('event-bookings.index')
            ->with('success', 'Event booking updated successfully.');
    }

    public function destroy(EventBooking $eventBooking)
    {
        $eventBooking->delete();

        return redirect()->route('event-bookings.index')
            ->with('success', 'Event booking deleted successfully.');
    }
}