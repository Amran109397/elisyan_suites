<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BookingModification extends Model
{
    use HasFactory;

    protected $fillable = [
        'booking_id',
        'modified_by',
        'modification_type',
        'old_value',
        'new_value',
        'notes',
    ];

    public function booking()
    {
        return $this->belongsTo(Booking::class);
    }

    public function modifiedBy()
    {
        return $this->belongsTo(User::class, 'modified_by');
    }
}