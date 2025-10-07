@extends('backend.layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Edit Payment</h3>
                    <div class="card-tools">
                        <a href="{{ route('payments.index') }}" class="btn btn-default">
                            <i class="fas fa-arrow-left"></i> Back
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <form action="{{ route('payments.update', $payment->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="booking_id">Booking <span class="text-danger">*</span></label>
                                    <select class="form-select @error('booking_id') is-invalid @enderror" id="booking_id" name="booking_id" required>
                                        <option value="">Select Booking</option>
                                        @foreach($bookings as $booking)
                                            <option value="{{ $booking->id }}" {{ old('booking_id', $payment->booking_id) == $booking->id ? 'selected' : '' }}>{{ $booking->booking_reference }} - {{ $booking->guest->full_name }}</option>
                                        @endforeach
                                    </select>
                                    @error('booking_id')
                                        <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="guest_id">Guest <span class="text-danger">*</span></label>
                                    <select class="form-select @error('guest_id') is-invalid @enderror" id="guest_id" name="guest_id" required>
                                        <option value="">Select Guest</option>
                                        @foreach($guests as $guest)
                                            <option value="{{ $guest->id }}" {{ old('guest_id', $payment->guest_id) == $guest->id ? 'selected' : '' }}>{{ $guest->full_name }}</option>
                                        @endforeach
                                    </select>
                                    @error('guest_id')
                                        <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="amount">Amount <span class="text-danger">*</span></label>
                                    <input type="number" class="form-control @error('amount') is-invalid @enderror" id="amount" name="amount" value="{{ old('amount', $payment->amount) }}" step="0.01" min="0" required>
                                    @error('amount')
                                        <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="payment_method">Payment Method <span class="text-danger">*</span></label>
                                    <select class="form-select @error('payment_method') is-invalid @enderror" id="payment_method" name="payment_method" required>
                                        <option value="credit_card" {{ old('payment_method', $payment->payment_method) == 'credit_card' ? 'selected' : '' }}>Credit Card</option>
                                        <option value="debit_card" {{ old('payment_method') == 'debit_card' ? 'selected' : '' }}>Debit Card</option>
                                        <option value="cash" {{ old('payment_method') == 'cash' ? 'selected' : '' }}>Cash</option>
                                        <option value="mobile_banking" {{ old('payment_method') == 'mobile_banking' ? 'selected' : '' }}>Mobile Banking</option>
                                        <option value="bank_transfer" {{ old('payment_method') == 'bank_transfer' ? 'selected' : '' }}>Bank Transfer</option>
                                        <option value="voucher" {{ old('payment_method') == 'voucher' ? 'selected' : '' }}>Voucher</option>
                                    </select>
                                    @error('payment_method')
                                        <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="payment_type">Payment Type <span class="text-danger">*</span></label>
                                    <select class="form-select @error('payment_type') is-invalid @enderror" id="payment_type" name="payment_type" required>
                                        <option value="advance" {{ old('payment_type', $payment->payment_type) == 'advance' ? 'selected' : '' }}>Advance</option>
                                        <option value="partial" {{ old('payment_type') == 'partial' ? 'selected' : '' }}>Partial</option>
                                        <option value="full" {{ old('payment_type') == 'full' ? 'selected' : '' }}>Full</option>
                                        <option value="refund" {{ old('payment_type') == 'refund' ? 'selected' : '' }}>Refund</option>
                                        <option value="deposit" {{ old('payment_type') == 'deposit' ? 'selected' : '' }}>Deposit</option>
                                    </select>
                                    @error('payment_type')
                                        <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="payment_status">Payment Status <span class="text-danger">*</span></label>
                                    <select class="form-select @error('payment_status') is-invalid @enderror" id="payment_status" name="payment_status" required>
                                        <option value="pending" {{ old('payment_status', $payment->payment_status) == 'pending' ? 'selected' : '' }}>Pending</option>
                                        <option value="completed" {{ old('payment_status') == 'completed' ? 'selected' : '' }}>Completed</option>
                                        <option value="failed" {{ old('payment_status') == 'failed' ? 'selected' : '' }}>Failed</option>
                                        <option value="refunded" {{ old('payment_status') == 'refunded' ? 'selected' : '' }}>Refunded</option>
                                        <option value="voided" {{ old('payment_status') == 'voided' ? 'selected' : '' }}>Voided</option>
                                    </select>
                                    @error('payment_status')
                                        <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="payment_gateway_id">Payment Gateway</label>
                                    <select class="form-select @error('payment_gateway_id') is-invalid @enderror" id="payment_gateway_id" name="payment_gateway_id">
                                        <option value="">Select Payment Gateway</option>
                                        @foreach($paymentGateways as $gateway)
                                            <option value="{{ $gateway->id }}" {{ old('payment_gateway_id', $payment->payment_gateway_id) == $gateway->id ? 'selected' : '' }}>{{ $gateway->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('payment_gateway_id')
                                        <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="transaction_id">Transaction ID</label>
                                    <input type="text" class="form-control @error('transaction_id') is-invalid @enderror" id="transaction_id" name="transaction_id" value="{{ old('transaction_id', $payment->transaction_id) }}">
                                    @error('transaction_id')
                                        <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="remarks">Remarks</label>
                            <textarea class="form-control @error('remarks') is-invalid @enderror" id="remarks" name="remarks" rows="3">{{ old('remarks', $payment->remarks) }}</textarea>
                            @error('remarks')
                                <span class="invalid-feedback" role="alert">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn btn-primary">Update Payment</button>
                            <a href="{{ route('payments.index') }}" class="btn btn-default">Cancel</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection