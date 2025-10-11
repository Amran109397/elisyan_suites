<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    use HasFactory;

    protected $fillable = [
        'booking_id',
        'invoice_number',
        'issue_date',
        'due_date',
        'amount',
        'tax_amount',
        'status',
        'pdf_path',
        'created_by',
    ];

    protected $casts = [
        'issue_date' => 'date',
        'due_date' => 'date',
        'amount' => 'decimal:2',
        'tax_amount' => 'decimal:2',
    ];

    // ফরেন কী ছাড়া রিলেশন
    public function booking()
    {
        return $this->belongsTo(Booking::class, 'booking_id');
    }

    // ফরেন কী ছাড়া রিলেশন
    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }

    // Calculate total paid amount
    public function getTotalPaidAttribute()
    {
        return $this->payments()
            ->where('payment_status', 'completed')
            ->sum('amount');
    }

    // Calculate remaining amount
    public function getRemainingAmountAttribute()
    {
        return $this->amount - $this->total_paid;
    }

    // Check if invoice is fully paid
    public function getIsFullyPaidAttribute()
    {
        return $this->remaining_amount <= 0;
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
}