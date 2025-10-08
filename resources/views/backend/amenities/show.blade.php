@extends('backend.layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Amenity Details</h3>
                    <div class="card-tools">
                        <a href="{{ route('amenities.edit', $amenity->id) }}" class="btn btn-warning">
                            <i class="fas fa-edit"></i> Edit
                        </a>
                        <a href="{{ route('amenities.index') }}" class="btn btn-default">
                            <i class="fas fa-arrow-left"></i> Back
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <p><strong>Name:</strong> {{ $amenity->name }}</p>
                            <p><strong>Icon:</strong> <i class="{{ $amenity->icon }}"></i> {{ $amenity->icon }}</p>
                            <p><strong>Category:</strong> 
                                <span class="badge bg-info">{{ ucfirst($amenity->category) }}</span>
                            </p>
                        </div>
                        <div class="col-md-6">
                            <p><strong>Used in Room Types:</strong> {{ $amenity->roomTypes->count() }}</p>
                            <p><strong>Created At:</strong> {{ $amenity->created_at->format('d M Y, h:i A') }}</p>
                            <p><strong>Updated At:</strong> {{ $amenity->updated_at->format('d M Y, h:i A') }}</p>
                        </div>
                    </div>
                    
                    @if($amenity->roomTypes->count() > 0)
                    <div class="mt-4">
                        <h5>Room Types with this Amenity</h5>
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Room Type</th>
                                    <th>Property</th>
                                    <th>Base Price</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($amenity->roomTypes as $roomType)
                                    <tr>
                                        <td>{{ $roomType->name }}</td>
                                        <td>{{ $roomType->property->name }}</td>
                                        <td>{{ number_format($roomType->base_price, 2) }}</td>
                                        <td>
                                            <a href="{{ route('room-types.show', $roomType->id) }}" class="btn btn-sm btn-info">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection