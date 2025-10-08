@extends('backend.layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Price Details</h3>
                    <div class="card-tools">
                        <a href="{{ route('prices.edit', $price->id) }}" class="btn btn-warning">
                            <i class="fas fa-edit"></i> Edit
                        </a>
                        <a href="{{ route('prices.index') }}" class="btn btn-default">
                            <i class="fas fa-arrow-left"></i> Back
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <p><strong>Room Type:</strong> {{ $price->roomType->name }}</p>
                            <p><strong>Property:</strong> {{ $price->roomType->property->name }}</p>
                            <p><strong>Date:</strong> {{ $price->date->format('d M Y') }}</p>
                            <p><strong>Price:</strong> {{ number_format($price->price, 2) }}</p>
                        </div>
                        <div class="col-md-6">
                            <p><strong>Base Price:</strong> {{ number_format($price->roomType->base_price, 2) }}</p>
                            <p><strong>Price Difference:</strong> 
                                @if($price->price > $price->roomType->base_price)
                                    <span class="text-success">+{{ number_format($price->price - $price->roomType->base_price, 2) }}</span>
                                @elseif($price->price < $price->roomType->base_price)
                                    <span class="text-danger">{{ number_format($price->price - $price->roomType->base_price, 2) }}</span>
                                @else
                                    <span class="text-muted">0.00</span>
                                @endif
                            </p>
                            <p><strong>Created At:</strong> {{ $price->created_at->format('d M Y, h:i A') }}</p>
                            <p><strong>Updated At:</strong> {{ $price->updated_at->format('d M Y, h:i A') }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection