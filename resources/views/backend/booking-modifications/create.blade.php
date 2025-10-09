@extends('backend.layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Create Booking Modification</h3>
                    <div class="card-tools">
                        <a href="{{ route('booking-modifications.index') }}" class="btn btn-default">
                            <i class="fas fa-arrow-left"></i> Back
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <form action="{{ route('booking-modifications.store') }}" method="POST">
                        @csrf
                        <div class="form-group">
                            <label for="booking_id">Booking <span class="text-danger">*</span></label>
                            <select class="form-select @error('booking_id') is-invalid @enderror" id="booking_id" name="booking_id" required>
                                <option value="">Select Booking</option>
                                @foreach($bookings as $booking)
                                    <option value="{{ $booking->id }}">{{ $booking->booking_reference }}</option>
                                @endforeach
                            </select>
                            @error('booking_id')
                                <span class="invalid-feedback" role="alert">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="modification_type">Modification Type <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('modification_type') is-invalid @enderror" id="modification_type" name="modification_type" value="{{ old('modification_type') }}" required>
                            @error('modification_type')
                                <span class="invalid-feedback" role="alert">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="old_value">Old Value <span class="text-danger">*</span></label>
                                    <textarea class="form-control @error('old_value') is-invalid @enderror" id="old_value" name="old_value" rows="3" required>{{ old('old_value') }}</textarea>
                                    @error('old_value')
                                        <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="new_value">New Value <span class="text-danger">*</span></label>
                                    <textarea class="form-control @error('new_value') is-invalid @enderror" id="new_value" name="new_value" rows="3" required>{{ old('new_value') }}</textarea>
                                    @error('new_value')
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
                            <button type="submit" class="btn btn-primary">Create Modification</button>
                            <a href="{{ route('booking-modifications.index') }}" class="btn btn-default">Cancel</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection