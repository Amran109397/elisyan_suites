<?php

namespace App\Http\Controllers;

use App\Models\LoyaltyProgram;
use Illuminate\Http\Request;

class LoyaltyProgramController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('role:super_admin,property_manager');
    }

    public function index()
    {
        $loyaltyPrograms = LoyaltyProgram::all();
        return view('backend.loyalty-programs.index', compact('loyaltyPrograms'));
    }

    public function create()
    {
        return view('backend.loyalty-programs.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'points_per_currency' => 'required|numeric|min:0',
            'redemption_rate' => 'required|numeric|min:0',
            'is_active' => 'boolean',
        ]);

        LoyaltyProgram::create($validated);

        return redirect()->route('loyalty-programs.index')
            ->with('success', 'Loyalty program created successfully.');
    }

    public function show(LoyaltyProgram $loyaltyProgram)
    {
        return view('backend.loyalty-programs.show', compact('loyaltyProgram'));
    }

    public function edit(LoyaltyProgram $loyaltyProgram)
    {
        return view('backend.loyalty-programs.edit', compact('loyaltyProgram'));
    }

    public function update(Request $request, LoyaltyProgram $loyaltyProgram)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'points_per_currency' => 'required|numeric|min:0',
            'redemption_rate' => 'required|numeric|min:0',
            'is_active' => 'boolean',
        ]);

        $loyaltyProgram->update($validated);

        return redirect()->route('loyalty-programs.index')
            ->with('success', 'Loyalty program updated successfully.');
    }

    public function destroy(LoyaltyProgram $loyaltyProgram)
    {
        $loyaltyProgram->delete();

        return redirect()->route('loyalty-programs.index')
            ->with('success', 'Loyalty program deleted successfully.');
    }
}