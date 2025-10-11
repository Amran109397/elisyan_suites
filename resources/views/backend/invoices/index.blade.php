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
                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>Invoice #</th>
                                <th>Booking</th>
                                <th>Guest</th>
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
                                <td>{{ $invoice->booking->booking_reference }}</td>
                                <td>{{ $invoice->booking->guest->full_name }}</td>
                                <td>{{ $invoice->issue_date }}</td>
                                <td>{{ $invoice->due_date }}</td>
                                <td>{{ number_format($invoice->amount, 2) }}</td>
                                <td>
                                    <span class="badge bg-{{ $invoice->status == 'paid' ? 'success' : ($invoice->status == 'sent' ? 'info' : ($invoice->status == 'overdue' ? 'danger' : 'secondary')) }}">
                                        {{ ucfirst($invoice->status) }}
                                    </span>
                                </td>
                                <td>
                                    <a href="{{ route('invoices.show', $invoice->id) }}" class="btn btn-sm btn-info">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('invoices.edit', $invoice->id) }}" class="btn btn-sm btn-warning">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <a href="{{ route('invoices.index') }}">All Invoices</a>
                                    <form action="{{ route('invoices.destroy', $invoice->id) }}" method="POST" style="display: inline;">
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