@extends('backend.layouts.app')

@section('title', 'Rooms Management')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header bg-primary">
                    <h3 class="card-title text-white">
                        <i class="fas fa-bed"></i> Rooms Management
                    </h3>
                    <div class="card-tools">
                        <a href="{{ route('rooms.create') }}" class="btn btn-light btn-sm">
                            <i class="fas fa-plus-circle"></i> Add New Room
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

                    @if(session('error'))
                        <div class="alert alert-danger alert-dismissible">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                            <i class="icon fas fa-ban"></i> {{ session('error') }}
                        </div>
                    @endif

                    @if($rooms->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped table-hover">
                            <thead class="thead-dark">
                                <tr>
                                    <th>#</th>
                                    <th>Room Number</th>
                                    <th>Property</th>
                                    <th>Room Type</th>
                                    <th>Floor</th>
                                    <th>Status</th>
                                    <th>Smoking</th>
                                    <th>Current Booking</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($rooms as $room)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>
                                        <strong>{{ $room->room_number }}</strong>
                                    </td>
                                    <td>{{ $room->property->name ?? 'N/A' }}</td>
                                    <td>{{ $room->roomType->name ?? 'N/A' }}</td>
                                    <td>{{ $room->floor->name ?? 'N/A' }}</td>
                                    <td>
                                        <span class="{{ $room->getStatusBadgeClass() }}">
                                            {{ ucfirst($room->status) }}
                                        </span>
                                    </td>
                                    <td>
                                        @if($room->is_smoking)
                                            <span class="badge bg-danger">Smoking</span>
                                        @else
                                            <span class="badge bg-success">Non-Smoking</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($room->currentBooking)
                                            <small class="text-primary">
                                                {{ $room->currentBooking->guest->full_name ?? 'Guest' }}
                                            </small>
                                        @else
                                            <span class="text-muted">No Booking</span>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="btn-group btn-group-sm">
                                            <a href="{{ route('rooms.show', $room->id) }}" 
                                               class="btn btn-info" 
                                               title="View Details">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <a href="{{ route('rooms.edit', $room->id) }}" 
                                               class="btn btn-warning" 
                                               title="Edit Room">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            
                                            <!-- Quick Status Buttons -->
                                            @if($room->status != 'available')
                                            <form action="{{ route('rooms.mark-available', $room->id) }}" 
                                                  method="POST" 
                                                  style="display: inline;">
                                                @csrf
                                                <button type="submit" 
                                                        class="btn btn-success" 
                                                        title="Mark as Available"
                                                        onclick="return confirm('Mark this room as available?')">
                                                    <i class="fas fa-check"></i>
                                                </button>
                                            </form>
                                            @endif

                                            @if($room->status != 'occupied')
                                            <form action="{{ route('rooms.mark-occupied', $room->id) }}" 
                                                  method="POST" 
                                                  style="display: inline;">
                                                @csrf
                                                <button type="submit" 
                                                        class="btn btn-primary" 
                                                        title="Mark as Occupied"
                                                        onclick="return confirm('Mark this room as occupied?')">
                                                    <i class="fas fa-user"></i>
                                                </button>
                                            </form>
                                            @endif

                                            @if($room->status != 'maintenance')
                                            <form action="{{ route('rooms.mark-maintenance', $room->id) }}" 
                                                  method="POST" 
                                                  style="display: inline;">
                                                @csrf
                                                <button type="submit" 
                                                        class="btn btn-warning" 
                                                        title="Mark as Maintenance"
                                                        onclick="return confirm('Mark this room as maintenance?')">
                                                    <i class="fas fa-tools"></i>
                                                </button>
                                            </form>
                                            @endif

                                            <form action="{{ route('rooms.destroy', $room->id) }}" 
                                                  method="POST" 
                                                  style="display: inline;"
                                                  onsubmit="return confirm('Are you sure you want to delete this room?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" 
                                                        class="btn btn-danger" 
                                                        title="Delete Room">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    @else
                    <div class="text-center py-4">
                        <i class="fas fa-bed fa-3x text-muted mb-3"></i>
                        <h4 class="text-muted">No Rooms Found</h4>
                        <p class="text-muted">Get started by adding your first room.</p>
                        <a href="{{ route('rooms.create') }}" class="btn btn-primary">
                            <i class="fas fa-plus"></i> Add First Room
                        </a>
                    </div>
                    @endif
                </div>
                @if($rooms->count() > 0)
                <div class="card-footer">
                    <div class="row">
                        <div class="col-md-6">
                            <p class="text-muted">
                                Showing <strong>{{ $rooms->count() }}</strong> rooms
                            </p>
                        </div>
                        <div class="col-md-6 text-right">
                            <!-- Add pagination if needed -->
                        </div>
                    </div>
                </div>
                @endif
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

        // DataTable initialization if needed
        // $('.table').DataTable();
    });
</script>
@endsection