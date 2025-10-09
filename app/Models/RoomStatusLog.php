<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RoomStatusLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'room_id',
        'status',
        'changed_by',
        'notes',
    ];

    public function room()
    {
        return $this->belongsTo(Room::class);
    }

    public function changedBy()
    {
        return $this->belongsTo(User::class, 'changed_by');
    }
}