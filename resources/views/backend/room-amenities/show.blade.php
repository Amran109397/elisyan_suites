@extends('backend.layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Room Amenity Assignment Details</h3>
                    <div class="card-tools">
                        <a href="{{ route('room-amenities.edit', $roomAmenity->id) }}" class="btn btn-warning">
                            <i class="fas fa-edit"></i> Edit
                        </a>
                        <a href="{{ route('room-amenities.index') }}" class="btn btn-default">
                            <i class="fas fa-arrow-left"></i> Back
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <p><strong>Room:</strong> {{ $roomAmenity->room->room_number }}</p>
                            <p><strong>Room Type:</strong> {{ $roomAmenity->room->roomType->name }}</p>
                            <p><strong>Property:</strong> {{ $roomAmenity->room->property->name }}</p>
                        </div>
                        <div class="col-md-6">
                            <p><strong>Amenity:</strong> {{ $roomAmenity->amenity->name }}</p>
                            <p><strong>Amenity Description:</strong> {{ $roomAmenity->amenity->description ?: 'N/A' }}</p>
                            <p><strong>Created At:</strong> {{ $roomAmenity->created_at->format('d M Y H:i') }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection