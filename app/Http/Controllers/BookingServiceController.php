<?php

namespace App\Http\Controllers;

use App\Models\BookingService;
use App\Models\Booking;
use App\Models\Service;
use Illuminate\Http\Request;

class BookingServiceController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('role:super_admin,property_manager,receptionist');
    }

    public function index()
    {
        $bookingServices = BookingService::with('booking', 'service')->get();
        return view('backend.booking-services.index', compact('bookingServices'));
    }

    public function create()
    {
        $bookings = Booking::all();
        $services = Service::all();
        return view('backend.booking-services.create', compact('bookings', 'services'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'booking_id' => 'required|exists:bookings,id',
            'service_id' => 'required|exists:services,id',
            'quantity' => 'required|integer|min:1',
            'price' => 'required|numeric|min:0',
            'notes' => 'nullable|string',
        ]);

        BookingService::create($validated);

        return redirect()->route('booking-services.index')
            ->with('success', 'Booking service created successfully.');
    }

    public function show(BookingService $bookingService)
    {
        return view('backend.booking-services.show', compact('bookingService'));
    }

    public function edit(BookingService $bookingService)
    {
        $bookings = Booking::all();
        $services = Service::all();
        return view('backend.booking-services.edit', compact('bookingService', 'bookings', 'services'));
    }

    public function update(Request $request, BookingService $bookingService)
    {
        $validated = $request->validate([
            'booking_id' => 'required|exists:bookings,id',
            'service_id' => 'required|exists:services,id',
            'quantity' => 'required|integer|min:1',
            'price' => 'required|numeric|min:0',
            'notes' => 'nullable|string',
        ]);

        $bookingService->update($validated);

        return redirect()->route('booking-services.index')
            ->with('success', 'Booking service updated successfully.');
    }

    public function destroy(BookingService $bookingService)
    {
        $bookingService->delete();

        return redirect()->route('booking-services.index')
            ->with('success', 'Booking service deleted successfully.');
    }
}