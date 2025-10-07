// app/Http/Controllers/RoomController.php
<?php

namespace App\Http\Controllers;

use App\Models\Room;
use App\Models\Property;
use App\Models\RoomType;
use App\Models\Floor;
use Illuminate\Http\Request;

class RoomController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('role:super_admin,property_manager,receptionist');
    }

    public function index()
    {
        $rooms = Room::with('property', 'roomType', 'floor')->get();
        return view('rooms.index', compact('rooms'));
    }

    public function create()
{
    $properties = Property::all();
    $roomTypes = RoomType::all();
    $floors = Floor::all();
    
    return view('backend.rooms.create', compact('properties', 'roomTypes', 'floors'));
}

public function store(Request $request)
{
    $request->validate([
        'property_id' => 'required|exists:properties,id',
        'room_type_id' => 'required|exists:room_types,id',
        'floor_id' => 'required|exists:floors,id',
        'room_number' => 'required|string|unique:rooms,room_number',
        'status' => 'required|in:available,occupied,maintenance,cleaning,out_of_service,blocked,renovation',
        'is_smoking' => 'boolean',
    ]);

    Room::create($request->all());

    return redirect()->route('rooms.index')
        ->with('success', 'Room created successfully.');
}

    public function show(Room $room)
    {
        $room->load('property', 'roomType', 'floor', 'currentBooking');
        return view('rooms.show', compact('room'));
    }

    public function edit(Room $room)
{
    $properties = Property::all();
    $roomTypes = RoomType::all();
    $floors = Floor::all();
    
    return view('backend.rooms.edit', compact('room', 'properties', 'roomTypes', 'floors'));
}

    public function update(Request $request, Room $room)
    {
        $validated = $request->validate([
            'property_id' => 'required|exists:properties,id',
            'room_type_id' => 'required|exists:room_types,id',
            'floor_id' => 'required|exists:floors,id',
            'room_number' => 'required|string|max:20',
            'status' => 'required|in:available,occupied,maintenance,cleaning,out_of_service,blocked,renovation',
            'is_smoking' => 'boolean',
        ]);

        $room->update($validated);

        return redirect()->route('rooms.index')
            ->with('success', 'Room updated successfully.');
    }

    public function destroy(Room $room)
    {
        $room->delete();
        return redirect()->route('rooms.index')
            ->with('success', 'Room deleted successfully.');
    }

    public function updateStatus(Request $request, Room $room)
    {
        $validated = $request->validate([
            'status' => 'required|in:available,occupied,maintenance,cleaning,out_of_service,blocked,renovation',
            'notes' => 'nullable|string',
        ]);

        $room->status = $validated['status'];
        $room->save();

        // Log status change
        \App\Models\RoomStatusLog::create([
            'room_id' => $room->id,
            'status' => $validated['status'],
            'changed_by' => auth()->id(),
            'notes' => $validated['notes'] ?? null,
        ]);

        return redirect()->back()
            ->with('success', 'Room status updated successfully.');
    }
}