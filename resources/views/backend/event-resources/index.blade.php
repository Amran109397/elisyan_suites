@extends('backend.layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Event Resources</h3>
                    <div class="card-tools">
                        <a href="{{ route('event-resources.create') }}" class="btn btn-primary">
                            <i class="fas fa-plus"></i> New Event Resource
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-md-4">
                            <input type="text" class="form-control" id="searchEventResources" placeholder="Search event resources...">
                        </div>
                        <div class="col-md-4">
                            <select class="form-select" id="filterEvent">
                                <option value="">All Events</option>
                                @foreach($events as $event)
                                    <option value="{{ $event->id }}">{{ $event->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-4">
                            <select class="form-select" id="filterResource">
                                <option value="">All Resources</option>
                                @foreach($resources as $resource)
                                    <option value="{{ $resource->id }}">{{ $resource->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    
                    <table class="table table-bordered table-striped table-hover" id="eventResourcesTable">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Event</th>
                                <th>Resource</th>
                                <th>Type</th>
                                <th>Quantity</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($eventResources as $eventResource)
                            <tr>
                                <td>{{ $eventResource->id }}</td>
                                <td>{{ $eventResource->event->name }}</td>
                                <td>{{ $eventResource->resource->name }}</td>
                                <td>{{ ucfirst($eventResource->resource->type) }}</td>
                                <td>{{ $eventResource->quantity }}</td>
                                <td>
                                    <a href="{{ route('event-resources.show', $eventResource->id) }}" class="btn btn-sm btn-info">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('event-resources.edit', $eventResource->id) }}" class="btn btn-sm btn-warning">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('event-resources.destroy', $eventResource->id) }}" method="POST" style="display: inline;">
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
                            Showing {{ $eventResources->firstItem() }} to {{ $eventResources->lastItem() }} of {{ $eventResources->total() }} entries
                        </div>
                        {{ $eventResources->links() }}
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
    $('#searchEventResources').on('keyup', function() {
        let value = $(this).val().toLowerCase();
        $('#eventResourcesTable tbody tr').filter(function() {
            $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1);
        });
    });
    
    $('#filterEvent, #filterResource').on('change', function() {
        window.location.href = '/event-resources?' + 
            $.param({
                search: $('#searchEventResources').val(),
                event: $('#filterEvent').val(),
                resource: $('#filterResource').val()
            });
    });
});
</script>
@endpush