@extends('backend.layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Create Feedback</h3>
                    <div class="card-tools">
                        <a href="{{ route('feedback.index') }}" class="btn btn-default">
                            <i class="fas fa-arrow-left"></i> Back
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <form action="{{ route('feedback.store') }}" method="POST">
                        @csrf
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="guest_id">Guest <span class="text-danger">*</span></label>
                                    <select class="form-select @error('guest_id') is-invalid @enderror" id="guest_id" name="guest_id" required>
                                        <option value="">Select Guest</option>
                                        @foreach($guests as $guest)
                                            <option value="{{ $guest->id }}">{{ $guest->full_name }}</option>
                                        @endforeach
                                    </select>
                                    @error('guest_id')
                                        <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="booking_id">Booking</label>
                                    <select class="form-select @error('booking_id') is-invalid @enderror" id="booking_id" name="booking_id">
                                        <option value="">Select Booking (Optional)</option>
                                        @foreach($bookings as $booking)
                                            <option value="{{ $booking->id }}">{{ $booking->booking_reference }}</option>
                                        @endforeach
                                    </select>
                                    @error('booking_id')
                                        <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="rating">Rating <span class="text-danger">*</span></label>
                                    <select class="form-select @error('rating') is-invalid @enderror" id="rating" name="rating" required>
                                        <option value="">Select Rating</option>
                                        <option value="1">1 Star</option>
                                        <option value="2">2 Stars</option>
                                        <option value="3">3 Stars</option>
                                        <option value="4">4 Stars</option>
                                        <option value="5">5 Stars</option>
                                    </select>
                                    @error('rating')
                                        <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="category">Category <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('category') is-invalid @enderror" id="category" name="category" value="{{ old('category') }}" required>
                                    @error('category')
                                        <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="comments">Comments <span class="text-danger">*</span></label>
                            <textarea class="form-control @error('comments') is-invalid @enderror" id="comments" name="comments" rows="4" required>{{ old('comments') }}</textarea>
                            @error('comments')
                                <span class="invalid-feedback" role="alert">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="status">Status <span class="text-danger">*</span></label>
                            <select class="form-select @error('status') is-invalid @enderror" id="status" name="status" required>
                                <option value="pending" {{ old('status', 'pending') == 'pending' ? 'selected' : '' }}>Pending</option>
                                <option value="in_progress" {{ old('status') == 'in_progress' ? 'selected' : '' }}>In Progress</option>
                                <option value="resolved" {{ old('status') == 'resolved' ? 'selected' : '' }}>Resolved</option>
                            </select>
                            @error('status')
                                <span class="invalid-feedback" role="alert">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn btn-primary">Create Feedback</button>
                            <a href="{{ route('feedback.index') }}" class="btn btn-default">Cancel</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection