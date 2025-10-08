<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WaitingList extends Model
{
    use HasFactory;

    protected $fillable = [
        'property_id',
        'guest_id',
        'room_type_id',
        'check_in_date',
        'check_out_date',
        'adults',
        'children',
        'status',
        'priority',
    ];

    protected $casts = [
        'check_in_date' => 'date',
        'check_out_date' => 'date',
    ];

    public function property()
    {
        return $this->belongsTo(Property::class);
    }

    public function guest()
    {
        return $this->belongsTo(Guest::class);
    }

    public function roomType()
    {
        return $this->belongsTo(RoomType::class);
    }
}