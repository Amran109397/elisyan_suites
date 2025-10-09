<?php

namespace App\Http\Controllers;

use App\Models\RoomStatusLog;
use App\Models\Room;
use Illuminate\Http\Request;

class RoomStatusLogController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('role:super_admin,property_manager,receptionist');
    }

    public function index()
    {
        $roomStatusLogs = RoomStatusLog::with('room', 'changedBy')->latest()->get();
        return view('backend.room-status-logs.index', compact('roomStatusLogs'));
    }

    public function create()
    {
        $rooms = Room::all();
        return view('backend.room-status-logs.create', compact('rooms'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'room_id' => 'required|exists:rooms,id',
            'status' => 'required|string|max:255',
            'notes' => 'nullable|string',
        ]);

        $validated['changed_by'] = auth()->id();
        
        RoomStatusLog::create($validated);

        return redirect()->route('room-status-logs.index')
            ->with('success', 'Room status log created successfully.');
    }

    public function show(RoomStatusLog $roomStatusLog)
    {
        return view('backend.room-status-logs.show', compact('roomStatusLog'));
    }

    public function edit(RoomStatusLog $roomStatusLog)
    {
        $rooms = Room::all();
        return view('backend.room-status-logs.edit', compact('roomStatusLog', 'rooms'));
    }

    public function update(Request $request, RoomStatusLog $roomStatusLog)
    {
        $validated = $request->validate([
            'room_id' => 'required|exists:rooms,id',
            'status' => 'required|string|max:255',
            'notes' => 'nullable|string',
        ]);

        $roomStatusLog->update($validated);

        return redirect()->route('room-status-logs.index')
            ->with('success', 'Room status log updated successfully.');
    }

    public function destroy(RoomStatusLog $roomStatusLog)
    {
        $roomStatusLog->delete();

        return redirect()->route('room-status-logs.index')
            ->with('success', 'Room status log deleted successfully.');
    }
}