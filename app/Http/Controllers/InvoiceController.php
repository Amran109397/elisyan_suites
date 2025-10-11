<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use App\Models\Booking;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class InvoiceController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('role:super_admin,property_manager,receptionist');
    }

    public function index()
    {
        $invoices = Invoice::with('booking', 'booking.guest')->get();
        return view('backend.invoices.index', compact('invoices'));
    }

    public function create()
    {
        $bookings = Booking::whereDoesntHave('invoices')->get();
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

        $invoice = Invoice::create([
            'booking_id' => $validated['booking_id'],
            'issue_date' => $validated['issue_date'],
            'due_date' => $validated['due_date'],
            'amount' => $validated['amount'],
            'tax_amount' => $validated['tax_amount'],
            'status' => 'draft',
            'created_by' => auth()->id(),
        ]);

        return redirect()->route('invoices.show', $invoice->id)
            ->with('success', 'Invoice created successfully.');
    }

    public function show(Invoice $invoice)
    {
        $invoice->load('booking', 'booking.guest', 'booking.property', 'payments');
        return view('backend.invoices.show', compact('invoice'));
    }

    public function edit(Invoice $invoice)
    {
        return view('backend.invoices.edit', compact('invoice'));
    }

    public function update(Request $request, Invoice $invoice)
    {
        $validated = $request->validate([
            'issue_date' => 'required|date',
            'due_date' => 'required|date|after:issue_date',
            'amount' => 'required|numeric|min:0',
            'tax_amount' => 'required|numeric|min:0',
            'status' => 'required|in:draft,sent,paid,overdue,cancelled,voided',
        ]);

        $invoice->update($validated);

        return redirect()->route('invoices.show', $invoice->id)
            ->with('success', 'Invoice updated successfully.');
    }

    public function destroy(Invoice $invoice)
    {
        $invoice->delete();
        return redirect()->route('invoices.index')
            ->with('success', 'Invoice deleted successfully.');
    }

    public function generatePdf(Invoice $invoice)
    {
        $invoice->load('booking', 'booking.guest', 'booking.property');
        
        $pdf = Pdf::loadView('backend.invoices.pdf', compact('invoice'));
        
        // Save PDF to storage
        $path = 'invoices/' . $invoice->invoice_number . '.pdf';
        $pdf->save(public_path($path));
        
        // Update invoice with PDF path
        $invoice->update(['pdf_path' => $path]);
        
        // Download PDF
        return $pdf->download($invoice->invoice_number . '.pdf');
    }

    public function sendInvoice(Invoice $invoice)
    {
        // Here you would implement email sending logic
        // For now, just mark as sent
        $invoice->update(['status' => 'sent']);
        
        return redirect()->route('invoices.show', $invoice->id)
            ->with('success', 'Invoice sent successfully.');
    }
}