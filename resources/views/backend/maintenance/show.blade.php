@extends('backend.layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Maintenance Issue Details</h3>
                    <div class="card-tools">
                        <a href="{{ route('maintenance.edit', $maintenance->id) }}" class="btn btn-warning">
                            <i class="fas fa-edit"></i> Edit
                        </a>
                        <a href="{{ route('maintenance.index') }}" class="btn btn-default">
                            <i class="fas fa-arrow-left"></i> Back
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <p><strong>Room:</strong> {{ $maintenance->room->room_number }}</p>
                            <p><strong>Issue Type:</strong> {{ $maintenance->issue_type }}</p>
                            <p><strong>Reported By:</strong> {{ $maintenance->reportedBy->name }}</p>
                            <p><strong>Assigned To:</strong> {{ $maintenance->assignedTo ? $maintenance->assignedTo->name : 'N/A' }}</p>
                        </div>
                        <div class="col-md-6">
                            <p><strong>Priority:</strong> 
                                <span class="badge bg-{{ $maintenance->priority == 'high' ? 'danger' : ($maintenance->priority == 'medium' ? 'warning' : 'info') }}">
                                    {{ ucfirst($maintenance->priority) }}
                                </span>
                            </p>
                            <p><strong>Status:</strong> 
                                <span class="badge bg-{{ $maintenance->status == 'completed' ? 'success' : ($maintenance->status == 'in_progress' ? 'warning' : 'danger') }}">
                                    {{ ucfirst(str_replace('_', ' ', $maintenance->status)) }}
                                </span>
                            </p>
                            <p><strong>Scheduled Date:</strong> {{ $maintenance->scheduled_date ? $maintenance->scheduled_date->format('d M Y') : 'N/A' }}</p>
                            <p><strong>Completed Date:</strong> {{ $maintenance->completed_date ? $maintenance->completed_date->format('d M Y') : 'N/A' }}</p>
                        </div>
                    </div>
                    <div class="mt-3">
                        <h5>Description</h5>
                        <p>{{ $maintenance->description }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection