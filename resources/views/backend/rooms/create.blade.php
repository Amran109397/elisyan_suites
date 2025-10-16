@extends('backend.layouts.app')

@section('title', 'Create New Room')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header bg-success">
                    <h3 class="card-title text-white">
                        <i class="fas fa-plus-circle"></i> Create New Room
                    </h3>
                    <div class="card-tools">
                        <a href="{{ route('rooms.index') }}" class="btn btn-light btn-sm">
                            <i class="fas fa-arrow-left"></i> Back to Rooms
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    @if($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('rooms.store') }}" method="POST" id="roomForm">
                        @csrf
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="property_id" class="required">Property</label>
                                    <select class="form-control select2 @error('property_id') is-invalid @enderror" 
                                            id="property_id" 
                                            name="property_id" 
                                            required>
                                        <option value="">Select Property</option>
                                        @foreach($properties as $property)
                                            <option value="{{ $property->id }}" 
                                                {{ old('property_id') == $property->id ? 'selected' : '' }}>
                                                {{ $property->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('property_id')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="room_type_id" class="required">Room Type</label>
                                    <select class="form-control select2 @error('room_type_id') is-invalid @enderror" 
                                            id="room_type_id" 
                                            name="room_type_id" 
                                            required>
                                        <option value="">Select Room Type</option>
                                        @foreach($roomTypes as $roomType)
                                            <option value="{{ $roomType->id }}" 
                                                {{ old('room_type_id') == $roomType->id ? 'selected' : '' }}>
                                                {{ $roomType->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('room_type_id')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="floor_id" class="required">Floor</label>
                                    <select class="form-control select2 @error('floor_id') is-invalid @enderror" 
                                            id="floor_id" 
                                            name="floor_id" 
                                            required>
                                        <option value="">Select Floor</option>
                                        @foreach($floors as $floor)
                                            <option value="{{ $floor->id }}" 
                                                {{ old('floor_id') == $floor->id ? 'selected' : '' }}>
                                                {{ $floor->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('floor_id')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="room_number" class="required">Room Number</label>
                                    <input type="text" 
                                           class="form-control @error('room_number') is-invalid @enderror" 
                                           id="room_number" 
                                           name="room_number" 
                                           value="{{ old('room_number') }}" 
                                           placeholder="Enter room number (e.g., 101, 202A)"
                                           required>
                                    @error('room_number')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="status" class="required">Status</label>
                                    <select class="form-control @error('status') is-invalid @enderror" 
                                            id="status" 
                                            name="status" 
                                            required>
                                        <option value="available" {{ old('status', 'available') == 'available' ? 'selected' : '' }}>
                                            Available
                                        </option>
                                        <option value="occupied" {{ old('status') == 'occupied' ? 'selected' : '' }}>
                                            Occupied
                                        </option>
                                        <option value="maintenance" {{ old('status') == 'maintenance' ? 'selected' : '' }}>
                                            Maintenance
                                        </option>
                                        <option value="cleaning" {{ old('status') == 'cleaning' ? 'selected' : '' }}>
                                            Cleaning
                                        </option>
                                        <option value="out_of_service" {{ old('status') == 'out_of_service' ? 'selected' : '' }}>
                                            Out of Service
                                        </option>
                                        <option value="blocked" {{ old('status') == 'blocked' ? 'selected' : '' }}>
                                            Blocked
                                        </option>
                                        <option value="renovation" {{ old('status') == 'renovation' ? 'selected' : '' }}>
                                            Renovation
                                        </option>
                                    </select>
                                    @error('status')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Room Features</label>
                                    <div class="mt-2">
                                        <div class="form-check">
                                            <input class="form-check-input" 
                                                   type="checkbox" 
                                                   id="is_smoking" 
                                                   name="is_smoking" 
                                                   value="1" 
                                                   {{ old('is_smoking') ? 'checked' : '' }}>
                                            <label class="form-check-label" for="is_smoking">
                                                Smoking Room
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="form-group mt-4">
                            <button type="submit" class="btn btn-success btn-lg">
                                <i class="fas fa-save"></i> Create Room
                            </button>
                            <a href="{{ route('rooms.index') }}" class="btn btn-secondary btn-lg">
                                <i class="fas fa-times"></i> Cancel
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('styles')
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet" />
<style>
    .required::after {
        content: " *";
        color: red;
    }
    .select2-container .select2-selection--single {
        height: 38px !important;
    }
</style>
@endsection

@section('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>
<script>
    $(document).ready(function() {
        // Initialize Select2
        $('.select2').select2({
            placeholder: "Select an option",
            allowClear: true
        });

        // Form validation
        $('#roomForm').on('submit', function() {
            $('.btn-success').prop('disabled', true).html('<i class="fas fa-spinner fa-spin"></i> Creating...');
        });
    });
</script>
@endsection