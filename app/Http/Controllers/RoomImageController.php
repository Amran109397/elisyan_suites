<?php

namespace App\Http\Controllers;

use App\Models\RoomImage;
use App\Models\RoomType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class RoomImageController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('role:super_admin,property_manager,receptionist');
    }

    public function index()
    {
        $roomImages = RoomImage::with('roomType')->orderBy('display_order')->get();
        return view('backend.room-images.index', compact('roomImages'));
    }

    public function create()
    {
        $roomTypes = RoomType::where('is_active', true)->get();
        return view('backend.room-images.create', compact('roomTypes'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'room_type_id' => 'required|exists:room_types,id',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'alt_text' => 'required|string|max:255',
            'is_primary' => 'nullable|boolean',
            'display_order' => 'nullable|integer|min:0',
        ]);

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('room-images', 'public');
            $validated['image_path'] = $path;
        }

        $validated['is_primary'] = $request->has('is_primary');
        $validated['display_order'] = $validated['display_order'] ?? 0;
        
        // If this is set as primary, unset any existing primary image for this room type
        if ($validated['is_primary']) {
            RoomImage::where('room_type_id', $validated['room_type_id'])
                ->where('is_primary', true)
                ->update(['is_primary' => false]);
        }
        
        RoomImage::create($validated);

        return redirect()->route('room-images.index')
            ->with('success', 'Room image uploaded successfully.');
    }

    public function show(RoomImage $roomImage)
    {
        $roomImage->load('roomType');
        return view('backend.room-images.show', compact('roomImage'));
    }

    public function edit(RoomImage $roomImage)
    {
        $roomTypes = RoomType::where('is_active', true)->get();
        return view('backend.room-images.edit', compact('roomImage', 'roomTypes'));
    }

    public function update(Request $request, RoomImage $roomImage)
    {
        $validated = $request->validate([
            'room_type_id' => 'required|exists:room_types,id',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'alt_text' => 'required|string|max:255',
            'is_primary' => 'nullable|boolean',
            'display_order' => 'nullable|integer|min:0',
        ]);

        if ($request->hasFile('image')) {
            // Delete old image
            if ($roomImage->image_path) {
                Storage::disk('public')->delete($roomImage->image_path);
            }
            
            $path = $request->file('image')->store('room-images', 'public');
            $validated['image_path'] = $path;
        }

        $validated['is_primary'] = $request->has('is_primary');
        $validated['display_order'] = $validated['display_order'] ?? 0;
        
        // If this is set as primary, unset any existing primary image for this room type
        if ($validated['is_primary']) {
            RoomImage::where('room_type_id', $validated['room_type_id'])
                ->where('id', '!=', $roomImage->id)
                ->where('is_primary', true)
                ->update(['is_primary' => false]);
        }
        
        $roomImage->update($validated);

        return redirect()->route('room-images.show', $roomImage->id)
            ->with('success', 'Room image updated successfully.');
    }

    public function destroy(RoomImage $roomImage)
    {
        // Delete image file
        if ($roomImage->image_path) {
            Storage::disk('public')->delete($roomImage->image_path);
        }
        
        $roomImage->delete();

        return redirect()->route('room-images.index')
            ->with('success', 'Room image deleted successfully.');
    }

    public function setPrimary(RoomImage $roomImage)
    {
        // Unset any existing primary image for this room type
        RoomImage::where('room_type_id', $roomImage->room_type_id)
            ->where('is_primary', true)
            ->update(['is_primary' => false]);
        
        // Set this image as primary
        $roomImage->is_primary = true;
        $roomImage->save();

        return redirect()->route('room-images.show', $roomImage->id)
            ->with('success', 'Image set as primary successfully.');
    }
}