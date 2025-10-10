<?php

namespace App\Http\Controllers;

use App\Models\Therapist;
use App\Models\Property;
use Illuminate\Http\Request;

class TherapistController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('role:super_admin,property_manager');
    }

    public function index()
    {
        $therapists = Therapist::with('property')->paginate(10);
        $properties = Property::all();
        return view('backend.therapists.index', compact('therapists', 'properties'));
    }

    public function create()
    {
        $properties = Property::all();
        return view('backend.therapists.create', compact('properties'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'property_id' => 'required|exists:properties,id',
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:therapists,email',
            'phone' => 'required|string|max:20',
            'specialization' => 'required|string|max:255',
            'experience' => 'required|integer|min:0',
            'is_active' => 'boolean',
        ]);

        Therapist::create($validated);

        return redirect()->route('therapists.index')
            ->with('success', 'Therapist created successfully.');
    }

    public function show(Therapist $therapist)
    {
        $therapist->load('property');
        return view('backend.therapists.show', compact('therapist'));
    }

    public function edit(Therapist $therapist)
    {
        $properties = Property::all();
        return view('backend.therapists.edit', compact('therapist', 'properties'));
    }

    public function update(Request $request, Therapist $therapist)
    {
        $validated = $request->validate([
            'property_id' => 'required|exists:properties,id',
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:therapists,email,' . $therapist->id,
            'phone' => 'required|string|max:20',
            'specialization' => 'required|string|max:255',
            'experience' => 'required|integer|min:0',
            'is_active' => 'boolean',
        ]);

        $therapist->update($validated);

        return redirect()->route('therapists.index')
            ->with('success', 'Therapist updated successfully.');
    }

    public function destroy(Therapist $therapist)
    {
        $therapist->delete();

        return redirect()->route('therapists.index')
            ->with('success', 'Therapist deleted successfully.');
    }
}