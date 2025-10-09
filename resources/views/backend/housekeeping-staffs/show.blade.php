@extends('backend.layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Housekeeping Staff Details</h3>
                    <div class="card-tools">
                        <a href="{{ route('housekeeping-staffs.edit', $staff->id) }}" class="btn btn-warning">
                            <i class="fas fa-edit"></i> Edit
                        </a>
                        <a href="{{ route('housekeeping-staffs.index') }}" class="btn btn-default">
                            <i class="fas fa-arrow-left"></i> Back
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="info-box bg-light">
                                <div class="info-box-content">
                                    <span class="info-box-text">Staff ID</span>
                                    <span class="info-box-number">#{{ $staff->id }}</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="info-box bg-light">
                                <div class="info-box-content">
                                    <span class="info-box-text">Status</span>
                                    <span class="info-box-number">
                                        <span class="badge bg-{{ $staff->is_active ? 'success' : 'danger' }}">
                                            {{ $staff->is_active ? 'Active' : 'Inactive' }}
                                        </span>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="row mt-4">
                        <div class="col-md-6">
                            <h5>Staff Information</h5>
                            <table class="table table-bordered">
                                <tr>
                                    <th width="30%">Name</th>
                                    <td>{{ $staff->name }}</td>
                                </tr>
                                <tr>
                                    <th>Employee ID</th>
                                    <td>{{ $staff->employee_id }}</td>
                                </tr>
                                <tr>
                                    <th>Property</th>
                                    <td>{{ $staff->property->name }}</td>
                                </tr>
                                <tr>
                                    <th>User Account</th>
                                    <td>{{ $staff->user ? $staff->user->name : 'N/A' }}</td>
                                </tr>
                            </table>
                        </div>
                        
                        <div class="col-md-6">
                            <h5>Additional Information</h5>
                            <table class="table table-bordered">
                                <tr>
                                    <th width="30%">Created At</th>
                                    <td>{{ $staff->created_at->format('d M Y, H:i:s') }}</td>
                                </tr>
                                <tr>
                                    <th>Updated At</th>
                                    <td>{{ $staff->updated_at->format('d M Y, H:i:s') }}</td>
                                </tr>
                            </table>
                        </div>
                    </div>
                    
                    <div class="row mt-4">
                        <div class="col-12">
                            <h5>Assigned Tasks</h5>
                            @if($staff->tasks->count() > 0)
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th>Task ID</th>
                                            <th>Room</th>
                                            <th>Task Type</th>
                                            <th>Priority</th>
                                            <th>Status</th>
                                            <th>Due Date</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($staff->tasks->take(5) as $task)
                                        <tr>
                                            <td>{{ $task->id }}</td>
                                            <td>{{ $task->room->room_number }}</td>
                                            <td>{{ ucfirst(str_replace('_', ' ', $task->task_type)) }}</td>
                                            <td>
                                                <span class="badge bg-{{ $task->priority == 'urgent' ? 'danger' : ($task->priority == 'high' ? 'warning' : ($task->priority == 'medium' ? 'info' : 'secondary')) }}">
                                                    {{ ucfirst($task->priority) }}
                                                </span>
                                            </td>
                                            <td>
                                                <span class="badge bg-{{ $task->status == 'completed' ? 'success' : ($task->status == 'in_progress' ? 'info' : ($task->status == 'cancelled' ? 'danger' : 'warning')) }}">
                                                    {{ ucfirst(str_replace('_', ' ', $task->status)) }}
                                                </span>
                                            </td>
                                            <td>{{ $task->due_date->format('d M Y, H:i') }}</td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            @else
                                <p>No tasks assigned to this staff member.</p>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection