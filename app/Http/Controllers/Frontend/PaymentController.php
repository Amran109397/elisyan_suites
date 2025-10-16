<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Booking;
use App\Models\Payment;
use App\Models\PaymentGateway;
use Illuminate\Support\Str;

class PaymentController extends Controller
{
    public function create($bookingId)
    {
        $booking = Booking::findOrFail($bookingId);
        $paymentGateways = PaymentGateway::where('is_active', true)->get();
        
        return view('frontend.payment.create', compact('booking', 'paymentGateways'));
    }
    
    public function store(Request $request, $bookingId)
    {
        $booking = Booking::findOrFail($bookingId);
        
        $validated = $request->validate([
            'payment_method' => 'required|in:credit_card,debit_card,cash,mobile_banking,bank_transfer,voucher',
            'payment_gateway_id' => 'nullable|exists:payment_gateways,id',
        ]);


        $payment = new Payment();
        $payment->booking_id = $booking->id;
        $payment->guest_id = $booking->guest_id;
        $payment->payment_gateway_id = $validated['payment_gateway_id'];
        $payment->amount = $booking->total_price;
        $payment->payment_method = $validated['payment_method'];
        $payment->payment_type = 'full';
        $payment->payment_status = 'completed';
        $payment->transaction_id = 'TXN-' . strtoupper(Str::random(8));
        $payment->paid_at = now();
        $payment->save();
        

        $booking->status = 'confirmed';
        $booking->save();
        
        return redirect()->route('frontend.booking.confirmation', $booking->id);
    }
}