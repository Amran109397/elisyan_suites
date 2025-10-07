@extends('backend.layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Bookings</h3>
                    <div class="card-tools">
                        <a href="{{ route('bookings.create') }}" class="btn btn-primary">
                            <i class="fas fa-plus"></i> New Booking
                        </a>
                        <a href="{{ route('bookings.calendar') }}" class="btn btn-info">
                            <i class="fas fa-calendar"></i> Calendar View
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>Reference</th>
                                <th>Guest</th>
                                <th>Property</th>
                                <th>Room</th>
                                <th>Check-in</th>
                                <th>Check-out</th>
                                <th>Status</th>
                                <th>Total Price</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($bookings as $booking)
                            <tr>
                                <td>{{ $booking->booking_reference }}</td>
                                <td>{{ $booking->guest->full_name }}</td>
                                <td>{{ $booking->property->name }}</td>
                                <td>{{ $booking->room ? $booking->room->room_number : 'Not assigned' }}</td>
                                <td>{{ $booking->check_in_date }}</td>
                                <td>{{ $booking->check_out_date }}</td>
                                <td>
                                    <span class="badge bg-{{ $booking->status == 'confirmed' ? 'success' : ($booking->status == 'pending' ? 'warning' : ($booking->status == 'checked_in' ? 'info' : ($booking->status == 'cancelled' ? 'danger' : 'secondary'))) }}">
                                        {{ ucfirst($booking->status) }}
                                    </span>
                                </td>
                                <td>{{ number_format($booking->total_price, 2) }}</td>
                                <td>
                                    <a href="{{ route('bookings.show', $booking->id) }}" class="btn btn-sm btn-info">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('bookings.edit', $booking->id) }}" class="btn btn-sm btn-warning">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('bookings.destroy', $booking->id) }}" method="POST" style="display: inline;">
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