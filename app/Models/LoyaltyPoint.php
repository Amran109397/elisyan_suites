<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LoyaltyPoint extends Model
{
    use HasFactory;

    protected $fillable = [
        'loyalty_member_id',
        'booking_id',
        'points',
        'type',
        'description',
        'expiry_date',
    ];

    protected $casts = [
        'expiry_date' => 'date',
    ];

    public function loyaltyMember()
    {
        return $this->belongsTo(LoyaltyMember::class);
    }

    public function booking()
    {
        return $this->belongsTo(Booking::class);
    }
}