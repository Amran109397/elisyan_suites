@extends('backend.layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Housekeeping Tasks</h3>
                    <div class="card-tools">
                        <a href="{{ route('housekeeping-tasks.create') }}" class="btn btn-primary">
                            <i class="fas fa-plus"></i> New Task
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-md-3">
                            <input type="text" class="form-control" id="searchTasks" placeholder="Search tasks...">
                        </div>
                        <div class="col-md-3">
                            <select class="form-select" id="filterProperty">
                                <option value="">All Properties</option>
                                @foreach($properties as $property)
                                    <option value="{{ $property->id }}">{{ $property->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-3">
                            <select class="form-select" id="filterStatus">
                                <option value="">All Status</option>
                                <option value="assigned">Assigned</option>
                                <option value="in_progress">In Progress</option>
                                <option value="completed">Completed</option>
                                <option value="cancelled">Cancelled</option>
                                <option value="skipped">Skipped</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <select class="form-select" id="filterPriority">
                                <option value="">All Priorities</option>
                                <option value="low">Low</option>
                                <option value="medium">Medium</option>
                                <option value="high">High</option>
                                <option value="urgent">Urgent</option>
                            </select>
                        </div>
                    </div>
                    
                    <table class="table table-bordered table-striped table-hover" id="tasksTable">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Room</th>
                                <th>Staff</th>
                                <th>Task Type</th>
                                <th>Priority</th>
                                <th>Status</th>
                                <th>Due Date</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($tasks as $task)
                            <tr>
                                <td>{{ $task->id }}</td>
                                <td>{{ $task->room->room_number }}</td>
                                <td>{{ $task->staff ? $task->staff->name : 'Unassigned' }}</td>
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
                                <td>
                                    <a href="{{ route('housekeeping-tasks.show', $task->id) }}" class="btn btn-sm btn-info">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('housekeeping-tasks.edit', $task->id) }}" class="btn btn-sm btn-warning">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    @if($task->status != 'completed' && $task->status != 'cancelled')
                                        <form action="{{ route('housekeeping-tasks.destroy', $task->id) }}" method="POST" style="display: inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    
                    <div class="d-flex justify-content-between align-items-center mt-3">
                        <div>
                            Showing {{ $tasks->firstItem() }} to {{ $tasks->lastItem() }} of {{ $tasks->total() }} entries
                        </div>
                        {{ $tasks->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
 $(document).ready(function() {
    $('#searchTasks').on('keyup', function() {
        let value = $(this).val().toLowerCase();
        $('#tasksTable tbody tr').filter(function() {
            $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1);
        });
    });
    
    $('#filterProperty, #filterStatus, #filterPriority').on('change', function() {
        window.location.href = '/housekeeping-tasks?' + 
            $.param({
                search: $('#searchTasks').val(),
                property: $('#filterProperty').val(),
                status: $('#filterStatus').val(),
                priority: $('#filterPriority').val()
            });
    });
});
</script>
@endpush