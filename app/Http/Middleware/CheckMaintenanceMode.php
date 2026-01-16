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
        // Bypass cache for maintenance mode so changes are instant
        $maintenanceMode = \App\Models\Setting::where('key', 'maintenance_mode')->value('value') ?? 'false';
        
        $trimmed = trim($maintenanceMode);
        $isMaintenance = filter_var($trimmed, FILTER_VALIDATE_BOOLEAN);

        \Illuminate\Support\Facades\Log::info('Maintenance Check V2', [
            'original' => $maintenanceMode,
            'trimmed' => $trimmed,
            'is_maintenance_bool' => $isMaintenance,
            'user_id' => auth()->id(),
            'is_admin' => auth()->check() ? auth()->user()->is_admin : 'guest'
        ]);

        // Check if maintenance mode is enabled
        if ($isMaintenance) {
            \Illuminate\Support\Facades\Log::info('Entering Maintenance Block');

            // Allow admins through
            if (auth()->check() && auth()->user()->is_admin) {
                \Illuminate\Support\Facades\Log::info('Bypassing: Admin User');
                return $next($request);
            }

            // Allow login/logout routes
            if ($request->routeIs('login', 'logout', 'admin.*')) {
                \Illuminate\Support\Facades\Log::info('Bypassing: Auth Route');
                return $next($request);
            }

            // Show maintenance page
            \Illuminate\Support\Facades\Log::info('BLOCKING REQUEST: Showing 503');
            return response()->view('maintenance', [], 503);
        }

        return $next($request);
    }
}
