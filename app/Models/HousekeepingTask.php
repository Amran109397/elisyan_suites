<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HousekeepingTask extends Model
{
    use HasFactory;

    protected $fillable = [
        'room_id',
        'housekeeping_staff_id',
        'task_type',
        'description',
        'status',
        'priority',
        'scheduled_date',
        'completed_date',
        'notes',
    ];

    protected $casts = [
        'scheduled_date' => 'date',
        'completed_date' => 'date',
    ];

    public function room()
    {
        return $this->belongsTo(Room::class);
    }

    public function housekeepingStaff()
    {
        return $this->belongsTo(HousekeepingStaff::class);
    }
}