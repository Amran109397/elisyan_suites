<?php

namespace App\Http\Controllers;

use App\Models\Season;
use App\Models\Property;
use Illuminate\Http\Request;

class SeasonController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('role:super_admin,property_manager');
    }

    public function index()
    {
        $seasons = Season::with('property')->orderBy('start_date')->get();
        return view('backend.seasons.index', compact('seasons'));
    }

    public function create()
    {
        $properties = Property::where('is_active', true)->get();
        return view('backend.seasons.create', compact('properties'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'property_id' => 'required|exists:properties,id',
            'name' => 'required|string|max:255',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'price_adjustment' => 'required|numeric',
        ]);

        Season::create($validated);

        return redirect()->route('seasons.index')
            ->with('success', 'Season created successfully.');
    }

    public function show(Season $season)
    {
        $season->load('property');
        return view('backend.seasons.show', compact('season'));
    }

    public function edit(Season $season)
    {
        $properties = Property::where('is_active', true)->get();
        return view('backend.seasons.edit', compact('season', 'properties'));
    }

    public function update(Request $request, Season $season)
    {
        $validated = $request->validate([
            'property_id' => 'required|exists:properties,id',
            'name' => 'required|string|max:255',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'price_adjustment' => 'required|numeric',
        ]);

        $season->update($validated);

        return redirect()->route('seasons.show', $season->id)
            ->with('success', 'Season updated successfully.');
    }

    public function destroy(Season $season)
    {
        $season->delete();

        return redirect()->route('seasons.index')
            ->with('success', 'Season deleted successfully.');
    }
}