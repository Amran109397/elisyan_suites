@extends('backend.layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Room Status Log Details</h3>
                    <div class="card-tools">
                        <a href="{{ route('room-status-logs.edit', $roomStatusLog->id) }}" class="btn btn-warning">
                            <i class="fas fa-edit"></i> Edit
                        </a>
                        <a href="{{ route('room-status-logs.index') }}" class="btn btn-default">
                            <i class="fas fa-arrow-left"></i> Back
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <p><strong>Room:</strong> {{ $roomStatusLog->room->room_number }}</p>
                            <p><strong>Status:</strong> {{ $roomStatusLog->status }}</p>
                            <p><strong>Changed By:</strong> {{ $roomStatusLog->changedBy->name }}</p>
                        </div>
                        <div class="col-md-6">
                            <p><strong>Date:</strong> {{ $roomStatusLog->created_at->format('d M Y H:i') }}</p>
                            <p><strong>Notes:</strong> {{ $roomStatusLog->notes ?: 'N/A' }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection