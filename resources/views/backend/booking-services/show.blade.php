@extends('backend.layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Booking Service Details</h3>
                    <div class="card-tools">
                        <a href="{{ route('booking-services.edit', $bookingService->id) }}" class="btn btn-warning">
                            <i class="fas fa-edit"></i> Edit
                        </a>
                        <a href="{{ route('booking-services.index') }}" class="btn btn-default">
                            <i class="fas fa-arrow-left"></i> Back
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <p><strong>Booking Reference:</strong> {{ $bookingService->booking->booking_reference }}</p>
                            <p><strong>Service:</strong> {{ $bookingService->service->name }}</p>
                            <p><strong>Quantity:</strong> {{ $bookingService->quantity }}</p>
                        </div>
                        <div class="col-md-6">
                            <p><strong>Price:</strong> {{ number_format($bookingService->price, 2) }}</p>
                            <p><strong>Total:</strong> {{ number_format($bookingService->quantity * $bookingService->price, 2) }}</p>
                        </div>
                    </div>
                    @if($bookingService->notes)
                    <div class="mt-3">
                        <h5>Notes</h5>
                        <p>{{ $bookingService->notes }}</p>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection