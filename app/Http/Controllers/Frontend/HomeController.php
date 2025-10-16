<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Property;
use App\Models\RoomType;
use App\Models\Room;

class HomeController extends Controller
{
    public function index()
    {

        $properties = Property::where('is_active', true)->get();
        $featuredRooms = RoomType::where('is_active', true)->take(3)->get();
        
        return view('frontend.home.index', compact('properties', 'featuredRooms'));
    }
}