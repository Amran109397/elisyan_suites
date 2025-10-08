@extends('backend.layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Room Assignment Details</h3>
                    <div class="card-tools">
                        <a href="{{ route('room-assignments.edit', $roomAssignment->id) }}" class="btn btn-warning">
                            <i class="fas fa-edit"></i> Edit
                        </a>
                        <a href="{{ route('room-assignments.index') }}" class="btn btn-default">
                            <i class="fas fa-arrow-left"></i> Back
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <p><strong>Guest:</strong> {{ $roomAssignment->booking->guest->first_name }} {{ $roomAssignment->booking->guest->last_name }}</p>
                            <p><strong>Booking Reference:</strong> {{ $roomAssignment->booking->booking_reference }}</p>
                            <p><strong>Room:</strong> {{ $roomAssignment->room->room_number }}</p>
                            <p><strong>Room Type:</strong> {{ $roomAssignment->room->roomType->name }}</p>
                        </div>
                        <div class="col-md-6">
                            <p><strong>Assigned At:</strong> {{ $roomAssignment->assigned_at->format('d M Y, h:i A') }}</p>
                            <p><strong>Assigned By:</strong> {{ $roomAssignment->assignedBy->name }}</p>
                            <p><strong>Check-in Date:</strong> {{ $roomAssignment->booking->check_in_date->format('d M Y') }}</p>
                            <p><strong>Check-out Date:</strong> {{ $roomAssignment->booking->check_out_date->format('d M Y') }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection