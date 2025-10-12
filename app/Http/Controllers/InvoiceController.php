<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use App\Models\Booking;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;
use App\Mail\InvoiceEmail;
use PDF;

class InvoiceController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('role:super_admin,property_manager,receptionist');
    }

    public function index()
    {
        $invoices = Invoice::with('booking', 'booking.guest', 'booking.property')
                    ->orderBy('created_at', 'desc')
                    ->paginate(10);
        
        return view('backend.invoices.index', compact('invoices'));
    }

    public function create()
    {
        $bookings = Booking::whereDoesntHave('invoices')
                    ->orWhereHas('invoices', function ($query) {
                        $query->where('status', 'cancelled');
                    })
                    ->with('guest', 'property')
                    ->get();
        
        return view('backend.invoices.create', compact('bookings'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'booking_id' => 'required|exists:bookings,id',
            'issue_date' => 'required|date',
            'due_date' => 'required|date|after:issue_date',
            'amount' => 'required|numeric|min:0',
            'tax_amount' => 'required|numeric|min:0',
        ]);

        // Generate invoice number
        $validated['invoice_number'] = 'INV' . date('Ym') . str_pad(random_int(1, 9999), 4, '0', STR_PAD_LEFT);
        $validated['status'] = 'draft';

        Invoice::create($validated);

        return redirect()->route('invoices.index')
            ->with('success', 'Invoice created successfully.');
    }

    public function show($id)
    {
        $invoice = Invoice::with(['booking', 'booking.guest', 'booking.property', 'payments'])->find($id);
        
        if (!$invoice) {
            abort(404, 'Invoice not found');
        }
        
        return view('backend.invoices.show', compact('invoice'));
    }

    public function edit(Invoice $invoice)
    {
        $bookings = Booking::with('guest', 'property')->get();
        return view('backend.invoices.edit', compact('invoice', 'bookings'));
    }

    public function update(Request $request, Invoice $invoice)
    {
        $validated = $request->validate([
            'booking_id' => 'required|exists:bookings,id',
            'issue_date' => 'required|date',
            'due_date' => 'required|date|after:issue_date',
            'amount' => 'required|numeric|min:0',
            'tax_amount' => 'required|numeric|min:0',
            'status' => 'required|in:draft,sent,paid,overdue,cancelled,voided',
        ]);

        $invoice->update($validated);

        return redirect()->route('invoices.index')
            ->with('success', 'Invoice updated successfully.');
    }

    public function destroy(Invoice $invoice)
    {
        $invoice->delete();
        return redirect()->route('invoices.index')
            ->with('success', 'Invoice deleted successfully.');
    }

    // New Methods Added Below

    /**
     * Send invoice (mark as sent)
     */
    public function send(Invoice $invoice)
    {
        $invoice->update(['status' => 'sent']);
        
        return redirect()->route('invoices.show', $invoice->id)
            ->with('success', 'Invoice sent successfully.');
    }

    /**
     * Mark invoice as paid
     */
    public function markAsPaid(Invoice $invoice)
    {
        $invoice->update(['status' => 'paid']);
        
        return redirect()->route('invoices.show', $invoice->id)
            ->with('success', 'Invoice marked as paid successfully.');
    }

    /**
     * Mark invoice as overdue
     */
    public function markAsOverdue(Invoice $invoice)
    {
        $invoice->update(['status' => 'overdue']);
        
        return redirect()->route('invoices.show', $invoice->id)
            ->with('success', 'Invoice marked as overdue successfully.');
    }

    /**
     * Cancel invoice
     */
    public function cancel(Invoice $invoice)
    {
        $invoice->update(['status' => 'cancelled']);
        
        return redirect()->route('invoices.show', $invoice->id)
            ->with('success', 'Invoice cancelled successfully.');
    }

    /**
     * Generate and download PDF
     */
    public function generatePdf(Invoice $invoice)
    {
        $data = [
            'invoice' => $invoice,
            'booking' => $invoice->booking,
            'guest' => $invoice->booking->guest,
            'property' => $invoice->booking->property,
        ];
        
        $pdf = PDF::loadView('backend.invoices.pdf', $data);
        
        // Save PDF to storage
        $filename = 'invoices/invoice_' . $invoice->invoice_number . '.pdf';
        $path = public_path($filename);
        $pdf->save($path);
        
        // Update invoice with PDF path
        $invoice->pdf_path = $filename;
        $invoice->save();
        
        // Download the PDF
        return $pdf->download('invoice_' . $invoice->invoice_number . '.pdf');
    }

    /**
     * Send invoice via email
     */
    public function sendEmail(Invoice $invoice)
    {
        try {
            // Generate PDF if not already generated
            if (!$invoice->pdf_path) {
                $data = [
                    'invoice' => $invoice,
                    'booking' => $invoice->booking,
                    'guest' => $invoice->booking->guest,
                    'property' => $invoice->booking->property,
                ];
                
                $pdf = PDF::loadView('backend.invoices.pdf', $data);
                $filename = 'invoices/invoice_' . $invoice->invoice_number . '.pdf';
                $path = public_path($filename);
                $pdf->save($path);
                
                $invoice->pdf_path = $filename;
                $invoice->save();
            }
            
            // Send email
            Mail::to($invoice->booking->guest->email)->send(new InvoiceEmail($invoice));
            
            // Update invoice status
            $invoice->status = 'sent';
            $invoice->save();
            
            return redirect()->route('invoices.show', $invoice->id)
                ->with('success', 'Invoice sent successfully via email.');
                
        } catch (\Exception $e) {
            return redirect()->route('invoices.show', $invoice->id)
                ->with('error', 'Failed to send invoice: ' . $e->getMessage());
        }
    }

    /**
     * Download generated PDF
     */
    public function downloadPdf(Invoice $invoice)
    {
        if (!$invoice->pdf_path) {
            return redirect()->route('invoices.show', $invoice->id)
                ->with('error', 'PDF not generated yet. Please generate PDF first.');
        }
        
        $path = public_path($invoice->pdf_path);
        
        if (!file_exists($path)) {
            return redirect()->route('invoices.show', $invoice->id)
                ->with('error', 'PDF file not found.');
        }
        
        return response()->download($path, 'invoice_' . $invoice->invoice_number . '.pdf');
    }

    /**
     * Preview invoice PDF in browser
     */
    public function previewPdf(Invoice $invoice)
    {
        if (!$invoice->pdf_path) {
            return redirect()->route('invoices.show', $invoice->id)
                ->with('error', 'PDF not generated yet. Please generate PDF first.');
        }
        
        $path = public_path($invoice->pdf_path);
        
        if (!file_exists($path)) {
            return redirect()->route('invoices.show', $invoice->id)
                ->with('error', 'PDF file not found.');
        }
        
        return response()->file($path);
    }

    /**
     * Bulk action for multiple invoices
     */
    public function bulkAction(Request $request)
    {
        $validated = $request->validate([
            'invoice_ids' => 'required|array',
            'invoice_ids.*' => 'exists:invoices,id',
            'action' => 'required|in:send,mark-as-paid,mark-as-overdue,cancel,delete'
        ]);

        $invoices = Invoice::whereIn('id', $validated['invoice_ids'])->get();
        
        switch ($validated['action']) {
            case 'send':
                $invoices->each->update(['status' => 'sent']);
                $message = 'Selected invoices marked as sent.';
                break;
            case 'mark-as-paid':
                $invoices->each->update(['status' => 'paid']);
                $message = 'Selected invoices marked as paid.';
                break;
            case 'mark-as-overdue':
                $invoices->each->update(['status' => 'overdue']);
                $message = 'Selected invoices marked as overdue.';
                break;
            case 'cancel':
                $invoices->each->update(['status' => 'cancelled']);
                $message = 'Selected invoices cancelled.';
                break;
            case 'delete':
                $invoices->each->delete();
                $message = 'Selected invoices deleted.';
                break;
        }

        return redirect()->route('invoices.index')
            ->with('success', $message);
    }

    /**
     * Auto-generate invoice from booking
     */
    public function generateFromBooking(Booking $booking)
    {
        // Check if invoice already exists
        if ($booking->invoices()->where('status', '!=', 'cancelled')->exists()) {
            return redirect()->route('bookings.show', $booking->id)
                ->with('error', 'Invoice already exists for this booking.');
        }

        // Calculate amounts
        $totalAmount = $booking->calculateTotalAmount();
        $taxAmount = $booking->calculateTaxAmount();

        // Create invoice
        $invoice = Invoice::create([
            'booking_id' => $booking->id,
            'invoice_number' => 'INV' . date('Ym') . str_pad(random_int(1, 9999), 4, '0', STR_PAD_LEFT),
            'issue_date' => now()->format('Y-m-d'),
            'due_date' => now()->addDays(30)->format('Y-m-d'),
            'amount' => $totalAmount,
            'tax_amount' => $taxAmount,
            'status' => 'draft'
        ]);

        return redirect()->route('invoices.show', $invoice->id)
            ->with('success', 'Invoice generated successfully from booking.');
    }

    /**
     * Get invoice statistics
     */
    public function statistics()
    {
        $stats = [
            'total_invoices' => Invoice::count(),
            'total_amount' => Invoice::sum('amount'),
            'paid_amount' => Invoice::where('status', 'paid')->sum('amount'),
            'overdue_amount' => Invoice::where('status', 'overdue')->sum('amount'),
            'pending_amount' => Invoice::whereIn('status', ['draft', 'sent'])->sum('amount'),
            'draft_count' => Invoice::where('status', 'draft')->count(),
            'sent_count' => Invoice::where('status', 'sent')->count(),
            'paid_count' => Invoice::where('status', 'paid')->count(),
            'overdue_count' => Invoice::where('status', 'overdue')->count(),
            'cancelled_count' => Invoice::where('status', 'cancelled')->count(),
        ];

        // Monthly revenue
        $monthlyRevenue = Invoice::where('status', 'paid')
            ->selectRaw('MONTH(created_at) as month, SUM(amount) as total')
            ->groupBy('month')
            ->pluck('total', 'month')
            ->toArray();

        // Property-wise revenue
        $propertyRevenue = Invoice::join('bookings', 'invoices.booking_id', '=', 'bookings.id')
            ->join('properties', 'bookings.property_id', '=', 'properties.id')
            ->where('invoices.status', 'paid')
            ->selectRaw('properties.name, SUM(invoices.amount) as total')
            ->groupBy('properties.name')
            ->pluck('total', 'name')
            ->toArray();

        return view('backend.invoices.statistics', compact('stats', 'monthlyRevenue', 'propertyRevenue'));
    }

    /**
     * Check for overdue invoices and update status
     */
    public function checkOverdue()
    {
        $overdueInvoices = Invoice::where('status', 'sent')
            ->where('due_date', '<', now())
            ->get();

        foreach ($overdueInvoices as $invoice) {
            $invoice->status = 'overdue';
            $invoice->save();
        }

        return redirect()->route('invoices.index')
            ->with('success', $overdueInvoices->count() . ' invoices marked as overdue.');
    }

    /**
     * Export invoices to CSV
     */
    public function exportCsv(Request $request)
    {
        $fileName = 'invoices_' . date('Y-m-d') . '.csv';
        
        $invoices = Invoice::with(['booking.guest', 'booking.property'])
            ->when($request->status, function ($query, $status) {
                return $query->where('status', $status);
            })
            ->when($request->date_from, function ($query, $dateFrom) {
                return $query->whereDate('created_at', '>=', $dateFrom);
            })
            ->when($request->date_to, function ($query, $dateTo) {
                return $query->whereDate('created_at', '<=', $dateTo);
            })
            ->get();

        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $fileName . '"',
        ];

        $callback = function() use ($invoices) {
            $file = fopen('php://output', 'w');
            
            // Header row
            fputcsv($file, [
                'Invoice Number',
                'Guest Name',
                'Property',
                'Issue Date',
                'Due Date',
                'Amount',
                'Tax Amount',
                'Status',
                'Created At'
            ]);

            // Data rows
            foreach ($invoices as $invoice) {
                fputcsv($file, [
                    $invoice->invoice_number,
                    $invoice->booking->guest->full_name,
                    $invoice->booking->property->name,
                    $invoice->issue_date,
                    $invoice->due_date,
                    $invoice->amount,
                    $invoice->tax_amount,
                    $invoice->status,
                    $invoice->created_at
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    /**
     * Print invoice (optimized for printing)
     */
    public function printInvoice(Invoice $invoice)
    {
        $data = [
            'invoice' => $invoice,
            'booking' => $invoice->booking,
            'guest' => $invoice->booking->guest,
            'property' => $invoice->booking->property,
        ];
        
        return view('backend.invoices.print', $data);
    }

    /**
     * Duplicate invoice
     */
    public function duplicate(Invoice $invoice)
    {
        $newInvoice = $invoice->replicate();
        $newInvoice->invoice_number = 'INV' . date('Ym') . str_pad(random_int(1, 9999), 4, '0', STR_PAD_LEFT);
        $newInvoice->status = 'draft';
        $newInvoice->pdf_path = null;
        $newInvoice->save();

        return redirect()->route('invoices.show', $newInvoice->id)
            ->with('success', 'Invoice duplicated successfully.');
    }

    /**
     * Void invoice (irreversible action)
     */
    public function void(Invoice $invoice)
    {
        if ($invoice->status === 'paid') {
            return redirect()->route('invoices.show', $invoice->id)
                ->with('error', 'Cannot void a paid invoice.');
        }

        $invoice->status = 'voided';
        $invoice->save();

        return redirect()->route('invoices.show', $invoice->id)
            ->with('success', 'Invoice voided successfully.');
    }
}