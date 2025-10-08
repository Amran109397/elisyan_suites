@extends('backend.layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Floor Details</h3>
                    <div class="card-tools">
                        <a href="{{ route('floors.edit', $floor->id) }}" class="btn btn-warning">
                            <i class="fas fa-edit"></i> Edit
                        </a>
                        <a href="{{ route('floors.index') }}" class="btn btn-default">
                            <i class="fas fa-arrow-left"></i> Back
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <p><strong>Property:</strong> {{ $floor->property->name }}</p>
                            <p><strong>Floor Number:</strong> {{ $floor->floor_number }}</p>
                            <p><strong>Floor Name:</strong> {{ $floor->name }}</p>
                        </div>
                        <div class="col-md-6">
                            <p><strong>Total Rooms:</strong> {{ $floor->rooms->count() }}</p>
                            <p><strong>Available Rooms:</strong> {{ $floor->rooms->where('status', 'available')->count() }}</p>
                            <p><strong>Occupied Rooms:</strong> {{ $floor->rooms->where('status', 'occupied')->count() }}</p>
                        </div>
                    </div>
                    
                    @if($floor->rooms->count() > 0)
                    <div class="mt-4">
                        <h5>Rooms on this Floor</h5>
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Room Number</th>
                                    <th>Room Type</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($floor->rooms as $room)
                                    <tr>
                                        <td>{{ $room->room_number }}</td>
                                        <td>{{ $room->roomType->name }}</td>
                                        <td>
                                            <span class="badge bg-{{ $room->status == 'available' ? 'success' : ($room->status == 'occupied' ? 'primary' : 'warning') }}">
                                                {{ ucfirst(str_replace('_', ' ', $room->status)) }}
                                            </span>
                                        </td>
                                        <td>
                                            <a href="{{ route('rooms.show', $room->id) }}" class="btn btn-sm btn-info">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection