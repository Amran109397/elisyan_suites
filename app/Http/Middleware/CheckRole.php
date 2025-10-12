<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    public function handle(Request $request, Closure $next, ...$roles)
    {
        if (!auth()->check()) {
            return redirect('/login');
        }

        $user = auth()->user();
        
        // Debug info
        \Log::info('Role Check', [
            'user' => $user->name,
            'user_role' => $user->role ? $user->role->name : 'No role',
            'required_roles' => $roles
        ]);

        // Super admin সব access পাবে
        if ($user->role && $user->role->name === 'super_admin') {
            return $next($request);
        }

        // User এর role নেই
        if (!$user->role) {
            abort(403, 'You do not have a role assigned. Please contact administrator.');
        }

        // Check if user has any of the required roles
        foreach ($roles as $role) {
            // Handle comma separated roles like: role:super_admin,property_manager
            $roleNames = explode(',', $role);
            foreach ($roleNames as $roleName) {
                if (trim($roleName) === $user->role->name) {
                    return $next($request);
                }
            }
        }

        abort(403, 'Unauthorized action. Your role: ' . $user->role->name . ' | Required: ' . implode(', ', $roles));
    }
}