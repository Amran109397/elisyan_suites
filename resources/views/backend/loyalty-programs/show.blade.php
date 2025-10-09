@extends('backend.layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Loyalty Program Details</h3>
                    <div class="card-tools">
                        <a href="{{ route('loyalty-programs.edit', $loyaltyProgram->id) }}" class="btn btn-warning">
                            <i class="fas fa-edit"></i> Edit
                        </a>
                        <a href="{{ route('loyalty-programs.index') }}" class="btn btn-default">
                            <i class="fas fa-arrow-left"></i> Back
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <p><strong>Name:</strong> {{ $loyaltyProgram->name }}</p>
                            <p><strong>Description:</strong> {{ $loyaltyProgram->description ?: 'N/A' }}</p>
                        </div>
                        <div class="col-md-6">
                            <p><strong>Points per Currency:</strong> {{ $loyaltyProgram->points_per_currency }}</p>
                            <p><strong>Redemption Rate:</strong> {{ $loyaltyProgram->redemption_rate }}</p>
                            <p><strong>Status:</strong> 
                                <span class="badge bg-{{ $loyaltyProgram->is_active ? 'success' : 'danger' }}">
                                    {{ $loyaltyProgram->is_active ? 'Active' : 'Inactive' }}
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