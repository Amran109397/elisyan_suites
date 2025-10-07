@extends('backend.layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Room Details</h3>
                    <div class="card-tools">
                        <a href="{{ route('rooms.edit', $room->id) }}" class="btn btn-warning">
                            <i class="fas fa-edit"></i> Edit
                        </a>
                        <a href="{{ route('rooms.index') }}" class="btn btn-default">
                            <i class="fas fa-arrow-left"></i> Back
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <p><strong>Room Number:</strong> {{ $room->room_number }}</p>
                            <p><strong>Property:</strong> {{ $room->property->name }}</p>
                            <p><strong>Room Type:</strong> {{ $room->roomType->name }}</p>
                            <p><strong>Floor:</strong> {{ $room->floor->name }}</p>
                        </div>
                        <div class="col-md-6">
                            <p><strong>Status:</strong> 
                                <span class="badge bg-{{ $room->status == 'available' ? 'success' : ($room->status == 'occupied' ? 'primary' : 'warning') }}">
                                    {{ ucfirst($room->status) }}
                                </span>
                            </p>
                            <p><strong>Smoking:</strong> {{ $room->is_smoking ? 'Yes' : 'No' }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="row mt-4">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title">Current Booking</h5>
                </div>
                <div class="card-body">
                    @if($room->currentBooking)
                        <p><strong>Guest:</strong> {{ $room->currentBooking->guest->full_name }}</p>
                        <p><strong>Check-in:</strong> {{ $room->currentBooking->check_in_date }}</p>
                        <p><strong>Check-out:</strong> {{ $room->currentBooking->check_out_date }}</p>
                    @else
                        <p>No current booking.</p>
                    @endif
                </div>
            </div>
        </div>
        
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title">Status Update</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('rooms.update-status', $room->id) }}" method="POST">
                        @csrf
                        <div class="form-group">
                            <label for="status">Status</label>
                            <select class="form-select" id="status" name="status" required>
                                <option value="available" {{ $room->status == 'available' ? 'selected' : '' }}>Available</option>
                                <option value="occupied" {{ $room->status == 'occupied' ? 'selected' : '' }}>Occupied</option>
                                <option value="maintenance" {{ $room->status == 'maintenance' ? 'selected' : '' }}>Maintenance</option>
                                <option value="cleaning" {{ $room->status == 'cleaning' ? 'selected' : '' }}>Cleaning</option>
                                <option value="out_of_service" {{ $room->status == 'out_of_service' ? 'selected' : '' }}>Out of Service</option>
                                <option value="blocked" {{ $room->status == 'blocked' ? 'selected' : '' }}>Blocked</option>
                                <option value="renovation" {{ $room->status == 'renovation' ? 'selected' : '' }}>Renovation</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="notes">Notes</label>
                            <textarea class="form-control" id="notes" name="notes" rows="3"></textarea>
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn btn-primary">Update Status</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection