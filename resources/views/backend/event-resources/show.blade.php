@extends('backend.layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Event Resource Details</h3>
                    <div class="card-tools">
                        <a href="{{ route('event-resources.edit', $eventResource->id) }}" class="btn btn-warning">
                            <i class="fas fa-edit"></i> Edit
                        </a>
                        <a href="{{ route('event-resources.index') }}" class="btn btn-default">
                            <i class="fas fa-arrow-left"></i> Back
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="info-box bg-light">
                                <div class="info-box-content">
                                    <span class="info-box-text">Event Resource ID</span>
                                    <span class="info-box-number">#{{ $eventResource->id }}</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="info-box bg-light">
                                <div class="info-box-content">
                                    <span class="info-box-text">Quantity</span>
                                    <span class="info-box-number">{{ $eventResource->quantity }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="row mt-4">
                        <div class="col-md-6">
                            <h5>Event Information</h5>
                            <table class="table table-bordered">
                                <tr>
                                    <th width="30%">Event Name</th>
                                    <td>{{ $eventResource->event->name }}</td>
                                </tr>
                                <tr>
                                    <th>Event Date</th>
                                    <td>{{ $eventResource->event->start_date->format('d M Y') }}</td>
                                </tr>
                                <tr>
                                    <th>Event Status</th>
                                    <td>
                                        <span class="badge bg-{{ $eventResource->event->status == 'completed' ? 'success' : ($eventResource->event->status == 'cancelled' ? 'danger' : ($eventResource->event->status == 'ongoing' ? 'info' : 'warning')) }}">
                                            {{ ucfirst($eventResource->event->status) }}
                                        </span>
                                    </td>
                                </tr>
                            </table>
                        </div>
                        
                        <div class="col-md-6">
                            <h5>Resource Information</h5>
                            <table class="table table-bordered">
                                <tr>
                                    <th width="30%">Resource Name</th>
                                    <td>{{ $eventResource->resource->name }}</td>
                                </tr>
                                <tr>
                                    <th>Resource Type</th>
                                    <td>{{ ucfirst($eventResource->resource->type) }}</td>
                                </tr>
                                <tr>
                                    <th>Resource Capacity</th>
                                    <td>{{ $eventResource->resource->capacity ?: 'N/A' }}</td>
                                </tr>
                                <tr>
                                    <th>Resource Status</th>
                                    <td>
                                        <span class="badge bg-{{ $eventResource->resource->is_active ? 'success' : 'danger' }}">
                                            {{ $eventResource->resource->is_active ? 'Active' : 'Inactive' }}
                                        </span>
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>
                    
                    <div class="row mt-4">
                        <div class="col-12">
                            <h5>Additional Information</h5>
                            <table class="table table-bordered">
                                <tr>
                                    <th width="30%">Created At</th>
                                    <td>{{ $eventResource->created_at->format('d M Y, H:i:s') }}</td>
                                </tr>
                                <tr>
                                    <th>Updated At</th>
                                    <td>{{ $eventResource->updated_at->format('d M Y, H:i:s') }}</td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection