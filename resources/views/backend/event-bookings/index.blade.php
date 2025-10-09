@extends('backend.layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Event Bookings</h3>
                    <div class="card-tools">
                        <a href="{{ route('event-bookings.create') }}" class="btn btn-primary">
                            <i class="fas fa-plus"></i> New Event Booking
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-md-4">
                            <input type="text" class="form-control" id="searchEventBookings" placeholder="Search event bookings...">
                        </div>
                        <div class="col-md-4">
                            <select class="form-select" id="filterEvent">
                                <option value="">All Events</option>
                                @foreach($events as $event)
                                    <option value="{{ $event->id }}">{{ $event->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-4">
                            <select class="form-select" id="filterStatus">
                                <option value="">All Status</option>
                                <option value="pending">Pending</option>
                                <option value="confirmed">Confirmed</option>
                                <option value="cancelled">Cancelled</option>
                            </select>
                        </div>
                    </div>
                    
                    <table class="table table-bordered table-striped table-hover" id="eventBookingsTable">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Event</th>
                                <th>Guest</th>
                                <th>Attendees</th>
                                <th>Total Price</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($eventBookings as $eventBooking)
                            <tr>
                                <td>{{ $eventBooking->id }}</td>
                                <td>{{ $eventBooking->event->name }}</td>
                                <td>{{ $eventBooking->guest->full_name }}</td>
                                <td>{{ $eventBooking->number_of_attendees }}</td>
                                <td>{{ number_format($eventBooking->total_price, 2) }}</td>
                                <td>
                                    <span class="badge bg-{{ $eventBooking->status == 'confirmed' ? 'success' : ($eventBooking->status == 'cancelled' ? 'danger' : 'warning') }}">
                                        {{ ucfirst($eventBooking->status) }}
                                    </span>
                                </td>
                                <td>
                                    <a href="{{ route('event-bookings.show', $eventBooking->id) }}" class="btn btn-sm btn-info">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('event-bookings.edit', $eventBooking->id) }}" class="btn btn-sm btn-warning">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    @if($eventBooking->status != 'cancelled')
                                        <form action="{{ route('event-bookings.destroy', $eventBooking->id) }}" method="POST" style="display: inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    
                    <div class="d-flex justify-content-between align-items-center mt-3">
                        <div>
                            Showing {{ $eventBookings->firstItem() }} to {{ $eventBookings->lastItem() }} of {{ $eventBookings->total() }} entries
                        </div>
                        {{ $eventBookings->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
 $(document).ready(function() {
    $('#searchEventBookings').on('keyup', function() {
        let value = $(this).val().toLowerCase();
        $('#eventBookingsTable tbody tr').filter(function() {
            $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1);
        });
    });
    
    $('#filterEvent, #filterStatus').on('change', function() {
        window.location.href = '/event-bookings?' + 
            $.param({
                search: $('#searchEventBookings').val(),
                event: $('#filterEvent').val(),
                status: $('#filterStatus').val()
            });
    });
});
</script>
@endpush