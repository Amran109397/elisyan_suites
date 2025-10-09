@extends('backend.layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Edit Property Amenity Assignment</h3>
                    <div class="card-tools">
                        <a href="{{ route('property-amenities.index') }}" class="btn btn-default">
                            <i class="fas fa-arrow-left"></i> Back
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <form action="{{ route('property-amenities.update', $propertyAmenity->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="property_id">Property <span class="text-danger">*</span></label>
                                    <select class="form-select @error('property_id') is-invalid @enderror" id="property_id" name="property_id" required>
                                        <option value="">Select Property</option>
                                        @foreach($properties as $property)
                                            <option value="{{ $property->id }}" {{ old('property_id', $propertyAmenity->property_id) == $property->id ? 'selected' : '' }}>{{ $property->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('property_id')
                                        <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="amenity_id">Amenity <span class="text-danger">*</span></label>
                                    <select class="form-select @error('amenity_id') is-invalid @enderror" id="amenity_id" name="amenity_id" required>
                                        <option value="">Select Amenity</option>
                                        @foreach($amenities as $amenity)
                                            <option value="{{ $amenity->id }}" {{ old('amenity_id', $propertyAmenity->amenity_id) == $amenity->id ? 'selected' : '' }}>{{ $amenity->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('amenity_id')
                                        <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn btn-primary">Update Assignment</button>
                            <a href="{{ route('property-amenities.index') }}" class="btn btn-default">Cancel</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection