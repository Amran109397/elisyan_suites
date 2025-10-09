@extends('backend.layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Room Status Logs</h3>
                    <div class="card-tools">
                        <a href="{{ route('room-status-logs.create') }}" class="btn btn-primary">
                            <i class="fas fa-plus"></i> New Log
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>Room</th>
                                <th>Status</th>
                                <th>Changed By</th>
                                <th>Date</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($roomStatusLogs as $log)
                            <tr>
                                <td>{{ $log->room->room_number }}</td>
                                <td>{{ $log->status }}</td>
                                <td>{{ $log->changedBy->name }}</td>
                                <td>{{ $log->created_at->format('d M Y H:i') }}</td>
                                <td>
                                    <a href="{{ route('room-status-logs.show', $log->id) }}" class="btn btn-sm btn-info">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('room-status-logs.edit', $log->id) }}" class="btn btn-sm btn-warning">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('room-status-logs.destroy', $log->id) }}" method="POST" style="display: inline;">
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