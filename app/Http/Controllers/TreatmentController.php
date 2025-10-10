<?php

namespace App\Http\Controllers;

use App\Models\Treatment;
use App\Models\Property;
use Illuminate\Http\Request;

class TreatmentController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('role:super_admin,property_manager');
    }

    public function index()
    {
        $treatments = Treatment::with('property')->paginate(10);
        $properties = Property::all();
        return view('backend.treatments.index', compact('treatments', 'properties'));
    }

    public function create()
    {
        $properties = Property::all();
        return view('backend.treatments.create', compact('properties'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'property_id' => 'required|exists:properties,id',
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'duration' => 'required|integer|min:1',
            'price' => 'required|numeric|min:0',
            'category' => 'required|string|max:255',
            'is_active' => 'boolean',
        ]);

        Treatment::create($validated);

        return redirect()->route('treatments.index')
            ->with('success', 'Treatment created successfully.');
    }

    public function show(Treatment $treatment)
    {
        $treatment->load('property');
        return view('backend.treatments.show', compact('treatment'));
    }

    public function edit(Treatment $treatment)
    {
        $properties = Property::all();
        return view('backend.treatments.edit', compact('treatment', 'properties'));
    }

    public function update(Request $request, Treatment $treatment)
    {
        $validated = $request->validate([
            'property_id' => 'required|exists:properties,id',
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'duration' => 'required|integer|min:1',
            'price' => 'required|numeric|min:0',
            'category' => 'required|string|max:255',
            'is_active' => 'boolean',
        ]);

        $treatment->update($validated);

        return redirect()->route('treatments.index')
            ->with('success', 'Treatment updated successfully.');
    }

    public function destroy(Treatment $treatment)
    {
        $treatment->delete();

        return redirect()->route('treatments.index')
            ->with('success', 'Treatment deleted successfully.');
    }
}