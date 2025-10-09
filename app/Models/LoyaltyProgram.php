<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LoyaltyProgram extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'points_per_currency',
        'redemption_rate',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function loyaltyMembers()
    {
        return $this->hasMany(LoyaltyMember::class);
    }

    public function loyaltyPoints()
    {
        return $this->hasMany(LoyaltyPoint::class);
    }
}