<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GuestPreference extends Model
{
    use HasFactory;

    protected $fillable = [
        'guest_id',
        'preference_type',
        'preference_value',
        'notes',
    ];

    public function guest()
    {
        return $this->belongsTo(Guest::class);
    }
}