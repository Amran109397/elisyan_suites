@extends('backend.layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Treatments</h3>
                    <div class="card-tools">
                        <a href="{{ route('treatments.create') }}" class="btn btn-primary">
                            <i class="fas fa-plus"></i> New Treatment
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-md-4">
                            <input type="text" class="form-control" id="searchTreatments" placeholder="Search treatments...">
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
                    
                    <table class="table table-bordered table-striped table-hover" id="treatmentsTable">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Property</th>
                                <th>Duration</th>
                                <th>Price</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($treatments as $treatment)
                            <tr>
                                <td>{{ $treatment->id }}</td>
                                <td>{{ $treatment->name }}</td>
                                <td>{{ $treatment->property->name }}</td>
                                <td>{{ $treatment->duration }} min</td>
                                <td>{{ number_format($treatment->price, 2) }}</td>
                                <td>
                                    <span class="badge bg-{{ $treatment->is_active ? 'success' : 'danger' }}">
                                        {{ $treatment->is_active ? 'Active' : 'Inactive' }}
                                    </span>
                                </td>
                                <td>
                                    <a href="{{ route('treatments.show', $treatment->id) }}" class="btn btn-sm btn-info">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('treatments.edit', $treatment->id) }}" class="btn btn-sm btn-warning">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('treatments.destroy', $treatment->id) }}" method="POST" style="display: inline;">
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
                            Showing {{ $treatments->firstItem() }} to {{ $treatments->lastItem() }} of {{ $treatments->total() }} entries
                        </div>
                        {{ $treatments->links() }}
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
    $('#searchTreatments').on('keyup', function() {
        let value = $(this).val().toLowerCase();
        $('#treatmentsTable tbody tr').filter(function() {
            $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1);
        });
    });
    
    $('#filterProperty, #filterStatus').on('change', function() {
        window.location.href = '/treatments?' + 
            $.param({
                search: $('#searchTreatments').val(),
                property: $('#filterProperty').val(),
                status: $('#filterStatus').val()
            });
    });
});
</script>
@endpush