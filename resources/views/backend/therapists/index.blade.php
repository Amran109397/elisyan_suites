@extends('backend.layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Therapists</h3>
                    <div class="card-tools">
                        <a href="{{ route('therapists.create') }}" class="btn btn-primary">
                            <i class="fas fa-plus"></i> New Therapist
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-md-4">
                            <input type="text" class="form-control" id="searchTherapists" placeholder="Search therapists...">
                        </div>
                        <div class="col-md-4">
                            <select class="form-select" id="filterProperty">
                                <option value="">All Properties</option>
                                @foreach($properties as $property)
                                    <option value="{{ $property->id }}">{{ $property->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-4">
                            <select class="form-select" id="filterStatus">
                                <option value="">All Status</option>
                                <option value="1">Active</option>
                                <option value="0">Inactive</option>
                            </select>
                        </div>
                    </div>
                    
                    <table class="table table-bordered table-striped table-hover" id="therapistsTable">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Property</th>
                                <th>Email</th>
                                <th>Phone</th>
                                <th>Specialization</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($therapists as $therapist)
                            <tr>
                                <td>{{ $therapist->id }}</td>
                                <td>{{ $therapist->name }}</td>
                                <td>{{ $therapist->property->name }}</td>
                                <td>{{ $therapist->email }}</td>
                                <td>{{ $therapist->phone }}</td>
                                <td>{{ $therapist->specialization ?: 'N/A' }}</td>
                                <td>
                                    <span class="badge bg-{{ $therapist->is_active ? 'success' : 'danger' }}">
                                        {{ $therapist->is_active ? 'Active' : 'Inactive' }}
                                    </span>
                                </td>
                                <td>
                                    <a href="{{ route('therapists.show', $therapist->id) }}" class="btn btn-sm btn-info">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('therapists.edit', $therapist->id) }}" class="btn btn-sm btn-warning">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('therapists.destroy', $therapist->id) }}" method="POST" style="display: inline;">
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
                    
                    <div class="d-flex justify-content-between align-items-center mt-3">
                        <div>
                            Showing {{ $therapists->firstItem() }} to {{ $therapists->lastItem() }} of {{ $therapists->total() }} entries
                        </div>
                        {{ $therapists->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
 $(document).ready(function() {
    $('#searchTherapists').on('keyup', function() {
        let value = $(this).val().toLowerCase();
        $('#therapistsTable tbody tr').filter(function() {
            $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1);
        });
    });
    
    $('#filterProperty, #filterStatus').on('change', function() {
        window.location.href = '/therapists?' + 
            $.param({
                search: $('#searchTherapists').val(),
                property: $('#filterProperty').val(),
                status: $('#filterStatus').val()
            });
    });
});
</script>
@endpush