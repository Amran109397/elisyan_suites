<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    use HasFactory;

    protected $fillable = [
        'guest_id',
        'treatment_id',
        'therapist_id',
        'appointment_date',
        'appointment_time',
        'status',
        'notes',
    ];

    protected $casts = [
        'appointment_date' => 'date',
        'appointment_time' => 'datetime',
    ];

    public function guest()
    {
        return $this->belongsTo(Guest::class);
    }

    public function treatment()
    {
        return $this->belongsTo(Treatment::class);
    }

    public function therapist()
    {
        return $this->belongsTo(Therapist::class);
    }
}