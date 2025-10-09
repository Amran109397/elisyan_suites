<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Resource extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'type',
        'capacity',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function eventResources()
    {
        return $this->hasMany(EventResource::class);
    }
}