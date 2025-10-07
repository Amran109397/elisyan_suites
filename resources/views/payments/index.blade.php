@extends('backend.layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Payments</h3>
                    <div class="card-tools">
                        <a href="{{ route('payments.create') }}" class="btn btn-primary">
                            <i class="fas fa-plus"></i> Add Payment
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Booking</th>
                                <th>Guest</th>
                                <th>Amount</th>
                                <th>Method</th>
                                <th>Type</th>
                                <th>Status</th>
                                <th>Date</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($payments as $payment)
                            <tr>
                                <td>{{ $payment->id }}</td>
                                <td>{{ $payment->booking->booking_reference }}</td>
                                <td>{{ $payment->guest->full_name }}</td>
                                <td>{{ number_format($payment->amount, 2) }}</td>
                                <td>{{ ucfirst(str_replace('_', ' ', $payment->payment_method)) }}</td>
                                <td>{{ ucfirst(str_replace('_', ' ', $payment->payment_type)) }}</td>
                                <td>
                                    <span class="badge bg-{{ $payment->payment_status == 'completed' ? 'success' : ($payment->payment_status == 'pending' ? 'warning' : 'danger') }}">
                                        {{ ucfirst($payment->payment_status) }}
                                    </span>
                                </td>
                                <td>{{ $payment->created_at->format('d M Y') }}</td>
                                <td>
                                    <a href="{{ route('payments.show', $payment->id) }}" class="btn btn-sm btn-info">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('payments.edit', $payment->id) }}" class="btn btn-sm btn-warning">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('payments.destroy', $payment->id) }}" method="POST" style="display: inline;">
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