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
        'role_id',
        'profile_image',
        'can_access_pos',
        'pos_outlet_ids',
        'last_login_at',
        'is_active',
        'created_by'
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
        'can_access_pos' => 'boolean',
        'is_active' => 'boolean',
        'pos_outlet_ids' => 'array',
        'last_login_at' => 'datetime'
    ];

    // Role relationship
    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    // Check specific role
    public function hasRole($roleName)
    {
        if (!$this->role) {
            return false;
        }
        
        return $this->role->name === $roleName;
    }

    // Check multiple roles
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

    // Check permission
    public function hasPermission($permission)
    {
        if (!$this->role) {
            return false;
        }
        
        $permissions = $this->role->permissions ?? [];
        return in_array($permission, $permissions) || in_array('full_access', $permissions);
    }

    // Properties relationship (for property managers)
    public function properties()
    {
        return $this->belongsToMany(Property::class, 'user_properties')
                    ->withPivot('is_primary')
                    ->withTimestamps();
    }
}