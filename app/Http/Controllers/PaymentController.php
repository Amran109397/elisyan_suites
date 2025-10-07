<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use App\Models\Booking;
use App\Models\Guest;
use App\Models\PaymentGateway;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('role:super_admin,property_manager,receptionist');
    }

    public function index()
    {
        $payments = Payment::with('booking', 'guest', 'paymentGateway')->get();
        return view('payments.index', compact('payments'));
    }

    public function create()
    {
        $bookings = Booking::where('status', '!=', 'cancelled')->get();
        $guests = Guest::all();
        $paymentGateways = PaymentGateway::where('is_active', true)->get();
        return view('payments.create', compact('bookings', 'guests', 'paymentGateways'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'booking_id' => 'required|exists:bookings,id',
            'guest_id' => 'required|exists:guests,id',
            'payment_gateway_id' => 'nullable|exists:payment_gateways,id',
            'amount' => 'required|numeric|min:0',
            'payment_method' => 'required|in:credit_card,debit_card,cash,mobile_banking,bank_transfer,voucher',
            'payment_type' => 'required|in:advance,partial,full,refund,deposit',
            'payment_status' => 'required|in:pending,completed,failed,refunded,voided',
            'transaction_id' => 'nullable|string|max:255|unique:payments',
            'remarks' => 'nullable|string',
        ]);

        Payment::create($validated);

        return redirect()->route('payments.index')
            ->with('success', 'Payment created successfully.');
    }

    public function show(Payment $payment)
    {
        $payment->load('booking', 'guest', 'paymentGateway');
        return view('payments.show', compact('payment'));
    }

    public function edit(Payment $payment)
    {
        $bookings = Booking::where('status', '!=', 'cancelled')->get();
        $guests = Guest::all();
        $paymentGateways = PaymentGateway::where('is_active', true)->get();
        return view('payments.edit', compact('payment', 'bookings', 'guests', 'paymentGateways'));
    }

    public function update(Request $request, Payment $payment)
    {
        $validated = $request->validate([
            'booking_id' => 'required|exists:bookings,id',
            'guest_id' => 'required|exists:guests,id',
            'payment_gateway_id' => 'nullable|exists:payment_gateways,id',
            'amount' => 'required|numeric|min:0',
            'payment_method' => 'required|in:credit_card,debit_card,cash,mobile_banking,bank_transfer,voucher',
            'payment_type' => 'required|in:advance,partial,full,refund,deposit',
            'payment_status' => 'required|in:pending,completed,failed,refunded,voided',
            'transaction_id' => 'nullable|string|max:255|unique:payments,transaction_id,' . $payment->id,
            'remarks' => 'nullable|string',
        ]);

        $payment->update($validated);

        return redirect()->route('payments.index')
            ->with('success', 'Payment updated successfully.');
    }

    public function destroy(Payment $payment)
    {
        $payment->delete();
        return redirect()->route('payments.index')
            ->with('success', 'Payment deleted successfully.');
    }

    public function processPayment(Request $request)
    {
        $request->validate([
            'booking_id' => 'required|exists:bookings,id',
            'amount' => 'required|numeric|min:0',
            'payment_method' => 'required|in:credit_card,debit_card,cash,mobile_banking,bank_transfer,voucher',
            'payment_gateway_id' => 'required_if:payment_method,credit_card,debit_card,mobile_banking',
        ]);

        $booking = Booking::findOrFail($request->booking_id);
        
        $payment = Payment::create([
            'booking_id' => $booking->id,
            'guest_id' => $booking->guest_id,
            'payment_gateway_id' => $request->payment_gateway_id,
            'amount' => $request->amount,
            'payment_method' => $request->payment_method,
            'payment_type' => 'full',
            'payment_status' => 'pending',
            'transaction_id' => 'TXN' . time() . rand(1000, 9999),
        ]);

        // Process payment based on method
        switch ($request->payment_method) {
            case 'cash':
                $payment->payment_status = 'completed';
                $payment->paid_at = now();
                $payment->save();
                break;
                
            case 'credit_card':
            case 'debit_card':
            case 'mobile_banking':
                // Integrate with payment gateway
                // This is a placeholder for actual payment processing
                $payment->payment_status = 'completed';
                $payment->paid_at = now();
                $payment->save();
                break;
                
            case 'bank_transfer':
            case 'voucher':
                // Manual verification required
                break;
        }

        return redirect()->route('payments.show', $payment)
            ->with('success', 'Payment processed successfully.');
    }

    public function markAsCompleted(Payment $payment)
    {
        $payment->payment_status = 'completed';
        $payment->paid_at = now();
        $payment->save();

        return redirect()->back()
            ->with('success', 'Payment marked as completed.');
    }

    public function markAsFailed(Payment $payment)
    {
        $payment->payment_status = 'failed';
        $payment->save();

        return redirect()->back()
            ->with('success', 'Payment marked as failed.');
    }

    public function markAsRefunded(Payment $payment)
    {
        $payment->payment_status = 'refunded';
        $payment->save();

        return redirect()->back()
            ->with('success', 'Payment marked as refunded.');
    }
}