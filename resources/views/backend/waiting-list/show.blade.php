@extends('backend.layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Waiting List Details</h3>
                    <div class="card-tools">
                        <a href="{{ route('waiting-list.edit', $waitingList->id) }}" class="btn btn-warning">
                            <i class="fas fa-edit"></i> Edit
                        </a>
                        <a href="{{ route('waiting-list.index') }}" class="btn btn-default">
                            <i class="fas fa-arrow-left"></i> Back
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <p><strong>Guest:</strong> {{ $waitingList->guest->first_name }} {{ $waitingList->guest->last_name }}</p>
                            <p><strong>Property:</strong> {{ $waitingList->property->name }}</p>
                            <p><strong>Room Type:</strong> {{ $waitingList->roomType->name }}</p>
                            <p><strong>Check-in Date:</strong> {{ $waitingList->check_in_date->format('d M Y') }}</p>
                            <p><strong>Check-out Date:</strong> {{ $waitingList->check_out_date->format('d M Y') }}</p>
                        </div>
                        <div class="col-md-6">
                            <p><strong>Adults:</strong> {{ $waitingList->adults }}</p>
                            <p><strong>Children:</strong> {{ $waitingList->children }}</p>
                            <p><strong>Status:</strong> 
                                <span class="badge bg-{{ $waitingList->status == 'waiting' ? 'warning' : ($waitingList->status == 'contacted' ? 'info' : ($waitingList->status == 'booked' ? 'success' : 'danger')) }}">
                                    {{ ucfirst($waitingList->status) }}
                                </span>
                            </p>
                            <p><strong>Priority:</strong> 
                                <span class="badge bg-{{ $waitingList->priority >= 8 ? 'danger' : ($waitingList->priority >= 5 ? 'warning' : 'info') }}">
                                    {{ $waitingList->priority }}
                                </span>
                            </p>
                            <p><strong>Added At:</strong> {{ $waitingList->created_at->format('d M Y, h:i A') }}</p>
                        </div>
                    </div>
                    
                    <div class="mt-4">
                        <h5>Actions</h5>
                        <div class="btn-group">
                            @if($waitingList->status == 'waiting')
                            <form action="{{ route('waiting-list.contact', $waitingList->id) }}" method="POST" style="display: inline;">
                                @csrf
                                @method('PATCH')
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-phone"></i> Mark as Contacted
                                </button>
                            </form>
                            @endif
                            
                            @if($waitingList->status == 'contacted')
                            <form action="{{ route('waiting-list.book', $waitingList->id) }}" method="POST" style="display: inline;">
                                @csrf
                                @method('PATCH')
                                <button type="submit" class="btn btn-success">
                                    <i class="fas fa-check"></i> Mark as Booked
                                </button>
                            </form>
                            @endif
                            
                            <form action="{{ route('waiting-list.destroy', $waitingList->id) }}" method="POST" style="display: inline;">
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