<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CheckOut extends Model
{
    use HasFactory;

    protected $fillable = [
        'booking_id',
        'checked_by',
        'final_bill',
        'payment_status',
        'notes',
        'actual_check_out',
    ];

    protected $casts = [
        'final_bill' => 'decimal:2',
        'actual_check_out' => 'datetime',
    ];

    public function booking()
    {
        return $this->belongsTo(Booking::class);
    }

    public function checkedBy()
    {
        return $this->belongsTo(User::class, 'checked_by');
    }
}