// app/Http/Controllers/GuestController.php
<?php

namespace App\Http\Controllers;

use App\Models\Guest;
use Illuminate\Http\Request;

class GuestController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('role:super_admin,property_manager,receptionist');
    }

    public function index()
    {
        $guests = Guest::with('user')->get();
        return view('guests.index', compact('guests'));
    }

    public function create()
    {
        return view('guests.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'nullable|exists:users,id|unique:guests',
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'nullable|string|max:20',
            'date_of_birth' => 'nullable|date',
            'id_type' => 'nullable|in:passport,nid,driving_license,other',
            'id_number' => 'nullable|string|max:50',
            'id_image_path' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'nationality' => 'nullable|string|max:50',
            'address' => 'nullable|string',
            'vip_status' => 'boolean',
        ]);

        if ($request->hasFile('id_image_path')) {
            $validated['id_image_path'] = $request->file('id_image_path')->store('guest_ids', 'public');
        }

        Guest::create($validated);

        return redirect()->route('guests.index')
            ->with('success', 'Guest created successfully.');
    }

    public function show(Guest $guest)
    {
        $guest->load('user', 'bookings', 'preferences', 'loyaltyMember');
        return view('guests.show', compact('guest'));
    }

    public function edit(Guest $guest)
    {
        return view('guests.edit', compact('guest'));
    }

    public function update(Request $request, Guest $guest)
    {
        $validated = $request->validate([
            'user_id' => 'nullable|exists:users,id|unique:guests,user_id,' . $guest->id,
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:guests,email,' . $guest->id,
            'phone' => 'nullable|string|max:20',
            'date_of_birth' => 'nullable|date',
            'id_type' => 'nullable|in:passport,nid,driving_license,other',
            'id_number' => 'nullable|string|max:50',
            'id_image_path' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'nationality' => 'nullable|string|max:50',
            'address' => 'nullable|string',
            'vip_status' => 'boolean',
        ]);

        if ($request->hasFile('id_image_path')) {
            // Delete old image if exists
            if ($guest->id_image_path) {
                \Storage::disk('public')->delete($guest->id_image_path);
            }
            $validated['id_image_path'] = $request->file('id_image_path')->store('guest_ids', 'public');
        }

        $guest->update($validated);

        return redirect()->route('guests.index')
            ->with('success', 'Guest updated successfully.');
    }

    public function destroy(Guest $guest)
    {
        $guest->delete();
        return redirect()->route('guests.index')
            ->with('success', 'Guest deleted successfully.');
    }

    public function search(Request $request)
    {
        $query = $request->get('q');
        $guests = Guest::where('first_name', 'like', "%{$query}%")
            ->orWhere('last_name', 'like', "%{$query}%")
            ->orWhere('email', 'like', "%{$query}%")
            ->orWhere('phone', 'like', "%{$query}%")
            ->with('user')
            ->get();

        return response()->json($guests);
    }
}