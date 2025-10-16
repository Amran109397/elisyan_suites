@extends('backend.layouts.app')

@section('title', 'Room Details - ' . $room->room_number)

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header bg-info">
                    <h3 class="card-title text-white">
                        <i class="fas fa-bed"></i> Room Details: {{ $room->room_number }}
                    </h3>
                    <div class="card-tools">
                        <a href="{{ route('rooms.edit', $room->id) }}" class="btn btn-warning btn-sm">
                            <i class="fas fa-edit"></i> Edit
                        </a>
                        <a href="{{ route('rooms.index') }}" class="btn btn-light btn-sm">
                            <i class="fas fa-arrow-left"></i> Back to Rooms
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                            <i class="icon fas fa-check"></i> {{ session('success') }}
                        </div>
                    @endif

                    <div class="row">
                        <div class="col-md-6">
                            <div class="card">
                                <div class="card-header bg-light">
                                    <h4 class="card-title">Basic Information</h4>
                                </div>
                                <div class="card-body">
                                    <table class="table table-bordered">
                                        <tr>
                                            <th width="40%">Room Number:</th>
                                            <td><strong>{{ $room->room_number }}</strong></td>
                                        </tr>
                                        <tr>
                                            <th>Property:</th>
                                            <td>{{ $room->property->name ?? 'N/A' }}</td>
                                        </tr>
                                        <tr>
                                            <th>Room Type:</th>
                                            <td>{{ $room->roomType->name ?? 'N/A' }}</td>
                                        </tr>
                                        <tr>
                                            <th>Floor:</th>
                                            <td>{{ $room->floor->name ?? 'N/A' }}</td>
                                        </tr>
                                        <tr>
                                            <th>Status:</th>
                                            <td>
                                                <span class="{{ $room->getStatusBadgeClass() }}">
                                                    {{ ucfirst($room->status) }}
                                                </span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>Smoking:</th>
                                            <td>
                                                @if($room->is_smoking)
                                                    <span class="badge bg-danger">Smoking Room</span>
                                                @else
                                                    <span class="badge bg-success">Non-Smoking Room</span>
                                                @endif
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>Created At:</th>
                                            <td>{{ $room->created_at->format('M d, Y h:i A') }}</td>
                                        </tr>
                                        <tr>
                                            <th>Last Updated:</th>
                                            <td>{{ $room->updated_at->format('M d, Y h:i A') }}</td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="card">
                                <div class="card-header bg-light">
                                    <h4 class="card-title">Current Status & Actions</h4>
                                </div>
                                <div class="card-body">
                                    <!-- Quick Status Actions -->
                                    <div class="mb-4">
                                        <h5>Quick Status Update:</h5>
                                        <div class="btn-group btn-group-sm">
                                            @if($room->status != 'available')
                                            <form action="{{ route('rooms.mark-available', $room->id) }}" method="POST" class="d-inline">
                                                @csrf
                                                <button type="submit" class="btn btn-success" 
                                                        onclick="return confirm('Mark this room as available?')">
                                                    <i class="fas fa-check"></i> Available
                                                </button>
                                            </form>
                                            @endif

                                            @if($room->status != 'occupied')
                                            <form action="{{ route('rooms.mark-occupied', $room->id) }}" method="POST" class="d-inline">
                                                @csrf
                                                <button type="submit" class="btn btn-primary" 
                                                        onclick="return confirm('Mark this room as occupied?')">
                                                    <i class="fas fa-user"></i> Occupied
                                                </button>
                                            </form>
                                            @endif

                                            @if($room->status != 'maintenance')
                                            <form action="{{ route('rooms.mark-maintenance', $room->id) }}" method="POST" class="d-inline">
                                                @csrf
                                                <button type="submit" class="btn btn-warning" 
                                                        onclick="return confirm('Mark this room as maintenance?')">
                                                    <i class="fas fa-tools"></i> Maintenance
                                                </button>
                                            </form>
                                            @endif
                                        </div>
                                    </div>

                                    <!-- Detailed Status Update Form -->
                                    <div class="mt-4">
                                        <h5>Detailed Status Update:</h5>
                                        <form action="{{ route('rooms.update-status', $room->id) }}" method="POST">
                                            @csrf
                                            <div class="form-group">
                                                <label for="status">Status</label>
                                                <select class="form-control" id="status" name="status" required>
                                                    <option value="available" {{ $room->status == 'available' ? 'selected' : '' }}>Available</option>
                                                    <option value="occupied" {{ $room->status == 'occupied' ? 'selected' : '' }}>Occupied</option>
                                                    <option value="maintenance" {{ $room->status == 'maintenance' ? 'selected' : '' }}>Maintenance</option>
                                                    <option value="cleaning" {{ $room->status == 'cleaning' ? 'selected' : '' }}>Cleaning</option>
                                                    <option value="out_of_service" {{ $room->status == 'out_of_service' ? 'selected' : '' }}>Out of Service</option>
                                                    <option value="blocked" {{ $room->status == 'blocked' ? 'selected' : '' }}>Blocked</option>
                                                    <option value="renovation" {{ $room->status == 'renovation' ? 'selected' : '' }}>Renovation</option>
                                                </select>
                                            </div>
                                            <div class="form-group">
                                                <label for="notes">Notes (Optional)</label>
                                                <textarea class="form-control" id="notes" name="notes" rows="3" 
                                                          placeholder="Add notes about status change..."></textarea>
                                            </div>
                                            <div class="form-group">
                                                <button type="submit" class="btn btn-primary btn-sm">
                                                    <i class="fas fa-sync-alt"></i> Update Status
                                                </button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Current Booking Information -->
                    <div class="row mt-4">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header bg-light">
                                    <h4 class="card-title">Current Booking Information</h4>
                                </div>
                                <div class="card-body">
                                    @if($room->currentBooking)
                                    <div class="alert alert-info">
                                        <h5><i class="fas fa-calendar-check"></i> Currently Booked</h5>
                                        <table class="table table-sm">
                                            <tr>
                                                <th width="30%">Guest Name:</th>
                                                <td>{{ $room->currentBooking->guest->full_name ?? 'N/A' }}</td>
                                            </tr>
                                            <tr>
                                                <th>Check-in Date:</th>
                                                <td>{{ \Carbon\Carbon::parse($room->currentBooking->check_in_date)->format('M d, Y') }}</td>
                                            </tr>
                                            <tr>
                                                <th>Check-out Date:</th>
                                                <td>{{ \Carbon\Carbon::parse($room->currentBooking->check_out_date)->format('M d, Y') }}</td>
                                            </tr>
                                            <tr>
                                                <th>Booking Status:</th>
                                                <td>
                                                    <span class="badge bg-success">
                                                        {{ ucfirst($room->currentBooking->status) }}
                                                    </span>
                                                </td>
                                            </tr>
                                        </table>
                                    </div>
                                    @else
                                    <div class="alert alert-warning">
                                        <i class="fas fa-info-circle"></i> No current booking for this room.
                                    </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="row mt-4">
                        <div class="col-12 text-center">
                            <div class="btn-group">
                                <a href="{{ route('rooms.edit', $room->id) }}" class="btn btn-warning">
                                    <i class="fas fa-edit"></i> Edit Room
                                </a>
                                <a href="{{ route('rooms.index') }}" class="btn btn-secondary">
                                    <i class="fas fa-list"></i> All Rooms
                                </a>
                                <form action="{{ route('rooms.destroy', $room->id) }}" method="POST" class="d-inline"
                                      onsubmit="return confirm('Are you sure you want to delete this room? This action cannot be undone.')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger">
                                        <i class="fas fa-trash"></i> Delete Room
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    $(document).ready(function() {
        // Auto-hide alerts after 5 seconds
        setTimeout(function() {
            $('.alert').fadeOut('slow');
        }, 5000);
    });
</script>
@endsection