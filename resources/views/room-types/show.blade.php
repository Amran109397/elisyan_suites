@extends('backend.layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Room Type Details</h3>
                    <div class="card-tools">
                        <a href="{{ route('room-types.edit', $roomType->id) }}" class="btn btn-warning">
                            <i class="fas fa-edit"></i> Edit
                        </a>
                        <a href="{{ route('room-types.index') }}" class="btn btn-default">
                            <i class="fas fa-arrow-left"></i> Back
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <p><strong>Name:</strong> {{ $roomType->name }}</p>
                            <p><strong>Property:</strong> {{ $roomType->property->name }}</p>
                            <p><strong>Base Price:</strong> {{ number_format($roomType->base_price, 2) }}</p>
                            <p><strong>Max Occupancy:</strong> {{ $roomType->max_occupancy }}</p>
                        </div>
                        <div class="col-md-6">
                            <p><strong>Size:</strong> {{ $roomType->size_sqm }} sqm</p>
                            <p><strong>Bed Type:</strong> {{ $roomType->bed_type }}</p>
                            <p><strong>Status:</strong> {{ $roomType->is_active ? 'Active' : 'Inactive' }}</p>
                        </div>
                    </div>
                    <div class="mt-3">
                        <h5>Description</h5>
                        <p>{{ $roomType->description }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="row mt-4">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title">Rooms</h5>
                </div>
                <div class="card-body">
                    @if($roomType->rooms->count() > 0)
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Room Number</th>
                                    <th>Floor</th>
                                    <th>Status</th>
                                    <th>Smoking</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($roomType->rooms as $room)
                                    <tr>
                                        <td>{{ $room->room_number }}</td>
                                        <td>{{ $room->floor->name }}</td>
                                        <td>
                                            <span class="badge bg-{{ $room->status == 'available' ? 'success' : ($room->status == 'occupied' ? 'primary' : 'warning') }}">
                                                {{ ucfirst($room->status) }}
                                            </span>
                                        </td>
                                        <td>{{ $room->is_smoking ? 'Yes' : 'No' }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @else
                        <p>No rooms found.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection