<?php

namespace App\Http\Controllers;

use App\Models\CheckIn;
use App\Models\Booking;
use Illuminate\Http\Request;

class CheckInController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('role:super_admin,property_manager,receptionist');
    }

    public function index()
    {
        $checkIns = CheckIn::with('booking', 'booking.guest', 'booking.room', 'checkedBy')->get();
        return view('backend.check-ins.index', compact('checkIns'));
    }

    public function create()
    {
        $bookings = Booking::where('status', 'confirmed')->get();
        return view('backend.check-ins.create', compact('bookings'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'booking_id' => 'required|exists:bookings,id',
            'id_document_path' => 'nullable|string',
            'notes' => 'nullable|string',
            'actual_check_in' => 'required|date',
        ]);

        $validated['checked_by'] = auth()->id();
        
        $checkIn = CheckIn::create($validated);
        
        // Update booking status
        $booking = Booking::find($validated['booking_id']);
        $booking->status = 'checked_in';
        $booking->save();
        
        // Update room status
        if ($booking->room_id) {
            $room = $booking->room;
            $room->status = 'occupied';
            $room->save();
        }

        return redirect()->route('check-ins.show', $checkIn->id)
            ->with('success', 'Guest checked in successfully.');
    }

    public function show(CheckIn $checkIn)
    {
        $checkIn->load('booking', 'booking.guest', 'booking.room', 'checkedBy');
        return view('backend.check-ins.show', compact('checkIn'));
    }

    public function edit(CheckIn $checkIn)
    {
        return view('backend.check-ins.edit', compact('checkIn'));
    }

    public function update(Request $request, CheckIn $checkIn)
    {
        $validated = $request->validate([
            'id_document_path' => 'nullable|string',
            'notes' => 'nullable|string',
            'actual_check_in' => 'required|date',
        ]);

        $checkIn->update($validated);

        return redirect()->route('check-ins.show', $checkIn->id)
            ->with('success', 'Check-in updated successfully.');
    }

    public function destroy(CheckIn $checkIn)
    {
        // Update booking status back to confirmed
        $booking = $checkIn->booking;
        $booking->status = 'confirmed';
        $booking->save();
        
        // Update room status back to available
        if ($booking->room_id) {
            $room = $booking->room;
            $room->status = 'available';
            $room->save();
        }
        
        $checkIn->delete();

        return redirect()->route('check-ins.index')
            ->with('success', 'Check-in deleted successfully.');
    }
}