<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\Guest;
use App\Models\Treatment;
use App\Models\Therapist;
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
        $appointments = Appointment::with('guest', 'treatment', 'therapist')->latest()->get();
        return view('backend.appointments.index', compact('appointments'));
    }

    public function create()
    {
        $guests = Guest::all();
        $treatments = Treatment::all();
        $therapists = Therapist::all();
        return view('backend.appointments.create', compact('guests', 'treatments', 'therapists'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'guest_id' => 'required|exists:guests,id',
            'treatment_id' => 'required|exists:treatments,id',
            'therapist_id' => 'required|exists:therapists,id',
            'appointment_date' => 'required|date',
            'appointment_time' => 'required|date_format:H:i',
            'status' => 'required|string|max:255',
            'notes' => 'nullable|string',
        ]);

        Appointment::create($validated);

        return redirect()->route('appointments.index')
            ->with('success', 'Appointment created successfully.');
    }

    public function show(Appointment $appointment)
    {
        return view('backend.appointments.show', compact('appointment'));
    }

    public function edit(Appointment $appointment)
    {
        $guests = Guest::all();
        $treatments = Treatment::all();
        $therapists = Therapist::all();
        return view('backend.appointments.edit', compact('appointment', 'guests', 'treatments', 'therapists'));
    }

    public function update(Request $request, Appointment $appointment)
    {
        $validated = $request->validate([
            'guest_id' => 'required|exists:guests,id',
            'treatment_id' => 'required|exists:treatments,id',
            'therapist_id' => 'required|exists:therapists,id',
            'appointment_date' => 'required|date',
            'appointment_time' => 'required|date_format:H:i',
            'status' => 'required|string|max:255',
            'notes' => 'nullable|string',
        ]);

        $appointment->update($validated);

        return redirect()->route('appointments.index')
            ->with('success', 'Appointment updated successfully.');
    }

    public function destroy(Appointment $appointment)
    {
        $appointment->delete();

        return redirect()->route('appointments.index')
            ->with('success', 'Appointment deleted successfully.');
    }
}