<?php

namespace App\Http\Controllers;

use App\Models\EventResource;
use App\Models\Event;
use App\Models\Resource;
use Illuminate\Http\Request;

class EventResourceController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('role:super_admin,property_manager');
    }

    public function index()
    {
        $eventResources = EventResource::with(['event', 'resource'])->paginate(10);
        $events = Event::all();
        $resources = Resource::all();
        return view('backend.event-resources.index', compact('eventResources', 'events', 'resources'));
    }

    public function create()
    {
        $events = Event::where('status', 'published')->get();
        $resources = Resource::where('is_available', true)->get();
        return view('backend.event-resources.create', compact('events', 'resources'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'event_id' => 'required|exists:events,id',
            'resource_id' => 'required|exists:resources,id',
            'quantity' => 'required|integer|min:1',
            'start_time' => 'required|date',
            'end_time' => 'required|date|after_or_equal:start_time',
            'notes' => 'nullable|string',
        ]);

        EventResource::create($validated);

        return redirect()->route('event-resources.index')
            ->with('success', 'Event resource assigned successfully.');
    }

    public function show(EventResource $eventResource)
    {
        $eventResource->load(['event', 'resource']);
        return view('backend.event-resources.show', compact('eventResource'));
    }

    public function edit(EventResource $eventResource)
    {
        $events = Event::where('status', 'published')->get();
        $resources = Resource::where('is_available', true)->get();
        return view('backend.event-resources.edit', compact('eventResource', 'events', 'resources'));
    }

    public function update(Request $request, EventResource $eventResource)
    {
        $validated = $request->validate([
            'event_id' => 'required|exists:events,id',
            'resource_id' => 'required|exists:resources,id',
            'quantity' => 'required|integer|min:1',
            'start_time' => 'required|date',
            'end_time' => 'required|date|after_or_equal:start_time',
            'notes' => 'nullable|string',
        ]);

        $eventResource->update($validated);

        return redirect()->route('event-resources.index')
            ->with('success', 'Event resource updated successfully.');
    }

    public function destroy(EventResource $eventResource)
    {
        $eventResource->delete();

        return redirect()->route('event-resources.index')
            ->with('success', 'Event resource removed successfully.');
    }
}