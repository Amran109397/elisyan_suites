@extends('backend.layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Loyalty Points</h3>
                    <div class="card-tools">
                        <a href="{{ route('loyalty-points.create') }}" class="btn btn-primary">
                            <i class="fas fa-plus"></i> New Points
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>Member</th>
                                <th>Booking</th>
                                <th>Points</th>
                                <th>Type</th>
                                <th>Description</th>
                                <th>Expiry Date</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($loyaltyPoints as $loyaltyPoint)
                            <tr>
                                <td>{{ $loyaltyPoint->loyaltyMember->guest->full_name }}</td>
                                <td>{{ $loyaltyPoint->booking ? $loyaltyPoint->booking->booking_reference : 'N/A' }}</td>
                                <td>{{ $loyaltyPoint->points }}</td>
                                <td>{{ $loyaltyPoint->type }}</td>
                                <td>{{ $loyaltyPoint->description }}</td>
                                <td>{{ $loyaltyPoint->expiry_date ? $loyaltyPoint->expiry_date->format('d M Y') : 'N/A' }}</td>
                                <td>
                                    <a href="{{ route('loyalty-points.show', $loyaltyPoint->id) }}" class="btn btn-sm btn-info">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('loyalty-points.edit', $loyaltyPoint->id) }}" class="btn btn-sm btn-warning">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('loyalty-points.destroy', $loyaltyPoint->id) }}" method="POST" style="display: inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection