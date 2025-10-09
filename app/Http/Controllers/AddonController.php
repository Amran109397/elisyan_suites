<?php

namespace App\Http\Controllers;

use App\Models\Addon;
use Illuminate\Http\Request;

class AddonController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('role:super_admin,property_manager');
    }

    public function index()
    {
        $addons = Addon::all();
        return view('backend.addons.index', compact('addons'));
    }

    public function create()
    {
        return view('backend.addons.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'is_active' => 'boolean',
        ]);

        Addon::create($validated);

        return redirect()->route('addons.index')
            ->with('success', 'Addon created successfully.');
    }

    public function show(Addon $addon)
    {
        return view('backend.addons.show', compact('addon'));
    }

    public function edit(Addon $addon)
    {
        return view('backend.addons.edit', compact('addon'));
    }

    public function update(Request $request, Addon $addon)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'is_active' => 'boolean',
        ]);

        $addon->update($validated);

        return redirect()->route('addons.index')
            ->with('success', 'Addon updated successfully.');
    }

    public function destroy(Addon $addon)
    {
        $addon->delete();

        return redirect()->route('addons.index')
            ->with('success', 'Addon deleted successfully.');
    }
}