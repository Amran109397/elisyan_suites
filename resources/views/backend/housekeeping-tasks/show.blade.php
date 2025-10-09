@extends('backend.layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Housekeeping Task Details</h3>
                    <div class="card-tools">
                        <a href="{{ route('housekeeping-tasks.edit', $task->id) }}" class="btn btn-warning">
                            <i class="fas fa-edit"></i> Edit
                        </a>
                        <a href="{{ route('housekeeping-tasks.index') }}" class="btn btn-default">
                            <i class="fas fa-arrow-left"></i> Back
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="info-box bg-light">
                                <div class="info-box-content">
                                    <span class="info-box-text">Task ID</span>
                                    <span class="info-box-number">#{{ $task->id }}</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="info-box bg-light">
                                <div class="info-box-content">
                                    <span class="info-box-text">Status</span>
                                    <span class="info-box-number">
                                        <span class="badge bg-{{ $task->status == 'completed' ? 'success' : ($task->status == 'in_progress' ? 'info' : ($task->status == 'cancelled' ? 'danger' : 'warning')) }}">
                                            {{ ucfirst(str_replace('_', ' ', $task->status)) }}
                                        </span>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="row mt-4">
                        <div class="col-md-6">
                            <h5>Task Information</h5>
                            <table class="table table-bordered">
                                <tr>
                                    <th width="30%">Room</th>
                                    <td>{{ $task->room->room_number }}</td>
                                </tr>
                                <tr>
                                    <th>Task Type</th>
                                    <td>{{ ucfirst(str_replace('_', ' ', $task->task_type)) }}</td>
                                </tr>
                                <tr>
                                    <th>Priority</th>
                                    <td>
                                        <span class="badge bg-{{ $task->priority == 'urgent' ? 'danger' : ($task->priority == 'high' ? 'warning' : ($task->priority == 'medium' ? 'info' : 'secondary')) }}">
                                            {{ ucfirst($task->priority) }}
                                        </span>
                                    </td>
                                </tr>
                                <tr>
                                    <th>Due Date</th>
                                    <td>{{ $task->due_date->format('d M Y, H:i') }}</td>
                                </tr>
                                <tr>
                                    <th>Property</th>
                                    <td>{{ $task->property->name }}</td>
                                </tr>
                            </table>
                        </div>
                        
                        <div class="col-md-6">
                            <h5>Assignment Information</h5>
                            <table class="table table-bordered">
                                <tr>
                                    <th width="30%">Staff</th>
                                    <td>{{ $task->staff ? $task->staff->name : 'Unassigned' }}</td>
                                </tr>
                                <tr>
                                    <th>Created By</th>
                                    <td>{{ $task->createdBy->name }}</td>
                                </tr>
                                <tr>
                                    <th>Created At</th>
                                    <td>{{ $task->created_at->format('d M Y, H:i:s') }}</td>
                                </tr>
                                <tr>
                                    <th>Updated At</th>
                                    <td>{{ $task->updated_at->format('d M Y, H:i:s') }}</td>
                                </tr>
                                @if($task->completed_at)
                                <tr>
                                    <th>Completed At</th>
                                    <td>{{ $task->completed_at->format('d M Y, H:i:s') }}</td>
                                </tr>
                                @endif
                            </table>
                        </div>
                    </div>
                    
                    @if($task->notes)
                    <div class="row mt-4">
                        <div class="col-12">
                            <h5>Notes</h5>
                            <div class="bg-light p-3">
                                {{ $task->notes }}
                            </div>
                        </div>
                    </div>
                    @endif
                    
                    <div class="row mt-4">
                        <div class="col-12">
                            <h5>Task Actions</h5>
                            <div class="btn-group">
                                @if($task->status == 'assigned')
                                    <a href="{{ route('housekeeping-tasks.start', $task->id) }}" class="btn btn-info">
                                        <i class="fas fa-play"></i> Start Task
                                    </a>
                                @endif
                                
                                @if($task->status == 'in_progress')
                                    <a href="{{ route('housekeeping-tasks.complete', $task->id) }}" class="btn btn-success">
                                        <i class="fas fa-check"></i> Complete Task
                                    </a>
                                @endif
                                
                                @if(!in_array($task->status, ['completed', 'cancelled']))
                                    <a href="{{ route('housekeeping-tasks.cancel', $task->id) }}" class="btn btn-danger" onclick="return confirm('Are you sure you want to cancel this task?')">
                                        <i class="fas fa-times"></i> Cancel Task
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