<?php

namespace App\Http\Controllers;

use App\Models\UserProperty;
use App\Models\User;
use App\Models\Property;
use Illuminate\Http\Request;

class UserPropertyController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('role:super_admin,property_manager');
    }

    public function index()
    {
        $userProperties = UserProperty::with('user', 'property')->get();
        return view('backend.user-properties.index', compact('userProperties'));
    }

    public function create()
    {
        $users = User::all();
        $properties = Property::all();
        return view('backend.user-properties.create', compact('users', 'properties'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'property_id' => 'required|exists:properties,id',
            'role' => 'required|string|max:255',
        ]);

        UserProperty::create($validated);

        return redirect()->route('user-properties.index')
            ->with('success', 'User property assignment created successfully.');
    }

    public function show(UserProperty $userProperty)
    {
        return view('backend.user-properties.show', compact('userProperty'));
    }

    public function edit(UserProperty $userProperty)
    {
        $users = User::all();
        $properties = Property::all();
        return view('backend.user-properties.edit', compact('userProperty', 'users', 'properties'));
    }

    public function update(Request $request, UserProperty $userProperty)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'property_id' => 'required|exists:properties,id',
            'role' => 'required|string|max:255',
        ]);

        $userProperty->update($validated);

        return redirect()->route('user-properties.index')
            ->with('success', 'User property assignment updated successfully.');
    }

    public function destroy(UserProperty $userProperty)
    {
        $userProperty->delete();

        return redirect()->route('user-properties.index')
            ->with('success', 'User property assignment deleted successfully.');
    }
}