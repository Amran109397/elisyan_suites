<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EventResource extends Model
{
    use HasFactory;

    protected $fillable = [
        'event_id',
        'resource_id',
        'quantity',
    ];

    public function event()
    {
        return $this->belongsTo(Event::class);
    }

    public function resource()
    {
        return $this->belongsTo(Resource::class);
    }
}