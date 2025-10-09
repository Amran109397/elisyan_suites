<?php

namespace App\Http\Controllers;

use App\Models\GuestPreference;
use App\Models\Guest;
use Illuminate\Http\Request;

class GuestPreferenceController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('role:super_admin,property_manager,receptionist');
    }

    public function index()
    {
        $guestPreferences = GuestPreference::with('guest')->get();
        return view('backend.guest-preferences.index', compact('guestPreferences'));
    }

    public function create()
    {
        $guests = Guest::all();
        return view('backend.guest-preferences.create', compact('guests'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'guest_id' => 'required|exists:guests,id',
            'preference_type' => 'required|string|max:255',
            'preference_value' => 'required|string|max:255',
            'notes' => 'nullable|string',
        ]);

        GuestPreference::create($validated);

        return redirect()->route('guest-preferences.index')
            ->with('success', 'Guest preference created successfully.');
    }

    public function show(GuestPreference $guestPreference)
    {
        return view('backend.guest-preferences.show', compact('guestPreference'));
    }

    public function edit(GuestPreference $guestPreference)
    {
        $guests = Guest::all();
        return view('backend.guest-preferences.edit', compact('guestPreference', 'guests'));
    }

    public function update(Request $request, GuestPreference $guestPreference)
    {
        $validated = $request->validate([
            'guest_id' => 'required|exists:guests,id',
            'preference_type' => 'required|string|max:255',
            'preference_value' => 'required|string|max:255',
            'notes' => 'nullable|string',
        ]);

        $guestPreference->update($validated);

        return redirect()->route('guest-preferences.index')
            ->with('success', 'Guest preference updated successfully.');
    }

    public function destroy(GuestPreference $guestPreference)
    {
        $guestPreference->delete();

        return redirect()->route('guest-preferences.index')
            ->with('success', 'Guest preference deleted successfully.');
    }
}