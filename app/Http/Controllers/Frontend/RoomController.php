<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Property;
use App\Models\RoomType;
use App\Models\Room;
use App\Models\RoomImage;

class RoomController extends Controller
{
    public function index()
    {
        $roomTypes = RoomType::with(['property', 'roomImages'])
            ->where('is_active', true)
            ->get();
            
        return view('frontend.rooms.index', compact('roomTypes'));
    }
    
    public function show($id)
    {
        $roomType = RoomType::with(['property', 'rooms', 'roomImages', 'amenities'])
            ->where('is_active', true)
            ->findOrFail($id);
            

        $relatedRooms = RoomType::where('property_id', $roomType->property_id)
            ->where('id', '!=', $roomType->id)
            ->where('is_active', true)
            ->take(3)
            ->get();
            
        return view('frontend.rooms.show', compact('roomType', 'relatedRooms'));
    }
}