@extends('backend.layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Floors</h3>
                    <div class="card-tools">
                        <a href="{{ route('floors.create') }}" class="btn btn-primary">
                            <i class="fas fa-plus"></i> New Floor
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>Property</th>
                                <th>Floor Number</th>
                                <th>Name</th>
                                <th>Rooms Count</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($floors as $floor)
                            <tr>
                                <td>{{ $floor->property->name }}</td>
                                <td>{{ $floor->floor_number }}</td>
                                <td>{{ $floor->name }}</td>
                                <td>{{ $floor->rooms->count() }}</td>
                                <td>
                                    <a href="{{ route('floors.show', $floor->id) }}" class="btn btn-sm btn-info">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('floors.edit', $floor->id) }}" class="btn btn-sm btn-warning">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('floors.destroy', $floor->id) }}" method="POST" style="display: inline;">
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