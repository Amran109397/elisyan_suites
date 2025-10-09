@extends('backend.layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Appointment Details</h3>
                    <div class="card-tools">
                        <a href="{{ route('appointments.edit', $appointment->id) }}" class="btn btn-warning">
                            <i class="fas fa-edit"></i> Edit
                        </a>
                        <a href="{{ route('appointments.index') }}" class="btn btn-default">
                            <i class="fas fa-arrow-left"></i> Back
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="info-box bg-light">
                                <div class="info-box-content">
                                    <span class="info-box-text">Appointment ID</span>
                                    <span class="info-box-number">#{{ $appointment->id }}</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="info-box bg-light">
                                <div class="info-box-content">
                                    <span class="info-box-text">Status</span>
                                    <span class="info-box-number">
                                        <span class="badge bg-{{ $appointment->status == 'completed' ? 'success' : ($appointment->status == 'cancelled' ? 'danger' : ($appointment->status == 'confirmed' ? 'info' : 'warning')) }}">
                                            {{ ucfirst(str_replace('_', ' ', $appointment->status)) }}
                                        </span>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="row mt-4">
                        <div class="col-md-6">
                            <h5>Appointment Information</h5>
                            <table class="table table-bordered">
                                <tr>
                                    <th width="30%">Guest</th>
                                    <td>{{ $appointment->guest->full_name }}</td>
                                </tr>
                                <tr>
                                    <th>Treatment</th>
                                    <td>{{ $appointment->treatment->name }} ({{ $appointment->treatment->duration }} min)</td>
                                </tr>
                                <tr>
                                    <th>Therapist</th>
                                    <td>{{ $appointment->therapist->name }}</td>
                                </tr>
                                <tr>
                                    <th>Date</th>
                                    <td>{{ $appointment->date->format('d M Y') }}</td>
                                </tr>
                                <tr>
                                    <th>Time</th>
                                    <td>{{ $appointment->time->format('H:i') }}</td>
                                </tr>
                                <tr>
                                    <th>Property</th>
                                    <td>{{ $appointment->property->name }}</td>
                                </tr>
                            </table>
                        </div>
                        
                        <div class="col-md-6">
                            <h5>Additional Information</h5>
                            <table class="table table-bordered">
                                <tr>
                                    <th width="30%">Created By</th>
                                    <td>{{ $appointment->createdBy->name }}</td>
                                </tr>
                                <tr>
                                    <th>Created At</th>
                                    <td>{{ $appointment->created_at->format('d M Y, H:i:s') }}</td>
                                </tr>
                                <tr>
                                    <th>Updated At</th>
                                    <td>{{ $appointment->updated_at->format('d M Y, H:i:s') }}</td>
                                </tr>
                            </table>
                            
                            @if($appointment->notes)
                            <div class="mt-3">
                                <h6>Notes</h6>
                                <div class="bg-light p-3">
                                    {{ $appointment->notes }}
                                </div>
                            </div>
                            @endif
                        </div>
                    </div>
                    
                    <div class="row mt-4">
                        <div class="col-12">
                            <h5>Appointment Actions</h5>
                            <div class="btn-group">
                                @if($appointment->status == 'scheduled')
                                    <a href="{{ route('appointments.confirm', $appointment->id) }}" class="btn btn-success">
                                        <i class="fas fa-check"></i> Confirm Appointment
                                    </a>
                                @endif
                                
                                @if($appointment->status == 'confirmed')
                                    <a href="{{ route('appointments.start', $appointment->id) }}" class="btn btn-info">
                                        <i class="fas fa-play"></i> Start Appointment
                                    </a>
                                @endif
                                
                                @if($appointment->status == 'in_progress')
                                    <a href="{{ route('appointments.complete', $appointment->id) }}" class="btn btn-success">
                                        <i class="fas fa-check"></i> Complete Appointment
                                    </a>
                                @endif
                                
                                @if(!in_array($appointment->status, ['completed', 'cancelled']))
                                    <a href="{{ route('appointments.cancel', $appointment->id) }}" class="btn btn-danger" onclick="return confirm('Are you sure you want to cancel this appointment?')">
                                        <i class="fas fa-times"></i> Cancel Appointment
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