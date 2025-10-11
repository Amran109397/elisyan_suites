@extends('backend.layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Invoice Details</h3>
                    <div class="card-tools">
                        <a href="{{ route('invoices.show', $invoice->id) }}">View Invoice</a>
                        <a href="{{ route('invoices.edit', $invoice->id) }}" class="btn btn-warning">
                            <i class="fas fa-edit"></i> Edit
                        </a>
                        <a href="{{ route('invoices.generate-pdf', $invoice->id) }}" class="btn btn-info">
                            <i class="fas fa-file-pdf"></i> Generate PDF
                        </a>
                        @if($invoice->status == 'draft')
                            <a href="{{ route('invoices.send', $invoice->id) }}" class="btn btn-success">
                                <i class="fas fa-paper-plane"></i> Send Invoice
                            </a>
                        @endif
                        <a href="{{ route('invoices.index') }}" class="btn btn-default">
                            <i class="fas fa-arrow-left"></i> Back
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <p><strong>Invoice Number:</strong> {{ $invoice->invoice_number }}</p>
                            <p><strong>Booking Reference:</strong> {{ $invoice->booking->booking_reference }}</p>
                            <p><strong>Guest:</strong> {{ $invoice->booking->guest->full_name }}</p>
                            <p><strong>Property:</strong> {{ $invoice->booking->property->name }}</p>
                        </div>
                        <div class="col-md-6">
                            <p><strong>Issue Date:</strong> {{ $invoice->issue_date }}</p>
                            <p><strong>Due Date:</strong> {{ $invoice->due_date }}</p>
                            <p><strong>Amount:</strong> {{ number_format($invoice->amount, 2) }}</p>
                            <p><strong>Tax Amount:</strong> {{ number_format($invoice->tax_amount, 2) }}</p>
                            <p><strong>Total:</strong> {{ number_format($invoice->amount + $invoice->tax_amount, 2) }}</p>
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-md-6">
                            <p><strong>Status:</strong> 
                                <span class="badge bg-{{ $invoice->status == 'paid' ? 'success' : ($invoice->status == 'sent' ? 'info' : ($invoice->status == 'overdue' ? 'danger' : 'secondary')) }}">
                                    {{ ucfirst($invoice->status) }}
                                </span>
                            </p>
                        </div>
                        <div class="col-md-6">
                            <p><strong>Total Paid:</strong> {{ number_format($invoice->total_paid, 2) }}</p>
                            <p><strong>Remaining:</strong> {{ number_format($invoice->remaining_amount, 2) }}</p>
                            <p><strong>Fully Paid:</strong> {{ $invoice->is_fully_paid ? 'Yes' : 'No' }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="row mt-4">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title">Payments</h5>
                </div>
                <div class="card-body">
                    @if($invoice->payments->count() > 0)
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Amount</th>
                                    <th>Method</th>
                                    <th>Type</th>
                                    <th>Status</th>
                                    <th>Date</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($invoice->payments as $payment)
                                    <tr>
                                        <td>{{ number_format($payment->amount, 2) }}</td>
                                        <td>{{ ucfirst(str_replace('_', ' ', $payment->payment_method)) }}</td>
                                        <td>{{ ucfirst(str_replace('_', ' ', $payment->payment_type)) }}</td>
                                        <td>
                                            <span class="badge bg-{{ $payment->payment_status == 'completed' ? 'success' : ($payment->payment_status == 'pending' ? 'warning' : 'danger') }}">
                                                {{ ucfirst($payment->payment_status) }}
                                            </span>
                                        </td>
                                        <td>{{ $payment->created_at->format('d M Y') }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @else
                        <p>No payments found.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection