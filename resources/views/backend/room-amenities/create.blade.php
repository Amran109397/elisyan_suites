@extends('backend.layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Create Room Amenity Assignment</h3>
                    <div class="card-tools">
                        <a href="{{ route('room-amenities.index') }}" class="btn btn-default">
                            <i class="fas fa-arrow-left"></i> Back
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <form action="{{ route('room-amenities.store') }}" method="POST">
                        @csrf
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="room_id">Room <span class="text-danger">*</span></label>
                                    <select class="form-select @error('room_id') is-invalid @enderror" id="room_id" name="room_id" required>
                                        <option value="">Select Room</option>
                                        @foreach($rooms as $room)
                                            <option value="{{ $room->id }}">{{ $room->room_number }}</option>
                                        @endforeach
                                    </select>
                                    @error('room_id')
                                        <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="amenity_id">Amenity <span class="text-danger">*</span></label>
                                    <select class="form-select @error('amenity_id') is-invalid @enderror" id="amenity_id" name="amenity_id" required>
                                        <option value="">Select Amenity</option>
                                        @foreach($amenities as $amenity)
                                            <option value="{{ $amenity->id }}">{{ $amenity->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('amenity_id')
                                        <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn btn-primary">Create Assignment</button>
                            <a href="{{ route('room-amenities.index') }}" class="btn btn-default">Cancel</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection