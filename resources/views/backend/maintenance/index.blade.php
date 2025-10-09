@extends('backend.layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Maintenance Issues</h3>
                    <div class="card-tools">
                        <a href="{{ route('maintenance.create') }}" class="btn btn-primary">
                            <i class="fas fa-plus"></i> New Issue
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>Room</th>
                                <th>Issue Type</th>
                                <th>Reported By</th>
                                <th>Assigned To</th>
                                <th>Priority</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($maintenances as $maintenance)
                            <tr>
                                <td>{{ $maintenance->room->room_number }}</td>
                                <td>{{ $maintenance->issue_type }}</td>
                                <td>{{ $maintenance->reportedBy->name }}</td>
                                <td>{{ $maintenance->assignedTo ? $maintenance->assignedTo->name : 'N/A' }}</td>
                                <td>
                                    <span class="badge bg-{{ $maintenance->priority == 'high' ? 'danger' : ($maintenance->priority == 'medium' ? 'warning' : 'info') }}">
                                        {{ ucfirst($maintenance->priority) }}
                                    </span>
                                </td>
                                <td>
                                    <span class="badge bg-{{ $maintenance->status == 'completed' ? 'success' : ($maintenance->status == 'in_progress' ? 'warning' : 'danger') }}">
                                        {{ ucfirst(str_replace('_', ' ', $maintenance->status)) }}
                                    </span>
                                </td>
                                <td>
                                    <a href="{{ route('maintenance.show', $maintenance->id) }}" class="btn btn-sm btn-info">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('maintenance.edit', $maintenance->id) }}" class="btn btn-sm btn-warning">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('maintenance.destroy', $maintenance->id) }}" method="POST" style="display: inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection