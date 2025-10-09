@extends('backend.layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Service Details</h3>
                    <div class="card-tools">
                        <a href="{{ route('services.edit', $service->id) }}" class="btn btn-warning">
                            <i class="fas fa-edit"></i> Edit
                        </a>
                        <a href="{{ route('services.index') }}" class="btn btn-default">
                            <i class="fas fa-arrow-left"></i> Back
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <p><strong>Name:</strong> {{ $service->name }}</p>
                            <p><strong>Description:</strong> {{ $service->description ?: 'N/A' }}</p>
                        </div>
                        <div class="col-md-6">
                            <p><strong>Price:</strong> {{ number_format($service->price, 2) }}</p>
                            <p><strong>Status:</strong> 
                                <span class="badge bg-{{ $service->is_active ? 'success' : 'danger' }}">
                                    {{ $service->is_active ? 'Active' : 'Inactive' }}
                                </span>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection