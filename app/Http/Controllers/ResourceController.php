<?php

namespace App\Http\Controllers;

use App\Models\Resource;
use App\Models\Property; 
use Illuminate\Http\Request;

class ResourceController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('role:super_admin,property_manager');
    }

    public function index()
    {
        $resources = Resource::with('property')->paginate(10);
        $properties = Property::all(); 
        return view('backend.resources.index', compact('resources', 'properties'));
    }

    public function create()
    {
        $properties = Property::all();
        return view('backend.resources.create', compact('properties'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'property_id' => 'required|exists:properties,id',
            'name' => 'required|string|max:255',
            'type' => 'required|in:room,equipment,facility,other',
            'description' => 'nullable|string',
            'quantity' => 'required|integer|min:1',
            'price_per_hour' => 'nullable|numeric|min:0',
            'is_available' => 'boolean',
        ]);

        Resource::create($validated);

        return redirect()->route('resources.index')
            ->with('success', 'Resource created successfully.');
    }

    public function show(Resource $resource)
    {
        $resource->load('property');
        return view('backend.resources.show', compact('resource'));
    }

    public function edit(Resource $resource)
    {
        $properties = Property::all();
        return view('backend.resources.edit', compact('resource', 'properties'));
    }

    public function update(Request $request, Resource $resource)
    {
        $validated = $request->validate([
            'property_id' => 'required|exists:properties,id',
            'name' => 'required|string|max:255',
            'type' => 'required|in:room,equipment,facility,other',
            'description' => 'nullable|string',
            'quantity' => 'required|integer|min:1',
            'price_per_hour' => 'nullable|numeric|min:0',
            'is_available' => 'boolean',
        ]);

        $resource->update($validated);

        return redirect()->route('resources.index')
            ->with('success', 'Resource updated successfully.');
    }

    public function destroy(Resource $resource)
    {
        $resource->delete();

        return redirect()->route('resources.index')
            ->with('success', 'Resource deleted successfully.');
    }
}