@extends('backend.layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Audit Logs</h3>
                    <div class="card-tools">
                        <button class="btn btn-default" onclick="exportLogs()">
                            <i class="fas fa-download"></i> Export
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-md-3">
                            <input type="text" class="form-control" id="searchTable" placeholder="Search logs...">
                        </div>
                        <div class="col-md-3">
                            <select class="form-select" id="filterAction">
                                <option value="">All Actions</option>
                                <option value="insert">Insert</option>
                                <option value="update">Update</option>
                                <option value="delete">Delete</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <input type="date" class="form-control" id="filterDate">
                        </div>
                        <div class="col-md-3">
                            <select class="form-select" id="filterUser">
                                <option value="">All Users</option>
                                @foreach($users as $user)
                                    <option value="{{ $user->id }}">{{ $user->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    
                    <table class="table table-bordered table-striped table-hover" id="auditLogsTable">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>User</th>
                                <th>Action</th>
                                <th>Table</th>
                                <th>Record ID</th>
                                <th>IP Address</th>
                                <th>Timestamp</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($auditLogs as $log)
                            <tr>
                                <td>{{ $log->id }}</td>
                                <td>{{ $log->user ? $log->user->name : 'System' }}</td>
                                <td>
                                    <span class="badge bg-{{ $log->action == 'insert' ? 'success' : ($log->action == 'update' ? 'warning' : 'danger') }}">
                                        {{ ucfirst($log->action) }}
                                    </span>
                                </td>
                                <td>{{ $log->table_name }}</td>
                                <td>{{ $log->record_id }}</td>
                                <td>{{ $log->ip_address }}</td>
                                <td>{{ $log->created_at->format('d M Y, H:i:s') }}</td>
                                <td>
                                    <button class="btn btn-sm btn-info" onclick="viewLogDetails({{ $log->id }})">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    
                    <div class="d-flex justify-content-between align-items-center mt-3">
                        <div>
                            Showing {{ $auditLogs->firstItem() }} to {{ $auditLogs->lastItem() }} of {{ $auditLogs->total() }} entries
                        </div>
                        {{ $auditLogs->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Log Details Modal -->
<div class="modal fade" id="logDetailsModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Audit Log Details</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body" id="logDetailsContent">
                <!-- Content will be loaded via AJAX -->
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
function viewLogDetails(logId) {
    $.get(`/audit-logs/${logId}`, function(data) {
        let content = `
            <div class="row">
                <div class="col-md-6">
                    <p><strong>User:</strong> ${data.user ? data.user.name : 'System'}</p>
                    <p><strong>Action:</strong> ${data.action}</p>
                    <p><strong>Table:</strong> ${data.table_name}</p>
                    <p><strong>Record ID:</strong> ${data.record_id}</p>
                    <p><strong>IP Address:</strong> ${data.ip_address}</p>
                    <p><strong>User Agent:</strong> ${data.user_agent || 'N/A'}</p>
                </div>
                <div class="col-md-6">
                    <p><strong>Timestamp:</strong> ${data.created_at}</p>
                </div>
            </div>
        `;
        
        if (data.old_values || data.new_values) {
            content += `
                <div class="mt-4">
                    <h6>Changes:</h6>
                    <div class="row">
                        <div class="col-md-6">
                            <h6>Old Values:</h6>
                            <pre class="bg-light p-3">${JSON.stringify(JSON.parse(data.old_values || '{}'), null, 2)}</pre>
                        </div>
                        <div class="col-md-6">
                            <h6>New Values:</h6>
                            <pre class="bg-light p-3">${JSON.stringify(JSON.parse(data.new_values || '{}'), null, 2)}</pre>
                        </div>
                    </div>
                </div>
            `;
        }
        
        $('#logDetailsContent').html(content);
        $('#logDetailsModal').modal('show');
    });
}

function exportLogs() {
    window.location.href = '/audit-logs/export?' + 
        $.param({
            action: $('#filterAction').val(),
            date: $('#filterDate').val(),
            user: $('#filterUser').val()
        });
}

 $(document).ready(function() {
    $('#searchTable').on('keyup', function() {
        let value = $(this).val().toLowerCase();
        $('#auditLogsTable tbody tr').filter(function() {
            $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1);
        });
    });
    
    $('#filterAction, #filterDate, #filterUser').on('change', function() {
        window.location.href = '/audit-logs?' + 
            $.param({
                search: $('#searchTable').val(),
                action: $('#filterAction').val(),
                date: $('#filterDate').val(),
                user: $('#filterUser').val()
            });
    });
});
</script>
@endpush