<?php

namespace App\Http\Controllers;

use App\Models\Floor;
use App\Models\Property;
use Illuminate\Http\Request;

class FloorController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('role:super_admin,property_manager,receptionist');
    }

    public function index()
    {
        $floors = Floor::with('property')->get();
        return view('backend.floors.index', compact('floors'));
    }

    public function create()
    {
        $properties = Property::where('is_active', true)->get();
        return view('backend.floors.create', compact('properties'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'property_id' => 'required|exists:properties,id',
            'floor_number' => 'required|integer|min:1',
            'name' => 'required|string|max:255',
        ]);

        Floor::create($validated);

        return redirect()->route('floors.index')
            ->with('success', 'Floor created successfully.');
    }

    public function show(Floor $floor)
    {
        $floor->load('property', 'rooms');
        return view('backend.floors.show', compact('floor'));
    }

    public function edit(Floor $floor)
    {
        $properties = Property::where('is_active', true)->get();
        return view('backend.floors.edit', compact('floor', 'properties'));
    }

    public function update(Request $request, Floor $floor)
    {
        $validated = $request->validate([
            'property_id' => 'required|exists:properties,id',
            'floor_number' => 'required|integer|min:1',
            'name' => 'required|string|max:255',
        ]);

        $floor->update($validated);

        return redirect()->route('floors.show', $floor->id)
            ->with('success', 'Floor updated successfully.');
    }

    public function destroy(Floor $floor)
    {
        // Check if floor has rooms
        if ($floor->rooms()->count() > 0) {
            return redirect()->route('floors.index')
                ->with('error', 'Cannot delete floor with rooms. Please delete or move rooms first.');
        }
        
        $floor->delete();

        return redirect()->route('floors.index')
            ->with('success', 'Floor deleted successfully.');
    }
}