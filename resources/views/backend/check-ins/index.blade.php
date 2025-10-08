@extends('backend.layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Check-ins</h3>
                    <div class="card-tools">
                        <a href="{{ route('check-ins.create') }}" class="btn btn-primary">
                            <i class="fas fa-plus"></i> New Check-in
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
                                <th>Check-in Time</th>
                                <th>Checked By</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($checkIns as $checkIn)
                            <tr>
                                <td>{{ $checkIn->booking->guest->first_name }} {{ $checkIn->booking->guest->last_name }}</td>
                                <td>{{ $checkIn->booking->booking_reference }}</td>
                                <td>{{ $checkIn->booking->room ? $checkIn->booking->room->room_number : 'Not assigned' }}</td>
                                <td>{{ $checkIn->actual_check_in->format('d M Y, h:i A') }}</td>
                                <td>{{ $checkIn->checkedBy->name }}</td>
                                <td>
                                    <a href="{{ route('check-ins.show', $checkIn->id) }}" class="btn btn-sm btn-info">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('check-ins.edit', $checkIn->id) }}" class="btn btn-sm btn-warning">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('check-ins.destroy', $checkIn->id) }}" method="POST" style="display: inline;">
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