<?php

namespace App\Http\Controllers;

use App\Models\Therapist;
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
        $therapists = Therapist::all();
        return view('backend.therapists.index', compact('therapists'));
    }

    public function create()
    {
        return view('backend.therapists.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'specialization' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'email' => 'nullable|email|max:255',
            'is_active' => 'boolean',
        ]);

        Therapist::create($validated);

        return redirect()->route('therapists.index')
            ->with('success', 'Therapist created successfully.');
    }

    public function show(Therapist $therapist)
    {
        return view('backend.therapists.show', compact('therapist'));
    }

    public function edit(Therapist $therapist)
    {
        return view('backend.therapists.edit', compact('therapist'));
    }

    public function update(Request $request, Therapist $therapist)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'specialization' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'email' => 'nullable|email|max:255',
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