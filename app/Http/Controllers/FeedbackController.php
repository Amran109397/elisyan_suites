<?php

namespace App\Http\Controllers;

use App\Models\Feedback;
use App\Models\Guest;
use App\Models\Booking;
use Illuminate\Http\Request;

class FeedbackController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('role:super_admin,property_manager');
    }

    public function index()
    {
        $feedbacks = Feedback::with('guest', 'booking')->latest()->get();
        return view('backend.feedback.index', compact('feedbacks'));
    }

    public function create()
    {
        $guests = Guest::all();
        $bookings = Booking::all();
        return view('backend.feedback.create', compact('guests', 'bookings'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'guest_id' => 'required|exists:guests,id',
            'booking_id' => 'nullable|exists:bookings,id',
            'rating' => 'required|integer|min:1|max:5',
            'category' => 'required|string|max:255',
            'comments' => 'required|string',
            'status' => 'required|string|max:255',
        ]);

        Feedback::create($validated);

        return redirect()->route('feedback.index')
            ->with('success', 'Feedback created successfully.');
    }

    public function show(Feedback $feedback)
    {
        return view('backend.feedback.show', compact('feedback'));
    }

    public function edit(Feedback $feedback)
    {
        $guests = Guest::all();
        $bookings = Booking::all();
        return view('backend.feedback.edit', compact('feedback', 'guests', 'bookings'));
    }

    public function update(Request $request, Feedback $feedback)
    {
        $validated = $request->validate([
            'guest_id' => 'required|exists:guests,id',
            'booking_id' => 'nullable|exists:bookings,id',
            'rating' => 'required|integer|min:1|max:5',
            'category' => 'required|string|max:255',
            'comments' => 'required|string',
            'status' => 'required|string|max:255',
        ]);

        $feedback->update($validated);

        return redirect()->route('feedback.index')
            ->with('success', 'Feedback updated successfully.');
    }

    public function destroy(Feedback $feedback)
    {
        $feedback->delete();

        return redirect()->route('feedback.index')
            ->with('success', 'Feedback deleted successfully.');
    }
}