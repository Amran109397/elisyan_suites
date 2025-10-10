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
                    <!-- Search and Filter Section -->
                    <div class="row mb-3">
                        <div class="col-md-3">
                            <input type="text" class="form-control" id="searchBookings" placeholder="Search bookings...">
                        </div>
                        <div class="col-md-3">
                            <select class="form-select" id="filterStatus">
                                <option value="">All Status</option>
                                <option value="pending">Pending</option>
                                <option value="confirmed">Confirmed</option>
                                <option value="checked_in">Checked In</option>
                                <option value="checked_out">Checked Out</option>
                                <option value="cancelled">Cancelled</option>
                                <option value="no_show">No Show</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <select class="form-select" id="filterProperty">
                                <option value="">All Properties</option>
                                @foreach($properties = App\Models\Property::all() as $property)
                                    <option value="{{ $property->id }}">{{ $property->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-3">
                            <input type="date" class="form-control" id="filterDate">
                        </div>
                    </div>

                    <table class="table table-bordered table-striped table-hover" id="bookingsTable">
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
                                <td>{{ $booking->booking_reference ?? 'N/A' }}</td>
                                <td>{{ $booking->guest->full_name ?? 'N/A' }}</td>
                                <td>{{ $booking->property->name ?? 'N/A' }}</td>
                                <td>{{ $booking->room ? $booking->room->room_number : 'Not assigned' }}</td>
                                <td>{{ $booking->check_in_date }}</td>
                                <td>{{ $booking->check_out_date }}</td>
                                <td>
                                    <span class="badge bg-{{ $booking->status == 'confirmed' ? 'success' : ($booking->status == 'pending' ? 'warning' : ($booking->status == 'checked_in' ? 'info' : ($booking->status == 'cancelled' ? 'danger' : 'secondary'))) }}">
                                        {{ ucfirst($booking->status) }}
                                    </span>
                                </td>
                                <td>${{ number_format($booking->total_price, 2) }}</td>
                                <td>
                                    <div class="btn-group">
                                        <a href="{{ route('bookings.show', $booking->id) }}" class="btn btn-sm btn-info" title="View">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="{{ route('bookings.edit', $booking->id) }}" class="btn btn-sm btn-warning" title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        
                                        <!-- Quick Actions -->
                                        @if($booking->status == 'pending')
                                            <form action="{{ route('bookings.confirm', $booking->id) }}" method="POST" style="display: inline;">
                                                @csrf
                                                <button type="submit" class="btn btn-sm btn-success" title="Confirm Booking" onclick="return confirm('Confirm this booking?')">
                                                    <i class="fas fa-check"></i>
                                                </button>
                                            </form>
                                        @endif
                                        
                                        @if(!in_array($booking->status, ['cancelled', 'checked_out']))
                                            <form action="{{ route('bookings.cancel', $booking->id) }}" method="POST" style="display: inline;">
                                                @csrf
                                                <button type="submit" class="btn btn-sm btn-danger" title="Cancel Booking" onclick="return confirm('Cancel this booking?')">
                                                    <i class="fas fa-times"></i>
                                                </button>
                                            </form>
                                        @endif
                                        
                                        <form action="{{ route('bookings.destroy', $booking->id) }}" method="POST" style="display: inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger" title="Delete" onclick="return confirm('Are you sure?')">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    
                    <!-- Pagination -->
                    <div class="d-flex justify-content-between align-items-center mt-3">
                        <div>
                            Showing {{ $bookings->firstItem() }} to {{ $bookings->lastItem() }} of {{ $bookings->total() }} entries
                        </div>
                        {{ $bookings->links() }}
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
    // Search functionality
    $('#searchBookings').on('keyup', function() {
        let value = $(this).val().toLowerCase();
        $('#bookingsTable tbody tr').filter(function() {
            $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1);
        });
    });
    
    // Filter functionality
    $('#filterStatus, #filterProperty, #filterDate').on('change', function() {
        let statusValue = $('#filterStatus').val().toLowerCase();
        let propertyValue = $('#filterProperty').val();
        let dateValue = $('#filterDate').val();
        
        $('#bookingsTable tbody tr').filter(function() {
            let statusMatch = statusValue === '' || $(this).find('td:eq(6)').text().toLowerCase().indexOf(statusValue) > -1;
            let propertyMatch = propertyValue === '' || $(this).find('td:eq(2)').text().includes($('#filterProperty option:selected').text());
            let dateMatch = dateValue === '' || $(this).find('td:eq(4)').text().includes(dateValue) || $(this).find('td:eq(5)').text().includes(dateValue);
            
            $(this).toggle(statusMatch && propertyMatch && dateMatch);
        });
    });
});
</script>
@endpush