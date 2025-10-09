@extends('backend.layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Therapist Details</h3>
                    <div class="card-tools">
                        <a href="{{ route('therapists.edit', $therapist->id) }}" class="btn btn-warning">
                            <i class="fas fa-edit"></i> Edit
                        </a>
                        <a href="{{ route('therapists.index') }}" class="btn btn-default">
                            <i class="fas fa-arrow-left"></i> Back
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="info-box bg-light">
                                <div class="info-box-content">
                                    <span class="info-box-text">Therapist ID</span>
                                    <span class="info-box-number">#{{ $therapist->id }}</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="info-box bg-light">
                                <div class="info-box-content">
                                    <span class="info-box-text">Status</span>
                                    <span class="info-box-number">
                                        <span class="badge bg-{{ $therapist->is_active ? 'success' : 'danger' }}">
                                            {{ $therapist->is_active ? 'Active' : 'Inactive' }}
                                        </span>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="row mt-4">
                        <div class="col-md-6">
                            <h5>Personal Information</h5>
                            <table class="table table-bordered">
                                <tr>
                                    <th width="30%">Name</th>
                                    <td>{{ $therapist->name }}</td>
                                </tr>
                                <tr>
                                    <th>Email</th>
                                    <td>{{ $therapist->email }}</td>
                                </tr>
                                <tr>
                                    <th>Phone</th>
                                    <td>{{ $therapist->phone }}</td>
                                </tr>
                                <tr>
                                    <th>Property</th>
                                    <td>{{ $therapist->property->name }}</td>
                                </tr>
                                <tr>
                                    <th>Specialization</th>
                                    <td>{{ $therapist->specialization ?: 'N/A' }}</td>
                                </tr>
                            </table>
                        </div>
                        
                        <div class="col-md-6">
                            <h5>Additional Information</h5>
                            <table class="table table-bordered">
                                <tr>
                                    <th width="30%">Created At</th>
                                    <td>{{ $therapist->created_at->format('d M Y, H:i:s') }}</td>
                                </tr>
                                <tr>
                                    <th>Updated At</th>
                                    <td>{{ $therapist->updated_at->format('d M Y, H:i:s') }}</td>
                                </tr>
                            </table>
                        </div>
                    </div>
                    
                    <div class="row mt-4">
                        <div class="col-12">
                            <h5>Recent Appointments</h5>
                            @if($therapist->appointments->count() > 0)
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Guest</th>
                                            <th>Treatment</th>
                                            <th>Date & Time</th>
                                            <th>Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($therapist->appointments->take(5) as $appointment)
                                        <tr>
                                            <td>{{ $appointment->id }}</td>
                                            <td>{{ $appointment->guest->full_name }}</td>
                                            <td>{{ $appointment->treatment->name }}</td>
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
                                <p>No appointments found for this therapist.</p>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection