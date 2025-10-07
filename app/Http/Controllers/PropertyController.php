<?php

namespace App\Http\Controllers;

use App\Models\Property;
use App\Models\Currency;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PropertyController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('role:super_admin,property_manager');
    }

    public function index()
    {
        $properties = Property::with('currency')->get();
        return view('backend.properties.index', compact('properties')); // ✅ views path corrected
    }

    public function create()
    {
        $currencies = Currency::where('is_active', true)->get();
        return view('backend.properties.create', compact('currencies')); // ✅ views path corrected
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'address' => 'required|string|max:255',
            'city' => 'required|string|max:255',
            'country' => 'required|string|max:255',
            'phone' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:255',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'check_in_time' => 'required|date_format:H:i',
            'check_out_time' => 'required|date_format:H:i',
            'timezone' => 'required|string|max:50',
            'currency_id' => 'required|exists:currencies,id',
            'is_active' => 'boolean',
        ]);

        if ($request->hasFile('logo')) {
            $validated['logo'] = $request->file('logo')->store('property_logos', 'public');
        }

        // ✅ Add created_by field
        $validated['created_by'] = auth()->id();

        Property::create($validated);

        return redirect()->route('properties.index')
            ->with('success', 'Property created successfully.');
    }

    public function show(Property $property)
    {
        $property->load('currency', 'roomTypes', 'floors', 'rooms');
        return view('backend.properties.show', compact('property')); // ✅ views path corrected
    }

    public function edit(Property $property)
    {
        $currencies = Currency::where('is_active', true)->get();
        return view('backend.properties.edit', compact('property', 'currencies')); // ✅ views path corrected
    }

    public function update(Request $request, Property $property)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'address' => 'required|string|max:255',
            'city' => 'required|string|max:255',
            'country' => 'required|string|max:255',
            'phone' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:255',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'check_in_time' => 'required|date_format:H:i',
            'check_out_time' => 'required|date_format:H:i',
            'timezone' => 'required|string|max:50',
            'currency_id' => 'required|exists:currencies,id',
            'is_active' => 'boolean',
        ]);

        if ($request->hasFile('logo')) {
            // Delete old logo if exists
            if ($property->logo) {
                Storage::disk('public')->delete($property->logo);
            }
            $validated['logo'] = $request->file('logo')->store('property_logos', 'public');
        }

        $property->update($validated);

        return redirect()->route('properties.index')
            ->with('success', 'Property updated successfully.');
    }

    public function destroy(Property $property)
    {
        // ✅ Delete logo file if exists
        if ($property->logo) {
            Storage::disk('public')->delete($property->logo);
        }
        
        $property->delete();
        
        return redirect()->route('properties.index')
            ->with('success', 'Property deleted successfully.');
    }
}