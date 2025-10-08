@extends('backend.layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Check-out Details</h3>
                    <div class="card-tools">
                        <a href="{{ route('check-outs.edit', $checkOut->id) }}" class="btn btn-warning">
                            <i class="fas fa-edit"></i> Edit
                        </a>
                        <a href="{{ route('check-outs.index') }}" class="btn btn-default">
                            <i class="fas fa-arrow-left"></i> Back
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <p><strong>Guest:</strong> {{ $checkOut->booking->guest->first_name }} {{ $checkOut->booking->guest->last_name }}</p>
                            <p><strong>Booking Reference:</strong> {{ $checkOut->booking->booking_reference }}</p>
                            <p><strong>Room:</strong> {{ $checkOut->booking->room ? $checkOut->booking->room->room_number : 'Not assigned' }}</p>
                            <p><strong>Check-out Time:</strong> {{ $checkOut->actual_check_out->format('d M Y, h:i A') }}</p>
                        </div>
                        <div class="col-md-6">
                            <p><strong>Checked By:</strong> {{ $checkOut->checkedBy->name }}</p>
                            <p><strong>Final Bill:</strong> {{ number_format($checkOut->final_bill, 2) }}</p>
                            <p><strong>Payment Status:</strong> 
                                <span class="badge bg-{{ $checkOut->payment_status == 'paid' ? 'success' : ($checkOut->payment_status == 'partial' ? 'warning' : 'danger') }}">
                                    {{ ucfirst($checkOut->payment_status) }}
                                </span>
                            </p>
                            <p><strong>Booking Status:</strong> 
                                <span class="badge bg-{{ $checkOut->booking->status == 'checked_out' ? 'success' : 'warning' }}">
                                    {{ ucfirst($checkOut->booking->status) }}
                                </span>
                            </p>
                        </div>
                    </div>
                    
                    @if($checkOut->booking->payments->count() > 0)
                    <div class="mt-4">
                        <h5>Payments</h5>
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Amount</th>
                                    <th>Method</th>
                                    <th>Status</th>
                                    <th>Date</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($checkOut->booking->payments as $payment)
                                    <tr>
                                        <td>{{ number_format($payment->amount, 2) }}</td>
                                        <td>{{ ucfirst(str_replace('_', ' ', $payment->payment_method)) }}</td>
                                        <td>
                                            <span class="badge bg-{{ $payment->payment_status == 'completed' ? 'success' : 'warning' }}">
                                                {{ ucfirst($payment->payment_status) }}
                                            </span>
                                        </td>
                                        <td>{{ $payment->created_at->format('d M Y') }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    @endif
                    
                    @if($checkOut->notes)
                    <div class="mt-3">
                        <h5>Notes</h5>
                        <p>{{ $checkOut->notes }}</p>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection