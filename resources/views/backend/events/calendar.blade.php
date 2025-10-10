@extends('backend.layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Events Calendar</h3>
                    <div class="card-tools">
                        <div class="input-group input-group-sm" style="width: 200px;">
                            <input type="text" id="calendarSearch" class="form-control" placeholder="Search events...">
                            <div class="input-group-append">
                                <button class="btn btn-default">
                                    <i class="fas fa-search"></i>
                                </button>
                            </div>
                        </div>
                        <a href="{{ route('events.index') }}" class="btn btn-default ml-2">
                            <i class="fas fa-list"></i> List View
                        </a>
                        <a href="{{ route('events.create') }}" class="btn btn-primary ml-2">
                            <i class="fas fa-plus"></i> New Event
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <!-- Event Overview Section -->
                    <div class="row mb-4">
                        <div class="col-md-12">
                            <div class="event-overview">
                                <h5 class="mb-3">Event Overview</h5>
                                <div class="row">
                                    <div class="col-md-2 col-sm-4">
                                        <div class="info-box bg-gradient-info">
                                            <span class="info-box-icon"><i class="fas fa-calendar"></i></span>
                                            <div class="info-box-content">
                                                <span class="info-box-text">Total Events</span>
                                                <span class="info-box-number">{{ $totalEvents }}</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-2 col-sm-4">
                                        <div class="info-box bg-gradient-success">
                                            <span class="info-box-icon"><i class="fas fa-play-circle"></i></span>
                                            <div class="info-box-content">
                                                <span class="info-box-text">Published</span>
                                                <span class="info-box-number">{{ $publishedEvents }}</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-2 col-sm-4">
                                        <div class="info-box bg-gradient-primary">
                                            <span class="info-box-icon"><i class="fas fa-spinner"></i></span>
                                            <div class="info-box-content">
                                                <span class="info-box-text">Ongoing</span>
                                                <span class="info-box-number">{{ $ongoingEvents }}</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-2 col-sm-4">
                                        <div class="info-box bg-gradient-secondary">
                                            <span class="info-box-icon"><i class="fas fa-check-circle"></i></span>
                                            <div class="info-box-content">
                                                <span class="info-box-text">Completed</span>
                                                <span class="info-box-number">{{ $completedEvents }}</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-2 col-sm-4">
                                        <div class="info-box bg-gradient-danger">
                                            <span class="info-box-icon"><i class="fas fa-times-circle"></i></span>
                                            <div class="info-box-content">
                                                <span class="info-box-text">Cancelled</span>
                                                <span class="info-box-number">{{ $cancelledEvents }}</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-2 col-sm-4">
                                        <div class="info-box bg-gradient-warning">
                                            <span class="info-box-icon"><i class="fas fa-file-alt"></i></span>
                                            <div class="info-box-content">
                                                <span class="info-box-text">Draft</span>
                                                <span class="info-box-number">{{ $draftEvents }}</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Calendar Section -->
                    <div class="row">
                        <div class="col-md-12">
                            <div id="eventCalendar"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
.event-overview {
    background: #f8f9fa;
    padding: 20px;
    border-radius: 8px;
    border: 1px solid #dee2e6;
}

.info-box {
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    border-radius: 6px;
    margin-bottom: 15px;
}

.info-box .info-box-icon {
    border-radius: 6px 0 0 6px;
}

.info-box .info-box-content {
    padding: 10px;
}

.info-box-text {
    font-size: 12px;
    font-weight: 600;
    text-transform: uppercase;
}

.info-box-number {
    font-size: 18px;
    font-weight: 700;
}

/* FullCalendar Custom Styles */
.fc-event {
    cursor: pointer;
    border: none;
    border-radius: 4px;
    font-size: 11px;
    padding: 2px 4px;
    margin: 1px;
}

.fc-event-title {
    font-weight: 600;
}

.fc-daygrid-event-dot {
    display: none;
}

.fc-toolbar {
    flex-wrap: wrap;
    padding: 15px;
    background: #f8f9fa;
    border-radius: 8px;
    margin-bottom: 20px !important;
}

.fc-toolbar-title {
    font-size: 1.5em;
    font-weight: 700;
    color: #495057;
}

.fc-button {
    border-radius: 4px !important;
    font-weight: 600 !important;
}

.fc-button-primary {
    background-color: #007bff !important;
    border-color: #007bff !important;
}

.fc-button-active {
    background-color: #0056b3 !important;
    border-color: #0056b3 !important;
}

.fc-day-today {
    background-color: #e7f3ff !important;
}

/* Event status colors */
.event-draft { background-color: #ffc107; color: #000; }
.event-published { background-color: #28a745; color: #fff; }
.event-ongoing { background-color: #007bff; color: #fff; }
.event-completed { background-color: #6c757d; color: #fff; }
.event-cancelled { background-color: #dc3545; color: #fff; }

@media (max-width: 768px) {
    .fc-toolbar {
        flex-direction: column;
        gap: 10px;
    }
    
    .fc-toolbar-chunk {
        text-align: center;
    }
    
    .event-overview .row {
        margin: 0 -5px;
    }
    
    .event-overview .col-md-2 {
        padding: 0 5px;
    }
}
</style>
@endpush

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.js"></script>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.css">

<script>
document.addEventListener('DOMContentLoaded', function() {
    var calendarEl = document.getElementById('eventCalendar');
    
    var calendar = new FullCalendar.Calendar(calendarEl, {
        initialView: 'dayGridMonth',
        headerToolbar: {
            left: 'prev,next today',
            center: 'title',
            right: 'dayGridMonth,timeGridWeek,timeGridDay,listMonth'
        },
        themeSystem: 'bootstrap5',
        navLinks: true,
        editable: false,
        selectable: false,
        nowIndicator: true,
        dayMaxEvents: true,
        events: '{{ route("events.calendar-data") }}',
        eventClick: function(info) {
            if (info.event.url) {
                window.location.href = info.event.url;
            }
        },
        eventDidMount: function(info) {
            // Add custom class based on event status
            const status = info.event.extendedProps.status;
            info.el.classList.add('event-' + status);
            
            // Add tooltip
            $(info.el).tooltip({
                title: `
                    <strong>${info.event.title}</strong><br>
                    <small>Property: ${info.event.extendedProps.property}</small><br>
                    <small>Status: ${info.event.extendedProps.status}</small><br>
                    <small>Capacity: ${info.event.extendedProps.capacity}</small>
                `,
                html: true,
                placement: 'top',
                container: 'body'
            });
        },
        loading: function(isLoading) {
            if (isLoading) {
                $('#eventCalendar').addClass('loading');
            } else {
                $('#eventCalendar').removeClass('loading');
            }
        }
    });

    calendar.render();

    // Search functionality
    $('#calendarSearch').on('keyup', function() {
        const searchTerm = $(this).val().toLowerCase();
        calendar.refetchEvents();
    });
});

// Responsive handling
$(window).on('resize', function() {
    $('#eventCalendar').fullCalendar('render');
});
</script>
@endpush