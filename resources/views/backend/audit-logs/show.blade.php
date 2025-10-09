@extends('backend.layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Audit Log Details</h3>
                    <div class="card-tools">
                        <a href="{{ route('audit-logs.index') }}" class="btn btn-default">
                            <i class="fas fa-arrow-left"></i> Back
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="info-box bg-light">
                                <div class="info-box-content">
                                    <span class="info-box-text">Log ID</span>
                                    <span class="info-box-number">{{ $auditLog->id }}</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="info-box bg-light">
                                <div class="info-box-content">
                                    <span class="info-box-text">Action</span>
                                    <span class="info-box-number">
                                        <span class="badge bg-{{ $auditLog->action == 'insert' ? 'success' : ($auditLog->action == 'update' ? 'warning' : 'danger') }}">
                                            {{ ucfirst($auditLog->action) }}
                                        </span>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="row mt-4">
                        <div class="col-md-6">
                            <h5>General Information</h5>
                            <table class="table table-bordered">
                                <tr>
                                    <th width="30%">User</th>
                                    <td>{{ $auditLog->user ? $auditLog->user->name : 'System' }}</td>
                                </tr>
                                <tr>
                                    <th>Table</th>
                                    <td>{{ $auditLog->table_name }}</td>
                                </tr>
                                <tr>
                                    <th>Record ID</th>
                                    <td>{{ $auditLog->record_id }}</td>
                                </tr>
                                <tr>
                                    <th>IP Address</th>
                                    <td>{{ $auditLog->ip_address }}</td>
                                </tr>
                                <tr>
                                    <th>User Agent</th>
                                    <td>{{ $auditLog->user_agent ?: 'N/A' }}</td>
                                </tr>
                                <tr>
                                    <th>Timestamp</th>
                                    <td>{{ $auditLog->created_at->format('d M Y, H:i:s') }}</td>
                                </tr>
                            </table>
                        </div>
                        
                        <div class="col-md-6">
                            <h5>Changes</h5>
                            @if($auditLog->old_values || $auditLog->new_values)
                                <div class="row">
                                    @if($auditLog->old_values)
                                    <div class="col-md-6">
                                        <h6>Old Values</h6>
                                        <pre class="bg-light p-3">{{ json_encode(json_decode($auditLog->old_values), JSON_PRETTY_PRINT) }}</pre>
                                    </div>
                                    @endif
                                    
                                    @if($auditLog->new_values)
                                    <div class="col-md-6">
                                        <h6>New Values</h6>
                                        <pre class="bg-light p-3">{{ json_encode(json_decode($auditLog->new_values), JSON_PRETTY_PRINT) }}</pre>
                                    </div>
                                    @endif
                                </div>
                            @else
                                <div class="alert alert-info">
                                    No changes recorded for this action.
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection