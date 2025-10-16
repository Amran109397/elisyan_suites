<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Room extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'property_id',
        'room_type_id', 
        'floor_id',
        'room_number',
        'status',
        'is_smoking',
    ];

    protected $casts = [
        'is_smoking' => 'boolean',
    ];

    // Relationships
    public function property()
    {
        return $this->belongsTo(Property::class);
    }

    public function roomType()
    {
        return $this->belongsTo(RoomType::class);
    }

    public function floor()
    {
        return $this->belongsTo(Floor::class);
    }

    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }

    public function currentBooking()
    {
        return $this->hasOne(Booking::class)
            ->where('status', 'checked_in')
            ->whereDate('check_in_date', '<=', now())
            ->whereDate('check_out_date', '>=', now());
    }

    public function roomImages()
    {
        return $this->hasMany(RoomImage::class);
    }

    // Scopes
    public function scopeAvailable($query)
    {
        return $query->where('status', 'available');
    }

    public function scopeOccupied($query)
    {
        return $query->where('status', 'occupied');
    }

    public function scopeMaintenance($query)
    {
        return $query->where('status', 'maintenance');
    }

    // Helper methods
    public function isAvailable()
    {
        return $this->status === 'available';
    }

    public function isOccupied()
    {
        return $this->status === 'occupied';
    }

    public function getStatusBadgeClass()
    {
        $classes = [
            'available' => 'badge bg-success',
            'occupied' => 'badge bg-primary', 
            'maintenance' => 'badge bg-warning',
            'cleaning' => 'badge bg-info',
            'out_of_service' => 'badge bg-danger',
            'blocked' => 'badge bg-dark',
            'renovation' => 'badge bg-secondary',
        ];

        return $classes[$this->status] ?? 'badge bg-secondary';
    }
}