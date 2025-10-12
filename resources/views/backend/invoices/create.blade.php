// resources/views/backend/invoices/create.blade.php
@extends('backend.layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Create Invoice</h3>
                    <div class="card-tools">
                        <a href="{{ route('invoices.index') }}" class="btn btn-default">
                            <i class="fas fa-arrow-left"></i> Back
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <form action="{{ route('invoices.store') }}" method="POST" id="invoiceForm">
                        @csrf
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="booking_id">Booking <span class="text-danger">*</span></label>
                                    <select class="form-select @error('booking_id') is-invalid @enderror" id="booking_id" name="booking_id" required>
                                        <option value="">Select Booking</option>
                                        @foreach($bookings as $booking)
                                            <option value="{{ $booking->id }}" {{ old('booking_id') == $booking->id ? 'selected' : '' }}>
                                                {{ $booking->booking_reference }} - {{ $booking->guest->full_name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('booking_id')
                                        <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="issue_date">Issue Date <span class="text-danger">*</span></label>
                                    <input type="date" class="form-control @error('issue_date') is-invalid @enderror" id="issue_date" name="issue_date" value="{{ old('issue_date', now()->format('Y-m-d')) }}" required>
                                    @error('issue_date')
                                        <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="due_date">Due Date <span class="text-danger">*</span></label>
                                    <input type="date" class="form-control @error('due_date') is-invalid @enderror" id="due_date" name="due_date" value="{{ old('due_date', now()->addDays(30)->format('Y-m-d')) }}" required>
                                    @error('due_date')
                                        <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="amount">Amount <span class="text-danger">*</span></label>
                                    <input type="number" class="form-control @error('amount') is-invalid @enderror" id="amount" name="amount" value="{{ old('amount') }}" step="0.01" min="0" required>
                                    @error('amount')
                                        <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="tax_amount">Tax Amount <span class="text-danger">*</span></label>
                                    <input type="number" class="form-control @error('tax_amount') is-invalid @enderror" id="tax_amount" name="tax_amount" value="{{ old('tax_amount', 0) }}" step="0.01" min="0" required>
                                    @error('tax_amount')
                                        <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="status">Status <span class="text-danger">*</span></label>
                                    <select class="form-select @error('status') is-invalid @enderror" id="status" name="status" required>
                                        <option value="draft" {{ old('status', 'draft') == 'draft' ? 'selected' : '' }}>Draft</option>
                                        <option value="sent" {{ old('status') == 'sent' ? 'selected' : '' }}>Sent</option>
                                        <option value="paid" {{ old('status') == 'paid' ? 'selected' : '' }}>Paid</option>
                                        <option value="overdue" {{ old('status') == 'overdue' ? 'selected' : '' }}>Overdue</option>
                                        <option value="cancelled" {{ old('status') == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                                        <option value="voided" {{ old('status') == 'voided' ? 'selected' : '' }}>Voided</option>
                                    </select>
                                    @error('status')
                                        <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="form-group mt-4">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save"></i> Create Invoice
                            </button>
                            <a href="{{ route('invoices.index') }}" class="btn btn-default">
                                <i class="fas fa-times"></i> Cancel
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
 $(document).ready(function() {
    // Auto-fill amount when booking is selected
    $('#booking_id').on('change', function() {
        const bookingId = $(this).val();
        if (bookingId) {
            $.ajax({
                url: `/api/bookings/${bookingId}/calculate-invoice-amount`,
                type: 'GET',
                success: function(response) {
                    $('#amount').val(response.amount);
                    $('#tax_amount').val(response.tax_amount);
                },
                error: function() {
                    $('#amount').val('');
                    $('#tax_amount').val('');
                }
            });
        }
    });
    
    // Form validation
    $('#invoiceForm').on('submit', function(e) {
        const issueDate = $('#issue_date').val();
        const dueDate = $('#due_date').val();
        
        if (issueDate && dueDate) {
            const issue = new Date(issueDate);
            const due = new Date(dueDate);
            
            if (due <= issue) {
                e.preventDefault();
                alert('Due date must be after issue date.');
                return false;
            }
        }
    });
    
    // Set minimum date for issue date to today
    const today = new Date().toISOString().split('T')[0];
    $('#issue_date').attr('min', today);
    $('#due_date').attr('min', today);
});
</script>
@endpush