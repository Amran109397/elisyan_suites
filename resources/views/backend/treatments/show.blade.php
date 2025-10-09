@extends('backend.layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Treatment Details</h3>
                    <div class="card-tools">
                        <a href="{{ route('treatments.edit', $treatment->id) }}" class="btn btn-warning">
                            <i class="fas fa-edit"></i> Edit
                        </a>
                        <a href="{{ route('treatments.index') }}" class="btn btn-default">
                            <i class="fas fa-arrow-left"></i> Back
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="info-box bg-light">
                                <div class="info-box-content">
                                    <span class="info-box-text">Treatment ID</span>
                                    <span class="info-box-number">#{{ $treatment->id }}</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="info-box bg-light">
                                <div class="info-box-content">
                                    <span class="info-box-text">Status</span>
                                    <span class="info-box-number">
                                        <span class="badge bg-{{ $treatment->is_active ? 'success' : 'danger' }}">
                                            {{ $treatment->is_active ? 'Active' : 'Inactive' }}
                                        </span>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="row mt-4">
                        <div class="col-md-6">
                            <h5>Treatment Information</h5>
                            <table class="table table-bordered">
                                <tr>
                                    <th width="30%">Name</th>
                                    <td>{{ $treatment->name }}</td>
                                </tr>
                                <tr>
                                    <th>Property</th>
                                    <td>{{ $treatment->property->name }}</td>
                                </tr>
                                <tr>
                                    <th>Duration</th>
                                    <td>{{ $treatment->duration }} minutes</td>
                                </tr>
                                <tr>
                                    <th>Price</th>
                                    <td>{{ number_format($treatment->price, 2) }}</td>
                                </tr>
                            </table>
                        </div>
                        
                        <div class="col-md-6">
                            <h5>Additional Information</h5>
                            <table class="table table-bordered">
                                <tr>
                                    <th width="30%">Created By</th>
                                    <td>{{ $treatment->createdBy->name }}</td>
                                </tr>
                                <tr>
                                    <th>Created At</th>
                                    <td>{{ $treatment->created_at->format('d M Y, H:i:s') }}</td>
                                </tr>
                                <tr>
                                    <th>Updated At</th>
                                    <td>{{ $treatment->updated_at->format('d M Y, H:i:s') }}</td>
                                </tr>
                            </table>
                            
                            @if($treatment->description)
                            <div class="mt-3">
                                <h6>Description</h6>
                                <div class="bg-light p-3">
                                    {{ $treatment->description }}
                                </div>
                            </div>
                            @endif
                        </div>
                    </div>
                    
                    <div class="row mt-4">
                        <div class="col-12">
                            <h5>Recent Appointments</h5>
                            @if($treatment->appointments->count() > 0)
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Guest</th>
                                            <th>Therapist</th>
                                            <th>Date & Time</th>
                                            <th>Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($treatment->appointments->take(5) as $appointment)
                                        <tr>
                                            <td>{{ $appointment->id }}</td>
                                            <td>{{ $appointment->guest->full_name }}</td>
                                            <td>{{ $appointment->therapist->name }}</td>
                                            <td>{{ $appointment->date->format('d M Y') }} at {{ $appointment->time->format('H:i') }}</td>
                                            <td>
                                                <span class="badge bg-{{ $appointment->status == 'completed' ? 'success' : ($appointment->status == 'cancelled' ? 'danger' : 'warning') }}">
                                                    {{ ucfirst(str_replace('_', ' ', $appointment->status)) }}
                                                </span>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            @else
                                <p>No appointments found for this treatment.</p>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection