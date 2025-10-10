@extends('backend.layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Create Booking</h3>
                    <div class="card-tools">
                        <a href="{{ route('bookings.index') }}" class="btn btn-default">
                            <i class="fas fa-arrow-left"></i> Back
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <form action="{{ route('bookings.store') }}" method="POST" id="bookingForm">
                        @csrf
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="property_id">Property <span class="text-danger">*</span></label>
                                    <select class="form-select @error('property_id') is-invalid @enderror" id="property_id" name="property_id" required>
                                        <option value="">Select Property</option>
                                        @foreach($properties as $property)
                                            <option value="{{ $property->id }}" {{ old('property_id') == $property->id ? 'selected' : '' }}>{{ $property->name }}</option>
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
                                            <option value="{{ $guest->id }}" {{ old('guest_id') == $guest->id ? 'selected' : '' }}>{{ $guest->full_name }}</option>
                                        @endforeach
                                    </select>
                                    @error('guest_id')
                                        <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="room_type_id">Room Type <span class="text-danger">*</span></label>
                                    <select class="form-select @error('room_type_id') is-invalid @enderror" id="room_type_id" name="room_type_id" required>
                                        <option value="">Select Room Type</option>
                                        @foreach($roomTypes as $roomType)
                                            <option value="{{ $roomType->id }}" data-price="{{ $roomType->base_price }}" {{ old('room_type_id') == $roomType->id ? 'selected' : '' }}>
                                                {{ $roomType->name }} (${{ number_format($roomType->base_price, 2) }})
                                            </option>
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
                                    </select>
                                    @error('room_id')
                                        <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="check_in_date">Check-in Date <span class="text-danger">*</span></label>
                                    <input type="date" class="form-control @error('check_in_date') is-invalid @enderror" id="check_in_date" name="check_in_date" value="{{ old('check_in_date') }}" required>
                                    @error('check_in_date')
                                        <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="check_out_date">Check-out Date <span class="text-danger">*</span></label>
                                    <input type="date" class="form-control @error('check_out_date') is-invalid @enderror" id="check_out_date" name="check_out_date" value="{{ old('check_out_date') }}" required>
                                    @error('check_out_date')
                                        <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="adults">Adults <span class="text-danger">*</span></label>
                                    <input type="number" class="form-control @error('adults') is-invalid @enderror" id="adults" name="adults" value="{{ old('adults', 1) }}" min="1" required>
                                    @error('adults')
                                        <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="children">Children</label>
                                    <input type="number" class="form-control @error('children') is-invalid @enderror" id="children" name="children" value="{{ old('children', 0) }}" min="0">
                                    @error('children')
                                        <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="infants">Infants</label>
                                    <input type="number" class="form-control @error('infants') is-invalid @enderror" id="infants" name="infants" value="{{ old('infants', 0) }}" min="0">
                                    @error('infants')
                                        <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="status">Status <span class="text-danger">*</span></label>
                                    <select class="form-select @error('status') is-invalid @enderror" id="status" name="status" required>
                                        <option value="pending" {{ old('status', 'pending') == 'pending' ? 'selected' : '' }}>Pending</option>
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
                                        <option value="website" {{ old('booking_source', 'website') == 'website' ? 'selected' : '' }}>Website</option>
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
                        <div class="row mt-3">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="total_nights">Total Nights</label>
                                    <input type="number" class="form-control" id="total_nights" name="total_nights" readonly>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="total_price">Total Price <span class="text-danger">*</span></label>
                                    <input type="number" class="form-control @error('total_price') is-invalid @enderror" id="total_price" name="total_price" value="{{ old('total_price') }}" step="0.01" min="0" required>
                                    @error('total_price')
                                        <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="form-group mt-3">
                            <label for="special_requests">Special Requests</label>
                            <textarea class="form-control @error('special_requests') is-invalid @enderror" id="special_requests" name="special_requests" rows="3">{{ old('special_requests') }}</textarea>
                            @error('special_requests')
                                <span class="invalid-feedback" role="alert">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group mt-4">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save"></i> Create Booking
                            </button>
                            <a href="{{ route('bookings.index') }}" class="btn btn-default">
                                <i class="fas fa-times"></i> Cancel
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
$(document).ready(function() {
    // Calculate nights and price when dates change
    function calculateBookingDetails() {
        const checkInDate = $('#check_in_date').val();
        const checkOutDate = $('#check_out_date').val();
        const roomTypeId = $('#room_type_id').val();
        
        if (checkInDate && checkOutDate) {
            const checkIn = new Date(checkInDate);
            const checkOut = new Date(checkOutDate);
            const timeDiff = checkOut.getTime() - checkIn.getTime();
            const nights = Math.ceil(timeDiff / (1000 * 3600 * 24));
            
            $('#total_nights').val(nights);
            
            // Calculate price if room type is selected
            if (roomTypeId && nights > 0) {
                const selectedRoomType = $('#room_type_id option:selected');
                const basePrice = selectedRoomType.data('price');
                const totalPrice = basePrice * nights;
                $('#total_price').val(totalPrice.toFixed(2));
            }
        }
    }

    // Date change handlers
    $('#check_in_date, #check_out_date').on('change', function() {
        calculateBookingDetails();
        checkRoomAvailability();
    });

    // Room type change handler
    $('#room_type_id').on('change', function() {
        calculateBookingDetails();
        checkRoomAvailability();
    });

    // Property change handler
    $('#property_id').on('change', function() {
        const propertyId = $(this).val();
        $('#room_id').html('<option value="">Select Room (Optional)</option>');
        
        if (propertyId) {
            // You can add AJAX call here to load room types based on property
        }
    });

    // Check room availability
    function checkRoomAvailability() {
        const propertyId = $('#property_id').val();
        const roomTypeId = $('#room_type_id').val();
        const checkInDate = $('#check_in_date').val();
        const checkOutDate = $('#check_out_date').val();
        
        if (propertyId && roomTypeId && checkInDate && checkOutDate) {
            $.ajax({
                url: '{{ route("bookings.check-availability") }}',
                type: 'GET',
                data: {
                    property_id: propertyId,
                    room_type_id: roomTypeId,
                    check_in_date: checkInDate,
                    check_out_date: checkOutDate
                },
                success: function(response) {
                    $('#room_id').html('<option value="">Select Room (Optional)</option>');
                    if (response.rooms && response.rooms.length > 0) {
                        $.each(response.rooms, function(key, room) {
                            $('#room_id').append('<option value="' + room.id + '">' + room.room_number + '</option>');
                        });
                    } else {
                        $('#room_id').append('<option value="">No rooms available</option>');
                    }
                },
                error: function() {
                    $('#room_id').html('<option value="">Error loading rooms</option>');
                }
            });
        }
    }

    // Form validation
    $('#bookingForm').on('submit', function(e) {
        const checkInDate = $('#check_in_date').val();
        const checkOutDate = $('#check_out_date').val();
        
        if (checkInDate && checkOutDate) {
            const checkIn = new Date(checkInDate);
            const checkOut = new Date(checkOutDate);
            const today = new Date();
            today.setHours(0, 0, 0, 0);
            
            if (checkIn < today) {
                e.preventDefault();
                alert('Check-in date cannot be in the past.');
                return false;
            }
            
            if (checkOut <= checkIn) {
                e.preventDefault();
                alert('Check-out date must be after check-in date.');
                return false;
            }
        }
    });

    // Set minimum date for check-in to today
    const today = new Date().toISOString().split('T')[0];
    $('#check_in_date').attr('min', today);
    $('#check_out_date').attr('min', today);
});
</script>
@endpush