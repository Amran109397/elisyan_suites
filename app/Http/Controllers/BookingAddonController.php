<?php

namespace App\Http\Controllers;

use App\Models\BookingAddon;
use App\Models\Booking;
use App\Models\Addon;
use Illuminate\Http\Request;

class BookingAddonController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('role:super_admin,property_manager,receptionist');
    }

    public function index()
    {
        $bookingAddons = BookingAddon::with('booking', 'addon')->get();
        return view('backend.booking-addons.index', compact('bookingAddons'));
    }

    public function create()
    {
        $bookings = Booking::all();
        $addons = Addon::all();
        return view('backend.booking-addons.create', compact('bookings', 'addons'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'booking_id' => 'required|exists:bookings,id',
            'addon_id' => 'required|exists:addons,id',
            'quantity' => 'required|integer|min:1',
            'price' => 'required|numeric|min:0',
            'notes' => 'nullable|string',
        ]);

        BookingAddon::create($validated);

        return redirect()->route('booking-addons.index')
            ->with('success', 'Booking addon created successfully.');
    }

    public function show(BookingAddon $bookingAddon)
    {
        return view('backend.booking-addons.show', compact('bookingAddon'));
    }

    public function edit(BookingAddon $bookingAddon)
    {
        $bookings = Booking::all();
        $addons = Addon::all();
        return view('backend.booking-addons.edit', compact('bookingAddon', 'bookings', 'addons'));
    }

    public function update(Request $request, BookingAddon $bookingAddon)
    {
        $validated = $request->validate([
            'booking_id' => 'required|exists:bookings,id',
            'addon_id' => 'required|exists:addons,id',
            'quantity' => 'required|integer|min:1',
            'price' => 'required|numeric|min:0',
            'notes' => 'nullable|string',
        ]);

        $bookingAddon->update($validated);

        return redirect()->route('booking-addons.index')
            ->with('success', 'Booking addon updated successfully.');
    }

    public function destroy(BookingAddon $bookingAddon)
    {
        $bookingAddon->delete();

        return redirect()->route('booking-addons.index')
            ->with('success', 'Booking addon deleted successfully.');
    }
}