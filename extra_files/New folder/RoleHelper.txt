<?php

if (!function_exists('hasRole')) {
    function hasRole($roles)
    {
        if (!auth()->check()) {
            return false;
        }
        
        $user = auth()->user();
        
        if (is_array($roles)) {
            return $user->hasAnyRole($roles);
        }
        
        return $user->hasRole($roles);
    }
}

if (!function_exists('hasPermission')) {
    function hasPermission($permission)
    {
        if (!auth()->check()) {
            return false;
        }
        
        return auth()->user()->hasPermission($permission);
    }
}

if (!function_exists('canAccessProperty')) {
    function canAccessProperty($propertyId)
    {
        if (!auth()->check()) {
            return false;
        }
        
        $user = auth()->user();
        
        // Super admin can access all properties
        if ($user->hasRole('super_admin')) {
            return true;
        }
        
        // Property manager can access their assigned properties
        if ($user->hasRole('property_manager')) {
            return $user->properties()->where('property_id', $propertyId)->exists();
        }
        
        return false;
    }
}