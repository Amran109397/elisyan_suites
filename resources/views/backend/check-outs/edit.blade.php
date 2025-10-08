@extends('backend.layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Edit Check-out</h3>
                    <div class="card-tools">
                        <a href="{{ route('check-outs.index') }}" class="btn btn-default">
                            <i class="fas fa-arrow-left"></i> Back
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <form action="{{ route('check-outs.update', $checkOut->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Booking</label>
                                    <input type="text" class="form-control" value="{{ $checkOut->booking->guest->first_name }} {{ $checkOut->booking->guest->last_name }} - {{ $checkOut->booking->booking_reference }}" readonly>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="actual_check_out">Check-out Time <span class="text-danger">*</span></label>
                                    <input type="datetime-local" class="form-control @error('actual_check_out') is-invalid @enderror" id="actual_check_out" name="actual_check_out" value="{{ old('actual_check_out', $checkOut->actual_check_out->format('Y-m-d\TH:i')) }}" required>
                                    @error('actual_check_out')
                                        <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="final_bill">Final Bill <span class="text-danger">*</span></label>
                                    <input type="number" class="form-control @error('final_bill') is-invalid @enderror" id="final_bill" name="final_bill" value="{{ old('final_bill', $checkOut->final_bill) }}" step="0.01" min="0" required>
                                    @error('final_bill')
                                        <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="payment_status">Payment Status <span class="text-danger">*</span></label>
                                    <select class="form-select @error('payment_status') is-invalid @enderror" id="payment_status" name="payment_status" required>
                                        <option value="pending" {{ old('payment_status', $checkOut->payment_status) == 'pending' ? 'selected' : '' }}>Pending</option>
                                        <option value="paid" {{ old('payment_status') == 'paid' ? 'selected' : '' }}>Paid</option>
                                        <option value="partial" {{ old('payment_status') == 'partial' ? 'selected' : '' }}>Partial</option>
                                    </select>
                                    @error('payment_status')
                                        <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="notes">Notes</label>
                            <textarea class="form-control @error('notes') is-invalid @enderror" id="notes" name="notes" rows="3">{{ old('notes', $checkOut->notes) }}</textarea>
                            @error('notes')
                                <span class="invalid-feedback" role="alert">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn btn-primary">Update Check-out</button>
                            <a href="{{ route('check-outs.index') }}" class="btn btn-default">Cancel</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection