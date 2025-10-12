<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\Invoice;

class InvoiceEmail extends Mailable
{
    use Queueable, SerializesModels;

    public $invoice;

    public function __construct(Invoice $invoice)
    {
        $this->invoice = $invoice;
    }

    public function build()
    {
        $subject = 'Invoice #' . $this->invoice->invoice_number . ' from ' . $this->invoice->booking->property->name;
        
        return $this->subject($subject)
                    ->view('emails.invoices.invoice')
                    ->attach(public_path($this->invoice->pdf_path), [
                        'as' => 'invoice_' . $this->invoice->invoice_number . '.pdf',
                        'mime' => 'application/pdf',
                    ]);
    }
}