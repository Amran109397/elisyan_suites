@extends('backend.layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Season Details</h3>
                    <div class="card-tools">
                        <a href="{{ route('seasons.edit', $season->id) }}" class="btn btn-warning">
                            <i class="fas fa-edit"></i> Edit
                        </a>
                        <a href="{{ route('seasons.index') }}" class="btn btn-default">
                            <i class="fas fa-arrow-left"></i> Back
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <p><strong>Property:</strong> {{ $season->property->name }}</p>
                            <p><strong>Season Name:</strong> {{ $season->name }}</p>
                            <p><strong>Start Date:</strong> {{ $season->start_date->format('d M Y') }}</p>
                            <p><strong>End Date:</strong> {{ $season->end_date->format('d M Y') }}</p>
                        </div>
                        <div class="col-md-6">
                            <p><strong>Price Adjustment:</strong> 
                                @if($season->price_adjustment > 0)
                                    <span class="text-success">+{{ $season->price_adjustment }}%</span>
                                @elseif($season->price_adjustment < 0)
                                    <span class="text-danger">{{ $season->price_adjustment }}%</span>
                                @else
                                    <span class="text-muted">0%</span>
                                @endif
                            </p>
                            <p><strong>Duration:</strong> {{ $season->start_date->diffInDays($season->end_date) }} days</p>
                            <p><strong>Created At:</strong> {{ $season->created_at->format('d M Y, h:i A') }}</p>
                            <p><strong>Updated At:</strong> {{ $season->updated_at->format('d M Y, h:i A') }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection