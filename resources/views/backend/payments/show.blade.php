@extends('backend.layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Payment Details</h3>
                    <div class="card-tools">
                        <a href="{{ route('payments.edit', $payment->id) }}" class="btn btn-warning">
                            <i class="fas fa-edit"></i> Edit
                        </a>
                        <a href="{{ route('payments.index') }}" class="btn btn-default">
                            <i class="fas fa-arrow-left"></i> Back
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <p><strong>Booking Reference:</strong> {{ $payment->booking->booking_reference }}</p>
                            <p><strong>Guest:</strong> {{ $payment->guest->full_name }}</p>
                            <p><strong>Amount:</strong> {{ number_format($payment->amount, 2) }}</p>
                            <p><strong>Payment Method:</strong> {{ ucfirst(str_replace('_', ' ', $payment->payment_method)) }}</p>
                        </div>
                        <div class="col-md-6">
                            <p><strong>Payment Type:</strong> {{ ucfirst(str_replace('_', ' ', $payment->payment_type)) }}</p>
                            <p><strong>Payment Status:</strong> 
                                <span class="badge bg-{{ $payment->payment_status == 'completed' ? 'success' : ($payment->payment_status == 'pending' ? 'warning' : 'danger') }}">
                                    {{ ucfirst($payment->payment_status) }}
                                </span>
                            </p>
                            <p><strong>Transaction ID:</strong> {{ $payment->transaction_id }}</p>
                            <p><strong>Paid At:</strong> {{ $payment->paid_at ? $payment->paid_at->format('d M Y H:i') : 'N/A' }}</p>
                        </div>
                    </div>
                    @if($payment->remarks)
                    <div class="mt-3">
                        <h5>Remarks</h5>
                        <p>{{ $payment->remarks }}</p>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
    
    <div class="row mt-4">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title">Payment Actions</h5>
                </div>
                <div class="card-body">
                    @if($payment->payment_status == 'pending')
                        <a href="{{ route('payments.mark-completed', $payment->id) }}" class="btn btn-success">
                            <i class="fas fa-check"></i> Mark as Completed
                        </a>
                        <a href="{{ route('payments.mark-failed', $payment->id) }}" class="btn btn-danger">
                            <i class="fas fa-times"></i> Mark as Failed
                        </a>
                    @endif
                    
                    @if($payment->payment_status == 'completed')
                        <a href="{{ route('payments.mark-refunded', $payment->id) }}" class="btn btn-warning">
                            <i class="fas fa-undo"></i> Mark as Refunded
                        </a>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection