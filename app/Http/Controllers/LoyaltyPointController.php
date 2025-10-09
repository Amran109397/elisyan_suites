<?php

namespace App\Http\Controllers;

use App\Models\LoyaltyPoint;
use App\Models\LoyaltyMember;
use App\Models\Booking;
use Illuminate\Http\Request;

class LoyaltyPointController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('role:super_admin,property_manager');
    }

    public function index()
    {
        $loyaltyPoints = LoyaltyPoint::with('loyaltyMember', 'booking')->get();
        return view('backend.loyalty-points.index', compact('loyaltyPoints'));
    }

    public function create()
    {
        $loyaltyMembers = LoyaltyMember::all();
        $bookings = Booking::all();
        return view('backend.loyalty-points.create', compact('loyaltyMembers', 'bookings'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'loyalty_member_id' => 'required|exists:loyalty_members,id',
            'booking_id' => 'nullable|exists:bookings,id',
            'points' => 'required|integer',
            'type' => 'required|string|max:255',
            'description' => 'required|string|max:255',
            'expiry_date' => 'nullable|date',
        ]);

        LoyaltyPoint::create($validated);

        return redirect()->route('loyalty-points.index')
            ->with('success', 'Loyalty point created successfully.');
    }

    public function show(LoyaltyPoint $loyaltyPoint)
    {
        return view('backend.loyalty-points.show', compact('loyaltyPoint'));
    }

    public function edit(LoyaltyPoint $loyaltyPoint)
    {
        $loyaltyMembers = LoyaltyMember::all();
        $bookings = Booking::all();
        return view('backend.loyalty-points.edit', compact('loyaltyPoint', 'loyaltyMembers', 'bookings'));
    }

    public function update(Request $request, LoyaltyPoint $loyaltyPoint)
    {
        $validated = $request->validate([
            'loyalty_member_id' => 'required|exists:loyalty_members,id',
            'booking_id' => 'nullable|exists:bookings,id',
            'points' => 'required|integer',
            'type' => 'required|string|max:255',
            'description' => 'required|string|max:255',
            'expiry_date' => 'nullable|date',
        ]);

        $loyaltyPoint->update($validated);

        return redirect()->route('loyalty-points.index')
            ->with('success', 'Loyalty point updated successfully.');
    }

    public function destroy(LoyaltyPoint $loyaltyPoint)
    {
        $loyaltyPoint->delete();

        return redirect()->route('loyalty-points.index')
            ->with('success', 'Loyalty point deleted successfully.');
    }
}