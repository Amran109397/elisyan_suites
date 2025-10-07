@extends('backend.layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Booking Details</h3>
                    <div class="card-tools">
                        <a href="{{ route('bookings.edit', $booking->id) }}" class="btn btn-warning">
                            <i class="fas fa-edit"></i> Edit
                        </a>
                        <a href="{{ route('bookings.index') }}" class="btn btn-default">
                            <i class="fas fa-arrow-left"></i> Back
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <p><strong>Booking Reference:</strong> {{ $booking->booking_reference }}</p>
                            <p><strong>Guest:</strong> {{ $booking->guest->full_name }}</p>
                            <p><strong>Property:</strong> {{ $booking->property->name }}</p>
                            <p><strong>Room Type:</strong> {{ $booking->roomType->name }}</p>
                            <p><strong>Room:</strong> {{ $booking->room ? $booking->room->room_number : 'Not assigned' }}</p>
                        </div>
                        <div class="col-md-6">
                            <p><strong>Check-in Date:</strong> {{ $booking->check_in_date }}</p>
                            <p><strong>Check-out Date:</strong> {{ $booking->check_out_date }}</p>
                            <p><strong>Total Nights:</strong> {{ $booking->total_nights }}</p>
                            <p><strong>Adults:</strong> {{ $booking->adults }}</p>
                            <p><strong>Children:</strong> {{ $booking->children }}</p>
                            <p><strong>Infants:</strong> {{ $booking->infants }}</p>
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-md-6">
                            <p><strong>Status:</strong> 
                                <span class="badge bg-{{ $booking->status == 'confirmed' ? 'success' : ($booking->status == 'pending' ? 'warning' : ($booking->status == 'checked_in' ? 'info' : ($booking->status == 'cancelled' ? 'danger' : 'secondary'))) }}">
                                    {{ ucfirst($booking->status) }}
                                </span>
                            </p>
                            <p><strong>Booking Source:</strong> {{ ucfirst(str_replace('_', ' ', $booking->booking_source)) }}</p>
                            <p><strong>Total Price:</strong> {{ number_format($booking->total_price, 2) }}</p>
                        </div>
                        <div class="col-md-6">
                            <p><strong>Total Paid:</strong> {{ number_format($booking->total_paid, 2) }}</p>
                            <p><strong>Remaining:</strong> {{ number_format($booking->remaining_amount, 2) }}</p>
                            <p><strong>Fully Paid:</strong> {{ $booking->is_fully_paid ? 'Yes' : 'No' }}</p>
                        </div>
                    </div>
                    @if($booking->special_requests)
                    <div class="mt-3">
                        <h5>Special Requests</h5>
                        <p>{{ $booking->special_requests }}</p>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
    
    <div class="row mt-4">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title">Payments</h5>
                    <div class="card-tools">
                        <a href="{{ route('payments.create', ['booking_id' => $booking->id]) }}" class="btn btn-sm btn-primary">
                            <i class="fas fa-plus"></i> Add Payment
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    @if($booking->payments->count() > 0)
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Amount</th>
                                    <th>Method</th>
                                    <th>Type</th>
                                    <th>Status</th>
                                    <th>Date</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($booking->payments as $payment)
                                    <tr>
                                        <td>{{ number_format($payment->amount, 2) }}</td>
                                        <td>{{ ucfirst(str_replace('_', ' ', $payment->payment_method)) }}</td>
                                        <td>{{ ucfirst(str_replace('_', ' ', $payment->payment_type)) }}</td>
                                        <td>
                                            <span class="badge bg-{{ $payment->payment_status == 'completed' ? 'success' : ($payment->payment_status == 'pending' ? 'warning' : 'danger') }}">
                                                {{ ucfirst($payment->payment_status) }}
                                            </span>
                                        </td>
                                        <td>{{ $payment->created_at->format('d M Y') }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @else
                        <p>No payments found.</p>
                    @endif
                </div>
            </div>
        </div>
        
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title">Booking Actions</h5>
                </div>
                <div class="card-body">
                    @if($booking->status == 'pending')
                        <a href="{{ route('bookings.confirm', $booking->id) }}" class="btn btn-success">
                            <i class="fas fa-check"></i> Confirm Booking
                        </a>
                    @endif
                    
                    @if($booking->status == 'confirmed')
                        <a href="{{ route('check-ins.create', ['booking_id' => $booking->id]) }}" class="btn btn-info">
                            <i class="fas fa-sign-in-alt"></i> Check In
                        </a>
                    @endif
                    
                    @if($booking->status == 'checked_in')
                        <a href="{{ route('check-outs.create', ['booking_id' => $booking->id]) }}" class="btn btn-warning">
                            <i class="fas fa-sign-out-alt"></i> Check Out
                        </a>
                    @endif
                    
                    @if(!in_array($booking->status, ['cancelled', 'checked_out']))
                        <a href="{{ route('bookings.cancel', $booking->id) }}" class="btn btn-danger" onclick="return confirm('Are you sure you want to cancel this booking?')">
                            <i class="fas fa-times"></i> Cancel Booking
                        </a>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection