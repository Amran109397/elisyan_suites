@extends('backend.layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Guest Details</h3>
                    <div class="card-tools">
                        <a href="{{ route('guests.edit', $guest->id) }}" class="btn btn-warning">
                            <i class="fas fa-edit"></i> Edit
                        </a>
                        <a href="{{ route('guests.index') }}" class="btn btn-default">
                            <i class="fas fa-arrow-left"></i> Back
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <p><strong>Name:</strong> {{ $guest->full_name }}</p>
                            <p><strong>Email:</strong> {{ $guest->email }}</p>
                            <p><strong>Phone:</strong> {{ $guest->phone }}</p>
                            <p><strong>Date of Birth:</strong> {{ $guest->date_of_birth }}</p>
                            <p><strong>Nationality:</strong> {{ $guest->nationality }}</p>
                        </div>
                        <div class="col-md-6">
                            <p><strong>ID Type:</strong> {{ ucfirst(str_replace('_', ' ', $guest->id_type)) }}</p>
                            <p><strong>ID Number:</strong> {{ $guest->id_number }}</p>
                            <p><strong>VIP Status:</strong> {{ $guest->vip_status ? 'Yes' : 'No' }}</p>
                            @if($guest->id_image_path)
                                <p><strong>ID Image:</strong><br>
                                <img src="{{ asset('storage/' . $guest->id_image_path) }}" alt="ID Image" width="100">
                                </p>
                            @endif
                        </div>
                    </div>
                    <div class="mt-3">
                        <h5>Address</h5>
                        <p>{{ $guest->address }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="row mt-4">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title">Bookings</h5>
                </div>
                <div class="card-body">
                    @if($guest->bookings->count() > 0)
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Booking Reference</th>
                                    <th>Property</th>
                                    <th>Check-in</th>
                                    <th>Check-out</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($guest->bookings as $booking)
                                    <tr>
                                        <td>{{ $booking->booking_reference }}</td>
                                        <td>{{ $booking->property->name }}</td>
                                        <td>{{ $booking->check_in_date }}</td>
                                        <td>{{ $booking->check_out_date }}</td>
                                        <td>
                                            <span class="badge bg-{{ $booking->status == 'confirmed' ? 'success' : ($booking->status == 'pending' ? 'warning' : 'secondary') }}">
                                                {{ ucfirst($booking->status) }}
                                            </span>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @else
                        <p>No bookings found.</p>
                    @endif
                </div>
            </div>
        </div>
        
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title">Preferences</h5>
                </div>
                <div class="card-body">
                    @if($guest->preferences->count() > 0)
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Type</th>
                                    <th>Preference</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($guest->preferences as $preference)
                                    <tr>
                                        <td>{{ ucfirst($preference->preference_type) }}</td>
                                        <td>{{ $preference->preference_value }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @else
                        <p>No preferences set.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection