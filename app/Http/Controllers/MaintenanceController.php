<?php

namespace App\Http\Controllers;

use App\Models\MaintenanceIssue; // Changed from Maintenance
use App\Models\Room;
use App\Models\User;
use Illuminate\Http\Request;

class MaintenanceController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('role:super_admin,property_manager,housekeeping,maintenance');
    }

    public function index()
    {
        // Temporary empty properties array
        $properties = collect([]);
        
        // Use MaintenanceIssue model
        $maintenances = MaintenanceIssue::with('room', 'reportedBy', 'assignedTo')->latest()->get();
        return view('backend.maintenance.index', compact('maintenances', 'properties'));
    }

    public function create()
    {
        $rooms = Room::all();
        $users = User::all();
        return view('backend.maintenance.create', compact('rooms', 'users'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'room_id' => 'required|exists:rooms,id',
            'reported_by' => 'required|exists:users,id',
            'assigned_to' => 'nullable|exists:users,id',
            'issue_type' => 'required|string|max:255',
            'description' => 'required|string',
            'status' => 'required|string|max:255',
            'priority' => 'required|string|max:255',
        ]);

        // Use MaintenanceIssue model
        MaintenanceIssue::create($validated);

        return redirect()->route('maintenance.index')
            ->with('success', 'Maintenance issue created successfully.');
    }

    public function show($id)
    {
        // Use MaintenanceIssue model
        $maintenance = MaintenanceIssue::with('room', 'reportedBy', 'assignedTo')->findOrFail($id);
        return view('backend.maintenance.show', compact('maintenance'));
    }

    public function edit($id)
    {
        $rooms = Room::all();
        $users = User::all();
        // Use MaintenanceIssue model
        $maintenance = MaintenanceIssue::findOrFail($id);
        return view('backend.maintenance.edit', compact('maintenance', 'rooms', 'users'));
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'room_id' => 'required|exists:rooms,id',
            'reported_by' => 'required|exists:users,id',
            'assigned_to' => 'nullable|exists:users,id',
            'issue_type' => 'required|string|max:255',
            'description' => 'required|string',
            'status' => 'required|string|max:255',
            'priority' => 'required|string|max:255',
        ]);

        // Use MaintenanceIssue model
        $maintenance = MaintenanceIssue::findOrFail($id);
        $maintenance->update($validated);

        return redirect()->route('maintenance.index')
            ->with('success', 'Maintenance issue updated successfully.');
    }

    public function destroy($id)
    {
        // Use MaintenanceIssue model
        $maintenance = MaintenanceIssue::findOrFail($id);
        $maintenance->delete();

        return redirect()->route('maintenance.index')
            ->with('success', 'Maintenance issue deleted successfully.');
    }
}