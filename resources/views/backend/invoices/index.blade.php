// resources/views/backend/invoices/index.blade.php
@extends('backend.layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Invoices</h3>
                    <div class="card-tools">
                        <a href="{{ route('invoices.create') }}" class="btn btn-primary">
                            <i class="fas fa-plus"></i> New Invoice
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <!-- Search and Filter Section -->
                    <div class="row mb-3">
                        <div class="col-md-3">
                            <input type="text" class="form-control" id="searchInvoices" placeholder="Search invoices...">
                        </div>
                        <div class="col-md-3">
                            <select class="form-select" id="filterStatus">
                                <option value="">All Status</option>
                                <option value="draft">Draft</option>
                                <option value="sent">Sent</option>
                                <option value="paid">Paid</option>
                                <option value="overdue">Overdue</option>
                                <option value="cancelled">Cancelled</option>
                                <option value="voided">Voided</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <select class="form-select" id="filterProperty">
                                <option value="">All Properties</option>
                                @foreach($properties = App\Models\Property::all() as $property)
                                    <option value="{{ $property->id }}">{{ $property->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-3">
                            <input type="date" class="form-control" id="filterDate">
                        </div>
                    </div>

                    <table class="table table-bordered table-striped table-hover" id="invoicesTable">
                        <thead>
                            <tr>
                                <th>Invoice #</th>
                                <th>Booking</th>
                                <th>Guest</th>
                                <th>Property</th>
                                <th>Issue Date</th>
                                <th>Due Date</th>
                                <th>Amount</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($invoices as $invoice)
                            <tr>
                                <td>{{ $invoice->invoice_number }}</td>
                                <td>{{ $invoice->booking->booking_reference ?? 'N/A' }}</td>
                                <td>{{ $invoice->booking->guest->full_name ?? 'N/A' }}</td>
                                <td>{{ $invoice->booking->property->name ?? 'N/A' }}</td>
                                <td>{{ $invoice->issue_date }}</td>
                                <td>{{ $invoice->due_date }}</td>
                                <td>${{ number_format($invoice->amount, 2) }}</td>
                                <td>
                                    <span class="badge bg-{{ $invoice->status == 'paid' ? 'success' : ($invoice->status == 'sent' ? 'info' : ($invoice->status == 'overdue' ? 'danger' : ($invoice->status == 'draft' ? 'warning' : 'secondary'))) }}">
                                        {{ ucfirst($invoice->status) }}
                                    </span>
                                </td>
                                <td>
                                    <div class="btn-group">
                                        <a href="{{ route('invoices.show', $invoice->id) }}" class="btn btn-sm btn-info" title="View">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="{{ route('invoices.edit', $invoice->id) }}" class="btn btn-sm btn-warning" title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        
                                        <!-- Quick Actions -->
                                        @if($invoice->status == 'draft')
                                            <form action="{{ route('invoices.send', $invoice->id) }}" method="POST" style="display: inline;">
                                                @csrf
                                                <button type="submit" class="btn btn-sm btn-primary" title="Send Invoice" onclick="return confirm('Send this invoice?')">
                                                    <i class="fas fa-paper-plane"></i>
                                                </button>
                                            </form>
                                        @endif
                                        
                                        @if($invoice->status == 'sent' && !$invoice->is_fully_paid)
                                            <form action="{{ route('invoices.mark-as-paid', $invoice->id) }}" method="POST" style="display: inline;">
                                                @csrf
                                                <button type="submit" class="btn btn-sm btn-success" title="Mark as Paid" onclick="return confirm('Mark this invoice as paid?')">
                                                    <i class="fas fa-check"></i>
                                                </button>
                                            </form>
                                        @endif
                                        
                                        @if($invoice->status == 'sent' && $invoice->is_overdue)
                                            <form action="{{ route('invoices.mark-as-overdue', $invoice->id) }}" method="POST" style="display: inline;">
                                                @csrf
                                                <button type="submit" class="btn btn-sm btn-danger" title="Mark as Overdue" onclick="return confirm('Mark this invoice as overdue?')">
                                                    <i class="fas fa-exclamation-triangle"></i>
                                                </button>
                                            </form>
                                        @endif
                                        
                                        @if(!in_array($invoice->status, ['cancelled', 'voided']))
                                            <form action="{{ route('invoices.cancel', $invoice->id) }}" method="POST" style="display: inline;">
                                                @csrf
                                                <button type="submit" class="btn btn-sm btn-danger" title="Cancel Invoice" onclick="return confirm('Cancel this invoice?')">
                                                    <i class="fas fa-times"></i>
                                                </button>
                                            </form>
                                        @endif
                                        
                                        <form action="{{ route('invoices.destroy', $invoice->id) }}" method="POST" style="display: inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger" title="Delete" onclick="return confirm('Are you sure?')">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    
                    <!-- Pagination -->
                    <div class="d-flex justify-content-between align-items-center mt-3">
                        <div>
                            Showing {{ $invoices->firstItem() }} to {{ $invoices->lastItem() }} of {{ $invoices->total() }} entries
                        </div>
                        {{ $invoices->links() }}
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
    // Search functionality
    $('#searchInvoices').on('keyup', function() {
        let value = $(this).val().toLowerCase();
        $('#invoicesTable tbody tr').filter(function() {
            $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1);
        });
    });
    
    // Filter functionality
    $('#filterStatus, #filterProperty, #filterDate').on('change', function() {
        let statusValue = $('#filterStatus').val().toLowerCase();
        let propertyValue = $('#filterProperty').val();
        let dateValue = $('#filterDate').val();
        
        $('#invoicesTable tbody tr').filter(function() {
            let statusMatch = statusValue === '' || $(this).find('td:eq(7)').text().toLowerCase().indexOf(statusValue) > -1;
            let propertyMatch = propertyValue === '' || $(this).find('td:eq(3)').text().includes($('#filterProperty option:selected').text());
            let dateMatch = dateValue === '' || $(this).find('td:eq(4)').text().includes(dateValue) || $(this).find('td:eq(5)').text().includes(dateValue);
            
            $(this).toggle(statusMatch && propertyMatch && dateMatch);
        });
    });
});
</script>
@endpush