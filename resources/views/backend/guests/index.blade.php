@extends('backend.layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Guests</h3>
                    <div class="card-tools">
                        <a href="{{ route('guests.create') }}" class="btn btn-primary">
                            <i class="fas fa-plus"></i> Add Guest
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Phone</th>
                                <th>Nationality</th>
                                <th>VIP</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($guests as $guest)
                            <tr>
                                <td>{{ $guest->id }}</td>
                                <td>{{ $guest->full_name }}</td>
                                <td>{{ $guest->email }}</td>
                                <td>{{ $guest->phone }}</td>
                                <td>{{ $guest->nationality }}</td>
                                <td>
                                    <span class="badge bg-{{ $guest->vip_status ? 'warning' : 'secondary' }}">
                                        {{ $guest->vip_status ? 'VIP' : 'Regular' }}
                                    </span>
                                </td>
                                <td>
                                    <a href="{{ route('guests.show', $guest->id) }}" class="btn btn-sm btn-info">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('guests.edit', $guest->id) }}" class="btn btn-sm btn-warning">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('guests.destroy', $guest->id) }}" method="POST" style="display: inline;">
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