@extends('backend.layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Edit Room</h3>
                    <div class="card-tools">
                        <a href="{{ route('rooms.index') }}" class="btn btn-default">
                            <i class="fas fa-arrow-left"></i> Back
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <form action="{{ route('rooms.update', $room->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="property_id">Property <span class="text-danger">*</span></label>
                                    <select class="form-select @error('property_id') is-invalid @enderror" id="property_id" name="property_id" required>
                                        <option value="">Select Property</option>
                                        @foreach($properties as $property)
                                            <option value="{{ $property->id }}" {{ old('property_id', $room->property_id) == $property->id ? 'selected' : '' }}>
                                                {{ $property->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('property_id')
                                        <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="room_type_id">Room Type <span class="text-danger">*</span></label>
                                    <select class="form-select @error('room_type_id') is-invalid @enderror" id="room_type_id" name="room_type_id" required>
                                        <option value="">Select Room Type</option>
                                        @foreach($roomTypes as $roomType)
                                            <option value="{{ $roomType->id }}" {{ old('room_type_id', $room->room_type_id) == $roomType->id ? 'selected' : '' }}>
                                                {{ $roomType->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('room_type_id')
                                        <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="floor_id">Floor <span class="text-danger">*</span></label>
                                    <select class="form-select @error('floor_id') is-invalid @enderror" id="floor_id" name="floor_id" required>
                                        <option value="">Select Floor</option>
                                        @foreach($floors as $floor)
                                            <option value="{{ $floor->id }}" {{ old('floor_id', $room->floor_id) == $floor->id ? 'selected' : '' }}>
                                                {{ $floor->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('floor_id')
                                        <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="room_number">Room Number <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('room_number') is-invalid @enderror" id="room_number" name="room_number" value="{{ old('room_number', $room->room_number) }}" required>
                                    @error('room_number')
                                        <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="status">Status <span class="text-danger">*</span></label>
                                    <select class="form-select @error('status') is-invalid @enderror" id="status" name="status" required>
                                        <option value="available" {{ old('status', $room->status) == 'available' ? 'selected' : '' }}>Available</option>
                                        <option value="occupied" {{ old('status', $room->status) == 'occupied' ? 'selected' : '' }}>Occupied</option>
                                        <option value="maintenance" {{ old('status', $room->status) == 'maintenance' ? 'selected' : '' }}>Maintenance</option>
                                        <option value="cleaning" {{ old('status', $room->status) == 'cleaning' ? 'selected' : '' }}>Cleaning</option>
                                        <option value="out_of_service" {{ old('status', $room->status) == 'out_of_service' ? 'selected' : '' }}>Out of Service</option>
                                        <option value="blocked" {{ old('status', $room->status) == 'blocked' ? 'selected' : '' }}>Blocked</option>
                                        <option value="renovation" {{ old('status', $room->status) == 'renovation' ? 'selected' : '' }}>Renovation</option>
                                    </select>
                                    @error('status')
                                        <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <div class="form-check mt-4">
                                        <input class="form-check-input @error('is_smoking') is-invalid @enderror" type="checkbox" id="is_smoking" name="is_smoking" value="1" {{ old('is_smoking', $room->is_smoking) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="is_smoking">
                                            Smoking Room
                                        </label>
                                        @error('is_smoking')
                                            <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn btn-primary">Update Room</button>
                            <a href="{{ route('rooms.index') }}" class="btn btn-default">Cancel</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection