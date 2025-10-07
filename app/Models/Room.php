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

    public function housekeepingTasks()
    {
        return $this->hasMany(HousekeepingTask::class);
    }

    public function maintenanceIssues()
    {
        return $this->hasMany(MaintenanceIssue::class);
    }

    public function statusLogs()
    {
        return $this->hasMany(RoomStatusLog::class);
    }

    // Scope for available rooms
    public function scopeAvailable($query)
    {
        return $query->where('status', 'available');
    }

    // Scope for rooms available between dates
    // app/Models/Room.php
public function scopeAvailableBetween($query, $startDate, $endDate)
{
    return $query->where('status', 'available')
        ->whereNotIn('id', function ($q) use ($startDate, $endDate) {
            $q->select('room_id')
                ->from('bookings')
                ->where('status', '!=', 'cancelled')
                ->where(function ($query) use ($startDate, $endDate) {
                    $query->whereBetween('check_in_date', [$startDate, $endDate])
                        ->orWhereBetween('check_out_date', [$startDate, $endDate])
                        ->orWhere(function ($q) use ($startDate, $endDate) {
                            $q->where('check_in_date', '<=', $startDate)
                                ->where('check_out_date', '>=', $endDate);
                        });
                });
        });
}
}