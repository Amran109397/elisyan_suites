<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LoyaltyMember extends Model
{
    use HasFactory;

    protected $fillable = [
        'guest_id',
        'loyalty_program_id',
        'membership_number',
        'join_date',
        'status',
    ];

    protected $casts = [
        'join_date' => 'date',
    ];

    public function guest()
    {
        return $this->belongsTo(Guest::class);
    }

    public function loyaltyProgram()
    {
        return $this->belongsTo(LoyaltyProgram::class);
    }

    public function loyaltyPoints()
    {
        return $this->hasMany(LoyaltyPoint::class);
    }
}