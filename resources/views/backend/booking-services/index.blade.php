@extends('backend.layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Booking Services</h3>
                    <div class="card-tools">
                        <a href="{{ route('booking-services.create') }}" class="btn btn-primary">
                            <i class="fas fa-plus"></i> New Service
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>Booking Reference</th>
                                <th>Service</th>
                                <th>Quantity</th>
                                <th>Price</th>
                                <th>Total</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($bookingServices as $bookingService)
                            <tr>
                                <td>{{ $bookingService->booking->booking_reference }}</td>
                                <td>{{ $bookingService->service->name }}</td>
                                <td>{{ $bookingService->quantity }}</td>
                                <td>{{ number_format($bookingService->price, 2) }}</td>
                                <td>{{ number_format($bookingService->quantity * $bookingService->price, 2) }}</td>
                                <td>
                                    <a href="{{ route('booking-services.show', $bookingService->id) }}" class="btn btn-sm btn-info">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('booking-services.edit', $bookingService->id) }}" class="btn btn-sm btn-warning">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('booking-services.destroy', $bookingService->id) }}" method="POST" style="display: inline;">
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