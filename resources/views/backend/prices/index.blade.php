@extends('backend.layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Prices</h3>
                    <div class="card-tools">
                        <a href="{{ route('prices.create') }}" class="btn btn-primary">
                            <i class="fas fa-plus"></i> New Price
                        </a>
                        <button type="button" class="btn btn-info" data-bs-toggle="modal" data-bs-target="#bulkPriceModal">
                            <i class="fas fa-calendar-plus"></i> Bulk Prices
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-md-4">
                            <select class="form-select" id="roomTypeFilter">
                                <option value="">All Room Types</option>
                                @foreach($roomTypes as $roomType)
                                    <option value="{{ $roomType->id }}">{{ $roomType->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-4">
                            <input type="date" class="form-control" id="startDateFilter" placeholder="Start Date">
                        </div>
                        <div class="col-md-4">
                            <input type="date" class="form-control" id="endDateFilter" placeholder="End Date">
                        </div>
                    </div>
                    
                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>Room Type</th>
                                <th>Date</th>
                                <th>Price</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($prices as $price)
                            <tr>
                                <td>{{ $price->roomType->name }}</td>
                                <td>{{ $price->date->format('d M Y') }}</td>
                                <td>{{ number_format($price->price, 2) }}</td>
                                <td>
                                    <a href="{{ route('prices.show', $price->id) }}" class="btn btn-sm btn-info">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('prices.edit', $price->id) }}" class="btn btn-sm btn-warning">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('prices.destroy', $price->id) }}" method="POST" style="display: inline;">
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

<!-- Bulk Price Modal -->
<div class="modal fade" id="bulkPriceModal" tabindex="-1" aria-labelledby="bulkPriceModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="bulkPriceModalLabel">Create Bulk Prices</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('prices.bulk-store') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="bulk_room_type_id" class="form-label">Room Type</label>
                        <select class="form-select" id="bulk_room_type_id" name="room_type_id" required>
                            <option value="">Select Room Type</option>
                            @foreach($roomTypes as $roomType)
                                <option value="{{ $roomType->id }}">{{ $roomType->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="bulk_start_date" class="form-label">Start Date</label>
                        <input type="date" class="form-control" id="bulk_start_date" name="start_date" required>
                    </div>
                    <div class="mb-3">
                        <label for="bulk_end_date" class="form-label">End Date</label>
                        <input type="date" class="form-control" id="bulk_end_date" name="end_date" required>
                    </div>
                    <div class="mb-3">
                        <label for="bulk_price" class="form-label">Price</label>
                        <input type="number" class="form-control" id="bulk_price" name="price" step="0.01" min="0" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Create Bulk Prices</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    $(document).ready(function() {
        // Filter functionality
        $('#roomTypeFilter, #startDateFilter, #endDateFilter').on('change', function() {
            var roomTypeId = $('#roomTypeFilter').val();
            var startDate = $('#startDateFilter').val();
            var endDate = $('#endDateFilter').val();
            
            var url = new URL(window.location.href);
            if (roomTypeId) url.searchParams.set('room_type_id', roomTypeId);
            if (startDate) url.searchParams.set('start_date', startDate);
            if (endDate) url.searchParams.set('end_date', endDate);
            
            window.location.href = url.toString();
        });
    });
</script>
@endpush