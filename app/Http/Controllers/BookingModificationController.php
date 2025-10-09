<?php

namespace App\Http\Controllers;

use App\Models\BookingModification;
use App\Models\Booking;
use Illuminate\Http\Request;

class BookingModificationController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('role:super_admin,property_manager,receptionist');
    }

    public function index()
    {
        $bookingModifications = BookingModification::with('booking', 'modifiedBy')->latest()->get();
        return view('backend.booking-modifications.index', compact('bookingModifications'));
    }

    public function create()
    {
        $bookings = Booking::all();
        return view('backend.booking-modifications.create', compact('bookings'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'booking_id' => 'required|exists:bookings,id',
            'modification_type' => 'required|string|max:255',
            'old_value' => 'required|string',
            'new_value' => 'required|string',
            'notes' => 'nullable|string',
        ]);

        $validated['modified_by'] = auth()->id();
        
        BookingModification::create($validated);

        return redirect()->route('booking-modifications.index')
            ->with('success', 'Booking modification created successfully.');
    }

    public function show(BookingModification $bookingModification)
    {
        return view('backend.booking-modifications.show', compact('bookingModification'));
    }

    public function edit(BookingModification $bookingModification)
    {
        $bookings = Booking::all();
        return view('backend.booking-modifications.edit', compact('bookingModification', 'bookings'));
    }

    public function update(Request $request, BookingModification $bookingModification)
    {
        $validated = $request->validate([
            'booking_id' => 'required|exists:bookings,id',
            'modification_type' => 'required|string|max:255',
            'old_value' => 'required|string',
            'new_value' => 'required|string',
            'notes' => 'nullable|string',
        ]);

        $bookingModification->update($validated);

        return redirect()->route('booking-modifications.index')
            ->with('success', 'Booking modification updated successfully.');
    }

    public function destroy(BookingModification $bookingModification)
    {
        $bookingModification->delete();

        return redirect()->route('booking-modifications.index')
            ->with('success', 'Booking modification deleted successfully.');
    }
}