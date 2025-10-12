@extends('backend.layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Housekeeping Staff</h3>
                    <div class="card-tools">
                        <a href="{{ route('housekeeping-staffs.create') }}" class="btn btn-primary">
                            <i class="fas fa-plus"></i> New Staff
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-md-4">
                            <input type="text" class="form-control" id="searchStaff" placeholder="Search staff...">
                        </div>
                        <div class="col-md-4">
                            <select class="form-select" id="filterProperty">
                                <option value="">All Properties</option>
                                @if(isset($properties) && $properties->count() > 0)
                                    @foreach($properties as $property)
                                        <option value="{{ $property->id }}">{{ $property->name }}</option>
                                    @endforeach
                                @else
                                    <option value="">No Properties Available</option>
                                @endif
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
                    
                    <table class="table table-bordered table-striped table-hover" id="staffTable">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Phone</th>
                                <th>Email</th>
                                <th>Position</th>
                                <th>Shift</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($housekeepingStaffs as $staff)
                            <tr>
                                <td>{{ $staff->id }}</td>
                                <td>{{ $staff->name }}</td>
                                <td>{{ $staff->phone }}</td>
                                <td>{{ $staff->email ?? 'N/A' }}</td>
                                <td>{{ $staff->position }}</td>
                                <td>{{ $staff->shift }}</td>
                                <td>
                                    <span class="badge bg-{{ $staff->is_active ? 'success' : 'danger' }}">
                                        {{ $staff->is_active ? 'Active' : 'Inactive' }}
                                    </span>
                                </td>
                                <td>
                                    <a href="{{ route('housekeeping-staffs.show', $staff->id) }}" class="btn btn-sm btn-info">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('housekeeping-staffs.edit', $staff->id) }}" class="btn btn-sm btn-warning">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('housekeeping-staffs.destroy', $staff->id) }}" method="POST" style="display: inline;">
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

@push('scripts')
<script>
 $(document).ready(function() {
    $('#searchStaff').on('keyup', function() {
        let value = $(this).val().toLowerCase();
        $('#staffTable tbody tr').filter(function() {
            $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1);
        });
    });
    
    $('#filterProperty, #filterStatus').on('change', function() {
        window.location.href = '/housekeeping-staffs?' + 
            $.param({
                search: $('#searchStaff').val(),
                property: $('#filterProperty').val(),
                status: $('#filterStatus').val()
            });
    });
});
</script>
@endpush