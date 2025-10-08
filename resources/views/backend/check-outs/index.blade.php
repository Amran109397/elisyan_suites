@extends('backend.layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Check-outs</h3>
                    <div class="card-tools">
                        <a href="{{ route('check-outs.create') }}" class="btn btn-primary">
                            <i class="fas fa-plus"></i> New Check-out
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>Guest</th>
                                <th>Booking Reference</th>
                                <th>Room</th>
                                <th>Check-out Time</th>
                                <th>Final Bill</th>
                                <th>Payment Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($checkOuts as $checkOut)
                            <tr>
                                <td>{{ $checkOut->booking->guest->first_name }} {{ $checkOut->booking->guest->last_name }}</td>
                                <td>{{ $checkOut->booking->booking_reference }}</td>
                                <td>{{ $checkOut->booking->room ? $checkOut->booking->room->room_number : 'Not assigned' }}</td>
                                <td>{{ $checkOut->actual_check_out->format('d M Y, h:i A') }}</td>
                                <td>{{ number_format($checkOut->final_bill, 2) }}</td>
                                <td>
                                    <span class="badge bg-{{ $checkOut->payment_status == 'paid' ? 'success' : ($checkOut->payment_status == 'partial' ? 'warning' : 'danger') }}">
                                        {{ ucfirst($checkOut->payment_status) }}
                                    </span>
                                </td>
                                <td>
                                    <a href="{{ route('check-outs.show', $checkOut->id) }}" class="btn btn-sm btn-info">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('check-outs.edit', $checkOut->id) }}" class="btn btn-sm btn-warning">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('check-outs.destroy', $checkOut->id) }}" method="POST" style="display: inline;">
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