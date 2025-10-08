@extends('backend.layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Edit Check-in</h3>
                    <div class="card-tools">
                        <a href="{{ route('check-ins.index') }}" class="btn btn-default">
                            <i class="fas fa-arrow-left"></i> Back
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <form action="{{ route('check-ins.update', $checkIn->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Booking</label>
                                    <input type="text" class="form-control" value="{{ $checkIn->booking->guest->first_name }} {{ $checkIn->booking->guest->last_name }} - {{ $checkIn->booking->booking_reference }}" readonly>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="actual_check_in">Check-in Time <span class="text-danger">*</span></label>
                                    <input type="datetime-local" class="form-control @error('actual_check_in') is-invalid @enderror" id="actual_check_in" name="actual_check_in" value="{{ old('actual_check_in', $checkIn->actual_check_in->format('Y-m-d\TH:i')) }}" required>
                                    @error('actual_check_in')
                                        <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="id_document_path">ID Document Path</label>
                            <input type="text" class="form-control @error('id_document_path') is-invalid @enderror" id="id_document_path" name="id_document_path" value="{{ old('id_document_path', $checkIn->id_document_path) }}" placeholder="Enter document path or upload file">
                            @error('id_document_path')
                                <span class="invalid-feedback" role="alert">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="notes">Notes</label>
                            <textarea class="form-control @error('notes') is-invalid @enderror" id="notes" name="notes" rows="3">{{ old('notes', $checkIn->notes) }}</textarea>
                            @error('notes')
                                <span class="invalid-feedback" role="alert">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn btn-primary">Update Check-in</button>
                            <a href="{{ route('check-ins.index') }}" class="btn btn-default">Cancel</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection