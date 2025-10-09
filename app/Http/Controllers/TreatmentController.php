<?php

namespace App\Http\Controllers;

use App\Models\Treatment;
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
        $treatments = Treatment::all();
        return view('backend.treatments.index', compact('treatments'));
    }

    public function create()
    {
        return view('backend.treatments.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'duration' => 'required|integer|min:1',
            'price' => 'required|numeric|min:0',
            'is_active' => 'boolean',
        ]);

        Treatment::create($validated);

        return redirect()->route('treatments.index')
            ->with('success', 'Treatment created successfully.');
    }

    public function show(Treatment $treatment)
    {
        return view('backend.treatments.show', compact('treatment'));
    }

    public function edit(Treatment $treatment)
    {
        return view('backend.treatments.edit', compact('treatment'));
    }

    public function update(Request $request, Treatment $treatment)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'duration' => 'required|integer|min:1',
            'price' => 'required|numeric|min:0',
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