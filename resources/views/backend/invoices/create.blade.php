@extends('backend.layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Create Invoice</h3>
                    <div class="card-tools">
                        <a href="{{ route('invoices.index') }}" class="btn btn-default">
                            <i class="fas fa-arrow-left"></i> Back
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <form action="{{ route('invoices.store') }}" method="POST">
                        @csrf
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="booking_id">Booking <span class="text-danger">*</span></label>
                                    <select class="form-select @error('booking_id') is-invalid @enderror" id="booking_id" name="booking_id" required>
                                        <option value="">Select Booking</option>
                                        @foreach($bookings as $booking)
                                            <option value="{{ $booking->id }}">{{ $booking->booking_reference }} - {{ $booking->guest->full_name }}</option>
                                        @endforeach
                                    </select>
                                    @error('booking_id')
                                        <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="issue_date">Issue Date <span class="text-danger">*</span></label>
                                    <input type="date" class="form-control @error('issue_date') is-invalid @enderror" id="issue_date" name="issue_date" value="{{ old('issue_date', now()->format('Y-m-d')) }}" required>
                                    @error('issue_date')
                                        <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="due_date">Due Date <span class="text-danger">*</span></label>
                                    <input type="date" class="form-control @error('due_date') is-invalid @enderror" id="due_date" name="due_date" value="{{ old('due_date', now()->addDays(7)->format('Y-m-d')) }}" required>
                                    @error('due_date')
                                        <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="amount">Amount <span class="text-danger">*</span></label>
                                    <input type="number" class="form-control @error('amount') is-invalid @enderror" id="amount" name="amount" value="{{ old('amount') }}" step="0.01" min="0" required>
                                    @error('amount')
                                        <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="tax_amount">Tax Amount <span class="text-danger">*</span></label>
                                    <input type="number" class="form-control @error('tax_amount') is-invalid @enderror" id="tax_amount" name="tax_amount" value="{{ old('tax_amount', 0) }}" step="0.01" min="0" required>
                                    @error('tax_amount')
                                        <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn btn-primary">Create Invoice</button>
                            <a href="{{ route('invoices.index') }}" class="btn btn-default">Cancel</a>
                            <a href="{{ route('invoices.create') }}">Create New Invoice</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection