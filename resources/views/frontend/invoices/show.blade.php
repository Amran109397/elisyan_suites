@extends('frontend.layouts.app')

@section('title', 'Invoice - Elisyan Suites')
@section('description', 'View your invoice for your booking at Elisyan Suites.')

@section('content')
    <!-- Page Header -->
    <section class="page-header" style="background: linear-gradient(rgba(0, 0, 0, 0.6), rgba(0, 0, 0, 0.6)), url('https://images.unsplash.com/photo-1571896349842-33c89424de2d?ixlib=rb-4.0.3') center/cover; height: 400px; display: flex; align-items: center; color: white; text-align: center;">
        <div class="container">
            <h1 class="display-3 fw-bold">Invoice</h1>
            <p class="lead">Your booking invoice details</p>
        </div>
    </section>

    <!-- Invoice Section -->
    <section class="invoice-section py-5">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <div class="invoice-card">
                        <div class="invoice-header">
                            <div class="row">
                                <div class="col-md-6">
                                    <h2>INVOICE</h2>
                                    <p>Invoice #: {{ $invoice->invoice_number }}</p>
                                    <p>Issue Date: {{ \Carbon\Carbon::parse($invoice->issue_date)->format('M d, Y') }}</p>
                                    <p>Due Date: {{ \Carbon\Carbon::parse($invoice->due_date)->format('M d, Y') }}</p>
                                </div>
                                <div class="col-md-6 text-md-end">
                                    <h3>Elisyan Suites</h3>
                                    <p>123 Luxury Avenue, City Center</p>
                                    <p>+1 (555) 123-4567</p>
                                    <p>info@elisyansuites.com</p>
                                </div>
                            </div>
                        </div>
                        
                        <div class="invoice-details">
                            <div class="row">
                                <div class="col-md-6">
                                    <h4>Bill To:</h4>
                                    <p>{{ $booking->guest->first_name }} {{ $booking->guest->last_name }}</p>
                                    <p>{{ $booking->guest->email }}</p>
                                    <p>{{ $booking->guest->phone }}</p>
                                </div>
                                <div class="col-md-6 text-md-end">
                                    <h4>Booking Details:</h4>
                                    <p>Booking Reference: {{ $booking->booking_reference }}</p>
                                    <p>Property: {{ $booking->property->name }}</p>
                                    <p>Room Type: {{ $booking->roomType->name }}</p>
                                    <p>{{ \Carbon\Carbon::parse($booking->check_in_date)->format('M d, Y') }} - {{ \Carbon\Carbon::parse($booking->check_out_date)->format('M d, Y') }}</p>
                                </div>
                            </div>
                        </div>
                        
                        <div class="invoice-items">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>Description</th>
                                        <th>Qty</th>
                                        <th>Price</th>
                                        <th>Total</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>{{ $booking->roomType->name }} ({{ $booking->total_nights }} nights)</td>
                                        <td>{{ $booking->total_nights }}</td>
                                        <td>${{ number_format($booking->roomType->base_price, 2) }}</td>
                                        <td>${{ number_format($booking->roomType->base_price * $booking->total_nights, 2) }}</td>
                                    </tr>
                                    @if($booking->bookingAddons->count() > 0)
                                        @foreach($booking->bookingAddons as $addon)
                                        <tr>
                                            <td>{{ $addon->addon->name }}</td>
                                            <td>{{ $addon->quantity }}</td>
                                            <td>${{ number_format($addon->price, 2) }}</td>
                                            <td>${{ number_format($addon->price * $addon->quantity, 2) }}</td>
                                        </tr>
                                        @endforeach
                                    @endif
                                    <tr>
                                        <td colspan="3" class="text-end">Subtotal</td>
                                        <td>${{ number_format($invoice->amount - $invoice->tax_amount, 2) }}</td>
                                    </tr>
                                    <tr>
                                        <td colspan="3" class="text-end">Tax</td>
                                        <td>${{ number_format($invoice->tax_amount, 2) }}</td>
                                    </tr>
                                    <tr class="total-row">
                                        <td colspan="3" class="text-end"><strong>Total</strong></td>
                                        <td><strong>${{ number_format($invoice->amount, 2) }}</strong></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        
                        <div class="invoice-footer">
                            <div class="row">
                                <div class="col-md-6">
                                    <p><strong>Payment Status:</strong> {{ ucfirst($invoice->status) }}</p>
                                </div>
                                <div class="col-md-6 text-md-end">
                                    <a href="{{ $invoice->pdf_path }}" class="btn-custom" target="_blank">Download PDF</a>
                                    <a href="{{ route('frontend.home') }}" class="btn-custom btn-outline">Back to Home</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection