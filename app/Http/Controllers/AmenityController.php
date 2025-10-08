<?php

namespace App\Http\Controllers;

use App\Models\Amenity;
use Illuminate\Http\Request;

class AmenityController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('role:super_admin,property_manager,receptionist');
    }

    public function index()
    {
        $amenities = Amenity::all();
        return view('backend.amenities.index', compact('amenities'));
    }

    public function create()
    {
        return view('backend.amenities.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'icon' => 'required|string|max:255',
            'category' => 'required|in:room,bathroom,entertainment,other',
        ]);

        Amenity::create($validated);

        return redirect()->route('amenities.index')
            ->with('success', 'Amenity created successfully.');
    }

    public function show(Amenity $amenity)
    {
        $amenity->load('roomTypes');
        return view('backend.amenities.show', compact('amenity'));
    }

    public function edit(Amenity $amenity)
    {
        return view('backend.amenities.edit', compact('amenity'));
    }

    public function update(Request $request, Amenity $amenity)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'icon' => 'required|string|max:255',
            'category' => 'required|in:room,bathroom,entertainment,other',
        ]);

        $amenity->update($validated);

        return redirect()->route('amenities.show', $amenity->id)
            ->with('success', 'Amenity updated successfully.');
    }

    public function destroy(Amenity $amenity)
    {
        $amenity->delete();

        return redirect()->route('amenities.index')
            ->with('success', 'Amenity deleted successfully.');
    }
}