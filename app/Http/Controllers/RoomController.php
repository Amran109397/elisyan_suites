<?php

namespace App\Http\Controllers;

use App\Models\Room;
use App\Models\Property;
use App\Models\RoomType;
use App\Models\Floor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RoomController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        try {
            $rooms = Room::with(['property', 'roomType', 'floor', 'currentBooking'])
                        ->latest()
                        ->get();
            
            return view('backend.rooms.index', compact('rooms'));
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error loading rooms: ' . $e->getMessage());
        }
    }

    public function create()
    {
        try {
            $properties = Property::where('is_active', true)->get();
            $roomTypes = RoomType::where('is_active', true)->get();
            $floors = Floor::all();
            
            return view('backend.rooms.create', compact('properties', 'roomTypes', 'floors'));
        } catch (\Exception $e) {
            return redirect()->route('rooms.index')
                ->with('error', 'Error loading create form: ' . $e->getMessage());
        }
    }

    public function store(Request $request)
    {
        $request->validate([
            'property_id' => 'required|exists:properties,id',
            'room_type_id' => 'required|exists:room_types,id',
            'floor_id' => 'required|exists:floors,id',
            'room_number' => 'required|string|max:50|unique:rooms,room_number',
            'status' => 'required|in:available,occupied,maintenance,cleaning,out_of_service,blocked,renovation',
            'is_smoking' => 'sometimes|boolean',
        ]);

        try {
            DB::beginTransaction();

            $room = Room::create([
                'property_id' => $request->property_id,
                'room_type_id' => $request->room_type_id,
                'floor_id' => $request->floor_id,
                'room_number' => $request->room_number,
                'status' => $request->status,
                'is_smoking' => $request->boolean('is_smoking'),
            ]);

            DB::commit();

            return redirect()->route('rooms.index')
                ->with('success', 'Room created successfully!');
                
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->withInput()
                ->with('error', 'Error creating room: ' . $e->getMessage());
        }
    }

    public function show($id)
    {
        try {
            $room = Room::with(['property', 'roomType', 'floor', 'currentBooking.guest'])
                        ->findOrFail($id);
            
            return view('backend.rooms.show', compact('room'));
        } catch (\Exception $e) {
            return redirect()->route('rooms.index')
                ->with('error', 'Room not found: ' . $e->getMessage());
        }
    }

    public function edit($id)
    {
        try {
            $room = Room::findOrFail($id);
            $properties = Property::where('is_active', true)->get();
            $roomTypes = RoomType::where('is_active', true)->get();
            $floors = Floor::all();
            
            return view('backend.rooms.edit', compact('room', 'properties', 'roomTypes', 'floors'));
        } catch (\Exception $e) {
            return redirect()->route('rooms.index')
                ->with('error', 'Room not found: ' . $e->getMessage());
        }
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'property_id' => 'required|exists:properties,id',
            'room_type_id' => 'required|exists:room_types,id',
            'floor_id' => 'required|exists:floors,id',
            'room_number' => 'required|string|max:50|unique:rooms,room_number,' . $id,
            'status' => 'required|in:available,occupied,maintenance,cleaning,out_of_service,blocked,renovation',
            'is_smoking' => 'sometimes|boolean',
        ]);

        try {
            DB::beginTransaction();

            $room = Room::findOrFail($id);
            $room->update([
                'property_id' => $request->property_id,
                'room_type_id' => $request->room_type_id,
                'floor_id' => $request->floor_id,
                'room_number' => $request->room_number,
                'status' => $request->status,
                'is_smoking' => $request->boolean('is_smoking'),
            ]);

            DB::commit();

            return redirect()->route('rooms.index')
                ->with('success', 'Room updated successfully!');
                
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->withInput()
                ->with('error', 'Error updating room: ' . $e->getMessage());
        }
    }

    public function destroy($id)
    {
        try {
            DB::beginTransaction();

            $room = Room::findOrFail($id);
            
            // Check if room has bookings
            if ($room->bookings()->exists()) {
                return redirect()->back()
                    ->with('error', 'Cannot delete room. It has associated bookings.');
            }

            $room->delete();

            DB::commit();

            return redirect()->route('rooms.index')
                ->with('success', 'Room deleted successfully!');
                
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->with('error', 'Error deleting room: ' . $e->getMessage());
        }
    }

    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:available,occupied,maintenance,cleaning,out_of_service,blocked,renovation',
            'notes' => 'nullable|string|max:500',
        ]);

        try {
            DB::beginTransaction();

            $room = Room::findOrFail($id);
            $oldStatus = $room->status;
            $room->update(['status' => $request->status]);

            // Log status change
            if (class_exists('App\Models\RoomStatusLog')) {
                \App\Models\RoomStatusLog::create([
                    'room_id' => $room->id,
                    'old_status' => $oldStatus,
                    'new_status' => $request->status,
                    'changed_by' => auth()->id(),
                    'notes' => $request->notes,
                ]);
            }

            DB::commit();

            return redirect()->back()
                ->with('success', 'Room status updated successfully!');
                
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->with('error', 'Error updating room status: ' . $e->getMessage());
        }
    }

    // Quick status update methods
    public function markAvailable($id)
    {
        return $this->quickStatusUpdate($id, 'available');
    }

    public function markOccupied($id)
    {
        return $this->quickStatusUpdate($id, 'occupied');
    }

    public function markMaintenance($id)
    {
        return $this->quickStatusUpdate($id, 'maintenance');
    }

    private function quickStatusUpdate($id, $status)
    {
        try {
            $room = Room::findOrFail($id);
            $room->update(['status' => $status]);

            return redirect()->back()
                ->with('success', "Room marked as " . ucfirst($status) . " successfully!");
                
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Error updating room status: ' . $e->getMessage());
        }
    }
}