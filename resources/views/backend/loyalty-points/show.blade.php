@extends('backend.layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Loyalty Points Details</h3>
                    <div class="card-tools">
                        <a href="{{ route('loyalty-points.edit', $loyaltyPoint->id) }}" class="btn btn-warning">
                            <i class="fas fa-edit"></i> Edit
                        </a>
                        <a href="{{ route('loyalty-points.index') }}" class="btn btn-default">
                            <i class="fas fa-arrow-left"></i> Back
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <p><strong>Member:</strong> {{ $loyaltyPoint->loyaltyMember->guest->full_name }}</p>
                            <p><strong>Booking:</strong> {{ $loyaltyPoint->booking ? $loyaltyPoint->booking->booking_reference : 'N/A' }}</p>
                            <p><strong>Points:</strong> {{ $loyaltyPoint->points }}</p>
                        </div>
                        <div class="col-md-6">
                            <p><strong>Type:</strong> {{ $loyaltyPoint->type }}</p>
                            <p><strong>Description:</strong> {{ $loyaltyPoint->description }}</p>
                            <p><strong>Expiry Date:</strong> {{ $loyaltyPoint->expiry_date ? $loyaltyPoint->expiry_date->format('d M Y') : 'N/A' }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection