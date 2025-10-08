<?php

namespace App\Http\Controllers;

use App\Models\RoomAssignment;
use App\Models\Booking;
use App\Models\Room;
use Illuminate\Http\Request;

class RoomAssignmentController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('role:super_admin,property_manager,receptionist');
    }

    public function index()
    {
        $roomAssignments = RoomAssignment::with('booking', 'booking.guest', 'room', 'assignedBy')->get();
        return view('backend.room-assignments.index', compact('roomAssignments'));
    }

    public function create()
    {
        $bookings = Booking::whereDoesntHave('roomAssignments')->get();
        $rooms = Room::where('status', 'available')->get();
        return view('backend.room-assignments.create', compact('bookings', 'rooms'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'booking_id' => 'required|exists:bookings,id',
            'room_id' => 'required|exists:rooms,id',
        ]);

        $validated['assigned_by'] = auth()->id();
        $validated['assigned_at'] = now();
        
        $roomAssignment = RoomAssignment::create($validated);
        
        // Update booking with room_id
        $booking = Booking::find($validated['booking_id']);
        $booking->room_id = $validated['room_id'];
        $booking->save();
        
        // Update room status
        $room = Room::find($validated['room_id']);
        $room->status = 'occupied';
        $room->save();

        return redirect()->route('room-assignments.show', $roomAssignment->id)
            ->with('success', 'Room assigned successfully.');
    }

    public function show(RoomAssignment $roomAssignment)
    {
        $roomAssignment->load('booking', 'booking.guest', 'room', 'assignedBy');
        return view('backend.room-assignments.show', compact('roomAssignment'));
    }

    public function edit(RoomAssignment $roomAssignment)
    {
        $rooms = Room::where('status', 'available')->orWhere('id', $roomAssignment->room_id)->get();
        return view('backend.room-assignments.edit', compact('roomAssignment', 'rooms'));
    }

    public function update(Request $request, RoomAssignment $roomAssignment)
    {
        $validated = $request->validate([
            'room_id' => 'required|exists:rooms,id',
        ]);

        // Free up the old room
        $oldRoom = $roomAssignment->room;
        $oldRoom->status = 'available';
        $oldRoom->save();
        
        $roomAssignment->update($validated);
        
        // Update booking with new room_id
        $booking = $roomAssignment->booking;
        $booking->room_id = $validated['room_id'];
        $booking->save();
        
        // Update new room status
        $newRoom = Room::find($validated['room_id']);
        $newRoom->status = 'occupied';
        $newRoom->save();

        return redirect()->route('room-assignments.show', $roomAssignment->id)
            ->with('success', 'Room assignment updated successfully.');
    }

    public function destroy(RoomAssignment $roomAssignment)
    {
        // Update booking to remove room_id
        $booking = $roomAssignment->booking;
        $booking->room_id = null;
        $booking->save();
        
        // Update room status
        $room = $roomAssignment->room;
        $room->status = 'available';
        $room->save();
        
        $roomAssignment->delete();

        return redirect()->route('room-assignments.index')
            ->with('success', 'Room assignment deleted successfully.');
    }
}