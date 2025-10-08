<?php

namespace App\Http\Controllers;

use App\Models\PromoCode;
use Illuminate\Http\Request;
use Carbon\Carbon;

class PromoCodeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('role:super_admin,property_manager');
    }

    public function index()
    {
        $promoCodes = PromoCode::orderBy('created_at', 'desc')->get();
        return view('backend.promo-codes.index', compact('promoCodes'));
    }

    public function create()
    {
        return view('backend.promo-codes.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'code' => 'required|string|max:255|unique:promo_codes',
            'discount_type' => 'required|in:percentage,fixed,free_night',
            'discount_value' => 'required|numeric|min:0',
            'max_uses' => 'nullable|integer|min:1',
            'valid_from' => 'required|date',
            'valid_until' => 'required|date|after_or_equal:valid_from',
            'is_active' => 'nullable|boolean',
        ]);

        $validated['used_count'] = 0;
        $validated['is_active'] = $request->has('is_active');
        
        PromoCode::create($validated);

        return redirect()->route('promo-codes.index')
            ->with('success', 'Promo code created successfully.');
    }

    public function show(PromoCode $promoCode)
    {
        return view('backend.promo-codes.show', compact('promoCode'));
    }

    public function edit(PromoCode $promoCode)
    {
        return view('backend.promo-codes.edit', compact('promoCode'));
    }

    public function update(Request $request, PromoCode $promoCode)
    {
        $validated = $request->validate([
            'code' => 'required|string|max:255|unique:promo_codes,code,' . $promoCode->id,
            'discount_type' => 'required|in:percentage,fixed,free_night',
            'discount_value' => 'required|numeric|min:0',
            'max_uses' => 'nullable|integer|min:1',
            'valid_from' => 'required|date',
            'valid_until' => 'required|date|after_or_equal:valid_from',
            'is_active' => 'nullable|boolean',
        ]);

        $validated['is_active'] = $request->has('is_active');
        
        $promoCode->update($validated);

        return redirect()->route('promo-codes.show', $promoCode->id)
            ->with('success', 'Promo code updated successfully.');
    }

    public function destroy(PromoCode $promoCode)
    {
        $promoCode->delete();

        return redirect()->route('promo-codes.index')
            ->with('success', 'Promo code deleted successfully.');
    }

    public function toggleActive(PromoCode $promoCode)
    {
        $promoCode->is_active = !$promoCode->is_active;
        $promoCode->save();

        return redirect()->route('promo-codes.index')
            ->with('success', 'Promo code status updated successfully.');
    }

    public function validateCode(Request $request)
    {
        $request->validate([
            'code' => 'required|string',
        ]);

        $promoCode = PromoCode::where('code', $request->code)
            ->where('is_active', true)
            ->where('valid_from', '<=', now())
            ->where('valid_until', '>=', now())
            ->where(function ($query) {
                $query->whereNull('max_uses')
                    ->orWhereRaw('used_count < max_uses');
            })
            ->first();

        if ($promoCode) {
            return response()->json([
                'valid' => true,
                'promo_code' => $promoCode,
            ]);
        }

        return response()->json([
            'valid' => false,
            'message' => 'Invalid or expired promo code.',
        ]);
    }
}