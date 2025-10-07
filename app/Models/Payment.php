// app/Models/Payment.php
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Payment extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'booking_id',
        'guest_id',
        'payment_gateway_id',
        'amount',
        'payment_method',
        'payment_type',
        'payment_status',
        'transaction_id',
        'remarks',
        'paid_at',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'paid_at' => 'datetime',
    ];

    public function booking()
    {
        return $this->belongsTo(Booking::class);
    }

    public function guest()
    {
        return $this->belongsTo(Guest::class);
    }

    public function paymentGateway()
    {
        return $this->belongsTo(PaymentGateway::class);
    }

    // Mark payment as completed
    public function markAsCompleted()
    {
        $this->payment_status = 'completed';
        $this->paid_at = now();
        $this->save();
    }

    // Mark payment as failed
    public function markAsFailed()
    {
        $this->payment_status = 'failed';
        $this->save();
    }

    // Mark payment as refunded
    public function markAsRefunded()
    {
        $this->payment_status = 'refunded';
        $this->save();
    }
}