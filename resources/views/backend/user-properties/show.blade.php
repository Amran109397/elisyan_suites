@extends('backend.layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">User Property Assignment Details</h3>
                    <div class="card-tools">
                        <a href="{{ route('user-properties.edit', $userProperty->id) }}" class="btn btn-warning">
                            <i class="fas fa-edit"></i> Edit
                        </a>
                        <a href="{{ route('user-properties.index') }}" class="btn btn-default">
                            <i class="fas fa-arrow-left"></i> Back
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <p><strong>User:</strong> {{ $userProperty->user->name }}</p>
                            <p><strong>Property:</strong> {{ $userProperty->property->name }}</p>
                        </div>
                        <div class="col-md-6">
                            <p><strong>Role:</strong> {{ $userProperty->role }}</p>
                            <p><strong>Created At:</strong> {{ $userProperty->created_at->format('d M Y H:i') }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection