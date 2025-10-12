<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MaintenanceIssue extends Model
{
    use HasFactory;

    protected $fillable = [
        'room_id',
        'reported_by',
        'assigned_to',
        'issue_type',
        'description',
        'status',
        'priority',
        'scheduled_date',
        'completed_date',
    ];

    protected $casts = [
        'scheduled_date' => 'date',
        'completed_date' => 'date',
    ];

    public function room()
    {
        return $this->belongsTo(Room::class);
    }

    public function reportedBy()
    {
        return $this->belongsTo(User::class, 'reported_by');
    }

    public function assignedTo()
    {
        return $this->belongsTo(User::class, 'assigned_to');
    }
}