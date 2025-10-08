@extends('backend.layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Check-in Details</h3>
                    <div class="card-tools">
                        <a href="{{ route('check-ins.edit', $checkIn->id) }}" class="btn btn-warning">
                            <i class="fas fa-edit"></i> Edit
                        </a>
                        <a href="{{ route('check-ins.index') }}" class="btn btn-default">
                            <i class="fas fa-arrow-left"></i> Back
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <p><strong>Guest:</strong> {{ $checkIn->booking->guest->first_name }} {{ $checkIn->booking->guest->last_name }}</p>
                            <p><strong>Booking Reference:</strong> {{ $checkIn->booking->booking_reference }}</p>
                            <p><strong>Room:</strong> {{ $checkIn->booking->room ? $checkIn->booking->room->room_number : 'Not assigned' }}</p>
                            <p><strong>Check-in Time:</strong> {{ $checkIn->actual_check_in->format('d M Y, h:i A') }}</p>
                        </div>
                        <div class="col-md-6">
                            <p><strong>Checked By:</strong> {{ $checkIn->checkedBy->name }}</p>
                            <p><strong>ID Document:</strong> {{ $checkIn->id_document_path ?: 'Not provided' }}</p>
                            <p><strong>Booking Status:</strong> 
                                <span class="badge bg-{{ $checkIn->booking->status == 'checked_in' ? 'success' : 'warning' }}">
                                    {{ ucfirst($checkIn->booking->status) }}
                                </span>
                            </p>
                        </div>
                    </div>
                    @if($checkIn->notes)
                    <div class="mt-3">
                        <h5>Notes</h5>
                        <p>{{ $checkIn->notes }}</p>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection