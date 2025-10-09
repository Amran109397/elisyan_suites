@extends('backend.layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Resource Details</h3>
                    <div class="card-tools">
                        <a href="{{ route('resources.edit', $resource->id) }}" class="btn btn-warning">
                            <i class="fas fa-edit"></i> Edit
                        </a>
                        <a href="{{ route('resources.index') }}" class="btn btn-default">
                            <i class="fas fa-arrow-left"></i> Back
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="info-box bg-light">
                                <div class="info-box-content">
                                    <span class="info-box-text">Resource ID</span>
                                    <span class="info-box-number">#{{ $resource->id }}</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="info-box bg-light">
                                <div class="info-box-content">
                                    <span class="info-box-text">Status</span>
                                    <span class="info-box-number">
                                        <span class="badge bg-{{ $resource->is_active ? 'success' : 'danger' }}">
                                            {{ $resource->is_active ? 'Active' : 'Inactive' }}
                                        </span>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="row mt-4">
                        <div class="col-md-6">
                            <h5>Resource Information</h5>
                            <table class="table table-bordered">
                                <tr>
                                    <th width="30%">Name</th>
                                    <td>{{ $resource->name }}</td>
                                </tr>
                                <tr>
                                    <th>Property</th>
                                    <td>{{ $resource->property->name }}</td>
                                </tr>
                                <tr>
                                    <th>Type</th>
                                    <td>{{ ucfirst($resource->type) }}</td>
                                </tr>
                                <tr>
                                    <th>Capacity</th>
                                    <td>{{ $resource->capacity ?: 'N/A' }}</td>
                                </tr>
                            </table>
                        </div>
                        
                        <div class="col-md-6">
                            <h5>Additional Information</h5>
                            <table class="table table-bordered">
                                <tr>
                                    <th width="30%">Created At</th>
                                    <td>{{ $resource->created_at->format('d M Y, H:i:s') }}</td>
                                </tr>
                                <tr>
                                    <th>Updated At</th>
                                    <td>{{ $resource->updated_at->format('d M Y, H:i:s') }}</td>
                                </tr>
                            </table>
                            
                            @if($resource->description)
                            <div class="mt-3">
                                <h6>Description</h6>
                                <div class="bg-light p-3">
                                    {{ $resource->description }}
                                </div>
                            </div>
                            @endif
                        </div>
                    </div>
                    
                    <div class="row mt-4">
                        <div class="col-12">
                            <h5>Event Usage</h5>
                            @if($resource->eventResources->count() > 0)
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th>Event</th>
                                            <th>Date</th>
                                            <th>Quantity</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($resource->eventResources as $eventResource)
                                        <tr>
                                            <td>{{ $eventResource->event->name }}</td>
                                            <td>{{ $eventResource->event->start_date->format('d M Y') }}</td>
                                            <td>{{ $eventResource->quantity }}</td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            @else
                                <p>This resource has not been used in any events yet.</p>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection