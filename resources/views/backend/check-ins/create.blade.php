@extends('backend.layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">New Check-in</h3>
                    <div class="card-tools">
                        <a href="{{ route('check-ins.index') }}" class="btn btn-default">
                            <i class="fas fa-arrow-left"></i> Back
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <form action="{{ route('check-ins.store') }}" method="POST">
                        @csrf
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="booking_id">Booking <span class="text-danger">*</span></label>
                                    <select class="form-select @error('booking_id') is-invalid @enderror" id="booking_id" name="booking_id" required>
                                        <option value="">Select Booking</option>
                                        @foreach($bookings as $booking)
                                            <option value="{{ $booking->id }}" {{ old('booking_id') == $booking->id ? 'selected' : '' }}>
                                                {{ $booking->guest->first_name }} {{ $booking->guest->last_name }} - {{ $booking->booking_reference }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('booking_id')
                                        <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="actual_check_in">Check-in Time <span class="text-danger">*</span></label>
                                    <input type="datetime-local" class="form-control @error('actual_check_in') is-invalid @enderror" id="actual_check_in" name="actual_check_in" value="{{ old('actual_check_in', now()->format('Y-m-d\TH:i')) }}" required>
                                    @error('actual_check_in')
                                        <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="id_document_path">ID Document Path</label>
                            <input type="text" class="form-control @error('id_document_path') is-invalid @enderror" id="id_document_path" name="id_document_path" value="{{ old('id_document_path') }}" placeholder="Enter document path or upload file">
                            @error('id_document_path')
                                <span class="invalid-feedback" role="alert">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="notes">Notes</label>
                            <textarea class="form-control @error('notes') is-invalid @enderror" id="notes" name="notes" rows="3">{{ old('notes') }}</textarea>
                            @error('notes')
                                <span class="invalid-feedback" role="alert">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn btn-primary">Check-in Guest</button>
                            <a href="{{ route('check-ins.index') }}" class="btn btn-default">Cancel</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection