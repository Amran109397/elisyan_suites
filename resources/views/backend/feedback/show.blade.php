@extends('backend.layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Feedback Details</h3>
                    <div class="card-tools">
                        <a href="{{ route('feedback.edit', $feedback->id) }}" class="btn btn-warning">
                            <i class="fas fa-edit"></i> Edit
                        </a>
                        <a href="{{ route('feedback.index') }}" class="btn btn-default">
                            <i class="fas fa-arrow-left"></i> Back
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <p><strong>Guest:</strong> {{ $feedback->guest->full_name }}</p>
                            <p><strong>Booking:</strong> {{ $feedback->booking ? $feedback->booking->booking_reference : 'N/A' }}</p>
                            <p><strong>Category:</strong> {{ $feedback->category }}</p>
                        </div>
                        <div class="col-md-6">
                            <p><strong>Rating:</strong> 
                                <div class="rating">
                                    @for($i = 1; $i <= 5; $i++)
                                        @if($i <= $feedback->rating)
                                            <i class="fas fa-star text-warning"></i>
                                        @else
                                            <i class="far fa-star text-warning"></i>
                                        @endif
                                    @endfor
                                    ({{ $feedback->rating }})
                                </div>
                            </p>
                            <p><strong>Status:</strong> 
                                <span class="badge bg-{{ $feedback->status == 'resolved' ? 'success' : ($feedback->status == 'pending' ? 'warning' : 'danger') }}">
                                    {{ ucfirst($feedback->status) }}
                                </span>
                            </p>
                        </div>
                    </div>
                    <div class="mt-3">
                        <h5>Comments</h5>
                        <p>{{ $feedback->comments }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection