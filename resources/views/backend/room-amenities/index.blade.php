@extends('backend.layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Room Amenities</h3>
                    <div class="card-tools">
                        <a href="{{ route('room-amenities.create') }}" class="btn btn-primary">
                            <i class="fas fa-plus"></i> New Assignment
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>Room</th>
                                <th>Amenity</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($roomAmenities as $roomAmenity)
                            <tr>
                                <td>{{ $roomAmenity->room->room_number }}</td>
                                <td>{{ $roomAmenity->amenity->name }}</td>
                                <td>
                                    <a href="{{ route('room-amenities.show', $roomAmenity->id) }}" class="btn btn-sm btn-info">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('room-amenities.edit', $roomAmenity->id) }}" class="btn btn-sm btn-warning">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('room-amenities.destroy', $roomAmenity->id) }}" method="POST" style="display: inline;">
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