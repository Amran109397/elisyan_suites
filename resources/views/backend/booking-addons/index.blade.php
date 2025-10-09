@extends('backend.layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Booking Addons</h3>
                    <div class="card-tools">
                        <a href="{{ route('booking-addons.create') }}" class="btn btn-primary">
                            <i class="fas fa-plus"></i> New Addon
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>Booking Reference</th>
                                <th>Addon</th>
                                <th>Quantity</th>
                                <th>Price</th>
                                <th>Total</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($bookingAddons as $bookingAddon)
                            <tr>
                                <td>{{ $bookingAddon->booking->booking_reference }}</td>
                                <td>{{ $bookingAddon->addon->name }}</td>
                                <td>{{ $bookingAddon->quantity }}</td>
                                <td>{{ number_format($bookingAddon->price, 2) }}</td>
                                <td>{{ number_format($bookingAddon->quantity * $bookingAddon->price, 2) }}</td>
                                <td>
                                    <a href="{{ route('booking-addons.show', $bookingAddon->id) }}" class="btn btn-sm btn-info">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('booking-addons.edit', $bookingAddon->id) }}" class="btn btn-sm btn-warning">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('booking-addons.destroy', $bookingAddon->id) }}" method="POST" style="display: inline;">
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