<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Booking;
use App\Models\Invoice;

class InvoiceController extends Controller
{
    public function show($bookingId)
    {
        $booking = Booking::findOrFail($bookingId);
        $invoice = Invoice::where('booking_id', $bookingId)->firstOrFail();
        
        return view('frontend.invoices.show', compact('booking', 'invoice'));
    }
}