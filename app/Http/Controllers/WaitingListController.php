<?php

namespace App\Http\Controllers;

use App\Models\WaitingList;
use App\Models\Property;
use App\Models\Guest;
use App\Models\RoomType;
use Illuminate\Http\Request;

class WaitingListController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('role:super_admin,property_manager,receptionist');
    }

    public function index()
    {
        $waitingLists = WaitingList::with('property', 'guest', 'roomType')
            ->orderBy('priority', 'desc')
            ->orderBy('created_at', 'asc')
            ->get();
        return view('backend.waiting-list.index', compact('waitingLists'));
    }

    public function create()
    {
        $properties = Property::where('is_active', true)->get();
        $guests = Guest::all();
        $roomTypes = RoomType::where('is_active', true)->get();
        return view('backend.waiting-list.create', compact('properties', 'guests', 'roomTypes'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'property_id' => 'required|exists:properties,id',
            'guest_id' => 'required|exists:guests,id',
            'room_type_id' => 'required|exists:room_types,id',
            'check_in_date' => 'required|date|after_or_equal:today',
            'check_out_date' => 'required|date|after:check_in_date',
            'adults' => 'required|integer|min:1',
            'children' => 'nullable|integer|min:0',
            'status' => 'required|in:waiting,contacted,booked,cancelled',
            'priority' => 'nullable|integer|min:0|max:10',
        ]);

        $validated['priority'] = $validated['priority'] ?? 0;
        
        $waitingList = WaitingList::create($validated);

        return redirect()->route('waiting-list.show', $waitingList->id)
            ->with('success', 'Added to waiting list successfully.');
    }

    public function show(WaitingList $waitingList)
    {
        $waitingList->load('property', 'guest', 'roomType');
        return view('backend.waiting-list.show', compact('waitingList'));
    }

    public function edit(WaitingList $waitingList)
    {
        $properties = Property::where('is_active', true)->get();
        $guests = Guest::all();
        $roomTypes = RoomType::where('is_active', true)->get();
        return view('backend.waiting-list.edit', compact('waitingList', 'properties', 'guests', 'roomTypes'));
    }

    public function update(Request $request, WaitingList $waitingList)
    {
        $validated = $request->validate([
            'property_id' => 'required|exists:properties,id',
            'guest_id' => 'required|exists:guests,id',
            'room_type_id' => 'required|exists:room_types,id',
            'check_in_date' => 'required|date',
            'check_out_date' => 'required|date|after:check_in_date',
            'adults' => 'required|integer|min:1',
            'children' => 'nullable|integer|min:0',
            'status' => 'required|in:waiting,contacted,booked,cancelled',
            'priority' => 'nullable|integer|min:0|max:10',
        ]);

        $validated['priority'] = $validated['priority'] ?? 0;
        
        $waitingList->update($validated);

        return redirect()->route('waiting-list.show', $waitingList->id)
            ->with('success', 'Waiting list updated successfully.');
    }

    public function destroy(WaitingList $waitingList)
    {
        $waitingList->delete();

        return redirect()->route('waiting-list.index')
            ->with('success', 'Waiting list entry deleted successfully.');
    }

    public function contact(WaitingList $waitingList)
    {
        $waitingList->status = 'contacted';
        $waitingList->save();

        return redirect()->route('waiting-list.show', $waitingList->id)
            ->with('success', 'Guest marked as contacted.');
    }

    public function book(WaitingList $waitingList)
    {
        $waitingList->status = 'booked';
        $waitingList->save();

        return redirect()->route('waiting-list.show', $waitingList->id)
            ->with('success', 'Guest marked as booked.');
    }
}