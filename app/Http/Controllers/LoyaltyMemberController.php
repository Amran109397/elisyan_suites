<?php

namespace App\Http\Controllers;

use App\Models\LoyaltyMember;
use App\Models\Guest;
use App\Models\LoyaltyProgram;
use Illuminate\Http\Request;

class LoyaltyMemberController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('role:super_admin,property_manager');
    }

    public function index()
    {
        $loyaltyMembers = LoyaltyMember::with('guest', 'loyaltyProgram')->get();
        return view('backend.loyalty-members.index', compact('loyaltyMembers'));
    }

    public function create()
    {
        $guests = Guest::all();
        $loyaltyPrograms = LoyaltyProgram::all();
        return view('backend.loyalty-members.create', compact('guests', 'loyaltyPrograms'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'guest_id' => 'required|exists:guests,id',
            'loyalty_program_id' => 'required|exists:loyalty_programs,id',
            'membership_number' => 'required|string|max:255|unique:loyalty_members',
            'join_date' => 'required|date',
            'status' => 'required|string|max:255',
        ]);

        LoyaltyMember::create($validated);

        return redirect()->route('loyalty-members.index')
            ->with('success', 'Loyalty member created successfully.');
    }

    public function show(LoyaltyMember $loyaltyMember)
    {
        return view('backend.loyalty-members.show', compact('loyaltyMember'));
    }

    public function edit(LoyaltyMember $loyaltyMember)
    {
        $guests = Guest::all();
        $loyaltyPrograms = LoyaltyProgram::all();
        return view('backend.loyalty-members.edit', compact('loyaltyMember', 'guests', 'loyaltyPrograms'));
    }

    public function update(Request $request, LoyaltyMember $loyaltyMember)
    {
        $validated = $request->validate([
            'guest_id' => 'required|exists:guests,id',
            'loyalty_program_id' => 'required|exists:loyalty_programs,id',
            'membership_number' => 'required|string|max:255|unique:loyalty_members,membership_number,' . $loyaltyMember->id,
            'join_date' => 'required|date',
            'status' => 'required|string|max:255',
        ]);

        $loyaltyMember->update($validated);

        return redirect()->route('loyalty-members.index')
            ->with('success', 'Loyalty member updated successfully.');
    }

    public function destroy(LoyaltyMember $loyaltyMember)
    {
        $loyaltyMember->delete();

        return redirect()->route('loyalty-members.index')
            ->with('success', 'Loyalty member deleted successfully.');
    }
}