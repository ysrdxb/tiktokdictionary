<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Models\Setting;

class CheckMaintenanceMode
{
    /**
     * Handle an incoming request.
     * Block access if maintenance mode is enabled (except for admins).
     */
    public function handle(Request $request, Closure $next): Response
    {
        $maintenanceMode = Setting::get('maintenance_mode', 'false');

        // Check if maintenance mode is enabled
        if ($maintenanceMode === 'true' || $maintenanceMode === true) {
            // Allow admins through
            if (auth()->check() && auth()->user()->is_admin) {
                return $next($request);
            }

            // Allow login/logout routes
            if ($request->routeIs('login', 'logout', 'admin.*')) {
                return $next($request);
            }

            // Show maintenance page
            return response()->view('maintenance', [], 503);
        }

        return $next($request);
    }
}
