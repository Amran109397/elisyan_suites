@extends('backend.layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Room Types</h3>
                    <div class="card-tools">
                        <a href="{{ route('room-types.create') }}" class="btn btn-primary">
                            <i class="fas fa-plus"></i> Add Room Type
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Property</th>
                                <th>Base Price</th>
                                <th>Max Occupancy</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($roomTypes as $roomType)
                            <tr>
                                <td>{{ $roomType->id }}</td>
                                <td>{{ $roomType->name }}</td>
                                <td>{{ $roomType->property->name }}</td>
                                <td>{{ number_format($roomType->base_price, 2) }}</td>
                                <td>{{ $roomType->max_occupancy }}</td>
                                <td>
                                    <span class="badge bg-{{ $roomType->is_active ? 'success' : 'danger' }}">
                                        {{ $roomType->is_active ? 'Active' : 'Inactive' }}
                                    </span>
                                </td>
                                <td>
                                    <a href="{{ route('room-types.show', $roomType->id) }}" class="btn btn-sm btn-info">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('room-types.edit', $roomType->id) }}" class="btn btn-sm btn-warning">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('room-types.destroy', $roomType->id) }}" method="POST" style="display: inline;">
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