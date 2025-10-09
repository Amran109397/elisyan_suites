@extends('backend.layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Booking Modification Details</h3>
                    <div class="card-tools">
                        <a href="{{ route('booking-modifications.edit', $bookingModification->id) }}" class="btn btn-warning">
                            <i class="fas fa-edit"></i> Edit
                        </a>
                        <a href="{{ route('booking-modifications.index') }}" class="btn btn-default">
                            <i class="fas fa-arrow-left"></i> Back
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <p><strong>Booking Reference:</strong> {{ $bookingModification->booking->booking_reference }}</p>
                            <p><strong>Modification Type:</strong> {{ $bookingModification->modification_type }}</p>
                            <p><strong>Modified By:</strong> {{ $bookingModification->modifiedBy->name }}</p>
                        </div>
                        <div class="col-md-6">
                            <p><strong>Date:</strong> {{ $bookingModification->created_at->format('d M Y H:i') }}</p>
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-md-6">
                            <h5>Old Value</h5>
                            <p>{{ $bookingModification->old_value }}</p>
                        </div>
                        <div class="col-md-6">
                            <h5>New Value</h5>
                            <p>{{ $bookingModification->new_value }}</p>
                        </div>
                    </div>
                    @if($bookingModification->notes)
                    <div class="mt-3">
                        <h5>Notes</h5>
                        <p>{{ $bookingModification->notes }}</p>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection