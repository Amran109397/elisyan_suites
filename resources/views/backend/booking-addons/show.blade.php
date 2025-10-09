@extends('backend.layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Booking Addon Details</h3>
                    <div class="card-tools">
                        <a href="{{ route('booking-addons.edit', $bookingAddon->id) }}" class="btn btn-warning">
                            <i class="fas fa-edit"></i> Edit
                        </a>
                        <a href="{{ route('booking-addons.index') }}" class="btn btn-default">
                            <i class="fas fa-arrow-left"></i> Back
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <p><strong>Booking Reference:</strong> {{ $bookingAddon->booking->booking_reference }}</p>
                            <p><strong>Addon:</strong> {{ $bookingAddon->addon->name }}</p>
                            <p><strong>Quantity:</strong> {{ $bookingAddon->quantity }}</p>
                        </div>
                        <div class="col-md-6">
                            <p><strong>Price:</strong> {{ number_format($bookingAddon->price, 2) }}</p>
                            <p><strong>Total:</strong> {{ number_format($bookingAddon->quantity * $bookingAddon->price, 2) }}</p>
                        </div>
                    </div>
                    @if($bookingAddon->notes)
                    <div class="mt-3">
                        <h5>Notes</h5>
                        <p>{{ $bookingAddon->notes }}</p>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection