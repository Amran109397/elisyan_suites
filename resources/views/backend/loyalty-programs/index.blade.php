@extends('backend.layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Loyalty Programs</h3>
                    <div class="card-tools">
                        <a href="{{ route('loyalty-programs.create') }}" class="btn btn-primary">
                            <i class="fas fa-plus"></i> New Program
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Points per Currency</th>
                                <th>Redemption Rate</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($loyaltyPrograms as $loyaltyProgram)
                            <tr>
                                <td>{{ $loyaltyProgram->name }}</td>
                                <td>{{ $loyaltyProgram->points_per_currency }}</td>
                                <td>{{ $loyaltyProgram->redemption_rate }}</td>
                                <td>
                                    <span class="badge bg-{{ $loyaltyProgram->is_active ? 'success' : 'danger' }}">
                                        {{ $loyaltyProgram->is_active ? 'Active' : 'Inactive' }}
                                    </span>
                                </td>
                                <td>
                                    <a href="{{ route('loyalty-programs.show', $loyaltyProgram->id) }}" class="btn btn-sm btn-info">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('loyalty-programs.edit', $loyaltyProgram->id) }}" class="btn btn-sm btn-warning">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('loyalty-programs.destroy', $loyaltyProgram->id) }}" method="POST" style="display: inline;">
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