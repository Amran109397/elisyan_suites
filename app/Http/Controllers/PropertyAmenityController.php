<?php

namespace App\Http\Controllers;

use App\Models\PropertyAmenity;
use App\Models\Property;
use App\Models\Amenity;
use Illuminate\Http\Request;

class PropertyAmenityController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('role:super_admin,property_manager');
    }

    public function index()
    {
        $propertyAmenities = PropertyAmenity::with('property', 'amenity')->get();
        return view('backend.property-amenities.index', compact('propertyAmenities'));
    }

    public function create()
    {
        $properties = Property::all();
        $amenities = Amenity::all();
        return view('backend.property-amenities.create', compact('properties', 'amenities'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'property_id' => 'required|exists:properties,id',
            'amenity_id' => 'required|exists:amenities,id',
        ]);

        PropertyAmenity::create($validated);

        return redirect()->route('property-amenities.index')
            ->with('success', 'Property amenity assignment created successfully.');
    }

    public function show(PropertyAmenity $propertyAmenity)
    {
        return view('backend.property-amenities.show', compact('propertyAmenity'));
    }

    public function edit(PropertyAmenity $propertyAmenity)
    {
        $properties = Property::all();
        $amenities = Amenity::all();
        return view('backend.property-amenities.edit', compact('propertyAmenity', 'properties', 'amenities'));
    }

    public function update(Request $request, PropertyAmenity $propertyAmenity)
    {
        $validated = $request->validate([
            'property_id' => 'required|exists:properties,id',
            'amenity_id' => 'required|exists:amenities,id',
        ]);

        $propertyAmenity->update($validated);

        return redirect()->route('property-amenities.index')
            ->with('success', 'Property amenity assignment updated successfully.');
    }

    public function destroy(PropertyAmenity $propertyAmenity)
    {
        $propertyAmenity->delete();

        return redirect()->route('property-amenities.index')
            ->with('success', 'Property amenity assignment deleted successfully.');
    }
}