@extends('frontend.layouts.app')

@section('title', 'Booking Confirmation - Elisyan Suites')
@section('description', 'Your booking at Elisyan Suites has been confirmed. Thank you for choosing us.')

@section('content')
    <!-- Page Header -->
    <section class="page-header" style="background: linear-gradient(rgba(0, 0, 0, 0.6), rgba(0, 0, 0, 0.6)), url('https://images.unsplash.com/photo-1571896349842-33c89424de2d?ixlib=rb-4.0.3') center/cover; height: 400px; display: flex; align-items: center; color: white; text-align: center;">
        <div class="container">
            <h1 class="display-3 fw-bold">Booking Confirmed</h1>
            <p class="lead">Thank you for choosing Elisyan Suites</p>
        </div>
    </section>

    <!-- Confirmation Section -->
    <section class="confirmation-section py-5">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <div class="confirmation-card">
                        <div class="confirmation-icon">
                            <i class="fas fa-check-circle"></i>
                        </div>
                        <h2>Booking Confirmed!</h2>
                        <p>Thank you for your reservation. Your booking has been confirmed and a confirmation email has been sent to {{ $booking->guest->email }}.</p>
                        
                        <div class="booking-details">
                            <h3>Booking Details</h3>
                            <div class="booking-detail">
                                <span>Booking Reference:</span>
                                <span>{{ $booking->booking_reference }}</span>
                            </div>
                            <div class="booking-detail">
                                <span>Property:</span>
                                <span>{{ $booking->property->name }}</span>
                            </div>
                            <div class="booking-detail">
                                <span>Room Type:</span>
                                <span>{{ $booking->roomType->name }}</span>
                            </div>
                            <div class="booking-detail">
                                <span>Check-in:</span>
                                <span>{{ \Carbon\Carbon::parse($booking->check_in_date)->format('M d, Y') }}</span>
                            </div>
                            <div class="booking-detail">
                                <span>Check-out:</span>
                                <span>{{ \Carbon\Carbon::parse($booking->check_out_date)->format('M d, Y') }}</span>
                            </div>
                            <div class="booking-detail">
                                <span>Nights:</span>
                                <span>{{ $booking->total_nights }}</span>
                            </div>
                            <div class="booking-detail">
                                <span>Guests:</span>
                                <span>{{ $booking->adults }} Adults, {{ $booking->children }} Children</span>
                            </div>
                            <div class="booking-detail">
                                <span>Status:</span>
                                <span>{{ ucfirst($booking->status) }}</span>
                            </div>
                            <div class="booking-detail total">
                                <span>Total Paid:</span>
                                <span>${{ number_format($booking->total_price, 2) }}</span>
                            </div>
                        </div>
                        
                        <div class="confirmation-actions">
                            <a href="{{ route('frontend.invoice.show', $booking->id) }}" class="btn-custom">View Invoice</a>
                            <a href="{{ route('frontend.home') }}" class="btn-custom btn-outline">Back to Home</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection