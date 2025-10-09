@extends('backend.layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Edit Loyalty Points</h3>
                    <div class="card-tools">
                        <a href="{{ route('loyalty-points.index') }}" class="btn btn-default">
                            <i class="fas fa-arrow-left"></i> Back
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <form action="{{ route('loyalty-points.update', $loyaltyPoint->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="loyalty_member_id">Loyalty Member <span class="text-danger">*</span></label>
                                    <select class="form-select @error('loyalty_member_id') is-invalid @enderror" id="loyalty_member_id" name="loyalty_member_id" required>
                                        <option value="">Select Member</option>
                                        @foreach($loyaltyMembers as $loyaltyMember)
                                            <option value="{{ $loyaltyMember->id }}" {{ old('loyalty_member_id', $loyaltyPoint->loyalty_member_id) == $loyaltyMember->id ? 'selected' : '' }}>{{ $loyaltyMember->guest->full_name }} ({{ $loyaltyMember->membership_number }})</option>
                                        @endforeach
                                    </select>
                                    @error('loyalty_member_id')
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
                                            <option value="{{ $booking->id }}" {{ old('booking_id', $loyaltyPoint->booking_id) == $booking->id ? 'selected' : '' }}>{{ $booking->booking_reference }}</option>
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
                                    <label for="points">Points <span class="text-danger">*</span></label>
                                    <input type="number" class="form-control @error('points') is-invalid @enderror" id="points" name="points" value="{{ old('points', $loyaltyPoint->points) }}" required>
                                    @error('points')
                                        <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="type">Type <span class="text-danger">*</span></label>
                                    <select class="form-select @error('type') is-invalid @enderror" id="type" name="type" required>
                                        <option value="earned" {{ old('type', $loyaltyPoint->type) == 'earned' ? 'selected' : '' }}>Earned</option>
                                        <option value="redeemed" {{ old('type') == 'redeemed' ? 'selected' : '' }}>Redeemed</option>
                                        <option value="expired" {{ old('type') == 'expired' ? 'selected' : '' }}>Expired</option>
                                    </select>
                                    @error('type')
                                        <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="description">Description <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('description') is-invalid @enderror" id="description" name="description" value="{{ old('description', $loyaltyPoint->description) }}" required>
                            @error('description')
                                <span class="invalid-feedback" role="alert">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="expiry_date">Expiry Date</label>
                            <input type="date" class="form-control @error('expiry_date') is-invalid @enderror" id="expiry_date" name="expiry_date" value="{{ old('expiry_date', $loyaltyPoint->expiry_date) }}">
                            @error('expiry_date')
                                <span class="invalid-feedback" role="alert">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn btn-primary">Update Points</button>
                            <a href="{{ route('loyalty-points.index') }}" class="btn btn-default">Cancel</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection