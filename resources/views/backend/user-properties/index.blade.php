@extends('backend.layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">User Property Assignments</h3>
                    <div class="card-tools">
                        <a href="{{ route('user-properties.create') }}" class="btn btn-primary">
                            <i class="fas fa-plus"></i> New Assignment
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>User</th>
                                <th>Property</th>
                                <th>Role</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($userProperties as $userProperty)
                            <tr>
                                <td>{{ $userProperty->user->name }}</td>
                                <td>{{ $userProperty->property->name }}</td>
                                <td>{{ $userProperty->role }}</td>
                                <td>
                                    <a href="{{ route('user-properties.show', $userProperty->id) }}" class="btn btn-sm btn-info">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('user-properties.edit', $userProperty->id) }}" class="btn btn-sm btn-warning">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('user-properties.destroy', $userProperty->id) }}" method="POST" style="display: inline;">
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