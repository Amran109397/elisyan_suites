<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Invoice extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'booking_id',
        'invoice_number',
        'issue_date',
        'due_date',
        'amount',
        'tax_amount',
        'status',
        'pdf_path',
    ];

    protected $casts = [
        'issue_date' => 'date',
        'due_date' => 'date',
        'amount' => 'decimal:2',
        'tax_amount' => 'decimal:2',
    ];

    public function booking()
    {
        return $this->belongsTo(Booking::class);
    }

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }

    // Generate invoice number
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($invoice) {
            if (empty($invoice->invoice_number)) {
                $invoice->invoice_number = 'INV' . date('Ym') . str_pad(random_int(1, 9999), 4, '0', STR_PAD_LEFT);
            }
        });
    }

    // Calculate total amount
    public function calculateTotalAmount()
    {
        $booking = $this->booking;
        $totalAmount = $booking->total_price;
        
        // Add any additional charges
        $addonsTotal = $booking->addons()->sum('price');
        $servicesTotal = $booking->services()->sum('price');
        
        $totalAmount += $addonsTotal + $servicesTotal;
        
        return $totalAmount;
    }

    // Calculate tax amount
    public function calculateTaxAmount()
    {
        $totalAmount = $this->calculateTotalAmount();
        $taxRate = 0.10; // 10% tax rate, can be made configurable
        
        return $totalAmount * $taxRate;
    }

    // Get paid amount
    public function getPaidAmountAttribute()
    {
        return $this->payments()
            ->where('payment_status', 'completed')
            ->sum('amount');
    }

    // Get remaining amount
    public function getRemainingAmountAttribute()
    {
        return $this->amount - $this->paid_amount;
    }

    // Check if invoice is fully paid
    public function getIsFullyPaidAttribute()
    {
        return $this->remaining_amount <= 0;
    }

    // Check if invoice is overdue
    public function getIsOverdueAttribute()
    {
        return $this->due_date < now() && !$this->is_fully_paid && in_array($this->status, ['sent', 'overdue']);
    }
}