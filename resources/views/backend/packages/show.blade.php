@extends('backend.layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Package Details</h3>
                    <div class="card-tools">
                        <a href="{{ route('packages.edit', $package->id) }}" class="btn btn-warning">
                            <i class="fas fa-edit"></i> Edit
                        </a>
                        <a href="{{ route('packages.index') }}" class="btn btn-default">
                            <i class="fas fa-arrow-left"></i> Back
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <p><strong>Property:</strong> {{ $package->property->name }}</p>
                            <p><strong>Package Name:</strong> {{ $package->name }}</p>
                            <p><strong>Price:</strong> {{ number_format($package->price, 2) }}</p>
                            <p><strong>Status:</strong> 
                                @if($package->is_active)
                                    <span class="badge bg-success">Active</span>
                                @else
                                    <span class="badge bg-secondary">Inactive</span>
                                @endif
                            </p>
                        </div>
                        <div class="col-md-6">
                            <p><strong>Created At:</strong> {{ $package->created_at->format('d M Y, h:i A') }}</p>
                            <p><strong>Updated At:</strong> {{ $package->updated_at->format('d M Y, h:i A') }}</p>
                        </div>
                    </div>
                    
                    @if($package->description)
                    <div class="mt-3">
                        <h5>Description</h5>
                        <p>{{ $package->description }}</p>
                    </div>
                    @endif
                    
                    <div class="mt-4">
                        <h5>Actions</h5>
                        <div class="btn-group">
                            <form action="{{ route('packages.toggle-active', $package->id) }}" method="POST" style="display: inline;">
                                @csrf
                                @method('PATCH')
                                <button type="submit" class="btn {{ $package->is_active ? 'btn-warning' : 'btn-success' }}">
                                    <i class="fas {{ $package->is_active ? 'fa-eye-slash' : 'fa-eye' }}"></i> 
                                    {{ $package->is_active ? 'Deactivate' : 'Activate' }}
                                </button>
                            </form>
                            
                            <form action="{{ route('packages.destroy', $package->id) }}" method="POST" style="display: inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure?')">
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