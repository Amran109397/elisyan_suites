// app/Http/Controllers/RoomTypeController.php
<?php

namespace App\Http\Controllers;

use App\Models\RoomType;
use App\Models\Property;
use Illuminate\Http\Request;

class RoomTypeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('role:super_admin,property_manager');
    }

    public function index()
    {
        $roomTypes = RoomType::with('property')->get();
        return view('room-types.index', compact('roomTypes'));
    }

    public function create()
    {
        $properties = Property::where('is_active', true)->get();
        return view('room-types.create', compact('properties'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'property_id' => 'required|exists:properties,id',
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'base_price' => 'required|numeric|min:0',
            'max_occupancy' => 'required|integer|min:1',
            'size_sqm' => 'nullable|numeric|min:0',
            'bed_type' => 'nullable|string|max:50',
            'is_active' => 'boolean',
        ]);

        RoomType::create($validated);

        return redirect()->route('room-types.index')
            ->with('success', 'Room type created successfully.');
    }

    public function show(RoomType $roomType)
    {
        $roomType->load('property', 'rooms', 'amenities', 'images');
        return view('room-types.show', compact('roomType'));
    }

    public function edit(RoomType $roomType)
    {
        $properties = Property::where('is_active', true)->get();
        return view('room-types.edit', compact('roomType', 'properties'));
    }

    public function update(Request $request, RoomType $roomType)
    {
        $validated = $request->validate([
            'property_id' => 'required|exists:properties,id',
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'base_price' => 'required|numeric|min:0',
            'max_occupancy' => 'required|integer|min:1',
            'size_sqm' => 'nullable|numeric|min:0',
            'bed_type' => 'nullable|string|max:50',
            'is_active' => 'boolean',
        ]);

        $roomType->update($validated);

        return redirect()->route('room-types.index')
            ->with('success', 'Room type updated successfully.');
    }

    public function destroy(RoomType $roomType)
    {
        $roomType->delete();
        return redirect()->route('room-types.index')
            ->with('success', 'Room type deleted successfully.');
    }
}