// resources/views/backend/invoices/show.blade.php

// Actions section এর জায়গায় নিচের কোড যোগ করুন
<div class="row mt-4">
    <div class="col-12">
        <div class="actions">
            <h4>Actions</h4>
            <div class="btn-group">
                @if($invoice->status == 'draft')
                    <form action="{{ route('invoices.send', $invoice->id) }}" method="POST" style="display: inline;">
                        @csrf
                        <button type="submit" class="btn btn-primary" onclick="return confirm('Send this invoice?')">
                            <i class="fas fa-paper-plane"></i> Send Invoice
                        </button>
                    </form>
                @endif
                
                @if($invoice->status == 'sent' && !$invoice->is_fully_paid)
                    <form action="{{ route('invoices.mark-as-paid', $invoice->id) }}" method="POST" style="display: inline;">
                        @csrf
                        <button type="submit" class="btn btn-success" onclick="return confirm('Mark this invoice as paid?')">
                            <i class="fas fa-check"></i> Mark as Paid
                        </button>
                    </form>
                @endif
                
                @if($invoice->status == 'sent' && $invoice->is_overdue)
                    <form action="{{ route('invoices.mark-as-overdue', $invoice->id) }}" method="POST" style="display: inline;">
                        @csrf
                        <button type="submit" class="btn btn-danger" onclick="return confirm('Mark this invoice as overdue?')">
                            <i class="fas fa-exclamation-triangle"></i> Mark as Overdue
                        </button>
                    </form>
                @endif
                
                @if(!in_array($invoice->status, ['cancelled', 'voided']))
                    <form action="{{ route('invoices.cancel', $invoice->id) }}" method="POST" style="display: inline;">
                        @csrf
                        <button type="submit" class="btn btn-danger" onclick="return confirm('Cancel this invoice?')">
                            <i class="fas fa-times"></i> Cancel Invoice
                        </button>
                    </form>
                @endif
                
                <a href="{{ route('invoices.generate-pdf', $invoice->id) }}" class="btn btn-info">
                    <i class="fas fa-file-pdf"></i> Generate PDF
                </a>
                
                @if($invoice->pdf_path)
                    <a href="{{ route('invoices.download-pdf', $invoice->id) }}" class="btn btn-secondary">
                        <i class="fas fa-download"></i> Download PDF
                    </a>
                    
                    <form action="{{ route('invoices.send-email', $invoice->id) }}" method="POST" style="display: inline;">
                        @csrf
                        <button type="submit" class="btn btn-primary" onclick="return confirm('Send invoice via email?')">
                            <i class="fas fa-envelope"></i> Send Email
                        </button>
                    </form>
                @endif
            </div>
        </div>
    </div>
</div>