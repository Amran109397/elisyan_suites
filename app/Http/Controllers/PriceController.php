<?php

namespace App\Http\Controllers;

use App\Models\Price;
use App\Models\RoomType;
use Illuminate\Http\Request;
use Carbon\Carbon;

class PriceController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('role:super_admin,property_manager');
    }

    public function index()
    {
        $prices = Price::with('roomType')->orderBy('date')->get();
        $roomTypes = RoomType::where('is_active', true)->get();
        return view('backend.prices.index', compact('prices', 'roomTypes'));
    }

    public function create()
    {
        $roomTypes = RoomType::where('is_active', true)->get();
        return view('backend.prices.create', compact('roomTypes'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'room_type_id' => 'required|exists:room_types,id',
            'date' => 'required|date|after_or_equal:today',
            'price' => 'required|numeric|min:0',
        ]);

        Price::create($validated);

        return redirect()->route('prices.index')
            ->with('success', 'Price created successfully.');
    }

    public function show(Price $price)
    {
        $price->load('roomType');
        return view('backend.prices.show', compact('price'));
    }

    public function edit(Price $price)
    {
        $roomTypes = RoomType::where('is_active', true)->get();
        return view('backend.prices.edit', compact('price', 'roomTypes'));
    }

    public function update(Request $request, Price $price)
    {
        $validated = $request->validate([
            'room_type_id' => 'required|exists:room_types,id',
            'date' => 'required|date',
            'price' => 'required|numeric|min:0',
        ]);

        $price->update($validated);

        return redirect()->route('prices.show', $price->id)
            ->with('success', 'Price updated successfully.');
    }

    public function destroy(Price $price)
    {
        $price->delete();

        return redirect()->route('prices.index')
            ->with('success', 'Price deleted successfully.');
    }

    public function bulkStore(Request $request)
    {
        $validated = $request->validate([
            'room_type_id' => 'required|exists:room_types,id',
            'start_date' => 'required|date|after_or_equal:today',
            'end_date' => 'required|date|after_or_equal:start_date',
            'price' => 'required|numeric|min:0',
        ]);

        $roomType = RoomType::find($validated['room_type_id']);
        $startDate = Carbon::parse($validated['start_date']);
        $endDate = Carbon::parse($validated['end_date']);
        
        // Delete existing prices for this date range
        Price::where('room_type_id', $validated['room_type_id'])
            ->whereBetween('date', [$startDate, $endDate])
            ->delete();
        
        // Create new prices for each day in the range
        $dates = [];
        $currentDate = $startDate->copy();
        
        while ($currentDate->lte($endDate)) {
            $dates[] = [
                'room_type_id' => $validated['room_type_id'],
                'date' => $currentDate->format('Y-m-d'),
                'price' => $validated['price'],
                'created_at' => now(),
                'updated_at' => now(),
            ];
            
            $currentDate->addDay();
        }
        
        Price::insert($dates);

        return redirect()->route('prices.index')
            ->with('success', 'Bulk prices created successfully.');
    }
}