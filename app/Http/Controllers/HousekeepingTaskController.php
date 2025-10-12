<?php

namespace App\Http\Controllers;

use App\Models\HousekeepingTask;
use App\Models\Room;
use App\Models\HousekeepingStaff;
use Illuminate\Http\Request;

class HousekeepingTaskController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('role:super_admin,property_manager,housekeeping');
    }

   public function index()
    {
    
    $properties = collect([]);
    
    
    $tasks = HousekeepingTask::with('room', 'housekeepingStaff')->latest()->paginate(10);
    
    return view('backend.housekeeping-tasks.index', compact('tasks', 'properties'));
    }
    public function create()
    {
        $rooms = Room::all();
        $housekeepingStaffs = HousekeepingStaff::all();
        return view('backend.housekeeping-tasks.create', compact('rooms', 'housekeepingStaffs'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'room_id' => 'required|exists:rooms,id',
            'housekeeping_staff_id' => 'required|exists:housekeeping_staffs,id',
            'task_type' => 'required|string|max:255',
            'description' => 'required|string',
            'status' => 'required|string|max:255',
            'priority' => 'required|string|max:255',
            'scheduled_date' => 'required|date',
            'completed_date' => 'nullable|date',
            'notes' => 'nullable|string',
        ]);

        HousekeepingTask::create($validated);

        return redirect()->route('housekeeping-tasks.index')
            ->with('success', 'Housekeeping task created successfully.');
    }

    public function show(HousekeepingTask $housekeepingTask)
    {
        return view('backend.housekeeping-tasks.show', compact('housekeepingTask'));
    }

    public function edit(HousekeepingTask $housekeepingTask)
    {
        $rooms = Room::all();
        $housekeepingStaffs = HousekeepingStaff::all();
        return view('backend.housekeeping-tasks.edit', compact('housekeepingTask', 'rooms', 'housekeepingStaffs'));
    }

    public function update(Request $request, HousekeepingTask $housekeepingTask)
    {
        $validated = $request->validate([
            'room_id' => 'required|exists:rooms,id',
            'housekeeping_staff_id' => 'required|exists:housekeeping_staffs,id',
            'task_type' => 'required|string|max:255',
            'description' => 'required|string',
            'status' => 'required|string|max:255',
            'priority' => 'required|string|max:255',
            'scheduled_date' => 'required|date',
            'completed_date' => 'nullable|date',
            'notes' => 'nullable|string',
        ]);

        $housekeepingTask->update($validated);

        return redirect()->route('housekeeping-tasks.index')
            ->with('success', 'Housekeeping task updated successfully.');
    }

    public function destroy(HousekeepingTask $housekeepingTask)
    {
        $housekeepingTask->delete();

        return redirect()->route('housekeeping-tasks.index')
            ->with('success', 'Housekeeping task deleted successfully.');
    }
}