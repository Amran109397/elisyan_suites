<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class RoomType extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'property_id',
        'name',
        'description',
        'base_price',
        'max_occupancy',
        'size_sqm',
        'bed_type',
        'is_active',
    ];

    protected $casts = [
        'base_price' => 'decimal:2',
        'size_sqm' => 'decimal:2',
        'is_active' => 'boolean',
    ];

    public function property()
    {
        return $this->belongsTo(Property::class);
    }

    public function rooms()
    {
        return $this->hasMany(Room::class);
    }

    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }

    public function amenities()
    {
        return $this->belongsToMany(Amenity::class, 'room_amenities')
            ->withTimestamps();
    }

    public function images()
    {
        return $this->hasMany(RoomImage::class);
    }

    public function prices()
    {
        return $this->hasMany(Price::class);
    }
}