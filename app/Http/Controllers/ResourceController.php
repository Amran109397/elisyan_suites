<?php

namespace App\Http\Controllers;

use App\Models\Resource;
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
        $resources = Resource::all();
        return view('backend.resources.index', compact('resources'));
    }

    public function create()
    {
        return view('backend.resources.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'type' => 'required|string|max:255',
            'capacity' => 'required|integer|min:1',
            'is_active' => 'boolean',
        ]);

        Resource::create($validated);

        return redirect()->route('resources.index')
            ->with('success', 'Resource created successfully.');
    }

    public function show(Resource $resource)
    {
        return view('backend.resources.show', compact('resource'));
    }

    public function edit(Resource $resource)
    {
        return view('backend.resources.edit', compact('resource'));
    }

    public function update(Request $request, Resource $resource)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'type' => 'required|string|max:255',
            'capacity' => 'required|integer|min:1',
            'is_active' => 'boolean',
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