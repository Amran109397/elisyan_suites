@extends('backend.layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Rooms</h3>
                    <div class="card-tools">
                        <a href="{{ route('rooms.create') }}" class="btn btn-primary">
                            <i class="fas fa-plus"></i> Add Room
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Room Number</th>
                                <th>Property</th>
                                <th>Room Type</th>
                                <th>Floor</th>
                                <th>Status</th>
                                <th>Smoking</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($rooms as $room)
                            <tr>
                                <td>{{ $room->id }}</td>
                                <td>{{ $room->room_number }}</td>
                                <td>{{ $room->property->name }}</td>
                                <td>{{ $room->roomType->name }}</td>
                                <td>{{ $room->floor->name }}</td>
                                <td>
                                    <span class="badge bg-{{ $room->status == 'available' ? 'success' : ($room->status == 'occupied' ? 'primary' : 'warning') }}">
                                        {{ ucfirst($room->status) }}
                                    </span>
                                </td>
                                <td>{{ $room->is_smoking ? 'Yes' : 'No' }}</td>
                                <td>
                                    <a href="{{ route('rooms.show', $room->id) }}" class="btn btn-sm btn-info">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('rooms.edit', $room->id) }}" class="btn btn-sm btn-warning">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('rooms.destroy', $room->id) }}" method="POST" style="display: inline;">
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