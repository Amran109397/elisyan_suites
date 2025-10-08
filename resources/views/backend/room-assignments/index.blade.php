@extends('backend.layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Room Assignments</h3>
                    <div class="card-tools">
                        <a href="{{ route('room-assignments.create') }}" class="btn btn-primary">
                            <i class="fas fa-plus"></i> New Assignment
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>Guest</th>
                                <th>Booking Reference</th>
                                <th>Room</th>
                                <th>Assigned At</th>
                                <th>Assigned By</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($roomAssignments as $assignment)
                            <tr>
                                <td>{{ $assignment->booking->guest->first_name }} {{ $assignment->booking->guest->last_name }}</td>
                                <td>{{ $assignment->booking->booking_reference }}</td>
                                <td>{{ $assignment->room->room_number }}</td>
                                <td>{{ $assignment->assigned_at->format('d M Y, h:i A') }}</td>
                                <td>{{ $assignment->assignedBy->name }}</td>
                                <td>
                                    <a href="{{ route('room-assignments.show', $assignment->id) }}" class="btn btn-sm btn-info">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('room-assignments.edit', $assignment->id) }}" class="btn btn-sm btn-warning">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('room-assignments.destroy', $assignment->id) }}" method="POST" style="display: inline;">
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