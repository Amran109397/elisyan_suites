@extends('backend.layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Appointments</h3>
                    <div class="card-tools">
                        <a href="{{ route('appointments.create') }}" class="btn btn-primary">
                            <i class="fas fa-plus"></i> New Appointment
                        </a>
                        <button class="btn btn-info" onclick="showCalendarView()">
                            <i class="fas fa-calendar"></i> Calendar View
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-md-3">
                            <input type="text" class="form-control" id="searchAppointments" placeholder="Search appointments...">
                        </div>
                        <div class="col-md-3">
                            <select class="form-select" id="filterStatus">
                                <option value="">All Status</option>
                                <option value="scheduled">Scheduled</option>
                                <option value="confirmed">Confirmed</option>
                                <option value="in_progress">In Progress</option>
                                <option value="completed">Completed</option>
                                <option value="cancelled">Cancelled</option>
                                <option value="no_show">No Show</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <select class="form-select" id="filterTherapist">
                                <option value="">All Therapists</option>
                                @foreach($therapists as $therapist)
                                    <option value="{{ $therapist->id }}">{{ $therapist->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-3">
                            <input type="date" class="form-control" id="filterDate">
                        </div>
                    </div>
                    
                    <table class="table table-bordered table-striped table-hover" id="appointmentsTable">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Guest</th>
                                <th>Treatment</th>
                                <th>Therapist</th>
                                <th>Date & Time</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($appointments as $appointment)
                            <tr>
                                <td>{{ $appointment->id }}</td>
                                <td>{{ $appointment->guest->full_name }}</td>
                                <td>{{ $appointment->treatment->name }}</td>
                                <td>{{ $appointment->therapist->name }}</td>
                                <td>{{ $appointment->date->format('d M Y') }} at {{ $appointment->time->format('H:i') }}</td>
                                <td>
                                    <span class="badge bg-{{ $appointment->status == 'completed' ? 'success' : ($appointment->status == 'cancelled' ? 'danger' : ($appointment->status == 'confirmed' ? 'info' : 'warning')) }}">
                                        {{ ucfirst(str_replace('_', ' ', $appointment->status)) }}
                                    </span>
                                </td>
                                <td>
                                    <a href="{{ route('appointments.show', $appointment->id) }}" class="btn btn-sm btn-info">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('appointments.edit', $appointment->id) }}" class="btn btn-sm btn-warning">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    @if($appointment->status != 'completed' && $appointment->status != 'cancelled')
                                        <form action="{{ route('appointments.destroy', $appointment->id) }}" method="POST" style="display: inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    
                    <div class="d-flex justify-content-between align-items-center mt-3">
                        <div>
                            Showing {{ $appointments->firstItem() }} to {{ $appointments->lastItem() }} of {{ $appointments->total() }} entries
                        </div>
                        {{ $appointments->links() }}
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
                <h5 class="modal-title">Appointments Calendar</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div id="appointmentCalendar" style="height: 500px;"></div>
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
        let calendarEl = document.getElementById('appointmentCalendar');
        let calendar = new FullCalendar.Calendar(calendarEl, {
            initialView: 'dayGridMonth',
            headerToolbar: {
                left: 'prev,next today',
                center: 'title',
                right: 'dayGridMonth,timeGridWeek,timeGridDay'
            },
            events: '/appointments/calendar-data',
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
    $('#searchAppointments').on('keyup', function() {
        let value = $(this).val().toLowerCase();
        $('#appointmentsTable tbody tr').filter(function() {
            $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1);
        });
    });
    
    $('#filterStatus, #filterTherapist, #filterDate').on('change', function() {
        window.location.href = '/appointments?' + 
            $.param({
                search: $('#searchAppointments').val(),
                status: $('#filterStatus').val(),
                therapist: $('#filterTherapist').val(),
                date: $('#filterDate').val()
            });
    });
});
</script>
@endpush