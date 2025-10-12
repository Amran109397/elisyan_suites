<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class RoleMiddleware
{
    public function handle(Request $request, Closure $next, $role)
    {
        if (!auth()->check()) {
            return redirect()->route('login');
        }

        $user = auth()->user();
        

        if (str_contains($role, ',')) {
            $roles = explode(',', $role);
            if (!$user->hasAnyRole($roles)) {
                abort(403, 'Unauthorized action.');
            }
        } else {

            if (!$user->hasRole($role)) {
                abort(403, 'Unauthorized action.');
            }
        }

        return $next($request);
    }
}