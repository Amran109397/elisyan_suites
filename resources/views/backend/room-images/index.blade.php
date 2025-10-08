@extends('backend.layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Room Images</h3>
                    <div class="card-tools">
                        <a href="{{ route('room-images.create') }}" class="btn btn-primary">
                            <i class="fas fa-plus"></i> Upload Image
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>Image</th>
                                <th>Room Type</th>
                                <th>Alt Text</th>
                                <th>Primary</th>
                                <th>Display Order</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($roomImages as $roomImage)
                            <tr>
                                <td>
                                    <img src="{{ asset('storage/' . $roomImage->image_path) }}" alt="{{ $roomImage->alt_text }}" class="img-thumbnail" style="max-width: 100px;">
                                </td>
                                <td>{{ $roomImage->roomType->name }}</td>
                                <td>{{ $roomImage->alt_text }}</td>
                                <td>
                                    @if($roomImage->is_primary)
                                        <span class="badge bg-success">Primary</span>
                                    @else
                                        <span class="badge bg-secondary">No</span>
                                    @endif
                                </td>
                                <td>{{ $roomImage->display_order }}</td>
                                <td>
                                    <a href="{{ route('room-images.show', $roomImage->id) }}" class="btn btn-sm btn-info">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('room-images.edit', $roomImage->id) }}" class="btn btn-sm btn-warning">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    @if(!$roomImage->is_primary)
                                    <form action="{{ route('room-images.set-primary', $roomImage->id) }}" method="POST" style="display: inline;">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" class="btn btn-sm btn-primary" title="Set as Primary">
                                            <i class="fas fa-star"></i>
                                        </button>
                                    </form>
                                    @endif
                                    <form action="{{ route('room-images.destroy', $roomImage->id) }}" method="POST" style="display: inline;">
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