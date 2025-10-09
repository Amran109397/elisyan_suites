@extends('backend.layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Create Room Status Log</h3>
                    <div class="card-tools">
                        <a href="{{ route('room-status-logs.index') }}" class="btn btn-default">
                            <i class="fas fa-arrow-left"></i> Back
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <form action="{{ route('room-status-logs.store') }}" method="POST">
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
                                    <label for="status">Status <span class="text-danger">*</span></label>
                                    <select class="form-select @error('status') is-invalid @enderror" id="status" name="status" required>
                                        <option value="">Select Status</option>
                                        <option value="available">Available</option>
                                        <option value="occupied">Occupied</option>
                                        <option value="maintenance">Maintenance</option>
                                        <option value="cleaning">Cleaning</option>
                                    </select>
                                    @error('status')
                                        <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="notes">Notes</label>
                            <textarea class="form-control @error('notes') is-invalid @enderror" id="notes" name="notes" rows="3">{{ old('notes') }}</textarea>
                            @error('notes')
                                <span class="invalid-feedback" role="alert">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn btn-primary">Create Log</button>
                            <a href="{{ route('room-status-logs.index') }}" class="btn btn-default">Cancel</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection