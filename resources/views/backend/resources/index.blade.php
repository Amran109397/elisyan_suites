@extends('backend.layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Resources</h3>
                    <div class="card-tools">
                        <a href="{{ route('resources.create') }}" class="btn btn-primary">
                            <i class="fas fa-plus"></i> New Resource
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-md-4">
                            <input type="text" class="form-control" id="searchResources" placeholder="Search resources...">
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
                            <select class="form-select" id="filterType">
                                <option value="">All Types</option>
                                <option value="room">Room</option>
                                <option value="equipment">Equipment</option>
                                <option value="facility">Facility</option>
                                <option value="other">Other</option>
                            </select>
                        </div>
                    </div>
                    
                    <table class="table table-bordered table-striped table-hover" id="resourcesTable">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Property</th>
                                <th>Type</th>
                                <th>Capacity</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($resources as $resource)
                            <tr>
                                <td>{{ $resource->id }}</td>
                                <td>{{ $resource->name }}</td>
                                <td>{{ $resource->property->name }}</td>
                                <td>{{ ucfirst($resource->type) }}</td>
                                <td>{{ $resource->capacity ?: 'N/A' }}</td>
                                <td>
                                    <span class="badge bg-{{ $resource->is_active ? 'success' : 'danger' }}">
                                        {{ $resource->is_active ? 'Active' : 'Inactive' }}
                                    </span>
                                </td>
                                <td>
                                    <a href="{{ route('resources.show', $resource->id) }}" class="btn btn-sm btn-info">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('resources.edit', $resource->id) }}" class="btn btn-sm btn-warning">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('resources.destroy', $resource->id) }}" method="POST" style="display: inline;">
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
                            Showing {{ $resources->firstItem() }} to {{ $resources->lastItem() }} of {{ $resources->total() }} entries
                        </div>
                        {{ $resources->links() }}
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
    $('#searchResources').on('keyup', function() {
        let value = $(this).val().toLowerCase();
        $('#resourcesTable tbody tr').filter(function() {
            $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1);
        });
    });
    
    $('#filterProperty, #filterType').on('change', function() {
        window.location.href = '/resources?' + 
            $.param({
                search: $('#searchResources').val(),
                property: $('#filterProperty').val(),
                type: $('#filterType').val()
            });
    });
});
</script>
@endpush