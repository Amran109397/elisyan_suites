@extends('backend.layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Room Image Details</h3>
                    <div class="card-tools">
                        <a href="{{ route('room-images.edit', $roomImage->id) }}" class="btn btn-warning">
                            <i class="fas fa-edit"></i> Edit
                        </a>
                        <a href="{{ route('room-images.index') }}" class="btn btn-default">
                            <i class="fas fa-arrow-left"></i> Back
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <p><strong>Room Type:</strong> {{ $roomImage->roomType->name }}</p>
                            <p><strong>Alt Text:</strong> {{ $roomImage->alt_text }}</p>
                            <p><strong>Display Order:</strong> {{ $roomImage->display_order }}</p>
                            <p><strong>Primary:</strong> 
                                @if($roomImage->is_primary)
                                    <span class="badge bg-success">Yes</span>
                                @else
                                    <span class="badge bg-secondary">No</span>
                                @endif
                            </p>
                        </div>
                        <div class="col-md-6">
                            <p><strong>Created At:</strong> {{ $roomImage->created_at->format('d M Y, h:i A') }}</p>
                            <p><strong>Updated At:</strong> {{ $roomImage->updated_at->format('d M Y, h:i A') }}</p>
                        </div>
                    </div>
                    
                    <div class="mt-4">
                        <h5>Image Preview</h5>
                        <img src="{{ asset('storage/' . $roomImage->image_path) }}" alt="{{ $roomImage->alt_text }}" class="img-fluid" style="max-width: 100%; max-height: 400px;">
                    </div>
                    
                    <div class="mt-4">
                        <h5>Actions</h5>
                        <div class="btn-group">
                            @if(!$roomImage->is_primary)
                            <form action="{{ route('room-images.set-primary', $roomImage->id) }}" method="POST" style="display: inline;">
                                @csrf
                                @method('PATCH')
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-star"></i> Set as Primary
                                </button>
                            </form>
                            @endif
                            
                            <form action="{{ route('room-images.destroy', $roomImage->id) }}" method="POST" style="display: inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure? This will permanently delete the image.')">
                                    <i class="fas fa-trash"></i> Delete
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection