@extends('backend.layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Create Event Booking</h3>
                    <div class="card-tools">
                        <a href="{{ route('event-bookings.index') }}" class="btn btn-default">
                            <i class="fas fa-arrow-left"></i> Back
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <form action="{{ route('event-bookings.store') }}" method="POST">
                        @csrf
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="event_id">Event <span class="text-danger">*</span></label>
                                    <select class="form-select @error('event_id') is-invalid @enderror" id="event_id" name="event_id" required>
                                        <option value="">Select Event</option>
                                        @foreach($events as $event)
                                            <option value="{{ $event->id }}" {{ old('event_id') == $event->id ? 'selected' : '' }}>{{ $event->name }} ({{ $event->start_date->format('d M Y') }})</option>
                                        @endforeach
                                    </select>
                                    @error('event_id')
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
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="number_of_attendees">Number of Attendees <span class="text-danger">*</span></label>
                                    <input type="number" class="form-control @error('number_of_attendees') is-invalid @enderror" id="number_of_attendees" name="number_of_attendees" value="{{ old('number_of_attendees', 1) }}" min="1" required>
                                    @error('number_of_attendees')
                                        <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                    @enderror
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
                        
                        <div class="form-group">
                            <label for="status">Status <span class="text-danger">*</span></label>
                            <select class="form-select @error('status') is-invalid @enderror" id="status" name="status" required>
                                <option value="pending" {{ old('status', 'pending') == 'pending' ? 'selected' : '' }}>Pending</option>
                                <option value="confirmed" {{ old('status') == 'confirmed' ? 'selected' : '' }}>Confirmed</option>
                                <option value="cancelled" {{ old('status') == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                            </select>
                            @error('status')
                                <span class="invalid-feedback" role="alert">{{ $message }}</span>
                            @enderror
                        </div>
                        
                        <div class="form-group">
                            <label for="special_requests">Special Requests</label>
                            <textarea class="form-control @error('special_requests') is-invalid @enderror" id="special_requests" name="special_requests" rows="3">{{ old('special_requests') }}</textarea>
                            @error('special_requests')
                                <span class="invalid-feedback" role="alert">{{ $message }}</span>
                            @enderror
                        </div>
                        
                        <div class="form-group">
                            <button type="submit" class="btn btn-primary">Create Event Booking</button>
                            <a href="{{ route('event-bookings.index') }}" class="btn btn-default">Cancel</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection