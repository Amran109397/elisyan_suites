@extends('backend.layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Edit Booking</h3>
                    <div class="card-tools">
                        <a href="{{ route('bookings.index') }}" class="btn btn-default">
                            <i class="fas fa-arrow-left"></i> Back
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <form action="{{ route('bookings.update', $booking->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="property_id">Property <span class="text-danger">*</span></label>
                                    <select class="form-select @error('property_id') is-invalid @enderror" id="property_id" name="property_id" required>
                                        <option value="">Select Property</option>
                                        @foreach($properties as $property)
                                            <option value="{{ $property->id }}" {{ old('property_id', $booking->property_id) == $property->id ? 'selected' : '' }}>{{ $property->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('property_id')
                                        <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="guest_id">Guest <span class="text-danger">*</span></label>
                                    <select class="form-select @error('guest_id') is-invalid @enderror" id="guest_id" name="guest_id" required>
                                        <option value="">Select Guest</option>
                                        @foreach($guests as $guest)
                                            <option value="{{ $guest->id }}" {{ old('guest_id', $booking->guest_id) == $guest->id ? 'selected' : '' }}>{{ $guest->full_name }}</option>
                                        @endforeach
                                    </select>
                                    @error('guest_id')
                                        <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="room_type_id">Room Type <span class="text-danger">*</span></label>
                                    <select class="form-select @error('room_type_id') is-invalid @enderror" id="room_type_id" name="room_type_id" required>
                                        <option value="">Select Room Type</option>
                                        @foreach($roomTypes as $roomType)
                                            <option value="{{ $roomType->id }}" {{ old('room_type_id', $booking->room_type_id) == $roomType->id ? 'selected' : '' }}>{{ $roomType->name }} ({{ number_format($roomType->base_price, 2) }})</option>
                                        @endforeach
                                    </select>
                                    @error('room_type_id')
                                        <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="room_id">Room</label>
                                    <select class="form-select @error('room_id') is-invalid @enderror" id="room_id" name="room_id">
                                        <option value="">Select Room (Optional)</option>
                                        @foreach($rooms as $room)
                                            <option value="{{ $room->id }}" {{ old('room_id', $booking->room_id) == $room->id ? 'selected' : '' }}>{{ $room->room_number }}</option>
                                        @endforeach
                                    </select>
                                    @error('room_id')
                                        <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="check_in_date">Check-in Date <span class="text-danger">*</span></label>
                                    <input type="date" class="form-control @error('check_in_date') is-invalid @enderror" id="check_in_date" name="check_in_date" value="{{ old('check_in_date', $booking->check_in_date) }}" required>
                                    @error('check_in_date')
                                        <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="check_out_date">Check-out Date <span class="text-danger">*</span></label>
                                    <input type="date" class="form-control @error('check_out_date') is-invalid @enderror" id="check_out_date" name="check_out_date" value="{{ old('check_out_date', $booking->check_out_date) }}" required>
                                    @error('check_out_date')
                                        <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="adults">Adults <span class="text-danger">*</span></label>
                                    <input type="number" class="form-control @error('adults') is-invalid @enderror" id="adults" name="adults" value="{{ old('adults', $booking->adults) }}" min="1" required>
                                    @error('adults')
                                        <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="children">Children</label>
                                    <input type="number" class="form-control @error('children') is-invalid @enderror" id="children" name="children" value="{{ old('children', $booking->children) }}" min="0">
                                    @error('children')
                                        <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="infants">Infants</label>
                                    <input type="number" class="form-control @error('infants') is-invalid @enderror" id="infants" name="infants" value="{{ old('infants', $booking->infants) }}" min="0">
                                    @error('infants')
                                        <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="status">Status <span class="text-danger">*</span></label>
                                    <select class="form-select @error('status') is-invalid @enderror" id="status" name="status" required>
                                        <option value="pending" {{ old('status', $booking->status) == 'pending' ? 'selected' : '' }}>Pending</option>
                                        <option value="confirmed" {{ old('status') == 'confirmed' ? 'selected' : '' }}>Confirmed</option>
                                        <option value="checked_in" {{ old('status') == 'checked_in' ? 'selected' : '' }}>Checked In</option>
                                        <option value="checked_out" {{ old('status') == 'checked_out' ? 'selected' : '' }}>Checked Out</option>
                                        <option value="cancelled" {{ old('status') == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                                        <option value="no_show" {{ old('status') == 'no_show' ? 'selected' : '' }}>No Show</option>
                                    </select>
                                    @error('status')
                                        <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="booking_source">Booking Source <span class="text-danger">*</span></label>
                                    <select class="form-select @error('booking_source') is-invalid @enderror" id="booking_source" name="booking_source" required>
                                        <option value="website" {{ old('booking_source', $booking->booking_source) == 'website' ? 'selected' : '' }}>Website</option>
                                        <option value="walk_in" {{ old('booking_source') == 'walk_in' ? 'selected' : '' }}>Walk In</option>
                                        <option value="phone" {{ old('booking_source') == 'phone' ? 'selected' : '' }}>Phone</option>
                                        <option value="ota" {{ old('booking_source') == 'ota' ? 'selected' : '' }}>OTA</option>
                                        <option value="travel_agent" {{ old('booking_source') == 'travel_agent' ? 'selected' : '' }}>Travel Agent</option>
                                        <option value="corporate" {{ old('booking_source') == 'corporate' ? 'selected' : '' }}>Corporate</option>
                                    </select>
                                    @error('booking_source')
                                        <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="total_price">Total Price <span class="text-danger">*</span></label>
                            <input type="number" class="form-control @error('total_price') is-invalid @enderror" id="total_price" name="total_price" value="{{ old('total_price', $booking->total_price) }}" step="0.01" min="0" required>
                            @error('total_price')
                                <span class="invalid-feedback" role="alert">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="special_requests">Special Requests</label>
                            <textarea class="form-control @error('special_requests') is-invalid @enderror" id="special_requests" name="special_requests" rows="3">{{ old('special_requests', $booking->special_requests) }}</textarea>
                            @error('special_requests')
                                <span class="invalid-feedback" role="alert">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn btn-primary">Update Booking</button>
                            <a href="{{ route('bookings.index') }}" class="btn btn-default">Cancel</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection