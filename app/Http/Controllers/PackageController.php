<?php

namespace App\Http\Controllers;

use App\Models\Package;
use App\Models\Property;
use Illuminate\Http\Request;

class PackageController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('role:super_admin,property_manager');
    }

    public function index()
    {
        $packages = Package::with('property')->get();
        return view('backend.packages.index', compact('packages'));
    }

    public function create()
    {
        $properties = Property::where('is_active', true)->get();
        return view('backend.packages.create', compact('properties'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'property_id' => 'required|exists:properties,id',
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'is_active' => 'nullable|boolean',
        ]);

        $validated['is_active'] = $request->has('is_active');
        
        Package::create($validated);

        return redirect()->route('packages.index')
            ->with('success', 'Package created successfully.');
    }

    public function show(Package $package)
    {
        $package->load('property');
        return view('backend.packages.show', compact('package'));
    }

    public function edit(Package $package)
    {
        $properties = Property::where('is_active', true)->get();
        return view('backend.packages.edit', compact('package', 'properties'));
    }

    public function update(Request $request, Package $package)
    {
        $validated = $request->validate([
            'property_id' => 'required|exists:properties,id',
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'is_active' => 'nullable|boolean',
        ]);

        $validated['is_active'] = $request->has('is_active');
        
        $package->update($validated);

        return redirect()->route('packages.show', $package->id)
            ->with('success', 'Package updated successfully.');
    }

    public function destroy(Package $package)
    {
        $package->delete();

        return redirect()->route('packages.index')
            ->with('success', 'Package deleted successfully.');
    }

    public function toggleActive(Package $package)
    {
        $package->is_active = !$package->is_active;
        $package->save();

        return redirect()->route('packages.index')
            ->with('success', 'Package status updated successfully.');
    }
}