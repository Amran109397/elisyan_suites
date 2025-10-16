@extends('frontend.layouts.app')

@section('title', 'Payment - Elisyan Suites')
@section('description', 'Complete your payment for your booking at Elisyan Suites.')

@section('content')
    <!-- Page Header -->
    <section class="page-header" style="background: linear-gradient(rgba(0, 0, 0, 0.6), rgba(0, 0, 0, 0.6)), url('https://images.unsplash.com/photo-1571896349842-33c89424de2d?ixlib=rb-4.0.3') center/cover; height: 400px; display: flex; align-items: center; color: white; text-align: center;">
        <div class="container">
            <h1 class="display-3 fw-bold">Complete Your Payment</h1>
            <p class="lead">Securely pay for your reservation</p>
        </div>
    </section>

    <!-- Payment Form Section -->
    <section class="payment-form-section py-5">
        <div class="container">
            <div class="row">
                <div class="col-lg-8">
                    <div class="payment-form-card">
                        <h3 class="mb-4">Payment Details</h3>
                        <form action="{{ route('frontend.payment.store', $booking->id) }}" method="POST">
                            @csrf
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group mb-3">
                                        <label for="payment_method">Payment Method</label>
                                        <select class="form-select" id="payment_method" name="payment_method" required>
                                            <option value="">Select Payment Method</option>
                                            <option value="credit_card">Credit Card</option>
                                            <option value="debit_card">Debit Card</option>
                                            <option value="mobile_banking">Mobile Banking</option>
                                            <option value="bank_transfer">Bank Transfer</option>
                                            <option value="voucher">Voucher</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group mb-3">
                                        <label for="payment_gateway_id">Payment Gateway</label>
                                        <select class="form-select" id="payment_gateway_id" name="payment_gateway_id">
                                            <option value="">Select Payment Gateway</option>
                                            @foreach($paymentGateways as $gateway)
                                            <option value="{{ $gateway->id }}">{{ $gateway->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-group mb-3">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" id="agree_terms" required>
                                            <label class="form-check-label" for="agree_terms">
                                                I agree to the terms and conditions
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <button type="submit" class="btn-custom w-100">Pay Now ${{ number_format($booking->total_price, 2) }}</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="booking-summary-card">
                        <h3>Booking Summary</h3>
                        <div class="booking-details">
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
                            <div class="booking-detail total">
                                <span>Total:</span>
                                <span>${{ number_format($booking->total_price, 2) }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection