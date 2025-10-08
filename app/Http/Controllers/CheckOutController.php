<?php

namespace App\Http\Controllers;

use App\Models\CheckOut;
use App\Models\Booking;
use Illuminate\Http\Request;

class CheckOutController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('role:super_admin,property_manager,receptionist');
    }

    public function index()
    {
        $checkOuts = CheckOut::with('booking', 'booking.guest', 'booking.room', 'checkedBy')->get();
        return view('backend.check-outs.index', compact('checkOuts'));
    }

    public function create()
    {
        $bookings = Booking::where('status', 'checked_in')->get();
        return view('backend.check-outs.create', compact('bookings'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'booking_id' => 'required|exists:bookings,id',
            'final_bill' => 'required|numeric|min:0',
            'payment_status' => 'required|in:pending,paid,partial',
            'notes' => 'nullable|string',
            'actual_check_out' => 'required|date',
        ]);

        $validated['checked_by'] = auth()->id();
        
        $checkOut = CheckOut::create($validated);
        
        // Update booking status
        $booking = Booking::find($validated['booking_id']);
        $booking->status = 'checked_out';
        $booking->save();
        
        // Update room status
        if ($booking->room_id) {
            $room = $booking->room;
            $room->status = 'available';
            $room->save();
        }

        return redirect()->route('check-outs.show', $checkOut->id)
            ->with('success', 'Guest checked out successfully.');
    }

    public function show(CheckOut $checkOut)
    {
        $checkOut->load('booking', 'booking.guest', 'booking.room', 'booking.payments', 'checkedBy');
        return view('backend.check-outs.show', compact('checkOut'));
    }

    public function edit(CheckOut $checkOut)
    {
        return view('backend.check-outs.edit', compact('checkOut'));
    }

    public function update(Request $request, CheckOut $checkOut)
    {
        $validated = $request->validate([
            'final_bill' => 'required|numeric|min:0',
            'payment_status' => 'required|in:pending,paid,partial',
            'notes' => 'nullable|string',
            'actual_check_out' => 'required|date',
        ]);

        $checkOut->update($validated);

        return redirect()->route('check-outs.show', $checkOut->id)
            ->with('success', 'Check-out updated successfully.');
    }

    public function destroy(CheckOut $checkOut)
    {
        // Update booking status back to checked_in
        $booking = $checkOut->booking;
        $booking->status = 'checked_in';
        $booking->save();
        
        // Update room status back to occupied
        if ($booking->room_id) {
            $room = $booking->room;
            $room->status = 'occupied';
            $room->save();
        }
        
        $checkOut->delete();

        return redirect()->route('check-outs.index')
            ->with('success', 'Check-out deleted successfully.');
    }
}