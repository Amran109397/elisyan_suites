<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Property extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'description',
        'address',
        'city',
        'country',
        'phone',
        'email',
        'logo',
        'check_in_time',
        'check_out_time',
        'timezone',
        'currency_id',
        'is_active',
    ];
    

    protected $casts = [
        'check_in_time' => 'datetime:H:i:s',
        'check_out_time' => 'datetime:H:i:s',
        'is_active' => 'boolean',
    ];

    public function currency()
    {
        return $this->belongsTo(Currency::class);
    }

    public function roomTypes()
    {
        return $this->hasMany(RoomType::class);
    }

    public function rooms()
    {
        return $this->hasMany(Room::class);
    }

    public function floors()
    {
        return $this->hasMany(Floor::class);
    }

    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }

    public function users()
    {
        return $this->belongsToMany(User::class, 'user_properties')
            ->withPivot('is_primary')
            ->withTimestamps();
    }
}