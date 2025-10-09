@extends('backend.layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Events</h3>
                    <div class="card-tools">
                        <a href="{{ route('events.create') }}" class="btn btn-primary">
                            <i class="fas fa-plus"></i> New Event
                        </a>
                        <button class="btn btn-info" onclick="showCalendarView()">
                            <i class="fas fa-calendar"></i> Calendar View
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-md-4">
                            <input type="text" class="form-control" id="searchEvents" placeholder="Search events...">
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
                                <option value="draft">Draft</option>
                                <option value="published">Published</option>
                                <option value="ongoing">Ongoing</option>
                                <option value="completed">Completed</option>
                                <option value="cancelled">Cancelled</option>
                            </select>
                        </div>
                    </div>
                    
                    <table class="table table-bordered table-striped table-hover" id="eventsTable">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Property</th>
                                <th>Start Date</th>
                                <th>End Date</th>
                                <th>Capacity</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($events as $event)
                            <tr>
                                <td>{{ $event->id }}</td>
                                <td>{{ $event->name }}</td>
                                <td>{{ $event->property->name }}</td>
                                <td>{{ $event->start_date->format('d M Y, H:i') }}</td>
                                <td>{{ $event->end_date->format('d M Y, H:i') }}</td>
                                <td>{{ $event->capacity ?: 'N/A' }}</td>
                                <td>
                                    <span class="badge bg-{{ $event->status == 'completed' ? 'success' : ($event->status == 'cancelled' ? 'danger' : ($event->status == 'ongoing' ? 'info' : ($event->status == 'published' ? 'primary' : 'secondary'))) }}">
                                        {{ ucfirst($event->status) }}
                                    </span>
                                </td>
                                <td>
                                    <a href="{{ route('events.show', $event->id) }}" class="btn btn-sm btn-info">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('events.edit', $event->id) }}" class="btn btn-sm btn-warning">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('events.destroy', $event->id) }}" method="POST" style="display: inline;">
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
                            Showing {{ $events->firstItem() }} to {{ $events->lastItem() }} of {{ $events->total() }} entries
                        </div>
                        {{ $events->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Calendar View Modal -->
<div class="modal fade" id="calendarViewModal" tabindex="-1">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Events Calendar</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div id="eventCalendar" style="height: 500px;"></div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.10.1/main.min.js"></script>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/fullcalendar@5.10.1/main.min.css">

<script>
function showCalendarView() {
    $('#calendarViewModal').modal('show');
    
    setTimeout(() => {
        let calendarEl = document.getElementById('eventCalendar');
        let calendar = new FullCalendar.Calendar(calendarEl, {
            initialView: 'dayGridMonth',
            headerToolbar: {
                left: 'prev,next today',
                center: 'title',
                right: 'dayGridMonth,timeGridWeek,timeGridDay'
            },
            events: '/events/calendar-data',
            eventClick: function(info) {
                if (info.event.url) {
                    window.location.href = info.event.url;
                }
            }
        });
        calendar.render();
    }, 300);
}

 $(document).ready(function() {
    $('#searchEvents').on('keyup', function() {
        let value = $(this).val().toLowerCase();
        $('#eventsTable tbody tr').filter(function() {
            $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1);
        });
    });
    
    $('#filterProperty, #filterStatus').on('change', function() {
        window.location.href = '/events?' + 
            $.param({
                search: $('#searchEvents').val(),
                property: $('#filterProperty').val(),
                status: $('#filterStatus').val()
            });
    });
});
</script>
@endpush