@extends('backend.layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Property Details</h3>
                    <div class="card-tools">
                        <a href="{{ route('properties.edit', $property->id) }}" class="btn btn-warning">
                            <i class="fas fa-edit"></i> Edit
                        </a>
                        <a href="{{ route('properties.index') }}" class="btn btn-default">
                            <i class="fas fa-arrow-left"></i> Back
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <p><strong>Name:</strong> {{ $property->name }}</p>
                            <p><strong>Address:</strong> {{ $property->address }}</p>
                            <p><strong>City:</strong> {{ $property->city }}</p>
                            <p><strong>Country:</strong> {{ $property->country }}</p>
                            <p><strong>Phone:</strong> {{ $property->phone }}</p>
                            <p><strong>Email:</strong> {{ $property->email }}</p>
                        </div>
                        <div class="col-md-6">
                            <p><strong>Currency:</strong> {{ $property->currency ? $property->currency->name : '-' }}</p>
                            <p><strong>Check-in Time:</strong> {{ $property->check_in_time }}</p>
                            <p><strong>Check-out Time:</strong> {{ $property->check_out_time }}</p>
                            <p><strong>Timezone:</strong> {{ $property->timezone }}</p>
                            <p><strong>Status:</strong> {{ $property->is_active ? 'Active' : 'Inactive' }}</p>
                            @if($property->logo)
                                <p><strong>Logo:</strong><br>
                                <img src="{{ asset('storage/' . $property->logo) }}" alt="Property Logo" width="100">
                                </p>
                            @endif
                        </div>
                    </div>
                    <div class="mt-3">
                        <h5>Description</h5>
                        <p>{{ $property->description }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="row mt-4">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title">Room Types</h5>
                </div>
                <div class="card-body">
                    @if($property->roomTypes->count() > 0)
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Base Price</th>
                                    <th>Max Occupancy</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($property->roomTypes as $roomType)
                                    <tr>
                                        <td>{{ $roomType->name }}</td>
                                        <td>{{ number_format($roomType->base_price, 2) }}</td>
                                        <td>{{ $roomType->max_occupancy }}</td>
                                        <td>
                                            <span class="badge bg-{{ $roomType->is_active ? 'success' : 'danger' }}">
                                                {{ $roomType->is_active ? 'Active' : 'Inactive' }}
                                            </span>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @else
                        <p>No room types found.</p>
                    @endif
                </div>
            </div>
        </div>
        
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title">Floors</h5>
                </div>
                <div class="card-body">
                    @if($property->floors->count() > 0)
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Floor Number</th>
                                    <th>Name</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($property->floors as $floor)
                                    <tr>
                                        <td>{{ $floor->floor_number }}</td>
                                        <td>{{ $floor->name }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @else
                        <p>No floors found.</p>
                    @endif
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
                    @if($property->rooms->count() > 0)
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Room Number</th>
                                    <th>Room Type</th>
                                    <th>Floor</th>
                                    <th>Status</th>
                                    <th>Smoking</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($property->rooms as $room)
                                    <tr>
                                        <td>{{ $room->room_number }}</td>
                                        <td>{{ $room->roomType->name }}</td>
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