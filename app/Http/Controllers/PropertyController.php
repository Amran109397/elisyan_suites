// app/Http/Controllers/PropertyController.php
<?php

namespace App\Http\Controllers;

use App\Models\Property;
use App\Models\Currency;
use Illuminate\Http\Request;

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
        return view('properties.index', compact('properties'));
    }

    public function create()
    {
        $currencies = Currency::where('is_active', true)->get();
        return view('properties.create', compact('currencies'));
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

        Property::create($validated);

        return redirect()->route('properties.index')
            ->with('success', 'Property created successfully.');
    }

    public function show(Property $property)
    {
        $property->load('currency', 'roomTypes', 'floors', 'rooms');
        return view('properties.show', compact('property'));
    }

    public function edit(Property $property)
    {
        $currencies = Currency::where('is_active', true)->get();
        return view('properties.edit', compact('property', 'currencies'));
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
                \Storage::disk('public')->delete($property->logo);
            }
            $validated['logo'] = $request->file('logo')->store('property_logos', 'public');
        }

        $property->update($validated);

        return redirect()->route('properties.index')
            ->with('success', 'Property updated successfully.');
    }

    public function destroy(Property $property)
    {
        $property->delete();
        return redirect()->route('properties.index')
            ->with('success', 'Property deleted successfully.');
    }
}