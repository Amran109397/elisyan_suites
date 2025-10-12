<?php

namespace App\Http\Controllers;

use App\Models\HousekeepingStaff;
use App\Models\Property;
use Illuminate\Http\Request;

class HousekeepingStaffController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('role:super_admin,property_manager,housekeeping');
    }

    public function index()
    {
        // Temporary empty properties array
        $properties = collect([]);
        
        $housekeepingStaffs = HousekeepingStaff::all();
        return view('backend.housekeeping-staffs.index', compact('housekeepingStaffs', 'properties'));
    }

    public function create()
    {
        // Temporary empty properties array
        $properties = collect([]);
        
        return view('backend.housekeeping-staffs.create', compact('properties'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'email' => 'nullable|email|max:255',
            'position' => 'required|string|max:255',
            'shift' => 'required|string|max:255',
            'is_active' => 'boolean',
        ]);

        HousekeepingStaff::create($validated);

        return redirect()->route('housekeeping-staffs.index')
            ->with('success', 'Housekeeping staff created successfully.');
    }

    public function show(HousekeepingStaff $housekeepingStaff)
    {
        return view('backend.housekeeping-staffs.show', compact('housekeepingStaff'));
    }

    public function edit(HousekeepingStaff $housekeepingStaff)
    {
        // Temporary empty properties array
        $properties = collect([]);
        
        return view('backend.housekeeping-staffs.edit', compact('housekeepingStaff', 'properties'));
    }

    public function update(Request $request, HousekeepingStaff $housekeepingStaff)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'email' => 'nullable|email|max:255',
            'position' => 'required|string|max:255',
            'shift' => 'required|string|max:255',
            'is_active' => 'boolean',
        ]);

        $housekeepingStaff->update($validated);

        return redirect()->route('housekeeping-staffs.index')
            ->with('success', 'Housekeeping staff updated successfully.');
    }

    public function destroy(HousekeepingStaff $housekeepingStaff)
    {
        $housekeepingStaff->delete();

        return redirect()->route('housekeeping-staffs.index')
            ->with('success', 'Housekeeping staff deleted successfully.');
    }
}