// app/Models/Guest.php
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Guest extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'user_id',
        'first_name',
        'last_name',
        'email',
        'phone',
        'date_of_birth',
        'id_type',
        'id_number',
        'id_image_path',
        'nationality',
        'address',
        'vip_status',
    ];

    protected $casts = [
        'date_of_birth' => 'date',
        'vip_status' => 'boolean',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }

    public function preferences()
    {
        return $this->hasMany(GuestPreference::class);
    }

    public function loyaltyMember()
    {
        return $this->hasOne(LoyaltyMember::class);
    }

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }

    public function feedback()
    {
        return $this->hasMany(Feedback::class);
    }

    public function appointments()
    {
        return $this->hasMany(Appointment::class);
    }

    public function accountsReceivable()
    {
        return $this->hasMany(AccountsReceivable::class);
    }

    // Accessor for full name
    public function getFullNameAttribute()
    {
        return $this->first_name . ' ' . $this->last_name;
    }
}