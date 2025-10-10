<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Property;
use Illuminate\Http\Request;

class EventController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('role:super_admin,property_manager');
    }

    public function index()
    {
        $events = Event::with('property')->paginate(10);
        $properties = Property::all();
        return view('backend.events.index', compact('events', 'properties'));
    }

    public function create()
    {
        $properties = Property::all();
        return view('backend.events.create', compact('properties'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'property_id' => 'required|exists:properties,id',
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'capacity' => 'required|integer|min:1',
            'setup_time' => 'required|integer|min:0',
            'cleanup_time' => 'required|integer|min:0',
            'status' => 'required|in:draft,published,ongoing,completed,cancelled',
        ]);

        Event::create($validated);

        return redirect()->route('events.index')
            ->with('success', 'Event created successfully.');
    }

    public function show(Event $event)
    {
        $event->load('property', 'eventResources.resource', 'eventBookings.guest');
        return view('backend.events.show', compact('event'));
    }

    public function edit(Event $event)
    {
        $properties = Property::all();
        return view('backend.events.edit', compact('event', 'properties'));
    }

    public function update(Request $request, Event $event)
    {
        $validated = $request->validate([
            'property_id' => 'required|exists:properties,id',
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'capacity' => 'required|integer|min:1',
            'setup_time' => 'required|integer|min:0',
            'cleanup_time' => 'required|integer|min:0',
            'status' => 'required|in:draft,published,ongoing,completed,cancelled',
        ]);

        $event->update($validated);

        return redirect()->route('events.index')
            ->with('success', 'Event updated successfully.');
    }

    public function destroy(Event $event)
    {
        $event->delete();

        return redirect()->route('events.index')
            ->with('success', 'Event deleted successfully.');
    }

    // Calendar View Method
public function calendar()
{
    $totalEvents = Event::count();
    $publishedEvents = Event::where('status', 'published')->count();
    $ongoingEvents = Event::where('status', 'ongoing')->count();
    $completedEvents = Event::where('status', 'completed')->count();
    $cancelledEvents = Event::where('status', 'cancelled')->count();
    $draftEvents = Event::where('status', 'draft')->count();

    return view('backend.events.calendar', compact(
        'totalEvents',
        'publishedEvents',
        'ongoingEvents',
        'completedEvents',
        'cancelledEvents',
        'draftEvents'
    ));
}

// Calendar Data API
public function calendarData(Request $request)
{
    $searchTerm = $request->get('search');
    
    $events = Event::with('property')
        ->when($searchTerm, function($query) use ($searchTerm) {
            return $query->where('name', 'like', '%' . $searchTerm . '%')
                        ->orWhereHas('property', function($q) use ($searchTerm) {
                            $q->where('name', 'like', '%' . $searchTerm . '%');
                        });
        })
        ->get();

    $formattedEvents = [];
    foreach ($events as $event) {
        $color = $this->getEventColor($event->status);
        
        $formattedEvents[] = [
            'id' => $event->id,
            'title' => $event->name . ' (' . $event->property->name . ')',
            'start' => $event->start_date->toIso8601String(),
            'end' => $event->end_date->toIso8601String(),
            'color' => $color,
            'url' => route('events.show', $event->id),
            'extendedProps' => [
                'property' => $event->property->name,
                'status' => $event->status,
                'capacity' => $event->capacity,
            ]
        ];
    }

    return response()->json($formattedEvents);
}
}