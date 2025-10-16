@extends('frontend.layouts.app')

@section('title', 'Book Your Stay - Elisyan Suites')
@section('description', 'Book your stay at Elisyan Suites. Choose from our luxurious rooms and suites for an unforgettable experience.')

@section('content')
    <!-- Page Header -->
    <section class="page-header" style="background: linear-gradient(rgba(0, 0, 0, 0.6), rgba(0, 0, 0, 0.6)), url('https://images.unsplash.com/photo-1551882547-ff40c63fe5fa?ixlib=rb-4.0.3') center/cover; height: 400px; display: flex; align-items: center; color: white; text-align: center;">
        <div class="container">
            <h1 class="display-3 fw-bold">Book Your Stay</h1>
            <p class="lead">Reserve your luxury accommodation at Elisyan Suites</p>
        </div>
    </section>

    <!-- Booking Form Section -->
    <section class="booking-form-section py-5">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <div class="booking-form-card">
                        <h3 class="text-center mb-4">Complete Your Booking</h3>
                        <form action="{{ route('frontend.booking.store') }}" method="POST">
                            @csrf
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group mb-3">
                                        <label for="property_id">Property</label>
                                        <select class="form-select" id="property_id" name="property_id" required>
                                            <option value="">Select Property</option>
                                            @foreach($properties as $property)
                                            <option value="{{ $property->id }}" {{ old('property_id') == $property->id ? 'selected' : '' }}>{{ $property->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group mb-3">
                                        <label for="room_type_id">Room Type</label>
                                        <select class="form-select" id="room_type_id" name="room_type_id" required>
                                            <option value="">Select Room Type</option>
                                            @foreach($roomTypes as $roomType)
                                            <option value="{{ $roomType->id }}" {{ old('room_type_id') == $roomType->id || $roomTypeId == $roomType->id ? 'selected' : '' }}>{{ $roomType->name }} - ${{ number_format($roomType->base_price, 2) }}/night</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group mb-3">
                                        <label for="check_in_date">Check-in Date</label>
                                        <input type="date" class="form-control" id="check_in_date" name="check_in_date" value="{{ $checkInDate }}" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group mb-3">
                                        <label for="check_out_date">Check-out Date</label>
                                        <input type="date" class="form-control" id="check_out_date" name="check_out_date" value="{{ $checkOutDate }}" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group mb-3">
                                        <label for="adults">Adults</label>
                                        <select class="form-select" id="adults" name="adults">
                                            <option value="1" {{ old('adults') == 1 || $adults == 1 ? 'selected' : '' }}>1 Adult</option>
                                            <option value="2" {{ old('adults') == 2 || $adults == 2 ? 'selected' : '' }}>2 Adults</option>
                                            <option value="3" {{ old('adults') == 3 || $adults == 3 ? 'selected' : '' }}>3 Adults</option>
                                            <option value="4" {{ old('adults') == 4 || $adults == 4 ? 'selected' : '' }}>4 Adults</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group mb-3">
                                        <label for="children">Children</label>
                                        <select class="form-select" id="children" name="children">
                                            <option value="0" {{ old('children') == 0 || $children == 0 ? 'selected' : '' }}>No Children</option>
                                            <option value="1" {{ old('children') == 1 || $children == 1 ? 'selected' : '' }}>1 Child</option>
                                            <option value="2" {{ old('children') == 2 || $children == 2 ? 'selected' : '' }}>2 Children</option>
                                            <option value="3" {{ old('children') == 3 || $children == 3 ? 'selected' : '' }}>3 Children</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group mb-3">
                                        <label for="infants">Infants</label>
                                        <select class="form-select" id="infants" name="infants">
                                            <option value="0" {{ old('infants') == 0 ? 'selected' : '' }}>No Infants</option>
                                            <option value="1" {{ old('infants') == 1 ? 'selected' : '' }}>1 Infant</option>
                                            <option value="2" {{ old('infants') == 2 ? 'selected' : '' }}>2 Infants</option>
                                            <option value="3" {{ old('infants') == 3 ? 'selected' : '' }}>3 Infants</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group mb-3">
                                        <label for="guest_first_name">First Name</label>
                                        <input type="text" class="form-control" id="guest_first_name" name="guest_first_name" value="{{ old('guest_first_name') }}" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group mb-3">
                                        <label for="guest_last_name">Last Name</label>
                                        <input type="text" class="form-control" id="guest_last_name" name="guest_last_name" value="{{ old('guest_last_name') }}" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group mb-3">
                                        <label for="guest_email">Email</label>
                                        <input type="email" class="form-control" id="guest_email" name="guest_email" value="{{ old('guest_email') }}" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group mb-3">
                                        <label for="guest_phone">Phone</label>
                                        <input type="text" class="form-control" id="guest_phone" name="guest_phone" value="{{ old('guest_phone') }}" required>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-group mb-3">
                                        <label for="special_requests">Special Requests</label>
                                        <textarea class="form-control" id="special_requests" name="special_requests" rows="3">{{ old('special_requests') }}</textarea>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <button type="submit" class="btn-custom w-100">Continue to Payment</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection