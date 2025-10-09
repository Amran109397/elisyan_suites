@extends('backend.layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Property Amenity Assignment Details</h3>
                    <div class="card-tools">
                        <a href="{{ route('property-amenities.edit', $propertyAmenity->id) }}" class="btn btn-warning">
                            <i class="fas fa-edit"></i> Edit
                        </a>
                        <a href="{{ route('property-amenities.index') }}" class="btn btn-default">
                            <i class="fas fa-arrow-left"></i> Back
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <p><strong>Property:</strong> {{ $propertyAmenity->property->name }}</p>
                        </div>
                        <div class="col-md-6">
                            <p><strong>Amenity:</strong> {{ $propertyAmenity->amenity->name }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection