<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, Notifiable;

    protected $fillable = [
        'name',
        'email', 
        'password',
        'role_id'
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    // Add relationship to Role
    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    // Add hasRole method
    public function hasRole($roleName)
    {
        if (!$this->role) {
            return false;
        }
        
        return $this->role->name === $roleName;
    }

    // Additional helper method to check multiple roles
    public function hasAnyRole($roles)
    {
        if (!$this->role) {
            return false;
        }

        if (is_array($roles)) {
            return in_array($this->role->name, $roles);
        }

        return $this->role->name === $roles;
    }
    
}