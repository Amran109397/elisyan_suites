<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HousekeepingStaff extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'phone',
        'email',
        'position',
        'shift',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function housekeepingTasks()
    {
        return $this->hasMany(HousekeepingTask::class);
    }
}