@extends('backend.layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Loyalty Member Details</h3>
                    <div class="card-tools">
                        <a href="{{ route('loyalty-members.edit', $loyaltyMember->id) }}" class="btn btn-warning">
                            <i class="fas fa-edit"></i> Edit
                        </a>
                        <a href="{{ route('loyalty-members.index') }}" class="btn btn-default">
                            <i class="fas fa-arrow-left"></i> Back
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <p><strong>Guest:</strong> {{ $loyaltyMember->guest->full_name }}</p>
                            <p><strong>Program:</strong> {{ $loyaltyMember->loyaltyProgram->name }}</p>
                            <p><strong>Membership Number:</strong> {{ $loyaltyMember->membership_number }}</p>
                        </div>
                        <div class="col-md-6">
                            <p><strong>Join Date:</strong> {{ $loyaltyMember->join_date->format('d M Y') }}</p>
                            <p><strong>Status:</strong> {{ $loyaltyMember->status }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection