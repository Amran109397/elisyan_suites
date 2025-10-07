// app/Models/Booking.php
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Booking extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'property_id',
        'guest_id',
        'room_id',
        'room_type_id',
        'check_in_date',
        'check_out_date',
        'total_nights',
        'adults',
        'children',
        'infants',
        'special_requests',
        'status',
        'booking_source',
        'booking_reference',
        'total_price',
    ];

    protected $casts = [
        'check_in_date' => 'date',
        'check_out_date' => 'date',
        'total_price' => 'decimal:2',
    ];

    public function property()
    {
        return $this->belongsTo(Property::class);
    }

    public function guest()
    {
        return $this->belongsTo(Guest::class);
    }

    public function room()
    {
        return $this->belongsTo(Room::class);
    }

    public function roomType()
    {
        return $this->belongsTo(RoomType::class);
    }

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }

    public function addons()
    {
        return $this->hasMany(BookingAddon::class);
    }

    public function services()
    {
        return $this->hasMany(BookingService::class);
    }

    public function checkIn()
    {
        return $this->hasOne(CheckIn::class);
    }

    public function checkOut()
    {
        return $this->hasOne(CheckOut::class);
    }

    public function modifications()
    {
        return $this->hasMany(BookingModification::class);
    }

    public function roomAssignments()
    {
        return $this->hasMany(RoomAssignment::class);
    }

    public function roomServiceOrders()
    {
        return $this->hasMany(RoomServiceOrder::class);
    }

    public function accountsReceivable()
    {
        return $this->hasOne(AccountsReceivable::class);
    }

    public function invoices()
    {
        return $this->hasMany(Invoice::class);
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
        return $this->total_price - $this->total_paid;
    }

    // Check if booking is fully paid
    public function getIsFullyPaidAttribute()
    {
        return $this->remaining_amount <= 0;
    }

    // Generate booking reference
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($booking) {
            if (empty($booking->booking_reference)) {
                $booking->booking_reference = 'BKG' . date('Ym') . strtoupper(substr(md5(uniqid(rand(), true)), 0, 4));
            }
            
            if (empty($booking->total_nights)) {
                $checkIn = new \DateTime($booking->check_in_date);
                $checkOut = new \DateTime($booking->check_out_date);
                $interval = $checkIn->diff($checkOut);
                $booking->total_nights = $interval->days;
            }
        });
    }

    // app/Models/Booking.php
public function calculateTotalPrice()
{
    $roomType = $this->roomType;
    $nights = $this->total_nights;
    
    // মৌলিক মূল্য হিসাব
    $basePrice = $roomType->base_price * $nights;
    
    // এখানে অতিরিক্ত চার্জ, ডিসকাউন্ট ইত্যাদি যোগ করা যেতে পারে
    
    return $basePrice;
}
}