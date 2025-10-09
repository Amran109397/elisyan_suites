@extends('backend.layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Event Details</h3>
                    <div class="card-tools">
                        <a href="{{ route('events.edit', $event->id) }}" class="btn btn-warning">
                            <i class="fas fa-edit"></i> Edit
                        </a>
                        <a href="{{ route('events.index') }}" class="btn btn-default">
                            <i class="fas fa-arrow-left"></i> Back
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="info-box bg-light">
                                <div class="info-box-content">
                                    <span class="info-box-text">Event ID</span>
                                    <span class="info-box-number">#{{ $event->id }}</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="info-box bg-light">
                                <div class="info-box-content">
                                    <span class="info-box-text">Status</span>
                                    <span class="info-box-number">
                                        <span class="badge bg-{{ $event->status == 'completed' ? 'success' : ($event->status == 'cancelled' ? 'danger' : ($event->status == 'ongoing' ? 'info' : ($event->status == 'published' ? 'primary' : 'secondary'))) }}">
                                            {{ ucfirst($event->status) }}
                                        </span>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="row mt-4">
                        <div class="col-md-6">
                            <h5>Event Information</h5>
                            <table class="table table-bordered">
                                <tr>
                                    <th width="30%">Name</th>
                                    <td>{{ $event->name }}</td>
                                </tr>
                                <tr>
                                    <th>Property</th>
                                    <td>{{ $event->property->name }}</td>
                                </tr>
                                <tr>
                                    <th>Start Date</th>
                                    <td>{{ $event->start_date->format('d M Y, H:i') }}</td>
                                </tr>
                                <tr>
                                    <th>End Date</th>
                                    <td>{{ $event->end_date->format('d M Y, H:i') }}</td>
                                </tr>
                                <tr>
                                    <th>Capacity</th>
                                    <td>{{ $event->capacity ?: 'Unlimited' }}</td>
                                </tr>
                                <tr>
                                    <th>Setup Time</th>
                                    <td>{{ $event->setup_time }} minutes</td>
                                </tr>
                                <tr>
                                    <th>Cleanup Time</th>
                                    <td>{{ $event->cleanup_time }} minutes</td>
                                </tr>
                            </table>
                        </div>
                        
                        <div class="col-md-6">
                            <h5>Additional Information</h5>
                            <table class="table table-bordered">
                                <tr>
                                    <th width="30%">Created By</th>
                                    <td>{{ $event->createdBy->name }}</td>
                                </tr>
                                <tr>
                                    <th>Created At</th>
                                    <td>{{ $event->created_at->format('d M Y, H:i:s') }}</td>
                                </tr>
                                <tr>
                                    <th>Updated At</th>
                                    <td>{{ $event->updated_at->format('d M Y, H:i:s') }}</td>
                                </tr>
                            </table>
                            
                            @if($event->description)
                            <div class="mt-3">
                                <h6>Description</h6>
                                <div class="bg-light p-3">
                                    {{ $event->description }}
                                </div>
                            </div>
                            @endif
                        </div>
                    </div>
                    
                    <div class="row mt-4">
                        <div class="col-md-6">
                            <h5>Assigned Resources</h5>
                            @if($event->eventResources->count() > 0)
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th>Resource</th>
                                            <th>Type</th>
                                            <th>Quantity</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($event->eventResources as $eventResource)
                                        <tr>
                                            <td>{{ $eventResource->resource->name }}</td>
                                            <td>{{ ucfirst($eventResource->resource->type) }}</td>
                                            <td>{{ $eventResource->quantity }}</td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            @else
                                <p>No resources assigned to this event.</p>
                            @endif
                        </div>
                        
                        <div class="col-md-6">
                            <h5>Event Bookings</h5>
                            @if($event->bookings->count() > 0)
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th>Guest</th>
                                            <th>Attendees</th>
                                            <th>Status</th>
                                            <th>Total Price</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($event->bookings as $booking)
                                        <tr>
                                            <td>{{ $booking->guest->full_name }}</td>
                                            <td>{{ $booking->number_of_attendees }}</td>
                                            <td>
                                                <span class="badge bg-{{ $booking->status == 'confirmed' ? 'success' : ($booking->status == 'cancelled' ? 'danger' : 'warning') }}">
                                                    {{ ucfirst($booking->status) }}
                                                </span>
                                            </td>
                                            <td>{{ number_format($booking->total_price, 2) }}</td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            @else
                                <p>No bookings for this event yet.</p>
                            @endif
                        </div>
                    </div>
                    
                    <div class="row mt-4">
                        <div class="col-12">
                            <h5>Event Actions</h5>
                            <div class="btn-group">
                                @if($event->status == 'draft')
                                    <a href="{{ route('events.publish', $event->id) }}" class="btn btn-primary">
                                        <i class="fas fa-paper-plane"></i> Publish Event
                                    </a>
                                @endif
                                
                                @if($event->status == 'published')
                                    <a href="{{ route('events.start', $event->id) }}" class="btn btn-info">
                                        <i class="fas fa-play"></i> Start Event
                                    </a>
                                @endif
                                
                                @if($event->status == 'ongoing')
                                    <a href="{{ route('events.complete', $event->id) }}" class="btn btn-success">
                                        <i class="fas fa-check"></i> Complete Event
                                    </a>
                                @endif
                                
                                @if(!in_array($event->status, ['completed', 'cancelled']))
                                    <a href="{{ route('events.cancel', $event->id) }}" class="btn btn-danger" onclick="return confirm('Are you sure you want to cancel this event?')">
                                        <i class="fas fa-times"></i> Cancel Event
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