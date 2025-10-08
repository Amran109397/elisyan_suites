@extends('backend.layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Room Amenities</h3>
                    <div class="card-tools">
                        <a href="{{ route('amenities.create') }}" class="btn btn-primary">
                            <i class="fas fa-plus"></i> New Amenity
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Icon</th>
                                <th>Category</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($amenities as $amenity)
                            <tr>
                                <td>{{ $amenity->name }}</td>
                                <td><i class="{{ $amenity->icon }}"></i> {{ $amenity->icon }}</td>
                                <td>
                                    <span class="badge bg-info">
                                        {{ ucfirst($amenity->category) }}
                                    </span>
                                </td>
                                <td>
                                    <a href="{{ route('amenities.show', $amenity->id) }}" class="btn btn-sm btn-info">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('amenities.edit', $amenity->id) }}" class="btn btn-sm btn-warning">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('amenities.destroy', $amenity->id) }}" method="POST" style="display: inline;">
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