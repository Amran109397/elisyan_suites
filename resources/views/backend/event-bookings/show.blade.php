@extends('backend.layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Event Booking Details</h3>
                    <div class="card-tools">
                        <a href="{{ route('event-bookings.edit', $eventBooking->id) }}" class="btn btn-warning">
                            <i class="fas fa-edit"></i> Edit
                        </a>
                        <a href="{{ route('event-bookings.index') }}" class="btn btn-default">
                            <i class="fas fa-arrow-left"></i> Back
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="info-box bg-light">
                                <div class="info-box-content">
                                    <span class="info-box-text">Event Booking ID</span>
                                    <span class="info-box-number">#{{ $eventBooking->id }}</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="info-box bg-light">
                                <div class="info-box-content">
                                    <span class="info-box-text">Status</span>
                                    <span class="info-box-number">
                                        <span class="badge bg-{{ $eventBooking->status == 'confirmed' ? 'success' : ($eventBooking->status == 'cancelled' ? 'danger' : 'warning') }}">
                                            {{ ucfirst($eventBooking->status) }}
                                        </span>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="row mt-4">
                        <div class="col-md-6">
                            <h5>Booking Information</h5>
                            <table class="table table-bordered">
                                <tr>
                                    <th width="30%">Event</th>
                                    <td>{{ $eventBooking->event->name }}</td>
                                </tr>
                                <tr>
                                    <th>Event Date</th>
                                    <td>{{ $eventBooking->event->start_date->format('d M Y, H:i') }} - {{ $eventBooking->event->end_date->format('d M Y, H:i') }}</td>
                                </tr>
                                <tr>
                                    <th>Guest</th>
                                    <td>{{ $eventBooking->guest->full_name }}</td>
                                </tr>
                                <tr>
                                    <th>Number of Attendees</th>
                                    <td>{{ $eventBooking->number_of_attendees }}</td>
                                </tr>
                                <tr>
                                    <th>Total Price</th>
                                    <td>{{ number_format($eventBooking->total_price, 2) }}</td>
                                </tr>
                            </table>
                        </div>
                        
                        <div class="col-md-6">
                            <h5>Additional Information</h5>
                            <table class="table table-bordered">
                                <tr>
                                    <th width="30%">Created By</th>
                                    <td>{{ $eventBooking->createdBy->name }}</td>
                                </tr>
                                <tr>
                                    <th>Created At</th>
                                    <td>{{ $eventBooking->created_at->format('d M Y, H:i:s') }}</td>
                                </tr>
                                <tr>
                                    <th>Updated At</th>
                                    <td>{{ $eventBooking->updated_at->format('d M Y, H:i:s') }}</td>
                                </tr>
                            </table>
                            
                            @if($eventBooking->special_requests)
                            <div class="mt-3">
                                <h6>Special Requests</h6>
                                <div class="bg-light p-3">
                                    {{ $eventBooking->special_requests }}
                                </div>
                            </div>
                            @endif
                        </div>
                    </div>
                    
                    <div class="row mt-4">
                        <div class="col-12">
                            <h5>Booking Actions</h5>
                            <div class="btn-group">
                                @if($eventBooking->status == 'pending')
                                    <a href="{{ route('event-bookings.confirm', $eventBooking->id) }}" class="btn btn-success">
                                        <i class="fas fa-check"></i> Confirm Booking
                                    </a>
                                @endif
                                
                                @if(!in_array($eventBooking->status, ['cancelled']))
                                    <a href="{{ route('event-bookings.cancel', $eventBooking->id) }}" class="btn btn-danger" onclick="return confirm('Are you sure you want to cancel this booking?')">
                                        <i class="fas fa-times"></i> Cancel Booking
                                    </a>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection