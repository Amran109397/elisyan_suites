@extends('backend.layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Edit Booking Addon</h3>
                    <div class="card-tools">
                        <a href="{{ route('booking-addons.index') }}" class="btn btn-default">
                            <i class="fas fa-arrow-left"></i> Back
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <form action="{{ route('booking-addons.update', $bookingAddon->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="booking_id">Booking <span class="text-danger">*</span></label>
                                    <select class="form-select @error('booking_id') is-invalid @enderror" id="booking_id" name="booking_id" required>
                                        <option value="">Select Booking</option>
                                        @foreach($bookings as $booking)
                                            <option value="{{ $booking->id }}" {{ old('booking_id', $bookingAddon->booking_id) == $booking->id ? 'selected' : '' }}>{{ $booking->booking_reference }}</option>
                                        @endforeach
                                    </select>
                                    @error('booking_id')
                                        <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="addon_id">Addon <span class="text-danger">*</span></label>
                                    <select class="form-select @error('addon_id') is-invalid @enderror" id="addon_id" name="addon_id" required>
                                        <option value="">Select Addon</option>
                                        @foreach($addons as $addon)
                                            <option value="{{ $addon->id }}" {{ old('addon_id', $bookingAddon->addon_id) == $addon->id ? 'selected' : '' }}>{{ $addon->name }} ({{ number_format($addon->price, 2) }})</option>
                                        @endforeach
                                    </select>
                                    @error('addon_id')
                                        <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="quantity">Quantity <span class="text-danger">*</span></label>
                                    <input type="number" class="form-control @error('quantity') is-invalid @enderror" id="quantity" name="quantity" value="{{ old('quantity', $bookingAddon->quantity) }}" min="1" required>
                                    @error('quantity')
                                        <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="price">Price <span class="text-danger">*</span></label>
                                    <input type="number" class="form-control @error('price') is-invalid @enderror" id="price" name="price" value="{{ old('price', $bookingAddon->price) }}" step="0.01" min="0" required>
                                    @error('price')
                                        <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="notes">Notes</label>
                            <textarea class="form-control @error('notes') is-invalid @enderror" id="notes" name="notes" rows="3">{{ old('notes', $bookingAddon->notes) }}</textarea>
                            @error('notes')
                                <span class="invalid-feedback" role="alert">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn btn-primary">Update Addon</button>
                            <a href="{{ route('booking-addons.index') }}" class="btn btn-default">Cancel</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection