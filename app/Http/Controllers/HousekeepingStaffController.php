<?php

namespace App\Http\Controllers;

use App\Models\HousekeepingStaff;
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
        $housekeepingStaffs = HousekeepingStaff::all();
        return view('backend.housekeeping-staffs.index', compact('housekeepingStaffs'));
    }

    public function create()
    {
        return view('backend.housekeeping-staffs.create');
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
        return view('backend.housekeeping-staffs.edit', compact('housekeepingStaff'));
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