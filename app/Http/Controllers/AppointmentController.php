<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\Therapist;
use App\Models\Treatment;
use App\Models\Guest;
use App\Models\Property;
use Illuminate\Http\Request;

class AppointmentController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('role:super_admin,property_manager,receptionist');
    }

    public function index()
    {
        $appointments = Appointment::with(['guest', 'therapist', 'treatment'])->paginate(10);
        $therapists = Therapist::where('is_active', true)->get();
        $treatments = Treatment::where('is_active', true)->get();
        $guests = Guest::all();
        return view('backend.appointments.index', compact('appointments', 'therapists', 'treatments', 'guests'));
    }

    public function create()
    {
        $therapists = Therapist::where('is_active', true)->get();
        $treatments = Treatment::where('is_active', true)->get();
        $guests = Guest::all();
        $properties = Property::all(); // Properties যোগ করুন
        return view('backend.appointments.create', compact('therapists', 'treatments', 'guests', 'properties'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'property_id' => 'required|exists:properties,id', // Property validation যোগ করুন
            'guest_id' => 'required|exists:guests,id',
            'therapist_id' => 'required|exists:therapists,id',
            'treatment_id' => 'required|exists:treatments,id',
            'appointment_date' => 'required|date',
            'appointment_time' => 'required',
            'duration' => 'required|integer|min:1',
            'status' => 'required|in:scheduled,confirmed,in_progress,completed,cancelled,no_show',
            'notes' => 'nullable|string',
        ]);

        Appointment::create($validated);

        return redirect()->route('appointments.index')
            ->with('success', 'Appointment created successfully.');
    }

    // বাকি মেথডগুলো একইভাবে properties যোগ করুন
    public function edit(Appointment $appointment)
    {
        $therapists = Therapist::where('is_active', true)->get();
        $treatments = Treatment::where('is_active', true)->get();
        $guests = Guest::all();
        $properties = Property::all();
        return view('backend.appointments.edit', compact('appointment', 'therapists', 'treatments', 'guests', 'properties'));
    }

    public function update(Request $request, Appointment $appointment)
    {
        $validated = $request->validate([
            'property_id' => 'required|exists:properties,id',
            'guest_id' => 'required|exists:guests,id',
            'therapist_id' => 'required|exists:therapists,id',
            'treatment_id' => 'required|exists:treatments,id',
            'appointment_date' => 'required|date',
            'appointment_time' => 'required',
            'duration' => 'required|integer|min:1',
            'status' => 'required|in:scheduled,confirmed,in_progress,completed,cancelled,no_show',
            'notes' => 'nullable|string',
        ]);

        $appointment->update($validated);

        return redirect()->route('appointments.index')
            ->with('success', 'Appointment updated successfully.');
    }


    // Calendar View Method
    public function calendar()
    {
        $totalAppointments = Appointment::count();
        $scheduledAppointments = Appointment::where('status', 'scheduled')->count();
        $confirmedAppointments = Appointment::where('status', 'confirmed')->count();
        $inProgressAppointments = Appointment::where('status', 'in_progress')->count();
        $completedAppointments = Appointment::where('status', 'completed')->count();
        $cancelledAppointments = Appointment::where('status', 'cancelled')->count();
        $noShowAppointments = Appointment::where('status', 'no_show')->count();

        return view('backend.appointments.calendar', compact(
            'totalAppointments',
            'scheduledAppointments',
            'confirmedAppointments',
            'inProgressAppointments',
            'completedAppointments',
            'cancelledAppointments',
            'noShowAppointments'
        ));
    }

    // Calendar Data API
    public function calendarData(Request $request)
    {
        $searchTerm = $request->get('search');
        
        $appointments = Appointment::with(['guest', 'therapist', 'treatment'])
            ->when($searchTerm, function($query) use ($searchTerm) {
                return $query->whereHas('guest', function($q) use ($searchTerm) {
                            $q->where('first_name', 'like', '%' . $searchTerm . '%')
                              ->orWhere('last_name', 'like', '%' . $searchTerm . '%');
                        })
                        ->orWhereHas('therapist', function($q) use ($searchTerm) {
                            $q->where('name', 'like', '%' . $searchTerm . '%');
                        })
                        ->orWhereHas('treatment', function($q) use ($searchTerm) {
                            $q->where('name', 'like', '%' . $searchTerm . '%');
                        });
            })
            ->get();

        $formattedAppointments = [];
        foreach ($appointments as $appointment) {
            $color = $this->getAppointmentColor($appointment->status);
            
            // Combine date and time for full datetime
            $startDateTime = $appointment->appointment_date . ' ' . $appointment->appointment_time;
            $endDateTime = date('Y-m-d H:i:s', strtotime($startDateTime . ' + ' . $appointment->duration . ' minutes'));
            
            $formattedAppointments[] = [
                'id' => $appointment->id,
                'title' => $appointment->guest->first_name . ' ' . $appointment->guest->last_name . ' - ' . $appointment->treatment->name,
                'start' => $startDateTime,
                'end' => $endDateTime,
                'color' => $color,
                'url' => route('appointments.show', $appointment->id),
                'extendedProps' => [
                    'guest' => $appointment->guest->first_name . ' ' . $appointment->guest->last_name,
                    'therapist' => $appointment->therapist->name,
                    'treatment' => $appointment->treatment->name,
                    'status' => $appointment->status,
                    'duration' => $appointment->duration,
                    'notes' => $appointment->notes,
                ]
            ];
        }

        return response()->json($formattedAppointments);
    }

    private function getAppointmentColor($status)
    {
        switch ($status) {
            case 'confirmed':
                return '#28a745'; // Green
            case 'in_progress':
                return '#007bff'; // Blue
            case 'completed':
                return '#6c757d'; // Gray
            case 'cancelled':
                return '#dc3545'; // Red
            case 'no_show':
                return '#ffc107'; // Yellow
            case 'scheduled':
            default:
                return '#17a2b8'; // Teal
        }
    }
}