<?php

namespace App\Http\Controllers;

use App\Models\RoomAmenity;
use App\Models\Room;
use App\Models\Amenity;
use Illuminate\Http\Request;

class RoomAmenityController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('role:super_admin,property_manager,receptionist');
    }

    public function index()
    {
        $roomAmenities = RoomAmenity::with('room', 'amenity')->get();
        return view('backend.room-amenities.index', compact('roomAmenities'));
    }

    public function create()
    {
        $rooms = Room::all();
        $amenities = Amenity::all();
        return view('backend.room-amenities.create', compact('rooms', 'amenities'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'room_id' => 'required|exists:rooms,id',
            'amenity_id' => 'required|exists:amenities,id',
        ]);

        RoomAmenity::create($validated);

        return redirect()->route('room-amenities.index')
            ->with('success', 'Room amenity assignment created successfully.');
    }

    public function show(RoomAmenity $roomAmenity)
    {
        return view('backend.room-amenities.show', compact('roomAmenity'));
    }

    public function edit(RoomAmenity $roomAmenity)
    {
        $rooms = Room::all();
        $amenities = Amenity::all();
        return view('backend.room-amenities.edit', compact('roomAmenity', 'rooms', 'amenities'));
    }

    public function update(Request $request, RoomAmenity $roomAmenity)
    {
        $validated = $request->validate([
            'room_id' => 'required|exists:rooms,id',
            'amenity_id' => 'required|exists:amenities,id',
        ]);

        $roomAmenity->update($validated);

        return redirect()->route('room-amenities.index')
            ->with('success', 'Room amenity assignment updated successfully.');
    }

    public function destroy(RoomAmenity $roomAmenity)
    {
        $roomAmenity->delete();

        return redirect()->route('room-amenities.index')
            ->with('success', 'Room amenity assignment deleted successfully.');
    }
}